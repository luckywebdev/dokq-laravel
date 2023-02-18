$(document).ready(function(){
	var count_index = 2;
	$(".register-form .base_info").change(function(){
		var ids = $(this).attr('id');
		var lastname_roma = $("#lastname_roma").val()
		var gender = $("#gender").val()
		var birthday = $("#birthday").val()
		if(ids == 'firstname_roma' || ids == 'lastname_roma' || ids == 'gender' || ids == 'birthday'){
			if (lastname_roma != "" && gender != "" && birthday != "") {
				makeNameAndPWD();
			}
		}
		else{
			var isFilled = checkBaseInfoFilled(ids);
			if(isFilled){
				checkSameUser();
				return;
			}
		}
	})	
	var checkBaseInfoFilled = function(id){
		var isFilled = true;
		var countNum = 0;

		if(id == 'firstname' || id == 'lastname'){
			count_index = 4;
		}
		else{
			count_index = 3;
		}
		$(".register-form .base_info").each(function(index, item){
			if($(item).val() != ""){
				countNum++;
				// isFilled = true;
			}
			// else{
			// 	isFilled = false;
			// 	return isFilled;
			// }
		});
		if(countNum >= count_index){
			isFilled = true;
		}
		else{
			isFilled = false;
		}

		return isFilled;
	}
	var makeNameAndPWD = function(){
		
			
		var info = {
			_token: $('meta[name="csrf-token"]').attr('content'),
			firstname_roma: $("#firstname_roma").val(),
			lastname_roma: $("#lastname_roma").val(),
			
			gender:$("#gender").val(),
			birthday:$("#birthday").val()
		}
		var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/teacher/checkPupilExists";
		$.ajax({
			type: "post",
      		url: "/teacher/checkPupilExists",
		    data: info,
		    
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	
		    	if(response.status == 'success'){
		    		
		    		$("#username").val(response.username)
		    		$("#r_password").val(response.password)
		    	}
	    	}
		})
		
	}

	var checkSameUser = function(){
			
		var info = {
			_token: $('meta[name="csrf-token"]').attr('content'),
			firstname: $("#firstname").val(),
			lastname: $("#lastname").val(),
			birthday:$("#birthday").val(),
			username:$('#username').val()
		}
		
		var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/teacher/checkSamePupil";
		$.ajax({
			type: "post",
      		url: "/teacher/checkSamePupil",
		    data: info,
		    
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	console.log(response);
		    	if(response.status == 'there_is'){
					$("#firstname").val(response.firstname)
					$("#lastname").val(response.lastname)
					$("#firstname_yomi").val(response.firstname_yomi)
					$("#lastname_yomi").val(response.lastname_yomi)
					$("#firstname_roma").val(response.firstname_roma)
					$("#lastname_roma").val(response.lastname_roma)
					$("#birthday").val(response.birthday)
		    		$("#username").val(response.username)
		    		$("#r_password").val(response.password)
		    		$("#address1").val(response.address1)
		    		$("#address2").val(response.address2)
		    		$("#address3").val(response.address3)
		    		$("#address4").val(response.address4)
		    		$("#address5").val(response.address5)
		    		// $("#address6").val(response.address6)
		    		// $("#address7").val(response.address7)
		    		// $("#address8").val(response.address8)
		    		// $("#address9").val(response.address9)
		    		// $("#address10").val(response.address10)
		    		//$("#face_img").val(response.image_path)
		    		//$("#parent_email").val(response.teacher)
		    		$("#email").val(response.email)
		    		$("#phone").val(response.phone)
		    		$("#update_key").val(1);
		    		$("#pupil_id").val(response.pupil_id);
		    		// $('#properties option[value='+response.properties+']', newOption).attr('selected', 'selected');
		    		$("#confirmModal").modal();
		    	}
		    	else if(response.status == 'there_is_no'){
					if($("#firstname_roma").val() != "" && $("#lastname_roma").val() != ""){
						makeNameAndPWD();
					}
		    	}
	    	}
		})
		
	}
	$(".create_new").click(function(){
		$("#firstname_yomi").val("");
		$("#lastname_yomi").val("");
		$("#firstname_roma").val("");
		$("#lastname_roma").val("");
		$("#address1").val("");
		$("#address2").val("");
		$("#address3").val("");
		$("#address4").val("");
		$("#address5").val("");
		$("#address6").val("");
		$("#address7").val("");
		$("#address8").val("");
		$("#address9").val("");
		$("#address10").val("");
		$("#face_img").val("");
		//$("#parent_email").val("");
		$("#email").val("");
		$("#phone").val("");
		$("#update_key").val(0);
		$("#pupil_id").val(0);
		makeNameAndPWD();
	})

	$(".save-continue").click(function(){
		$firstname = $("#firstname").val();
		$lastname = $("#lastname").val();
		$firstname_yomi = $("#firstname_yomi").val();
		$lastname_yomi = $("#lastname_yomi").val();
		$firstname_roma = $("#firstname_roma").val();
		$lastname_roma = $("#lastname_roma").val();
		$properties = $('#role').val();
		$classes = $('#classes').val();
		
		if($firstname == ''){

			$("#alertModal").modal();
			$("#alert_text").text('氏を入力して下さい。');
			return;
		}else if($lastname == ''){
			$("#alertModal").modal();
			$("#alert_text").text('名を入力して下さい。');
			return;
		}
		else if($firstname_yomi == ''){
			$("#alertModal").modal();
			$("#alert_text").text('氏（カタカナ）を入力して下さい。');
			return;
		}
		else if($lastname_yomi == ''){
			$("#alertModal").modal();
			$("#alert_text").text('名（カタカナ）を入力して下さい。');
			return;
		}else if($firstname_roma ==  ''){
			$("#alertModal").modal();
			$("#alert_text").text('氏（ローマ字）を入力して下さい。');
			return;
		}else if($lastname_roma == ''){
			$("#alertModal").modal();
			$("#alert_text").text('名（ローマ字）を入力して下さい。');
			return;
		}else if($properties == 2){
			$("#alertModal").modal();
			$("#alert_text").text('属性を選択してください。');
			return;
		}else if($classes == ""){
			$("#alertModal").modal();
			$("#alert_text").text('学級を選択してください。');
			return;
		}

		$(".register-form").attr("action", "/teacher/pupil/continue/reg");
		$(".register-form").submit();
	})
	$(".save-close").click(function(){
		$(".register-form").attr("action", "/teacher/pupil/close/reg");
		$(".register-form").submit();
	})
