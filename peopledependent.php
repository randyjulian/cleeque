<?php
	session_start();
	include("groupFunction.php");
	include("main_ics_processer.php");
	include("databaseconnection.php");
	if(!isset($_SESSION['username'])){header('Location: index.php');}
	$username=$_SESSION['username'];
	$_SESSION['fullName']=gettingNameFromUsername($_SESSION['username']);
	
?>
<!DOCTYPE html>
<html>
<head>
	<!--<title>People Dependent Function</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<title>Cleeque | People Dependent Slots</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">
	<link type="text/css" rel="stylesheet" href="style.css"></link>
	<!---Fonts-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <script>
    $(function(){
    	$('#check').button();
    	$('input').buttonset();
    });
    </script>
    <style>
    input {margin-top: 2em;}
    button {background: 'blue';
			color: 'navy';
			width: 0px;}
	.ui-helper-hidden-accessible {
	border: 0;
	clip: rect(0 0 0 0);
	height: 1px;
	margin: -1px;
	overflow: hidden;
	padding: 0;
	position: absolute;
}
    </style>
</head>
<body>

	<div class="modal">
		<div class="modal-content">
			<div class="modalHeader">
				<span class="close"> X </span>
				<p id="modalCleeque">CLEEQUE</p>				
			</div>
			<div class="modalBody">
				<form  method="post">
					<input type="text" id="username" placeholder="Username"><br><br>
					<input type="password" id="password" placeholder="Password"><br>
					<p id="errorMessage" style="color:red"></p>
					<input type="submit" name="submit" value="Sign In" id="loginButton">
				</form>
				
				<br id="account"> Don't have an account? <a href="signup.php" id="modalSignup">Sign up!</a>
			</div>
		</div>
	</div>
	<div class="navbar">
		<img id="logo" src="http://i.imgur.com/NXXGa4e.png" height="35" width="35" style="float: left; margin-top: 6.4px;"><p id= "cleeque" style="margin-top:0px;" >  CLEEQUE</p> 
		<div class="menu" style="float:right;">
			<div class="mainMenu">
				<p><a href="index.php">Home</a></p>
				<p><a href="about.php">About</a></p>
			</div>
			<a id="usernameNav" style="text-decoration:none;" href="logout.php">Log Out</a>
			<p id="responsiveNavButton"> &#9776; Menu</p>
		</div>
	</div>


<br><br>
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