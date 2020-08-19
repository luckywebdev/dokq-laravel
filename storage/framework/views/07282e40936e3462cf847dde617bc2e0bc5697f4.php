
<?php $__env->startSection('styles'); ?>
    
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
					> クイズを作る
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="offset-md-2 col-md-8">
					
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="row">
								<div class="col-md-12">
									<h3 class="text-center margin-top-10 margin-bottom-10" style="font-weight: 600">
										クイズ作成カード
									</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										タイトル： <strong><?php echo e($book->title); ?></strong>
									</h5>
								</div>
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										著者:  <?php echo e($book->fullname_nick()); ?>

									</h5>
								</div>
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										読Q本ID: dq<?php echo e($book->id); ?>

									</h5>
								</div>
							</div>

						</div>
						<div class="portlet-body margin-top-10">
							<div class="form">
								<?php echo $__env->make('books.quiz.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							</div>
							<input type="hidden" id="bookPages" name="bookPages" value="<?php echo e($book->pages); ?>">
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<button class="btn btn-warning float-right">クイズを作る際の注意</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>" type="text/javascript"></script>
     <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('body').addClass('page-full-width');
    		ComponentsDropdowns.init();
    		var handleComponents = function() {
		        $('#quiz').maxlength({
		            limitReachedClass: "label label-danger",
		            alwaysShow: true
		        });
		        $("#app_page").spinner({
		        	min: 1,
		        	value: 0,
		        	step: 1,
		        	max: $("#bookPages").val()
		        })
		    }
		    handleComponents();
		     $(".btn-warning").click(function(){
		    	//$("#quiz").val('');
		    	location.href = '/quiz/answer';
		    });

		    setInterval(function(){
                var question_txt = $("#quiz").val();
                var question_ary = question_txt.split("＃");
                var question_ary1 = question_txt.split("#");
                if(question_txt.length > 0){
                	$(".text_err").removeClass("hide");
                	$(".text_err").html("<?php echo e(config('consts')['MESSAGES']['POUND_NO']); ?>");
                }
                if(question_ary.length > 2 || question_ary1.length > 2){
                	$(".btn-primary").removeAttr('disabled');
                	$(".text_err").addClass('hide');
                }
                else{
                	$(".btn-primary").attr('disabled', true);
                }

            },1000)
    	})
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>