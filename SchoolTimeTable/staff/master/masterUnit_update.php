<?php
	include('../../db_conn.php'); //db connection
	
	$id = $_GET["id"];
	$unitCode = $_GET["unitCode"];
	$unitName = $_GET["unitName"];
	$description = $_GET["description"];
	$semPandora = $_GET["semPandora"];
	$semRivendell = $_GET["semRivendell"];
	$semNeverland = $_GET["semNeverland"];
	$credit = $_GET["credit"];
	
	$qur = "UPDATE `unit_detail` SET `unit_code`='$unitCode',`unit_name`='$unitName',`description`='$description',`pandora`='$semPandora',`rivendell`='$semRivendell',`neverland`='$semNeverland',`credit`='$credit' WHERE `id`='$id' ; ";
	
	for( $i=1; $i < 5; $i++){
		$str = $i-1;
		$semPandora1 = SUBSTR($semPandora,$str,1);
		
		if($semPandora1 == 1){
			$query = "insert into `lec_manage` ( `unit_code`, `campus`, `semester` ) select * from (select '$unitCode', 'Pandora', '$i') as tmp where not exists ( select * from `lec_manage` where `unit_code` = '$unitCode' AND `campus` = 'Pandora' AND `semester` = '$i' ) limit 1";
			$insertunit = $mysqli -> query($query);
		} else {
			$query = "DELETE FROM `lec_manage` WHERE `unit_code` = '$unitCode' AND `campus` = 'Pandora' AND `semester` = '$i'";
			$deletetunit = $mysqli -> query($query);
		}
	}
	for( $i=1; $i < 5; $i++){
		$str = $i-1;
		$semRivendell1 = SUBSTR($semRivendell,$str,1);
		
		if($semRivendell1 == 1){
			$query = "insert into `lec_manage` ( `unit_code`, `campus`, `semester` ) select * from (select '$unitCode', 'Rivendell', '$i') as tmp where not exists ( select * from `lec_manage` where `unit_code` = '$unitCode' AND `campus` = 'Rivendell' AND `semester` = '$i' ) limit 1";
			$insertunit = $mysqli -> query($query);
		} else {
			$query = "DELETE FROM `lec_manage` WHERE `unit_code` = '$unitCode' AND `campus` = 'Rivendell' AND `semester` = '$i'";
			$deletetunit = $mysqli -> query($query);
		}
	}
	for( $i=1; $i < 5; $i++){
		$str = $i-1;
		$semNeverlandr1 = SUBSTR($semNeverland,$str,1);
		
		if($semNeverlandr1 == 1){
			$query = "insert into `lec_manage` ( `unit_code`, `campus`, `semester` ) select * from (select '$unitCode', 'Neverland', '$i') as tmp where not exists ( select * from `lec_manage` where `unit_code` = '$unitCode' AND `campus` = 'Neverland' AND `semester` = '$i' ) limit 1";
			$insertunit = $mysqli -> query($query);
		} else {
			$query = "DELETE FROM `lec_manage` WHERE `unit_code` = '$unitCode' AND `campus` = 'Neverland' AND `semester` = '$i'";
			$deletetunit = $mysqli -> query($query);
		}
	}	
	
	
	
	$insert = $mysqli -> query($qur);
			
	$mysqli ->close();
	
?>