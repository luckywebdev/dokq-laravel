$(document).ready(function(){
	
	var items = [];

	$(".checkboxes").click(function(){
		var key =  $(this).val();
		if($(this).attr("checked") == "checked"){
			items.push(key);
		}else{

			items.splice(items.indexOf(key));
		}

	})

	$("#act").click(function(){
		if(items.length == 0){
			message = 'ローを選択して下さい。'
			bootboxNotification(message)
			return
		}else if(items.length > 1 && $("#action").val() == 0){
			message = '一つのローを選択して下さい。'
			bootboxNotification(message)
			return
		}
		$("#authModal").modal('show')
	})


	$("#authModal .send_password").click(function(){
		var password = $("#password").val()
		if (password == ''){
			$("#password").focus()
			$("#password").parent('.form-group').addClass('has-error')
			return;
		}
		var data = {_token: $('meta[name="csrf-token"]').attr('content') , password: password, id: $("#id").val()};
		$.ajax({
			type: "post",
      		url: "/api/user/passwordcheck",
		    data: data,
		    
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	if(response.status == 'success'){
//		    		if($("#action").val() == 0){
//		    			location.href="/group/teacher/" + items[0] + "/edit/card"
//		    		}else if($("#action").val() == 1){
//		    			location.href="/api/group/teacher/remove?ids=" + items.join("+")
//		    		}
		    		$("#authModal").modal('hide');
		    		$("#action").attr("disabled", false);
				}else{
					$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
					$("#password_error").html('読Q団体パスワードが違います')
					$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
				}
	    	}
		})
	})
	$("tr td:gt(0)").click(function(){
		var id = $(this).parent('tr').data('id');
		// location.href="/group/teacher/" + id + "/view/card"
	})
})
