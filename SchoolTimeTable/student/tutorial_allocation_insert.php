<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$userID = $_SESSION['session_userID'];
	$unit_code = $_GET["unit_code"];
	$tutID = $_GET["tutID"];
	
	//before update check the available
	$qur="SELECT COUNT(`tutID`) AS 'numTut' FROM `student_enrl` WHERE `tutID` = '$tutID'";
	$num = $mysqli -> query($qur);
	foreach ($num as $row) {
		$regiNum = $row['numTut'];
	}
	
	//get capacity
	$qur="SELECT `capacity` FROM `tut_manage` WHERE `id` = '$tutID'";
	$num2 = $mysqli -> query($qur);
	foreach ($num2 as $row) {
		$capa = $row['capacity'];
	}
	
	
	$num = $capa-$regiNum;
	if($num <= 0){
		header('Location: ./tutorial_allocation.php?error=unavailable');
	}else{
		$qur = "UPDATE `student_enrl` SET `tutID` = '$tutID' WHERE `userID`= '$userID' AND `unit_code`= '$unit_code' ";	
		
		$insert = $mysqli -> query($qur);
		
	}


	$mysqli ->close();
	
	
	
?>