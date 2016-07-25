<?php
	session_start();
	include('databaseconnection.php');
	include('groupFunction.php');
	$usernameSession=$_SESSION['username'];
	$userID = gettingUserID($usernameSession);
	$groupID= $_SESSION['groupID'];
	//echo "UserID is $userID<br>";
	$sql= "DELETE FROM groupmember WHERE userID = '$userID' AND groupID= '$groupID' ";
	//echo "Username is $usernameSession <br> inside addingGroupMember<br>";
	$database->exec($sql);
	header('Location: loginPage.php');
?>