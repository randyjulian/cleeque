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

<div class="main">
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

<form action= '<?php $_SERVER['PHP_SELF']?>' method='POST'>
	Add Group Member: <input type ='text' name='username' placeholder='Username'>
	<input type='submit' name='submit' value='Add Member'>
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
<h2> Current Group Members: </h2>
<?php printingGroupMember($_SESSION['groupID']);?>
<h1> The Common Free Time Slot For All Group Members!</h1>
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