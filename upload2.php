<?php
session_start();
if(!isset($_SESSION['username'])){header('Location: index.php');}
include("databaseconnection.php");
include("main_ics_processer.php");

function printEditingSchedule($array){
   echo "<form action='showedited2.php' method='post' enctype='multipart/form-data'>";
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
            echo "<td class='free'><input type='checkbox' name='userinput[$day][$subkey]' value=1></td>";
         } else {
            echo "<td class='busy'>BUSY!</td>";
         }

      }
      echo "</tr>";
   }
   echo "</table>";
   echo "<input type='submit' value='Submit'>";
}

//print_r($_FILES['fileToUpload']);
$fileType = pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);
if($fileType== 'ics'){
   fillingArray($_FILES['fileToUpload']['tmp_name'],$userTimeslotArray);
   $_SESSION['icsArray'] = $userTimeslotArray;
   initialiseWeekArray($freeTimeArray);
   comparison($userTimeslotArray, $freeTimeArray);
   $usernameSession = $_SESSION['username'];
  $serialisedArray=serialize($freeTimeArray);
  $sql="UPDATE userid SET filename= '$serialisedArray' WHERE username='$usernameSession'";
  $stmt = $database->prepare($sql);
  $stmt->execute();
   //printEditingSchedule($freeTimeArray);
   header('Location: loginPage.php');
} else {
   echo '<script>alert("Ops! That is not ics file!");window.location.href="dashboard.php"</script>';
   
}
?>