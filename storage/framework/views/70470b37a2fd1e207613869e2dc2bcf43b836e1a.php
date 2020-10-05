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
	            <li class="hidden-xs">
	            	<a href="<?php echo e(url('/mypage/top')); ?>">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 試験監督履歴
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-5"></div>	
					<div class="col-md-3">	
						<h3 class="page-title" >試験監督履歴</h3>
					</div>
					<div class="col-md-4">	
						<div class="row">
							<span>監督人数順位：<?php echo e($userrank); ?>位/<?php echo e(count($aptitudes)); ?>人  これまでに監督した実人数 <?php echo e(count($user_histories)); ?>人</span>
						</div>
						<div class="row">
							<span>監督回数順位：<?php echo e($rank); ?>位/<?php echo e(count($aptitudes)); ?>人  これまでに監督した検定回数 <?php echo e(count($histories)); ?>回</span>
						</div>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="blue">
								<th class="col-md-2">開始日時</th>
								<th class="col-md-2">終了日時</th>
								<th class="col-md-2">受検者</th>
								<th class="col-md-2">タイトル</th>
								<th class="col-md-1">読Q本ID</th>
								<th class="col-md-1">合否</th>
								<th class="col-md-2">試験監督の方法</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						    <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="info text-md-center">
								<td><?php echo e($history->created_date); ?></td>
								<td <?php if($history->finished_date == ""): ?> style="color:#f00" <?php endif; ?>><?php if($history->finished_date == ""): ?> （検定中） <?php else: ?> <?php echo e($history->finished_date); ?> <?php endif; ?></td>
								<td><a href="<?php echo e(url("/mypage/other_view/" . $history->user_id)); ?>" class="font-blue-madison"><?php if($history->User->fullname_is_phblic): ?> <?php echo e($history->User->fullname()); ?> <?php else: ?> <?php echo e($history->User->username); ?> <?php endif; ?>
								</a></td>
								<td><a <?php if($history->Book->active >= 3): ?> href="<?php echo e(url("/book/" . $history->Book->id . "/detail")); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($history->Book->title); ?></a></td>
								<td><a <?php if($history->Book->active >= 3): ?> href="<?php echo e(url("/book/" . $history->Book->id . "/detail")); ?>" <?php endif; ?> class="font-blue-madison">dq<?php echo e($history->Book->id); ?></a></td>
								<td><?php if($history->status == 3): ?> 合格 <?php elseif($history->status == 4): ?> 不 <?php else: ?> （検定中） <?php endif; ?></td>
								<td><?php if($history->examinemethod == 0): ?> 顔認証 <?php elseif($history->examinemethod == 1): ?> パスワード入力 <?php else: ?>  <?php endif; ?></td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row margin-top-10">
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