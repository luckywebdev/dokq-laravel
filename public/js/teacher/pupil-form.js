var FormValidation = function () {
    
    // basic validation
    var handleValidation = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation
            
            var form = $('#validate-form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    firstname_yomi: {
                        required: true,
                    },
                    lastname_yomi: {
                        required: true,
                    },
                    firstname_roma: {
                        required: true,
                    },
                    lastname_roma: {
                        required: true,
                    },
                    address1: {
                    	required: true
                    },
                    address2: {
                    	required: true
                    },
                    address4: {
                    	required: true
                    },
                    address5: {
                    	required: true
                    },
                    birthday: {
                        required: true,
                    },
                    email: {
                    	required: true
                    },
                    classes:{
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    /*parent_email: {
                        required: true,
                        //email: true,
                    },*/
                    r_password: {
                        required: true,
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

                //submitHandler: function (form) {
                //   form.submit()
                //}
            });


    }
    
    return {
        //main function to initiate the module
        init: function () {

            handleValidation();
        }

    };

}();