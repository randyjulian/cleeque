<?php
	include('databaseconnection.php');
	$sql= "DELETE FROM groupmember WHERE groupID = '352' AND userID ='872' "; 
	$database->exec($sql);
	header('Location: loginPage.php');
?>