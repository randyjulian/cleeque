<?php
	include('databaseconnection.php');
	$sql= "SELECT TOP(1) FROM groupmember WHERE groupID = '352' AND userID ='872' "; 
	$stmt = $database->prepare($sql);
	$stmt->execute();
	$array = $stmt->fetchColumn();
	print_r($array);
?>