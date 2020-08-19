

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php
	$classes = Auth::user()->classes;
	$books = Auth::user()->books;
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
	            	<a href="<?php echo e(url('/top/')); ?>">
	                	> 団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                <a href="<?php echo e(url('/class/search_pupil')); ?>"> > 児童生徒検索</a>
	            </li>
	            <li class="hidden-xs">合格記録の取り消</li>
	        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				合格記録の取り消し<br>
				<small>担任教諭に限り、児童生徒の合格記録を取り消すことができます。</small>
			</h3>

			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form" role="form" id="form"action="">
						<?php echo e(csrf_field()); ?>

						<div class="form-group row">
							<label class="control-label col-md-12 text-md-center" style="font-size:16px">
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pupil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>&nbsp;&nbsp;<?php echo e($pupil->fullname()); ?>さん<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>の合格記録
							</label>

						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="info">
											<th class="col-md-1">受検開始日時</th>
											<th class="col-md-2">タイトル</th>
											<th class="col-md-1">著者</th>
											<th class="col-md-1">ISBN</th>
											<th class="col-md-1">ポイント</th>
											<th class="col-md-1">受検終了日時</th>
											<th class="col-md-2">試験監督</th>
											<th class="col-md-2">1冊ごとの公開非公開</th>
											<th class="col-md-1">選択</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<?php $__currentLoopData = $userQuizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userquiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e(date_format(date_create($userquiz->created_date),'Y.m.d H:i:s')); ?></td>
											<td><?php echo e($userquiz->Book->title); ?></td>
											<td><?php echo e($userquiz->Book->fullname_nick()); ?></td>
											<td><?php echo e($userquiz->Book->isbn); ?></td>
											<td><?php echo e(floor($userquiz->point*100)/100); ?></td>
											<td><?php echo e(date_format(date_create($userquiz->finished_date),'Y.m.d H:i:s')); ?></td>
											<td><?php echo e($userquiz->Org_User->username); ?></td>
											<td><?php if($userquiz->is_public == 0): ?>非公開<?php else: ?>公開<?php endif; ?></td>
											<td><input type="checkbox" class="checkboxes" id="<?php echo e($userquiz->id); ?>" name="record" value="<?php echo e($userquiz->id); ?>"></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="form-group form-actions">
							<div class="col-md-12">
								<button type="button" id="remove" class="btn btn-danger pull-right">選択した合格記録の削除を実行</button>
							</div>
						</div>
						<input type="hidden" name="selected" id="selected" value=""/>
						<input type="hidden" name="user_id" id="user_id" value="<?php echo e(isset($student_ids)?$student_ids:''); ?>"/>

					</form>					
				</div>
			</div>
		</div>
	</div>
<div id="confirmModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span style="font-size:16px">削除しますか？</span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-loading-text="確認中..." class="delete_record btn btn-warning">実　行</button>
			<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
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
        	<span style="font-size:16px">合格削除する記録を選択してください。</span>
     	</div>
        <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
        </div>
    </div>

  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			
		});
		$("#remove").click(function() {
            var checkboxes = $('input:checked');
			if(checkboxes.length>0)
				$("#confirmModal").modal();
			else
		    	$("#alertModal").modal();
		});

		$(".delete_record").click(function(){
			var checkboxes = $('input:checked');
			console.log(checkboxes.length);
            var t = '';
            for(i =0;i<checkboxes.length;i++){
                if(i == checkboxes.length-1){
                    t+=$(checkboxes[i]).attr("id");
				}
				else{
					t+=$(checkboxes[i]).attr("id")+",";
				}
            }
			$('#selected').val(t);
            $("#form").attr("method", "post");
            $("#form").attr("action",'<?php echo e(url("/teacher/record/delete")); ?>');
            $("#form").submit()
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>