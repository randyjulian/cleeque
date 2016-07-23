<?php
include("icstoarray.php");
class user{
	public $name="";
	public $file="";
	public $weekArray;
	public function __construct($file){
		$this->file = $file;
	}

	public function allfunctionsprocessing(){
		$this->setNameUsingFilename();
		$this->checkingInfo();
		$this->gettingWeekArray();
		$this->printingArray();
	}
	public function checkingInfo(){
		echo "Name: $this->name<br>";
		echo "file: $this->file<br>";
	}

	//Function to derive name from the file name;
	public function setNameUsingFilename(){
		$this->name=substr_replace($this->file, "",-4,4);
		echo $this->name."<br>";
		echo "in<br>";
	}

	public function gettingWeekArray(){
		fillingArray($this->file, $this->weekArray);
	}

	public function printingArray(){
		testPrintArray($this->weekArray);
	}
}

function comparison($array1, &$freeTimeArray){
	foreach($array1 as $key1  => $value1){
		foreach ($freeTimeArray as $key2 => $value2) {
			if($key1==$key2){
				foreach ($value1 as $subkey1 => $subvalue1) {
					foreach ($value2 as $subkey2 => $subvalue2) {
						if($subkey1==$subkey2){
								$freeTimeArray[$key1][$subkey1]+=$subvalue1;
						}
					}
				}
			}
		}
	}
}



function initialiseWeekArray(& $arrayInput){
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
   $arrayInput = array(
         "Monday" => $dayArray,
         "Tuesday" => $dayArray,
         "Wednesday" => $dayArray,
         "Thursday" => $dayArray,
         "Friday" => $dayArray,
         "Saturday" => $dayArray,
         "Sunday" => $dayArray);
}
//Creating $freeTimeArray where 0 means free
function doingComparison($userArray, $freeTimeArray){



//creating 2 objects. 
/*
$user1 = new user("sample.ics");
$user1->allfunctionsprocessing();
$user2 = new user("sample2.ics");
$user2->allfunctionsprocessing();*/


comparison($userArray, $freeTimeArray);
//comparison($user2->weekArray, $freeTimeArray);
echo "<br><br>=======Free Time Array=======<br><br>";
//Function below is from icsToArray.php
/*testPrintArray($freeTimeArray);
for($i=0;$i<5;$i++){
	${'value'.$i}=$i;
}
echo $user2->name;*/

}


?>