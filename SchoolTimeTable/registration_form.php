<?php
include("session.php");
if(isset($_GET['error'])){
	$errormessage=$_GET['error'];
	echo "<script>alert('$errormessage');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="./js/registration.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/registration.css">
</head>
<body>
	
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<img src="./img/UDW.png" alt="The University of DoWell" title="The University of DoWell">
			<a class="navbar-brand" href="#">Course Management System</a>	
			<div class="navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active"></li>
	                <li class="nav-item"><a class="nav-link" href="./index.php">Home<span class="sr-only">(current)</span></a></li>

					<?php if($_SESSION['access'] == 'STD'){ 
						$accountLink = "./student/userAccount_STD.php";
					?>
						<li class="nav-item"><a class="nav-link" href="./student/unit_enrolment.php">Unit Enrolment</a></li>
						<li class="nav-item"><a class="nav-link" href="./student/tutorial_allocation.php">Tutorial Allocation</a></li>
						<li class="nav-item"><a class="nav-link" href="./student/my_timetable.php">Timetable</a></li>
						
					<?php } else if ($_SESSION['access'] == 'DC'){ 
						$accountLink = "./staff/userAccount_STF.php";
					?>
					
						<li class="nav-item"><a class="nav-link" href="./staff/master/masterUnit.php">Master Unit</a></li>
						<li class="nav-item"><a class="nav-link" href="./staff/master/masterStaff.php">Master Staff</a></li>
						<li class="nav-item"><a class="nav-link" href="./staff/master/unitManage.php">Unit Management</a></li>
						
					<?php } else if ($_SESSION['access'] == 'UC'){ 
						$accountLink = "./staff/userAccount_STF.php";
					?>
						<li class="nav-item"><a class="nav-link" href="./staff/master/unitManage.php">Unit Management</a></li>

					<?php } 
						 
						 if ($_SESSION['access'] == 'DC' or $_SESSION['access'] == 'UC' or $_SESSION['access'] == 'LEC' or $_SESSION['access'] == 'TUT'){ 
							 $accountLink = "./staff/userAccount_STF.php";
						 ?>
					
						<li class="nav-item"><a class="nav-link" href="./staff/enrolledStudent.php">Enrolled Student</a></li>
						
					<?php } 
						if($_SESSION['access'] == 'STF'){
							$accountLink = "./staff/userAccount_STF.php";
						}
						
					?>
					
						<li class="nav-item"><a class="nav-link" href="./unit_detail.php">Unit Detail</a></li>
						<li class="nav-item"><a class="nav-link" href="./registration_form.php">Registration</a></li>
						
						<li class="nav-item">
						<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"></a>
						</li>
					</ul>
				
				<?php if($session_user == ""){ ?>
				
					<a class = "text-secondary"  href="login.php"><img src="img/login.png"><br><h5>Sign In</h5></a>
					
				<?php } else { ?>
					<form action="./ses_signout.php" method="post">
						<input type="image" src="img/logout.png" alt="Singn out" name="submit" value="Sign out"><p>logout</p>
					</form>
					
				<?php } ?>
				
			</div>
		</nav>
    
	<h3>CMS Registration</h3>
    <div class="container">
	    <div class="container" id="checkGuest">
		    <form class="form-horizontal">
			    <div class="form-group">
				    
				  	<label class="control-label">Are you Student or Staff??</label>
				    <div class="radio">
						<label><input type="radio" name="occu" id="fromStudent" value="fromStudent">Student</label>
						<label><input type="radio" name="occu" id="fromStaff" value="fromStaff">Staff</label>
				    </div>
			    </div>	    
			</form>
    	</div>
		

		<div class="container" id="formContainer">
			<form onsubmit="return validation()" id="regiForm" class="form-horizontal" method="post" action="registration.php">
				<div class="form-group StudentForm">
					<label class="col-sm-4 control-label">Student ID:</label>
					<div class="col-sm-8">
						<input type="text" name="StudentId" id="StudentId">
					</div>
				</div>
				
				<div class="form-group StaffForm">
					<label class="col-sm-4 control-label">Staff ID:</label>
					<div class="col-sm-8">
						<input type="text" name="StaffId" id="StaffId">
					</div>
				</div>
				
				<div class="form-group">	
					<label class="col-sm-4 control-label">Name:</label>
					<div class="col-sm-8">
						<input type="text" name="Name" id="Name">
					</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-4 control-label">Password:</label>
					<div class="col-sm-8">
						<input type="password" name="password" id="pass">
					</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-4 control-label">Confirm password:</label>
					<div class="col-sm-8">
						<input type="password" name="confirmpassword" id="confPass">
					</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-4 control-label">Email:</label>
					<div class="col-sm-8">
						<input type="email" name="email" id="email">
					</div>
				</div>
					
				<div class="form-group StaffForm">	
					<label  class="col-sm-4 control-label"><br>Qualification:</label>
					<div class="col-sm-8">
						<select id="qualification" name ="qualification" class="form-control">
							<option value=""></option>
							<option value="PhD">PhD</option>
							<option value="Master">Master</option>
							<option value="Degree">Degree</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
				
				<div class="form-group StaffForm">
					<label  class="col-sm-4 control-label">Expertise:</label>
					<div class="col-sm-8">
						<select id="expertise" name="expertise" class="form-control">
							<option value=""></option>
							<option value="Information Systems">Information Systems</option>
							<option value="Human Computer Interaction">Human Computer Interaction</option>
							<option value="Network Administration">Network Administration</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-6 control-label" id="telOption" >Phone number:</label>
					<div class="col-sm-6">
						<input type="tel" name="tel" id="tel">
					</div>
				</div>
				
				<div class="form-group StudentForm">
					<label class="col-sm-6 control-label">Address (optional):</label>
					<div class="col-sm-6">
						<input type="text" name="address" id="Address">
					</div>
				</div>
					
				<div class="form-group StudentForm">
					<label class="col-sm-6 control-label">Date of birth (optional):</label>
					<div class="col-sm-6">
						<input type="date" name="birthday" id="birthday">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<input type="submit" name="submit" value="Submit">
					</div>
				</div>
			</form>
		</div>
	</div>

	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
