<?php
session_start();
if(!isset($_SESSION['username'])){header('Location: index.php');}
include("groupFunction.php");
include("main_ics_processer.php");

if(isset($_GET['submit']) && !isset($_GET['groupID'])){
	$_SESSION['groupID']=$_GET['groupNameSelected'];
	$groupID = $_SESSION['groupID'];

	//member Status: 0 not a member, 1 exist and not pending, 2 pending member
	$memberStatus = checkingUsernameExistInGroup($groupID, $_SESSION['username']);
	if($memberStatus== 0 || $memberStatus == 2){
		$groupMember = false ; // For pending member and those haven't joined the group.
	} else {
		$groupMember = true;
	}
} else {
	if(!isset($_SESSION['groupID'])&& !isset($_POST['submit'])){
		header("Location: loginPage.php");
	}
};


//This is for adding member.
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
	<script type="text/javascript">
		$(document).ready(function(){
			var $selectedSlot; //The selected cell on the table
			var $xhr;
		$('.busy').mouseenter(function(event){
			event.preventDefault();
			var dataObject = {};
			$selectedSlot = this;
			dataObject['value']= $(this).attr('id');
			//AJAX REQUEST!//
			$xhr = $.ajax({
			url: 'timeDependent.php',
			type: 'POST',
			data: dataObject,
			dataType: 'text',
			success: function(response){
				var obj = JSON.parse(response);
				console.log(obj);
				$('.busy').css('background-color','#3c3c3c'); //Revert background color back;
				$('.memberList').css('background-color','#e3f1e2'); //Green colour for free ppl.
				$('.memberList').css('color','#63b252'); //Green colour for free ppl.
				obj.forEach(function(item){
					id = "#".concat(item);
					$(id).css("background-color", "##f7e9e8"); //Red colour for busy ppl.
					$(id).css("color", "##f44336"); //Red colour for busy ppl.
				});
				id = '#'+dataObject['value'];
				$($selectedSlot).css('background-color', '#ffc107');//The background-color of selected cell;

			},
			error: function(response, status,thrown){
				$("#errorMessage").text("Error! Please try again later. If the problem persists, please contact us!");
				
			}
			});
		});
		$('.busy').mouseleave(function(){
			$xhr.abort();
			$('.memberList').css('background-color','white'); //Revert back to original color;
			$('.memberList').css('color','#3498db'); // Revert back to original color;
			$($selectedSlot).css('background-color','#3c3c3c'); //Revert background color back;
		});
	});		



	</script>
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
		font-size: 25px;
		text-align: center;
		clear: both;
	}


	.memberList{
		background-color: white;
		padding: 5px;
		color: #3498db;
		display: inline-block;
		width: 31%;
		max-width: 250px;
		text-align: center;
		border-radius: 7px;
		border: 1px solid;
		transition: 0.2s;
		overflow: hidden;
	}

		
	.usernameDescription{
		font-size: 20px;
		margin: 0;
	}

	.nameDescription{
		color: #999999;
		font-family: "Roboto";
		font-style: italic;
		font-size: 15px;
		margin: 0;
		overflow: hidden;
	}

	#memberHeaders{
		margin: 0;
		font-size: 20px;
		margin-bottom: 10px;
	}

	.opacityDescription{
		display: inline-block;
		font-family: "Montserrat";
	}

	/*This section is taken from peopledependent.php to style member approval form.*/
	#pendingPeopleSubmitButton{
	    width: 10%;
	    background-color: white;
	    color: #3498db;
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
			<?php if($memberStatus==1){  //If in the group, Quit Group appears.?> 
			<form action="exitGroup.php" method='POST'>
				<p id="addmember"  style="text-align: center;">
				<input  style="margin-left: auto; margin-right: auto; min-width: 120px;" class="quitgroup" type='submit' name='submit' value='Quit Group'><br>
				</p>
			</form>
			<?php } elseif ($memberStatus==0) { //not in the group, Join Group appears.?>
			<form action="joinGroup.php" method='POST'>
				<p id="addmember"  style="text-align: center;">
				<input  style="margin-left: auto; margin-right: auto; min-width: 120px;" class="quitgroup" type='submit' name='submit' value='Join Group'><br>
				</p>
			</form>
			<?php } else { //Pending Approval appears. ?> 
				<p id="addmember"  style="text-align: center;">
				<input  style="margin-left: auto; margin-right: auto; min-width: 160px; cursor:default;" class="quitgroup" type='submit' name='submit' value='Pending Approval'><br>
				</p>

			<?php } ?>
		</div>
		<div class="showTableDiv">
		<div>
			<p style="margin-bottom: 0;" class="groupTableHeader">The Group's Timetable</p>
			<!--<p style="text-align: center; margin-top: 0; font-family: 'Montserrat'; font-size:13px; margin-bottom: 5px;">Darker slots mean more people are not available</p>-->
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
$numberOfPeople = count($groupMemberArray);
$width= 300/($numberOfPeople+1);
$cellWidth = $width.'px';
echo "<div class='opacityTableDiv' style='height: 30px;'>";
echo "<p class='opacityDescription' style='margin-right: 8px;'>0/".$numberOfPeople." Free</p>";
echo "<table class='opacityTable'>";
echo "<tr>";
echo "<td style='background-color: white; width: $cellWidth;' ></td>";
for ($i=1; $i < $numberOfPeople ; $i++) { 
	$opacity = (($i/$numberOfPeople)*0.8) + 0.2;
    echo "<td class='busyHeader' style='opacity: $opacity; width: $cellWidth; '></td>";
}
echo "<td class='busyHeader' style='width: $cellWidth;'></td>";
echo "</tr>";
echo "</table>";
echo "<p class='opacityDescription' style='margin-left: 8px;'>".$numberOfPeople."/".$numberOfPeople." Free</p>";
echo "</div>";
?>
		<p style="margin-top:0; text-align: center; font-size: 12px; font-family: 'Montserrat';">Hover your cusor on a busy slot and wait a moment to see who are busy for that time!</p>
	</div>
	<div style="overflow-x:scroll;">
<?php
if(!$groupMember){
	initialiseWeekArray($freeTimeArray); 
}
printTableArray($freeTimeArray,$numberOfPeople);
?>
	</div>
	</div>
			<div class="showingMembers" style="margin: 0;">
				<p id="memberHeaders">Members</p>
				<?php
					printingGroupMember($_SESSION['groupID']);
				?>
			</div>
			<?php if($groupMember){?>
			<div class="showingPendingPeople">
				<p style='font-size: 20px; margin-top: 0px;'>Pending Request</p> 
				<?php 
					printingPendingPeople($_SESSION['groupID']);
				?>
			</div>
			<? } //closing the bracket?> 
	</div>

<!-- If the user isn't a member, the seciton below wouldn't appear-->
<?php if($groupMember){?>
<form action= '<?php $_SERVER['PHP_SELF']?>' method='POST'>
	<p id="addmember"  style="text-align: center;">Add Group Member: </p><input class="addmember"  style="margin: auto;" type ='text' name='username' placeholder='Username or NUSNET ID'> <br>
	<input  style="margin: auto;" class="submit" type='submit' name='submit' value='Add Member'><br>
</form>


<form action="peopledependent.php" method='POST'>
	<p id="selected"  style="text-align: center;"><br>
	<input  style="margin: auto;" class="peopledependent" type='submit' name='submit' value='Find common free slot for selected users!'><br>
</form>

<?php } ?>


</body>
</html>
