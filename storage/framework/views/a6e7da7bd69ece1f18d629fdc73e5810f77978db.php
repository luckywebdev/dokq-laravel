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
            <form class="form-horizontal" method="POST" action="<?php echo e(url('/auth/doresetpwd')); ?>">
            <?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
              	<?php echo e(csrf_field()); ?>

                <input type="hidden" id="email" name="email" value="<?php echo e($user->email); ?>">
        				<h3>パスワードの再設定</h3>
        				<p>&nbsp;</p>
                    <input type="hidden" name="token" value="<?php echo e($user->refresh_token); ?>">
                    <div class="form-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">                            
                          <input id="username" type="text" class="form-control" value="<?php echo e($user->username); ?>" disabled>
                     </div>
                     <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                           <p class="helper-block">
            								新しいパスワードを入力（半角英数８文字以上１５文字以内）
            						   </p>
            							<input id="password" type="password" class="form-control" name="password" required>									
                                <?php if($errors->has('password')): ?>
                                   <span class="help-block">
                                       <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>                                
                      </div>
                      <div class="form-group">
                      	  <label style="padding-left:0px !important; margin-left: -3px !important"><input type="checkbox" id="show_password">パスワードを表示する</label>
                      </div>
                      <div class="form-group">
                            <div class="offset-md-1 col-md-5">
                                <button type="submit" class="btn btn-warning">送　信</button>
                            </div>
                            <div class="col-md-2">
                                <a href="<?php echo e(url("/")); ?>" class="btn btn-info">読Qトップに戻る</a>
                            </div>
                      </div>
             </form> 
         </div>                   
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#show_password").change(function(){
				var status = $(this).attr("checked");
				
				if(status ==  'checked'){
					
					$("#password").attr("type","text");
				}else{
					
					$("#password").attr("type","password");
				}
			});
		});
	</script>	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>