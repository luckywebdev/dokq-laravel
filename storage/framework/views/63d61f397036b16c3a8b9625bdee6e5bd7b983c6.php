

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
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="<?php echo e(url('/')); ?>">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修応募履歴
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修応募履歴</h3>

			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="blue">
									<th class="col-md-2 col-xs-2">応募日</th>
									<th class="col-md-2 col-xs-2">タイトル</th>
									<th class="col-md-2 col-xs-2">著者</th>
									<th class="col-md-1 col-xs-1">読Q本ID</th>
									<th class="col-md-2 col-xs-2">応募理由</th>
									<th class="col-md-2 col-xs-2">決定通知日</th>
									<th class="col-md-1 col-xs-1">監修</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								<?php $__currentLoopData = $demands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e(with((date_create($demand->updated_at)))->format('Y/m/d')); ?></td>
									<td><a <?php if($demand->Book->active >= 3): ?> href="<?php echo e(url('/book/' . $demand->book_id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($demand->Book->title); ?></a></td>
									<td><a href="<?php echo e(url('/book/search_books_byauthor?writer_id=' . $demand->Book->writer_id.'&fullname='.$demand->Book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($demand->Book->fullname_nick()); ?></a></td>
									<td>dq<?php echo e($demand->book_id); ?></td>
									<td><?php echo e($demand->reason); ?></td>
									<td>
										<?php if($demand->overseer_id == $user->id && $demand->Book->active >= 5): ?>
										<?php echo e(with((new Date($demand->Book->replied_date3)))->format("Y/m/d")); ?>

										<?php endif; ?>
									</td>
									<td>
										<?php if($demand->Book->active >= 5): ?>
											<?php if($demand->overseer_id == $user->id && $demand->status == 1): ?>
											〇
											<?php else: ?>
											X
											<?php endif; ?>
										
										    
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
		jQuery(document).ready(function() {
			<?php if($otherview_flag): ?>
				$('body').addClass('page-full-width');
				var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
			<?php endif; ?>
		});   
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>