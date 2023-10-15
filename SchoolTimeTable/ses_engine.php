<?php
	include("session.php");
	include("db_conn.php");
	
	$userID = $_POST['S_id'];
	$pass = $_POST['password'];
	
	
	$userID = strip_tags($userID);
	$userID = $mysqli->real_escape_string($userID);
	
	$pass = strip_tags($pass);
	$pass = $mysqli->real_escape_string($pass);
	
	$query = "SELECT * FROM `dw_users` WHERE `userID` = '$userID';";
	echo ($query);
	
	$resultData = $mysqli -> query($query);
	$row = $resultData -> fetch_array(MYSQLI_ASSOC);
	
	
	if($row['userID'] != $userID || $userID ==""){
		header('Location: ./login.php?error=Do_Not_have_a_record');
	} else {
		$cryptpass = crypt($pass, $row['password']);
		if(hash_equals($row['password'], $cryptpass)){
			$session_userID = $row['userID'];
			$session_user = $row['username'];
			$session_access = $row['access'];
			$_SESSION['session_userID'] = $session_userID;
			$_SESSION['session_user'] = $session_user;
			$_SESSION['access'] = $session_access;
			header('Location: ./ses_success.php');
			
		} else {
			header('Location: ./login.php?error=invalid_password');
		}
	}
	
$mysqli ->close();
$resultData ->close();
?>