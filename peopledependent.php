<?php
	session_start();
	include("groupFunction.php");
	include("main_ics_processer.php");
	include("databaseconnection.php");
	if(!isset($_SESSION['username'])){header('Location: index.php');}
	$username=$_SESSION['username'];
	$_SESSION['fullName']=gettingNameFromUsername($_SESSION['username']);
	$groupID=$_SESSION['groupID'];
	
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
			color: 'navy';}
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

<style>
input.submit[type=submit] {
    width: 10%;
    background-color: #3498db;
    color: white;
    padding: 6px 10px;
    margin: 8px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
}

input.submit[type=submit]:hover {
    background-color: #2b3856;
    transition: 0.2s;
    color: white;
}
input.member[type=checkbox] select{
	font-family: "Roboto";

}
input.return[type=submit] {
    width: 10%;
    background-color: white;
    color: red;
    padding: 6px 10px;
    border: 1px solid red;
    margin: 8px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
}

input.return[type=submit]:hover {
    background-color: red;
    transition: 0.2s;
    color: white;
    margin-left: 20px;
}

.groupPeopleDep{
	font-size: 20px;
	margin: 0px;
	margin-bottom: 10px;
	background-color: white;
	padding: 5px;
	color: #3498db;
	display: inline-block;
	width: 31%;
	max-width: 250px;
	text-align: center;
	border-radius: 7px;
	border: 1px solid;
	cursor: pointer;
	transition: 0.2s;
	overflow: hidden;
	font-family: "Montserrat";

}

.groupPeopleDep:hover{
	background-color: #8ac3f1;
}

.selected{
	background-color: #2b3856;
	color: white;
}

.selectedForName{
	color: #3498db ;
}

</style>

<br><br><p id="selectmember">Select the members:
<form action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="post" name="userChosen">
<?php
	$groupMember=gettingGroupMember($_SESSION['groupID']);
	foreach($groupMember as $key=>$value){
		foreach ($value as $subkey => $userID) {
			$name= gettingUsernameFromID($userID);
			$fullname = gettingNameFromUsername($name);
			echo "<input type='checkbox' class='member' name='userChosen[$name]' value='$userID' id='$name' style='display:none'></input>";
			echo "<label for='$name' class='groupPeopleDep'>$name<br><span class='nameDescription' style='color:#999999'>$fullname</span></label>";
		}
	}
	//echo "<br><br><input type='submit' value='Submit'>";
	echo "<br><br><input class='submit' type='submit'>";
	echo "</form>";
	$_SESSION['groupID']=$groupID;
	?>
<form action="addmember.php" method="POST">
        <input class= "return" type="submit" name="submit" value="Cancel">
    </form>
	<?php 

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
		echo "<p id='selectmember'>Please choose some users!</p>";
		exit();
	}
	echo "<p id='selectmember'> Common Free Time For Selected Users</p>";
	echo '<div class="showTableDiv">';
	$numberOfPeopleSubmitted = count($_POST['userChosen']);
	printTableArray($freeTimeArray, $numberOfPeopleSubmitted);
	echo '</div>';
	

?>



</body>
</html>