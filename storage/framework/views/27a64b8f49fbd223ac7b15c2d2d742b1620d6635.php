

<?php $__env->startSection('styles'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
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
	            <li>
	                > <a href="<?php echo e(url('/book/search')); ?>">本を検索</a>
	            </li>
	            <li>
	                > <a <?php if($book->active >= 3): ?> href="<?php echo url('book').'/'.$book->id.'/detail'; ?>" <?php endif; ?>>本のページ</a>
	            </li>
	            <li class="hidden-xs">
	                > 読Q合格者検索結果
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Q合格者の検索結果</h3>

			<div class="row">
				<div class="offset-md-1 col-md-10">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="yellow">
								<th class="col-md-3">氏名</th>
								<th class="col-md-3">読Qネーム</th>
								<th class="col-md-3">本の名前</th>
								<th class="col-md-3">合格日</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						    <?php if(count($bookPasses) > 0): ?>
						    	<?php $index = 1; ?>
							    <?php $__currentLoopData = $bookPasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr <?php if($key % 2 == 0): ?> class="warning" <?php endif; ?>>
									<td><a href="<?php echo e(url('mypage/other_view/' . $one->id)); ?>" class="font-blue-madison">
										<?php if($one->age() < 15 && $schoolmember == 0): ?>
							                中学生以下ー<?php echo e($index); ?>

							            <?php else: ?>
							            	<?php if($one->role != config('consts')['USER']['ROLE']['AUTHOR']){
							                            if($one->fullname_is_public) 
							                            	$title = $one->fullname(); 
							                            else $title = '●●●'; 
							                        }else{
							                            if($one->fullname_is_public) 
							                            	$title = $one->fullname_nick();
							                            else $title = '●●●'; 
							                        } 
							                        echo $title;?> 
							            <?php endif; ?>
							           </a></td>
									<td><a href="<?php echo e(url('mypage/other_view/' . $one->id)); ?>" class="font-blue-madison">
										<?php if($one->age() < 15 && $schoolmember == 0): ?>
							                中学生以下ー<?php echo e($index++); ?>

							            <?php else: ?>
							            	<?php if($one->role != config('consts')['USER']['ROLE']['AUTHOR']){
							                            if($one->fullname_is_public) 
							                            	$title = '●●●'; 
							                            else $title = $one->username; 
							                        }else{
							                            if($one->fullname_is_public) 
							                            	$title = '●●●';
							                            else $title = $one->username; 
							                        } 
							                        echo $title;?> 
							            <?php endif; ?>
							            </a></td>
									<td><a href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" class="font-blue-madison"><?php echo e($one->title); ?></a></td>
									<td><?php echo e(date_format(date_create($one->finished_date), "Y/m/d")); ?></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
							<tr class="warning">
								<td colspan="4" class="text-md-center">該当がありませんでした。</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>