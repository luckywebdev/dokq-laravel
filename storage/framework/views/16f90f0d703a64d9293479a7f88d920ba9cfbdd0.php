
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
			            > 	<a href="<?php echo e(url('/top')); ?>">協会トップ</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">協会トップ</h3>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8" >
				    <div class="panel panel-primary">
				      <div class="panel-heading"><h4 class="text-center">昨日の読Q記録</h4></div>
				      <div class="panel-body">
				      	<div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">アクセス数（トップ）</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($accessCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">ログインのべ人数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($loginCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">受検数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($testCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">合格数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($testPassedCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">登録申請書籍数(急務）</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($demandBooksCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">正式認定書籍数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($approvalBooksCnt); ?></h5>
					      	</div>
					     </div>
					     <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">作成クイズ数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($newQuizCnt); ?></h5>
					      	</div>
					      </div>
					      <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">認定クイズ数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($approvalQuizCnt); ?></h5>
					      	</div>
					      </div>
					      <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">新規団体数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($newGroupCnt); ?></h5>
					      	</div>
					      </div>
					    <div class="row">
					      	<div class="col-md-6">
					      		<h5 class="text-center">新規個人会員数</h5>
					      	</div>
					      	<div class="col-md-6">
					      		<h5 class="text-center"><?php echo e($newPersonCnt); ?></h5>
					      	</div>	
				      	</div>
				    </div>
			    </div>
			</div>	
		</div>
		    <div class="row">
		    		<div class="col-md-8"></div>
					<div class="alert alert-info alert-dismissable">
						<strong>新着問い合わせメール(未読)通</strong>
						<br><br>
						<a href="<?php echo e(url('/admin/quiz_answer')); ?>" class="btn btn-warning pull-right" role="button">メールを確認する</a>
					</div>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>