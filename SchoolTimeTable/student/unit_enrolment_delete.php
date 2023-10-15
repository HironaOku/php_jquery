<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$unit_code = $_GET["unit_code"];
	
	$qur = "DELETE FROM `student_enrl` WHERE `userID` = '$userID' AND `unit_code` ='$unit_code'; ";
	$runSQL = $mysqli -> query($qur);
	
	$mysqli ->close();
	
?>