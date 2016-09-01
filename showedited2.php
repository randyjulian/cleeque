<?php
	session_start();
  //$_SESSION['fullName']=gettingNameFromUsername($_SESSION['username']);
  if(!isset($_SESSION['username'])){header('Location: index.php');}
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
<style>
input.submit[type=submit] {
    width: 10%;
    background-color: #3498db;;
    color: white;
    padding: 6px 10px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
    min-width: 130px;
}

input.submit[type=submit]:hover {
    background-color: #2b3856;
    transition: 0.2s;
    color: white;
}

input.return[type=submit] {
    width: 10%;
    background-color: white;
    color: red;
    padding: 6px 10px;
    border: 1px solid red;
    margin: 8px 0;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
    min-width: 130px;
}

input.return[type=submit]:hover {
    background-color: red;
    transition: 0.2s;
    color: white;
}

input.reset[type=submit] {
    width: 10%;
    background-color: white;
    color: #EB9100;
    padding: 6px 10px;
    border: 1px solid #EB9100;
    margin: 8px 0;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Roboto";
    font-size: 15px;
    min-width: 130px;
}

input.reset[type=submit]:hover {
    background-color: #EB9100;
    transition: 0.2s;
    min-width: 130px;
    color: white;
}

</style>


<?php
include("main_ics_processer.php");
include("groupFunction.php");
$username=$_SESSION['username'];
function printEditingSchedule($array){
   echo "<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>";
   echo "<div class='showingTableToEdit'>";
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
            echo "<td class='busy'><input type='checkbox' name='userinput[$day][$subkey]' value={$day}T$subkey checked></td>";
         }

      }
      echo "</tr>";
   }
   echo "</table>";
   echo "</div>";
   echo "<input class= 'submit' type='submit' value='Submit'>";
   echo "</form>";


}  
?>

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
  <div class="main">
    <div class="mainHeaderdashboard">
      <h1 id="welcomeHeader"><?php echo $_SESSION['username'];?></h1>
      <h6 id="welcomeHeaderFullName"><?php echo $_SESSION['fullName'];?></h6>
    </div>
    <div class="editTimetable">
    <?php
      if(isset($_POST['userinput']) || $_SESSION['form']==true){
        $icsArray = $_SESSION['icsArray'];
        foreach($icsArray as $day=>$subkey){
          foreach($subkey as $timeslot => $value){
            $icsArray[$day][$timeslot]=0;
          }
        }
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
    
    <form action="reset.php" method="POST" style="display: none;">
        <input class= "reset" type="submit" name="submit" value="Reset Timetable">
    </form>

    <form action="loginPage.php" method="POST">
        <input class= "return" type="submit" name="submit" value="Cancel">
    </form>
    </div>
  </div>

</body>
</html>
