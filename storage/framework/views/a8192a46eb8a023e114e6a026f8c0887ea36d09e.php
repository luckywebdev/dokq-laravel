

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
                        > 自己評価シート公開ボタン
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">自己評価シート公開ボタン</h3>
			<div class="row">
			<form method="post" id="self-evaluation-form" class="form-horizontal" enctype="multipart/form-data">
				<div class="form">
					<?php echo e(csrf_field()); ?>

					<?php if(count($errors) > 0): ?>
						<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php endif; ?>
					<div class="col-md-12">
						<h4 class="text-left">自己評価シート公開ボタンのアップロード</h4>
						<div class="col-md-6">
							<!-- <label class="control-label col-md-12 text-md-left"><strong>自己評価シート公開ボタンのアップロード: </strong>
								<input type="checkbox" class="form-control" id="self_evaluation_publish_upload" <?php if(!$self_evaluation_buttons && $self_evaluation_buttons->self_evaluation_sheet_url == ''): ?> <?php echo e(checked); ?> <?php endif; ?>>
							</label> -->
							<label class="control-label col-md-7 text-md-right">自己評価シート公開ボタンのアップロード:</label>
							<div class="col-md-5">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
										<span class="fileinput-new">ファイルを選択</span>
										<span class="fileinput-exists">変更</span>
										<input type="file" name="evaluation_button" required>
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
									<?php if($errors->has('filemaxsize')): ?>
									<span class="form-control-feedback">
											<span><?php echo e($errors->first('filemaxsize')); ?></span>
									</span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="control-label col-md-7 text-md-right">自己評価シートPDFのアップロード:</label>
							<div class="col-md-5">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
										<span class="fileinput-new">ファイルを選択</span>
										<span class="fileinput-exists">変更</span>
										<input type="file" name="evaluation_sheet" required>
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
									<?php if($errors->has('filemaxsize1')): ?>
									<span class="form-control-feedback">
											<span><?php echo e($errors->first('filemaxsize1')); ?></span>
									</span>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="#" class="btn btn-primary btn-save" role="button">セーブ</a>
					<a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="saveModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>自己評価シート公開ボタンを登録しますか？</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-primary modal-save" >確  認</button>
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >キャンセル</button>
	        </div>
	      </div>
	    </div>
	</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
$(function(){
	$(".btn-save").click(function(){
		$("#saveModal").modal('show');
	});
	$(".modal-save").click(function(){
		$("#self-evaluation-form").attr('action', "/admin/self_evaluation_save");
		$("#self-evaluation-form").submit();
	})
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>