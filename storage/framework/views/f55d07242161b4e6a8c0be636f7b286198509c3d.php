

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
	            	<a href="<?php echo e(url('/')); ?>">
	                	> 団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                <a href="#"> > 児童生徒検索</a>
	            </li>
	            <li class="hidden-xs">
	                <a href="#"> > お知らせ入力</a>
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				児童生徒へ連絡、お知らせ、おすすめなど<br>
				<small>(児童のマイ書斎の連絡帳欄に表示されます)</small>
			</h3>

			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form" role="form" action="<?php echo e(url('teacher/post_notify')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<input type="hidden" name="pupil" value="<?php echo e($toId); ?>"/>

						<div class="form-group row">

							<label class="control-label col-md-12 text-md-center">
							<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($class->grade==0): ?>
									<?php echo e($class->class_number); ?>学級								
									<?php else: ?>
										<?php echo e($class->grade); ?>-<?php echo e($class->class_number); ?>

								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> &nbsp;
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo e($user->fullname()); ?>さん&nbsp;
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							宛</label>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">入力欄 100字以内</label>
							<div class="col-md-8">
								<textarea class="form-control msg_content" rows="5" name="content" maxlength="100"></textarea>
							</div>
							<div class="col-md-2 notify_send">
								<button type="submit" class="btn btn-success">確認して送信</button>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<table class="table table-bordered-purple table-hover">
									<thead>
										<tr class="info">
											<th width="15%">送信日時</th>
											<th width="20%">宛名</th>
											<th width="50%">文面</th>
											<th width="15%">削除</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td width="15%" ><?php echo e(date_format($message->created_at,'Y.m.d.H.i a')); ?></td>
											<td width="20%"><?php echo e($message->to_username); ?></td>
											<td width="50%"><?php echo e($message->content); ?></td>
											<td width="15%"><?php if(isset($message) && $message->del_flag == 1): ?> 削除
											    <?php else: ?> <a href="<?php echo e(url('teacher/del_notify?id='.$message->id)); ?>">削除</a><?php endif; ?>
											</td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
					</form>					
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
    <script type="text/javascript">
    	$("#class").change(function(){
    	    location.href = "/teacher/send_notify?class=" + $("#class").val();
    	});
		var isChecked = false;
    	$(".form-horizontal:first").submit(function(){
		    if (isChecked) return true;
    	    if ($("#class").val() == -1) {
                $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CLASS_REQUIRED']); ?>");
                $("#alertModal").modal();
    	    } else if ($("#pupil").val() == -1) {
                $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['PUPIL_REQUIRED']); ?>");
                $("#alertModal").modal();
    	    } else if ($(".msg_content").val() == "") {
                $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['REQUIRED']); ?>");
                $("#alertModal").modal();
    	    } else {
		        isChecked = true;
                $(".form-horizontal").submit();
    	    }
			return false;
    	});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>