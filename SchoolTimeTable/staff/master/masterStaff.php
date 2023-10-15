<?php
	include('../../db_conn.php'); //db connection
	include("../../session.php");
//checklogin
	if(isset($_GET["error"])){
		$errorMsg = $_GET["error"];
		echo "<script>alert('$errorMsg');</script>";
	}

	if($_SESSION['access'] == ""){
		$msg ="Please login.";
		header('Location: ../../index.php?error='.$msg.'');

	} else if ($_SESSION['access'] == 'DC'){
		$username = $_SESSION['username'];
		
	} else {
		$msg ="Your account is not allowed to access.";
		header('Location: ../../index.php?error='.$msg.'');
	}
	
$query = <<<query
		SELECT 
			u.userID, u.username, d.qualification, d.expertise, m.unit_code, u.access
		FROM
			dw_users u
		LEFT JOIN
			user_detail d
		ON u.userID = d.userID
		LEFT JOIN
			staff_manage m
		ON d.userID = m.userID
		WHERE
			u.access = "STF" 
			OR u.access = "LEC"
			OR u.access = "TUT" 
query;

	$resultData = $mysqli -> query($query);
	
	//get unit code
	$query1 = "SELECT `unit_code` FROM `unit_detail` ORDER BY `unit_code`";
	$resultData1 = $mysqli -> query($query1);
	
	//staff_unavailable 
	$query2 =  <<<query
	
		SELECT 
			u.userID, 
			s.day, 
			s.stat_time, 
			s.end_time 
		FROM 
			dw_users u 
		LEFT JOIN staff_unavailable s ON u.userID = s.userID 
		WHERE 
			u.access = "STF" 
			OR u.access = "LEC" 
			OR u.access = "TUT" 
		ORDER BY 
			u.userID, 
			s.day
