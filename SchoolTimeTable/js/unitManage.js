$(document).ready(function(){
	//displayLec button click show and hide
	$('#displayLec').on('click', function() {		
		$("#lecMng").toggle();
		
		if ($("#lecMng").css('display') == 'block') {
			$("#displayLec").text("HIDE");
		}else{
			$("#displayLec").text("OPEN");
		}
		
		return false;
	});
	
	$('#displayConsl').on('click', function() {		
		$("#consMng").toggle();
		
		if ($("#consMng").css('display') == 'block') {
			$("#displayConsl").text("HIDE");
		}else{
			$("#displayConsl").text("OPEN");
		}
		
		return false;
	});
	
	$('#displayTut').on('click', function() {		
		$("#tutMng").toggle();
		
		if ($("#tutMng").css('display') == 'block') {
			$("#displayTut").text("HIDE");
		}else{
			$("#displayTut").text("OPEN");
		}
		return false;
	});
	//edit button click
	$('.editBtn').on('click', function() {
		
		var id = $(this).attr('id');
		var spnId = ".id_" + id;
		var editId = ".edit_" + id;
		var savebtn = "#savebtn_" + id;
		$(spnId).toggle();
		$(savebtn).toggle();
		$(editId).toggle();
		
		return false;
	});
	
	$('.cnslEdit').on('click', function() {
		
		var id = $(this).attr('id');
		var spnId = ".id_" + id;
		var editId = ".edit_" + id;
		var savebtn = "#savebtn_" + id;
		$(spnId).toggle();
		$(editId).toggle();
		$(savebtn).toggle();
		
		return false;
	});
	//lecture manage save
	$('.saveBtn').on('click', function() {
		var id = $(this).attr('id'); //lecID
		id = id.replace("savebtn_", "");

		var day = "#lecday_" + id;
		var startTime = "#stTime_" + id;
		var duration = "#durTime_" + id;
		var lecturer = "#lecName_" + id;
		var location = "#location_" + id;
		var room = "#room_" + id;
		
		var day = $(day).val();
		var startTime = $(startTime).val();
		var duration = $(duration).val();
		var lecturer = $(lecturer).val();
		var location = $(location).val();
		var room = $(room).val();
		

		
		$.get("unitManage_Lec_update.php", {
			id:id,
			day:day,
			startTime:startTime,
			duration:duration,
			lecturer:lecturer,
			location:location,
			room:room
		}).done(function(data){
			alert("updated!");
			window.location.href = 'unitManage.php';
		});
	});
	
	//cnsl manage save
	$('.cnslSave').on('click', function() {
		var id = $(this).attr('id'); //lecID
		id = id.replace("savebtn_", "");
		
		var day = "#lecday_" + id;
		var startTime = "#stTime_" + id;
		var duration = "#durTime_" + id;
		var lecturer = "#lecName_" + id;
		var location = "#location_" + id;
		var room = "#room_" + id;
		var campus = "#campus_" + id;
		var semester = "#sem_" + id;
		
		day = $(day).val();
		startTime = $(startTime).val();
		duration = $(duration).val();
		lecturer = $(lecturer).val();
		location = $(location).val();
		room = $(room).val();
		unit = $("#unitCode").text();
		campus = $(campus).text();
		semester = $(semester).text();

		$.get("unitManage_cnsl_update.php", {
			unit:unit,
			campus:campus,
			semester:semester,
			id:id,
			day:day,
			startTime:startTime,
			duration:duration,
			lecturer:lecturer,
			location:location,
			room:room
		}).done(function(data){
			alert("updated!");
			window.location.href = 'unitManage.php';
		});

	});
	//tutrial Save click
	$('.tutSave').on('click', function() {
		var id = $(this).attr('id'); //lecID
		id = id.replace("savebtn_", "");
		
		var day = "#lecday_" + id;
		var startTime = "#stTime_" + id;
		var duration = "#durTime_" + id;
		var lecturer = "#lecName_" + id;
		var location = "#location_" + id;
		var room = "#room_" + id;
		var campus = "#campus_" + id;
		var semester = "#sem_" + id;
		var capacity = "#capacity_" + id;
		
		day = $(day).val();
		startTime = $(startTime).val();
		duration = $(duration).val();
		lecturer = $(lecturer).val();
		location = $(location).val();
		room = $(room).val();
		capacity = $(capacity).val();
		unit = $("#unitCode").text();
		campus = $(campus).text();
		semester = $(semester).text();

		$.get("unitManage_tut_update.php", {
			unit:unit,
			campus:campus,
			semester:semester,
			id:id,
			day:day,
			startTime:startTime,
			duration:duration,
			lecturer:lecturer,
			location:location,
			room:room,
			capacity:capacity
		}).done(function(data){
			alert("updated!");
			window.location.href = 'unitManage.php';
		});

	});

	
	//DELETE for tut
	$(".tutDelete").click(function(){
		var id = $(this).attr('id');
		id = id.replace("dlt_", "");
		
		if(!confirm('Are you sure?? ')){
			return false;
		}else{
			$.get("unitManage_tut_delete.php", {
				id:id
			}).done(function(data){
				alert("deleted..... ")
				location.reload();
			});
		}
	});
	
	//DELETE for cnsl
	$(".cnslDelete").click(function(){
		var id = $(this).attr('id');
		id = id.replace("dlt_", "");
		
		if(!confirm('Are you sure?? ')){
			return false;
		}else{
			$.get("unitManage_delete.php", {
				id:id
			}).done(function(data){
				alert("deleted..... ")
				location.reload();
			});
		}
	});
	
	//modal insert for Cnsl
	$("#insertCnsl").click(function(){
		var unit = $("#unitCod").text();
		var day = $("#lecdayM").val();
		var startTime = $("#stTimeM").val();
		var duration = $("#durTimeM").val();
		var lecturer = $("#lecNameM").val();
		var location = $("#locationM").val();
		var room = $("#roomM").val();
		var unit = $("#unitCod").text();
		var semester = $("#semesterM").val();
		var res = semester.split('_');
		semester = res[0];
		var campus = res[1];
		var id ="newCnsl";
		
		$.get("unitManage_cnsl_update.php", {
			id:id,
			unit:unit,
			campus:campus,
			semester:semester,
			day:day,
			startTime:startTime,
			duration:duration,
			lecturer:lecturer,
			location:location,
			room:room
		}).done(function(data){
			alert("updated!");
			window.location.href = 'unitManage.php';
		});
		
	});
	//modal insert for tut
	$("#insertTut").click(function(){
		var unit = $("#tutunit").text();
		var day = $("#tutday").val();
		var startTime = $("#stTimeT").val();
		var duration = $("#durTimeT").val();
		var lecturer = $("#tutName").val();
		var location = $("#locationT").val();
		var room = $("#roomT").val();
		var capacity = $("#capacityT").val();
		var semester = $("#semesterT").val();
		var res = semester.split('_');
		semester = res[0];
		var campus = res[1];
		var id ="newTut";
		
		$.get("unitManage_tut_update.php", {
			id:id,
			unit:unit,
			campus:campus,
			semester:semester,
			day:day,
			startTime:startTime,
			duration:duration,
			lecturer:lecturer,
			location:location,
			room:room,
			capacity:capacity
		}).done(function(data){
			alert("updated!");
			window.location.href = 'unitManage.php';
		});
		
	});
});