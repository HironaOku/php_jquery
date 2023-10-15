<?php
	include('../../db_conn.php'); //db connection
	
	$userId = $_GET["userId"];
	
if($userId != ""){
	header('Location: ./masterStaff_delete.php?error=error');	
}

	$query1 = "DELETE FROM `dw_users` WHERE `userID` = '$userId' ";
	$resultData = $mysqli -> query($query1);
	
	$query1 = "DELETE FROM `staff_manage` WHERE `userID` = '$userId' ";
	$resultData = $mysqli -> query($query1);
	
	$query1 = "DELETE FROM `staff_unavailable` WHERE `userID` = '$userId' ";
	$resultData = $mysqli -> query($query1);
	
	$mysqli ->close();

	//header('Location: ./masterStaff_delete.php?error=deleted');	


	
?>