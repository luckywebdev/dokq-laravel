<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	<strong>エラー! &nbsp;
			<?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<span><?php echo e($error); ?></span>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</strong> 
</div>