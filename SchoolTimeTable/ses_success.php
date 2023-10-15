<?php
include("session.php");
include("db_conn.php");

$query=mysqli_query($mysqli, "SELECT * FROM `dw_users` WHERE `userID` LIKE '$session_userID'");
if ($query) {
	$rs = mysqli_fetch_array($res);
}
if ($session_userID==""){
	header('Location: login.php');
} else {
	header('Location: index.php');
}
?>