query;
	$resultData2 = $mysqli -> query($query2);
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>CMS Registration</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../../js/masterStaff.js"> </script>	
 	<link rel="stylesheet" type="text/css" href="../../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../../css/mstrPg_acStaff.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 	
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
    <h1>Master List Page - academic staff</h1>
		<div class="table-responsive">
			<h5 class="card-title">List of academic staff</h5>
			<table class="table table-bordered table-hover" id="staffList">
				<thead>
					<tr>
						<th colspan="5">Staff detail</th>
						<th colspan="2">Unit
							<button type="button" class="btn btn-light" id="charge" name="charge_edit" value="charge_edit"><img src="../../img/mst_chng.png" alt ="add new unit"></button>
							<button type="button" class="btn btn-light" id="finish" name="finish" value="finish"><img src="../../img/mst_tick.png" alt ="finish"></button>
							
						</th>
						<th rowspan="2"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#addstaffModal" id="addstaff"><img src="../../img/mst_newStaff.png" alt ="add new staff"></button></th>
					</tr>
					<tr>
						<th>Staff ID</th>
						<th>Staff Name</th>
						<th>Qualification</th>
						<th>Expertise</th>
						<th>Unavailability</th>
						<th>Unit Code</th>
						<th>Post</th>
					</tr>
				</thead>
			<tbody>
			<?php 
				$i = 0;
				while ( $row = $resultData -> fetch_array(MYSQLI_ASSOC)){ 
					
			?>
				<tr>
					<td>
						<span id ="userID_<?php echo $i ?>"><?php echo $row["userID"] ?></span>
					</td>
					<td>
						<span><?php echo $row["username"] ?></span>
					</td>
					<td>
						<span><?php echo $row["qualification"] ?></span>
					</td>
					<td>
				
						<span><?php echo $row["expertise"] ?></span>
					</td>
					<td>
						<?php 
						//display unavailable	
						foreach ($resultData2 as $unavailable) { 
							
							if ($unavailable["userID"] == $row["userID"] && $unavailable["day"]){ 
								
								switch ($unavailable["day"]) {
									case 1: 
										echo "MON ";
										break;
									case 2: 
										echo "TUE ";
										break;
									case 3: 
										echo "WED ";
										break;
									case 4: 
										echo "THU ";
										break;
									case 5: 
										echo "FRI ";
										break;
								}
								
								//create unavailable start time
								if(strpos($unavailable["stat_time"],'.5') === false){
									echo $unavailable["stat_time"].":00 - ";
								} else {
									$time = explode(".",$unavailable["stat_time"]);
									echo $time[0].":30 - ";
								}
								
								//create unavailable end time
								if(strpos($unavailable["end_time"],'.5') === false){
									echo $unavailable["end_time"].":00 <br>";
								} else {
									$endtime = explode(".",$unavailable["end_time"]);
									echo $endtime[0].":30 <br>";
								}
							}
						 } ?>
					</td>
					<td>
						<select  class="editBox unitlist" id="unit_code_<?php echo $i ?>">
							<option></option>
							<?php foreach ($resultData1 as $unitCode) { 
								if ($unitCode["unit_code"] == $row["unit_code"]){ ?>
									<option selected="" value="<?php echo $unitCode["unit_code"] ?>"><?php echo $unitCode["unit_code"] ?></option>
							<?php } else { ?>
									<option value="<?php echo $unitCode["unit_code"] ?>"><?php echo $unitCode["unit_code"] ?></option>
							<?php }} ?>
						</select>
						<span class="unit_code"><?php echo $row["unit_code"] ?></span>
					</td>
					<td>
						<select  class="editBox postlist" id="post_<?php echo $i ?>">
							
							<?php if($row["access"] == "STF") { ?>
								<option value="STF" selected="">STAFF</option>
							<?php } else { ?>
								<option value="STF">STAFF</option>
							<?php } ?>
							
							<?php if($row["access"] == "TUT") { ?>
								<option value="TUT" selected="">TUTOR</option>
								<?php } else { ?>
								<option value="TUT">TUTOR</option>
							<?php } ?>
							
							<?php if($row["access"] == "LEC") { ?>
								<option value="LEC" selected="">LECTURER</option>
							<?php } else { ?>
								<option value="LEC">LECTURER</option>
							<?php } ?>
						</select>
						
						<?php 
						$post = "";
						switch ($row["access"]) {
							case "STF": 
								$post = "STAFF";
								break;
							case "TUT": 
								$post =  "TUTOR";
								break;
							case "LEC": 
								$post =  "LECTURER";
								break;
						}
					
					
							
						?>
						<span id="id_<?php echo $i ?>" class="post"><?php echo $post ?></span>
						
					
					</td>
					<td>
						<button type="button" class="btn btn-light removeBtn" id="remove_<?php echo $i ?>" name="remove" value="remove"><img src="../../img/mst_bin.png" alt ="remove"></button>
					</td>
				</tr>
			<?php 
					$i++;
				}
				$insert = $mysqli -> query($qur);
				$mysqli ->close();
				
			?>
			
				</tbody>
			</table>
		</div>
    </div>

	<div class="modal fade" id="addstaffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchLabel">Add New STAFF</h5>
					</div>
					
					<div class="modal-body" id="searchBody">
						<form role="form">
							<div class="form-group">
							<label class="col-form-label">staff ID</label>
							<input type="text" class="form-control" id="StaffId" name="StaffId">
						</div>
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Staff Name</label>
							<input type="text" class="form-control" id="Name" name="Name">
						</div>
						
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Qualification</label>
							<div class="col-sm-8">
								<select id="qualificationM" name ="qualification" class="form-control">
									<option value=""></option>
									<option value="PhD">PhD</option>
									<option value="Master">Master</option>
									<option value="Degree">Degree</option>
									<option value="Other">Other</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Expertise</label>
							<div class="col-sm-8">
								<select id="expertiseM" name="expertiseM" class="form-control">
									<option value=""></option>
									<option value="Information Systems">Information Systems</option>
									<option value="Human Computer Interaction">Human Computer Interaction</option>
									<option value="Network Administration">Network Administration</option>
									<option value="Other">Other</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Unit Code</label>
							<div class="col-sm-8">
								<select id="unit_codeM" name="unit_codeM" class="form-control">
									<option></option>
									<?php foreach ($resultData1 as $unitCode) { 
										if ($unitCode["unit_code"] == $row["unit_code"]){ ?>
											<option selected="" value="<?php echo $unitCode["unit_code"] ?>"><?php echo $unitCode["unit_code"] ?></option>
									<?php } else { ?>
											<option value="<?php echo $unitCode["unit_code"] ?>"><?php echo $unitCode["unit_code"] ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="serchUnit" class="col-form-label">Post</label>
							<div class="col-sm-8">
								<select id="postM" name="postM" class="form-control">
									<option value=""></option>
									<option value="STF">STAFF</option>
									<option value="TUT">TUTOR</option>
									<option value="LEC">LECTURER</option>
								</select>
							</div>
						</div>
						<button type="button" class="btn btn-success" id="insertStaff" name="insertStaff" value="add">Add</button>
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
