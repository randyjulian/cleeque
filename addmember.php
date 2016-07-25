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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cleeque | Group</title>
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>

<div class="navbar">
		<img id="logo" src="http://i.imgur.com/NXXGa4e.png" height="35" width="35" style="float: left; margin-top: 6.4px;"><p id= "cleeque" style="margin-top:0px;" >  CLEEQUE</p> 
		<div class="menu" style="float:right;">
			<div class="mainMenu">
				<p >Home</p>
				<p>About</p>
				<p>Contact Us</p>
			</div>
			<a id="usernameNav" style="text-decoration:none;" href="logout.php">Log Out</a>
			<p id="responsiveNavButton"> &#9776; Menu</p>
		</div>
</div>	

<div class="mainGroup">
		<div class="mainHeadergroup">
			<h1 id="welcomeHeader"><?php echo gettingGroupNameFromID($_SESSION['groupID']);?></h1>
			<h6 id="welcomeHeaderFullName">The current group ID is <?php echo $_SESSION['groupID'];?></h6>
		</div>
		<div class="showingMembers" style="margin: 0;">
			<p>Members</p>
			<?php
				printingGroupMember($_SESSION['groupID']);
			?>
		</div>
</div>

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
    width: 30%;
    background-color: #3498db;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
	}
	input.submit[type=submit]:hover {
    background-color: #2b3856;
    transition: 0.2s;
	}
</style>
<form action= '<?php $_SERVER['PHP_SELF']?>' method='POST'>
	<p id="addmember">Add Group Member: </p>><input class="addmember" type ='text' name='username' placeholder='Username'>
	<input class="submit" type='submit' name='submit' value='Add Member'>
</form>
<?php
if (!isset($_POST['username'])) {
	//$error=true;
	} else{
		if($_POST['username']==''){
			echo "No name is input!<br>";
		} else {
			$usernameAdded=$_POST['username'];
			$useridNotExist=checkingUsernameExistInUserid($usernameAdded);
			if(!$useridNotExist){
				$userNotInGroup=checkingUsernameExistInGroup($_SESSION['groupID'],$usernameAdded);
				if(!$userNotInGroup){
			addingGroupMember($_SESSION['groupID'],$usernameAdded);
			echo "$usernameAdded is added!<br>";
		}
		}
			//echo $_SESSION['groupID'];
	}
}
?>
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
<h2>Click <a href="peopledependent.php">here</a> to get the schedule for selected users only</h2>

</body>
</html>