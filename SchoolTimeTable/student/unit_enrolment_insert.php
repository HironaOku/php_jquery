<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$unit_code = $_GET["unit_code"];
	$lecID = $_GET["lecID"];
	
	$qur = "INSERT INTO `student_enrl` (`userID`, `unit_code`, `lecID`) VALUES ('$userID','$unit_code','$lecID'); ";	
	
	$insert = $mysqli -> query($qur);

	$mysqli ->close();
	
	
	
?>