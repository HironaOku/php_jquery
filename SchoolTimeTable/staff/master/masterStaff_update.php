<?php
	include('../../db_conn.php'); //db connection
	
	$userId = $_GET["userId"];
	$unitCode = $_GET["unitCode"];
	
$query = <<<query

		INSERT INTO `staff_manage`(`userID`, `unit_code`) 
		VALUES 
			("$userId", "$unitCode") ON DUPLICATE KEY 
		UPDATE 
			`unit_code` = "$unitCode"
query;

	$resultData = $mysqli -> query($query);
	$row = $resultData -> fetch_array(MYSQLI_ASSOC);
	

	$mysqli ->close();
	$query ->close();
	
?>