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
                        > 広告登録廃止
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">広告登録廃止</h3>
			<div class="row">
			<form method="post" id="ad-register-form" class="form-horizontal" enctype="multipart/form-data">
				<div class="form">
					<?php echo e(csrf_field()); ?>

					<div class="col-md-12">
						<h4 class="text-left">1. トップ画面</h4>
						<div class="col-md-5">
							<label class="control-label col-md-2 text-md-left"><strong>左&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;側:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="top_page_left"><?php echo e((isset($advise)? $advise->top_page_left: '')); ?></textarea>
						</div>
						<div class="col-md-5">
							<label class="control-label col-md-2 text-md-left"><strong>右&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;側:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="top_page_right"><?php echo e((isset($advise)? $advise->top_page_right: '')); ?></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="text-left">2. マイ書斎</h4>
						<div class="col-md-5">
							<label class="control-label col-md-2 text-md-left"><strong>上&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;側:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="mystudy_top"><?php echo e((isset($advise)? $advise->mystudy_top: '')); ?></textarea>
						</div>
						<div class="col-md-5">
							<label class="control-label col-md-2 text-md-left"><strong>底&nbsp;&nbsp;部&nbsp;&nbsp;側:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="mystudy_bottom"><?php echo e((isset($advise)? $advise->mystudy_bottom: '')); ?></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<h4 class="text-left">3. 本のページ</h4>
						<div class="col-md-4">
							<label class="control-label col-md-2 text-md-left"><strong>左&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="book_page_top_left"><?php echo e((isset($advise)? $advise->book_page_top_left: '')); ?></textarea>
						</div>	
						<div class="col-md-4">
							<label class="control-label col-md-2 text-md-left"><strong>右&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上:<br>468 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="book_page_top_right"><?php echo e((isset($advise)? $advise->book_page_top_right: '')); ?></textarea>
						</div>	
						<div class="col-md-4">
							<label class="control-label col-md-2 text-md-left"><strong>右&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;下:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="book_page_bottom_right"><?php echo e((isset($advise)? $advise->book_page_bottom_right: '')); ?></textarea>
						</div>	
					</div>
					<div class="col-md-12">
						<h4 class="text-left">4. 本の検索画面</h4>
						<div class="col-md-5">
							<label class="control-label col-md-2 text-md-left"><strong>右&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上:<br>234 x 60 </strong></label>
							<textarea class="col-md-10" rows="3" name="search_page_top"><?php echo e((isset($advise)? $advise->search_page_top: '')); ?></textarea>
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
	          <p>広告を登録しますか？</p>
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
		$("#ad-register-form").attr('action', "/admin/ad_save");
		$("#ad-register-form").submit();
	})
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>