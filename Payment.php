<?php
if($_GET["Stat"] != "Successfull")
{
if(isset($_COOKIE["Access"]) && isset($_GET["S"]))
{
  $conn = new mysqli("localhost", "username", "password", "my_aspid");
  if($mysqli->connect_error) {
  exit('Could not connect');
  }
  $Hash = $_COOKIE["Access"];
?>
<!DOCTYPE html>
<html>
<head>
<title>Ammazz</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="Payment.css">
</head>
<body>

<h2>Completamento ordine</h2>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="Card.php" method="POST" >
        <div class="row">
          <div class="col-50">
            <h3>Indirizzo di spedizione</h3>
            <label for="fname"><i class="fa fa-user"></i> Nome Completo</label>
            <input type="text" id="fname" name="firstname" placeholder="Ex: Mario Rossi">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" placeholder="Ex: abc@example.com">
            <label for="adr"><i class="fas fa-home"></i> Indirizzo</label>
            <input type="text" id="adr" name="address" placeholder="Ex: Via del Corso">
            <label for="city"><i class="fas fa-city"></i> Città</label>
            <input type="text" id="city" name="city" placeholder="Ex: Roma">

            <div class="row">
              <div class="col-50">
                <label for="state">Stato</label>
                <input type="text" id="state" name="state" placeholder="Ex: Italia">
              </div>
              <div class="col-50">
                <label for="zip">CAP</label>
                <input type="text" id="zip" name="zip" placeholder="Ex: 00100">
              </div>
            </div>
          </div>
          
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> L'indirizzo di spedizione e lo stesso di quello di fattura
        </label>
        <input type="hidden" id="tot" name="tot" value="">
        <input id="card" type="submit" value="Credit or Debit Card" class="btn">
        <!--- Attenzione: Google Pay funziona solo in HTTPS ---->
<div id="container"></div>
        <!--- ---->
      </form>
    </div>
  </div>
  <div class="col-25">
    <div class="container">
      <?php
      $sql = 'SELECT * FROM utenti JOIN Carello on utenti.Hash ="'.$Hash.'" AND utenti.Id = Carello.id_utente;';
      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        $row = $result->fetch_assoc();
        echo '<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>'.$row["numeroprodotti"].'</b></span></h4>';
        $prod = $row["id_prodotti"];
        $id = explode(",",$prod);
        $num =array_count_values($id);
        $tot = 0;
        foreach($id as &$value)
        {
          if($num[$value] != -1)
          {
            $sql='SELECT * FROM Prodotti WHERE Id_prodotto ='.$value;
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
              $row = $result->fetch_assoc();
              ?>
              <p id="<?php echo $row["Id_prodotto"];?>"><a href="C.php?Id=<?php echo $value ?>"><?php echo $row["Nome"];?></a> <span id="<?php echo $row["Id_prodotto"];?>.x"> X<?php echo $num[$row["Id_prodotto"]]; ?></span><span id="<?php echo $row["Id_prodotto"];?>.p" class="price"><?php if($row["Sconto"] == NULL){echo $row["Costo"] * $num[$row["Id_prodotto"]].'€'; $tot = $tot + $row["Costo"]* $num[$row["Id_prodotto"]];}else{echo '<s>'.$row["Costo"] * $num[$row["Id_prodotto"]].'€</s> '; echo $row["Sconto"] * $num[$row["Id_prodotto"]].'€'; $tot = $tot + $row["Sconto"] * $num[$row["Id_prodotto"]];}?></span></p>
              <?php
              $num[$value] = -1;
            }
          }
        }
        ?>
        <script>
          document.getElementById("tot").value = "<?php echo $tot; ?>";
          if(<?php echo $tot; ?> = 0)
          {
            document.querySelector('#card').disabled = true;
            document.querySelector('#container').disabled = true;
          }
        </script>
        <?php
      }
      else{
        //redirect utente nn esistente
      }
      unset($value);
      ?>
      <hr>
      <p>Totale <span class="price" style="color:black"><b id="totale"><?php echo $tot.'€'; ?></b></span></p>
    </div>
  </div>
