<?php
	include('../../db_conn.php'); //db connection
	
	$id = $_GET["id"];
	
	$qur = "DELETE FROM `cnsl_manage` WHERE `id`='$id' ; ";
	$runSQL = $mysqli -> query($qur);
	
	$mysqli ->close();
	
?>