<?php
	include('../../db_conn.php'); //db connection
	
	$staffId = $_GET["staffId"];
	$name = $_GET["name"];
	$qualification = $_GET["qualification"];
	$expertise = $_GET["expertise"];
	$unit_code = $_GET["unit_code"];
	$postM = $_GET["postM"];
	
	$pass = crypt("Dw12345!");
	
	$staffId = strip_tags($staffId);
	$name = strip_tags($name);

	$staffId = $mysqli->real_escape_string($staffId);
	$name = $mysqli->real_escape_string($name);
			
		$serchSQL="SELECT * FROM `dw_users` WHERE `userID` = '$staffId';";
		$searchRsl = $mysqli -> query($serchSQL);
		$rowtble = $searchRsl->num_rows;
		
		if ($rowtble > 0) {
			
			$rowtble ="";
			$searchRsl="";
			$msg ="staff ID exist";
			header('Location: masterStaff.php?error='.$msg.'');
			
		} else if ($staffId ==""){
			$msg ="staff ID is not entered";
			header('Location: masterStaff.php?error='.$msg.'');
		} else {
			
			
			
			
			$qur = "INSERT INTO `dw_users`(`userID`, `username`, `password`, `access`) VALUES ('$staffId','$name','$pass','$postM'); ";
			$qur2 = "INSERT INTO `user_detail`(`userID`, `qualification`, `expertise`) VALUES ('$staffId','$qualification','$expertise'); ";			
			$qur3 = "INSERT INTO `staff_manage`(`userID`, `unit_code`) VALUES ('$staffId','$unit_code'); ";
			
			
			$insert = $mysqli -> query($qur);
			$insert = $mysqli -> query($qur2);
			$insert = $mysqli -> query($qur3);
			
			$msg ="New staff has been registered!";
			header('Location: masterStaff.php?error='.$msg.'');
		}
	
	$mysqli ->close();
	$insert ->close();
	
?>