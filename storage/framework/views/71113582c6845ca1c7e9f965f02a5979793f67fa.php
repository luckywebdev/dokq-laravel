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
	                	> 監修者になる
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
			<h3 class="page-title">監修者になる</h3>

			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8">
					<p>監修者になるには、自己推薦文を入力し、教員免許状、学士などの資格証の画像を送っていただく必要があります。</p>
					<p>読Qの監修者採用規定外の場合でも、自己推薦をしていただき、読Q側で承認すれば、監修者になれます。</p>
					<p>送信いただきましたら、承認の可否を2日以内に協会からメールでご連絡いたします。</p>
					<p>承認後は、読Qネーム末尾に「k」をつけてログインして下さい。</p>
				</div>
			</div>
			
			<form enctype="multipart/form-data" class="form form-horizontal" action="<?php echo e(url('/mypage/update_userinfo')); ?>" method="post" id="form1">
				<?php echo e(csrf_field()); ?>

				<input type="hidden" name="beforefile" id="beforefile" value="<?php echo e(isset($beforefile) ? $beforefile : ''); ?>">
				<input type="hidden" name="beforefilename" id="beforefilename" value="<?php echo e(isset($beforefilename) ? $beforefilename : ''); ?>">
	
				<div class="form-group row">
					<div class="offset-md-2 col-md-8">
						<textarea  required id="recommend_content" class="form-control" name="recommend_content" maxlength="200" rows="5" placeholder="自己推薦文入力　200字以内"><?php echo e(old('recommend_content')!=""? old('recommend_content') : (isset($user->recommend_content) ? $user->recommend_content : '')); ?></textarea>
					</div>
				</div>

				<div class="form-group row">
					<div class="offset-md-2 col-md-8">
						<label class="control-label col-md-2 text-md-right">資格証</label>
				    	<div class="col-md-4">
					    	<div class="fileinput <?php if((isset($user->authfile) && $user->authfile != '')|| old('authfile')): ?> fileinput-exists <?php else: ?> fileinput-new <?php endif; ?>" data-provides="fileinput" style="margin-bottom: 0px;">
								<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
								<span class="fileinput-new">ファイルを選択</span>
								<?php if((!isset($success) || isset($success) && $success != 1) && (isset($fail) && $fail == 1)): ?>
								<span class="fileinput-exists">ファイルを選択</span>
								<?php else: ?>
								<span class="fileinput-exists">変　更</span>
								<?php endif; ?>
								<input type="file" name="authfile" id="authfile" value="<?php echo e(isset($user->authfile) && isset($user->recommend_flag) && $user->recommend_flag == 1 ?  $user->authfile : ''); ?>" class="form-control" >
								</span>
								<span class="fileinput-filename">
								</span>
								&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">キャンセル
								</a>
								<?php if($errors->has('authfile')): ?>
                                <span class="form-control-feedback">
                                    <span><?php echo e($errors->first('authfile')); ?></span>
                                </span>
                                <?php endif; ?>
							</div>
						</div>
						<button type="button" class="btn btn-primary pull-right" id="submit_btn">送　信</button>
					</div>
				</div>
			</form>
			
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
 <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
    <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.fileinput-filename').text($("#beforefile").val());

			<?php if(isset($completed) && $completed == true): ?>
				bootboxNotification('送信しました');
			<?php endif; ?>
			$("#submit_btn").click(function(){
				$("#form1").submit();				
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>