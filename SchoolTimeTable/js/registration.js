$(document).ready(function(){
	//display for student
	$("#fromStudent").change(function(){
		$("div#formContainer").show();
		$(".StudentForm").show();
		$(".StaffForm").hide();
		$('h3').text("CMS Student Registration From");
		
		$("#telOption").text("Phone number (optional):");
	});
	
	
	//display for stuff
	$("#fromStaff").change(function(){
		$("div#formContainer").show();
		$('.StudentForm').hide();
		$(".StaffForm").show();
		$('h3').text("CMS Staff Registration From");
		$("#telOption").text("Phone number :");
	});
});

	//login check
	function valiPass(){
	
	if ($("#S_id").val() === "") {
			alert("Please enter student / staff ID");
			$("#S_id").focus();
			return false;
		}
		var passVal = $("#password").val();
		
		if (passVal === "") {
			alert("Please enter user password");
			$("#password").focus();	
			return false;
			
		} 
	}
	
	function validation(){
		var guest = $("input[name='occu']:checked").val();
		
		//Guest is student
		if (guest == "fromStudent"){
			
			//Student ID check
			if ($("#StudentId").val() === "") {
			alert("Please enter student ID");
			$("#StudentId").focus();
			return false;
			}
		} 
		
		//Guest is staff
		if (guest == "fromStaff"){
			//Staff ID check
			if ($("#StaffId").val() === "") {
			alert("Please enter staff ID");
			$("#StaffId").focus();
			return false;
			}
			
			//qualfication check
			if($("#qualification").val() === ""){
				alert("Please select your qualification");
				$("#qualification").focus();
				return false;
			}
			
			//expertise check
			if($("#expertise").val() === ""){
				alert("Please select your expertise");
				$("#expertise").focus();
				return false;
			}
			
			//phone nm check
			if($("#tel").val() === ""){
				alert("Please enter your phone number");
				$("#tel").focus();
				return false;
			}
			
		}
		
		if ($("#Name").val() === "") {
			alert("Please enter your name");
			$("#Name").focus();
			return false;
		}
		
		
		//password check
		var passVal = $("#pass").val();
		var confPassVal = $("#confPass").val();
		
		if (passVal === "") {
			alert("Please enter user password");
			$("#pass").focus();	
			return false;
			
		} else if (!passVal.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^])[A-Za-z\d!@#$%^]{6,12}$/)){
			alert("Password must contains at least 1 lowercase letter, 1 uppercase letter,1 number and one of following special characters ! @ # $ % ^ and 6 to 12characters.");
			
			$("#pass").focus();	
			return false;
		}
		
		//check comfirm pass
		if (confPassVal === "") {
			alert("Please re-type the password");
			$("#confPass").focus();
			return false;	
			
		//check password and comfirm pass
		} else if (passVal !== confPassVal) {
			alert("Password do not match");
			
			$("#confPass").focus();		
			return false;
		}
		
		
		//Email check
		if (!$("#email").val().match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
			alert("Please enter your vaild email address");
			$("#email").focus();
			return false;
		}
		
		
	}
