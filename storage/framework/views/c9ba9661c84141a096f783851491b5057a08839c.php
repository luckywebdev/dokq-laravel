

<?php $__env->startSection('styles'); ?>
    <style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
		}
	</style>
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
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 監修者決定：クイズ編集権限移譲
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者決定：クイズ編集権限移譲</h3>

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
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
						    <thead>
						    	<tr class="success">
							        <th>監修募集開始日</th>
							        <th>書籍名</th>
							        <th>読Q本ID</th>					        
							        <th>監修希望者名</th>
							        <th>受付日</th>
							        <th>希望する理由</th>
							        <th>監修している本の数</th>
							        <th>選択して決定  返信日</th>
						        </tr>
						    </thead>
 						    <tbody class="text-md-center">	
						    	<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td rowspan="<?php echo e(count($overseers[$key]) + 1); ?>" style="vertical-align:middle"><?php echo e($book->replied_date1?with(date_create($book->replied_date1))->format('Y/m/d'):""); ?></td>
									<td rowspan="<?php echo e(count($overseers[$key]) + 1); ?>" style="vertical-align:middle"><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/' . $book->id . '/detail')); ?>" <?php endif; ?> class="font-blue"><?php echo e($book->title); ?></a></td>
									<td rowspan="<?php echo e(count($overseers[$key]) + 1); ?>" style="vertical-align:middle">dq<?php echo e($book->id); ?></td>
								<?php if(!$overseers[$key] || count($overseers[$key]) == 0): ?>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td style="text-align: left !important"></td>
								<?php endif; ?>
								</tr>
								<?php $__currentLoopData = $overseers[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td style="vertical-align:middle;border-left-width:1px"><a href="<?php echo e(url('mypage/other_view/' . $demand->User->id)); ?>" class="font-blue"><?php if($demand->User->role == config('consts')['USER']['ROLE']['AUTHOR']): ?> <?php echo e($demand->User->fullname_nick()); ?> <?php else: ?> <?php echo e($demand->User->fullname()); ?> <?php endif; ?></td>
									<td style="vertical-align:middle"><?php echo e(with(date_create($demand->updated_at))->format('Y/m/d')); ?></td>
									<td style="vertical-align:middle"><?php echo e($demand->reason); ?></td>
									<td style="vertical-align:middle"><?php echo e($demand->User->overseerBookCount()); ?></td>
									<td style="text-align: center !important">
										<input type="checkbox" class="book_check" oid="<?php echo e($demand->overseer_id); ?>" bid="<?php echo e($book->id); ?>" <?php if($demand->overseer_id == $book->overseer_id): ?> checked <?php endif; ?>> <?php if($demand->overseer_id == $book->overseer_id): ?> <?php echo e(with((date_create($book->replied_date3)))->format('Y/m/d')); ?> <?php endif; ?>
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
				    <?php if(count($books) > 0): ?>
					<form action="<?php echo e(url('/admin/do_can_book_c')); ?>" method="post" id="book_form">
						<?php echo e(csrf_field()); ?>

						<input type="hidden" name="book_id" id="book_id"/>
						<input type="hidden" name="user_id" id="user_id"/>
						
					</form>
					<?php endif; ?>
				</div>
			</div>	
			<div class="row">
				<div class="offset-md-5  col-md-6">
					<button type="button" class="btn btn-primary" id="btn_submit">送　信</button>
					<a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
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
        $(document).ready(function(){
            $("#btn_submit").click(function(){
				var book_checks = $(".checked .book_check");
				if(book_checks.length != 1){
					$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CHECK_ONEQUIZUSER']); ?>");
	                $("#alertModal").modal();
	                return;
				}else{
					$("#book_id").val($(".checked .book_check").attr("bid"));
					$("#user_id").val($(".checked .book_check").attr("oid"));
					$("#book_form").submit();
				}
            });
        });
	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>