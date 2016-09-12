<?php

function icsToArray($paramUrl) {
   $icsFile = file_get_contents($paramUrl);
   /*echo $icsFile;*/
   $icsData = explode("BEGIN:", $icsFile);

   foreach($icsData as $key => $value) {
      $icsDatesMeta[$key] = explode("\n", $value);
   }

   foreach($icsDatesMeta as $key => $value) {
      foreach($value as $subKey => $subValue) {
         if ($subValue != "") {
            if ($key != 0 && $subKey == 0) {
               $icsDates[$key]["BEGIN"] = $subValue;
            } else {
               $subValueArr = explode(":", $subValue, 2);
               if (! isset($subValueArr[1])) {$subValueArr[1] = null;}
                    $icsDates[$key][$subValueArr[0]] = $subValueArr[1];
            }
         }
      }
   }

   return $icsDates;
}
/* Not required
   function dateBreaker($date){
   $dateBroken= explode("T",$date);
   return $date = array("DATE"=>$dateBroken[0],"TIME"=>$dateBroken[1]);
   }
 */

//covertTime converts time string into time object. 
function convertTime($time0){
   date_default_timezone_set("Asia/Singapore");
   $timeFromString= strtotime($time0);
   return $timeFromString;
}

function changeArray($event, &$array){
   $valuesummary = isset($event['SUMMARY']) ? $event['SUMMARY'] : '';
   $valueDTSTART = isset($event['DTSTART']) ? $event['DTSTART'] : '';
   $valueDTEND = isset($event['DTEND']) ? $event['DTEND'] : '';
   $valueDTSTART2 = isset($event['DTSTART2']) ? $event['DTSTART2'] : '';
   if(strpos($valuesummary, "Exam")!=false){
      return;
   } else {
      //To process the data that has been added when users edit their timetable
      if($valuesummary == "EDITED"){
         $day=substr($valueDTSTART2,0,-5);
         $timeSlot=substr($valueDTSTART2, -4);
         //echo "day = $day<br>";
         //echo "timeSlot = $timeSlot<br>";
         $array[$day][$timeSlot] = 1;
      } else {
   $timeBegin=convertTime( $valueDTSTART);
   $day=date("l",$timeBegin);
   $startTimeHour=date("H", $timeBegin);
   $startTimeMin=date("i", $timeBegin);
   $timeStop=convertTime($valueDTEND);
   $endTimeHour=date("H",$timeStop);
   $endTimeMin=date("i",$timeStop);
   //calculate the interval in min.
   $interval = 60*($endTimeHour-$startTimeHour) + ($endTimeMin-$startTimeMin);
   if($interval==0){
      return;
   }
   //echo $day."<br>";
   //echo $startTimeHour."<br>";
   //echo "interval: ".$interval." mins<br>";
   //find the time slot
   $mins=30;
   $timeSlot=$startTimeHour.$startTimeMin;
   //echo $timeSlot."first<br>";
   $array[$day][$timeSlot] = 1;
   //echo "Array Value== ".$array[$day][$timeSlot]."<br>";
   $count=1; //$count is used to count the number of times it loops through the while condition.
   while($count<($interval/30)){ 
      //If condition is implemented in the case that the minute == 60. However, there are a few assumptions: 
      //1) The end time doesn't cross midnight. 
      //2) The time always starts at 00 or 30 mins. 
      //These 2 assumptions would be taken into consideration later once th code is done. 
      if($startTimeMin+$mins == 60){
         $startTimeHour++; //Hour increases;
         $startTimeMin="00"; // Min goes back to 0;
      } else{
         $startTimeMin+=$mins; // if the min == 00, then min+=30.
      }
      $timeSlot=sprintf("%02d",$startTimeHour).$startTimeMin; // Combine string. sprintf is used for adding "0" in front of a single digit $startTimeHour;
      $array[$day][$timeSlot] = 1;//Initialise this slot to 1 or "busy";
      //echo "timeSlot== ".$timeSlot."<br>";
      //echo "Array Value== ".$array[$day][$timeSlot]."<br>";

      $count++;//updating count
   }
   }
   }  

}

