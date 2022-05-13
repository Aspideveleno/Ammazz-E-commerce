<?php
$conn = new mysqli("localhost", "username", "password", "my_aspid");
if($mysqli->connect_error) {
  exit('Could not connect');
}
$id=$_GET["id"];
$sql = "SELECT * FROM Prodotti where Id_prodotto =".$id;
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();
    $costo = $row["Costo"];
    $Hash = $_GET["Access"];
    $sql = 'SELECT * FROM utenti where Hash ="'.$Hash.'"';
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $sql = 'SELECT * FROM Carello JOIN utenti ON utenti.Hash="'.$Hash.'"  AND utenti.Id = Carello.id_utente';
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $tot= $row["totale_carello"];
            $numprod= $row["numeroprodotti"];
            $idprod= $row["id_prodotti"];
            $tot = $tot - ($costo * substr_count($idprod, $id));
            $numprod = $numprod - substr_count($idprod, $id);
            $idprod = str_replace($id, "", $idprod);
            $idprod = str_replace(",,", ",", $idprod);
            $sql = 'UPDATE Carello SET totale_carello = '.$tot.', id_prodotti = "'.$idprod.'", numeroprodotti = '.$numprod.' WHERE id_utente = '.$row["id_utente"]; 'UPDATE Carello SET totale_carello = '.$tot.', id_prodotti = "'.$idprod.'", numeroprodotti = '.$numprod.' WHERE id_utente = '.$row["id_utente"];
            $result = $conn->query($sql);
            $sql = 'SELECT * FROM utenti JOIN Carello on utenti.Hash ="'.$Hash.'" AND utenti.Id = Carello.id_utente;';
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $prod = $row["id_prodotti"];
                $ida = explode(",",$prod);
                $num =array_count_values($ida);
                if($num[$_GET["id"]] == NULL){
                    echo 0;
                }else{
                    echo $num[$_GET["id"]];
                }
            }else{
                echo "errore";
            }
        }
    }
}
else{
    echo "404";
}
?>