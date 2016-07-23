<?php
	session_start();
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
		
	$location = null;
	$error = false;
	
	try {
    $database = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
   		if ($e -> getcode() == 23000) {
   		echo "The username has already exist.";	
   		}
   		else {
   			print($e->getMessage());
   		}
    
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Schedule</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
<?php
include("main_ics_processer.php");
function printEditingSchedule($array){
   echo "<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>";
   echo "<table>";
   echo "<tr>"; // start of headers
   echo "<td class='header'></td>";
   foreach($array["Monday"]as $subkey=>$subvalue){
      echo "<td class='header'>".$subkey."</td>";
   }
   echo"</tr>";

   foreach($array as $day=>$value){
      //start of printing the values
      echo "<tr>";
      echo "<td class='day'>".$day."</td>"; // print day
      foreach($value as $subkey=>$subvalue){
         if($subvalue==0){
            echo "<td class='free'><input type='checkbox' name='userinput[$day][$subkey]' value={$day}T$subkey></td>";
         } else {
            echo "<td class='busy'>BUSY!</td>";
         }

      }
      echo "</tr>";
   }
   echo "</table>";
   echo "<input type='submit' value='Submit'>";
   echo "</form>";
   echo "<form action='group.php'>";
   		echo "<input type='submit' value='Confirm'>";
   echo "</form>";
}


	echo "Welcome, ".$_SESSION['username']."<br>";
	$icsArray = $_SESSION['icsArray'];
	foreach($_POST['userinput'] as $day=>$subkey){
		//echo "$day<br>";
		foreach($subkey as $timeslot => $value){
		//echo "$timeslot : $value<br>";
		$icsArray[$day][$timeslot]=1;
  }
}
	printEditingSchedule($icsArray);
  $_SESSION['icsArray']= $icsArray;
  $usernameSession = $_SESSION['username'];
  $serialisedArray=serialize($icsArray);
  $sql="UPDATE userid SET filename= '$serialisedArray' WHERE username='$usernameSession'";
  $stmt = $database->prepare($sql);
  $stmt->execute();
?>

</body>
</html>