<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "orbital";
		
	$location = null;
	$error = false;
	
	try {
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
   			print($e->getMessage());
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Group</title>
</head>
<body>
<?php
	include("groupFunction.php");
	$usernameSession = $_SESSION['username'];
	echo "<h1>Welcome, ".$_SESSION['username']."!</h1>";
	listingAllGroups($_SESSION['username']);
?>
<br>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
	New Group Name: <input type="text" name="groupName">
	<input type="submit" name="submit">
</form>
<?php
if(!isset($_POST['groupName'])){
	exit();
} else {
	if($_POST['groupName']==''){
		echo "No name is input";
	} else {
		$groupName=$_POST['groupName'];
		creatingGroup($usernameSession, $groupName);
		echo "Click <a href='addmember.php'>here</a> to add member.";
		$_SESSION['groupName'] = $groupName;
	}
}


?>


</body>
</html>