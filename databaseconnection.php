
<?php
$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "orbital";
		
	$location = null;
	$error = false;
	
	try {
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
   			print($e->getMessage());
	}
	?>