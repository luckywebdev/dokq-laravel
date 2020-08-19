
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
                	<a href="<?php echo e(url('/about_site')); ?>"> > 読Qとは</a>
	            </li>
	             <li class="hidden-xs">
                	<a href="#"> > 利用規約</a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">	
			<div class="row">
				<div class="col-md-12" style="margin-bottom:1%">
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">会員種類の説明と利用規約</span>
				</div>
			</div>
		
			<form class="form-horizontal form" method="post" id="form-validation" role="form" action="<?php echo e(url('/auth/viewpdf')); ?>">
				<?php echo e(csrf_field()); ?>	
				<input required type="hidden" name="helpdoc" id="helpdoc" value="">
				<input required type="hidden" name="role" id="role" value="">	
				<input required type="hidden" id="pdfheight" name="pdfheight" value="">			
				<h3>各会員についての説明と新規登録の流れ、および利用規約のPDFです。</h3>
				<div class="form-group row"> 
					<div class="col-md-2">
					</div>				
					<div class="col-md-2">	
						<button type="button" id="viewpdf0" class="btn btn-success more col-md-12" style="text-overflow: ellipsis;overflow: hidden; margin-bottom:8px">
						一般会員 </button>				
					</div>
					<div class="col-md-2">	
						<button type="button" id="viewpdf1" class="btn btn-success more col-md-12" style="text-overflow: ellipsis;overflow: hidden; margin-bottom:8px">
						監修者会員</button>				
					</div>
					<div class="col-md-2">	
						<button type="button" id="viewpdf2" class="btn btn-success more col-md-12" style="text-overflow: ellipsis;overflow: hidden; margin-bottom:8px">
						著者会員</button>				
					</div>
					<div class="col-md-2">	
						<button type="button" id="viewpdf3" class="btn btn-success more col-md-12" style="text-overflow: ellipsis;overflow: hidden; margin-bottom:8px">
						学校団体</button>				
					</div>						
				</div>
			</form>
		</div>
	</div>
	
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">	
		$(document).ready(function(){
			var pdfheight  = $(window).height() - 55;
			$("#pdfheight").val(pdfheight);

			$("#viewpdf0").click(function(){
		
				$("#role").attr("value", 100); 
				$("#helpdoc").attr("value", "/manual/user.pdf"); 
				
		    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
			    $(".form-horizontal").submit();
		    });

		   $("#viewpdf1").click(function(){
				
				$("#role").attr("value", 100); 
				$("#helpdoc").attr("value", "/manual/overseer.pdf"); 
		    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
			    $(".form-horizontal").submit();
		    });
		    $("#viewpdf2").click(function(){
				
				$("#role").attr("value", 100); 
				$("#helpdoc").attr("value", "/manual/author.pdf");
		    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
			    $(".form-horizontal").submit();
		    });
		    $("#viewpdf3").click(function(){
				
				$("#role").attr("value", 100); 
				$("#helpdoc").attr("value", "/manual/group.pdf");
		    	$(".form-horizontal").attr("action", '<?php echo e(url("/auth/viewpdf")); ?>');
			    $(".form-horizontal").submit();
		    });
		});  
	</script>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>