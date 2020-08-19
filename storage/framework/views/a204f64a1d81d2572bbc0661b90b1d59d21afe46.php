


<?php $__env->startSection('contents'); ?>

<div class="container register">
	<br><br><br>
	<p>
	<center>
	新しいパスワードが登録されました。ご登録のEメールアドレス宛に確認のメールを送信しました。
すぐに新しいパスワードでログインすることができます。
	</center>
	</p>
	<br><br><br>
	<div class="col-md-12 text-md-right">
		<a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップへ戻る</a>
	</div>
	<br><br><br>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>