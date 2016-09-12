<?php
	include('databaseconnection.php');
	$sql= "SELECT * FROM groupmember "; 
	$stmt = $database->prepare($sql);
	$stmt->execute();
	$groupArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($groupArray);
?>