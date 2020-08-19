
<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="<?php echo e(url('/')); ?>">
	                	読Qトップ
	                </a>
	            </li>
	            <li class="hidden-xs">
					> <a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> 本の編集
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">本の編集<?php if(isset($act)&& $act == "confirm"): ?>(確認画面)<?php endif; ?></h3>

			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
                    <form action="<?php echo e(url('/book/create_update')); ?>" method="post" id="book-register-form" class="form-horizontal" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

                    <div class="form">
			            <input type="hidden" id="msg_id" name="msg_id" value="<?php echo e($msgId); ?>"/>
                         <input type="hidden" id="act" name="act" <?php if(isset($act)): ?>value="<?php echo e($act); ?>"<?php endif; ?>/>
                         <input type="hidden" name="active" id="active" value="<?php echo e(isset($book) ? $book->active : 0); ?>">
						<?php echo $__env->make('books.book.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <br><br>
                        <div class="form-body col-md-12">
                            <?php if(isset($act)&& $act == "confirm"): ?>
                                <div class="col-md-3">
                                <button type="button" class="btn btn-primary save-close" style="margin-top:8px;"><i class="fa fa-save"></i> 登録して終了する</button>
                                </div>
                                <div class="col-md-3">
                                <button type="button" class="btn btn-success quiz-make" style="margin-top:8px;"><i class="fa fa-check"></i> 登録してクイズを作る</button>
                                </div>
                                <div class="col-md-4">
                                <button type="button" class="btn btn-warning recreate" style="margin-top:8px;">登録してもう1冊本を登録する</button>
                            	</div>
                            	<div class="col-md-2">
                            	<button type="button" class="btn btn-info" style="margin-top:8px;" onclick="javascript:history.go(-1)">戻　る</button>
                            	</div>
                            <?php else: ?>
                            	<div class="col-md-5">
                                <button type="button" class="btn btn-primary subsave" style="margin-top:8px;"><i class="fa fa-save"></i> 途中保存する</button>
                                </div>
                                <div class="col-md-3">
                                <button type="button" class="btn btn-success btn_confirm" style="margin-top:8px;"><i class="fa fa-check"></i> 確認画面へ進む</button>
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-warning" style="margin-top:8px;" id="cancel">キャンセル</button>
                            	</div>
                            	<div class="col-md-2">
                            	<button type="button" class="btn btn-info" style="margin-top:8px;" onclick="javascript:history.go(-1)">戻　る</button>
                            	</div>
                            <?php endif; ?>

                        </div>
					</div>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
    <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/book/book.js')); ?>"></script>
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();

            var last_input = 1;
            $('#book-register-form').on('keypress', 'input.form-control', function(e) {
                if (e.which == 13) {
                    last_input=last_input+1;
                    if(last_input>19)
                        last_input=1;
//                  alert(last_input);
                    $('#book-register-form').find('#input_'+last_input).focus();
                    return false; //<---- Add this line
                }
            });
            
            $(".subsave").click(function(){
            	
                $("#book-register-form").attr("action", "/book/subsave");
                $("#book-register-form").submit();
            })
            $(".save-close").click(function(){
                $("#action").val("close");
                $("#book-register-form").submit();
            })
            $(".quiz-make").click(function(){
                $("#action").val("quiz");
                $("#book-register-form").submit();
            })
            $(".recreate").click(function(){
                $("#action").val("recreate");
                $("#book-register-form").submit();
            })

            $(".btn_confirm").click(function(){
                $("#book-register-form").attr("method", 'get');
                $("#book-register-form").attr('action', '/book/book_edit_confirm');
                $("#book-register-form").submit();
            })

            $('#input_3').keyup(function(){
                bookout();
                
            }); 
            
            $('#input_1').keyup(function(){
                bookout();
            }); 

            var bookout = function () {
                var writer = $('#input_3').val();
                var title = $('#input_1').val();
                if(title != '' && writer != ''){
                    var info = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        writer: writer,
                        title: title
                    };
                    var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/book/search/bookoutAjax";
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

                            if(response.hasbookout){
                                $("#Errorbookout").show();
                            }
                            else
                                $("#Errorbookout").hide();  
                        }
                    }); 
                }
            }
		});
	    var recommend = 0;
	    setInterval(function(){
	    	var temp = $("select[name=recommend]").val();
	    	var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];
	    	if( temp != ""){
				recommend = pointarray[temp];
			}
	    },500)
    </script>

    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>