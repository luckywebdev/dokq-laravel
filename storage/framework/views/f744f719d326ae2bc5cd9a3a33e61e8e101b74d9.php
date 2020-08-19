
<?php $__env->startSection('styles'); ?>
	<style type="text/css">
	.font_gogic{
        font-family:HGP明朝B; 
    }
	</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="login page-content-wrapper">
		<div class="logo">
	        <a href="<?php echo e(url('/')); ?>" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
	    </div>
		<div class="page-content" style="padding-top:10px;">
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<div class="row test_content">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-6 col-xs-10" style="text-align:left;padding:2px;">
							<div class="portlet light" style="margin-bottom:0px;">
								<div class="portlet-body">
									<div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
										<div class="row">
											<table style="width: 100%">
												<tr>
													<td width="70%">
														<div class="col-sm-12 quiz_content" style="height:380px;" >
															<h4 class="font_gogic" style="max-width: 30px;text-align: left;color:black;font-family:HGP明朝B;">
																<span style="font-size:0px;color:#fff;">ー</span>
																<?php if(isset($quiz) && $quiz !== null && $quiz != ''): ?> 
																	<?php 
																	 	$st = str_replace_first("#", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:overline !important;font-family:HGP明朝B;'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
																		$st = str_replace_first("＃", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:overline !important;font-family:HGP明朝B;'>", $st); $st = str_replace_first("＃", "</span>", $st);
																		$st = str_replace("、", "、", $st); $st = str_replace("､", "、", $st); 
																		$st = str_replace("」", "﹂", $st); $st = str_replace("｣", "﹂", $st); 
																		$st = str_replace("「", "﹁", $st); $st = str_replace("｢", "﹁", $st);
																		$st = str_replace("（", "︵", $st); $st = str_replace("(", "︵", $st);
																		$st = str_replace("）", "︶", $st); $st = str_replace(")", "︶", $st); 
																		$st = str_replace("。", "<span style='font-size:22px;'>．</span>", $st); $st = str_replace("｡", "<span style='font-size:22px;'>．</span>", $st);
																		for($i = 0; $i < 30; $i++) {
																		 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("*", "︶</span>", $st);
																			$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("＊", "︶</span>", $st);
																		} 
																	echo $st;  ?>
																<?php endif; ?>
																	<span style="font-size:0px;color:#fff;">ー</span>
															</h4>
														</div>
													</td>
													<td width="15%">
														<div class="col-sm-12 answer_content" style="padding-left:5px;padding-right:5px; display: flex; flex-direction: column; align-items:center">
															<div class="btn-group" data-toggle="buttons">
																<label class="btn btn-primary btn-block" id="btn_yes" style="margin-top: 0px;margin-bottom: 0px;">
																<input type="radio" class="toggle font_gogic" style="font-family:HGP明朝B;">①</label>
																<label class='font_gogic' style="font-family:HGP明朝B;">〇</label>
															</div>	
															<div class="btn-group" data-toggle="buttons">
																<label class="btn btn-danger btn-block" id="btn_no" style="margin-bottom: 0px;">
																<input type="radio" class="toggle font_gogic" style="font-family:HGP明朝B;">②</label>
																<label class='font_gogic' style="font-family:HGP明朝B;">✕</label>
															</div>
															<div class="btn-group" data-toggle="buttons">
																<div class="col-sm-12 tonext_content" style="align-self:right;padding-left:0px;padding-right:0px;text-align:center;vertical-align:bottom;">
																	<button type="button" class="btn btn-warning hidden" id="next">次<br>へ</button>
																</div>
															</div>
														</div>
													</td>
													<td width="15%" valign="middle" style="text-align: center">
														<div class="row" style="margin-top: 2%">
															<div class="col-sm-12 time_content" align="center" style="display: flex; flex-direction: column; align-items:center">
																<h4 class="font_gogic" time="30" id="time_text" style="direction:ltr;font-family:HGP明朝B;"></h4>
															</div>
														</div>
														
													</td>
													
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-xs-2" style="text-align:right;padding-right:15px;">

							<div class="row" style="height:80%">
								<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">出典···<span style="font-size:0px;color:#fff;">ー</span>﹁<?php echo e($book->title); ?>﹂ <?php echo e($book->fullname_nick()); ?><span style="font-size:0px;color:#fff;">ー</span></p>
								<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">クイズ作成者···
								<?php if(isset($quiz) && $quiz !== null && $quiz != ''): ?> 
									<span style="font-size:0px;color:#fff;">ー</span><?php echo e($quiz->RegisterShow()); ?><span style="font-size:0px;color:#fff;">ー</span>
								<?php endif; ?>
								</p>
							</div>
							
							<div class="row" style="height:20%;text-align:right;vertical-align:bottom;align-self:flex-end;align-items:flex-end;">
								<button type="button" class="btn btn-danger" id="cancel" style="align-self:flex-end;align-items:flex-end;">中<br>止<br>す<br>る</button>
							</div>
						</div>	
						
						
						
						<form action="<?php echo e(url('/book/test/quiz')); ?>" method="post" id="quiz_form">
						    <?php echo e(csrf_field()); ?>

							<input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>"/>
							<input type="hidden" name="quiz_count" value="<?php echo e($book->quiz_count); ?>" id="quiz_count"/>
							<input type="hidden" name="page_count" id="page_count" value="<?php echo e($page_count); ?>"/>
							<input type="hidden" name="quiz_block_num" id="quiz_block_num" value="<?php echo e($quiz_block_num); ?>"/>
							<input type="hidden" name="point" id="point" value="<?php echo e($point); ?>"/>
							<input type="hidden" name="test_time" id="test_time" value="">
							<input type="hidden" name="answer" id="answer" value="-1">
						    
						</form>
						<form action="<?php echo e(url('/book/test/failed')); ?>" method="get" id="failed_form">
						<?php echo e(csrf_field()); ?>

							<input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>">
							<input type="hidden" name="page_count" id="page_count" value="<?php echo e($page_count); ?>"/>
							<input type="hidden" name="quiz_block_num" id="quiz_block_num" value="<?php echo e($quiz_block_num); ?>"/>
							<input type="hidden" name="test_time" id="test_time" value="">
						</form>
						<form action="<?php echo e(url('/book/test/stoped')); ?>" method="get" id="stoped_form">
						<?php echo e(csrf_field()); ?>

							<input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>">
							<input type="hidden" name="page_count" id="page_count" value="<?php echo e($page_count); ?>"/>
							<input type="hidden" name="quiz_block_num" id="quiz_block_num" value="<?php echo e($quiz_block_num); ?>"/>
							<input type="hidden" name="test_time" id="test_time" value="">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if($mode == 3): ?>
	<form action="<?php echo e(url('/book/test/success_signin')); ?>" method="post" id="recorg_form">
	    <?php echo e(csrf_field()); ?>

		<input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>"/>
		<input type="hidden" name="mode" id="mode" value="<?php echo e($mode); ?>"/>
		<input type="hidden" name="page_count" id="page_count" value="<?php echo e($page_count); ?>"/>
		<input type="hidden" name="answer" id="answer" value="-1">
		<input type="hidden" name="passed_quiz_count" value="<?php echo e($book->quiz_count); ?>" id="quiz_count"/>
		<input type="hidden" name="passed_point" id="passed_point1" value=""/>
		<input type="hidden" name="passed_test_time" id="passed_test_time1" value=""/>
	</form>
	<?php endif; ?>

	<div class="modal fade draggable draggable-modal" id="successModal" tabindex="-1" role="dialog" >
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>おめでとうございます。</strong></h4>
				</div>
				<div class="modal-body" style="padding-bottom:0px;">
					<form class="form form-horizontal" id="success_form" action="<?php echo e(url('/book/test/success')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<input type="hidden" name="id" id="id" value="<?php if(isset($quiz_overseer) && $quiz_overseer !== null): ?> <?php echo e($quiz_overseer->id); ?> <?php endif; ?>">
						<div class="form-group text-md-center col-xs-12" style="text-align:center;margin-bottom:0px;">
							<h4 style="color:#f00;">合格です</h4>
						</div>
						<div class="form-group" style="margin-bottom:0px;">
							<label class="offset-md-2 control-label col-md-9 text-md-left" style="font-size:14px;">試験監督によって合格を認証されると、完了します。<br>開始時と同じ認証方法を選んでください。</label>
						</div>
						
					 	<div class="form-group text-md-center" style="text-align:center">
							<button type="button" class="btn btn-warning" id="face_recog" <?php if(!isset($password) || (isset($password) && $password == "")): ?> disabled <?php endif; ?>>顔 認 証</button>
					 	</div>
					 	<div class="form-group" align="center">
					 		<div class="offset-md-3 col-md-6">               
			                    <div>
			                        <label class="label-above">教師パスワードによる認証</label>                                                   
			                    </div>
			                    <input type="password" class="form-control" name="password" id="password" value="" readonly>
								<span class="help-block " id="password_error"></span>
			                </div>
					 	</div>

					 	<div class="form-group">
					 		<label class="offset-md-2 control-label col-md-9 text-md-left" style="color:#f00;font-size:14px;">
					 			注意： すぐに認証してもらいましょう。試験監督の認証が１０分間行われない場合、不合格になります。
					 			</label>
					 	</div>
					 	<input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>"/>
						<input type="hidden" name="passed_quiz_count" value="<?php echo e($book->quiz_count); ?>" id="quiz_count"/>
						<input type="hidden" name="passed_point" id="passed_point" value=""/>
						<input type="hidden" name="password" id="password" value="<?php echo e($password); ?>"/>
						<input type="hidden" name="page_count" id="page_count" value="<?php echo e($page_count); ?>"/>
						<input type="hidden" name="answer" id="answer" value="-1">
						<input type="hidden" name="passed_test_time" id="passed_test_time" value="">
					</form>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-loading-text="確認中..." class="send_password btn btn-primary" style="margin-bottom:8px">送　信</button>
					<button type="button" data-dismiss="modal" class="btn btn-info modal-close" style="margin-bottom:8px">戻　る</button>
				</div>
				
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        $('body').addClass('page-full-width');
		// var socket = io('http://localhost:3000');
		var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
		var datas = {
			id: '<?php echo Auth::id(); ?>'
		};
		socket.emit('test-start', JSON.stringify(datas));
		socket.on('test-overseer', function(msg){
			var data = JSON.parse(msg);
			if(data.test == 1){
				var datas = {
					id: '<?php echo Auth::id(); ?>'
				};
				socket.emit('test-start', JSON.stringify(datas));
			}
		});
		   

		history.pushState(null, null, location.href);
			window.onpopstate = function () {
			history.go(1);
		};
		
        var extratime = 0; 
        var test_time = 0;
        resultView();
        <?php if(Request::session()->has('quiztime')): ?>
        	$("#time_text").attr('time', parseInt(<?php echo e(session('quiztime')); ?>));
        <?php endif; ?>
        var page_count = parseInt($("#page_count").val());
	    var quiz_count = parseInt($("#quiz_count").val());
	    
	    <?php if($test_success == 0): ?> 	
	        var timer = setInterval(function() {
	            var time = parseInt($("#time_text").attr("time"));
	            time = time -1;
	            test_time = test_time +1;
	            
	            var info = {
					_token: $('meta[name="csrf-token"]').attr('content'),
					quiztime: time
				}
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/book/sessionquiztime";
				$.ajax({
					type: "post",
		      		url: "/book/sessionquiztime",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf_token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	
			    	}
				})
	            $("#test_time").val(test_time + parseInt(<?php echo e(session('test_time')); ?>));
	            $("#passed_test_time").val(test_time + parseInt(<?php echo e(session('test_time')); ?>));
	            $("#passed_test_time1").val(test_time + parseInt(<?php echo e(session('test_time')); ?>));
	           
	            if(time >= 0) {
	                if(time>10) {
	                    $("#time_text").attr('time',time);
	                } else {

	                    $("#time_text").attr("time", time);
	                    $("#time_text").html("あと<br>"+time+"<br>秒");
	                }
	            } else {
	                clearInterval(timer);
	                nextQuiz();
	            }
	        }, 1000);
    	<?php else: ?>
    		$("#test_time").val(parseInt(<?php echo e(session('test_time')); ?>));
            $("#passed_test_time").val(parseInt(<?php echo e(session('test_time')); ?>));
            $("#passed_test_time1").val(parseInt(<?php echo e(session('test_time')); ?>));
    	<?php endif; ?>

	    function failedDlgBox() {
	        bootbox.dialog({
	            message: "残念ながら、不合格です。",
	            title: "読Q",
	            closeButton:false,
	            buttons: {
	                success: {
	                    label: "確認",
	                    className: "blue",
	                    callback: function() {
	                        $('#failed_form').submit();
	                    }
	                }
	            }
	        });
	    };

	    function stopedDlgBox() {
	        bootbox.dialog({
	            message: "残念ながら、不合格です。",
	            title: "読Q",
	            closeButton:false,
	            buttons: {
	                success: {
	                    label: "確認",
	                    className: "blue",
	                    callback: function() {
	                        $('#stoped_form').submit();
	                    }
	                }
	            }
	        });
	    };

	    function nextQuiz() {
	        var point = parseInt($("#point").val());
	        var page_count = parseInt($("#page_count").val());
	        var quiz_count = parseInt($("#quiz_count").val());
	        var correct_point = Math.floor((point / quiz_count)*100)/100;
	        var answer = $("#answer").val();

	        $("#passed_point").val(correct_point);
	        $("#passed_point1").val(correct_point);

	        <?php if($test_success == 0): ?>	
	        	$("#quiz_form").submit();

	        <?php endif; ?>
	    }

	    function resultView(){

	    	var point = parseInt($("#point").val());
	        var page_count = parseInt($("#page_count").val());
	        var quiz_count = parseInt($("#quiz_count").val());
	        var correct_point = Math.floor((point / quiz_count)*100)/100;
	        var answer = $("#answer").val();
	        
	        $("#passed_point").val(correct_point);
	        $("#passed_point1").val(correct_point);

	    	
	        <?php if($test_success == 0): ?> 	

	        <?php else: ?> 
	        	//clearInterval(timer);
	        	
	            var quiz_count = parseInt($("#quiz_count").val());
	            
	            <?php if($test_success == 2): ?> 
	                $("#passed_test_time").val($('#test_time').val());
	                $("#passed_test_time1").val($('#test_time').val());

	                $("#successModal").modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
	                setTimeout(function(){
	                	$("#successModal").hide();
			            failedDlgBox();
			            extratime++;
			        }, 600000);
			        if(extratime < 1){
						// var socket = io('http://localhost:3000');
						var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
		                socket.on('test-password', function(msg){
		                    var data = JSON.parse(msg);
		                    var id = '<?php echo Auth::id();?>';
		                    var ids = data.ids.split(",");
		                    for(i = 0; i < ids.length; i++){
		                        if(ids[i] == id){
		                            $("#password").val(data.password);
		                            //$("#success_form").submit();

		                            ajaxRegTest();
		                        }
		                    }
		               });
			        }
	            <?php elseif($test_success == 1): ?> 
	            	if ($(this).hasClass("bootbox") == false) 
	                	failedDlgBox();
	                
	            <?php endif; ?>
	        <?php endif; ?>
	    }
	    $('.answer_content .btn').click(function() {
	        $('#next').removeClass('hidden');
	    });
	    $('#next').click(function() {
	        if ($('#btn_yes').hasClass('active')) {
	            $("#answer").val(1);
	            var answer = '<?php echo Request::session()->put('answer', 1); ?>';
	        }
	        if ($('#btn_no').hasClass('active')) {
	            $("#answer").val(0);
	            var answer = '<?php echo Request::session()->put('answer', 0); ?>';
	        }
	        nextQuiz();
	    });

	    $('#btn_yes').click(function() {
	        $('#btn_yes').attr('style', 'margin-top: 0px;margin-bottom: 0px;background-color:#0c40fd;');
	        $('#btn_no').attr('style', 'margin-bottom: 0px;background-color:#cb5a5e;');
	    });

	    $('#btn_no').click(function() {
	        $('#btn_no').attr('style', 'margin-bottom: 0px;background-color:#f00;');
	        $('#btn_yes').attr('style', 'margin-top: 0px;margin-bottom: 0px;background-color:#3598dc;');
	    });

	    $('#face_recog').click(function() {
			$("#recorg_form").submit();
	    });
	    $(".send_password").click(function(){
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
	                    //$("#success_form").submit();
	                    ajaxRegTest();
	                }else{
	                    $("#successModal").hide();
	                    failedDlgBox();
	                }
	            }
	        })
	    });
		
		function ajaxRegTest() {

			var info = {
                book_id: $("#book_id").val(),
                passed_quiz_count: $("#quiz_count").val(),
                page_count: $("#page_count").val(),
                passed_test_time: $("#passed_test_time").val(),
                passed_point: $("#passed_point").val(),
                answer: $("#answer").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                type: "post",
                url: "<?php echo e(url('/book/regTestSuccess')); ?>",
                data: info,

                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function (response){
                    if(response.status == 'success'){
                       
                        $("#success_form").submit();
                    } else if(response.status == 'failed') {
                    }
                },
                error: function (err) {
                   
                    $(".failed-alert").css('display','block');
                }
            });
        }

	    $("#cancel").click(stopedDlgBox);
	    $("#successModal .modal-close").click(failedDlgBox);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>