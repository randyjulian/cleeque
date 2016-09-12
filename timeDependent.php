<?php 
	session_start();
	include("groupFunction.php");
	include("main_ics_processer.php");
	$postedInfo = $_POST['value'];
	$value = explode(" ", $postedInfo);
	$daySelected = $value[0];
	$timeSelected = $value[1];
	$groupMemberArray = gettingGroupMember($_SESSION['groupID']);

	//Busy people IDs => Will be parsed back.
	$busyPeopleString = "";

	//Looping through everybody in the group 
	foreach ($groupMemberArray as $key => $value) {
		foreach ($value as $subkey => $subvalue) {
			$filename=gettingFilename($subvalue); // Getting their serialised ics array
			$userTimeSlotArray = unserialize($filename); //Unserialised the code
			if($userTimeSlotArray[$daySelected][$timeSelected] == 1){
				$busyPeopleString .= $subvalue."N";
			} 
		}
	}

	$busyPeopleArray = explode("N", $busyPeopleString);
	unset($busyPeopleArray[count($busyPeopleArray) - 1]);

	//Encode for sending back to addmember.php AJAX code
	echo json_encode($busyPeopleArray);

?>
