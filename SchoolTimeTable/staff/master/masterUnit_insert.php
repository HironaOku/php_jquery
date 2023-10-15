<?php
	include('../../db_conn.php'); //db connection
	
	$unitCode = $_GET["unitCode"];
	$unitName = $_GET["unitName"];
	$description = $_GET["description"];
	$semPandora = $_GET["semPandora"];
	$semRivendell = $_GET["semRivendell"];
	$semNeverlandr = $_GET["semNeverland"];
	$credit = $_GET["credit"];
	
	$rowtble ="";
	$serchSQL="SELECT * FROM `unit_detail` WHERE `unit_code` = '$unitCode';";
	$searchRsl = $mysqli -> query($serchSQL);
	$rowtble = $searchRsl->num_rows;
	
	if($rowtble > 0){
		
		$rowtble ="";
		$searchRsl="";
		$msg = "Unit Code exist";
		header('Location: masterUnit.php?error=Unit_Code_exist');
		
	} else {
		
		$qur = "INSERT INTO `unit_detail`(`unit_code`, `unit_name`, `description`, `pandora`, `rivendell`, `neverland`, `credit`) VALUES ('$unitCode','$unitName','$description','$semPandora','$semRivendell','$semNeverlandr','$credit'); ";
		$insert = $mysqli -> query($qur);
		
		for( $i=1; $i < 5; $i++){
			$str = $i-1;
			$semPandora1 = SUBSTR($semPandora,$str,1);
			
			if($semPandora1 == 1){
				$query = "INSERT INTO `lec_manage`( `unit_code`, `campus`, `semester`) VALUES ('$unitCode','Pandora','$i')";
				$insertunit = $mysqli -> query($query);
			} 
		}
		for( $i=1; $i < 5; $i++){
			$str = $i-1;
			$semRivendell1 = SUBSTR($semRivendell,$str,1);
			
			if($semRivendell1 == 1){
				$query = "INSERT INTO `lec_manage`( `unit_code`, `campus`, `semester`) VALUES ('$unitCode','Rivendell','$i')";
				$insertunit = $mysqli -> query($query);
			} 
		}
		for( $i=1; $i < 5; $i++){
			$str = $i-1;
			$semNeverlandr1 = SUBSTR($semNeverlandr,$str,1);
			
			if($semNeverlandr1 == 1){
				$query = "INSERT INTO `lec_manage`( `unit_code`, `campus`, `semester`) VALUES ('$unitCode','Neverland','$i')";
				$insertunit = $mysqli -> query($query);
			} 
		}
		
	}
		
	$mysqli ->close();
	
?>