/*
	$("#firstname_roma").keyup(function(){
		var firstname_roma = $(this).val();
		var lastname_roma = $("#lastname_roma").val();
		var birthday = $("#birthday").val();
		
		

		//$("#username").val(lastname_roma.toLowerCase() + "0"+ ran1 + $("#gender").val());
		var ran = new String(Math.random());
		var ran1 = ran.substring(2,5); 
		var firstnamecut = firstname_roma.substring(0,2);
		var lastnamecut = lastname_roma.substring(0,2);
		$("#r_password").val(firstnamecut.toLowerCase()+lastnamecut.toLowerCase()+ "0"+ ran1 + $("#gender").val());
			
	});
	
	$("#lastname_roma").keyup(function(){
		var lastname_roma = $(this).val();
		var firstname_roma = $("#firstname_roma").val();
		var ran = new String(Math.random());
		var ran1 = ran.substring(2,5); 
		
		//$("#username").val(lastname_roma.toLowerCase() + "0"+ ran1 + $("#gender").val());
		
		var firstnamecut = firstname_roma.substring(0,2);
		var lastnamecut = lastname_roma.substring(0,2);
		$("#r_password").val(firstnamecut.toLowerCase()+lastnamecut.toLowerCase()+ "0"+ ran1 + $("#gender").val());
		
	});*/
	
	// $("#gender").change(function(){
	// 	/*var firstname_roma = $("#firstname_roma").val();
	// 	var lastname_roma = $("#lastname_roma").val();
	// 	var ran = new String(Math.random());
	// 	var ran1 = ran.substring(2,5); 
		
	// 	$("#username").val(lastname_roma.toLowerCase() + "0"+ ran1 + $("#gender").val());
	// 	var firstnamecut = firstname_roma.substring(0,2);
	// 	var lastnamecut = lastname_roma.substring(0,2);
	// 	$("#r_password").val(firstnamecut+lastnamecut+ "0"+ ran1 + $("#gender").val());*/
	// 	var isFilled = checkBaseInfoFilled();
		
	// 	if(isFilled){
	// 		checkSameUser();
	// 	}
	// });

	$("#address5").inputmask("mask",{
        "mask":"9999"
    });
	$("#address4").inputmask("mask",{
        "mask":"999"
	});

	$("#authModal .modal-close").click(function(){
		history.go(-1);
	});
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
		    		$("#authModal").modal('hide');

		    		//register.blade.php
		    		$(".save-close").attr("disabled", false);
					$(".move_btn").attr("disabled", false);
					$(".btn-success").attr("disabled", false);
					$(".del_btn").attr("disabled", false);
					$(".face-verify").attr("disabled", false);
					$(".save-continue").attr("disabled", false);
					
				}else{
					$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
					$("#password_error").html('読Q教師パスワードが違います。')
					$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
				}
	    	}
		})
	})
	
})
