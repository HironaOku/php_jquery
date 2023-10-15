$(document).ready(function(){
	$("#charge").click(function(){
		
		$(".unit_code").toggle();
		$(".editBox").toggle();
		$(".post").toggle();
		$("#charge").toggle();
		$("#finish").toggle();
	});
	
	$("#finish").click(function(){
		$(".unit_code").toggle();
		$(".editBox").toggle();
		$(".post").toggle();
		$("#charge").toggle();
		$("#finish").toggle();
		
		var unitCode = $("#unitCode").val();
		var unitName = $("#unitName").val();
		
		location.reload();
		
	});
	
	
	$('.unitlist').change(function() {
		var id = $(this).attr('id');
		var unitSelect = "#" + id;
		var unitCode = $(unitSelect).val();
		var dispID = id.slice( 10 ) ;
		var userID0 = "#userID_" + dispID;
		var userId = $(userID0).text();

		
		$.get("masterStaff_update.php", {
			userId:userId,
			unitCode:unitCode
			
		}).done(function(data){
			$(unitSelect).focus();
		});
	});
	
	//POST chenge
	$('.postlist').change(function() {
		var id = $(this).attr('id');
		var postSelect = "#" + id;
		var post = $(postSelect).val();
		var dispID = id.slice( 5 ) ;
		var userID0 = "#userID_" + dispID;
		var userId = $(userID0).text();
		
		$.get("masterStaff_updatepost.php", {
			userId:userId,
			post:post
			
		}).done(function(data){
			$(unitSelect).focus();
		});
		
		
	});	
	
	//DELETE
	$(".removeBtn").click(function(){
		var id = $(this).attr('id');
		var dispID = id.slice( 7 ) ;
		var userID0 = "#userID_" + dispID;
		var userId = $(userID0).text();
		
		if (userId ==""){
			return false;
		}
		if(!confirm('Are you sure?? ')){
			return false;
		}else{
			$.get("masterStaff_delete.php", {
				userId:userId
			}).done(function(data){
				alert(userId + " has been deleted..... ")
				location.reload();
			});
		}
	});
	
	$("#insertStaff").click(function(){
		var staffId = $("#StaffId").val();
		var name = $("#Name").val();
		var qualification = $("#qualificationM").val();
		var expertise = $("#expertiseM").val();
		var unit_code = $("#unit_codeM").val();
		var postM = $("#postM").val();
		
		
		if (staffId === ""){
			alert("staff Id is required");
			$("#StaffId").focus();
			
		} else if  (name === ""){
			alert("staff name is required");
			$("#Name").focus();
			
		} else {
			$.get("masterStaff_insert.php", {
				
				staffId:staffId,
				name:name,
				qualification:qualification,
				expertise:expertise,
				unit_code:unit_code,
				postM:postM
				
			}).done(function(data){
				alert("You have added a unit successfully!!");
				$("#StaffId").val("");
				$("#Name").val("");
				location.reload();
				
			});
		}		
		
	});
});