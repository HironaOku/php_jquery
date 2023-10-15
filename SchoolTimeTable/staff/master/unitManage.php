<?php
	include('../../db_conn.php'); //db connection
	include("../../session.php");
//checklogin

	if($_SESSION['access'] == ""){
		$msg ="Please login.";
		header('Location: ../../index.php?error='.$msg.'');

	} else if ($_SESSION['access'] == 'DC'){
		
		$username = $_SESSION['username'];
		
		if(isset($_GET["searchUnit"])){
			$dispUnit = $_GET["searchUnit"];
		} else {
			//for DC display minimum number of Unit code when DC login
			$query = "SELECT MIN(`unit_code`) AS 'unit_code' FROM `unit_detail`";
			$unitList = $mysqli -> query($query);
			
			foreach ($unitList as $rowunit) {
				$dispUnit = $rowunit["unit_code"];
			}
		}
		
		//for DC select other Unit
		$query ="SELECT `unit_code`, `unit_name` FROM `unit_detail` ORDER BY `unit_code`";
		$unitList = $mysqli -> query($query);
		
	} else if ($_SESSION['access'] == 'UC'){
		$username = $_SESSION['username'];
		$session_userID = $_SESSION['session_userID'];
		
		//for UC   UC can see only the Unit which allocated
		$query = "SELECT `unit_code` FROM `unit_detail` WHERE `UC` = '$session_userID' ";
		$result2 = $mysqli -> query($query);
		foreach ($result2 as $row2) {
			$dispUnit = $row2["unit_code"];
		}
		$result2 = "";
	} else {
		$msg ="Your account is not allowed to access.";
		header('Location: ../../index.php?error='.$msg.'');
	}

	//get offered lecture detail for Lecture Management
	$query = "SELECT l.`id`, l.`unit_code`, l.`campus`, l.`semester`, l.`date`, l.`starttime`, l.`duration`, l.`location`, l.`room`, l.`lecturor`, d.`username` FROM `lec_manage` l LEFT JOIN `dw_users` d ON l.`lecturor` = d.`userID` WHERE `unit_code` = '$dispUnit' ORDER BY `semester`";
	$result = $mysqli -> query($query);
	
	//get lecturer info include UC LEC TUT who allocated the unit
	$query = "SELECT d.`id`, d.`userID`, d.`username`, d.`access` FROM `dw_users` d LEFT JOIN `unit_detail` u ON u.`UC` = d.`userID` LEFT JOIN `staff_manage` s ON d.`userID` = s.`userID` WHERE s.`unit_code` = '$dispUnit' OR u.`unit_code` = '$dispUnit'";
	$result1 = $mysqli -> query($query);
	
	//get info for Consultation Management
	$query ="SELECT l.`semester`, l.`campus`, c.`id` AS 'cnslID', c.`date`, c.`starttime`, c.`duration`, c.`tutor`, d.`username`, c.`location`, c.`room` FROM `lec_manage` l LEFT OUTER JOIN `cnsl_manage` c ON l.`semester` = c.`semester` AND l.`campus` = c.`campus` AND l.`unit_code` = c.`unit_code` LEFT JOIN `dw_users` d ON d.`userID` = c.`tutor` WHERE l.`unit_code` = '$dispUnit' ORDER BY `semester`";
	$cnsResult1 = $mysqli -> query($query);
	
	//get info for tutrial Management
	$query="SELECT l.`semester`, l.`campus`, c.`id` AS 'tutID', c.`date`, c.`starttime`, c.`duration`, c.`tutor`, d.`username`, c.`location`, c.`room` , c.`capacity` FROM `lec_manage` l LEFT OUTER JOIN `tut_manage` c ON l.`semester` = c.`semester` AND l.`campus` = c.`campus` AND l.`unit_code` = c.`unit_code` LEFT JOIN `dw_users` d ON d.`userID` = c.`tutor` WHERE l.`unit_code` = '$dispUnit' ORDER BY `semester`, `campus`";
	$tutResult1 = $mysqli -> query($query);

	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../../js/unitManage.js"> </script>	

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    
 	<link rel="stylesheet" type="text/css" href="../../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../../css/unitManage.css">
