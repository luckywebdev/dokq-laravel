<?php $__env->startSection('styles'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/login/login.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
	<div class="breadcum">
	    <div class="container-fluid">
	        <ol class="breadcrumb">
	            <li>
	                <a href="<?php echo e(url('/')); ?>" style="font-family: 'Judson'">
						読Q
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > 新規登録
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>

	<div class="container login_types">
	<form class="form-horizontal form" method="post" id="form-validation" role="form" action="<?php echo e(url('/auth/viewpdf')); ?>">
		<?php echo e(csrf_field()); ?>	
		<div class="row justify-content-md-center">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="dashboard-stat blue-madison">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<a href="<?php echo e(url('/auth/register/0/1')); ?>">
						<div class="details">
							<label class="number">
								 学校団体様新規登録
							</label>
							
						</div>
					</a>
				<!--<a class="more" href="/manual/group.pdf">
					団体会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
				</a>-->
					<input type="hidden" name="helpdoc" id="helpdoc" value="">
					<input type="hidden" name="role" id="role" value="">
					<button type="button" id="viewpdf0" class="btn btn-primary more col-md-12" style="width:100%;color:white;text-align:left;border:0px">
						団体会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</button>
					
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="dashboard-stat red-intense">
					<div class="visual">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<a href="<?php echo e(url('/auth/register/2/1')); ?>">
						<div class="details">
							<label class="number">
								 監修者志望の方 新規登録
							</label>
							
						</div>
					</a>
					<!--<a class="more" href="/manual/overseer.pdf">
					監修者会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</a>-->
					
					<button type="button" id="viewpdf2" class="btn btn-primary more col-md-12" style="width:100%;color:white;text-align:left;border:0px">
						監修者会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</button>
					
				</div>
			</div>
		</div>
		<div class="row ">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="dashboard-stat purple-plum">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<a href="<?php echo e(url('/auth/register/1/1')); ?>">
						<div class="details">
							<label class="number">
								 一般の方 新規登録
							</label>
						</div>
					</a>
					<!--<a class="more" href="/manual/user.pdf">
					一般会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</a>-->
					<button type="button" id="viewpdf1" class="btn btn-primary more col-md-12" style="width:100%;color:white;text-align:left;border:0px">
						一般会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</button>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="dashboard-stat green-haze">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<a href="<?php echo e(url('/auth/register/3/1')); ?>">
						<div class="details">
							<label class="number">
								 著者の方 新規登録
							</label>
						</div>
					</a>
					<!--<a class="more" href="/manual/author.pdf">
						著者会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</a>-->
					<button type="button" id="viewpdf3" class="btn btn-primary more col-md-12" style="width:100%;color:white;text-align:left;border:0px">
						著者会員利用規約と申込の流れはこちら <i class="m-icon-swapright m-icon-white"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<a href="<?php echo e(url('/')); ?>" class="btn btn-info float-right">読Qトップへ戻る</a>
			</div>
		</div>
		<input required type="hidden" id="pdfheight" name="pdfheight" value="">
	</form>
	</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
	$(document).ready(function(){
	var pdfheight  = $(window).height() - 55;
	$("#pdfheight").val(pdfheight);
	
	$("#viewpdf0").click(function(){
		
		$("#role").attr("value", 100); 
		$("#helpdoc").attr("value", "/manual/group.pdf"); 
		
    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
	    $(".form-horizontal").submit();
    });
    $("#viewpdf1").click(function(){
		
		$("#role").attr("value", 100); 
		$("#helpdoc").attr("value", "/manual/user.pdf"); 
    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
	    $(".form-horizontal").submit();
    });
    $("#viewpdf2").click(function(){
		
		$("#role").attr("value", 100); 
		$("#helpdoc").attr("value", "/manual/overseer.pdf");
    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
	    $(".form-horizontal").submit();
    });
    $("#viewpdf3").click(function(){
		
		$("#role").attr("value", 100); 
		$("#helpdoc").attr("value", "/manual/author.pdf");
    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
	    $(".form-horizontal").submit();
    });
     var handleInputMasks = function () {
	    $.extend($.inputmask.defaults, {
	        'autounmask': true
	    });

	    $("#birthday").inputmask("y/m/d", {
	        //"placeholder": "yyyy/mm/dd"
	    }); //multi-char placeholder
    }
		   
	handleInputMasks();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>