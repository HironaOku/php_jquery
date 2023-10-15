<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$email = $_GET["email"];
	$tel = $_GET["tel"];
	$address = $_GET["address"];
	$birthday = $_GET["birthday"];
	
	$qur = "UPDATE `user_detail` SET `Email` = '$email', `tell` = '$tel', `address` = '$address', `birthday` = '$birthday' WHERE `userID` = '$userID'";	
	
	$insert = $mysqli -> query($qur);

	$mysqli ->close();
	
	
	
?>