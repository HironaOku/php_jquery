<?php
	include("session.php");

	if(isset($_GET['error'])){
		$errormessage=$_GET['error'];
		echo "<script>alert('$errormessage');</script>";
	}
	
	if(isset($_GET['success'])){
		$message=$_GET['success'];
		echo "<script>alert('$message');</script>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>		
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="./css/style.css">
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
	
		<div id="imgConteiner">    
			<h1>The University of DoWell in Wonderland</h1>
			<h2>Course Management System</h2>
			
			<?php if($_SESSION['session_user']){ ?>
				<p>Welcome <?php echo $_SESSION['session_user'] ?>. Logging in as <?php echo $_SESSION['access'] ?> account.</p>
			<?php } ?>
			
		</div>
		
		<div id="linkConteiner" class="container">
			<div class="row">
				
				<div class="col-md-6">
					<div class="media position-relative linkbox">
						<a href="./registration_form.php" class="stretched-link"><img src="img/indx_register.png" alt="indx_register" width="64" height="64" ></a>
						<div class="media-body">
							<h5 class="mt-0">Registration to CMS</h5>
							<p>New student and staff can register to use CMS.</p>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="media position-relative linkbox">
						<a  href="<?php echo ($accountLink); ?>" class="stretched-link"><img src="img/indx_account.png" alt="account" width="64" height="64"></a>
						<div class="media-body">
							<h5 class="mt-0">Account Detail</h5>
							<p>Confirm and edit account detail</p>
						</div>
					</div>
				</div>

			</div>
			<div class="row">
				
				<div class="col-md-6">
					<div class="media position-relative linkbox">
						<a href="./unit_detail.php" class="stretched-link"><img src="img/indx_unitdetail.png" alt="Unit details" width="64" height="64" ></a>
						<div class="media-body">
							<h5 class="mt-0">Unit details</h5>
							<p></p>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="media position-relative linkbox">
						<a href="./student/my_timetable.php" class="stretched-link"><img src="img/indx_timetable.png" alt="indx_register" width="64" height="64" ></a>
						<div class="media-body">
							<h5 class="mt-0">Timetable</h5>
							<p>Student can check timetable.</p>
						</div>
					</div>
				</div>

			</div>
			
			
		</div>



	</div>
	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
