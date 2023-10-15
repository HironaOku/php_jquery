<?php

	include("../session.php");
	include('../db_conn.php'); //db connection
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
	
	$query ="SELECT l.`id` AS 'MlecID', l.`unit_code`, u.`unit_name`, l.`campus`, l.`semester`, s.`unit_code` as 'enrUnit', s.`lecID`, s.`userID` FROM `lec_manage` l LEFT JOIN `unit_detail` u ON l.`unit_code` = u.`unit_code` LEFT JOIN `student_enrl` s ON l.`id` = s.`lecID` AND s.`userID` = '$session_userID' ORDER BY l.`unit_code`, s.`lecID` DESC";
	$unitList = $mysqli -> query($query);


	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../js/unit_enrolment.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../css/unit_enrolment.css">
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
    
    
    <h1>Unit Enrolment</h1>
    <div id="enrollwrap">
	    <div class="row">

			<div class="col-md-10" id="unitEnroledwrap">
				<div class="table-responsive">
					<h5 class="card-title">
						<button type="button" class="btn btn-info hidedisp" id="dipPandora" name="dipPandora" value="dipPandora">Pandora</button>
						<button type="button" class="btn btn-info hidedisp" id="dipNeverland" name="dipNeverland" value="dipNeverland">Neverland</button>
						<button type="button" class="btn btn-info hidedisp" id="dipRivendell" name="dipRivendell" value="dipRivendell">Rivendell</button>
					</h5>
					<table class="table table-sm">
						<tbody>
							<tr>
								<th>Unit ID</th>
								<th>Campus</th>
								<th>Unit code</th>
								<th>Unit name</th>
								<th>Semester</th>
								<th>Status</th>
								<th>Enroll</th>
							</tr>
							
							<?php 
								$enrolFlag = "0";
								while ( $row = $unitList -> fetch_array(MYSQLI_ASSOC)){ 
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
										

							?>
										<tr class="disp_<?php echo($row['campus']) ?>">
											<td><?php echo($row['MlecID']) ?></td>
											<td><?php echo($row['campus']) ?></td>
											<td><span id="unitcode_<?php echo($row['MlecID']) ?>"><?php echo($row['unit_code']) ?></span></td>
											<td><?php echo($row['unit_name']) ?></td>
											<td><?php echo($semester) ?></td>
											
										<?php if($row['lecID']=="" && $enrolFlag != $row['unit_code']){ //if student is not enrolled in this unit?>
											<td></td>
											<td><button type="button" class="btn btn-info btn-sm btnEnrol" id="<?php echo($row['MlecID']) ?>">Enrol</button></td>
											
										<?php } else if($row['lecID'] !=""){ ////if student is enrolled in this unit
											$enrolFlag = $row['unit_code'];
											$enrolFlag2 = $row['MlecID'];
											$enrolFlag3 = $row['campus'];
										?>
											<td>Enroled</td>
											<td><button type="button" class="btn btn-light btn-sm btnWithdrow" id="<?php echo($row['MlecID']) ?>">Withdraw</button></td>
											
										<?php } else { ?>
											<td colspan="2"> 
												<p class="h6">
													<small class="text-muted">to enrol this Unit, please withdraw UNIT ID : <?php echo($enrolFlag2) ?> in <?php echo($enrolFlag3) ?></small>
												</p>
											</td>
											<td></td>
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
					<a href="#" class="list-group-item list-group-item-action active" id="listTitle">Enroled Unit<br><span id="stuID"><?php echo($session_userID) ?></span></a>
					
					<?php //create enroed Unit lost
						foreach ($unitList as $row3){
							if($row3['enrUnit']){
					?>
						  	<a href="#" class="list-group-item list-group-item-action">
							  	<?php echo $row3['unit_code'] ?><br><?php echo $row3['unit_name'] ?><br><?php echo $row3['campus'] ?></a>
					<?php }
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
