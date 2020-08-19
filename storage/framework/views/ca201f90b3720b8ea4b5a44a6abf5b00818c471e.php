<?php $__env->startSection('contents'); ?>
<div class="login">
    <div class="logo">
        <a href="<?php echo e(url('/')); ?>" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    </div>
    <div class="content">
         <?php if(session('status')): ?>
            <div class="alert alert-success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>
        <form class="forget-password" method="POST" action="<?php echo e(url('auth/doforgot_email')); ?>">
            <?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php echo e(csrf_field()); ?>

             <h3>Eメールアドレス入力</h3>
            <p>
            	登録Eメールを入力してください。パスワード再設定用のURLを送信します。
            </p>
            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                <input id="email" type="text" class="form-control placeholder-no-fix" name="email" value="<?php echo e(old('email')); ?>" placeholder="Eメールを入力" required>

                <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <a id="back-btn" class="btn btn-info" href="<?php echo e(url('auth/forgot_pwd')); ?>" style="padding: 8px 20px !important; font-weight: bold !important;">戻　る</a>
                <button type="submit" class="btn btn-success pull-right">送　信</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>