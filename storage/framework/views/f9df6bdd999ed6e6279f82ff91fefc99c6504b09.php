
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
	            <li>
	                > <a href="<?php echo e(url('/book/search')); ?>">本の検索</a>
	            </li>
	            <li>
	                > <a <?php if($book->active >= 3): ?> href="<?php echo url('book').'/'.$book->id.'/detail'; ?>" <?php endif; ?>>本のページ</a>
	            </li>
	            <li class="hidden-xs">
	                > 合格者を検索
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">この本の読Q合格者を検索</h3>
			<br><br>
										
			<div class="row margin-top-20">
				<div class="col-md-12">
					<form class="form-horizontal form" action="<?php echo url('book').'/'.$book->id.'/res_passer'; ?>" method="post">
						<?php echo e(csrf_field()); ?>

						  	
						<div class="form-group row">
							<h4 class="control-label col-md-12 text-md-center">タイトル: <?php echo e($book->title); ?></h4>
						</div>

						<div class="form-group row">
							<label class="offset-md-3 control-label col-md-1 text-md-right">名前</label>
							<div class="col-md-2">
								<input type="text" name="first_name" id="first_name" class="form-control" placeholder="姓">
							</div>
							<div class="col-md-2">
								<input type="text" name="last_name" id="last_name" class="form-control" placeholder="名">
							</div>
							<label class="label-after-input control-label col-md-4 text-md-left">（全角）</label>
						</div>

						<div class="form-group row">
							<label class="offset-md-3 control-label col-md-1 text-md-right">読Qネーム</label>
							<div class="col-md-4">
								<input type="text" name="username" id="username" class="form-control">
							</div>
							<label class="label-after-input control-label col-md-4 text-md-left">（半角）</label>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-12 text-md-center text-danger" style="font-size:16px">
								この本の合格非公開者や、中学生以下非表示の場合は検出されません。<br>
								（閲覧権限のある担任教師は、担当児童生徒の合格を検索することができます。）
							</label>
						</div>

						<div class="row">
							<div class="offset-md-5 col-md-1">
								<button type="button" class="btn btn-primary search_btn">検　索</button>
							</div>
							<div class="col-md-2">
								<a class="btn btn-danger" <?php if($book->active >= 3): ?> href="<?php echo url('book').'/'.$book->id.'/detail'; ?>"<?php endif; ?> style="margin-bottom:8px;">キャンセル</a>
							</div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)" style="margin-bottom:8px;">戻　る</button>
                            </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	            <h4 class="modal-title"><strong>読Q</strong></h4>
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
		$(document).ready(function(){
			$('body').addClass('page-full-width');

			$(".search_btn").click(function() {
				var name = $('#name').val();
				var username = $('#username').val();

				if(name == '' && username == ''){
					$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['FULLNAME_USERNAME_ALERT']); ?>");
	            	$("#alertModal").modal();
				}else
					$(".form-horizontal").submit();
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>