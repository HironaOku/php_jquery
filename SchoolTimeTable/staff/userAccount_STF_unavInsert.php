<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$unavDay = $_GET["unavDay"];
	$unavTime = $_GET["unavTime"];
	$unavTimeend = $_GET["unavTimeend"];
	
	$qur = "INSERT INTO `staff_unavailable`(`userID`, `day`, `stat_time`, `end_time`) VALUES ('$userID','$unavDay','$unavTime','$unavTimeend')";	
	
	$insert = $mysqli -> query($qur);
	
	$msg ="Your unavailabe day uploaded!";
	header('Location: ./userAccount_STF.php?error='.$msg.'');
	$mysqli ->close();
	
	
	
?>