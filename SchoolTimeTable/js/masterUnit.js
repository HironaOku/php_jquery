$(document).ready(function(){
	
	
	//add click
	$("#insertUnit").click(function(){
		var unitCode = $("#unitCode").val();
		var unitName = $("#unitName").val();
		var description = $("#description").val();
		var credit = $("#credit").val();
		//var semester = $("#semester").val();
		
		//semester Pandora
		var semPandora = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#semPandora" + i;
			if ($(para).prop("checked") == true) {
				semPandora += "1";
			} else {
				semPandora += "0";
			}
		}
		
		//semester Rivendell
		var semRivendell = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#rivendell" + i;
			if ($(para).prop("checked") == true) {
				semRivendell += "1";
			} else {
				semRivendell += "0";
			}
		}

		//semester neverland
		var semNeverland = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#neverland" + i;
			if ($(para).prop("checked") == true) {
				semNeverland += "1";
			} else {
				semNeverland += "0";
			}
		}

		
		
		if (unitCode === ""){
			alert("Unit Code is required");
			$("#unitCode").focus();
			
		} else if  (unitName === ""){
			alert("Unit Name is required");
			$("#unitName").focus();
			
		} else if  (description === ""){
			alert("description is required");
			$("#description").focus();
			
		} else if  (credit === ""){
			alert("credit is required");
			$("#credit").focus();
			
		}	else if (!$("#credit").val().match(/^[-]?([1-9]\d*|0)(\.\d+)?$/)) {
			alert("Please enter your vaild credits ");
			$("#credit").focus();
			
		} else {
			$.get("masterUnit_insert.php", {
				
				unitCode:unitCode,
				unitName:unitName,
				description:description,
				semPandora:semPandora,
				semRivendell:semRivendell,
				semNeverland:semNeverland,
				credit:credit
				
			}).done(function(data){
				alert("You have added a unit successfully!!");
				$("#unitCode").val("");
				$("#unitName").val("");
				$("#description").val("");
				$("#credit").val("");
				location.reload();
				
			});
		}
	});
	
	//Delete
	$('.deleteBtn').on('click', function() {
		var id = $(this).attr('id');
		
		var unitCode1 = "#unitCode_" + id;
		var unitCode = $(unitCode1).val();
		
		$.get("masterUnit_delete.php", {
				unitCode:unitCode,
				id:id
				
			}).done(function(data){
				alert(unitCode + "has been deleted.");
				location.reload();
			});
	});
	
	
	//edit button click
	$('.editBtn').on('click', function() {
		
		var id = $(this).attr('id');
		var spnId = ".id_" + id;
		var editId = ".edit_" + id;
		var chkbox = ".chkbox_" + id;
		
		$(spnId).toggle();
		$(".saveBtn").toggle();
		$(editId).toggle();
		
		//disabled check box for semester
		var result = $(chkbox).prop('disabled');
		if(result) {
			$(chkbox).prop('disabled', false);
		} else {
			$(chkbox).prop('disabled', true);
		}
		return false;
	});
	
	//save for editing
	$('.saveBtn').on('click', function() {
		var id = $(this).attr('id');
		var unitCode1 = "#unitCode_" + id;
		var unitName1 = "#unitName_" + id;
		var description1 = "#description_" + id;
		var credit1 = "#credit_" + id;
		
		var unitCode = $(unitCode1).val();
		var unitName = $(unitName1).val();
		var description = $(description1).val();
		var credit = $(credit1).val();
		//var semester = $(semester1).val();
		
		//semester Pandora
		var semPandora = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#semPandora" + id + i;
			if ($(para).prop("checked") == true) {
				semPandora += "1";
			} else {
				semPandora += "0";
			}
		}
		
		//semester Rivendell
		var semRivendell = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#rivendell" + id + i;
			if ($(para).prop("checked") == true) {
				semRivendell += "1";
			} else {
				semRivendell += "0";
			}
		}

		//semester neverland
		var semNeverland = "";
		
		for (var i=0; i< 4; i++) {
			var para = "#neverland" + id + i;
			if ($(para).prop("checked") == true) {
				semNeverland += "1";
			} else {
				semNeverland += "0";
			}
		}
		
		
		if (unitCode === ""){
			alert("Unit Code is required");
			$(unitCode1).focus();
			
		} else if  (unitName === ""){
			alert("Unit Name is required");
			$(unitName1).focus();
			
		} else if  (description === ""){
			alert("Description is required");
			$(description1).focus();
			
		} else if  (credit === ""){
			alert("credit is required");
			$(credit1).focus();
			
		}	else if (!$(credit1).val().match(/^[-]?([1-9]\d*|0)(\.\d+)?$/)) {
			alert("Please enter your vaild credits ");
			$(credit1).focus();
			
		} else {
			$.get("masterUnit_update.php", {
				id:id,
				unitCode:unitCode,
				unitName:unitName,
				description:description,
				semPandora:semPandora,
				semRivendell:semRivendell,
				semNeverland:semNeverland,
				credit:credit
				
			}).done(function(data){
				alert("You have edited a unit successfully!!");
				location.reload();
				
			});
		}
		
	
	});
	
	//close click
	$(".close").click(function(){
		$(unitCode1).val("");
		$(unitName1).val("");
		$(description1).val("");
		location.reload();

	});
});
