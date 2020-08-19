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
			                > 団体アカウントトップ
			            </li>
			        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">団体トップページ</h3>
			
			<form action="/group/edit_teacher_top" class="form-horizontal">
				<div class="form-body">
					<div class="form-group" style="margin-top:10px;margin-bottom:20px;">
						<div class="col-md-12">
							<div class="portlet solid blue">
								<div class="portlet-title" style="font-size:18px;">
									<p><b>読Qからのお知らせ</b></p>
								</div>
								<div class="portlet-body" style="font-size:18px;">
									
									<?php if(count($messages) > 0): ?>
										<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mess): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<p>(<?php echo e(with((date_create($mess->created_at)))->format('Y.m.d')); ?>) <?php if($mess->from_id == Auth::id()): ?><?php echo e($mess->post); ?><?php else: ?><?php echo e($mess->content); ?><?php endif; ?></p>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php else: ?>
									<br>									
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2"  style="margin-bottom:8px;">学級を選択</label>
						<div class="col-md-4"  style="margin-bottom:8px;">
							<select name="group_id" class="bs-select form-control">
								<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($class->id); ?>" <?php if($current_season < $class->year): ?> disabled <?php endif; ?>>
								<?php if($class->grade == 0): ?>									
									<?php if($class->class_number !== null && $class->class_number != ''): ?>
										<?php echo e($class->class_number); ?>

										<?php if($class->teacher_name !== null && $class->teacher_name != ''): ?>
											<?php echo e($class->teacher_name); ?> 
										<?php endif; ?>
										学級 /
									<?php else: ?>
										<?php if($class->teacher_name !== null && $class->teacher_name != ''): ?>
											<?php echo e($class->teacher_name); ?> 学級 /
										<?php endif; ?>
									<?php endif; ?>
								<?php elseif($class->class_number == '' || $class->class_number == null): ?>
									<?php echo e($class->grade); ?> <?php echo e($class->teacher_name); ?>年 /
								<?php else: ?>
									<?php echo e($class->grade); ?>-<?php echo e($class->class_number); ?> <?php echo e($class->teacher_name); ?>学級 /
								<?php endif; ?>	
								<?php echo e($class->year); ?>年度							
								<?php if($class->member_counts != 0 && $class->member_counts !== null): ?>
								 	<?php echo e($class->member_counts); ?>名
								<?php endif; ?>									
								</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--								<option>〇-〇中村学級/2017年度　33名</option>-->
							</select>
						</div>
						<div  style="margin-bottom:8px;">
							<button type="submit" class="btn btn-primary">学級トップページへ</button>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-info pull-right" href="<?php echo e(url('/')); ?>">読Qトップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>