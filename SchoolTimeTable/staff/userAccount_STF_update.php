<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$email = $_GET["email"];
	$tel = $_GET["tel"];
	$qualification = $_GET["qualification"];
	$expertise = $_GET["expertise"];
	
	$qur = "UPDATE `user_detail` SET `Email` = '$email', `tell` = '$tel', `qualification` = '$qualification', `expertise` = '$expertise' WHERE `userID` = '$userID'";	
	
	$insert = $mysqli -> query($qur);

	$mysqli ->close();
	
	
	
?>