<?php
if(isset($_COOKIE["Access"]))
{
    $conn = new mysqli("localhost", "username", "password", "my_aspid");
    if($mysqli->connect_error) {
        exit('Could not connect');
    }
    $Hash = $_COOKIE["Access"];
?>
<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Ammazz</title>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    </head>
    <body className='snippet-body'>
        <div class="card">
            <div class="row">
                <div class="col-md-8 cart">
                    <div class="title">
                        <div class="row">
                            <div class="col"><h4><b>Carrello</b></h4></div>
                            <?php
                            $sql = 'SELECT * FROM utenti JOIN Carello on utenti.Hash ="'.$Hash.'" AND utenti.Id = Carello.id_utente;';
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0)
                            {
                                $row = $result->fetch_assoc();
                                echo'<div class="col align-self-center text-right text-muted">'.$row["numeroprodotti"].' Oggetti</div>';
                            ?>
                        </div>
                    </div>
                    <div class="row border-top border-bottom"></div>
                    <?php
                    $sql = 'SELECT * FROM utenti JOIN Carello on utenti.Hash ="'.$Hash.'" AND utenti.Id = Carello.id_utente;';
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0)
                    {
                        $row = $result->fetch_assoc();
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
                                    if($row["Sconto"] == NULL)
                                    {
                                        ?>
                                        <div id="<?php echo $row["Id_prodotto"]; ?>.d" class="row">
                                            <div class="row main align-items-center">
                                                <div class="col-2"><img class="img-fluid" src="<?php echo $row["Image"]; ?>"></div>
                                                    <div class="col">
                                                        <div class="row text-muted"><?php echo $row["Categoria"]; ?></div>
                                                        <div class="row"><?php echo $row["Nome"]; ?></div>
                                                    </div>
                                                    <div class="col">
                                                        <a href="#" class="border" id="<?php echo $row["Id_prodotto"]; ?>.q"><?php echo $num[$row["Id_prodotto"]]; ?></a><a onclick="add(<?php echo $row['Id_prodotto']; ?>)" href="#">+</a>
                                                    </div>
                                                    <div class="col"><?php echo $row["Costo"]; ?> €<span onclick="remove(<?php echo $row['Id_prodotto']; ?>)" class="close">&#10005;</span></div>
                                                </div>
                                            </div>
                                        <div id="<?php echo $row["Id_prodotto"]; ?>.d2" class="row border-top border-bottom"></div>
                                        <?php
                                        $tot = $tot + $row["Costo"]* $num[$row["Id_prodotto"]];
                                        $num[$value] = -1;
                                    }else{
                                        ?>
                                        <div class="row">
                                            <div class="row main align-items-center">
                                                <div class="col-2"><img class="img-fluid" src="<?php echo $row["Image"]; ?>"></div>
                                                    <div class="col">
                                                        <div class="row text-muted"><?php echo $row["Categoria"]; ?></div>
                                                        <div class="row"><?php echo $row["Nome"]; ?></div>
                                                    </div>
                                                    <div class="col">
                                                        <a href="#" class="border" id="<?php echo $row["Id_prodotto"]; ?>.q"><?php echo $num[$row["Id_prodotto"]]; ?></a><a onclick="add(<?php echo $row['Id_prodotto']; ?>)" href="#">+</a>
                                                    </div>
                                                    <div class="col"><s><?php echo $row["Costo"]; ?> €</s>    <?php echo $row["Sconto"]; ?> €<span onclick="remove(<?php echo $row['Id_prodotto']; ?>)" class="close">&#10005;</span></div>
                                                </div>
                                            </div>
                                        <div class="row border-top border-bottom"></div>
                                        <?php
                                        $tot = $tot + $row["Costo"]* $num[$row["Id_prodotto"]];
                                        $num[$value] = -1;
                                    }  
                                }
                            }
                        }
                    }
                    ?>
                    <div class="back-to-shop"><a href="P.php">&leftarrow;</a><span class="text-muted" >Back to shop</span></div>
                </div>
                <div class="col-md-4 summary">
                    <div><h5><b>Summary</b></h5></div>
                    <hr>
                    <?php 
                    $sql = 'SELECT * FROM utenti JOIN Carello on utenti.Hash ="'.$Hash.'" AND utenti.Id = Carello.id_utente;';
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0)
                    {
                        $row = $result->fetch_assoc();
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
                                    if($row["Sconto"] == NULL)
                                    {
                                        echo '<div class="row">';
                                        echo    '<div class="col" style="padding-left:0;">'.$row["Nome"].'</div>';
                                        echo    '<div class="col text-right">'.$row["Costo"] * $num[$row["Id_prodotto"]].'€ </div>';
                                        echo'</div>';
                                        $tot = $tot + $row["Costo"]* $num[$row["Id_prodotto"]];
                                        $num[$value] = -1;
                                    }else{
                                        echo '<div class="row">';
                                        echo    '<div class="col" style="padding-left:0;">'.$row["Nome"].'</div>';
                                        echo    '<div class="col text-right"><s>'.$row["Costo"] * $num[$row["Id_prodotto"]].'€</s></div>';
                                        echo    $row["Sconto"] * $num[$row["Id_prodotto"]].'€';
                                        echo'</div>';
                                        $tot = $tot + $row["Sconto"] * $num[$row["Id_prodotto"]];
                                        $num[$value] = -1;
                                    }  
                                }
                            }
                        }
                    /*<div class="row">
                        <div class="col" style="padding-left:0;">boh</div>
                        <div class="col text-right">€banana</div>
                    </div>*/
                    }
                    unset($value);
                    ?>
                    <form>
                        <p>SHIPPING</p>
                        <select id="spedizione" onchange="tot()">
                            <option class="text-muted" value="5">Standard-Delivery - 5 €</option>
                            <option class="text-muted" value="10">Express-Delivery - 10 €</option>
                        </select>
                        <p>GIVE CODE</p>
                        <input id="code" placeholder="Enter your code">
                    </form>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div id="totale" class="col text-right">0 €</div>
                    </div>
                    <script>
                    var select = document.getElementById('spedizione');
                    var value = select.options[select.selectedIndex].value;
                    document.getElementById("totale").innerHTML = <?php echo $tot;?> + parseInt(value);
                    var php=<?php echo $tot;?>;
                    function tot()
                    {
                        value = select.options[select.selectedIndex].value;
                        document.getElementById("totale").innerHTML = php + parseInt(value);
                    }
                    function add(id){
                        <?php
                        if(isset($_COOKIE["Access"])){
                            ?>
                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function() {
                                document.getElementById(id+".q").innerHTML = this.responseText;
                            }
                            xhttp.open("GET", "addcart.php?id="+id+"&Access="+"<?php echo $_COOKIE["Access"]; ?>&y=TRUE");
                            xhttp.send();
                            <?php
                        }
                        ?>
                    }
                    function remove(id){
                        <?php
                        if(isset($_COOKIE["Access"])){
                            ?>
                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function() {
                                if(this.responseText == 0){
                                    var div = document.getElementById(id+'.d');
                                    div.parentNode.removeChild(div);
                                    div = document.getElementById(id+'.d2');
                                    div.parentNode.removeChild(div);
                                }
                                else{
                                    document.getElementById(id+".q").innerHTML = this.responseText;
                                }
                            }
                            xhttp.open("GET", "removecart.php?id="+id+"&Access="+"<?php echo $_COOKIE["Access"]; ?>");
                            xhttp.send();
                            <?php
                        }
                        ?>
                    }
                    function payment()
                    {
                        value = select.options[select.selectedIndex].value;
                        window.location.href = "Payment.php?S="+parseInt(value);
                    }
                    </script>
                    <button onclick="payment()" class="btn">CHECKOUT</button>
                </div>
            </div>
            
        </div>
                            
        <style>::-webkit-scrollbar {
                                  width: 8px;
                                }
                                /* Track */
                                ::-webkit-scrollbar-track {
                                  background: #f1f1f1; 
                                }
                                 
                                /* Handle */
                                ::-webkit-scrollbar-thumb {
                                  background: #888; 
                                }
                                
                                /* Handle on hover */
                                ::-webkit-scrollbar-thumb:hover {
                                  background: #555; 
                                } body{
    background: #ddd;
    min-height: 100vh;
    vertical-align: middle;
    display: flex;
    font-family: sans-serif;
    font-size: 0.8rem;
    font-weight: bold;
}
.title{
    margin-bottom: 5vh;
}
.card{
    margin: auto;
    max-width: 950px;
    width: 90%;
    box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border-radius: 1rem;
    border: transparent;
}
@media(max-width:767px){
    .card{
        margin: 3vh auto;
    }
}
.cart{
    background-color: #fff;
    padding: 4vh 5vh;
    border-bottom-left-radius: 1rem;
    border-top-left-radius: 1rem;
}
@media(max-width:767px){
    .cart{
        padding: 4vh;
        border-bottom-left-radius: unset;
        border-top-right-radius: 1rem;
    }
}
.summary{
    background-color: #ddd;
    border-top-right-radius: 1rem;
    border-bottom-right-radius: 1rem;
    padding: 4vh;
    color: rgb(65, 65, 65);
}
@media(max-width:767px){
    .summary{
    border-top-right-radius: unset;
    border-bottom-left-radius: 1rem;
    }
}
.summary .col-2{
    padding: 0;
}
.summary .col-10
{
    padding: 0;
}.row{
    margin: 0;
}
.title b{
    font-size: 1.5rem;
}
.main{
    margin: 0;
    padding: 2vh 0;
    width: 100%;
}
.col-2, .col{
    padding: 0 1vh;
}
a{
    padding: 0 1vh;
}
.close{
    margin-left: auto;
    font-size: 0.7rem;
}
img{
    width: 3.5rem;
}
.back-to-shop{
    margin-top: 4.5rem;
}
h5{
    margin-top: 4vh;
}
hr{
    margin-top: 1.25rem;
}
form{
    padding: 2vh 0;
}
select{
    border: 1px solid rgba(0, 0, 0, 0.137);
    padding: 1.5vh 1vh;
    margin-bottom: 4vh;
    outline: none;
    width: 100%;
    background-color: rgb(247, 247, 247);
}
input{
    border: 1px solid rgba(0, 0, 0, 0.137);
    padding: 1vh;
    margin-bottom: 4vh;
    outline: none;
    width: 100%;
    background-color: rgb(247, 247, 247);
}
input:focus::-webkit-input-placeholder
{
      color:transparent;
}
.btn{
    background-color: #000;
    border-color: #000;
    color: white;
    width: 100%;
    font-size: 0.7rem;
    margin-top: 4vh;
    padding: 1vh;
    border-radius: 0;
}
.btn:focus{
    box-shadow: none;
    outline: none;
    box-shadow: none;
    color: white;
    -webkit-box-shadow: none;
    -webkit-user-select: none;
    transition: none; 
}
.btn:hover{
    color: white;
}
a{
    color: black; 
}
a:hover{
    color: black;
    text-decoration: none;
}
 #code{
    background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253) , rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
    background-repeat: no-repeat;
    background-position-x: 95%;
    background-position-y: center;
}</style>
    </body>
</html>
<?php
                    }
}else{
    header("location: P.php",true,402);
}
?>