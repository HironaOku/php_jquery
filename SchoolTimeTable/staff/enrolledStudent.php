<?php

	include("../session.php");
	include('../db_conn.php'); //db connection
//checklogin


	if($_SESSION['access'] == ""){
		$msg ="Please login.";
		header('Location: ../index.php?error='.$msg.'');

	} else if ($_SESSION['access'] == 'STD'){
		$msg ="Your account is not allowed to access.";
		header('Location: ../index.php?error='.$msg.'');
	} else {
		$username = $_SESSION['username'];
		$session_userID = $_SESSION['session_userID'];
		
	}
	
	$semester = '1';
	if(isset($_GET["searchSem"])){
		$semester = $_GET["searchSem"];
	} 
	
	//get enrolled 
	$query ="SELECT s.`id`, s.`userID`, d.`username`, s.`unit_code`, u.`unit_name`, s.`tutID`, t.`semester`, t.`campus` AS 'tutCampus', t.`date` AS 'tutDay', t.`starttime` AS 'tutStart', t.`duration` AS 'tutHour', t.`tutor`, d2.`username` AS 'tutName' FROM `student_enrl` s LEFT JOIN `tut_manage` t ON t.`id` = s.`tutID` LEFT JOIN `unit_detail` u ON u.`unit_code` = s.`unit_code` LEFT JOIN `dw_users` d ON s.`userID` = d.`userID` LEFT JOIN `dw_users` d2 ON t.`tutor` = d2.`userID` WHERE s.`tutID` <> '0' ORDER BY `unit_code`, `tutID`, `userID`";
	
	$arraySchedule = $mysqli -> query($query);
	
	$disSem = "";
	
	switch ($semester) {
		case "1": 
			$disSem = "Semester 1";
			break;
		case "2": 
			$disSem =  "Semester 2";
			break;
		case "3": 
			$disSem =  "Winter School";
			break;
		case "4": 
			$disSem =  "Spring School";
			break;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../js/enrolledStudent.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../css/enrolledStudent.css">
</head>
<body>		
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<img src="../img/UDW.png" alt="The University of DoWell" title="The University of DoWell">
			<a class="navbar-brand" href="#">Course Management System</a>	
			<div class="navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active"></li>
	                <li class="nav-item"><a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a></li>

					<?php if($_SESSION['access'] == 'STD'){ 
						$accountLink = "./student/userAccount_STD.php";
					?>
						<li class="nav-item"><a class="nav-link" href="../student/unit_enrolment.php">Unit Enrolment</a></li>
						<li class="nav-item"><a class="nav-link" href="../student/tutorial_allocation.php">Tutorial Allocation</a></li>
						<li class="nav-item"><a class="nav-link" href="../student/my_timetable.php">Timetable</a></li>
						
					<?php } else if ($_SESSION['access'] == 'DC'){ 
						$accountLink = "./staff/userAccount_STF.php";
					?>
					
						<li class="nav-item"><a class="nav-link" href="../staff/master/masterUnit.php">Master Unit</a></li>
						<li class="nav-item"><a class="nav-link" href="../staff/master/masterStaff.php">Master Staff</a></li>
						<li class="nav-item"><a class="nav-link" href="../staff/master/unitManage.php">Unit Management</a></li>
						
					<?php } else if ($_SESSION['access'] == 'UC'){ 
						$accountLink = "./staff/userAccount_STF.php";
					?>
						<li class="nav-item"><a class="nav-link" href="../staff/master/unitManage.php">Unit Management</a></li>

					<?php } 
						 
						 if ($_SESSION['access'] == 'DC' or $_SESSION['access'] == 'UC' or $_SESSION['access'] == 'LEC' or $_SESSION['access'] == 'TUT'){ 
							 $accountLink = "./staff/userAccount_STF.php";
						 ?>
					
						<li class="nav-item"><a class="nav-link" href="../staff/enrolledStudent.php">Enrolled Student</a></li>
						
					<?php } 
						if($_SESSION['access'] == 'STF'){
							$accountLink = "./staff/userAccount_STF.php";
						}
						
					?>
					
						<li class="nav-item"><a class="nav-link" href="../unit_detail.php">Unit Detail</a></li>
						<li class="nav-item"><a class="nav-link" href="../registration_form.php">Registration</a></li>

					</ul>
				
				<?php if($session_user == ""){ ?>
				
					<a class = "text-secondary"  href="../login.php"><img src="../img/login.png"><br><h5>Sign In</h5></a>
					
				<?php } else { ?>
					<form action="../ses_signout.php" method="post">
						<input type="image" src="../img/logout.png" alt="Singn out" name="submit" value="Sign out"><p>logout</p>
					</form>
					
				<?php } ?>
				
			</div>
		</nav>
    <div id="myTableconteiner">
    	<h1>Enrolled Student Details </h1>
    	<?php
	    $tutrialID = ""; 
	    while ( $row = $arraySchedule -> fetch_array(MYSQLI_ASSOC)){ 
			switch ($row['semester']) {
				case "1": 
					$disSem = "Semester 1";
					break;
				case "2": 
					$disSem =  "Semester 2";
					break;
				case "3": 
					$disSem =  "Winter School";
					break;
				case "4": 
					$disSem =  "Spring School";
					break;
			}
			switch ($row["tutDay"]) {
				case 1: 
					$tutDay = "MON ";
					break;
				case 2: 
					$tutDay = "TUE ";
					break;
				case 3: 
					$tutDay = "WED ";
					break;
				case 4: 
					$tutDay = "THU ";
					break;
				case 5: 
					$tutDay = "FRI ";
					break;
			}
			if($row["tutStart"] == 0){
				$tuttime = "";
			}else if(strpos($row["tutStart"],'.5') === false){
				$tuttime = explode(".",$row["tutStart"]);
				$tuttime =  $tuttime[0].":00";
			} else {
				$tuttime = explode(".",$row["tutStart"]);
				$tuttime =  $tuttime[0].":30";
			}
			
			
			if ($tutrialID != $row['tutID']){
				$tutrialID = $row['tutID'];
							    	 ?>
			    	<button type="button" class="btn btn-secondary btn-sm btnDisplay" id = "<?php echo($row['tutID']) ?>">display</button>
			    	<span>tutorial ID : <?php echo($row['tutID']) ?> </span>
			    	<span><?php echo($disSem." , ".$row['tutCampus']." , ".$row['unit_code']." , ".$tutDay." , ".$tuttime." , ".$row['tutName']) ?></span><br>
    	<?php }
	    	} ?>
    	<div class="table-responsive">
			<div>
	    		<table class="table table-striped">
				<thead>
					<th>Tutorial ID</th>
					<th>Semester</th>
					<th>Campus</th>
					<th>Unit code</th>
					<th>Unit Name</th>
					<th>Date</th>
					<th>Start Time</th>
					<th>Duration</th>
					<th>Tutor</th>
				</thead>
				<tbody>
					<?php 
					$tutrialID = "";
					foreach($arraySchedule as $row){ 
						if ($tutrialID != $row['tutID']){
							$tutrialID = $row['tutID'];
						switch ($row['semester']) {
							case "1": 
								$disSem = "Semester 1";
								break;
							case "2": 
								$disSem =  "Semester 2";
								break;
							case "3": 
								$disSem =  "Winter School";
								break;
							case "4": 
								$disSem =  "Spring School";
								break;
						}
						switch ($row["tutDay"]) {
							case 1: 
								$tutDay = "MON ";
								break;
							case 2: 
								$tutDay = "TUE ";
								break;
							case 3: 
								$tutDay = "WED ";
								break;
							case 4: 
								$tutDay = "THU ";
								break;
							case 5: 
								$tutDay = "FRI ";
								break;
						}
						if($row["tutStart"] == 0){
							$tuttime = "";
						}else if(strpos($row["tutStart"],'.5') === false){
							$tuttime = explode(".",$row["tutStart"]);
							$tuttime =  $tuttime[0].":00";
						} else {
							$tuttime = explode(".",$row["tutStart"]);
							$tuttime =  $tuttime[0].":30";
						}
					?>
					<tr class="<?php echo($row['tutID']) ?> tutList">
						<td><?php echo($row['tutID']) ?></td>
						<td><?php echo($disSem) ?></td>
						<td><?php echo($row['tutCampus']) ?></td>
						<td><?php echo($row['unit_code']) ?></td>
						<td><?php echo($row['unit_name']) ?></td>
						<td><?php echo($tutDay) ?></td>
						<td><?php echo($tuttime) ?></td>
						<td><?php echo($row['tutHour']) ?></td>
						<td><?php echo($row['tutName']) ?></td>
					</tr>
					<?php }
					} ?>
				</tbody>
	    	</table>
			</div>
			<div>
	    		<table class="table table-sm">
				<thead>
					<th>Student ID</th>
					<th>Student Name</th>
					<th>Tutorial ID</th>
				</thead>
				<tbody>
					<?php 
					$tutrialID = "";
					foreach($arraySchedule as $row){ 
					?>
					<tr class="<?php echo($row['tutID']) ?> tutList">
						<td><?php echo($row['userID']) ?></td>
						<td><?php echo($row['username']) ?></td>
						<td><?php echo($row['tutID']) ?></td>
					</tr>
					<?php 
					} ?>
				</tbody>
	    	</table>
			</div>
		</div>
    </div>
		
		
		
	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
