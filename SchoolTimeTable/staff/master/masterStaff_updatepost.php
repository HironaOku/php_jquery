<?php
	include('../../db_conn.php'); //db connection
	
	$userId = $_GET["userId"];
	$post = $_GET["post"];
	
$query = <<<query

	UPDATE 
		`dw_users` 
	SET 
		`access` = "$post"
	WHERE 
		`userID` = "$userId"
	
query;

	$resultData = $mysqli -> query($query);
	

	$mysqli ->close();
	$query ->close();
	
?>