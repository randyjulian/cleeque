<?php
	session_start();
	$groupID = $_SESSION['groupID'];
	include("groupFunction.php");
	include("main_ics_processer.php");


	foreach($_POST['userApproved'] as $key=>$userID){
		$username = gettingUsernameFromID($userID);
		changePendingToZero($groupID,$username);
	}

	header('Location: https://cleequetest.herokuapp.com/addmember.php?groupNameSelected='.$groupID.'&submit=Go%21');
?>