</head>
<body>		
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<img src="../../img/UDW.png" alt="The University of DoWell" title="The University of DoWell">
		<a class="navbar-brand" href="#">Course Management System</a>	
		<div class="navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active"></li>
                <li class="nav-item"><a class="nav-link" href="../../index.php">Home<span class="sr-only">(current)</span></a></li>

				<?php if($_SESSION['access'] == 'STD'){ 
					$accountLink = "./student/userAccount_STD.php";
				?>
					<li class="nav-item"><a class="nav-link" href="../../student/unit_enrolment.php">Unit Enrolment</a></li>
					<li class="nav-item"><a class="nav-link" href="../../student/tutorial_allocation.php">Tutorial Allocation</a></li>
					<li class="nav-item"><a class="nav-link" href="../../student/my_timetable.php">Timetable</a></li>
					
				<?php } else if ($_SESSION['access'] == 'DC'){ 
					$accountLink = "./staff/userAccount_STF.php";
				?>
				
					<li class="nav-item"><a class="nav-link" href="../../staff/master/masterUnit.php">Master Unit</a></li>
					<li class="nav-item"><a class="nav-link" href="../../staff/master/masterStaff.php">Master Staff</a></li>
					<li class="nav-item"><a class="nav-link" href="../../staff/master/unitManage.php">Unit Management</a></li>
					
				<?php } else if ($_SESSION['access'] == 'UC'){ 
					$accountLink = "./staff/userAccount_STF.php";
				?>
					<li class="nav-item"><a class="nav-link" href="../../staff/master/unitManage.php">Unit Management</a></li>

				<?php } 
					 
					 if ($_SESSION['access'] == 'DC' or $_SESSION['access'] == 'UC' or $_SESSION['access'] == 'LEC' or $_SESSION['access'] == 'TUT'){ 
						 $accountLink = "./staff/userAccount_STF.php";
					 ?>
				
					<li class="nav-item"><a class="nav-link" href="../../staff/enrolledStudent.php">Enrolled Student</a></li>
					
				<?php } 
					if($_SESSION['access'] == 'STF'){
						$accountLink = "./staff/userAccount_STF.php";
					}
					
				?>
				
					<li class="nav-item"><a class="nav-link" href="../../unit_detail.php">Unit Detail</a></li>
					<li class="nav-item"><a class="nav-link" href="../../registration_form.php">Registration</a></li>

				</ul>
			
			<?php if($session_user == ""){ ?>
			
				<a class = "text-secondary"  href="../../login.php"><img src="../../img/login.png"><br><h5>Sign In</h5></a>
				
			<?php } else { ?>
				<form action="../../ses_signout.php" method="post">
					<input type="image" src="../../img/logout.png" alt="Singn out" name="submit" value="Sign out"><p>logout</p>
				</form>
				
			<?php } ?>
			
		</div>
	</nav>
    <div id="masterTable">
	    <h1>Unit Management / allocating teaching staff</h1>
	    <h3>Unit Code : <span id="unitCode"><?php echo $dispUnit; ?></span></h3>
		<p>
			
			
			
		</p>
		<div>
			<div class="row">
				
				<div class="col-md-10 col-lg-10" >
					<!-- Lecture Management -->
					<div>
						<h3><button type="button" class="btn btn-info hidedisp" id="displayLec" name="displayLec" value="displayLec">HIDE</button><a name="lecTitle">  Lecture Management</a></h3>
						<div class="table-responsive"  id="lecMng">
							<table class="table table-bordered table-hover" id="leclist">
							<thead>
								<tr>
									<th>Semester</th>
									<th>Campus</th>
									<th>Day</th>
									<th>Start time</th>
									<th>Duration</th>
									<th>Consultator</th>
									<th>Location</th>
									<th>Room</th>
									<?php if($_SESSION['access'] == 'UC') { ?>
									<th></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
			
								<?php 
									while ( $row = $result -> fetch_array(MYSQLI_ASSOC)){ 
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
										
										$day="";
										$dayHtml="";
										//translate day	
										switch ($row["date"]) {
											case 1: 
												$day = "MON ";
												break;
											case 2: 
												$day = "TUE ";
												break;
											case 3: 
												$day = "WED ";
												break;
											case 4: 
												$day = "THU ";
												break;
											case 5: 
												$day = "FRI ";
												break;
										}
										
								?>
								<tr>
									<td><?php echo $semester ?></td>
									<td><?php echo $row["campus"] ?></td>
									<td><span class="dispUnit id_<?php echo $row["id"] ?>"><?php echo $day ?></span>
										<select id="lecday_<?php echo $row["id"] ?>" name ="lecday" class="editBox edit_<?php echo $row["id"] ?>">
											<option value=""></option>
											
											<?php if($row["date"] == 1){ ?>
												<option value="1" selected="">MON</option>
											<?php } else {?>
												<option value="1">MON</option>
											<?php } ?>
											
											<?php if($row["date"] == 2){ ?>
												<option value="2" selected="">TUE</option>
											<?php } else {?>
												<option value="2">TUE</option>
											<?php } ?>
											
											<?php if($row["date"] == 3){ ?>
												<option value="3" selected="">WED</option>
											<?php } else {?>
												<option value="3">WED</option>
											<?php } ?>
											
											<?php if($row["date"] == 4){ ?>
												<option value="4" selected="">THU</option>
											<?php } else {?>
												<option value="4">THU</option>
											<?php } ?>
											
											<?php if($row["date"] == 5){ ?>
												<option value="5" selected="">FRI</option>
											<?php } else {?>
												<option value="5">FRI</option>
											<?php } ?>
										</select>
									
									</td>
									<td>
										<span class="dispUnit id_<?php echo $row["id"] ?>">
										<?php
											//display time
											if($row["starttime"] == 0){
												echo "";
											}else if(strpos($row["starttime"],'.5') === false){
												$time = explode(".",$row["starttime"]);
												echo $time[0].":00";
											} else {
												$time = explode(".",$row["starttime"]);
												echo $time[0].":30";
											}
											
											
											//create puldown list for start time
											?>
										</span>
										<select id="stTime_<?php echo $row["id"] ?>" name ="stTime" class="editBox edit_<?php echo $row["id"] ?>">
										<option value=""></option>
											
											<?php
											for( $i=9; $i <= 19; $i=$i+0.5){
												if(strpos($i,'.5') === false){
													$disptime =  $i.":00";
												} else {
													$time = explode(".",$i);
													$disptime = $time[0].":30";
												}
												
												if($i == $row["starttime"]){ ?>
													<option value="<?php echo $i ?>" selected=""><?php echo $disptime ?></option>
													
											<?php	} else { ?>
													<option value="<?php echo $i ?>"><?php echo $disptime ?></option>
											<?php } ?>
											
											<?php } ?>	
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $row["id"] ?>">
										<?php 
										if($row["duration"] == 0){
												echo "";
										}else{
											echo $row["duration"];
										} ?>
										</span>
										<select id="durTime_<?php echo $row["id"] ?>" name ="durTime" class="editBox edit_<?php echo $row["id"] ?>">
										<option value=""></option>
										<?php
										for( $i=0.5; $i <= 5; $i=$i+0.5){ 
											if($i == $row["duration"]){ ?>
												<option value="<?php echo $i ?>" selected=""><?php echo $i ?></option>
										<?php	} else { ?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } ?>
										<?php } ?>
										</select>
									</td>
									<td>
										<span class="dispUnit id_<?php echo $row["id"] ?>"><?php echo $row["username"] ;?></span>
										
										<select id="lecName_<?php echo $row["id"] ?>" name ="lecName" class="editBox edit_<?php echo $row["id"] ?>">
										<option value=""></option>
										<?php
											//create lecturer(cnsl) list
										foreach ($result1 as $row1) {
											
											//display UC or LECTURER
											if($row1["access"] == "UC" || $row1["access"] == "LEC"){
												if($row["username"] == $row1["username"]){ ?>
													<option value="<?php echo $row1["userID"] ?>" selected=""><?php echo $row1["username"] ?></option>
											<?php	} else { ?>
													<option value="<?php echo $row1["userID"] ?>"><?php echo $row1["username"] ?></option>
											<?php } 
												}
										}
									?>
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $row["id"] ?>"><?php echo $row["location"] ?></span>
										<input id ="location_<?php echo $row["id"] ?>" class="editBox edit_<?php echo $row["id"] ?>" type="text" name="location" value="<?php echo $row["location"] ?>">
									</td>
									<td><span class="dispUnit id_<?php echo $row["id"] ?>"><?php echo $row["room"] ?></span>
										<input id ="room_<?php echo $row["id"] ?>" class="editBox edit_<?php echo $row["id"] ?>" type="text" name="room" value="<?php echo $row["room"] ?>">
									</td>
									<?php if($_SESSION['access'] == 'UC') { ?>
									<td>
										<button type="button" class="btn btn-light editBtn" id="<?php echo $row["id"] ?>" name="edit" value="edit"><img src="../../img/mst_edit.png" alt ="edit"></button>
										<button type="button" class="btn btn-light saveBtn" id="savebtn_<?php echo $row["id"] ?>" name="save" value="save"><img src="../../img/mst_tick.png" alt ="save"></button>										
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						</div>
					</div>
					<!-- Consultation Management-->
					<div>
						<h3><button type="button" class="btn btn-info hidedisp" id="displayConsl" name="displayConsl" value="displayConsl">HIDE</button><a name="conslTitle">  Consultation Management</a></h3>
						<div class="table-responsive"  id="consMng">
							<table class="table table-bordered table-hover" id="leclist">
							<thead>
								<tr>
									<th>Semester</th>
									<th>Campus</th>
									<th>Day</th>
									<th>Start time</th>
									<th>Duration</th>
									<th>Consultator</th>
									<th>Location</th>
									<th>Room</th>
									<?php if($_SESSION['access'] == 'UC') { ?>
									<th><button type="button" class="btn btn-light" data-toggle="modal" data-target="#add_cnsl" id="addUnit"><img src="../../img/mst_newStaff.png" alt ="add new consultation"></button></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
			
								<?php 
									
									$cntrow=0;
									
									while ( $row = $cnsResult1 -> fetch_array(MYSQLI_ASSOC)){ 
									
									$cntrow++; //for row id
									$cnslData="";
										//if cnslID is null put id as insert or put cnslID
										if($row["cnslID"]){
											$cnt = "Cnsl".$row["cnslID"];
											$cnslData = "1";
										} else {
											$cnt = "newCnsl".$cntrow;
											$cnslData = "0";
										}
									
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
										
										$day="";
										$dayHtml="";
										//translate day	
										switch ($row["date"]) {
											case 1: 
												$day = "MON ";
												break;
											case 2: 
												$day = "TUE ";
												break;
											case 3: 
												$day = "WED ";
												break;
											case 4: 
												$day = "THU ";
												break;
											case 5: 
												$day = "FRI ";
												break;
										}
										
									
								?>
								<tr>
									<td><span id="sem_<?php echo $cnt ?>"><?php echo $semester ?></span></td>
									<td><span id="campus_<?php echo $cnt ?>"><?php echo $row["campus"] ?></span></td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $day ?></span>
										<select id="lecday_<?php echo $cnt ?>" name ="lecday" class="editBox edit_<?php echo $cnt ?>">
											<option value=""></option>
											
											<?php if($row["date"] == 1){ ?>
												<option value="1" selected="">MON</option>
											<?php } else {?>
												<option value="1">MON</option>
											<?php } ?>
											
											<?php if($row["date"] == 2){ ?>
												<option value="2" selected="">TUE</option>
											<?php } else {?>
												<option value="2">TUE</option>
											<?php } ?>
											
											<?php if($row["date"] == 3){ ?>
												<option value="3" selected="">WED</option>
											<?php } else {?>
												<option value="3">WED</option>
											<?php } ?>
											
											<?php if($row["date"] == 4){ ?>
												<option value="4" selected="">THU</option>
											<?php } else {?>
												<option value="4">THU</option>
											<?php } ?>
											
											<?php if($row["date"] == 5){ ?>
												<option value="5" selected="">FRI</option>
											<?php } else {?>
												<option value="5">FRI</option>
											<?php } ?>
										</select>
									</td>
									<td>
										<span class="dispUnit id_<?php echo $cnt ?>">
										<?php
											//display time
											if($row["starttime"] == 0){
												echo "";
											}else if(strpos($row["starttime"],'.5') === false){
												$time = explode(".",$row["starttime"]);
												echo $time[0].":00";
											} else {
												$time = explode(".",$row["starttime"]);
												echo $time[0].":30";
											}
											
											
											//create puldown list for start time
											?>
										</span>
										<select id="stTime_<?php echo $cnt ?>" name ="stTime" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
											
											<?php //create start time
											for( $i=9; $i <= 19; $i=$i+0.5){
												if(strpos($i,'.5') === false){
													$disptime =  $i.":00";
												} else {
													$time = explode(".",$i);
													$disptime = $time[0].":30";
												}
												
												if($i == $row["starttime"]){ ?>
													<option value="<?php echo $i ?>" selected=""><?php echo $disptime ?></option>
													
											<?php	} else { ?>
													<option value="<?php echo $i ?>"><?php echo $disptime ?></option>
											<?php } ?>
											
											<?php } ?>	
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>">
										<?php 
										if($row["duration"] == 0){
												echo "";
										}else{
											echo $row["duration"];
										} ?>
										</span>
										<select id="durTime_<?php echo $cnt ?>" name ="durTime" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
										<?php //create duration time
										for( $i=0.5; $i <= 5; $i=$i+0.5){ 
											if($i == $row["duration"]){ ?>
												<option value="<?php echo $i ?>" selected=""><?php echo $i ?></option>
										<?php	} else { ?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } ?>
										<?php } ?>
										</select>
									</td>
									<td>
										<span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["username"] ;?></span>
										
										<select id="lecName_<?php echo $cnt ?>" name ="lecName" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
										<?php
											//create lecturer list
										foreach ($result1 as $row1) {
											//display TUTOR or LECTURER
											if($row1["access"] == "TUT" || $row1["access"] == "LEC"){
											
												if($row["username"] == $row1["username"]){ ?>
													<option value="<?php echo $row1["userID"] ?>" selected=""><?php echo $row1["username"] ?></option>
											<?php	} else { ?>
													<option value="<?php echo $row1["userID"] ?>"><?php echo $row1["username"] ?></option>
											<?php } 
											}
										}
									?>
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["location"] ?></span>
										<input id ="location_<?php echo $cnt ?>" class="editBox edit_<?php echo $cnt ?>" type="text" name="location" value="<?php echo $row["location"] ?>">
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["room"] ?></span>
										<input id ="room_<?php echo $cnt ?>" class="editBox edit_<?php echo $cnt ?>" type="text" name="room" value="<?php echo $row["room"] ?>">
									</td>
									<?php if($_SESSION['access'] == 'UC') { 
										// for UC display edit/delete botton
									?>
									
									<td>
										<button type="button" class="btn btn-light cnslEdit" id="<?php echo $cnt ?>" name="edit" value="edit"><img src="../../img/mst_edit.png" alt ="edit"></button>
										<button type="button" class="btn btn-light cnslSave" id="savebtn_<?php echo $cnt ?>" name="save" value="save"><img src="../../img/mst_tick.png" alt ="save"></button>
										
										<?php if($cnslData=="1") { //if there is consaltation data, display delete button
										?>
										<button type="button" class="btn btn-light cnslDelete" id="dlt_<?php echo $row["cnslID"] ?>" name="delete" value="delete"><img src="../../img/mst_bin.png" alt ="save"></button>
										<?php } ?>										
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						</div>
					</div>
					<!-- Tutorial Management-->
					<div>
						<h3><button type="button" class="btn btn-info hidedisp" id="displayTut" name="displayTut" value="displayTut">HIDE</button><a name="tutTitle">  Tutorial Management</a></h3>
						<div class="table-responsive"  id="tutMng">
							<table class="table table-bordered table-hover" id="tutlist">
							<thead>
								<tr>
									<th>Semester</th>
									<th>Campus</th>
									<th>Day</th>
									<th>Start time</th>
									<th>Duration</th>
									<th>Tutor</th>
									<th>Location</th>
									<th>Room</th>
									<th>Capacity</th>
									<?php if($_SESSION['access'] == 'UC') { ?>
									<th><button type="button" class="btn btn-light" data-toggle="modal" data-target="#add_tut" id="addtut"><img src="../../img/mst_newStaff.png" alt ="add new Tutorial"></button></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
			
								<?php 
									
									$cntrow=0;
									
									while ( $row = $tutResult1 -> fetch_array(MYSQLI_ASSOC)){ 
									
									$cntrow++; //for row id
									$cnslData="";
										//if tutID is null put id as insert or put cnslID
										if($row["tutID"]){
											$cnt = "tut".$row["tutID"];
											$cnslData = "1";
										} else {
											$cnt = "newTut".$cntrow;
											$cnslData = "0";
										}
									
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
										
										$day="";
										$dayHtml="";
										//translate day	
										switch ($row["date"]) {
											case 1: 
												$day = "MON ";
												break;
											case 2: 
												$day = "TUE ";
												break;
											case 3: 
												$day = "WED ";
												break;
											case 4: 
												$day = "THU ";
												break;
											case 5: 
												$day = "FRI ";
												break;
										}
										
									
								?>
								<tr>
									<td><span id="sem_<?php echo $cnt ?>"><?php echo $semester ?></span></td>
									<td><span id="campus_<?php echo $cnt ?>"><?php echo $row["campus"] ?></span></td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $day ?></span>
										<select id="lecday_<?php echo $cnt ?>" name ="lecday" class="editBox edit_<?php echo $cnt ?>">
											<option value=""></option>
											
											<?php if($row["date"] == 1){ ?>
												<option value="1" selected="">MON</option>
											<?php } else {?>
												<option value="1">MON</option>
											<?php } ?>
											
											<?php if($row["date"] == 2){ ?>
												<option value="2" selected="">TUE</option>
											<?php } else {?>
												<option value="2">TUE</option>
											<?php } ?>
											
											<?php if($row["date"] == 3){ ?>
												<option value="3" selected="">WED</option>
											<?php } else {?>
												<option value="3">WED</option>
											<?php } ?>
											
											<?php if($row["date"] == 4){ ?>
												<option value="4" selected="">THU</option>
											<?php } else {?>
												<option value="4">THU</option>
											<?php } ?>
											
											<?php if($row["date"] == 5){ ?>
												<option value="5" selected="">FRI</option>
											<?php } else {?>
												<option value="5">FRI</option>
											<?php } ?>
										</select>
									</td>
									<td>
										<span class="dispUnit id_<?php echo $cnt ?>">
										<?php
											//display time
											if($row["starttime"] == 0){
												echo "";
											}else if(strpos($row["starttime"],'.5') === false){
												$time = explode(".",$row["starttime"]);
												echo $time[0].":00";
											} else {
												$time = explode(".",$row["starttime"]);
												echo $time[0].":30";
											}
											
											
											//create puldown list for start time
											?>
										</span>
										<select id="stTime_<?php echo $cnt ?>" name ="stTime" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
											
											<?php //create start time
											for( $i=9; $i <= 19; $i=$i+0.5){
												if(strpos($i,'.5') === false){
													$disptime =  $i.":00";
												} else {
													$time = explode(".",$i);
													$disptime = $time[0].":30";
												}
												
												if($i == $row["starttime"]){ ?>
													<option value="<?php echo $i ?>" selected=""><?php echo $disptime ?></option>
													
											<?php	} else { ?>
													<option value="<?php echo $i ?>"><?php echo $disptime ?></option>
											<?php } ?>
											
											<?php } ?>	
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>">
										<?php 
										if($row["duration"] == 0){
												echo "";
										}else{
											echo $row["duration"];
										} ?>
										</span>
										<select id="durTime_<?php echo $cnt ?>" name ="durTime" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
										<?php //create duration time
										for( $i=0.5; $i <= 5; $i=$i+0.5){ 
											if($i == $row["duration"]){ ?>
												<option value="<?php echo $i ?>" selected=""><?php echo $i ?></option>
										<?php	} else { ?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } ?>
										<?php } ?>
										</select>
									</td>
									<td>
										<span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["username"] ;?></span>
										
										<select id="lecName_<?php echo $cnt ?>" name ="lecName" class="editBox edit_<?php echo $cnt ?>">
										<option value=""></option>
										<?php
											//create lecturer list
										foreach ($result1 as $row1) {
											//display TUTOR
											if($row1["access"] == "TUT"){
											
												if($row["username"] == $row1["username"]){ ?>
													<option value="<?php echo $row1["userID"] ?>" selected=""><?php echo $row1["username"] ?></option>
											<?php	} else { ?>
													<option value="<?php echo $row1["userID"] ?>"><?php echo $row1["username"] ?></option>
											<?php } 
											}
										}
									?>
										</select>
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["location"] ?></span>
										<input id ="location_<?php echo $cnt ?>" class="editBox edit_<?php echo $cnt ?>" type="text" name="location" value="<?php echo $row["location"] ?>">
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["room"] ?></span>
										<input id ="room_<?php echo $cnt ?>" class="editBox edit_<?php echo $cnt ?>" type="text" name="room" value="<?php echo $row["room"] ?>">
									</td>
									<td><span class="dispUnit id_<?php echo $cnt ?>"><?php echo $row["capacity"] ?></span>
										<input type="number" id ="capacity_<?php echo $cnt ?>" class="editBox edit_<?php echo $cnt ?>" type="text" name="room" value="<?php echo $row["capacity"] ?>">
									</td>
									<?php if($_SESSION['access'] == 'UC') { 
										// for UC display edit/delete botton
									?>
									
									<td>
										<button type="button" class="btn btn-light cnslEdit" id="<?php echo $cnt ?>" name="edit" value="edit"><img src="../../img/mst_edit.png" alt ="edit"></button>
										<button type="button" class="btn btn-light tutSave" id="savebtn_<?php echo $cnt ?>" name="save" value="save"><img src="../../img/mst_tick.png" alt ="save"></button>
										
										<?php if($cnslData=="1") { //if there is consaltation data, display delete button
										?>
										<button type="button" class="btn btn-light tutDelete" id="dlt_<?php echo $row["tutID"] ?>" name="delete" value="delete"><img src="../../img/mst_bin.png" alt ="delete"></button>
										<?php } ?>										
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
				
				
				<!-- Unit List for DC -->
				<?php if($_SESSION['access'] == 'DC') { ?>
				<div class="col-md-2 col-lg-2">
					<div class="list-group" id="unitList">
						<a href="#" class="list-group-item list-group-item-action active" id="listTitle">Unit List</a>
					<?php 
						while ( $row = $unitList -> fetch_array(MYSQLI_ASSOC)){ 
					?>
					    
						  	<a href="unitManage.php?searchUnit=<?php echo $row['unit_code'] ?>" class="list-group-item list-group-item-action " id="<?php echo $row['id'] ?>"><?php echo $row['unit_code'] ?>
						  	<span><br><?php echo $row['unit_name'] ?></span></a>
					<?php } ?>
					</div>				
				</div>
				<?php } ?>

			</div>
	    </div>
    </div>
    
    <!--  consl MODAL   -->
	<div class="modal fade" id="add_cnsl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchLabel">Add New Consultation</h5>
				</div>
				<div class="modal-body" id="searchBody">
					<form role="form">
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Unit Code: <span id="unitCod"><?php echo $dispUnit; ?></span></label>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Semester & Campus</label>
							<div>
								<select id="semesterM" name ="semesterM" class="form-control">
									<?php  
									foreach ($cnsResult1 as $row3) {
									if ($chkcampus != $row3["campus"] || $chksemester != $row3["semester"]){
										
										$chkcampus=$row3["campus"];
										$chksemester=$row3["semester"];
										
										$semester="";
										switch ($row3["semester"]) {
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
										
										?>
										<option value="<?php echo $row3["semester"]."_".$row3["campus"]; ?>">
											<?php echo $semester."  :  ".$row3["campus"] ?>
										</option>
										<?php }?>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Day</label>
							<div>
								<select id="lecdayM" name ="lecdayM" class="form-control">
									<option value="1">MON</option>
									<option value="2">TUE</option>
									<option value="3">WED</option>
									<option value="4">THU</option>
									<option value="5">FRI</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Start time</label>
							<div>
								<select id="stTimeM" name ="stTimeM"  class="form-control">
									<?php //create start time
									for( $i=9; $i <= 19; $i=$i+0.5){
										if(strpos($i,'.5') === false){
											$disptime =  $i.":00";
										} else {
											$time = explode(".",$i);
											$disptime = $time[0].":30";
										}
										?>
											<option value="<?php echo $i ?>"><?php echo $disptime ?></option>
									<?php } ?>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Duration</label>
							<div>
								<select id="durTimeM" name ="durTimeM"  class="form-control">
								<option value=""></option>
								<?php //create duration time
								for( $i=0.5; $i <= 5; $i=$i+0.5){  ?>
										<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Consultator</label>
							<div>
								<select id="lecNameM" name ="lecNameM"  class="form-control">
								<option value=""></option>
								<?php
									//create lecturer list
								foreach ($result1 as $row1) {
									//display TUTOR or LECTURER
									if($row1["access"] == "TUT" || $row1["access"] == "LEC"){ ?>
										<option value="<?php echo $row1["userID"] ?>"><?php echo $row1["username"] ?></option>
									<?php } 
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Location</label>
							<input type="text" class="form-control" id="locationM" name="locationM">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Room</label>
							<input type="text" class="form-control" id="roomM" name="roomM">
						</div>
						
						
						<button type="button" class="btn btn-success" id="insertCnsl" name="insertCnsl" value="add">Add</button>
						<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>
    <!--  Tutrial MODAL   -->
	<div class="modal fade" id="add_tut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchLabel">Add New Tutrial</h5>
				</div>
				<div class="modal-body" id="searchBody">
					<form role="form">
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Unit Code: <span id="tutunit"><?php echo $dispUnit; ?></span></label>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Semester & Campus</label>
							<div>
								<select id="semesterT" name ="semesterT" class="form-control">
									<?php  
									foreach ($tutResult1 as $row3) {
									if ($chkcampus != $row3["campus"] || $chksemester != $row3["semester"]){
										
										$chkcampus=$row3["campus"];
										$chksemester=$row3["semester"];
										
										$semester="";
										switch ($row3["semester"]) {
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
										
										?>
										<option value="<?php echo $row3["semester"]."_".$row3["campus"]; ?>">
											<?php echo $semester."  :  ".$row3["campus"] ?>
										</option>
										<?php }?>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Day</label>
							<div>
								<select id="tutday" name ="tutday" class="form-control">
									<option value="1">MON</option>
									<option value="2">TUE</option>
									<option value="3">WED</option>
									<option value="4">THU</option>
									<option value="5">FRI</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Start time</label>
							<div>
								<select id="stTimeT" name ="stTimeT"  class="form-control">
									<?php //create start time
									for( $i=9; $i <= 19; $i=$i+0.5){
										if(strpos($i,'.5') === false){
											$disptime =  $i.":00";
										} else {
											$time = explode(".",$i);
											$disptime = $time[0].":30";
										}
										?>
											<option value="<?php echo $i ?>"><?php echo $disptime ?></option>
									<?php } ?>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Duration</label>
							<div>
								<select id="durTimeT" name ="durTimeT"  class="form-control">
								<option value=""></option>
								<?php //create duration time
								for( $i=0.5; $i <= 5; $i=$i+0.5){  ?>
										<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="lecday" class="col-form-label">Tutor</label>
							<div>
								<select id="tutName" name ="tutName"  class="form-control">
								<option value=""></option>
								<?php
									//create lecturer list
								foreach ($result1 as $row1) {
									//display TUTOR
									if($row1["access"] == "TUT"){ ?>
										<option value="<?php echo $row1["userID"] ?>"><?php echo $row1["username"] ?></option>
									<?php } 
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Location</label>
							<input type="text" class="form-control" id="locationT" name="locationT">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Room</label>
							<input type="text" class="form-control" id="roomT" name="roomT">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Capacity</label>
							<input type="number" class="form-control" id="capacityT" name="capacityT">
						</div>
						
						<button type="button" class="btn btn-success" id="insertTut" name="insertCnsl" value="add">Add</button>
						<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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
