<?php $__env->startSection('contents'); ?>
<div class="login">
    <div class="logo">
        <a class="text-md-center" href="<?php echo e(url('/')); ?>">
            <img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_only_up.png')); ?>">
        <!-- <a href="<?php echo e(url('/')); ?>" style="color:white; font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', HGP明朝B;">
            読<span style="font-family: 'Judson'">Q</span> -->
        </a>
    </div>
    <div class="content">
        
        
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" method="POST" action="<?php echo e(url('/auth/dologin')); ?>" novalidate="novalidate">
            <?php echo e(csrf_field()); ?>

            
            <h3 class="form-title">読Qにログイン</h3>
            
            <?php if(count($errors) > 0 && ($errors->first('error') != 'vice_log')): ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span>
                        <?php if($errors->first('error') == 'locked'): ?>
                             ロックがかかったのでパスワードを再設定して下さい。
                        <?php elseif($errors->first('error') == 'no_use'): ?>
                             無効の読Ｑネームです。ログインできません。
                        <?php else: ?>
                            読Qネームまたはパスワードが違います。<br>
                             3回間違えて入力すると、ロックがかかります。
                        <?php endif; ?>

                    </span>
                </div>
            <?php endif; ?>
            <div class="form-group <?php echo e($errors->has('username') ? ' has-danger' : ''); ?>">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">読Qネーム</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="読Qネーム" name="username" autofocus value="<?php echo e(old('username')); ?>">
                <?php if($errors->has('username')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('username')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group <?php echo e($errors->has('password') ? ' has-danger' : ''); ?>">
                <label class="control-label visible-ie8 visible-ie9">パスワード</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" id="password" autocomplete="off" placeholder="パスワード" name="password">
			    	<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">パスワードを表示する</label>
                <?php if($errors->has('password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success uppercase" style="margin-right:20px;">ログイン</button>
                <input type="checkbox" class="checkboxes" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                	ログイン状態を保持する                 	
                	
            </div>
            <div class="form-actions">
            	<p class="text-md-right">パスワードを忘れた場合は <a href="<?php echo e(url('auth/forgot_pwd')); ?>">こちら</a></p>
            </div>
            <p class="text-md-right">
                <a href="<?php echo e(url("/")); ?>" class="btn btn-info">読Qトップに戻る</a>
            </p>
            <div class="create-account">
                <p>
                    <a href="<?php echo e(route('auth/register')); ?>">新 規 登 録</a>
                </p>
            </div>
        </form>
        <!-- END LOGIN FORM -->
    </div>
    <div class="copyright" style="background-color: #364150;">
    <?php echo e(Date('Y')); ?> © 一般社団法人 読書認定協会 All Rights Reserved
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
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