//function to print out an array
function printArray($array){
   foreach($array as $key=>$value){
      echo $key.": ".$value."<br>";

      foreach($value as $subkey=>$subvalue){
         echo $subkey.": ".$subvalue."<br>";

      }
   }
}

function printTableArray($array,$numberOfPeople){
   echo "<table>";
   echo "<tr>";
   echo "<td></td>";
   foreach($array["Monday"]as $subkey=>$subvalue){
      echo "<td>".$subkey."</td>";
   }
   echo"</tr>";

   foreach($array as $key=>$value){
     
      echo "<tr>";
      echo "<td>".$key."</td>";
      foreach($value as $subkey=>$subvalue){
         if($subvalue==0){
            echo "<td class='free'></td>";
         } else {
            $opacity = (($subvalue/$numberOfPeople)*0.8) + 0.2;
            echo "<td class='busy' style='opacity: $opacity' id='$key $subkey'></td>";
         }

      }
      echo "</tr>";
   }
   echo "</table>";
}


function testPrintArray($array){
   foreach($array as $key=>$value){
      echo "========".$key."========<br>";
      foreach($value as $subkey=>$subvalue){
         if($subvalue==0){
            echo $subkey.": ".$subvalue."<br>";
         }
      }
   }
}

function fillingArray($file, &$weekArray){

   $icsarrays = icsToArray($file);
   $count=0;

   //Array for the day.
   $dayArray = array(
         "0600"=>0,
         "0630"=>0,
         "0700"=>0,
         "0730"=>0,
         "0800"=>0,
         "0830"=>0,
         "0900"=>0,
         "0930"=>0,
         "1000"=>0,
         "1030"=>0,
         "1100"=>0,
         "1130"=>0,
         "1200"=>0,
         "1230"=>0,
         "1300"=>0,
         "1330"=>0,
         "1400"=>0,
         "1430"=>0,
         "1500"=>0,
         "1530"=>0,
         "1600"=>0,
         "1630"=>0,
         "1700"=>0,
         "1730"=>0,
         "1800"=>0,
         "1830"=>0,
         "1900"=>0,
         "1930"=>0,
         "2000"=>0,
         "2030"=>0,
         "2100"=>0,
         "2130"=>0,
         "2200"=>0,
         "2230"=>0,
         "2300"=>0,
         "2330"=>0);
   // Array for the weekArray
   $weekArray = array(
         "Monday" => $dayArray,
         "Tuesday" => $dayArray,
         "Wednesday" => $dayArray,
         "Thursday" => $dayArray,
         "Friday" => $dayArray,
         "Saturday" => $dayArray,
         "Sunday" => $dayArray);
   //for printing the array
   foreach($icsarrays as $x=>$a){
      $count++;
      //echo "<br><br>====== section {$x} ======<br>";
      foreach($a as $b=>$c){
         /* if ($b== "SUMMARY" || $b== "RRULE" ||$b=="DTSTART" || $b=="DTEND" || $b== "EXDATE" || $count==1) {
            echo $b.": ".$c."\n";
            }*/
         if ($b== "SUMMARY" || $b== "RRULE"|| $count==1) {
            //echo $b.": ".$c."<br>";
         } else {
            if ($b=="DTSTART" || $b=="DTEND"|| $b== "EXDATE") {
               /*echo date("Y/m/d l h:i", convertTime($c))."\n";
                 $dateArray=dateBreaker($c);
                 foreach ($dateArray as $key => $value) {
                 echo $b." ".$key.": ".$value."\n";*/

               //Printing our DATE and TIME
               $convertedTime = convertTime($c);
               //echo $b." "."DATE :".date("Y/m/d l", $convertedTime)."<br>";
               //echo $b." "."TIME :".date("H"."i", $convertedTime)."<br>";


            }
         }

      }

   }
   foreach($icsarrays as $key=>$eventNo){
      //echo "key: ".$key."<br>";
      changeArray($eventNo, $weekArray);
   }
   //echo "***************"."Busy Schedule"."***************<br>";
   //testPrintArray($weekArray);
}

//Outside function
/*$file= "sample.ics";
if($_SERVER["REQUEST_METHOD"]=="POST"){
   $file = $_POST["fileUpload"];
}
fillingArray($file, $weekArray);*/
?>
