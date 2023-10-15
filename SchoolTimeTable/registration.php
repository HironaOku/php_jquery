<?php
	
	include('db_conn.php'); //db connection
	
	if(isset($_POST["Name"])){
		
		if($_POST["StaffId"] != ""){
			$access = "STF";
			$userID = $_POST["StaffId"];
			$qualification = $_POST["qualification"];
			$expertise = $_POST["expertise"];
		}else{
			$access = "STD";
			$userID = $_POST["StudentId"];
		}
		
		$userName = $_POST["Name"];
		$pass = crypt($_POST["password"]);
		$email = $_POST["email"];
		$tell = $_POST["tel"];
		$address = $_POST["address"];
		$birthday = $_POST["birthday"];
		
		$userID = strip_tags($userID);
		$userID = $mysqli->real_escape_string($userID);
		
		
		
		$serchSQL="SELECT * FROM `dw_users` WHERE `userID` = '$userID';";
		$searchRsl = $mysqli -> query($serchSQL);
		$rowtble = $searchRsl->num_rows;
		
		if ($rowtble > 0) {
			
			$rowtble ="";
			$searchRsl="";
			$msg ="student ID or staff ID exist";
			header('Location: registration_form.php?error='.$msg.'');
		} else {
		
			$qur = "INSERT INTO `dw_users`(`userID`, `username`, `password`, `access`) VALUES ('$userID','$userName','$pass','$access'); ";
			
			$qur2 = "INSERT INTO `user_detail`(`userID`, `Email`, `tell`, `address`, `birthday`, `qualification`, `expertise`) VALUES ('$userID','$email','$tell','$address','$birthday','$qualification','$expertise'); ";
			
			
			$insert = $mysqli -> query($qur);
			$insert = $mysqli -> query($qur2);
			
			$msg ="Your account has been registered!";
			header('Location: index.php?success='.$msg.'');
		}
		
	
	
	}
	
	$mysqli ->close();
	$searchRsl ->close();
	
?>