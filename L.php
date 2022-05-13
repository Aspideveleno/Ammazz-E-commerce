<?php
$conn = new mysqli("localhost", "username", "password", "my_aspid");
if($mysqli->connect_error) {
  exit('Could not connect');
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Ammazz</title>
  <link rel="stylesheet" href="L.css">

</head>
<body>
<!-- partial:index.partial.html -->
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

<body>
  <header>
    <div class="company-logo">Ammazz</div>
    <nav class="navbar">
      <ul class="nav-items">
        <li class="nav-item"><a href="L.php" class="nav-link">HOME</a></li>
        <li class="nav-item"><a href="P.php" class="nav-link">Prodotti</a></li>
        <?php
        if(isset($_COOKIE["Access"]))
        {
          $Hash = $_COOKIE["Access"];
          $sql = 'SELECT * FROM utenti Where Hash = "' . $Hash.'";';
          $result = $conn->query($sql);
          if ($result->num_rows > 0)
          {
            $sql = 'SELECT numeroprodotti FROM Carello JOIN utenti ON utenti.Hash="'.$Hash.'" AND utenti.Id = Carello.id_utente';
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
          echo'<li class="nav-item"><a id="carello" href="Cart.php" class="nav-link">Carrello ('.$row["numeroprodotti"].')</a></li>';
          echo'<li class="nav-item"><a href="Log.php" class="nav-link">LogOut</a></li>';
        }
      }
        else{
          echo'<li class="nav-item"><a href="Cart.php" class="nav-link">Carrello (0)</a></li>';
          echo'<li class="nav-item"><a href="Log.php" class="nav-link">Login/Registrazione</a></li>';
        }
        ?>
      </ul>
    </nav>
    <div class="menu-toggle">
      <i class="bx bx-menu"></i>
      <i class="bx bx-x"></i>
    </div>
  </header>
  <main>
    <!-- HOME SECTION -->
    <section class="container section-1">
      <div class="slogan">
        <h1 class="company-title">Ammazz veditore specializzato d'informatica</h1>
        <h2 class="company-slogan">
          Il tuo E-commerce di informatica numero 1.
        </h2>
      </div>
      <div class="home-computer-container">
        <img class="home-computer" src="https://github.com/r-e-d-ant/Computer-store-website/blob/main/assets/images/home_img.png?raw=true" alt="a computer in dark with shadow" class="home-img">
      </div>
    </section>

    <!-- OFFER SECTION -->
    <section class="container section-2">
      <!-- offer 1 -->
      <?php
      $sql = 'SELECT * FROM Prodotti Where Id_prodotto="11";';
      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        $row = $result->fetch_assoc();
      ?>
      <div class="offer offer-1">
        <img src="<?php echo $row['Image'];?>" alt="a computer in dark with with white shadow" class="offer-img offer-1-img">
        <div class="offer-description offer-desc-1">
          <h2 class="offer-title"><?php echo $row["Nome"];?></h2>
          <p class="offer-hook"><?php echo $row["Descrizione"];?></p>
          <div onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="cart-btn">ADD TO CART</div>
        </div>
      </div>
      <?php
      }else{
        //errore
      }
    ?>
      <!-- offer 2 -->
      <?php
      $sql = 'SELECT * FROM Prodotti Where Id_prodotto="12"';
      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        $row = $result->fetch_assoc();
      ?>
      <div class="offer offer-2">
        <img src="<?php echo $row['Image'];?>" alt="a opened computer" class="offer-img offer-2-img">
        <div class="offer-description offer-desc-2">
          <h2 class="offer-title"><?php echo $row["Nome"];?></h2>
          <p class="offer-hook"><?php echo $row["Descrizione"];?></p>
          <div onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="cart-btn">ADD TO CART</div>
        </div>
      </div>
    </section>
    <?php
      }else{
        //errore
      }
    ?>

    <!-- PRODUCT SECTION -->
    <section class="container section-3">
      <!-- product - 1 -->
      <?php
      $sql = 'SELECT * FROM Prodotti Where Id_prodotto="13" OR Id_prodotto="14" OR Id_prodotto="15" OR Id_prodotto="16" ';
      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        $row = $result->fetch_assoc();
      ?>
      <div class="product product-1">
        <img src="<?php echo $row['Image'];?>" alt="computer to sell" class="product-img">
        <span onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="product_add_cart">ADD TO CART</span>
      </div>
      <!-- product - 2 -->
      <?php
        $row = $result->fetch_assoc();
      ?>
      <div class="product product-2">
        <img src="<?php echo $row['Image'];?>" alt="computer to sell" class="product-img">
        <span onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="product_add_cart">ADD TO CART</span>
      </div>
      <!-- product - 3 -->
      <?php
        $row = $result->fetch_assoc();
      ?>
      <div class="product product-3">
        <img src="<?php echo $row['Image'];?>" alt="computer to sell" class="product-img">
        <span onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="product_add_cart">ADD TO CART</span>
      </div>
      <!-- product - 4 -->
      <?php
        $row = $result->fetch_assoc();
      ?>
      <div class="product product-4">
        <img src="<?php echo $row['Image'];?>" alt="computer to sell" class="product-img">
        <span onclick="addcart(<?php echo $row['Id_prodotto'];?>)" class="product_add_cart">ADD TO CART</span>
      </div>
    </section>
    <?php
    }
    ?>

    <!-- SPONSOR SECTION -->
    <section class="container section-4">
      <!-- SPONSOR group 1 -->
      <div class="sponsor sponsor-1"><img src="https://raw.githubusercontent.com/r-e-d-ant/Computer-store-website/b90ac65459206fef22e9b87313f587185554263b/assets/images/microsoft.svg" alt=""></div>
      <div class="sponsor sponsor-2"><img src="https://raw.githubusercontent.com/r-e-d-ant/Computer-store-website/b90ac65459206fef22e9b87313f587185554263b/assets/images/apple.svg" alt=""></div>

      <!-- SPONSOR group 2 -->
      <div class="sponsor sponsor-3"><img src="https://raw.githubusercontent.com/r-e-d-ant/Computer-store-website/b90ac65459206fef22e9b87313f587185554263b/assets/images/dell.svg" alt=""></div>
      <div class="sponsor sponsor-4"><img src="https://raw.githubusercontent.com/r-e-d-ant/Computer-store-website/b90ac65459206fef22e9b87313f587185554263b/assets/images/ibm.svg" alt=""></div>
    </section>

    <!-- SUBSCRIBE SECTION-->
    <section class="container section-5">
      <h2 class="subscribe-input-label">NEWSLETTER</h2>
      <div class="subscribe-container">
        <input type="text" id="email-subscribe" placeholder="Email address...">
        <input type="submit" value="SUBSCRIBE">
      </div>
    </section>
  </main>
  <!---<footer>
    <div class="container top-footer">
      <div class="footer-item">
        <h2 class="footer-title">ADDRESS</h2>
        <div class="footer-items">
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing st18</h3>
        </div>
      </div>
      <div class="footer-item">
        <h2 class="footer-title">SERVICES</h2>
        <div class="footer-items">
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
        </div>
      </div>
      <div class="footer-item">
        <h2 class="footer-title">SUPPLIERS</h2>
        <div class="footer-items">
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
        </div>
      </div>
      <div class="footer-item">
        <h2 class="footer-title">INVESTMENT</h2>
        <div class="footer-items">
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
          <h3>Adipisicing elit.</h3>
        </div>
      </div>
    </div>
  </footer>--->
</body>
<!-- partial -->
  <script  src="L.js"></script>
  <script>
    function addcart(id){
      <?php
      if(isset($_COOKIE["Access"])){
        ?>
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("carello").innerHTML = "Carrello("+this.responseText+")";
        }
        xhttp.open("GET", "addcart.php?id="+id+"&Access="+"<?php echo $_COOKIE["Access"]; ?>");
        xhttp.send();
        <?php
      }
      else{
        ?>
        alert("effettuare l'accesso per aggiungere un prodotto al carrello.");
        <?php
      }
      ?>
    }
    function apri(id){
      window.location.href = "C.php?Id="+id;
    }
</script>
</body>
</html>
<?php
      
?>