<?php
session_start();
include("main_ics_processer.php");
include("groupFunction.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>People Dependent Function</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script>
    $(function(){
    	$('#check').button();
    	$('input').buttonset();
    });
    </script>
    <style>
    input {margin-top: 2em;}
    button {background: 'blue';
			color: 'navy';}
    </style>
</head>
<body>
<h1> Welcome, <?php echo $_SESSION['username'];?>!</h1>
<form action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="post" name="userChosen">
<?php
	$groupMember=gettingGroupMember($_SESSION['groupID']);
	foreach($groupMember as $key=>$value){
		foreach ($value as $subkey => $userID) {
			$name= gettingUsernameFromID($userID);
			echo "<input type='checkbox' name='userChosen[$name]' value='$userID' id='check'>$name</input>";
		}
	}
	//echo "<br><br><input type='submit' value='Submit'>";
	echo "<br><br><button type='submit'>Submit</button>";
	echo "</form>";

	if(isset($_POST['userChosen'])){
		//$freeTimeArray=array();
		initialiseWeekArray($freeTimeArray);
		foreach($_POST['userChosen'] as $key=>$userID){
			initialiseWeekArray($userTimeslotArray);
			$filename=gettingFilename($userID);
			//echo "Filename for $subvalue is $filename<br>";
			$userTimeslotArray=unserialize($filename);
			comparison($userTimeslotArray, $freeTimeArray);

		}
	} else {
		echo "<br><h2>Please choose some users!</h2>";
		exit();
	}
	echo "<h1> Common Free Time For Selected Users</h1>";
	printTableArray($freeTimeArray);

	

?>



</body>
</html>