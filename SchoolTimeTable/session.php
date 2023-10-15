<?php
	session_start();
	
	if(!isset($_SESSION['session_userID'])){
		$_SESSION['session_userID'] = "";
	}	
	if(!isset($_SESSION['access'])){
		$_SESSION['access'] = "";
	}
	
	if(!isset($_SESSION['session_user'])){
		$_SESSION['session_user'] = "";
	}	
		
	$session_userID= $_SESSION['session_userID'];
	$session_access= $_SESSION['access'];
	$session_user= $_SESSION['session_user'];
?>