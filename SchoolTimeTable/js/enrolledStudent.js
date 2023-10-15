$(document).ready(function(){	
	//show Pandora units
	$('.btnDisplay').on('click', function() {
		var id = $(this).attr('id');
		id = "." + id;
		
		$(".tutList").hide();
		$(id).show();
	});
});