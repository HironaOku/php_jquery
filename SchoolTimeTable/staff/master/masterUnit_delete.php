<?php
	include('../../db_conn.php'); //db connection
	
	$id = $_GET["id"];
	$unitCode = $_GET["unitCode"];
	
	$qur = "DELETE FROM `unit_detail` WHERE `id`='$id' ; ";
	$runSQL = $mysqli -> query($qur);
	
	$qur = "DELETE FROM `lec_manage` WHERE `unit_code` = '$unitCode'";
	$runSQL = $mysqli -> query($qur);
	
	$mysqli ->close();
	
?>