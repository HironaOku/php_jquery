<?php
	include('../../db_conn.php'); //db connection
	include("../../session.php");
//checklogin

	if($_SESSION['access'] == ""){
		$msg ="Please login.";
		header('Location: ../../index.php?error='.$msg.'');

	} else if ($_SESSION['access'] == 'DC'){
		$username = $_SESSION['username'];
		
	} else {
		$msg ="Your account is not allowed to access.";
		header('Location: ../../index.php?error='.$msg.'');
	}
	if(isset($_GET['error'])){
		$errormessage=$_GET['error'];
		echo "<script>alert('$errormessage');</script>";
	}
	$query = "SELECT * FROM `unit_detail` ORDER BY `unit_code`;";
	$resultData = $mysqli -> query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="../../js/masterUnit.js"> </script>	

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    
 	<link rel="stylesheet" type="text/css" href="../../css/style.css">
 	<link rel="stylesheet" type="text/css" href="../../css/masterUnit.css">
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
    <h1>Master List Page - Unit</h1>
		<div class="table-responsive">
			<form>
				<table class="table table-bordered table-hover" id="staffList">
					<thead>
						<tr>
							<th colspan ="3">Unit details</th>
							<th colspan="3">Semester</th>
							<th rowspan="2">Credits</th>
							<th rowspan="2"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#add_unit" id="addUnit"><img src="../../img/mst_newStaff.png" alt ="add new unit"></button></th>
						</tr>
						<tr>
							<th>Unit Code</th>
							<th>Unit Name</th>
							<th>Brief description</th>
							<th>Pandora</th>
							<th>Rivendell</th>
							<th>Neverland</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							while ( $row = $resultData -> fetch_array(MYSQLI_ASSOC)){ 
						?>
						<tr>
							<td><span class="id_<?php echo $row["id"] ?>"><?php echo $row["unit_code"] ?></span>
								<input id ="unitCode_<?php echo $row["id"] ?>" class="edit_<?php echo $row["id"] ?> editBox" type="text" name="unit_code" value="<?php echo $row["unit_code"] ?>">
							</td>
							<td><span class="id_<?php echo $row["id"] ?>"><?php echo $row["unit_name"] ?></span>
								<input id ="unitName_<?php echo $row["id"] ?>" class="edit_<?php echo $row["id"] ?> editBox" type="text" name="unit_name" value="<?php echo $row["unit_name"] ?>">
							</td>
							<td class ="description"><span class="id_<?php echo $row["id"] ?>"><?php echo $row["description"] ?></span>
								<textarea rows="10" cols="40" id ="description_<?php echo $row["id"] ?>" class="edit_<?php echo $row["id"] ?> editBox" name="description"> <?php echo $row["description"] ?></textarea>
							</td>
							<td>
								
								<?php 
									$sem = array("s1","s2","W","S");

									for( $i=0; $i < 4; $i++){
										$semPandora = SUBSTR($row["pandora"],$i,1);
										if($semPandora == "1"){
								?>
										<label>
											<input id ="semPandora<?php echo $row["id"].$i ?>" type="checkbox" name="semPandora" class="semesterP chkbox_<?php echo $row["id"] ?> " value="<?php echo $i ?>" disabled="" checked="" >
											<?php echo $sem[$i] ?>
										</label>
									
									<?php } else { ?>
										
										<label>
											<input id ="semPandora<?php echo $row["id"].$i ?>" type="checkbox" name="semPandora" class="semesterP chkbox_<?php echo $row["id"] ?>" value="<?php echo $i ?>" disabled="">
											<?php echo $sem[$i] ?>
										</label>
										
									<?php }
									}
								?>								
							</td>
							<td>
								<?php 
									for( $i=0; $i < 4; $i++){
										$semRivendell = SUBSTR($row["rivendell"],$i,1);
										if($semRivendell == "1"){
								?>
										<label>
											<input id ="rivendell<?php echo $row["id"].$i ?>" type="checkbox" name="semRivendell" class="semesterR chkbox_<?php echo $row["id"] ?>" value="<?php echo $i ?>" disabled="" checked="">
											<?php echo $sem[$i] ?>
										</label>
									
									<?php } else if ($semRivendell == "0"){ ?>
										
										<label>
											<input id ="rivendell<?php echo $row["id"].$i ?>" type="checkbox" name="semRivendell" class="semesterR chkbox_<?php echo $row["id"] ?>" value="<?php echo $i ?>" disabled="">
											<?php echo $sem[$i] ?>
										</label>
										
									<?php }
									}
								?>								
							</td>
							<td>
								<?php 
									for( $i=0; $i < 4; $i++){
										$semNeverland = SUBSTR($row["neverland"],$i,1);
										if($semNeverland == "1"){
								?>
										<label>
											<input id ="neverland<?php echo $row["id"].$i ?>" type="checkbox" name="semNeverland" class="semesterN chkbox_<?php echo $row["id"] ?>" disabled="" checked="">
											<?php echo $sem[$i] ?>
										</label>
									
									<?php } else if ($semNeverland == "0"){ ?>
										
										<label>
											<input id ="neverland<?php echo $row["id"].$i ?>" type="checkbox" name="semNeverland" class="semesterN chkbox_<?php echo $row["id"] ?>" disabled="">
											<?php echo $sem[$i] ?>
										</label>
										
									<?php }
									}
								?>								
							</td>
							<td class ="credit"><span class="id_<?php echo $row["id"] ?>"><?php echo $row["credit"] ?></span>
								<input id ="credit_<?php echo $row["id"] ?>" class="edit_<?php echo $row["id"] ?> editBox" type="text" name="credit" value="<?php echo $row["credit"] ?>">
							</td>
							<td><button type="button" class="editBtn btn-light" id="<?php echo $row["id"] ?>" name="edit" value="edit" alt="edit"><img src="../../img/mst_edit.png" alt ="edit unit"></button>
								<button type="button" class="deleteBtn btn-light" id="<?php echo $row["id"] ?>" name="delete" value="delete" alt="delete"><img src="../../img/mst_bin.png" alt ="delete unit"></button>
								<button type="button" class="saveBtn btn-light" id="<?php echo $row["id"] ?>" name="save" value="delete" alt="save"><img src="../../img/mst_save.png" alt ="save unit"></button></td>
							</tr>
					<?php 	}
						$resultData ->close();
						$mysqli ->close(); ?>
					</tbody>
				</table>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<?php 
								if($_SESSION['USER'] == 'Degree Coordinator' || $_SESSION['USER'] == 'Unit Coordinator'){					
									echo ("<input type=\"button\" name=\"modifyStaff\" form=\"addStafform\" value=\"submit\">");
								} 					
						?>
					</div>
				</div>
			</div>
		</form>
    </div>
    
			
			
			<div class="modal fade" id="add_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="searchLabel">Add New Unit</h5>
						</div>
						<div class="modal-body" id="searchBody">
							<form role="form">
								<div class="form-group">
									<label for="serchUnit" class="col-form-label">Unit Code</label>
									<input type="text" class="form-control" id="unitCode" name="unitCode">
								</div>
								<div class="form-group">
									<label for="serchUnit" class="col-form-label">Unit Name</label>
									<input type="text" class="form-control" id="unitName" name="unitName">
								</div>
								<div class="form-group">
									<label for="serchUnit" class="col-form-label">Brief description</label>
									<textarea id= "description" class="form-control" rows="20" cols="45" name="description"></textarea>
								</div>
								
								<div class="form-group">
									<h3>Semester</h3>
									<h4><label for="serchUnit" class="col-form-label">Pandora</label></h4>
									
										<input id ="semPandora0" type="checkbox" name="semPandora" class="semesterP chkbox" value="0">
										<label>Semester1</label>
									
										<input id ="semPandora1" type="checkbox" name="semPandora" class="semesterP chkbox" value="1">
										<label>Semester2</label><br>
										
										<input id ="semPandora2" type="checkbox" name="semPandora" class="semesterP chkbox" value="2">
										<label>Winter School</label>
									
										<input id ="semPandora3" type="checkbox" name="semPandora" class="semesterP chkbox" value="3">
										<label>Spring School</label>

									<h4><label for="serchUnit" class="col-form-label">Rivendell</label></h4>
									
										<input id ="rivendell0" type="checkbox" name="semRivendell" class="semesterR chkbox" value="0">
										<label>Semester1</label>
									
										<input id ="rivendell1" type="checkbox" name="semRivendell" class="semesterR chkbox" value="1">
										<label>Semester2</label><br>
										
										<input id ="rivendell2" type="checkbox" name="semRivendell" class="semesterR chkbox" value="2">
										<label>Winter School</label>
									
										<input id ="rivendell3" type="checkbox" name="semRivendell" class="semesterR chkbox" value="3">
										<label>Spring School</label>

									<h4><label for="serchUnit" class="col-form-label">Neverland</label></h4>
									
										<input id ="neverland0" type="checkbox" name="semNeverland" class="semesterN chkbox" value="0">
										<label>Semester1</label>
									
										<input id ="neverland1" type="checkbox" name="semNeverland" class="semesterN chkbox" value="1">
										<label>Semester2</label><br>
										
										<input id ="neverland2" type="checkbox" name="semNeverland" class="semesterN chkbox" value="2">
										<label>Winter School</label>
									
										<input id ="neverland3" type="checkbox" name="semNeverland" class="semesterN chkbox" value="3">
										<label>Spring School</label>
										<div class="form-group">
											<label for="serchUnit" class="col-form-label">credit</label>
											<input type="text" class="form-control" id="credit" name="credit">
										</div>
									</div>
								<button type="button" class="btn btn-success" id="insertUnit" name="insertUnit" value="add">Add</button>
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
