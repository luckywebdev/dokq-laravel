<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
<style>
    .arrow{
        display: none!important;
    }
    .popover{
        float: right !important;
        margin-left: -135px!important;
        margin-top: -20px;
	}
	iframe {
        min-width: 100%; 
        width: 100px;
        *width: 100%; 
    }
</style>
<?php $__env->stopSection(); ?>
	
<?php $__env->startSection('contents'); ?>
<!--<div class="container register">-->
	<div class="page-content">
		<form class="form-horizontal" method="get" role="form" action=" route('authregister/0/1')">
			<input type="hidden" name="role" id="role" value="<?php echo e($role); ?>">
			<input type="hidden" name="data" id="data" value="<?php echo e($data); ?>">
			<input required type="hidden" id="pdfheight" name="pdfheight" value="">

			<div class="row">
				<div class="col-md-12">
					<iframe class="iframe_help_score" src="<?php echo asset($helpdoc)?>"></iframe>
				</div>
			</div>
		</form>
	</div>

	<div class="col-md-12">		
		<button type="button" id="back" class="btn btn-info pull-right"  style="margin-top:0px" >戻　る</button>
	</div>

<!-- <div >	
	<div  style="margin-bottom:5px: height: 70vh">
		<form class="form-horizontal" method="get" role="form" action=" route('authregister/0/1')">
			<input type="hidden" name="role" id="role" value="<?php echo e($role); ?>">
			<input type="hidden" name="data" id="data" value="<?php echo e($data); ?>">
			<input required type="hidden" id="pdfheight" name="pdfheight" value="">

			<embed width="100%" height="<?php echo e(session('pdfheight')); ?>" name="plugin" id="plugin" src="<?php echo asset($helpdoc)?>" type="application/pdf" internalinstanceid="87">
			<iframe src="<?php echo asset($helpdoc)?>" width="100%" height="600" title="" scrolling="no"></iframe>
		</form>
	</div>
	
	<div >
		<div class="col-md-12">		
			<button type="button" id="back" class="btn btn-info pull-right"  style="margin-top:0px" >戻　る</button>
		</div>
	</div>
	<div style="margin:0px"></div>
	
</div> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">	
		$("#plugin").css("height", $(window).height()- 55);
		
		$("#back").click(function(){
			var role = $("#role").val(); 
			var beforepage = "";
			if(role == 0) beforepage = "/auth/register/0/1";
			else if(role == 1) beforepage = "/auth/register/1/1";
			else if(role == 2) beforepage = "/auth/register/2/1";
			else if(role == 3) beforepage = "/auth/register/3/1";
			else{
				history.go(-1);
				return;
			} 
			
	    	$(".form-horizontal").attr("action", beforepage);
		    $(".form-horizontal").submit();

		     
	    })
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>