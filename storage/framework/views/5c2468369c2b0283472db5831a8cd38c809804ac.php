

<?php $__env->startSection('styles'); ?>
    
<?php $__env->stopSection(); ?>
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
	                	 > 団体アカウント 
		            </li>
	            	<li class="hidden-xs">
	                	<a href="#"> > 担任登録</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">担任登録</h3>

			<div class="row">
				<div class="col-md-12">
					<?php if(isset($message)): ?>
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
							<strong>お知らせ!</strong>
							<p>
								<?php echo e($message); ?>

							</p>
						</div>
					<?php endif; ?>
					
					<form class="form-horizontal form" id="form-validation" role="form" action="<?php echo e(url('group/teacher/doreg_class')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<?php if(count($errors) > 0): ?>
							<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					
						<div class="form-group">
							<label class="control-label col-md-2">
								年度を入力
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-2">
<!--								<input type="number" name="year" id="year" class="form-control required">-->
								<input type="number" min="2000" name="year" value="<?php echo e(isset($year) ? $year : $current_season['year']); ?>" id="year" class="form-control" placeholder="入力例：<?php echo Date('Y')?>">
							</div>
						</div>
						<!--<div class="form-group">
							<label class="control-label col-md-2">
								役割を選択
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-2">
								<select name="role" id="role" class="bs-select form-control">
										<option>担任、副担任</option>
										<option>学年主任</option>
										<option>その他教職員</option>
										<option>司書</option>
										<option>校長（代表者）</option>
										<option>教頭(代表者）</option>
										<option>IT担当者（代表者）</option>
								</select>
							</div>
						</div>-->
						<div class="form-group">
							<label class="control-label col-md-2">
								学年を選択
							</label>
							<div class="col-md-2">
								<select name="grade" id="grade" class="bs-select form-control">
									<?php $__currentLoopData = config('consts')['CLASS_GRADE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($key >= 0): ?>
											<option value="<?php echo e($key); ?>"><?php echo e($grade); ?></option>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2" for="class_number">学級名</label>
							<div class="col-md-2">
								<input type="text" name="class_number" id="class_number" class="form-control" disabled="true">
							</div>
							<label class="control-label col-sm-2 text-md-left label-after-input">学級</label>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2"  for="teacher_id">
								担任教師名
<!--								<span class="text-danger">*</span>-->
							</label>
							<div class="col-md-3">
								<select class="bs-select form-control search" name="teacher_id" id="teacher_id"  enabled="true"  placeholder="選択...">
									
									<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($member->id); ?>"><?php echo e($member->firstname); ?> <?php echo e($member->lastname); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
<!--								<input type="text" name="teacher_id" id="teacher_id" class="form-control" placeholder="選択...">-->
							</div>
						</div>
						<!--<div class="form-group">
							<label class="control-label col-md-2">副担任教師名</label>
							<div class="col-md-3">
								<select class="bs-select form-control search" name="vice_teacher_id" id="vice_teacher_id"  placeholder="選択...">
									<option value=""></option>
									<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($member->id); ?>"><?php echo e($member->firstname); ?> <?php echo e($member->lastname); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">その他氏名
							</label>
							<div class="col-md-3">
								<input type="text" name="other_teacher_id" id="other_teacher_id" class="form-control">
							</div>
						</div>-->
						<div class="form-group">
							<label class="control-label col-md-2">
								児童生徒人数(半角)
<!--								<span class="text-danger">*</span>-->
							</label>

							<div id="member_counts" class="col-md-2">
								<div class="input-group">
									<input type="number" name="member_counts" class="spinner-input form-control" maxlength="3" min="1">
								</div>
							</div>

							<label class="control-label col-sm-2 text-md-left label-after-input">名</label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-5 text-md-right" style="font-size: 16px;" id="result"></label>
						</div>
						<div class="form-group">
							<label class="control-label col-md-5 text-md-right">
								<?php if(isset($message)): ?>
								<?php echo e($message); ?>

								<?php endif; ?>
							</label>
						</div>

						<div class="form-group">
							<div class="col-md-4">
								<button type="submit" id="register"  class="btn btn-primary pull-right" style="margin-bottom:8px;"  disabled="true">登録する</button>
							</div>
							<div class="col-md-3">
								<button type="button" id="register_cancel" class="btn btn-danger" style="margin-bottom:8px;"  disabled="true">キャンセル</button>
							</div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-info pull-right" id="back" style="margin-bottom:8px;"  disabled="true">戻　る</button>
                            </div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
			</div>
		</div>
	</div>

	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
				    <input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
					<h4 class="modal-title text-primary"><strong><?php echo e(config('consts')['MESSAGES']['21B1']); ?></strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							<span class="help-block " id="password_error"></span>
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
	<input type="hidden" id="reloadFlag" name="reloadFlag" value="<?php echo e($group->reload_flag); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-validation/js/localization/messages_ja.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('plugins/fuelux/js/spinner.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();

   			flag = 100;
			if($("#reloadFlag").val()){
				flag = $("#reloadFlag").val();
			}
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});
				$("#class_number").attr("disabled", true);
				$("#teacher_id").attr("disabled", true);
				$("#register").attr("disabled", true);
				$("#register_cancel").attr("disabled", true);
				$("#back").attr("disabled", true);
			}else{
				$("#class_number").attr("disabled", false);
				$("#teacher_id").attr("disabled", false);
				$("#register").attr("disabled", false);
				$("#register_cancel").attr("disabled", false);
				$("#back").attr("disabled", false);
			}
			$("#authModal .modal-close").click(function(){
				history.go(-1);
			});
		

		    $('#register_cancel').click(function(){
		    	$("#form-validation").attr("method", "get")
		    	$("#form-validation").attr("action",'<?php echo e(url("/top")); ?>');
		    	$("#form-validation").submit()
			})

			$('#register').click(function(){
				FormValidation.init();
			})
			$("#back").click(function(){
				 history.go(-1);
				//$("#form").attr("method", "get");
				//$("#form").attr("action", "<?php echo e(url('/')); ?>");
				//$("#form").submit();
			})	
//			    FormValidation.init();
		    setInterval(function(){
		    	if($("#year").val() != "" && $("#year").val() !== null &&
		    	   $("#teacher_id").val() != "" && $("#teacher_id").val() !== null &&
		    	   $("input[name=member_counts]").val() != "" && $("input[name=member_counts]").val() !== null){
		    		var str = '学級の表示 : ';
		    		if($("#grade").val() == 0 ){
		    			if($("#class_number").val() != '')
		 		  			str += $("#class_number").val()+'学級';
		    		}
		 		  	else if($("#class_number").val() == '')
		 		  		str += $("#grade option:selected").text();
		 		  	else
		 		  		str += $("#grade").val() + '-' + $("#class_number").val()+'学級';
		 		  			    		
		    		str += ' ' + $("#teacher_id option:selected").html() + "/"
		    		str += $("#year").val() + "年度/";
		    		if($("input[name=member_counts]").val() > 0)
		    			str += $("input[name=member_counts]").val() + "名";

		    		$("#result").html(str)
		    	}else{
		    		$("#result").html('&nbsp;')
		    	}
		    },500);
    })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>