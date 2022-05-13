<?php
if(isset($_GET["Id"]))
{
$conn = new mysqli("localhost", "username", "password", "my_aspid");
if($mysqli->connect_error) {
  exit('Could not connect');
}
$id=$_GET["Id"];
?>
<html>
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
  </script>
<header class="header">
		<h1 class="logo"><a href="P.php">Ammazz</a></h1>
      <ul class="main-nav">
          <li><a href="#">Home</a></li>
          <li><a href="#">???</a></li>
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
<link rel="stylesheet" href="stylec.css">
<!--<script src="scriptc.js"></script>-->
<div class="single-item">
  <div class="left-set">
    <?php
    $sql = "SELECT * FROM Prodotti where Id_Prodotto =".$id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
	    $row = $result->fetch_assoc();
      echo '<img src="'.$row["Image"].'" alt="" />';
      echo '</div>';
      echo '<div class="right-set">';
      echo '<div class="name"></div>';
      echo '<div class="subname">'.$row["Nome"].'</div>';
      echo '<div class="price">'.$row["Costo"].'€</div>';
      echo '<div class="description">';
      echo '<p>';
      echo $row["Descrizione"];
      echo '</p>';
    }
    else
    {
    	header("location: Err.php?E=404");
    }
    ?>
    </div>
    <div class="color">
      <ul>
        <li></li>
        <li></li>
      </ul>
    </div>
    <button onclick="addcart(<?php echo $row["Id_prodotto"]; ?>)">ADD TO CART</button>
  </div>
</div>
</html>
<?php
}
else
{
	header("location: Err.php?E=404");
}
?>