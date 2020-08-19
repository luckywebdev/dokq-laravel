

<?php $__env->startSection('styles'); ?>
	<style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;
		}
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
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">
	                    本の検索
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="#">
	                	 クイズを作る
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <?php echo e($title); ?>

	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title"><?php echo e($title); ?></h3>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-2">監修本のタイトルを検索</label>
						
						<div class="col-md-4">
							<select class="form-control select2me"  placeholder="選択..." style="height:33px !important" id="select_book">
								<option></option>
								<option value="<?php echo e($book->id); ?>"  selected><?php echo e($book->title); ?></option>
							</select>
						</div>						
					</div>
				</div>
			</div>
			<?php if($book): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-3">タイトル：<span style="color:black;"><?php echo e($book->title); ?></span></div>
								<div class="col-md-3">著者：<span style="color:black;"><?php echo e($book->fullname_nick()); ?></span></div>
								<div class="col-md-3">読Q本ID：　<span style="color:black;">dq<?php echo e($book->id); ?></span>  </div>
								<div class="col-md-3">　出題数：<span style="color:black;">全<?php echo e($book->quiz_count); ?> 問</span></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3">読Q本ポイント：<span style="color:black;"><?php echo e(floor($book->point*100)/100); ?></span></div>
								<div class="col-md-3">クイズ認定ポイント：<span style="color:black;"><?php echo e(floor($book->point * 0.1*100)/100); ?> / 1問</span></div>
								<div class="col-md-3">認定に必要なｸｲｽﾞの最低数：<span style="color:black;"><?php echo e($book->quiz_count * 3); ?> 問</span>  </div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr class="success">
										<th>受付日</th>
										<th width="40%">クイズ本文</th>
										<th>正解</th>
										<th>出典ページ</th>
										<th>名前</th>
										<th>クイズID</th>
										<!-- <th>編集/削除</th>-->
									</tr>
								</thead>
								<tbody class="text-md-center">
									<?php $__currentLoopData = $quizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e(with($quiz->created_at)->format("Y/m/d")); ?> <?php if($quiz->active < 2): ?> <br><span style="color:red">新着</span> <?php endif; ?></td>
										<td><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
														$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
														for($i = 0; $i < 30; $i++) {
														 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
															$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
														} 
														echo $st  ?></td>
										<td><?php if($quiz->answer == 1): ?> ① <?php elseif($quiz->answer == 0): ?> ② <?php endif; ?></td>
										<td><?php echo $quiz->AppearPosition() ?></td>
										<td><?php echo e($quiz->RegisterShow()); ?>

										</td>
										<td>dq<?php echo e($book->id); ?>-<?php echo e($key + 1); ?></td>
										<!-- <td>
											<div><a class="quiz_edit font-blue" href="#" qid="<?php echo e($quiz->id); ?>">編集</a></div>
											<div><a class="quiz_delete font-red" href="#" qid="<?php echo e($quiz->id); ?>">削除</a></div>
										</td>-->
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</div>
			
			<?php endif; ?>
			
			<div class="row">
				<div class="col-md-6 text-md-center">
					
				</div>
				<div class="col-md-6 text-md-center">
					<button class="btn btn-info" id="btn_submit" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="qid" name="qid" value="">
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
            <button type="button" data-dismiss="modal" class="btn btn-warning confirm modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			$("#select_book").change(function(){
				location.href="<?php echo e(url('/mypage/accept_quiz_list/')); ?>" + $(this).val();
			});
			$(".quiz_edit").click(function() {
			    location.href = "/quiz/create?quiz=" + $(this).attr("qid") + "&act=accept";
			})
			$(".quiz_delete").click(function () {
                $("#qid").val($(this).attr("qid"));
                $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_DELETE']); ?>");
                $("#alertModal").modal();
			});
			$(".confirm").click(function() {
			    location.href = "/quiz/remove/" + $("#qid").val();
			})
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>