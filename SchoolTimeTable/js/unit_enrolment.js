$(document).ready(function(){
	
	//show Pandora units
	$('#dipPandora').on('click', function() {		
		$(".disp_Pandora").toggle();
		
		if ($(".disp_Pandora").css('display') != 'block') {
			$(".disp_Neverland").hide();
			$(".disp_Rivendell").hide();
		}
		return false;
	});

	//show Neverland units
	$('#dipNeverland').on('click', function() {		
		$(".disp_Neverland").toggle();
		if ($(".disp_Neverland").css('display') != 'block') {
			$(".disp_Pandora").hide();
			$(".disp_Rivendell").hide();
		}
		return false;
	});

	//show Rivendell units
	$('#dipRivendell').on('click', function() {		
		$(".disp_Rivendell").toggle();
		if ($(".disp_Rivendell").css('display') != 'block') {
			$(".disp_Pandora").hide();
			$(".disp_Neverland").hide();
		}
		return false;
	});

	//Enrol function
	$('.btnEnrol').on('click', function() {
		var lecID = $(this).attr('id'); 	
		var unit_code = "#unitcode_" + lecID;		
		unit_code = $(unit_code).text();

		$.get("unit_enrolment_insert.php", {
			lecID:lecID,
			unit_code:unit_code
			
		}).done(function(data){
			alert("Enroled!");
			window.location.href = 'unit_enrolment.php';
		});

	});
	//Enrol function
	$('.btnWithdrow').on('click', function() {
		var lecID = $(this).attr('id'); 	
		var unit_code = "#unitcode_" + lecID;		
		unit_code = $(unit_code).text();

		if(!confirm('Are you sure?? ')){
			return false;
		}else{
			$.get("unit_enrolment_delete.php", {
				unit_code:unit_code
			}).done(function(data){
				alert("withdrew")
				location.reload();
			});
		}
	});
});
	