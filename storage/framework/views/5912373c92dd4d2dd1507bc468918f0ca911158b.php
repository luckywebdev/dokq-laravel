

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>">
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
	            	<a href="<?php echo e(url('/mypage/top')); ?>">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="<?php echo e(url('/mypage/main_info')); ?>">
	                	 > 基本情報
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	> 読Qを退会
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Qを退会</h3>
			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8">
					<p>本当に退会しますか？</p>
					<p>・　退会すると、今まで貯めた合格履歴やポイントを取り戻せなくなります。</p>
					<p>・　有効期間が残っていても、退会手続きをすると即座に退会となります。払込済みの会費は返金いたしません。</p>
					<p>退会のタイミングについて</p>
					<p>・　クレジットカード払いの場合・・・次回引落日の５日前までに退会手続きをしなかった場合、次回の会費も引き落とされますのでご注意ください。</p>
					<p>・　銀行口座引落の場合・・・・・・次回引落日の１０日前までに退会手続きをしなかった場合、次回の会費も引き落とされますのでご注意ください。</p>
					<br><br>
					<p>退会は、顔認証が必要です。顔認証登録が無い方は、Ｅメールで本人確認をしてからのお手続きとなります。Eメールで届いたＵＲＬをクリックしてください。</p>
				</div>
			</div>
			<form class="form form-horizontal offset-md-2" action="<?php echo e(url('/auth/escape_mail')); ?>" method="post">
			<?php if(count($errors) > 0 && $errors->has('servererr')): ?>
				<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endif; ?>
			<?php echo e(csrf_field()); ?>

				<input type="hidden" id="email" name="email" value="<?php echo e($user->email); ?>">
				<div class="form-group row">
					<label class="control-label col-md-3 pull-right">パスワード入力</label>
					<div class="col-md-3">
						<input type="password" class="form-control" id="password">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 pull-right">顔認証の登録がある方</label>
					<div class="col-md-3">
						<button type="button" class="btn btn-warning pull-left" onclick='do_face()' <?php if(isset($user) && $user->image_path == '' &&  $user->image_path == null): ?> disabled <?php endif; ?>>顔認証で退会</button>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 pull-right">顔認証未登録の方、<br>顔認証がエラーになる方</label>
					<div class="col-md-8">
						<button type="button" class="btn btn-warning pull-left" onclick="do_escape()">Eメールで本人確認して退会</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
					</div>
				</div>
			</form>

			
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {


			});
		function do_face() {
			if ("<?php echo e($mypassword); ?>" == $("#password").val()) {
        		// location.href="/auth/escape_group";
        		location.href="/mypage/face_verify/3";
			}else{
				bootbox.dialog({
	                message: "パスワードを確認して下さい。",
	                title: "読Q",
	                closeButton: false,
	                buttons: {
	                  success: {
	                    label: "確認",
	                    className: "btn-primary",
	                    callback: function() {
	                    	
	                    }
	                  }
	                }
	            });
			}
		}

		function do_escape() {
			
			if ("<?php echo e($mypassword); ?>" == $("#password").val()) {
            	//location.href="/auth/escape_mail?email="+'<?php echo e($user->email); ?>';
            	$(".form-horizontal").submit();
			}else{
				bootbox.dialog({
	                message: "パスワードを確認して下さい。",
	                title: "読Q",
	                closeButton: false,
	                buttons: {
	                  success: {
	                    label: "確認",
	                    className: "btn-primary",
	                    callback: function() {
	                    	
	                    }
	                  }
	                }
	            });
			}
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>