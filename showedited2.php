<?php
	session_start();
  //$_SESSION['fullName']=gettingNameFromUsername($_SESSION['username']);
  //if(!isset($_SESSION['username'])){header('Location: index.php');}
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script type="text/javascript" src="main.js"></script>
  <title>Cleeque | Editing Schedule</title>
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <meta name="theme-color" content="#ffffff">
  <link type="text/css" rel="stylesheet" href="style.css"></link>
  <!---Fonts-->
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
</head>
<body> 
</head>
<body>
<?php
include("main_ics_processer.php");
include("groupFunction.php");
$username=$_SESSION['username'];
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
}  
?>

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
  <div class="editTimetable">
    <?php
      if(isset($_POST['userinput']) || $_SESSION['form']==true){
        $icsArray = $_SESSION['icsArray'];
        foreach($_POST['userinput'] as $day=>$subkey){
        //echo "$day<br>";
          foreach($subkey as $timeslot => $value){
          //echo "$timeslot : $value<br>";
          $icsArray[$day][$timeslot]=1;
          unset($_SESSION['form']);
          header('Location: loginPage.php');
          }
        }
      } else {
        $username=$_SESSION['username'];
        $sql= "SELECT filename FROM userid WHERE username='$username' ";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        $result= $stmt->fetchColumn();
        if(count($result)==1){
          $icsArray = unserialize($result);
          echo $icsArray;
        }
      }
      printEditingSchedule($icsArray);
      $_SESSION['icsArray']= $icsArray;
      $usernameSession = $_SESSION['username'];
      $serialisedArray=serialize($icsArray);
      $sql="UPDATE userid SET filename= '$serialisedArray' WHERE username='$usernameSession'";
      $stmt = $database->prepare($sql);
      $stmt->execute();
      $_SESSION['form']=true;
    ?>
    <a href="loginPage.php">Go Back</a>
  </div>
  <div class="footer">
    <p style="text-align: left;"> &copy Cleeque 2016</p>
  </div>

</body>
</html>
