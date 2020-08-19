
<?php $__env->startSection('styles'); ?>
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
	            <li class="breadcrumb-item">
					<a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="breadcrumb-item">
					<a href="#">受検</a>
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
			<h3 class="page-title">パスワードがちがいます</h3>
			<form class="form form-horizontal" action="<?php echo e(url('/book/test/forget_pwd/mail')); ?>" method="post">
        	<?php echo e(csrf_field()); ?>	
        			
			<div class="row">
				<div class="col-md-12 text-md-center">

					<h4>※　児童生徒は、担任の先生にパスワードをおしえてもらうことができます。</h4>
					<br>
					<h4>
						パスワードを忘れた場合は、パスワードを再設定します。<br>下記の「送信」ボタンを押すと、再設定フォームのURLが、ご登録のメールアドレス宛に届きます。
					</h4>
					<button type="button" class="btn btn-warning btn-sendmail"  style="margin-bottom:8px" <?php if(Auth::user()->isOverseer()): ?> disabled <?php endif; ?>>送　信</button>
					<br><br><br>
					<h5>
						※　試験監督のパスワードエラーは、監督自身の端末でパスワード再設定手続きをしてください。
					</h5>
					<button type="button" class="btn btn-danger" onclick="javascript:history.go(-1)" style="margin-bottom:8px">キャンセル</button>
				</div>
			</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-info pull-right" href="<?php echo e(url('/')); ?>" style="margin-bottom:8px">トップに戻る</a>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
			$(".btn-sendmail").click(function() {
				$(".form-horizontal").submit();
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>