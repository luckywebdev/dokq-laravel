

<?php $__env->startSection('styles'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-datepicker/css/datepicker3.css')); ?>">
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
			<h3 class="page-title">基本情報の登録(団体児童生徒)</h3>

			<div class="row">
				<div class="col-md-12">
					<?php echo $__env->make('teacher.manage_pupil.register_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
			<div class="row">
				
				
			</div>
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
		    <input type="hidden" name="id" id="id" value="<?php echo e(Auth::id()); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong><?php echo e(config('consts')['MESSAGES']['PASSWORD_INPUT']); ?></strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							<span class="help-block " id="password_error"></span>
								<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">パスワードを表示する</label>
			                <?php if($errors->has('password')): ?>
			                    <span class="help-block">
			                        <strong><?php echo e($errors->first('password')); ?></strong>
			                    </span>
			                <?php endif; ?>
					 	</div>
					 </div>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
					<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="reloadFlag" name="reloadFlag" value="<?php echo e($teacherinfo->reload_flag); ?>" />
	<div id="confirmModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h4 class="modal-title"><strong>おたずね</strong></h4>
	      	</div>
	      	<div class="modal-body">
	        	<span>すでに読Q会員ですか？　同じ情報を持つ読Q会員がいます。</span>
	     	</div>
	        <div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-warning">すでに読Q会員</button>
				<button type="button" data-dismiss="modal" class="create_new btn btn-primary">読Q会員ではない</button>
            	<!-- <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button> -->
	        </div>
	    </div>

	  </div>
	</div>

	<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h4 class="modal-title"><strong>エラー</strong></h4>
	      	</div>
	      	<div class="modal-body">
	        	<span id="alert_text"></span>
	     	</div>
	        <div class="modal-footer">
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
				
		var isChecked = false;
		$("#validate-form:first").submit(function(){
		    if (isChecked) return true;
			var params = "username=" + $("#username").val() + "&password=" + $("#r_password").val();
			$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/user/duppasswordcheck?" + params,
				function(data, status){
					if(data.result=="dup"){
		        		$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['FACE_RECOG_1']); ?>");
		        		$("#alertModal").modal();
		        		$("#password").select();
		        	} else {
		        	    isChecked = true;
		        		$("#validate-form").submit();
		        	}
				});
			return false;
		});
    	$(document).ready(function(){
    		ComponentsDropdowns.init();
    		FormValidation.init();

    		flag = 100;
			
			if($("#reloadFlag").val()){
				flag =$("#reloadFlag").val();
			}
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});

				$(".save-close").attr("disabled", true);
				$(".move_btn").attr("disabled", true);
				$(".btn-success").attr("disabled", true);
				$(".del_btn").attr("disabled", true);
				$(".face-verify").attr("disabled", true);
				$(".save-continue").attr("disabled", true);
			}else{
				$(".save-close").attr("disabled", false);
				$(".move_btn").attr("disabled", false);
				$(".btn-success").attr("disabled", false);
				$(".del_btn").attr("disabled", false);
				$(".face-verify").attr("disabled", false);
				$(".save-continue").attr("disabled", false);
			}
			
		});
    	
		var handleInputMasks = function () {
		    $.extend($.inputmask.defaults, {
		        'autounmask': true
		    });

		    $("#birthday").inputmask("y/m/d", {
		    }); //multi-char placeholder
		    $("#phone").inputmask("mask", {
		        "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
		    });
		    $("#address4").inputmask("mask", {
				"mask": "999"
		    });
		    $("#address5").inputmask("mask", {
				"mask": "9999"
		    });
		    $("#address5").inputmask("mask", {
				"mask": "9999"
		    });
		    $("#address6").inputmask("mask", {
				"mask": "99999"
		    });
		    $("#address7").inputmask("mask", {
				"mask": "9999"
		    });
		    $("#address8").inputmask("mask", {
				"mask": "9999"
		    });
		    $("#address10").inputmask("mask", {
				"mask": "****"
		    });
		}

		$("#show_pwd").change(function() {
		    if($(this).attr("checked")) {
		        $("#password").attr("type", "text");
		    } else {
		        $("#password").attr("type", "password");
		    }
		});
		
		$(".del_btn").click(function(){
			if($("#pupil_id").val() == 0){
				bootboxNotification("児童生徒を選択して下さい。");
				return;
			}else{
				bootbox.dialog({
	                message: "この基本情報データを削除しますか？",
	                title: "読Q",
	                closeButton: false,
	                buttons: {
	                  success: {
	                    label: "はい",
	                    className: "yellow",
	                    callback: function() {
	                    	location.href="/class/pupil/remove?id="+$("#pupil_id").val()
	                    }
	                  },
	                  main: {
	                    label: "いいえ!",
	                    className: "default"
	                  }
	                }
	            });
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
	    handleInputMasks();
	    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>