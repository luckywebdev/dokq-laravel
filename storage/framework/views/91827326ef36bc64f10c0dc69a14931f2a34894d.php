

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
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 読書量ランキング１００
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content" style="height: 700px">
			<h3 class="page-title">読書量ランキング100：　読Qポイント獲得者上位100人</h3>
			<div class="form">
				<form class="form-horizontal form-row-separated"  action="<?php echo e(url('/admin/book_ranking')); ?>" method="get" id="book_form">
					<div class="form-body">
						<div class="form-group col-md-6">
							<label class="control-label col-md-2">期間</label>
							<div class="col-md-4">
								<select class="form-control input-small select2me" name="rankperiod" id="rankperiod" data-placeholder="選択...">
									<option></option>
									<?php $__currentLoopData = config('consts')['USER']['RANKPERIOD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$rperiod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($key+1); ?>" <?php if($rankperiod == $key+1): ?> selected <?php endif; ?>><?php echo e($rperiod); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>							
						</div>
						<div class="form-group col-md-4">
							<label class="control-label col-md-2">年代</label>
							<div class="col-md-3">
								<select class="form-control input-small select2me" name="rankyear" id="rankyear" data-placeholder="選択...">
									<option></option>
									<?php $__currentLoopData = config('consts')['USER']['RANKYEARS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$ryear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($key+1); ?>"  <?php if($rankyear == $key+1): ?> selected <?php endif; ?>><?php echo e($ryear); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>							
						</div>
						<div class="form-group col-md-2">
						<button type="button" id="btn_submit" class="btn btn-warning pull-right" role="button">実　行</button>
						</div>
					</div>
				</form>
			</div>

			<div class="form-body col-md-12">
				<div class="form-group col-md-6" style="max-height: 500px; overflow-y: auto">
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="blue">
								<th>順位</th>
								<th>名前</th>
								<th>級</th>
								<th>居住地</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						   <?php $__currentLoopData = $ranks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						   <?php if($key < ceil(count($ranks)/2)): ?>
							<tr>
								<td><?php echo e($key+1); ?></td>
								<td><?php if(Date("Y") - Date("Y", strtotime($rank->birthday)) >= 15): ?>
										<?php if($rank->firstname != '' && $rank->firstname !== null && $rank->fullname_is_public == 1): ?> 
											<a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue"><?php echo e($rank->firstname); ?> <?php echo e($rank->lastname); ?></a>
										<?php else: ?>
											<a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue"> <?php echo e($rank->username); ?></a>
										<?php endif; ?>
									<?php else: ?> 
										<a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue">中学生以下非表示</a>
									<?php endif; ?>
								</td>
								<td>
									<?php if($rank->cur_point >= 0 && $rank->cur_point < 20): ?>
						               10 級
						            <?php elseif($rank->cur_point >= 20 && $rank->cur_point < 60): ?>
						                9 級
						            <?php elseif($rank->cur_point >= 60 && $rank->cur_point < 120): ?>
						                8 級
						            <?php elseif($rank->cur_point >= 120 && $rank->cur_point < 220): ?>
						                7 級
						            <?php elseif($rank->cur_point >= 220 && $rank->cur_point < 370): ?>
						               6 級
						            <?php elseif($rank->cur_point >= 370 && $rank->cur_point < 870): ?>
						                5 級
						            <?php elseif($rank->cur_point >= 660 && $rank->cur_point < 2070): ?>
						                4 級
						            <?php elseif($rank->cur_point >= 1060 && $rank->cur_point < 6070): ?>
						                3 級
						            <?php elseif($rank->cur_point >= 1610 && $rank->cur_point < 14070): ?>
						                2 級
						            <?php elseif($rank->cur_point >= 2400 && $rank->cur_point < 29070): ?>
						                1 級
						            <?php else: ?>
						                超段
						            <?php endif; ?>
								</td>
								<td><?php if($rank->address1 != '' && $rank->address1 !== null): ?> <?php echo e($rank->address1 != '0' ? $rank->address1 : '国外'); ?> <?php endif; ?></td>
							</tr>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
				<div class="form-group col-md-6" style="max-height: 500px; overflow-y: auto">
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="blue">
								<th>順位</th>
								<th>名前</th>
								<th>級</th>
								<th>居住地</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						   <?php $__currentLoopData = $ranks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						   <?php if($key >= ceil(count($ranks)/2)): ?>
							<tr>
								<td><?php echo e($key+1); ?></td>
								<td><?php if(Date("Y") - Date("Y", strtotime($rank->birthday)) >= 15): ?>
										<?php if($rank->firstname != '' && $rank->firstname !== null && $rank->fullname_is_public == 1): ?> 
											<a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue"><?php echo e($rank->firstname); ?> <?php echo e($rank->lastname); ?></a>
										<?php else: ?>
											<a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue"> <?php echo e($rank->username); ?></a>
										<?php endif; ?>
									<?php else: ?> <a href="<?php echo e(url('mypage/other_view/' . $rank->id)); ?>" class="font-blue">中学生以下非表示</a> <?php endif; ?>
								</td>
								<td>
									<?php if($rank->cur_point >= 0 && $rank->cur_point < 20): ?>
						               10 級
						            <?php elseif($rank->cur_point >= 20 && $rank->cur_point < 60): ?>
						                9 級
						            <?php elseif($rank->cur_point >= 60 && $rank->cur_point < 120): ?>
						                8 級
						            <?php elseif($rank->cur_point >= 120 && $rank->cur_point < 220): ?>
						                7 級
						            <?php elseif($rank->cur_point >= 220 && $rank->cur_point < 370): ?>
						               6 級
						            <?php elseif($rank->cur_point >= 370 && $rank->cur_point < 870): ?>
						                5 級
						            <?php elseif($rank->cur_point >= 660 && $rank->cur_point < 2070): ?>
						                4 級
						            <?php elseif($rank->cur_point >= 1060 && $rank->cur_point < 6070): ?>
						                3 級
						            <?php elseif($rank->cur_point >= 1610 && $rank->cur_point < 14070): ?>
						                2 級
						            <?php elseif($rank->cur_point >= 2400 && $rank->cur_point < 29070): ?>
						                1 級
						            <?php else: ?>
						                超段
						            <?php endif; ?>
								</td>
								<td><?php if($rank->address1 != '' && $rank->address1 !== null): ?> <?php echo e($rank->address1 != '0' ? $rank->address1 : '国外'); ?>  <?php endif; ?></td>
							</tr>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		
        $("#btn_submit").click(function(){
			
			$("#book_form").submit();
			
    	});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>