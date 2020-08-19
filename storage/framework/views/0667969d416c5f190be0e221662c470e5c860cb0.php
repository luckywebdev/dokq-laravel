

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
                        > クイズ募集中の本リスト
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズ募集中の本リスト</h3>

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
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>					        
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>
							        <th>出題数</th>
							        <th>今集まっているクイズ数</th>
							        <th>クイズストックを見る</th>
						        </tr>
						    </thead>
						    <tbody class="text-md-center">
								<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td style="vertical-align:middle"><?php echo e(with((date_create($book->replied_date1)))->format('Y/m/d')); ?></td>
									<td style="vertical-align:middle"><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/' . $book->id . '/detail')); ?>" <?php endif; ?> class="font-blue"><?php echo e($book->title); ?></a></td>
									<td style="vertical-align:middle"><a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue"><?php echo e($book->fullname_nick()); ?></a></td>
									<td style="vertical-align:middle">dq<?php echo e($book->id); ?></td>
									<td style="vertical-align:middle"><?php echo e(floor($book->point*100)/100); ?></td>
									<td style="vertical-align:middle"><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
									<td style="vertical-align:middle"><?php echo e($book->quiz_count); ?></td>
									<td style="vertical-align:middle"><?php echo e($book->PendingQuizes()->count()); ?></td>
									<td><input type="checkbox" class="book_check" bid="<?php echo e($book->id); ?>"></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
        $(document).ready(function(){
			$(".book_check").click(function(){
				location.href="<?php echo e(url('/admin/can_book_e')); ?>/" + $(this).attr("bid");
			});
        });
	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>