<?php $__env->startSection('styles'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
   <style>
	@media (max-width: 560px){
	   table{
		   width: 1024px !important;
	   }
	   table th,td{
		   text-align: center !important;
	   }
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
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 読Q活動の履歴
	            </li>
	            <li class="hidden-xs">
	            	> 全履歴
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
		    	<div class="col-md-12">	
					<h3 class="page-title caption col-md-11">読Q活動の全履歴</h3>
					<?php if($otherview_flag): ?>			
					<div class="tools" style="float:right;">
						<a class="text-md-center font-blue-madison" href="<?php if(Auth::user()->isPupil()): ?><?php echo e(url('/mypage/rank_child_pupil')); ?><?php else: ?><?php echo e(url('/mypage/rank_by_age')); ?><?php endif; ?>">もっと見る</a>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">	
					<div style="height:400px; min-width: 100%; overflow-x: auto">					
						<table class="table table-bordered table-hover" style="width: 100%">
							<thead>
								<tr class="blue">
									<th class="col-md-1"  style="padding:0px; width: 9%">登録日</th>
									<th class="col-md-1"  style="padding:0px; width: 5%; white-space: normal">受検</th>
									<th class="col-md-1" style="padding:0px; width: 5%; white-space: normal">クイズ作成</th>
									<th class="col-md-1"  style="padding:0px; width: 5%; white-space: normal">本の登録</th>
									<th class="col-md-1"  style="padding:0px; width: 9%; white-space: normal">タイトル</th>
									<th class="col-md-1"  style="padding:0px; width: 9%">著者</th>
									<th class="col-md-2"  style="padding:0px; width: 30%">クイズ</th>
									<th class="col-md-1" style="padding:0px; width: 7%; white-space: normal">得たポイント</th>
									<th class="col-md-1"  style="padding:0px; width: 7%; white-space: normal">現在までの<br>今期ポイント</th>
									<th class="col-md-1"  style="padding:0px; width: 7%; white-space: normal">現在までの<br>今年度ポイント</th>
									<th class="col-md-1"  style="padding:0px; width: 7%; white-space: normal">現在までの<br>生涯ポイント</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								<?php $sumPoint = 0; ?>
								<?php $__currentLoopData = $myAllHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr class="info">
									<td style="vertical-align:middle; width: 9%"><?php if($history->created_date !== null): ?><?php echo e(with(date_create($history->created_date))->format('Y/m/d')); ?><?php endif; ?></td>

									<td style="vertical-align:middle; width: 5%"><?php if($history->type == 2 && $history->status == 3): ?>〇 
										<?php elseif($history->type == 2 && $history->status == 4): ?> X <?php elseif($history->type == 2 && ($history->status == 0 || $history->status == 1 || $history->status == 2 )): ?> <?php echo e(""); ?> <?php elseif($history->type == 2 && $history->status == 6 ): ?> <?php echo e(""); ?> <?php endif; ?></td>
									<td style="vertical-align:middle; width: 5%"><?php if($history->type == 1 && $history->status == 1): ?>〇
										<?php elseif($history->type == 1 && $history->status == 2): ?> X <?php elseif($history->type == 1 && ($history->status == 1 || $history->status == 0 || $history->status == 3)): ?> <?php echo e("△"); ?> <?php elseif($history->type == 1 && $history->status == 4 ): ?> <?php echo e(""); ?> <?php endif; ?></td>
									<td style="vertical-align:middle; width: 5%"><?php if($history->type == 0 && $history->status == 1): ?>〇
										<?php elseif($history->type == 0 && $history->status == 2): ?> X <?php elseif($history->type == 0 && ($history->status == 0 || $history->status == 3)): ?>  <?php echo e("△"); ?> <?php elseif($history->type == 0 && $history->status == 4 ): ?> <?php echo e(""); ?> <?php endif; ?></td>

									<td style="vertical-align:middle; width: 9%"><a <?php if($history->active >= 3): ?> href="<?php echo e(url('book/' . $history->book_id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($history->title); ?></a></td>
									<td style="vertical-align:middle; width: 9%"><a href="<?php echo e(url('/book/search_books_byauthor?writer_id=' . $history->writer_id.'&fullname='.$history->firstname_nick.' '.$history->lastname_nick)); ?>" class="font-blue-madison"><?php echo e($history->firstname_nick.' '.$history->lastname_nick); ?></a></td>
									<td style="vertical-align:middle; text-align: left; width: 30%"> <?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $history->question); $st = str_replace_first("#", "</u>", $st); 
															$st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
															for($i = 0; $i < 30; $i++) {
															 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
																$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
															} 
															echo $st  ?>
									</td>
									<td style="vertical-align:middle; width: 7%"><?php if(isset($history->cur_point) && $history->cur_point !== null): ?><?php echo e(floor(($history->cur_point + 0.0001)*100)/100); ?><?php endif; ?></td>
									
									<td style="vertical-align:middle; width: 7%">
										<?php if($i == 0): ?>
										<?php echo e(floor(($curQuarterPoint + 0.0001) * 100)/100); ?>

										<?php else: ?>
										<?php $a = $curQuarterPoint - $sumPoint; if($a > 0) echo floor(($a + 0.0001)*100)/100; else echo 0;?>
										<?php endif; ?>
									</td>
									<td style="vertical-align:middle; width: 7%">
										<?php if($i == 0): ?>
										<?php echo e(floor(($curYearPoint + 0.0001)*100)/100); ?>

										<?php else: ?>
										<?php $b = $curYearPoint - $sumPoint; if($b > 0) echo floor(($b + 0.0001)*100)/100; else echo 0;?>
										<?php endif; ?>
									</td>
									<td style="vertical-align:middle; width: 7%">
										<?php if($i == 0): ?>
										<?php echo e(floor(($allPoint + 0.0001) * 100) / 100); ?>

										<?php else: ?>
										<?php $c = $allPoint - $sumPoint; if($c > 0) echo floor(($c + 0.0001)*100)/100; else echo 0;?>
										<?php endif; ?>
									</td>
									<?php $sumPoint += $history->cur_point; $sumPoint = floor(($sumPoint + 0.0001)*100)/100; ?>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
	jQuery(document).ready(function() {
		<?php if($otherview_flag): ?>
			$('body').addClass('page-full-width');
			var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
		<?php endif; ?>
		//alert(count($myAllHistories));
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>