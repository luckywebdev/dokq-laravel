

<?php $__env->startSection('styles'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-datepicker/css/datepicker3.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>">
	<style>
		.paddingleftzero{
			padding-left: 0px !important;
		}
		
		.paddingrightzero{			
			padding-right: 0px !important;	
		}

		.tools{
			float:left !important;
			margin-bottom:5px !important;
		}
		.text-danger, .has-danger{
			font-weight: 800 !important;
		}

	</style>
<?php $__env->stopSection(); ?>
<?php
	use Carbon\Carbon;
	Carbon::setLocale('ja') ;
	$classes = Auth::user()->classes;
?>
<?php $__env->startSection('breadcrumb'); ?>
	<div class="breadcum">
	    <div class="container-fluid">
	    	<div class="row">
		        <ol class="breadcrumb">
		            <li>
		                <a href="<?php echo e(url('/')); ?>">
		                	読Qトップ 
		                </a>
		            </li>
		            <li class="hidden-xs">
		            	<a href="<?php echo e(url('/')); ?>">
	                		> 団体教師トップ 
	                	</a>
		            </li>
	            	<li class="hidden-xs">
	                	<a href="#"> > クラス児童の基本情報登録・編集</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">基本情報の編集(団体児童生徒)</h3>

			<div class="row">
				<div class="col-md-12">
					<?php echo $__env->make('teacher.manage_pupil.register_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 text-md-center">
					
				</div>
				
			</div>
		</div>
	</div>

<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title" style="margin: 0 !important; font-family: 'Judson', HGP明朝B; color:blue";><strong>読Q</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text">この児童生徒が他校へ転校する場合、下記「転校を実行」ボタンを押してください。それによってこの児童生徒は、この学校に所属しない読Q会員となります。</span>
     	</div>
        <div class="modal-footer">
        	<button type="button" data-dismiss="modal" class="btn btn-warning confirm modal-close" >転校を実行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div id="graduateModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title" style="margin: 0 !important; font-family: 'Judson', HGP明朝B; color:blue";><strong>読Q</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text">この児童生徒が卒業する場合、下記「卒業を実行」ボタンを押してください。それによってこの児童生徒は、この学校に所属しない読Q会員となります。</span>
     	</div>
        <div class="modal-footer">
        	<button type="button" data-dismiss="modal" class="btn btn-warning graduateconfirm modal-close" >卒業を実行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-validation/js/localization/messages_ja.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/teacher/teacher.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/teacher/pupil-form.js')); ?>"></script>
	<script type="text/javascript">
    	$(document).ready(function(){
    		ComponentsDropdowns.init();
    		FormValidation.init();
    		<?php if ($page_info['mode']=="delete") echo '$(".del_btn").click();'; ?>
    	})
		var handleInputMasks = function () {
		    $.extend($.inputmask.defaults, {
		        'autounmask': true
		    });
		    $("#birthday").inputmask("y/m/d", {
		    }); //multi-char placeholder
		    $("#birthday").inputmask("y/m/d", {
		    }); //multi-char placeholder
		    $("#phone").inputmask("mask", {
		        "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
		    }); //specifying fn & options
		}
		handleInputMasks()
		$(".del_btn").click(function(){
			if($("#pupil_id").val() == 0){
				bootboxNotification("児童生徒を選択して下さい。");
				return;
			}else{
				bootbox.dialog({
	                message: "削除すると読Q退会となり、合格履歴など全て消去されます。",
	                title: "読Q",
	                closeButton: false,
	                buttons: {
	                  success: {
	                    label: "削除する",
	                    className: "yellow",
	                    callback: function() {
	                    	location.href="<?php echo e(url('/teacher/pupil/remove')); ?>?id="+$("#pupil_id").val();
	                    }
	                  },
	                  main: {
	                    label: "削除しない",
	                    className: "red",
	                  }
	                }
	            });
			}
			
		})
		$(".move_btn").click(function(){
			$("#alertModal").modal();
			/*if($("#pupil_id").val() == 0){
				bootboxNotification("この児童生徒が他校へ転校する場合、下記「転校を実行」ボタンを押してください。それによってこの児童生徒は、この学校に所属しない読Q会員となります。");
				return;
			}else{
            	location.href="<?php echo e(url('/teacher/edit_pupil')); ?>?pupil="+$("#pupil_id").val();
			}*/
		})
		$(".confirm").click(function(){
			if($("#pupil_id").val() > 0){				
            	location.href="<?php echo e(url('/teacher/pupil/move')); ?>?pupil="+$("#pupil_id").val();
			}
		})
		$(".edit_btn").click(function(){
			if($("#pupil_id").val() == 0){
				bootboxNotification("児童生徒を選択して下さい。");
				return;
			}else{
            	location.href="<?php echo e(url('/teacher/edit_pupil')); ?>?pupil="+$("#pupil_id").val();
			}
		})
		$(".graduate_btn").click(function(){
			$("#graduateModal").modal();
		})
		$(".graduateconfirm").click(function(){
			if($("#pupil_id").val() > 0){				
            	location.href="<?php echo e(url('/teacher/pupil/graduate')); ?>?pupil="+$("#pupil_id").val();
			}
		})
		var handleDatePickers = function () {

	        if (jQuery().datepicker) {
	            $('.date-picker').datepicker({
	                rtl: Metronic.isRTL(),
	                orientation: "left",
	                autoclose: true,
	                language: 'ja'
	            });
	        }
	    }
		
	    handleDatePickers();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>