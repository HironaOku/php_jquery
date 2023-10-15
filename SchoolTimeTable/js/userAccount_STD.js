	//change password function
	function vali(){ 
		//password check
		var oldPass = $("#oldpass").val();
		var newPass = $("#pass").val();
		var confPassVal = $("#confPass").val();

	if ($("#S_id").val() === "") {
			alert("Please enter student ID");
			$("#S_id").focus();
			return false;
		}

		if (oldPass === "") {
			alert("Please enter Your Current password");
			$("#oldpass").focus();	
			return false;
			
		} else if (newPass === "") {
			alert("Please enter New Pasword");
			$("#pass").focus();	
			return false;
			
		} else if (!newPass.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^])[A-Za-z\d!@#$%^]{6,12}$/)){
			alert("Password must contains at least 1 lowercase letter, 1 uppercase letter,1 number and one of following special characters ! @ # $ % ^ and 6 to 12characters.");
			
			$("#pass").focus();	
			return false;

		//check comfirm pass
		} else if (confPassVal === "") {
			alert("Please re-type the password");
			$("#confPass").focus();
			return false;	
			
		//check password and comfirm pass
		} else if (newPass !== confPassVal) {
			alert("Password do not match");
			
			$("#confPass").focus();		
			return false;
		} 
	
	}
	
	


$(document).ready(function(){	
	//show Pandora units
	$('#editAcc').on('click', function() {
		$('.accDisp').toggle();
		$('.accedit').toggle();
	});
	
	//after check vaviled insert
	$('#Submit').on('click', function() {
		if ($("#Name").val() === "") {
			alert("Please enter your name");
			$("#Name").focus();
			return false;
		} else if (!$("#email").val().match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
			alert("Please enter your vaild email address");
			$("#email").focus();
			return false;
		} else {
			var email = $('#email').val();
			var tel = $('#tel').val();
			var address = $('#address').val();
			var birthday = $('#birthday').val();

			$.get("userAccount_STD_update.php", {
				email:email,
				tel:tel,
				address:address,
				birthday:birthday
				
			}).done(function(data){
				alert("You have edited your account successfully!!");
				location.reload();
			});
		}

	});




});

