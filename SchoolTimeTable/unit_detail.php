<?php
	include("session.php");
	include('db_conn.php'); 

	if(isset($_GET["searchUnit"])){
		 
		$searchUnit = $_GET["searchUnit"];
		$query = "SELECT u.`unit_code`, u.`unit_name`, u.`description`, u.`pandora`, u.`rivendell`, u.`neverland`, u.`credit`, u.`UC`, d.`username` FROM `unit_detail` u LEFT JOIN `dw_users` d ON u.`UC` = d.`userID` WHERE u.`unit_code` = '$searchUnit'" ;
	} else {
		$query =  "SELECT u.`unit_code`, u.`unit_name`, u.`description`, u.`pandora`, u.`rivendell`, u.`neverland`, u.`credit`, u.`UC`, d.`username` FROM `unit_detail` u LEFT JOIN `dw_users` d ON u.`UC` = d.`userID` WHERE u.`unit_code` = (SELECT MIN(`unit_code`) FROM `unit_detail`)";	
	}

	$resultData = $mysqli -> query($query);
	
	$query1 = "SELECT `unit_code`, `unit_name` FROM `unit_detail` ORDER BY `unit_code`;";
	$resultData1 = $mysqli -> query($query1);
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Registration</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="./js/unit_detail.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
 	<link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/unit_detail.css">
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
	
		<main role="main" class="container">
			<div class="starter-template">
				<h1>Unit detail</h1>
				<div class="container">
					<div class="row justify-content-md-center">
						<?php 
							while ( $row1 = $resultData -> fetch_array(MYSQLI_ASSOC)){ 
						?>
				    	<div class="col-md-10" id="unitDetailwrap">
			      			<div class="card" id="unitDetail">
								<div class="card-header"  class="unitDetail1">
									<h2 id="uniCode"><?php echo $row1['unit_code'] ?></h2>
									<h3 id="uniName"><?php echo $row1['unit_name'] ?><h3>
								</div>
								<div class="card-body" class="unitDetail1">
									
									<h5 class="card-title">Brief description about this unit</h5>
									<p class="card-text"><?php echo $row1['description'] ?></p>
																	
									<h5 class="card-title">Unit coordinator</h5>
									<p id="UCname">
										<?php 
										if($row1['username']){
											echo $row1['username'];
										} else {
											echo "under consideration";
										}?>
									</p>
									<h5 class="card-title">Credit</h5>
									<p id="Credit">
										<?php 
										if($row1['credit']){
											echo $row1['credit'];
										} else {
											echo "under consideration";
										}?>
									</p>
									<div class="table-responsive">
										<h5 class="card-title">Available semester and campus</h5>
										<table class="table table-sm">
											<tbody>
												<tr>
													<th></th>
													<th>Semester 1</th>
													<th>Semester 2</th>
													<th>Winter School</th>
													<th>Spring School</th>
												</tr>
												<tr>
													<th>Pandora</th>
													<?php 
														//Pandora semester
														for( $i=0; $i < 4; $i++){
															$semPandora = SUBSTR($row1["pandora"],$i,1);
															if($semPandora == "1"){
													?>
																<td>○</td>
													<?php			
															}else{
													?>
																<td>ー</td>
													<?php			
															}
														}
													?>
												</tr>
												<tr>
													<th>Rivendell</th>
													<?php 
														//Rivendell semester
														for( $i=0; $i < 4; $i++){
															$semRivendell = SUBSTR($row1["rivendell"],$i,1);
															if($semRivendell == "1"){
													?>
																<td>○</td>
													<?php			
															}else{
													?>
																<td>ー</td>
													<?php			
															}
														}
													?>
												</tr>
												<tr>
													<th>Neverland</th>
													<?php 
														//Neverland semester
														for( $i=0; $i < 4; $i++){
															$semNeverland = SUBSTR($row1["neverland"],$i,1);
															if($semNeverland == "1"){
													?>
																<td>○</td>
													<?php			
															}else{
													?>
																<td>ー</td>
													<?php			
															}
														}
													?>
												</tr>
											</tbody>
										</table>
									</div>
														
									<a href="./unit_enrolment.php" class="btn btn-outline-info">Unit Enrolment</a>
								</div>
							</div>	
				    	</div>
						<?php 
							}
						?>			    	
				    	
						<div class="col-md-2">
							<div class="list-group" id="unitList">
								<a href="#" class="list-group-item list-group-item-action active" id="listTitle">Unit List</a>
							<?php 
								while ( $row = $resultData1 -> fetch_array(MYSQLI_ASSOC)){ 
							?>
							    
								  	<a href="unit_detail.php?searchUnit=<?php echo $row['unit_code'] ?>" class="list-group-item list-group-item-action " id="<?php echo $row['id'] ?>"><?php echo $row['unit_code'] ?>
								  	<span><br><?php echo $row['unit_name'] ?></span></a>
							<?php } ?>
							</div>				
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
<?php 	
	$resultData ->close();
	$mysqli ->close(); ?>
   
	<footer>
		<p>The University of DoWell</p>
 	</footer>
</body>
</html>
