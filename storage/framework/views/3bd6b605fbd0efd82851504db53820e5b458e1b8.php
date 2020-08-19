<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="token" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>読Q</title>

        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/font-awesome/css/font-awesome.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/simple-line-icons/simple-line-icons.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/uniform/css/uniform.default.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-select/bootstrap-select.min.css')); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-toastr/toastr.min.css')); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/select2/select2.css')); ?>"/>    
       <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-datepicker/css/datepicker3.css')); ?>">
       
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/components-rounded.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/style.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/style-responsive.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/themes/blue.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/themes/darkblue.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/layout.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/lib.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/custom.css')); ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('datatables/plugins/bootstrap/dataTables.bootstrap.css')); ?>"/>

        <link href="<?php echo e(asset('js/gritter/css/jquery.gritter.css')); ?>" rel="stylesheet" type="text/css"/>
       
        <style>
            .container-fluid{
              width: 100%!important;
              padding: 0px;
              margin-left: 15px;
            }
            .breadcum > .container{
              width: 100%;
              padding: 0px;
            }
        </style>
        <?php echo $__env->yieldContent('styles'); ?>
    </head>
   
   <?php if(isset($nosidebar)): ?>
    <body class = 'page-full-width'>
   <?php else: ?>
    <body>
   <?php endif; ?>
        <header>
            <?php echo $__env->make('common.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php if(Auth::check() && Auth::user()->active == 1 && (Auth::user()->isTeacher() || Auth::user()->isRepresen() || Auth::user()->isItmanager() || Auth::user()->isLibrarian() || Auth::user()->isOther())): ?>
                <?php echo $__env->make('common.second_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
        </header>
        <?php echo $__env->yieldContent('breadcrumb'); ?>
        <div class="page-container" >

            <?php if(!isset($nosidebar)): ?>
                <?php echo $__env->make('common.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php echo $__env->yieldContent('contents'); ?>
        </div>

        <?php if(!isset($nofooter)): ?>
            <?php echo $__env->make('common.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>           
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/tether-master/dist/js/tether.min.js')); ?>" ></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery-migrate.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery.blockui.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery.cokie.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/moment.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/uniform/jquery.uniform.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ja.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/select2/select2.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-toastr/toastr.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/select2/select2_locale_ja.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/jquery-slimscroll/jquery.slimscroll.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/fuelux/js/spinner.min.js')); ?>"></script>

        <script type="text/javascript" src="<?php echo e(asset('plugins/bootbox/bootbox.min.js' )); ?>"></script>

        <script type="text/javascript" src="<?php echo e(asset('js/metronic.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/layout-frontend.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/layout.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/back-to-top.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/demo.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/quick-sidebar.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/components.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('plugins/socket.io.min.js')); ?>"></script>

        <script type="text/javascript" src="<?php echo e(asset('datatables/media/js/jquery.dataTables.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('datatables/plugins/bootstrap/dataTables.bootstrap.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/table-managed.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/gritter/js/jquery.gritter.js')); ?>"></script>
        <script>
            Metronic.init();
            Layout.init();    
            LayoutFrontend.init();            
            Demo.init();
            QuickSidebar.init();
            TableManaged.init();

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            // Layout.initOWL();
            // Layout.initTwitter();
            // Layout.initFixHeaderWithPreHeader();
            var pdfheight  = $(window).height() - 55;
                      
            var data = {_token: $('meta[name="csrf-token"]').attr('content') , pdfheight: pdfheight};
            $.ajax({
                type: "post",
                url: "<?php echo e(url('/help/storepdfheight')); ?>",
                data: data,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },          
                success: function (response){
                    
                }
            })

            var status = '<?php echo Request::session()->get('status'); ?>'
            if(status != ''){
                toastr.success(status)
            }

            var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
            <?php if(Auth::check()): ?>
	            socket.on('logout', function(msg){
					var id = '<?php echo Auth::id();?>';
					var ids = msg.split(",");
					for(i = 0; i < ids.length; i++){
						if(ids[i] == id){
							location.href='<?php echo e(url("/logout")); ?>';
							break;
						}
					}
	            });
                socket.on('faceverifyerror', function(msg){
                    var id = '<?php echo Auth::id();?>';
                    var ids = msg.split(",");

                    for(i = 0; i < ids.length; i++){
                        
                        if(ids[i] == id){
                            location.href='<?php echo e(url("/book/test/faceverify_error_delete")); ?>';
                            break;
                        }
                    }
                });
            <?php endif; ?>

        // send mail active !=1 members of Users table
           /* var info = {
                _token: $('meta[name="csrf-token"]').attr('content')
            }
            $.ajax({
                type: "post",
                url: "<?php echo e(url('/alerttomember')); ?>",
                data: info,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },          
                success: function (response){
                    //console.log(response['status']);
                }
            });*/
            
            $("#fullname_is_public1").change(function () {
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    fullname_is_public: $(this).val(),
                    user_id: $(this).attr("uid")
                };
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/api/user/changeDisplayName";
                $.ajax({
                    type: "post",
                    url: post_url,
                    data: info,

                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response) {
                        $(".display_name").html(response.result);
                        if($("#fullname_is_public1").attr("checked")) {
                            $("#fullname_is_public2").attr("checked", false);
                        } else {
                            $("#fullname_is_public2").attr("checked", true);
                        }
                        jQuery.uniform.update($("#fullname_is_public2"));
                    }
                });
            });

            $("#fullname_is_public2").change(function () {
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    fullname_is_public: $(this).val(),
                    user_id: $(this).attr("uid")
                };
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/api/user/changeDisplayName";
                $.ajax({
                    type: "post",
                    url: post_url,
                    data: info,

                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response) {
                        $(".display_name").html(response.result);
                        if($("#fullname_is_public2").attr("checked")) {
                            $("#fullname_is_public1").attr("checked", false);
                        } else {
                            $("#fullname_is_public1").attr("checked", true);
                        }
                        jQuery.uniform.update($("#fullname_is_public1"));
                    }
                });
            });
        </script>
        <?php echo $__env->yieldContent('scripts'); ?>
    </body>
</html>
