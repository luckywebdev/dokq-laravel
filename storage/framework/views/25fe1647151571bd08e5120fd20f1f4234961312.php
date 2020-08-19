
<?php $__env->startSection('styles'); ?>
    <style>
<!--
		td{
			text-align: center !important;
		}
-->
</style>
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
					> <a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> <a href="<?php echo e(url('quiz/create')); ?>">クイズを作る</a>
				</li>
				<li class="hidden-xs">
					> 作成クイズ確認
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">作ったクイズの確認</h3>

			<div class="row">
				<form class="offset-md-1 col-md-10 form" method="post" action="<?php echo e(url('quiz/update')); ?>">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
					<input type="hidden" name="quizmakername" <?php if(isset($quizmakername)): ?> value="<?php echo e($quizmakername); ?>" <?php endif; ?>>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="row margin-top-10">
								<div class="col-md-3">
									<h4 class="text-center margin-bottom-10 margin-top-10">
										タイトル： <strong><?php echo e($book->title); ?></strong>
									</h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-center margin-bottom-10 margin-top-10">
										著者:  <?php echo e($book->fullname_nick()); ?>

									</h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-center margin-bottom-10 margin-top-10">
										読Q本ID: dq<?php echo e($book->id); ?>

									</h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-center margin-bottom-10 margin-top-10">
										読Q本ポイント: <?php echo e(floor($book->point*100)/100); ?>

									</h4>
								</div>
							</div>
						</div>

						<div class="portlet-body margin-top-10">
							<div class="form-group row">
								<div class="col-md-12 table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<th class="col-md-1">No</th>
											<th class="col-md-4">クイズ本文</th>
											<th class="col-md-1">正解</th>
											<th class="col-md-2">出典ページ</th>
											<th class="col-md-2">
												作成者表示名
												<br>
												<small>(15歳まで非表示)</small>
											</th>
											<th class="col-md-2">
												編集・削除
											</th>
										</thead>
										<?php 
											$quiz_ids = $quizes->map(function($quiz){
												return $quiz->id;
											})->toArray();
											$quiz_ids = json_encode($quiz_ids);
										?>
										<tbody class="text-md-center">
											<input type="hidden" name="quiz_ids" value="<?php echo e($quiz_ids); ?>">
											<?php $__currentLoopData = $quizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<tr class="text-md-left">
													<td style="vertical-align: middle;"><?php echo e($key + 1); ?></td>
													<td class="text-md-left" style="vertical-align: middle;">
													<?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
														$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
														for($i = 0; $i < 30; $i++) {
														 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
															$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
														} 
															echo $st  ?></td>
													<td style="vertical-align: middle;">
														<?php if($quiz->answer == 1): ?> ① <?php elseif($quiz->answer == 0): ?> ② <?php endif; ?>
													</td>
													<td style="vertical-align: middle;">
														<?php echo $quiz->AppearPosition(); ?>
													</td>
													<td style="vertical-align: middle;">
														<?php echo e($quiz->RegisterShow()); ?>

													</td>
													<td style="vertical-align: middle;">
														<div class="radio-list text-md-center">														
															<a class="btn btn-warning btn-xs edit-btn" data-id="<?php echo e($quiz->id); ?>" href="<?php echo e(url('/quiz/create?quiz=').$quiz->id); ?>">編集</a>
															<a class="btn btn-danger btn-xs edit-btn" data-id="<?php echo e($quiz->id); ?>" href="<?php echo e(url('/quiz/remove?id=').$quiz->id); ?>">削除</a>															
														</div>
													</td>
												</tr>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
									</table>
								</div>
							</div>
							
						</div>
					</div>
					<div class="offset-md-3 col-md-6 text-md-center" style="margin-bottom: 30px;">
						<?php if(isset($status) && $status == 'completed'): ?>
						<h5 class="text-md-center">送信しました。 </h5>
						<?php else: ?>
						 <a <?php if(isset($quizmakername)): ?> href="<?php echo e(url('/quiz/create?book_id='.$book->id.'&&quizmakername='.$quizmakername)); ?>" <?php else: ?> href="<?php echo e(url('/quiz/create?book_id='.$book->id)); ?>" <?php endif; ?> class="btn btn-primary float-left">もっと作る </a>
						 <button class="btn btn-primary" type="submit">完了して送信 </button>
						 <a href="<?php echo e(url('/')); ?>" class="btn btn-info float-right">トップへ戻る</a>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<p>
						ありがとうございました。
					</p>
					<p>
						作成いただいたクイズを、管理者へ送信しました。
					</p>
					<p>
						認定審査にしばらくお時間をいただきます。
					</p>
					<p>
						結果が出ましたら、マイ書斎内連絡帳でお知らせします。
					</p>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<a class="btn btn-info" href="<?php echo e(url('/')); ?>"> トップへ戻る </a>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
    	$('body').addClass('page-full-width');
    	$(".editRadio").click(function(){
    		location.herf="/quiz/edit?quiz=" + $(this).data("id");
    	});
    	<?php if (isset($status) && $status == 'completed')
    	echo '$("#confirmModal").modal({
    		backdrop: "static",
			keyboard: false
    	})
    	$(".draggable").draggable({
		      handle: ".modal-header"
		});';
		?>
    	
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>