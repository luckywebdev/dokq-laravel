$(document).ready(function(){
	$(".search").change(function(){
    	var year = $("#year").val() 
    	var grade = $("#grade").val()
    	if ( year == "" || grade == "" ){
    		return;
    	}
    	var info = {
    		schoolid: $("#group_id").val(),
    		year: year,
    		grade: grade,
    		_token: $('meta[name="csrf-token"]').attr('content')
    	}
		$.ajax({
			type: "post",
      		url: "/api/group/getClassOption",
		    data: info,
		    
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf-token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	$("#classname option").remove();
		    	$("#classname").append(response.body)
	    	}
		})
    })
    $("#classname").change(function(){
    	var year = $("#year").val() 
    	var grade = $("#grade").val()
    	var classid = $("#classname").val()
    	if ( year == "" || grade == "" || classid == ""){
    		return;
    	}
    	var info = {
    		classid: classid
    	}
    	$.ajax({
			type: "post",
      		url: "/api/group/getTeacherOption",
		    data: info,
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	var teacher_options = response.teacher;
		    	//var vice_teacher_options = response.vice_teacher;
		    	$("#teacher_id option").remove()
		    	$("#teacher_id").append(teacher_options)
		    	//$("#vice_teacher_id option").remove()
		    	//$("#vice_teacher_id").append(vice_teacher_options)
		    	$("input[name=member_counts]").val(response.member_counts)
	    	}
		})
    })
})