<?php

	include("../session.php");
	include('../db_conn.php'); //db connection
//checklogin

	if(isset($_GET['error'])){
		$errormessage=$_GET['error'];
		echo "<script>alert('$errormessage');</script>";
	}
	
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
	
	$semester = '1';
	if(isset($_GET["searchSem"])){
		$semester = $_GET["searchSem"];
	} 
	
	//get enrolled 
	$query ="SELECT s.`id`, s.`userID`, s.`unit_code`, u.`unit_name`, s.`lecID`, s.`tutID`, l.`campus`, l.`semester`, l.`date`, l.`starttime`, l.`duration`, l.`location`, l.`room`, l.`lecturor`, t.`campus` AS 'tutCampus', t.`date` AS 'tutDay', t.`starttime` AS 'tutStart', t.`duration` AS 'tutHour', t.`location` AS 'tutLocation', t.`room` AS 'tutRoom', t.`tutor` FROM `student_enrl` s LEFT JOIN `tut_manage` t ON t.`id` = s.`tutID` LEFT JOIN `lec_manage` l ON l.`id` = s.`lecID` LEFT JOIN `unit_detail` u ON u.`unit_code` = s.`unit_code` WHERE s.`userID` = '$session_userID' AND l.`semester` = '$semester'";
	$arraySchedule = $mysqli -> query($query);
	
	$query ="SELECT u.`userID`, u.`Email`, u.`tell`, u.`address`, u.`birthday`, d.`id`, d.`userID`, d.`username`, d.`password` FROM `dw_users` d LEFT JOIN `user_detail` u ON d.`userID` = u.`userID` WHERE d.`userID` = '$session_userID'";
	$account = $mysqli -> query($query);
	
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
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../js/userAccount_STD.js"> </script>	

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../css/userAccount_STD.css">
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
	<div id="wrap">
		<div class="row">
			<div class="col-md-4" id="acountDetail">
				<h3>Account Detail
					<button type="button" class="btn btn-info hidedisp" id="editAcc" name="editAcc" value="editAcc">Edit<br>Account</button>
					<button type="button" data-toggle="modal" data-target="#changePass" class="btn btn-info hidedisp" id="chgPass" name="chgPass" >Change<br>Password</button>
				</h3>
				<?php 
					while ( $row1 = $account -> fetch_array(MYSQLI_ASSOC)){ 
				?>
				<h4>Student ID 
				</h4>
				<p class="account" id="studentID"><?php echo($row1['userID']) ?></p>
				<h4>Name</h4>
				<p class="account">
					<span><?php echo($row1['username']) ?></span>
				</p>
				<h4>Email</h4>
				<p class="account">
					<span class="accDisp"><?php echo($row1['Email']) ?></span>
					<span class="accedit"><input type="email" name="email" id="email" value="<?php echo($row1['Email']) ?>"></span>
				</p>
				<h4>Phone number</h4>
				<p class="account">
					<span class="accDisp"><?php echo($row1['tell']) ?></span>
					<span class="accedit"><input type="tel" name="tel" id="tel" value="<?php echo($row1['tell']) ?>"></span>
				</p>
				<h4>Address</h4>
				<p class="account">
					<span class="accDisp"><?php echo($row1['address']) ?></span>
					<span class="accedit"><input type="text" name="address" id="address" value="<?php echo($row1['address']) ?>"></span>
				</p>
				<h4>Date of birth</h4>
				<p class="account">
					<span class="accDisp"><?php echo($row1['birthday']) ?></span>
					<span class="accedit"><input type="date" name="birthday" id="birthday" value="<?php echo($row1['birthday']) ?>"></span>
				</p>
				<?php 
					} 
				?>
				<button type="button" class="btn btn-info hidedisp accedit"  id="Submit" name="Submit" value="Submit">Submit</button>
			</div>
			<div class="col-md-8"  id="myTableconteiner">
    	<h1>My Timetable    (<?php echo($disSem); ?>)</h1>
    	<a href="userAccount_STD.php?searchSem=1"><button type="button" class="btn btn-secondary btn-sm btnWithdrw">Semester 1</button></a>
    	<a href="userAccount_STD.php?searchSem=2"><button type="button" class="btn btn-secondary btn-sm btnWithdrw">Semester 2</button></a>
    	<a href="userAccount_STD.php?searchSem=3"><button type="button" class="btn btn-secondary btn-sm btnWithdrw">Winter School</button></a>
    	<a href="userAccount_STD.php?searchSem=4"><button type="button" class="btn btn-secondary btn-sm btnWithdrw">Spring School</button></a>
    	<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<th></th>
					<th class="timetable-date">
						<span class="inner">
							<span class="day">MON</span>
						</span>
					</th>
					<th class="timetable-date">
						<span class="inner">
							<span class="day">TUE</span>
						</span>
					</th>
					<th class="timetable-date">
						<span class="inner">
							<span class="day">WED</span>
						</span>
					</th>
					<th class="timetable-date">
						<span class="inner">
							<span class="day">THU</span>
						</span>
					</th>
					<th class="timetable-date">
						<span class="inner">
							<span class="day">FRI</span>
						</span>
					</th>
				</thead>
				<tbody>
					
					<?php 
						$startTime = 9;
						$minuts = 30;
						$dispHtml ="";
						$i = 0; //cnt
						//Table generate
						for($cnt = 0; $startTime<=18; $cnt++) {
							if($cnt == 0){
								$dispTime = $startTime.":00";
								$time = $startTime;
							} else if($cnt % 2 != 0){
								$dispTime = $startTime.":".$minuts;
								$time = $startTime + 0.5; 
							}else{
								$startTime++;
								$dispTime = $startTime.":00";
								$time = $startTime;
							}
							
							$dispHtml .= "<tr>";
							$dispHtml .= "<th class=\"timetable-time\"><span class=".$time."><time datetime>".$dispTime."</time></span></th>";
							
							//after DB need modify
							$tdClose = "</td>";
							$monSche="";
							$tueSche="";
							$wedSche="";
							$thuSche="";
							$friSche="";
							
							for($dayColum = 0; $dayColum <5; $dayColum++){
								foreach($arraySchedule as $row){
									
									$unitCode = $row["unit_code"];
									$unitName = $row["unit_name"];
									$unitdate = $row["date"];
									$unitTime = $row["starttime"];
									$unitLong = $row["duration"];
									$unitLong = $unitLong * 2; //hour to 30 min
									$urlUnitdetail = "../unit_detail.php";
									$unitRoom = $row["room"];
									$unitLoc = $row["location"];

									//tutrialURL
									$linkUrl = $urlUnitdetail;
									
									$generateHIML = "<td rowspan=".$unitLong." id=\"Lec".$unitCode."\" class=\"Lec\">
													 <a href=\"".$urlUnitdetail."?searchUnit=".$unitCode."\">
													 <h5>LEC ".$unitCode."</h5>
													 <p>".$unitName."<br>".$unitLoc.":".$unitRoom."</p></a>".$tdClose;
									
														
									//Create MON to FRI HTML	
									if($dayColum == 0 && $unitdate == "1" && $time == $unitTime){
										$monSche = $generateHIML;
										$monUnitLong = $unitLong;
									}
									
																		
									if ($dayColum == 1 && $unitdate == "2" && $time == $unitTime){
										$tueSche = $generateHIML;
										$tueUnitLong = $unitLong;
									}
										
									if ($dayColum == 2 && $unitdate == "3" && $time == $unitTime){
										$wedSche =  $generateHIML;
										$wedUnitLong = $unitLong;
									}
										
									if ($dayColum == 3 && $unitdate == "4" && $time == $unitTime){
										$thuSche =  $generateHIML;
										$thuUnitLong = $unitLong;
									}
										
									if ($dayColum == 4 && $unitdate == "5" && $time == $unitTime){
										$friSche = $generateHIML;
										$friUnitLong = $unitLong;
									}
									
									//for tutrial
									$tutdate = $row["tutDay"];
									$tutTime = $row["tutStart"];
									$tutLong = $row["tutHour"];
									$tutLong = $tutLong * 2;
									$urltutAllocate ="./tutorial_allocation.php";
									$unitLoc = $row["tutLocation"];
									$unitRoom = $row["tutRoom"];
									
									//START tutrial HTML
									$linkUrl = $urltutAllocate."?id=".$unitCode;
									
									
									$generateHIML = "<td rowspan=".$tutLong." id=\"Tut".$unitCode."\" class=\"Tut\">
													 <a href=\"".$linkUrl."?searchUnit=".$unitCode."\">
													 <h5>TUT ".$unitCode."</h5>
													 <p>".$unitName."<br>".$unitLoc.":".$unitRoom."</p></a>".$tdClose;
									//tutHTMl
									if($dayColum == 0 && $tutdate == "1" && $time == $tutTime){
										$monSche = $generateHIML;
										$monUnitLong = $tutLong;
									}
									if($dayColum == 0 && $tutdate == "2" && $time == $tutTime){
										$tueSche = $generateHIML;
										$tueUnitLong = $tutLong;
									}
									if($dayColum == 0 && $tutdate == "3" && $time == $tutTime){
										$wedSche =  $generateHIML;
										$wedUnitLong = $tutLong;
									}
									if($dayColum == 0 && $tutdate == "4" && $time == $tutTime){
										$thuSche =  $generateHIML;
										$thuUnitLong = $tutLong;
									}
									if($dayColum == 0 && $tutdate == "5" && $time == $tutTime){
										$friSche = $generateHIML;
										$friUnitLong = $tutLong;
									}
								}//end foreach
		
							}

								$empTag = "<td></td>";
								
								//if no schedule, put empty td tag or adjust for rowspan
								if ($monSche == "" && $monUnitLong < 1 && $dispTime != ""){
									$monSche = $empTag;
								} else if ($monUnitLong >= 1){
									$monUnitLong--;
								}
								
								if ($tueSche == "" && $tueUnitLong < 1 && $dispTime != ""){
									$tueSche = $empTag;
								} else if ($tueUnitLong >= 1){
									$tueUnitLong--;
								}
								
								if ($wedSche == "" && $wedUnitLong < 1 && $dispTime != ""){
									$wedSche = $empTag;
								} else if ($wedUnitLong >= 1){
									$wedUnitLong--;
								}
								
								if ($thuSche == "" && $thuUnitLong < 1 && $dispTime != ""){
									$thuSche = $empTag;
								} else if ($thuUnitLong >= 1){
									$thuUnitLong--;
								}
								
								if ($friSche == "" && $friUnitLong < 1 && $dispTime != ""){
									$friSche = $empTag;
								} else if ($friUnitLong >= 1){
									$friUnitLong--;
								}
							
							
							$dispHtml .= $monSche.$tueSche.$wedSche.$thuSche.$friSche;
							$dispHtml .= "</tr>";
							$i++;
						} 
						echo($dispHtml);
						
						
					?>
					
					
				</tbody>
			</table>
		</div>
    </div>
	</div>
	
	<!--MODAL-->
	<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchLabel">Change Password</h5>
				</div>
				<div class="modal-body" id="searchBody">
				<form onsubmit="return vali();" id="changePass" class="form-horizontal" method="post" action="userAccount_STD_change.php">

						<div class="form-group">
							<label for="ID" class="control-label">Student ID</label>
							<input id="S_id" type="text" name="S_id">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="control-label">Your Current Pasword</label><br>
							<input type="password" name="oldpass" id="oldpass" autocomplete="current-password">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="control-label">New Pasword</label><br>
							<input type="password" name="password" id="pass" autocomplete="new-password">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="control-label">Confirm New Pasword</label><br>
							<input type="password" name="confirmpassword" id="confPass" autocomplete="new-password">
						</div>
						
						
						<input type="submit" name="submit" class="btn btn-primary button" value="Submit">
						<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
