<?php
	include('../../db_conn.php'); //db connection
	
	$id = $_GET["id"];
	$day = $_GET["day"];
	$startTime = $_GET["startTime"];
	$duration = $_GET["duration"];
	$lecturer = $_GET["lecturer"];
	$location = $_GET["location"];
	$room = $_GET["room"];
	
	$qur = "UPDATE `lec_manage` SET `date` = '$day', `starttime` = '$startTime', `duration` = '$duration', `location` = '$location', `room` = '$room', `lecturor` = '$lecturer' WHERE `id` = '$id'";
	
	$update = $mysqli -> query($qur);
			
	$mysqli ->close();
	
?>