<?php
if(isset($_POST["card-holder"]) && $_POST["card-holder"] == "" && isset($_POST["card-number"]) && $_POST["card-number"] == "" &&  isset($_POST["card-number-1"]) && $_POST["card-number-1"] == "" && isset($_POST["card-number-2"]) && $_POST["card-number-2"] == "" && isset($_POST["card-number-3"]) && $_POST["card-number-3"] == "" && isset($_POST["card-expiration-month"]) && $_POST["card-expiration-month"] == "" && $_POST["card-expiration-year"] == "" && isset($_POST["card-expiration-year"]) && $_POST["card-ccv"] == "" && isset($_POST["card-ccv"]))
{
	echo"Riempire tutti i campi";
}else if(isset($_POST["card-holder"]) && $_POST["card-holder"] != "" && isset($_POST["card-number"]) && $_POST["card-number"] != "" &&  isset($_POST["card-number-1"]) && $_POST["card-number-1"] != "" && isset($_POST["card-number-2"]) && $_POST["card-number-2"] != "" && isset($_POST["card-number-3"]) && $_POST["card-number-3"] != "" && isset($_POST["card-expiration-month"]) && $_POST["card-expiration-month"] != "" && $_POST["card-expiration-year"] != "" && isset($_POST["card-expiration-year"]) && $_POST["card-ccv"] != "" && isset($_POST["card-ccv"]))
{
  echo "Pagamento Eseguito";
}else
{
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Ammazz</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Open+Sans&amp;display=swap'><link rel="stylesheet" href="Card.css">

</head>
<body>
<div class="checkout">
  <div class="credit-card-box">
    <div class="flip">
      <div class="front">
        <div class="chip"></div>
        <div class="logo">
          <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
          </svg>
        </div>
        <div class="number"></div>
        <div class="card-holder">
          <label>Card holder</label>
          <div></div>
        </div>
        <div class="card-expiration-date">
          <label>Expires</label>
          <div></div>
        </div>
      </div>
      <div class="back">
        <div class="strip"></div>
        <div class="logo">

        </div>
        <div class="ccv">
          <label>CCV</label>
          <div></div>
        </div>
      </div>
    </div>
  </div>
  <form class="form" autocomplete="off" novalidate action="Card.php" method="POST">
    <fieldset>
      <label for="card-number">Card Number</label>
      <input type="text" id="card-number" class="input-cart-number" name="card-number" maxLenght="4" />
      <input type="text" id="card-number-1" class="input-cart-number" name="card-number-1" maxLenght="4" />
      <input type="text" id="card-number-2" class="input-cart-number" name="card-number-2" maxLenght="4" />
      <input type="text" id="card-number-3" class="input-cart-number" name="card-number-3" maxLenght="4" />
    </fieldset>
    <fieldset>
      <label for="card-holder">Card holder</label>
      <input type="text" id="card-holder" minlength="3" name="card-holder" />
    </fieldset>
    <fieldset class="fieldset-expiration">
      <label for="card-expiration-month">Expiration date</label>
      <div class="select">
        <select id="card-expiration-month" name="card-expiration-month">
          <option></option>
          <option>01</option>
          <option>02</option>
          <option>03</option>
          <option>04</option>
          <option>05</option>
          <option>06</option>
          <option>07</option>
          <option>08</option>
          <option>09</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
        </select>
      </div>
      <div class="select">
        <select id="card-expiration-year" name="card-expiration-year">
          <option></option>
          <option>2016</option>
          <option>2017</option>
          <option>2018</option>
          <option>2019</option>
          <option>2020</option>
          <option>2021</option>
          <option>2022</option>
          <option>2023</option>
          <option>2024</option>
          <option>2025</option>
        </select>
      </div>
    </fieldset>
    <fieldset class="fieldset-ccv">
      <label for="card-ccv">CCV</label>
      <input type="text" id="card-ccv" name="card-ccv" minLenght="3" maxLenght="3" />
    </fieldset>
    <button class="btn"><i class="fa fa-lock"></i> submit</button>
  </form>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script><script  src="Card.js"></script>

</body>
</html>
<?php
}
?>