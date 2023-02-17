$(document).ready(function(){
	$(".draggable").draggable({
	      handle: ".modal-header"
	});
	var key = '';
	$('.password_confirm').click(function(){
		key = $(this).data('key')
		$("#password").focus();
		setTimeout(function(){
			$("#passwordModal").modal('show');
		},150);
	})

	$('#passwordModal .send_password').click(function(){
		var password = $("#password").val()
		if (password == '' || !password){
			$("#password").focus()
			$("#password").parent('.form-group').addClass('has-error')
			return;
		}
		var data = {_token: $('meta[name="csrf_token"]').attr('content') , password: password, id: $("#modalid").val()};
		
		$.ajax({
			type: "post",
      		url: "/api/user/passwordcheck",
		    data: data,
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf-token"]').attr('content');

	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },		    
		    success: function (response){
		    	if(response.status == 'success'){
		    		$("#passwordModal").modal('hide');
		    		$("#passwordModal").on('hidden.bs.modal', function(){
		    			setTimeout(function() {
							//$("#" + key + "Modal").modal('hide')
						}, 100);
		    			
		    		})
    				$("#" + key + "Modal").modal('show')
				}else{
					$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
					$("#password_error").html('読Q団体パスワードが違います。')
					$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
				}
	    	}
		})
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
		    		$("#authModal").modal('hide');

		    		//teacher_search.blade.php
		    		$("#teacher_register").attr("disabled", true);
					$("#search").attr("disabled", false);
					$("#back").attr("disabled", false);
					//list.blade.php
					$("#action").attr("disabled", false);
					//reg_class.blade.php
					$("#class_number").attr("disabled", false);
					$("#teacher_id").attr("disabled", false);
					$("#register").attr("disabled", false);
					$("#register_delete").attr("disabled", false);
					$("#teacher_delete").attr("disabled", false);
					$("#register_cancel").attr("disabled", false);
					$("#back").attr("disabled", false);
					//reg_class.blade.php
					//$("#class_number").attr("disabled", false);
					//$("#teacher_id").attr("disabled", false);
					//$("#register").attr("disabled", false);
					//$("#back").attr("disabled", false);
				}else{
					$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
					$("#password_error").html('読Q団体パスワードが違います。')
					$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
				}
	    	}
		})
	})


	
})
 

var FormValidation = function () {
    // basic validation
    var handleValidation = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation
            var form = $('#form-validation');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    year: {
                        required: true,
                        minlength:4,
                        maxlength:4,
                        number:true,
                    },
                    grade:{
                    	required:true
                    },
                    teacher_id:{
                    	required:true,
                    },
                    class_number: {
                    	required:true,
                    },
                    member_counts: {
                    	required:true,
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    form.submit()
                }
            });


    }

   
    
    return {
        //main function to initiate the module
        init: function () {

            handleValidation();
        }

    };

}();