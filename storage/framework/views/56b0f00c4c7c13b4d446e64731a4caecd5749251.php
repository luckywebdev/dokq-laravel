



<?php $__env->startSection('contents'); ?>
<div class="container register">
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
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２ 
							</span>
							</span>
						</li>
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>						
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 100%;">
						</div>
					</div>
				</div>
			</div>
					<div class="jumbotron">
						<h3>読Q会員登録が完了しました</h3>
						<hr class="my-4">
						<p class="lead">
					  		読Q会員登録をしていただき、ありがとうございました。
				  		</p>
				  		<p class="lead">
				  			ご登録のメールアドレス宛に、読Qネームとパスワードの一部表示を送信しました。<br>
							今後ログインする際に入力してください。<br>
							なお、下記「読Qトップへ戻る」ボタンから、既にログインした状態ですぐに読Qを始められます。
				  		</p>
						<hr class="my-4">
					  	<p class="lead">
					  		無料期間内は会費引き落としが行われず、無料でお試しいただけます。
							なお、ご登録いただいた内容に不備があった場合、後日ご連絡いたします。
					  	</p>
					</div>
					<div class="form-group form-actions">
						<div class="text-xs-center text-md-center text-sm-center col-sm-12">
							<a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップへ戻る</a>
						</div>
					</div>
			
		</div>
	</div>
</div>
<div class="container">
    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>