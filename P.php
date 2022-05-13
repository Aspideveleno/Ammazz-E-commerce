<?php
$conn = new mysqli("localhost", "username", "password", "my_aspid");
if($mysqli->connect_error) {
  exit('Could not connect');
}
?>
<html>
<header class="header">
<title>Ammazz</title>
		<h1 class="logo"><a href="P.php">Ammazz</a></h1>
      <ul class="main-nav">
          <li><a href="L.php">Home</a></li>
          <li><a href="P.php">Prodotti</a></li>
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
              echo '<li><a id="carello" class="carrello" href="Cart.php">Carrello:'.$row["numeroprodotti"].'</a></li>';
              echo '<li><a href="Log.php?Logout=y">LogOut</a></li>';
            }else {
              echo '<li><a class="carrello" href="Cart.php">Carrello:0</a></li>';
              echo '<li><a href="Log.php">Accesso/Registrazione</a></li>';
            }
          }else {
          echo '<li><a class="carrello" href="Cart.php">Carrello:0</a></li>';
          echo '<li><a href="Log.php">Accesso/Registrazione</a></li>';
          }
          ?>
      </ul>
	</header>
  <body>
<link rel="stylesheet" href="stylep.css">
<script>
    function addcart(id){
      <?php
      if(isset($_COOKIE["Access"])){
        ?>
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("carello").innerHTML = "Carrello:"+this.responseText;
        }
        xhttp.open("GET", "addcart.php?id="+id+"&Access="+"<?php echo $_COOKIE["Access"]; ?>");
        xhttp.send();
        <?php
      }
      ?>
    }
    function apri(id){
      window.location.href = "C.php?Id="+id;
    }
</script>
<div class="wrapper">
<div class="full-height"></div>
  <div class="row">
    <?php
    $sql = "SELECT * FROM Prodotti ";
    $result = $conn->query($sql);
    $i=0;
    if ($result->num_rows > 0)
    {
	    while($row = $result->fetch_assoc()){
        $i=$i+1;
    echo '<div class="card">';
      echo '<img src="'.$row["Image"].'" width="250" height="150" onclick="apri('.$row["Id_prodotto"].')">';
      echo '<div class="product">';
        echo '<span class="product-name" onclick="apri('.$row["Id_prodotto"].')">'.$row["Nome"].'</span>';
        echo '<span class="product-author">By './*$row["produttore"]*/"CIAO".'</span>';
      echo '</div>
      <div class="product-rating">
        <i class="fas fa-heart"></i>
        <i class="fas fa-heart"></i>
        <i class="fas fa-heart"></i>
        <i class="fas fa-heart"></i>
        <i class="fas fa-heart"></i>
      </div>';
      echo '<div class="description">';
        echo '<p>'.$row["Descrizione"].'</p>';
      echo '</div>
      <div class="price">
        <div>';
        if($row["Sconto"] != NULL)
        {
          echo '<span class="before-price">'.$row["Costo"].'€</span>';
          echo '<span class="now-price">'.$row["Sconto"].'€</span>';
        }
        else{
          echo '<span class="price">'.$row["Costo"].'€</span>';
        }
        echo '</div>
        <button onclick="addcart('.$row["Id_prodotto"].')">add to cart</button>
      </div>
    </div>';
    if($i== 4)
    {
      echo '</div><div class="row">';
      $i=0;
    }
      }
    }
    ?>
  </div>
</div>
</body>
</html>