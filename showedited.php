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
	//$_POST['userinput'];
	//print_r($_POST);
	//echo "<br>";
	$username=$_SESSION['username'];
	echo $username."<br>";
	$sql= "SELECT filename FROM userid WHERE username= '$username'";
	$stmt = $database->prepare($sql);
	$stmt->execute();
	$dataArray= $stmt->fetch(PDO::FETCH_ASSOC);
	$filename=$dataArray['filename'];
	echo $filename."<br>";
	$icsfile=fopen("uploads/{$filename}","a+") or die("Error has occured. Cannot open file!");
	foreach($_POST['userinput'] as $day=>$subkey){
		//echo "$day<br>";
		foreach($subkey as $timeslot => $value){
		//echo "$timeslot : $value<br>";
		fputs($icsfile, "
BEGIN:VEVENT
SUMMARY:EDITED
DTSTART2:$value
END:VEVENT
END:VCALENDAR");
	}
	}
	fclose($icsfile);
	$userFreeTimeArray  = array();
	fillingArray("uploads/{$filename}", $userFreeTimeArray);
	printEditingSchedule($userFreeTimeArray);

	

?>

</body>
</html>