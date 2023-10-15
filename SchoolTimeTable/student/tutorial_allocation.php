<?php

	include("../session.php");
	include('../db_conn.php'); 
	//db connection
//checklogin


	if($_SESSION['access'] == ""){
		$msg ="Please login.";
		header('Location: ../index.php?error='.$msg.'');

	} else if ($_SESSION['access'] == 'STD'){
		$username = $_SESSION['username'];
		$session_userID = $_SESSION['session_userID']; 
		
	} else {
		$msg ="Your account is not allowed to access.";
		header('Location: ../index.php?error='.$msg.'');
	}
	
	
	//tutrial list
	$query ="SELECT l.`id` AS 'tutID', l.`unit_code`, l.`date`, u.`unit_name`, l.`campus`, l.`starttime`, l.`duration`, l.`location`, l.`room`, l.`capacity`, l.`semester`, s.`unit_code` as 'enrUnit', s.`tutID` AS 'enrTut', s.`userID` FROM `tut_manage` l LEFT JOIN `unit_detail` u ON l.`unit_code` = u.`unit_code` LEFT JOIN `student_enrl` s ON l.`unit_code` = s.`unit_code` AND s.`userID` = '$session_userID' ORDER BY l.`unit_code`, s.`lecID` DESC";
	$tutList = $mysqli -> query($query);
	
	//count registerd tutorial for capacity
	$query ="SELECT `unit_code`, `tutID`, COUNT(`tutID`) AS 'numTut' FROM `student_enrl` WHERE `tutID` <> 0 GROUP BY `tutID`";
	$regiNum = $mysqli -> query($query);
	
	//Unit enroled list
	$query ="SELECT s.`id` AS 'enrID', s.`userID`, s.`lecID`, s.`unit_code`, d.`unit_name`, l.`campus` AS 'lecCampus', l.`semester` AS 'lecSem', l.`date` AS 'lecDate', l.`starttime` AS 'lecStart', l.`duration` AS 'lecHour', s.`tutID`, t.`campus` AS 'tutCampus', t.`semester` AS 'tutSem', t.`date` AS 'tutDate', t.`starttime` AS 'tutStart', t.`duration` AS 'tutHour' FROM `student_enrl` s LEFT JOIN `tut_manage` t ON t.`id` = s.`tutID` LEFT JOIN `lec_manage` l ON l.`id` = s.`lecID` LEFT JOIN `unit_detail` d ON l.`unit_code` = d.`unit_code` WHERE s.`userID` = '$session_userID' ORDER BY `unit_code`, 'lecSem'";
	$enrolList = $mysqli -> query($query);

	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../js/tutorial_allocation.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../css/tutorial_allocation.css">
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
    <h1>Tutorial Allocation</h1>
    <div id="enrollwrap">
	    <div class="row">
			<div class="col-md-10" id="unitEnroledwrap">
				<div class="table-responsive">
					<h5 class="card-title">
						<button type="button" class="btn btn-info hidedisp" id="dipAll" name="dipAll" value="dipAll">Display ALL</button>
						<button type="button" class="btn btn-info hidedisp" id="dipAve" name="dipAve" value="dipAve">Display matched</button>
					</h5>
					<table class="table table-sm">
						<tbody>
							<tr>
								<th>Tutorial ID</th>
								<th>Campus</th>
								<th>Unit code</th>
								<th>Unit name</th>
								<th>Semester</th>
								<th>Day</th>
								<th>Start Time</th>
								<th>Duration</th>
								<th>Availability</th>
								<th>Status</th>
								<th>Allocate</th>
							</tr>
							
							<?php 
								
								while ( $row = $tutList -> fetch_array(MYSQLI_ASSOC)){ 
									$semester="";
									switch ($row["semester"]) {
										case "1": 
											$semester = "Semester 1";
											break;
										case "2": 
											$semester =  "Semester 2";
											break;
										case "3": 
											$semester =  "Winter School";
											break;
										case "4": 
											$semester =  "Spring School";
											break;
									}
									//create day
									$date ="";
									switch ($row["date"]) {
										case 1: 
											$date = "MON ";
											break;
										case 2: 
											$date = "TUE ";
											break;
										case 3: 
											$date = "WED ";
											break;
										case 4: 
											$date = "THU ";
											break;
										case 5: 
											$date = "FRI ";
											break;
									}
									
									//create time display
									$tuttime ="";
									if($row["starttime"] == 0){
										$tuttime = "";
									}else if(strpos($row["starttime"],'.5') === false){
										$tuttime = explode(".",$row["starttime"]);
										$tuttime =  $tuttime[0].":00";
									} else {
										$tuttime = explode(".",$row["starttime"]);
										$tuttime =  $tuttime[0].":30";
									}
									
									//create Availability capacity minus count allocated number
									$remain = "";
									$remainFlg = "0";
									foreach ($regiNum as $rowRegi){
										if($rowRegi['tutID'] == $row["tutID"]){

											if($row["capacity"] && $rowRegi['numTut']) {
												
												$remain = $row["capacity"] - $rowRegi['numTut'];
												if($remain <= 0 || $row["capacity"] <= 0){
													$remainFlg = "1"; //unavailable
												}
												$remain = $remain."/".$row["capacity"];
											}
										}
									}
									if($row["capacity"] <= 0){
										$remainFlg = "1";
										$remain = $row["capacity"]."/".$row["capacity"];
									}
									if($remain ==""){
										 $remain = $row["capacity"]."/".$row["capacity"];
									}
									
									//if semester, campus, unitcode are mismuch as enroled unit display none and give flag
									
									foreach ($enrolList as $rowDisp){
										$dispFlg = "1";
										if ($row["semester"]==$rowDisp["lecSem"] && $row["campus"]==$rowDisp["lecCampus"] && $row["unit_code"]==$rowDisp["unit_code"] ){ 
										
										?>
											
											<tr class="disp_<?php echo($row['unit_code']) ?>">
										<?php
											$dispFlg = "0";
											break;
											
											 } else { ?>
											<tr class="nonDisp">
										<?php 
											
										} ?>
							
										
									<?php } ?>
											<td><?php echo($row['tutID']) ?></td>
											<td><?php echo($row['campus']) ?></td>
											<td><span id="unitcode_<?php echo($row['tutID']) ?>"><?php echo($row['unit_code']) ?></span></td>
											<td><?php echo($row['unit_name']) ?></td>
											<td><?php echo($semester) ?></td>
											<td><?php echo($date) ?></td>
											<td><?php echo($tuttime) ?></td>
											<td><?php echo($row['duration']) ?></td>
											<td><?php echo($remain) ?></td>
											
											
										<?php if($row['enrTut']=="0" && $remainFlg == "0" && $dispFlg == "0"){ //if student is not enrolled in this unit?>
											<td></td>
											<td><button type="button" class="btn btn-info btn-sm btnEnrol" id="<?php echo($row['tutID']) ?>">Allocate</button></td>
											
										<?php } else if($row['enrTut'] > 0 && $row['enrTut']==$row['tutID']){ ////if student is enrolled in this unit
											$enrolFlag = $row['unit_code'];
											$enrolFlag2 = $row['enrTut'];
											$enrolFlag3 = $row['campus'];
										?>
											<td>Allocated</td>
											<td><button type="button" class="btn btn-secondary btn-sm btnWithdrw" id="<?php echo($row['tutID']) ?>">Withdraw</button></td>
											
										<?php } else if ($remainFlg == "1") { ?>
											<td>Not available</td>
											<td></td>
										<?php } else if ($dispFlg == "1"){ ?>
											<td><small class="text-muted">mismatch semester/Campus</small></td>
											<td></td>
										
										<?php } else{ ?>
											<td colspan="2"> 
												<p class="h6">
													<small class="text-muted">to allocate this, please withdraw Tutorial ID : <?php echo($row['enrTut']) ?></small>
												</p>
											</td>
										<?php }?>	
										</tr>
							<?php	}	
								 ?>
						</tbody>
					</table>
				</div>		
			</div>
			
			<div class="col-md-2">
				<div class="list-group" id="Enrolledunit">
					<a href="#" class="list-group-item list-group-item-action active" id="listTitle">Enroled Unit<br>
						<span id="stuID"><?php echo($session_userID) ?></span></a>
					
					<?php //create enroed Unit lost
						foreach ($enrolList as $row3){
							$lecDay="";
							$tutDay="";
							$dayHtml="";
							$time="";
							$tuttime="";
						
							//translate day	
							switch ($row3["lecDate"]) {
								case 1: 
									$lecDay = "MON ";
									break;
								case 2: 
									$lecDay = "TUE ";
									break;
								case 3: 
									$lecDay = "WED ";
									break;
								case 4: 
									$lecDay = "THU ";
									break;
								case 5: 
									$lecDay = "FRI ";
									break;
							}
							
							$semester="";
							switch ($row3["lecSem"]) {
								case "1": 
									$semester = "Semester 1";
									break;
								case "2": 
									$semester =  "Semester 2";
									break;
								case "3": 
									$semester =  "Winter School";
									break;
								case "4": 
									$semester =  "Spring School";
									break;
							}
							
							if($row3["tutID"]){
								switch ($row3["tutDate"]) {
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
										$$tutDay = "FRI ";
										break;
								}
								
								if($row3["tutStart"] == 0){
									$tuttime = "";
								}else if(strpos($row3["tutStart"],'.5') === false){
									$tuttime = explode(".",$row3["tutStart"]);
									$tuttime =  $tuttime[0].":00";
								} else {
									$tuttime = explode(".",$row3["tutStart"]);
									$tuttime =  $tuttime[0].":30";
								}
							}							
							
							if($row3["lecStart"] == 0){
								$time = "LEC : under consideration";
								
							}else if(strpos($row3["lecStart"],'.5') === false){
								$time = explode(".",$row3["lecStart"]);
								$time =  $time[0].":00";
								$time = "LEC : ".$lecDay." ".$time."(".$row3['lecHour']."H)";
							} else {
								$time = explode(".",$row3["lecStart"]);
								$time =  $time[0].":30";
								$time = "LEC : ".$lecDay." ".$time."(".$row3['lecHour']."H)";
							}

					?>
						  	<a href="#" class="list-group-item list-group-item-action">
								<?php echo ($row3['unit_code']."  ".$row3['unit_name']); ?><br>
								<?php echo ($row3['lecCampus']."  ".$semester); ?><br>
								<?php echo ($time); ?><br>
								<?php if($row3["tutID"]){									
										echo ("TUT : ".$tutDay." ".$tuttime."(".$row3['tutHour']."H)"); 
									} else {
										echo ("TUT : Not allocated"); 
									}
									?>
							</a>
					<?php 
						} ?>
							
				</div>				
			</div>			
	    </div>
    </div>

	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
