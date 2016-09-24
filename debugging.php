<?php
	include('databaseconnection.php');
	$sql= "DELETE TOP(1) FROM groupmember WHERE groupID = '352' AND userID ='872'"; 
	$database->exec($sql);
	header('Location: loginPage.php');
?>