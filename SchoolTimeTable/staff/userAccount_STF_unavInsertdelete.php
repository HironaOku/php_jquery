<?php
	include("../session.php");
	include('../db_conn.php'); //db connection
	
	$id = $_GET["id"];
	
	$qur = "DELETE FROM `staff_unavailable` WHERE `id` ='$id'";	
	
	$insert = $mysqli -> query($qur);
	
	$mysqli ->close();
	
	
	
?>