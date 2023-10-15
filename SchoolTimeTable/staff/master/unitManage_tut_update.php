<?php
	include('../../db_conn.php'); //db connection
	$unitCode = $_GET["unit"];
	$campus = $_GET["campus"];
	$semester = $_GET["semester"];
	$id = $_GET["id"];
	$day = $_GET["day"];
	$startTime = $_GET["startTime"];
	$duration = $_GET["duration"];
	$lecturer = $_GET["lecturer"];
	$location = $_GET["location"];
	$room = $_GET["room"];
	$capacity = $_GET["capacity"];
	
	switch ($semester) {
		case "Semester 1": 
			$semester = "1";
			break;
		case "Semester 2": 
			$semester =  "2";
			break;
		case "Winter School": 
			$semester =  "3";
			break;
		case "Spring School": 
			$semester =  "4";
			break;
	}
	
	//for new cnsl- update
	if(strpos($id,'newTut') !== false){
		$qur = "INSERT INTO `tut_manage`(`unit_code`, `campus`, `semester`, `date`, `starttime`, `duration`, `location`, `room`, `tutor`,`capacity`) VALUES ('$unitCode','$campus','$semester','$day','$startTime','$duration','$location','$room','$lecturer','$capacity')";
		
	} else {
		$id = str_replace('tut', '', $id);
		$qur = "UPDATE `tut_manage` SET `unit_code` = '$unitCode', `campus` = '$campus', `semester` = '$semester', `date` = '$day', `starttime` = '$startTime', `duration` = '$duration', `location` = '$location', `room` = '$room', `capacity` = '$capacity', `tutor` = '$lecturer' WHERE `id` = '$id' ";
	}
	
	
	$update = $mysqli -> query($qur);
			
	$mysqli ->close();
	
?>