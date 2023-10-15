$(document).ready(function(){
	
	//show Pandora units
	$('#dipAll').on('click', function() {		
		$("#dipAll").hide();
		$("#dipAve").show();
		$(".nonDisp").show();
		return false;
	});

	//show Neverland units
	$('#dipAve').on('click', function() {
		$("#dipAll").show();
		$("#dipAve").hide();
		$(".nonDisp").hide();
		$(".disp_Neverland").toggle();
		return false;
	});


	//Allocate function
	$('.btnEnrol').on('click', function() {
		var tutID = $(this).attr('id'); 	
		var unit_code = "#unitcode_" + tutID;		
		unit_code = $(unit_code).text();

		$.get("tutorial_allocation_insert.php", {
			tutID:tutID,
			unit_code:unit_code
			
		}).done(function(data){
			alert("Allocated!");
			window.location.href = 'tutorial_allocation.php';
		});
	});
	//Withdraw function
	$('.btnWithdrw').on('click', function() {
		var tutID = $(this).attr('id'); 	
		var unit_code = "#unitcode_" + tutID;		
		unit_code = $(unit_code).text();
		if(!confirm('Are you sure?? ')){
			return false;
		}else{
			$.get("tutorial_allocation_withdraw.php", {
				tutID:tutID,
				unit_code:unit_code
				
			}).done(function(data){
				alert("Withdrew!");
				window.location.href = 'tutorial_allocation.php';
			});
		}
	});
	
});
	