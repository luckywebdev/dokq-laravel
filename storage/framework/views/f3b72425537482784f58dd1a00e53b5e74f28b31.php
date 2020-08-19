

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="breadcum">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo e(url('/')); ?>">
                            読Qトップ
                        </a>
                    </li>
                    <li class="hidden-xs">
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 協会の基本情報
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-head">
				<div class="page-title">
					<h3>協会メンバーの基本情報</h3>
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal form" method="post" id="form-validation" role="form" action="<?php echo e(url('/admin/updatebasicinfo')); ?>">
                        <?php echo e(csrf_field()); ?>    
                        <input type="hidden" id='id' name="id" value="<?php echo e($user->id); ?>"> 
                        <div class="form-group row <?php echo e($errors->has('username') ? ' has-danger' : ''); ?>">
                            <label class="control-label col-md-3 text-md-right" for="username">協会メンバーの読Qネーム:</label>
                            <div class="col-md-3">
                                <input type="text" value="<?php echo e(old('username') !='' ? old('username') : (isset($user) ?  $user->username : '')); ?>" class="form-control" name="username" id="username" readonly>
                                
                                <?php if($errors->has('username')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('username')); ?></span>
                                </span>
                                <?php endif; ?>
                                                        
                            </div>
                            
                        </div>
                        <div class="form-group row <?php echo e($errors->has('r_password') ? ' has-danger' : ''); ?>">
                            <label class="control-label col-md-3 text-md-right" for="firstname_roma">ログインパスワード:</label>
                            <div class="col-md-3">
                                <input type="text" value="<?php echo e(old('r_password') !='' ? old('r_password') : (isset($user) ?  $user->r_password : '')); ?>" class="form-control" name="r_password" id="r_password">
                                
                                <?php if($errors->has('r_password')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('r_password')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="firstname_roma">保有メールアドレスとパスワード:</label>
                            <label class="control-label col-md-1 text-md-right" for="lastname_roma">個別用１:</label>
                            <div class="col-md-2 <?php echo e($errors->has('email1') ? ' has-danger' : ''); ?>">
                                <input type="text" value="<?php echo e(old('email1') !='' ? old('email1') : (isset($user) ?  $user->email1 : '')); ?>" class="form-control" name="email1" id="email1">
                                
                                <?php if($errors->has('email1')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email1')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2  <?php echo e($errors->has('email1_password') ? ' has-danger' : ''); ?>">
                                <?php if($user->id == Auth::user()->id): ?>
                                    <input type="text" value="<?php echo e(old('email1_password') !='' ? old('email1_password') : (isset($user) ?  $user->email1_password : '')); ?>" class="form-control" name="email1_password" id="email1_password">
                                <?php else: ?>
                                    <input type="text" value="••••••" class="form-control" name="email1_password" id="email1_password">
                                <?php endif; ?>
                                <?php if($errors->has('email1_password')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email1_password')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo e($errors->has('email2') ? ' has-danger' : ''); ?>">
                            <label class="control-label col-md-4 text-md-right" for="">個別用2:</label>
                            <div class="col-md-2">
                                <input type="text" value="<?php echo e(old('email2') !='' ? old('email2') : (isset($user) ?  $user->email2 : '')); ?>" class="form-control" name="email2" id="email2">
                                
                                <?php if($errors->has('email2')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email2')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2 <?php echo e($errors->has('email2_password') ? ' has-danger' : ''); ?>">
                                <?php if($user->id == Auth::user()->id): ?>
                                    <input type="text" value="<?php echo e(old('email2_password') !='' ? old('email2_password') : (isset($user) ?  $user->email2_password : '')); ?>" class="form-control" name="email2_password" id="email2_password">
                                <?php else: ?>
                                    <input type="text" value="••••••" class="form-control" name="email2_password" id="email2_password">
                                <?php endif; ?>
                                <?php if($errors->has('email2_password')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email2_password')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-4 text-md-right" for="">送信専用:</label>
                            <div class="col-md-2 <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
                                <input type="text" value="<?php echo e(old('email') !='' ? old('email') : (isset($user) ?  $user->email : '')); ?>" class="form-control" name="email" id="email">
                                
                                <?php if($errors->has('email')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2 <?php echo e($errors->has('email_password') ? ' has-danger' : ''); ?>">
                                <?php if($user->id == Auth::user()->id): ?>
                                    <input type="text" value="<?php echo e(old('email_password') !='' ? old('email_password') : (isset($user) ?  $user->email_password : '')); ?>" class="form-control" name="email_password" id="email_password">
                                <?php else: ?>
                                    <input type="text" value="••••••" class="form-control" name="email_password" id="email_password">
                                <?php endif; ?>
                                <?php if($errors->has('email_password')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('email_password')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="member_name">メンバー名:</label>
                            <div class="col-md-3 <?php echo e($errors->has('member_name') ? ' has-danger' : ''); ?>">
                                <textarea id="member_name" class="form-control" name="member_name" rows="3"><?php echo e(old('member_name')!=""? old('member_name') : (isset($user) ? $user->member_name : '')); ?></textarea>
                                <?php if($errors->has('member_name')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('member_name')); ?></span>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="society_settlement_date">決算:</label>
                            <div class="col-md-3 ">
                                 <input type="<?php echo e("text"); ?>" name="society_settlement_date"  id="society_settlement_date" value="<?php echo e($user->society_settlement_date); ?>" class="form-control text-md-right base_info date-picker" readonly>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="row" style="margin-top:8px">
                <div class="col-md-6 text-md-right">
                    <?php if($user->id == Auth::user()->id): ?><button type="button" class="btn btn-success save-continue"  style="margin-bottom:8px">保　存</button><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
<script type="text/javascript"> 
    ComponentsDropdowns.init();  
    $(".save-continue").click(function(){
        $("#form-validation").submit();
    });

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: 'ja'
            });
        }
    }

    var handleInputMasks = function () {
        $.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#society_settlement_date").inputmask("y/m/d", {
            "placeholder": "yyyy/mm/dd"
        }); //multi-char placeholder
       

    }
    handleDatePickers();
    handleInputMasks();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>