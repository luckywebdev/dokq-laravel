
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
	            <li class="hidden-xs">
					> <a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> <a href="<?php echo e(url('book/test/caution')); ?>">受検の注意</a>
				</li>
				<li class="hidden-xs">
					> パスワード 入力
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">パスワード入力</h3><br>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" action="<?php echo e(url('/book/test/signin')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<?php if(Auth::check()): ?>
							<input type="hidden" name="book_id" value="<?php echo e($bookId); ?>">
							<input type="hidden" name="mode" value="<?php echo e($mode); ?>">
						<?php endif; ?>
						<div class="form-body">
							<div class="form-group row">
								<label class="offset-md-2 col-md-3 control-label">
									<?php if($mode == 0): ?>
										パスワード入力
									<?php elseif($mode == 1): ?>
										試験監督のパスワード入力
									<?php else: ?>
										試験監督のパスワード入力
									<?php endif; ?>
								</label>
								<div class="col-md-3">
									<input type="password" class="form-control" name="password" id="password" value="" >
									<?php if($errors->has('password')): ?>
					                    <span class="help-block">
					                        <strong><?php echo e($errors->first('password')); ?></strong>
					                    </span>
					                <?php endif; ?>
								</div>								
							</div>
							<?php if($mode == 0): ?>
								<?php if($errors->has('invalid_pwd')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">パスワードが間違っています。</h5>
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">
										パスワードを忘れた方は、
										<a href="<?php echo e(url('/book/test/forget_pwd')); ?>" class="font-blue-madison">こちら</a>
									</h5>
								</div>
								<?php endif; ?>
							<?php elseif($mode == 1): ?>
								<?php if($errors->has('invalid_pwd')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">パスワードが間違っています。</h5>
									<!--
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">
										パスワードを忘れた方は、
										<a href="<?php echo e(url('/book/test/forget_pwd')); ?>" class="font-blue-madison">こちら</a>
									</h5>
									-->
								</div>
								<?php elseif($errors->has('aptitude_no')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">適性検査を受けてください。</h5>
								</div>
								<?php elseif($errors->has('tester_oneself')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">自分の試験監督をすることは不可です。</h5>
								</div>
								<?php elseif($errors->has('tester_family')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">家族が試験監督をすることはできません。</h5>
								</div>
								<?php elseif($errors->has('tester_address')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">試験監督を行うには、基本情報の編集で住所を登録する必要があります。</h5>
								</div>
								<?php endif; ?>
							<?php else: ?>
								<?php if($errors->has('invalid_pwd')): ?>
									<div class="form-group row">
										<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">パスワードが間違っています。</h5>
										<!--
										<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">
											 パスワードを忘れた方は、
											<a href="<?php echo e(url('/book/test/forget_pwd')); ?>" class="font-blue-madison">こちら</a>
										</h5>
										-->
									</div>
								<?php elseif($errors->has('aptitude_no')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">適性検査を受けてください。</h5>
								</div>
								<?php elseif($errors->has('tester_oneself')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">自分の試験監督をすることは不可です。</h5>
								</div>
								<?php elseif($errors->has('tester_family')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">家族が試験監督をすることはできません。</h5>
								</div>
								<?php elseif($errors->has('tester_address')): ?>
								<div class="form-group row">
									<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">試験監督を行うには、基本情報の編集で住所を登録する必要があります。</h5>
								</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>	
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<button class="offset-md-5 btn btn-primary">送　信</button>
									<button type="button" class=" btn btn-danger" >キャンセル</button>
									<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">トップに戻る</button>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
	   $(document).ready(function(){
	   	$('#password').val('');
			$('body').addClass('page-full-width');
			$('#password').focus();
			$('.btn-danger').click(function(){
				//location.reload();
				$("input").val('');
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>