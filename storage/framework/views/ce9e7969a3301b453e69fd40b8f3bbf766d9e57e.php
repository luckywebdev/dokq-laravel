<html>
    <body>
    	<div>
        <?php $i = 1; ?>
            <?php $__currentLoopData = $voter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voter_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php if($voter_user->User->age() < 15): ?> 
                	<a href="<?php echo e(url('mypage/other_view/' . $voter_user->voter_id)); ?>" style="color:blue;font-size:14px;">中学生以下ー<?php echo($i); $i++;?></a>
                <?php else: ?> 
                	<a href="<?php echo e(url('mypage/other_view/' . $voter_user->voter_id)); ?>" style="color:blue;font-size:14px;"><?php if($voter_user->fullname_is_public): ?> <?php if($voter_user->role != config('consts')['USER']['ROLE']['AUTHOR']): ?> <?php echo e($voter_user->firstname.' '.$voter_user->lastname); ?> <?php else: ?> <?php echo e($voter_user->firstname_nick.' '.$voter_user->lastname_nick); ?> <?php endif; ?> <?php else: ?> <?php echo e($voter_user->username); ?> <?php endif; ?></a>
                <?php endif; ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	</div>
    </body>
</html>