</div>
<script>
/**
 * Define the version of the Google Pay API referenced when creating your
 * configuration
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|apiVersion in PaymentDataRequest}
 */
const baseRequest = {
  apiVersion: 2,
  apiVersionMinor: 0
};

/**
 * Card networks supported by your site and your gateway
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 * @todo confirm card networks supported by your site and gateway
 */
const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "MIR", "VISA"];

/**
 * Card authentication methods supported by your site and your gateway
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 * @todo confirm your processor supports Android device tokens for your
 * supported card networks
 */
const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

/**
 * Identify your gateway and your site's gateway merchant identifier
 *
 * The Google Pay API response will return an encrypted payment method capable
 * of being charged by a supported gateway after payer authorization
 *
 * @todo check with your gateway on the parameters to pass
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway|PaymentMethodTokenizationSpecification}
 */
const tokenizationSpecification = {
  type: 'PAYMENT_GATEWAY',
  parameters: {
    'gateway': 'example',
    'gatewayMerchantId': 'exampleGatewayMerchantId'
  }
};

/**
 * Describe your site's support for the CARD payment method and its required
 * fields
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 */
const baseCardPaymentMethod = {
  type: 'CARD',
  parameters: {
    allowedAuthMethods: allowedCardAuthMethods,
    allowedCardNetworks: allowedCardNetworks
  }
};

/**
 * Describe your site's support for the CARD payment method including optional
 * fields
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 */
const cardPaymentMethod = Object.assign(
  {},
  baseCardPaymentMethod,
  {
    tokenizationSpecification: tokenizationSpecification
  }
);

/**
 * An initialized google.payments.api.PaymentsClient object or null if not yet set
 *
 * @see {@link getGooglePaymentsClient}
 */
let paymentsClient = null;

/**
 * Configure your site's support for payment methods supported by the Google Pay
 * API.
 *
 * Each member of allowedPaymentMethods should contain only the required fields,
 * allowing reuse of this base request when determining a viewer's ability
 * to pay and later requesting a supported payment method
 *
 * @returns {object} Google Pay API version, payment methods supported by the site
 */
function getGoogleIsReadyToPayRequest() {
  return Object.assign(
      {},
      baseRequest,
      {
        allowedPaymentMethods: [baseCardPaymentMethod]
      }
  );
}

/**
 * Configure support for the Google Pay API
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
 * @returns {object} PaymentDataRequest fields
 */
function getGooglePaymentDataRequest() {
  const paymentDataRequest = Object.assign({}, baseRequest);
  paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
  paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
  paymentDataRequest.merchantInfo = {
    // @todo a merchant ID is available for a production environment after approval by Google
    // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
    // merchantId: '12345678901234567890',
    merchantName: 'Ammazz'
  };

  paymentDataRequest.callbackIntents = ["PAYMENT_AUTHORIZATION"];

  return paymentDataRequest;
}

/**
 * Return an active PaymentsClient or initialize
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
 * @returns {google.payments.api.PaymentsClient} Google Pay API client
 */
function getGooglePaymentsClient() {
  if ( paymentsClient === null ) {
    paymentsClient = new google.payments.api.PaymentsClient({
        environment: 'TEST',
      paymentDataCallbacks: {
        onPaymentAuthorized: onPaymentAuthorized
      }
    });
  }
  return paymentsClient;
}

/**
 * Handles authorize payments callback intents.
 *
 * @param {object} paymentData response from Google Pay API after a payer approves payment through user gesture.
 * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData object reference}
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentAuthorizationResult}
 * @returns Promise<{object}> Promise of PaymentAuthorizationResult object to acknowledge the payment authorization status.
 */
function onPaymentAuthorized(paymentData) {
        return new Promise(function(resolve, reject){
    // handle the response
    processPayment(paymentData)
    .then(function() {
      resolve({transactionState: 'SUCCESS'});
    })
    .catch(function() {
      resolve({
        transactionState: 'ERROR',
        error: {
          intent: 'PAYMENT_AUTHORIZATION',
          message: 'Insufficient funds',
          reason: 'PAYMENT_DATA_INVALID'
        }
      });
        });
  });
}

/**
 * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
 *
 * Display a Google Pay payment button after confirmation of the viewer's
 * ability to pay.
 */
