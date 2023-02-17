

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
	                <a href="<?php echo e(url('/book/search')); ?>">
	                	> 本を検索 
	                </a>
	            </li>
	            <li>
	                <a href="#">
	                	> 受検 > <?php if($mode == 'before_recog'): ?> 受検の確認  <?php elseif($mode == 'after_recog'): ?> 受検開始 <?php endif; ?>
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if($mode == 'before_recog'): ?>
		<form class="form form-horizontal" action="<?php echo e(url('book/test/caution')); ?>" method="post">
		<?php echo e(csrf_field()); ?>

			<h3 class="page-title">読Q受検を始めます</h3>
			<div class="row margin-top-20">
				<div class="offset-md-3 col-md-5">
					
					<?php if(isset($book)&&Auth::check()): ?>
						<input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
					<?php endif; ?>
						<div class="form-body">
							<table class="table table-no-border table-hover">
								<tbody class="h4 ">
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">タイトル　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><?php echo e($book->title); ?>

														(<?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php if($key + 1 == count($book->categories)): ?>
																<?php echo e($category->name); ?>

															<?php else: ?>
																<?php echo e($category->name); ?>、
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>)</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">著者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><?php echo e($book->fullname_nick()); ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Q本登録者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><?php if(isset($book->Register) && $book->Register !== null && $book->register_id != 0): ?> <?php if($book->register_visi_type == 0): ?><?php echo e($book->Register->fullname()); ?><?php else: ?><?php echo e($book->Register->username); ?><?php endif; ?> <?php endif; ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">クイズ監修者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><?php if($book->author_overseer_flag == 1): ?>著者、<?php endif; ?>
											<?php if(isset($quiz_overseer) && $quiz_overseer !== null): ?><?php echo e($quiz_overseer->fullname()); ?><?php endif; ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Q本ID　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">dq<?php echo e($book->id); ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Qポイント　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><?php echo e(floor($book->point*100)/100); ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">短時間加算　　　<br>ポイント　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><br><?php echo e(floor(($book->point/10)*100)/100); ?></td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">問題数　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">
											<?php if($book->quiz_count >15): ?>
												<?php echo e($book->quiz_count); ?>問以下
												<input type="hidden" name="quiz_count" value="<?php echo e($book->quiz_count); ?>">
											<?php else: ?>
												<?php echo e($book->quiz_count); ?>問以下
												<input type="hidden" name="quiz_count" value="<?php echo e($book->quiz_count); ?>">
											<?php endif; ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>
			</div>
			<h3 class="page-title">回答方法</h3>
			<div class="row margin-top-20">
				<div class="offset-md-2 col-md-10">
					<div class="form-body h4">
					問題文の<span style='text-decoration:underline !important'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>線部が、本の内容(ないよう)と合(あ)っていれば〇（①）、違(ちが)っていれば×（②）を選(えら)んで、「次へ」をクリックしてください。
					</div>
				</div>
			</div>
			<div class="form-body text-md-center col-xs-12" style="text-align:center;">
				<button class="btn btn-primary" >確認して次へ</button>
			</div>
		</form>
		<?php elseif($mode == 'after_recog'): ?>
		<form class="form form-horizontal" action="<?php echo e(url('book/test/quiz')); ?>" method="post">
		<?php echo e(csrf_field()); ?>

		<?php if(isset($book)&&Auth::check()): ?>
			<input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
		<?php endif; ?>
			<h3 style="text-align:center;"><?php echo e($book->title); ?></h3>
			<!-- (<?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($key + 1 == count($book->categories)): ?>
											<?php echo e($category->name); ?>

										<?php else: ?>
											<?php echo e($category->name); ?>、
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>) -->
			<h4 style="text-align:center;"><?php echo e($book->fullname_nick()); ?></h4>
			<div class="clearfix"></div>
			<h4 style="text-align:center;">問題数　···　
											<?php if($book->quiz_count >15): ?>
												<?php echo e($book->quiz_count); ?>問以下
												<input type="hidden" name="quiz_count" value="<?php echo e($book->quiz_count); ?>">
											<?php else: ?>
												<?php echo e($book->quiz_count); ?>問以下
												<input type="hidden" name="quiz_count" value="<?php echo e($book->quiz_count); ?>">
											<?php endif; ?></h34>
			<div class="clearfix">&nbsp;</div>

			<h4 style="text-align:center;color:red;">回答方法</h4>
			<div class="row">
				<div class="offset-md-2 col-md-10">
					<div class="form-body h5"  style="color:red; line-height: 1.3">
					問題文の<span style='text-decoration:underline !important'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>線のひいてあるところが本の内容と合っていれば①ちがっていれば②を選んで「次へ」をクリック！。
					</div>
				</div>
			</div>
			<div class="form-body text-md-center col-xs-12" style="text-align:center;">
				<button class="btn btn-primary" >受検スタート</button>
				<?php if($mode == 'after_recog'): ?>
					<label class="help-block" style="text-align:center;">
						＊このボタンを押すとすぐにクイズ第１問が始まります。
					</label>
				<?php endif; ?>
			</div>
		</form>
		<?php endif; ?>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>