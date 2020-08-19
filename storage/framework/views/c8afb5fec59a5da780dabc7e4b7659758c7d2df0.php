

<?php $__env->startSection('contents'); ?>
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][1];
	$auth_types = config('consts')['USER']['AUTH_TYPE'][0];
	$genders = config('consts')['USER']['GENDER'];
	$purposes = config('consts')['USER']['PURPOSE'][1];
	
?>
<div class="container register">
	<div class="form">
		<form class="form-horizontal" method="post" role="form" action="<?php echo e(url('/auth/changepassword')); ?>">
			<input type="hidden" value="<?php echo e($user->authfile); ?>" name="authfilename" id="authfilename">
			<input type="hidden" name="refresh_token" value="<?php echo e($user->refresh_token); ?>"/>
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 20px; padding: 0 !important;">
                    <a class="text-md-center" href="<?php echo e(url('/')); ?>">
						<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_reserve_2.png')); ?>">
                        <!-- <h1 style="margin: 0 !important; font-family: 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
                        <h6 style="margin: 0 !important; font-family: HGP明朝B;">読書認定級</h6> -->
                    </a>
			    </div>
				<div class="form-body col-md-11">
					<ul class="nav nav-pills nav-fill steps">
						<li class="nav-item active">
							<span class="step" aria-expanded="true">
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
						<li class="nav-item">
							<span class="step">
							<span class="number"> 4 </span>
							<span class="desc"><i class="fa fa-check"></i> ステップ４ </span>
							</span>
						</li>
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 75%;">
						</div>
					</div>				
				</div>
			</div>
			<h3 class="text-sm-center"> 正式ID（読Qネーム）、パスワード登録</h3>
			<?php echo e(csrf_field()); ?>

			<div class="note note-info">

				<h5  style="line-height:150%;">
					
					 貴団体の読Qネームを設定しました。末尾の郵便番号７桁は変更できませんが、ローマ字部分はこのフォームで変更可能です。読Qネームは、設定後の変更ができませんので、間違いのないように入力をお願いいたします。（郵便番号を含めて30文字以内）
					
				</h5>
			</div>	
			<?php if(count($errors) > 0): ?>
				<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endif; ?>
			<div class="form-group row <?php echo e($errors->has('username') ? ' has-danger' : ''); ?>">
				<label class="control-label col-sm-3 offset-md-2 text-sm-right" for="romaname">読Qネーム:</label>
				
				<div class="col-md-2">
					<input type="text" required name="romaname" value="<?php echo e($romaname); ?>" class="form-control" id="romaname">
				</div>
				<div class="col-md-2">
					<input type="text" required name="numbername" value="<?php echo e($numbername); ?>" readonly="true" class="form-control" id="numbername">
				</div>
				<?php if($errors->has('romaname')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('romaname')); ?></span>
				</span>
				<?php endif; ?>
				
			</div>
			<div class="form-group row <?php echo e($errors->has('password') ? ' has-danger' : ''); ?>">
				<label class="control-label col-sm-3 offset-md-2 text-sm-right" for="password">パスワード:</label>
				<div class="col-md-4">
					<input type="password" required name="password" value="<?php echo e(old('password')); ?>" class="form-control" id="password">
			    	<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">表示する</label>
				</div>
			</div>

			<div class="form-group row">
				<label class="control-label offset-md-4 text-danger">
					<span class="help-block">正式なパスワードを、8文字以上の半角英数で入力してください。</span>
				</label>
				<label class="control-label offset-md-4 text-danger">
					※ ログインに使用する重要な情報です。必ず控えてください。		
				</label>
			</div>

			<div class="form-group form-actions row">
				<div class="offset-md-4 col-md-4 text-md-center col-sm-12" >
					<button type="submit" class="btn btn-success" style="margin-bottom:8px">次　へ</button>
				</div>
				<div class="col-md-4 text-md-right col-sm-12">
					<a href="javascript:history.go(-1)" class="btn btn-info" style="margin-bottom:8px">戻って修正する</a>
				</div>
			</div>
		</form>
		
	</div>
</div>
<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
	var isChecked = false;
	$(".form-horizontal:first").submit(function(){
	    if (isChecked) return true;
		var params = "username=" + $("#romaname").val() + $("#numbername").val() + "&password=" + $("#password").val();
		
		$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/user/duppasswordcheck?" + params,
			function(data, status){
				if(data.result=="dup"){
	        		//alert("<?php echo e(config('consts')['MESSAGES']['PASSWORD_EXIST']); ?>");
	        		$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['PASSWORD_EXIST']); ?>");
	        		$("#alertModal").modal();
	        		$("#password").select();
	        	} else {
	        	    isChecked = true;
	        		$(".form-horizontal").submit();
	        	}
			});
		return false;
	});
	$("#show_pwd").change(function() {
	    if($(this).attr("checked")) {
	        $("#password").attr("type", "text");
	    } else {
	        $("#password").attr("type", "password");
	    }
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>