function onGooglePayLoaded() {
  const paymentsClient = getGooglePaymentsClient();
  paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
      .then(function(response) {
        if (response.result) {
          addGooglePayButton();
        }
      })
      .catch(function(err) {
        // show error in developer console for debugging
        console.error(err);
      });
}

/**
 * Add a Google Pay purchase button alongside an existing checkout button
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
 * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
 */
function addGooglePayButton() {
  const paymentsClient = getGooglePaymentsClient();
  const button =
      paymentsClient.createButton({
        onClick: onGooglePaymentButtonClicked,
        allowedPaymentMethods: [baseCardPaymentMethod]
      });
  document.getElementById('container').appendChild(button);
}

/**
 * Provide Google Pay API with a payment amount, currency, and amount status
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
 * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
 */
function getGoogleTransactionInfo() {
  return {
        displayItems: [
        {
          label: "Subtotal",
          type: "SUBTOTAL",
          price: "<?php echo $tot; ?>",
        },
      {
          label: "Tax",
          type: "TAX",
          price: "1.00",
        },
        {
          label: "Spedizione",
          type: "TAX",
          price: "<?php echo $_GET["S"]; ?>",
        },
    ],
    countryCode: 'IT',
    currencyCode: "EUR",
    totalPriceStatus: "FINAL",
    totalPrice: "<?php echo $tot+1+$_GET["S"]; ?>",
    totalPriceLabel: "Total"
  };
}

/**
 * Show Google Pay payment sheet when Google Pay payment button is clicked
 */
function onGooglePaymentButtonClicked() {
  const paymentDataRequest = getGooglePaymentDataRequest();
  paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

  const paymentsClient = getGooglePaymentsClient();
  paymentsClient.loadPaymentData(paymentDataRequest);
}

/**
 * Process payment data returned by the Google Pay API
 *
 * @param {object} paymentData response from Google Pay API after user approves payment
 * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
 */
function processPayment(paymentData) {
		console.log(paymentData);
        return new Promise(function(resolve, reject) {
        setTimeout(function() {
                // @todo pass payment token to your gateway to process payment
                paymentToken = paymentData.paymentMethodData.tokenizationData.token;

        resolve({});
    }, 3000);
  },window.location.href = "Payment.php?Stat=Successfull");
}</script>
<script async
  src="https://pay.google.com/gp/p/js/pay.js"
  onload="onGooglePayLoaded()"></script>
</body>
</html>
<?php
}else
{
  header("location: Log.php");
}
}else{
  ?>
  <html>
  <div class="container">
   <div class="row">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header">
               <div class="check"><i class="fa fa-check" aria-hidden="true"></i></div>
            </div>
            <div class="content">
               <h1>Pagamento eseguito con successo!</h1>
               <p>Il pagamento e andato a buon fine il suo ordine verra preparato per la spedizione e consegna</p>
               <a href="L.php">Vai alla home</a>
            </div>
            
         </div>
      </div>
   </div>
</div>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<style type="text/css">

    body
    {
        background:#f2f2f2;
    }

    .payment
	{
		border:1px solid #f2f2f2;
		height:280px;
        border-radius:20px;
        background:#fff;
	}
   .payment_header
   {
	   background:rgba(255,102,0,1);
	   padding:20px;
       border-radius:20px 20px 0px 0px;
	   
   }
   
   .check
   {
	   margin:0px auto;
	   width:50px;
	   height:50px;
	   border-radius:100%;
	   background:#fff;
	   text-align:center;
   }
   
   .check i
   {
	   vertical-align:middle;
	   line-height:50px;
	   font-size:30px;
   }

    .content 
    {
        text-align:center;
    }

    .content  h1
    {
        font-size:25px;
        padding-top:25px;
    }

    .content a
    {
        width:200px;
        height:35px;
        color:#fff;
        border-radius:30px;
        padding:5px 10px;
        background:rgba(255,102,0,1);
        transition:all ease-in-out 0.3s;
    }

    .content a:hover
    {
        text-decoration:none;
        background:#000;
    }
   
</style>
  </html>
<?php
}
?>