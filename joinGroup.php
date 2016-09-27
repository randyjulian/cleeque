<?php
	session_start();
	include("groupFunction.php");
	include("main_ics_processer.php");
	$groupID = $_SESSION['groupID'];
	$usernameSession = $_SESSION['username'];
	$inside = checkingUsernameExistInGroup($groupID, $usernameSession);
	if($inside == 0 ) {
		requestToJoinGroup($groupID,$usernameSession);
	}; 

	header('Location: https://cleequetest.herokuapp.com/loginPage.php');
?>