<?php
include('db_conn.php'); //db connection

$serchVal = $_GET["serchVal"];


if ($serchVal) {
	$serchSQL = "SELECT * FROM `unit_detail` WHERE `id` = '$serchVal' ;";
	$searchRsl = $mysqli -> query($serchSQL);
	$rowtble = $searchRsl->num_rows;
	
	} else {
		
	$serchSQL = "SELECT * FROM `unit_detail` WHERE `unit_code` = (SELECT MIN(`unit_code`) FROM `unit_detail`) ;";
	$searchRsl = $mysqli -> query($serchSQL);
	$rowtble = $searchRsl->num_rows;
	
	}
	
	
	$searchHTML ="";
	
	

	if($rowtble >= 1){
				
		while ( $serchRow = $searchRsl -> fetch_array(MYSQLI_ASSOC)){
			$searchHTML .= "<div class=\"card-header\">";
			$searchHTML .=  "<h2>".$serchRow['unit_code']."</h2>";
			$searchHTML .= "<h3>".$serchRow['unit_name']."</h3> </div>";
			$searchHTML .= "<div class=\"card-body\">";
			$searchHTML .= "<h5 class=\"card-title\">Brief description about this unit</h5>";
			$searchHTML .= "<p class=\"card-text\">".$serchRow['description']."</p>";
			$searchHTML .= "<div class=\"table-responsive\">";
			$searchHTML .= "<h5 class=\"card-title\">Unit coordinator and Lecturer</h5>";
			$searchHTML .= "<table class=\"table table-sm\">";
			$searchHTML .= "<tbody><tr><th></th>";
			$searchHTML .= "<th>Pandora</th><th>Rivendell</th><th>Neverland</th></tr>";
			$searchHTML .= "<tr><th>Unit coordinator</th><td colspan=\"3\">".$serchRow['UC']."</td>";
			$searchHTML .= "</tr><tr>";
			$searchHTML .= "<th>Lecturer</th>";
			$searchHTML .= "<td>LecturerA</td><td>LecturerA</td><td>LecturerA</td>";
			
			$searchHTML .= "</tr></tbody></table></div>";
			
			
			
			
			
			
			
			
			$searchHTML .= "<table class=\"table table-bordered table-sm resultTable\">";
			$searchHTML .= "<tbody>";
				foreach ($serchRow as $key => $value){
					$searchHTML .= "<tr>";
						$searchHTML .= "<td class=\"tableKey\">";
						$searchHTML .= $key;
						$searchHTML .= "</td>";
						$searchHTML .= "<td>";
						$searchHTML .= $value;
						$searchHTML .= "</td>";
					$searchHTML .= "</tr>";
				}
			$searchHTML .= "</tbody>";
			$searchHTML .= "</table>";
		}		
	} else {
		$searchHTML= NULL;
	}


echo $searchHTML;

$mysqli ->close();
$searchRsl ->close();
?>

