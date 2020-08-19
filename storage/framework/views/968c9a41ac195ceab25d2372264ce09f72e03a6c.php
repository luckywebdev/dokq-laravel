

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
	                	 > 読Qからの連絡帳
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Qからの連絡帳</h3>

			<div class="portlet-body" style="height: 420px;">
				<div class="table-scrollable table-scrollable-borderless scroller" style="height:400px;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">						
					<table class="table table-no-border" >
						
						<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="text-md-center info" style="font-size:16px;white-space:nowrap;">						   
						    <td class="col-md-2 col-xs-2"><?php echo e(date_format(date_create($message->created_at), "Y/m/d")); ?></td>
						    <td class="col-md-2 col-xs-2" >
						    	<?php if($message->from_id == $user->id): ?><?php echo  '協会' ?>
								<?php elseif($message->from_id == 1): ?><?php echo  '協会' ?>
								<?php else: ?>
									<?php echo $message->name ?>
								<?php endif; ?>
						    </td>
							<td class="col-md-8 col-xs-8 text-md-left" >
								<?php if($message->from_id == $user->id): ?>
									<?php if($message->type == 2): ?>
										<?php if($message->post): ?> 
									 		<?php echo e("「返信内容」".$message->post."「お問合せ」".$message->content); ?>

									 	<?php else: ?>
									 		<?php echo e("「お問合せ」".$message->content); ?>

									 	<?php endif; ?>
									<?php else: ?>
										<?php echo  $message->post ?>
									<?php endif; ?>
								<?php else: ?>
									<?php echo $message->content ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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