<?php
session_start();
if(!isset($_SESSION['username'])){header('Location: index.php');}
include("groupFunction.php");
include("main_ics_processer.php");
if(isset($_POST['submit']) && !isset($_SESSION['groupID'])){
$_SESSION['groupID']=$_POST['groupNameSelected'];
} else {
	if(!isset($_SESSION['groupID'])&& !isset($_POST['submit'])){
		header("Location: loginPage.php");
	}
}

if (!isset($_POST['username'])) {
	//$error=true;
	} else{
		if($_POST['username']==''){
			echo "<script> alert('No name is input!')</script>";
		} else {
			$usernameAdded=$_POST['username'];
			$useridNotExist=checkingUsernameExistInUserid($usernameAdded);
			if(!$useridNotExist){
				$userNotInGroup=checkingUsernameExistInGroup($_SESSION['groupID'],$usernameAdded);
				if(!$userNotInGroup){
			addingGroupMember($_SESSION['groupID'],$usernameAdded);
			}else {
				echo "<script>alert('The username already exists in the group!')</script>";
			}
		}else {
			echo "<script> alert('Username is not found!')</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cleeque | Group</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" type="text/css" href="style.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
</head>
<body>

<style>
	input.addmember[type=text],select {
	width: 30%;
    padding: 12px 20px;
    margin: 8px 8px;
    display: block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: "Roboto";
    font-size: 15px;

	}
	input.submit[type=submit],select {
    width: 15%;
    background-color: #3498db;
    color: white;
    display: block;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
	}
	input.submit[type=submit]:hover {
    background-color: #2b3856;
    transition: 0.2s;
	}

	input.peopledependent[type=submit],select {
    width: 40%;
    background-color: white;
    color: #3498db;
    display: block;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-family: "Montserrat";
    font-size: 15px;
	}

	input.quitgroup[type=submit]:hover {
    background-color: red;
    color: white;
    transition: 0.2s;
	}

	input.quitgroup[type=submit],select {
    width: 10%;
    background-color: white;
    color: black;
    display: block;
    padding: 6px 10px;
    margin-top: -40px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-family: "Montserrat";
    font-size: 15px;
	}
	
	input.peopledependent[type=submit]:hover {
    background-color: #2b3856;
    color: white;
    transition: 0.2s;
	}

	.groupTableHeader{
		font-family: "Montserrat";
		font-size: 20px;
		text-align: center;
		clear: both;
	}
</style>

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

<div class="mainGroup">
		<div class="mainHeadergroup">
			<h1 id="welcomeHeader"><?php echo gettingGroupNameFromID($_SESSION['groupID']);?></h1>
			<h6 id="welcomeHeaderFullName">Group ID : <?php echo $_SESSION['groupID'];?></h6>
			<form action="exitGroup.php" method='POST'>
				<p id="addmember"  style="text-align: center;">
				<input  style="margin-left: auto; margin-right: auto;" class="quitgroup" type='submit' name='submit' value='Quit Group'><br>
			</form>
		</div>
		<div class="showTableDiv">
			<p class="groupTableHeader">The Group's Timetable</p>
<?php
//Initialise the free time array
$groupMemberArray=gettingGroupMember($_SESSION['groupID']);
initialiseWeekArray($freeTimeArray);
foreach ($groupMemberArray as $key => $value) {
	foreach ($value as $subkey => $subvalue) {
		initialiseWeekArray($userTimeslotArray);
		$filename=gettingFilename($subvalue);
		//echo "Filename for $subvalue is $filename<br>";
		$userTimeSlotArray = unserialize($filename);
		
		comparison($userTimeSlotArray, $freeTimeArray);
	}
}
printTableArray($freeTimeArray);
?>
</div>
		<div class="showingMembers" style="margin: 0;">
			<p>Members</p>
			<?php
				printingGroupMember($_SESSION['groupID']);
			?>
		</div>
</div>


<form action= '<?php $_SERVER['PHP_SELF']?>' method='POST'>
	<p id="addmember"  style="text-align: center;">Add Group Member: </p><input class="addmember"  style="margin: auto;" type ='text' name='username' placeholder='Username or NUSNET ID'> <br>
	<input  style="margin: auto;" class="submit" type='submit' name='submit' value='Add Member'><br>
</form>


<form action="peopledependent.php" method='POST'>
	<p id="selected"  style="text-align: center;"><br>
	<input  style="margin: auto;" class="peopledependent" type='submit' name='submit' value='Find common free slot for selected users!'><br>
</form>


</body>
</html>