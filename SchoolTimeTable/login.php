
<?php
	include("session.php");
	
	if ($session_userID!=""){
		header("location:./ses_success.php");
	}
	
	if(isset($_GET["error"])){
		$errorMsg = $_GET["error"];
		echo "<script>alert('$errorMsg');</script>";
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
 	<link rel="stylesheet" type="text/css" href="./css/login.css">
</head>
<body>
	<div id="conteiner">		
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
		<h3>Log in</h3>
		<div class="container" id="formContainer">
			<p id="error"><?php echo $message ?></p>
			<form onsubmit="return valiPass()" id="regiForm" class="form-horizontal" method="post" action="ses_engine.php">
				<div class="form-group">
					<label for="ID" class="col-sm-4 control-label">Student / Staff ID</label>
					<div class="col-sm-8">
						<input id="S_id" type="text" name="S_id">
					</div>
				</div>
				<div class="form-group">
					<label for="password"  class="col-sm-4 control-label">Password</label>
					<div class="col-sm-8">
						<input id="password" type="password" name="password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<input type="submit" name="login" class="btn btn-primary button" value="Sign in">
					</div>
				</div>
			</form>
			<p>Don't have your account? You can <a href="registration_form.php">register</a> here.</p>
		 </div>
		<footer>
			<p>The University of DoWell</p>
	 	</footer>
	</body>
</html>
