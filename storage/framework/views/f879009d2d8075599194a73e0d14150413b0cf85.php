



<?php $__env->startSection('contents'); ?>
<div class="container">
	<div class="form">
		<div class="form-horizontal">
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="<?php echo e(url('/')); ?>">
						<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_reserve_2.png')); ?>">
                        <!-- <h1 style="margin: 0 !important; font-family: 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
                        <h6 style="margin: 0 !important; font-family: HGP明朝B;">読書認定級</h6> -->
                    </a>
			    </div>
				<div class="form-body col-md-11">
					<ul class="nav nav-pills nav-fill steps">
						<li class="nav-item active">
							<span class="step">
								<span class="number"> 1 </span>
								<span class="desc">
									<i class="fa fa-check"></i> ステップ１
								</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２ 
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>		
					
						<?php if($role == 0): ?>
							<li class="nav-item">
								<span class="step">
								<span class="number"> 4 </span>
								<span class="desc"><i class="fa fa-check"></i> ステップ４ </span>
								</span>
							</li>
						<?php endif; ?>
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width:<?php echo e($role == 0 ?  25 :  33); ?>%;">
						</div>
					</div>
					<div class="jumbotron">
						<h3><?php echo e(config('consts')['USER']['TYPE'][$role]); ?><?php echo e($role == 2 ? '候補' :''); ?>会員登録の申請が完了しました</h3>
						<hr class="my-4">
						<p class="lead">
					  		このたびは、読Qに会員登録申請をしていただき、ありがとうございます。
				  		</p>
				  		<p class="lead">
						<?php if($role == 0): ?>
				  			読書認定協会からご登録のEメール宛に、仮ID、仮パスワードをお知らせしますので、それを使用してログインしてください。<br>
							通知から７日間を過ぎるとログインできなくなりますので、その場合はもう一度最初からお手続きをお願いいたします。
						<?php else: ?>
                            正式登録用URLを、ご登録メールアドレス宛に送信しますので、そこから手続きをしてください。<br>
                            通知から７日間を過ぎると無効になります。その場合はお手数ですが、もう一度最初からお手続きをお願いいたします。
						<?php endif; ?>
				  		</p>
						<hr class="my-4">
					  	<p>
						<?php if($role == 0): ?>
					  		※　3日経っても読書認定協会からメールが届かない場合は、メールアドレスを間違えて登録された可能性があります。恐れ入りますが再度申請をお願いいたします。
					  	<?php else: ?>
					  	    ※　２日経ってもメールが届かない場合は、メールアドレスを間違えて登録された可能性があります。恐れ入りますが再度申請をお願いいたします。
						<?php endif; ?>
					  	</p>
					</div>
					<div class="col-md-12 text-md-right">
						<a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップへ戻る</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="container">
    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>