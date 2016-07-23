<?php
session_start();
include("groupFunction.php");
include("main_ics_processer.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
<h1> Welcome, <?php echo $_SESSION['username'];?>!</h1>
<?php 
	if(isset($_POST['submit']) && !isset($_SESSION['groupID'])){
	$_SESSION['groupID']=$_POST['groupNameSelected'];
	} else {
		if(!isset($_SESSION['groupID'])&& !isset($_POST['submit'])){
		echo "Error! No group was selected!";
		exit();
		}
	}
?>
<h2>The current group is "<?php echo gettingGroupNameFromID($_SESSION['groupID']);?> "</h2>
<h2>The current group ID is <?php echo $_SESSION['groupID'];?></h2>
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