<?php
$conn = new mysqli("localhost", "username", "password", "my_aspid");
require_once './google/vendor/autoload.php';
$clientID = '1082057051595-fjiqgith9c071a1s6mtv2plhfvua8u2a.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://aspid.altervista.org/boh/Reg.php';
   
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
if (isset($_GET['code'])) {
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    var_dump($token);
	$client->setAccessToken($token['access_token']);
	 
	// get profile info
	$google_oauth = new Google_Service_Oauth2($client);
	$google_account_info = $google_oauth->userinfo->get();
	$email =  $google_account_info->email;
	$name =  addslashes($google_account_info->name);
    $temp = "Test";
    $sql = "SELECT Password,Username FROM utenti Where Email = '" . $email."' ;";
    var_dump($sql);
    var_dump($conn);
  	$result = $conn->query($sql);
  	if ($result->num_rows > 0)
    {
    	$row = $result->fetch_assoc();
		echo "Benvenuto ".$name;
		$options = [
			'cost' => 12,
		];
		$Hash=password_hash($row["Username"].$row["Password"], PASSWORD_BCRYPT, $options);
		$sql = "UPDATE utenti
		SET Hash = ".$Hash."
		WHERE Username = ".$row["Username"]." and Password =".$row["Password"].";";
  		$result = $conn->query($sql);
    	setcookie("Access", $Hash, time()+60*60*24*30);
		 ?>
		 <html>
		 <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			 <input type="submit" name="Logout" value="Log out" />
		 </form>
		 </html>
		 <?php
	}
	else{
	echo "Utente non presente Registrarzione in corso";
	//echo "<a href='Log.php'>Torna al login</a>";
    $options = [
			'cost' => 12,
		];
    $Hash=password_hash($name.$temp, PASSWORD_BCRYPT, $options);
    $sql = "INSERT INTO utenti (Username, Password, Email, Hash)
			VALUES ('$name','$temp','$email','$Hash');";
            var_dump($sql);
  		$result = $conn->query($sql);
	}
    }
?>