<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$unit_code = $_GET["unit_code"];
	$tutID = $_GET["tutID"];
	
	$qur = "UPDATE `student_enrl` SET `tutID` = '0' WHERE `userID`= '$userID' AND `unit_code`= '$unit_code' ";	
		
	$insert = $mysqli -> query($qur);		

	$mysqli ->close();
	
	
	
?>