
<?php $__env->startSection('styles'); ?>
    <!-- BEGIN PAGE LEVEL STYLES -->
	<link href="<?php echo e(asset('css/pages/timeline.css')); ?>" rel="stylesheet" type="text/css"/>
	<link href="<?php echo e(asset('css/pages/news.css')); ?>" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
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
                	<a href="<?php echo e(url('/about_site')); ?>"> > 読Qとは</a>
	            </li>
	             <li class="hidden-xs">
                	<a href="#"> > 監修者紹介</a>
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
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">監修者紹介</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<p style="font-size:16px;">
						監修者とは、担当する本の、クイズを監修する人です。会員が作ったクイズを選定し、正式な検定問題として認定する権限を持ちます。認定後も、クイズや帯文投稿など、その本のページの監修を続けていただきます。<br>
						監修者には、著者の方や学校教師の方もいます。
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<select class="bs-select form-control">
						<option value="0" <?php if($order == 0): ?> selected <?php endif; ?>>ポイント順に並べ替え</option>
						<option id="name_order" value="1" <?php if($order == 1): ?> selected <?php endif; ?>>五十音順に並べ替え</option>
					</select>
				</div>
			
			</div>

			<!-- BEGIN PAGE CONTENT-->
			<div class="timeline">
				<!-- TIMELINE ITEM -->
				<?php $__currentLoopData = $overseers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overseer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="timeline-item">
					<div class="timeline-badge">
						<img class="timeline-badge-userpic" src="<?php echo e(asset($overseer->myprofile)); ?>">
					</div>
					<div class="timeline-body" style="padding-top:0px;padding-bottom:0px;">
						<div class="timeline-body-arrow">
						</div>
						<div class="timeline-body-head">
							<div class="timeline-body-head-caption">
								<a class="timeline-body-title font-blue-madison" href="<?php echo e(url('mypage/other_view/' . $overseer->id)); ?>"><?php if($overseer->isAuthor()): ?><?php echo e($overseer->fullname_nick()); ?><?php else: ?><?php echo e($overseer->fullname()); ?><?php endif; ?></a>
							</div>
						</div>
						<div class="timeline-body-content">
							<table class="table table-no-border" style="margin-top:5px;margin-bottom:5px;">
								<tr>
									<td style="padding-top:0px;padding-bottom:0px; width: 35%">居住地</td>
									<td style="padding-top:0px;padding-bottom:0px; width: 65%"><?php if($overseer->address1_is_public == 1): ?><?php echo e($overseer->address1); ?><?php else: ?> <?php endif; ?>&nbsp;&nbsp; <?php if($overseer->address2_is_public == 1): ?><?php echo e($overseer->address2); ?><?php else: ?> <?php endif; ?></td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">監修した本の合計読Qﾎﾟｲﾝﾄ</td>
									<td style="padding-top:0px;padding-bottom:0px;"><?php echo e(floor($overseer->point*100)/100); ?>ポイント</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">監修した本</td>
									<td style="padding-top:0px;padding-bottom:0px;">
									 <?php
									 if($overseer->overseerbook_list !== null && $overseer->overseerbook_list != '')
									 	$overseerbook_list = preg_split('/,/', $overseer->overseerbook_list);
									 else
									 	$overseerbook_list = $overseer->overseerBooks($overseer);
									 ?>
									 <?php $__currentLoopData = $overseerbook_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $book_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 	<?php $book = $overseer->getBook($book_id); ?>
									 	 <?php if($key + 1 == count($overseerbook_list)): ?>
									 		<a href="<?php echo e(url('/book/'.$book['id'].'/detail' )); ?>"><?php echo e($book['title']); ?></a>
									 	 <?php else: ?>
									 	 	<a href="<?php echo e(url('/book/'.$book['id'].'/detail' )); ?>"><?php echo e($book['title']); ?>、&nbsp;</a>
									 	 <?php endif; ?>
									 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">最終学歴</td>
									<td style="padding-top:0px;padding-bottom:0px;"><?php echo e($overseer->scholarship); ?></td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">職業</td>
									<td style="padding-top:0px;padding-bottom:0px;"><?php echo e($overseer->job); ?></td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">読書について</td>
									<td style="padding-top:0px;padding-bottom:0px;"><?php echo e($overseer->about); ?></td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<!-- END TIMELINE ITEM -->
				<!-- TIMELINE ITEM -->
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<!-- END TIMELINE ITEM -->
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	
	<form id="order_form" action="" method="get">
		<input type="hidden" id="order" name="order" value="">
	</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script src="<?php echo e(asset('js/timeline.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('body').addClass('page-container-bg-solid');
			ComponentsDropdowns.init();
//			Timeline.init(); // init timeline page
//			alert("dd");
			$('select').change(function(){
//				if($(':selected').attr('id') == 'name_order'){
//					
//					}
   
				$("#order").val($(this).val());
				$("#order_form").attr("method", "get");
				$("#order_form").attr("action", "<?php echo e(url('/about_overseer')); ?>");
				$("#order_form").submit();
				})

		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>