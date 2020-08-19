
<?php $__env->startSection('styles'); ?>
    <style type="text/css">
    	.caution{
    		font-size: 16px;
    	}
    </style>
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
					<a href="<?php echo e(url('book/search')); ?>"> > 読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					<a href="<?php echo e(url('book/search/register')); ?>"> > 本の登録</a>
				</li>
				<li class="hidden-xs">
					<a href="#"> > 登録完了</a>
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">本の登録が完了しました！</h3>
			<br><br>
			<div class="row">
				<div class="offset-md-1 col-md-10">
				  	<div class="form">
						<!-- <form class="form-horizontal" action="<?php echo e(url('/quiz/make/caution')); ?>"> -->
							<?php echo e(csrf_field()); ?>

						<!--	<input type="hidden" name="book_id" value="$book->id">-->
							<div class="form-body offset-md-1 col-md-10">
								<p class="caution">
									新しく、読Qに本を登録していただき、ありがとうございます。<br><br>
									ご登録内容をもとに、協会及び監修者がより適切に編集して正式登録し、クイズ募集と監修者募集をさせていただきます。
									すぐにクイズ作成ができますが、万が一この本が読Qに相応しくないと読書認定協会が判断した場合は、認定を却下させていただきます。
									クイズも保存されません。<br><br>
									結果は、マイ書斎の読Qからの連絡帳でお知らせします。
								</p>
							</div>	
							<div class="form-body">
								<!-- <button class="offset-md-4 btn btn-primary">この本のクイズを作る</button> -->
								<a href = "<?php echo e(url('quiz/make/caution1?book_id=').$book->id); ?>" class="offset-md-4 btn btn-primary">この本のクイズを作る</a>	
								<a href="<?php echo e(url('book/register')); ?>" class="btn btn-success">もう1冊本を登録する</a>
								<a class="btn btn-info pull-right" href="<?php echo e(url('/')); ?>">トップに戻る</a>
							</div>
						<!-- </form> -->
					</div>
				</div>
			</div>

		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
	    $(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>