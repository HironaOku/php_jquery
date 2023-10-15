$(document).ready(function(){
		
	$(".unitSelected").click(function(){
		var serchVal = $(this).attr('id');
		
		$.get("unit_detail_search.php", {serchVal:serchVal}).done(function(data){
			
			if (data === "" || data === "\r\n"){
				alert("Do not have a record");
			} else {
//				$("#searchBody").show();
				$("#unitDetail").hide();
				$("#unitDetailwrap").hide();
				$("#searchBody").html(data);
			}
		});
	});

	$(".close").click(function(){
		location.reload();
	});
});
