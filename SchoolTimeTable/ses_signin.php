<?php
	include("session.php");
	
	if ($session_user!=""){
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
	<title>Sign in</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>	
	<script type="text/javascript" src="./registration.js"> </script>	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
    <link rel="stylesheet" type="text/css" href="tute7_registration.css">
</head>
<body>
    
	<div class="container" id = "createAccount">
		
	    <div class="container">
		    <h3>Sign in</h3>
			<div class="container" id="formContainer">
				<form onsubmit="return valiPass()" id="regiForm" class="form-horizontal" method="post" action="ses_engine.php">
				<div class="form-group">	
					<input type="text" name="Name" id="Name" placeholder="Username" class="form-control">
				</div>
				<div class="form-group">	
					<input type="password" name="password" id="pass" placeholder="Password" class="form-control">
				</div>
					<input type="submit" name="login" class="btn btn-primary button" value="Sign in"><br><br>
					<a href="tute7_main.php"><button type="button" class="btn btn-danger button">Cancel</button></a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
