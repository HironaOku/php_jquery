<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$session_userID = $_SESSION['session_userID'];
	$userID = $_POST['S_id'];
	$oldpass = $_POST['oldpass'];
	$password = $_POST['password'];
	
	$query = "SELECT * FROM `dw_users` WHERE `userID` = '$userID';";
	
	$resultData = $mysqli -> query($query);
	$row = $resultData -> fetch_array(MYSQLI_ASSOC);
	$cryptpass = crypt($oldpass, $row['password']);
	
	if($session_userID != $userID){
			$msg ="Your userID is not correct";
			header('Location: ./userAccount_STD.php?error='.$msg.'');
			
	} else if($row['userID'] != $userID || $userID ==""){
		
		header('Location: ./userAccount_STD.php?error=Do_Not_have_a_record');
		
	} else if( hash_equals($row['password'], $cryptpass)){
			
			$password = crypt($_POST["password"]);
			
			$query = "UPDATE `dw_users` SET `password`='$password' WHERE `userID` ='$session_userID'";
			$resultData = $mysqli -> query($query);
			
			$msg ="Your password has been changed!";
			header('Location: ./userAccount_STD.php?error='.$msg.'');

		} else {
			
			//if old pass is not correct
			header('Location: ./userAccount_STD.php?error=invalid_password');
		}
	
	
	$mysqli ->close();
	
	
	
?>