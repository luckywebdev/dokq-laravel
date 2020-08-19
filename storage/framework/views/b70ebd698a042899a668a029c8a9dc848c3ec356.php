

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
	            	> <a href="<?php echo e(url('/')); ?>">
	                	団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > 試験監督パスワード送信履
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				受検する児童への試験監督パスワード送信履歴
			</h3>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="info">
                                    <th>パスワード送信日時</th>
                                    <th>受検者</th>
                                    <th>開始時</th>
                                    <th>合格時</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-left">
                                <?php $__currentLoopData = $overseers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overseer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-md-center">
                                    <td><?php echo e($overseer->created_at); ?></td>
                                    <td><?php echo e($overseer->User->fullname()); ?></td>
                                    <?php if($overseer->type == 1): ?>
                                    <td>〇</td>
                                    <td></td>
                                    <?php else: ?>
                                    <td></td>
                                    <td>〇</td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>