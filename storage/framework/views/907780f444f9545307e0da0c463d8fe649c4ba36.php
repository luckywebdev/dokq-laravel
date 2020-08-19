<?php $__env->startSection('styles'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
   
   <style type="text/css">
   		.chart_kind{
   			float: left;
   		}
   		.chart_kind ul{
   			margin-left: -7%;
   		}
   		.chart_kind ul li{
   			float: left;
   			padding: 0 35px;
   		}
   		.chart_kind ul li.clast{
   			margin-left: 0%;
   		}
   		.chart-holder {
		  width: 120%;
		  height: 325px;
		}
   </style>
<?php $__env->stopSection(); ?>
<?php foreach ($myrankPoints5 as $i => $rank ):
		if ($rank->flag=='1'){		
			$current_sum=$rank->sum;
			break;
		}
	endforeach 
?>
<?php $__env->startSection('breadcrumb'); ?>
	
	<div id = "non-printable" class="breadcum">
	    <div class="container" id = "non-printable">
	        <ol class="breadcrumb" id = "non-printable">
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
	            	<a href="#">
	                	 > 読Q活動の履歴
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 最近の読Qレポート
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content" id = "idprint">
			<div class="row">
				<div class="col-md-12">
					<h3 class="page-title col-md-11">
						<?php echo e($current_season['year']); ?>年度<?php echo e($current_season['season']); ?>末　読Qレポート<br>
						<small><?php echo e($current_season['from'] . '～' . $current_season['to']); ?></small>
					</h3>
					<form class="form-horizontal" method="post" role="form" action="/mypage/recent_print">
					 <?php echo e(csrf_field()); ?>

					<button id = "non-printable" type="button" class="btn btn-success print">印　刷</button>
					</form>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-6 column">
					<div class="news-blocks yellow1">
						<h4 class="font-blue">
							今期まとめ　<?php echo e($current_season['to']); ?>現在
						</h4>
						
						<table class="table table-no-border">
							<tr>
								<td width="50%">現時点の読Q資格</td>
								<td width="50%"><?php echo e($my_rank); ?>級</td>
							</tr>
							<tr name = "student_show" id = "student_show" style = "display:none">
								<td>今期目標達成率</td>
								<td><?php if(isset($current_user)&& $tagrgetpoint !=0): ?><?php echo e(floor($current_user->sumpoint*100/$tagrgetpoint)); ?> <?php else: ?> 0 <?php endif; ?>％</td>
							</tr>
							<tr>
								<td>今期得たポイント</td>
								<td><?php if(isset($current_user)): ?><?php echo e(floor($current_user->sumpoint*100)/100); ?> <?php else: ?> 0 <?php endif; ?>ポイント</td>
							</tr>
							<tr>
								<td>合格ポイント</td>
								<td><?php if(isset($passed_point)): ?><?php echo e(floor($passed_point->sumpoint*100)/100); ?> <?php else: ?> 0 <?php endif; ?>ポイント</td>
							</tr>
							<tr>
								<td>書籍登録ポイント</td>
								<td><?php if(isset($book_point)): ?><?php echo e(floor($book_point->sumpoint*100)/100); ?> <?php else: ?> 0 <?php endif; ?>ポイント</td>
							</tr>
							<tr>
								<td>クイズ作成ポイント</td>
								<td><?php if(isset($quiz_point)): ?><?php echo e(floor($quiz_point->sumpoint*100)/100); ?> <?php else: ?> 0 <?php endif; ?>ポイント</td>
							</tr>
							<tr>
								<td>今期までの生涯ポイント</td>
								<td><?php if(isset($total_point)): ?><?php echo e(floor($total_point*100)/100); ?> <?php else: ?> 0 <?php endif; ?>ポイント</td>
							</tr>
							<tr>
								<td>昇級まであと</td>
								<td><?php echo e(floor($my_addpoint*100)/100); ?>ポイント</td>
							</tr>
						</table>
					</div>

					<div class="portlet box blue">
						<?php if($type == 0): ?>
						<div class="portlet-title">
							<div class="caption">
								現在までの各期　目標達成率　（同学年全国平均との比較）
							</div>
						</div>
						<div class="portlet-body  col-md-12">
							<canvas id="bar" width="617" height="300" style="width: 617px; height: 300px;"></canvas>
							<div class="legend">
								<div style="position: absolute; width: 70px; height: 40px; top: 14px; right: 13px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
								<table style="position:absolute;top:14px;right:13px;font-size:smaller;color:#545454">
								<tbody>
								<tr>
								<td class="legendColorBox">
								<div style="border:1px solid #ccc;padding:1px">
								<div style="width:4px;height:0;border:5px solid #d0cece;overflow:hidden">
								</div>
								</div>
								</td>
								<td class="legendLabel">全国平均</td>
								</tr>
								<tr>
								<td class="legendColorBox">
								<div style="border:1px solid #ccc;padding:1px">
								<div style="width:4px;height:0;border:5px solid #f8cbad;overflow:hidden">
									
								</div>
								</div>
								</td>
								<td class="legendLabel">自分</td>
								</tr>
								
								</tbody></table>
							</div>
						</div>
						<?php else: ?>
							<?php if($user->active != 2): ?>
							<div class="portlet-title">
								<div class="caption">
									3カ月間で獲得するポイント推移<span style="font-size:12px">（同年代全国平均との比較）</span>
								</div>
							</div>
							<div class="portlet-body  col-md-12" style="height: 350px;">
								<div id="target-chart" class="dqtarget-chart chart-holder" style="width: 480px; height: 320px;"></div>
							</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>

					<!--<h4 class="font-blue">今期の読書量順位</h4>

					<table class="table table-bordered table-hover">
						<thead>
							<tr class="yellow">
								<th class="col-md-2"></th>
								<th class="col-md-2">自分の<br>ポイント</th>
								<th class="col-md-2">市区町村内順位<br>（位/人）</th>
								<th class="col-md-2">都道府県内順位<br>（位/人）</th>
								<th class="col-md-2">全国順位<br>（位/人）</th>
								<th class="col-md-2" style="padding-left:0px;padding-right:0px;">グラフで見る</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							<tr class="warning">
								<td class="align-middle" style="padding-left:0px;padding-right:0px;"><?php echo e($current_season['season']); ?><?php echo e($current_season['from_num'] . '～' . $current_season['to_num']); ?>(今　四半期)</td>
								<td class="align-middle"><?php $__currentLoopData = $mybookPoints1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$mybook_Points1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($mybookPoints1[$i]->sum != 0): ?>
											<?php echo e(floor($mybookPoints1[$i]->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($mybookPoints2); $i++): ?>
										<?php if($mybookPoints2[$i]->sum == $mybook_Points1->sum): ?>
											<?php echo e($i + 1); ?>

											
										<?php endif; ?>
										<?php $total_people+=$mybookPoints2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($mybookPoints3); $i++): ?>
										<?php if($mybookPoints3[$i]->sum == $mybook_Points1->sum): ?>
											<?php echo e($i + 1); ?>

											
										<?php endif; ?>
										<?php $total_people+=$mybookPoints3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($mybookPoints4); $i++): ?>
										<?php if($mybookPoints4[$i]->sum == $mybook_Points1->sum): ?>
											<?php echo e($i + 1); ?>

											
										<?php endif; ?>
										<?php $total_people+=$mybookPoints4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle" style="padding-left:0px;padding-right:0px;"><a href="<?php echo e(url("/mypage/rank_graph")); ?>" class="font-blue-madison">グラフで見る</a></td>
							</tr>
						</tbody>
					</table>-->
					<div class="clearfix"></div>
					<h4 class="font-blue">読書推進活動ランキング<span class="font-blue" style="font-size:12px">（同年代内順位）</span></h4>

					<table class="table table-bordered table-hover" style="margin-bottom:0px">
						<thead>
							<tr class="" style="width:100%; background: #F78E1F; color: #FFF; font-weight: 100">
								<th style="width:28%">本の登録とクイズ作成</th>
								<th style="width:18%">自分の読書<br>推進ポイント</th>
								<th style="width:18%">市区町村内順位<br>（位/人）</th>
								<th style="width:18%">都道府県内順位<br>（位/人）</th>
								<th style="width:18%">全国順位<br>（位/人）</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							<tr class="warning">
								<td class="align-middle"><?php echo e($current_season['season']); ?><?php echo e($current_season['from_num'] . '～' . $current_season['to_num']); ?><br>(今　四半期)</td>
								<td class="align-middle"><?php $__currentLoopData = $myquizPoints1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$myquiz_Points1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($myquizPoints1[$i]->sum != 0): ?>
											<?php echo e(floor($myquiz_Points1->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints2); $i++): ?>
										<?php if($myquizPoints2[$i]->sum == $myquiz_Points1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints3); $i++): ?>
										<?php if($myquizPoints3[$i]->sum == $myquiz_Points1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints4); $i++): ?>
										<?php if($myquizPoints4[$i]->sum == $myquiz_Points1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
							</tr>
							<tr>
								<td class="align-middle"><?php echo e($array_season_obj[1]['season']); ?><?php echo e($array_season_obj[1]['from_num'] . '～' . $array_season_obj[1]['to_num']); ?><br>(前　四半期)</td>
								<td class="align-middle"><?php $__currentLoopData = $myquizPoints_before1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$myquiz_Points_before1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($myquizPoints_before1[$i]->sum != 0): ?>
											<?php echo e(floor($myquiz_Points_before1->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_before2); $i++): ?>
										<?php if($myquizPoints_before2[$i]->sum == $myquiz_Points_before1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_before2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_before3); $i++): ?>
										<?php if($myquizPoints_before3[$i]->sum == $myquiz_Points_before1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_before3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_before4); $i++): ?>
										<?php if($myquizPoints_before4[$i]->sum == $myquiz_Points_before1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_before4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
							</tr>
							<tr class="warning">
								<td class="align-middle"><?php echo e($current_season['year']); ?>年度<br>（今年度通算）</td>
								<td class="align-middle"><?php $__currentLoopData = $myquizPoints_this1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$myquiz_Points_this1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($myquizPoints_this1[$i]->sum != 0): ?>
											<?php echo e(floor($myquiz_Points_this1->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_this2); $i++): ?>
										<?php if($myquizPoints_this2[$i]->sum == $myquiz_Points_this1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_this2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_this3); $i++): ?>
										<?php if($myquizPoints_this3[$i]->sum == $myquiz_Points_this1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_this3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_this4); $i++): ?>
										<?php if($myquizPoints_this4[$i]->sum == $myquiz_Points_this1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_this4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
							</tr>
							<tr>
								<td class="align-middle"><?php echo e($current_season['year']-1); ?>年度<br>（前年度）</td>
								<td class="align-middle"><?php $__currentLoopData = $myquizPoints_last1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$myquiz_Points_last1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($myquizPoints_last1[$i]->sum != 0): ?>
											<?php echo e(floor($myquiz_Points_last1->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_last2); $i++): ?>
										<?php if($myquizPoints_last2[$i]->sum == $myquiz_Points_last1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_last2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_last3); $i++): ?>
										<?php if($myquizPoints_last3[$i]->sum == $myquiz_Points_last1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_last3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_last4); $i++): ?>
										<?php if($myquizPoints_last4[$i]->sum == $myquiz_Points_last1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_last4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
							</tr>
							<tr class="warning">
								<td class="align-middle">生涯<br>（現在まで累計）</td>
								<td class="align-middle"><?php $__currentLoopData = $myquizPoints_all1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$myquiz_Points_all1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($myquizPoints_all1[$i]->sum != 0): ?>
											<?php echo e(floor($myquiz_Points_all1->sum*100)/100); ?>

										<?php else: ?>
											0
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_all2); $i++): ?>
										<?php if($myquizPoints_all2[$i]->sum == $myquiz_Points_all1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_all2[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_all3); $i++): ?>
										<?php if($myquizPoints_all3[$i]->sum == $myquiz_Points_all1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_all3[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									
									 / <?php echo e($total_people); ?></td>
								<td class="align-middle"><?php for($total_people=0,$i = 0; $i < count($myquizPoints_all4); $i++): ?>
										<?php if($myquizPoints_all4[$i]->sum == $myquiz_Points_all1->sum): ?>
											<?php echo e($i + 1); ?>

										<?php endif; ?>
										<?php $total_people+=$myquizPoints_all4[$i]->pupil_numbers; ?>
									<?php endfor; ?>
									 / <?php echo e($total_people); ?></td>
							</tr>
						</tbody>
					</table>
					<a href="<?php echo e(url('/mypage/rank_bq')); ?>" class="news-block-btn font-blue-madison"  style="float:right;margin-bottom:20px">もっと見る</a>
					<div class="clearfix"></div>

				</div>

				<div class="col-md-6 column">
					<div class="news-blocks white">
						<div class="row">
							<div class="col-md-12">
								<h4 class="font-blue">今期(<?php echo e($current_season['from']); ?>～<?php echo e($current_season['to']); ?>)読んだ本棚</h4>
							</div>
							
							<div class="col-md-12">
								<table class="table table-bordered table-hover">
									<tbody class="text-md-center">
										<tr style="height: 300px;width:100%"> 
											
											<?php for($i = 0; $i < 8 - count($myBooks); $i++): ?>
											<td style="width:12%"></td>
											<?php endfor; ?>
											<?php $__currentLoopData = $myBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											
											<?php if($book->point >= 0 && $book->point <= 2) $color = '#ffb5fc'; //help.about_target.blade.php
												  elseif($book->point > 2 && $book->point <= 5) $color = '#facaca';//ff0000 
												  elseif($book->point > 5 && $book->point <= 8) $color = '#f9d195'; //FF9900
												  elseif($book->point > 8 && $book->point <= 11) $color = '#f6f99a'; //f4fd00
												  elseif($book->point > 11 && $book->point <= 15) $color = '#e1f98f'; //d6f432
												  elseif($book->point > 15 && $book->point <= 19) $color = '#92fab2'; //26a69a
												  elseif($book->point > 19 && $book->point <= 25) $color = '#a7d4fb'; //5C9BD1
												  elseif($book->point > 25) $color = '#f0f5fa';	
											?>
											<td class="text-md-center" style="width:12%;background-color:<?php echo e($color); ?>;padding-left:0px;padding-right:0px;">
												<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:200px;">
													<h5 class="font_gogic text-md-left" style="align-self:center;line-height:1.5;font-family:HGP明朝B;">
														<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" <?php endif; ?>>
														<?php echo e($book->title); ?>

														</a>
													</h5>
												</div>
												<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:100px;">
													<h5 class="font_gogic text-md-left" style="align-self:center;line-height:1.5;font-family:HGP明朝B;">
														<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)); ?>">
														<?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?>

														</a>
													</h5>
												</div>
											</td>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="news-blocks lime">
								<h4 class="font-blue" style="font-size:17px">
									今期、登録して認定された本
								</h4>
								
								<table class="table table-no-border">
									<?php $__currentLoopData = $myAllowedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td width="60%"><?php echo e($book->title); ?></td>
										<td width="40%"><?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
							</div>
						</div>
						<div class="col-md-6">
							<div class="news-blocks lime">
								<h4 class="font-blue" style="font-size:17px">
									今期、クイズを作成した本
								</h4>
								
								<table class="table table-no-border">
									<?php $__currentLoopData = $myAllowedQuizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td width="60%"><?php echo e($book->title); ?></td>
										<td width="40%"><?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
							</div>
						</div>
					</div>
					<?php if($user->active != 2): ?>
					<h4 class="font-blue">マイ読書量順位</h4>
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								現在までの、獲得ポイント順位<span style="font-size:12px">（同年代と競うグラフ）</span>
							</div>
						</div>
						<div class="portlet-title" style="min-height:18px">
							<div class="row">
								<table class="col-md-12">
									<tr class="text-md-center">
										<td width="10%"></td>
										<td width="30%" style="text-align: center!important;">四半期（3カ月間）</td>
										<td width="30%" style="text-align: center!important;">年度（1年間）</td>
										<td width="30%" style="text-align: center!important;">生涯</td>
									</tr>
								</table> 
							</div>
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">クラス</span></div>
							<div id="threemonth-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart1" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">学年</span></div>
							<div id="threemonth-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart2" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<?php endif; ?>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">市区<br>町村内</span></div>
							<div id="threemonth-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart3" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">都道<br>府県内</span></div>
							<div id="threemonth-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart4" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 360px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">国内</span></div>
							<div id="threemonth-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<a class="text-md-center font-blue-madison" href="<?php if(Auth::user()->isPupil()): ?><?php echo e(url('/mypage/rank_child_pupil')); ?><?php else: ?><?php echo e(url('/mypage/rank_by_age')); ?><?php endif; ?>">もっと見る</a>
						</div>
						<input type="hidden" id="currentSeason" name="currentSeason" value="<?php echo e($current_season['term']); ?>">
						<input type="hidden" id="arraySeason" name="arraySeason" value="<?php echo e($current_season['term']); ?>">
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/charts/Chart.js')); ?>"></script>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.resize.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.pie.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.stack.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.crosshair.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.categories.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('js/Theme.js')); ?>"></script>
	<script src="<?php echo e(asset('js/Charts.js')); ?>"></script>
	<script src="<?php echo e(asset('js/flot/jquery.flot.js')); ?>"></script>
	<script src="<?php echo e(asset('js/flot/jquery.flot.orderBars.js')); ?>"></script>
	<script src="<?php echo e(asset('js/charts-flotcharts.js')); ?>"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<link rel="stylesheet" href="<?php echo e(asset('css/jqwidgets/styles/jqx.base.css')); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxcore.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdraw.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxchart.core.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdata.js')); ?>"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script type="text/javascript">
		<?php if($type == 0): ?>
			<?php if(isset($grade) && $grade != 0): ?>
				$("#student_show").css('display','');
			<?php else: ?>
				$("#student_show").css('display','none');
			<?php endif; ?>
		<?php else: ?>
			$("#student_show").css('display','none');
		<?php endif; ?>

		var current_year = new Date().getYear() + 1900;
		var point_now = 0;
		var point = [];
		var avg_now = 0;
		var avg = [];
		var current_season = $("#currentSeason").val();
		//alert(current_season);
		var array_season = [<?php echo e($array_season[0]); ?>,<?php echo e($array_season[1]); ?>,<?php echo e($array_season[2]); ?>,<?php echo e($array_season[3]); ?>];
	/*
		var quarters_point = [
			<?php for($i = 0; $i < 4; $i++): ?>
				<?php if(isset($quarters_point[$i])): ?>
					<?php if($i == 3): ?>
						<?php echo e($quarters_point[$i]->sumpoint); ?>

					<?php else: ?>
						<?php echo e($quarters_point[$i]->sumpoint); ?>,
					<?php endif; ?>
				<?php else: ?>
					<?php if($i == 3): ?>
						<?php echo e(0); ?>

					<?php else: ?>
						<?php echo e(0); ?>,
					<?php endif; ?>
				<?php endif; ?>
			<?php endfor; ?>
		];
		//alert(quarters_point);
		var quarters_avg = [
			<?php for($i = 0; $i < 4; $i++): ?>
				<?php if(isset($quarters_avg[$i])): ?>
					<?php if($i == 3): ?>
						<?php echo e($quarters_avg[$i]); ?>

					<?php else: ?>
						<?php echo e($quarters_avg[$i]); ?>,			
					<?php endif; ?>
				<?php else: ?>
					<?php if($i == 3): ?>
						<?php echo e(0); ?>

					<?php else: ?>
						<?php echo e(0); ?>,
					<?php endif; ?>
				<?php endif; ?>
			<?php endfor; ?>
		];
		//alert(quarters_avg);
		for($i = 0; $i <= current_season; $i ++){
			if(current_season == array_season[$i]){
				point_now = quarters_point[$i];
				avg_now = quarters_avg[$i];
			}else{
				point[$i] = quarters_point[$i];
				avg[$i] = quarters_avg[$i];
			}
		}
		*/
		<?php if($type == 0): ?>
			var barChartData = {
				labels : [<?php echo e($cur_season[0]['year']); ?> + "年度 <?php echo e($cur_season[0]['season']); ?>"  ,<?php echo e($cur_season[1]['year']); ?> + "年度 <?php echo e($cur_season[1]['season']); ?>",<?php echo e($cur_season[2]['year']); ?> + "年度 <?php echo e($cur_season[2]['season']); ?>",<?php echo e($cur_season[3]['year']); ?> + "年度 <?php echo e($cur_season[3]['season']); ?>"],
				datasets : [
					{
						fillColor : "#d0cece",
						strokeColor : "#d0cece",
						data : [<?php echo e($myavgPoints[0][0]); ?>,<?php echo e($myavgPoints[1][0]); ?>,<?php echo e($myavgPoints[2][0]); ?>,<?php echo e($myavgPoints[3][0]); ?>]
					},
					{
						fillColor : "#f8cbad",
						strokeColor : "#f8cbad",
						data : [<?php echo e($myavgPoints[0][1]); ?>,<?php echo e($myavgPoints[1][1]); ?>,<?php echo e($myavgPoints[2][1]); ?>,<?php echo e($myavgPoints[3][1]); ?>]
					}
				]
				
			};
			new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
		<?php else: ?>
			//Interactive Chart
	        $(function () {
	            if ($('#target-chart').size() != 1) {
	                return;
	            }

	            var pageviews = [
	                [1,<?php echo e($myavgPoints[0][0]); ?>],
	                [2,<?php echo e($myavgPoints[1][0]); ?>],
	                [3,<?php echo e($myavgPoints[2][0]); ?>],
	                [4,<?php echo e($myavgPoints[3][0]); ?>],
	                [5,<?php echo e($myavgPoints[4][0]); ?>],
	                [6,<?php echo e($myavgPoints[5][0]); ?>],
	                [7,<?php echo e($myavgPoints[6][0]); ?>],
	                [8,<?php echo e($myavgPoints[7][0]); ?>],
	            ];
	            var visitors = [
	                [1,<?php echo e($myavgPoints[0][1]); ?>],
	                [2,<?php echo e($myavgPoints[1][1]); ?>],
	                [3,<?php echo e($myavgPoints[2][1]); ?>],
	                [4,<?php echo e($myavgPoints[3][1]); ?>],
	                [5,<?php echo e($myavgPoints[4][1]); ?>],
	                [6,<?php echo e($myavgPoints[5][1]); ?>],
	                [7,<?php echo e($myavgPoints[6][1]); ?>],
	                [8,<?php echo e($myavgPoints[7][1]); ?>],
	            ];

	            var plot = $.plot($("#target-chart"), [{
	                data: pageviews,
	                label: "全国平均",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0

	            }, {
	                data: visitors,
	                label: "自分",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0
	            }], {
	                series: {
	                    lines: {
	                        show: true,
	                        lineWidth: 2,
	                        fill: true,
	                        fillColor: {
	                            colors: [{
	                                opacity: 0.05
	                            }, {
	                                opacity: 0.01
	                            }]
	                        }
	                    },
	                    points: {
	                        show: true,
	                        radius: 3,
	                        lineWidth: 1
	                    },
	                    shadowSize: 2
	                },
	                grid: {
	                    hoverable: true,
	                    clickable: true,
	                    tickColor: "#eee",
	                    borderColor: "#eee",
	                    borderWidth: 1
	                },
	                colors: ["#d0cece", "#d12610", "#52e136"],
	                xaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                    mode: '',
	                },
	                yaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                }
	            });
				$(".dqtarget-chart .tickLabels .xAxis").empty();
				$xstr = "<div class='tickLabel' style='position:absolute;text-align:center;left:-12px;top:300px;width:60px'>"+<?php echo e($cur_season[0]['year']); ?> + "年度<br> <?php echo e($cur_season[0]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:54px;top:300px;width:60px'>"+<?php echo e($cur_season[1]['year']); ?> + "年度<br> <?php echo e($cur_season[1]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:119px;top:300px;width:60px'>"+<?php echo e($cur_season[2]['year']); ?> + "年度<br> <?php echo e($cur_season[2]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:185px;top:300px;width:60px'>"+<?php echo e($cur_season[3]['year']); ?> + "年度<br> <?php echo e($cur_season[3]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:250px;top:300px;width:60px'>"+<?php echo e($cur_season[4]['year']); ?> + "年度<br> <?php echo e($cur_season[4]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:316px;top:300px;width:60px'>"+<?php echo e($cur_season[5]['year']); ?> + "年度<br> <?php echo e($cur_season[5]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:381px;top:300px;width:60px'>"+<?php echo e($cur_season[6]['year']); ?> + "年度<br> <?php echo e($cur_season[6]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:447px;top:300px;width:60px'>"+<?php echo e($cur_season[7]['year']); ?> + "年度<br> <?php echo e($cur_season[7]['season']); ?>"+"</div>";
				$(".dqtarget-chart .tickLabels .xAxis").html($xstr);

	            function showTooltip(x, y, contents) {
	                $('<div id="tooltip">' + contents + '</div>').css({
	                    position: 'absolute',
	                    display: 'none',
	                    top: y + 5,
	                    left: x + 15,
	                    border: '1px solid #333',
	                    padding: '4px',
	                    color: '#fff',
	                    'border-radius': '3px',
	                    'background-color': '#333',
	                    opacity: 0.80
	                }).appendTo("body").fadeIn(200);

	            }

	            var previousPoint = null;
	            /*$("#target-chart").bind("plothover", function(event, pos, item) {
	                $("#x").text(pos.x.toFixed(2));
	                $("#y").text(pos.y.toFixed(2));
	               
	                if (item) {
	                    if (previousPoint != item.dataIndex) {
	                        previousPoint = item.dataIndex;

	                        $("#tooltip").remove();
	                        var x = item.datapoint[0].toFixed(2),
	                            y = item.datapoint[1].toFixed(2);

	                        showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
	                    }
	                } else {
	                    $("#tooltip").remove();
	                    previousPoint = null;
	                }
	            });*/
	        });

		<?php endif; ?>

		$(function () {
	
			function showBar(tag, points_data, points_interval, member_interval, my_points, legend_text = '',axis_label = 'null'){
	 	  	var settings = {
				title:null,
				description: null,
				showLegend: true,
				showToolTips: false,
				enableAnimations: true,
				showBorderLine: false,
				legendLayout : { left:0 , top: 5, width:100, height:100, flow: 'vertical' },
				padding: { left: 0, top: 5, right: 20, bottom: 0 },
				source: points_data,
				xAxis:
				{
					dataField: 'x_point',
					gridLines: { visible: false },
					flip: true,
					minValue:0,
					unitInterval:points_interval,
					visible:true,
					labels:{
						angle:90,
						offset:{x:0,y:10}
					}
				},
				valueAxis:
				{
					flip: true,
					minValue:0,
					unitInterval:member_interval,
					labels: {
						visible: true,
						horizontalAlignment: 'left',
						formatFunction: function (value) {
							return parseInt(value);
						}
					},
					title: { text: axis_label,
                    		horizontalAlignment:'right'
                	}
				},
				colorScheme: 'scheme01',
				seriesGroups:
					[
						{
							type: 'column',
							orientation: 'horizontal',
							columnsGapPercent: 40,
							series: [
							{ dataField: 'value_member', displayText:legend_text, colorFunction: function (value, itemIndex, serie, group) {
											return (itemIndex == [Math.floor(my_points/points_interval)] ) ? '#FF0000' : '#0000ff';
							},
							labels: { 
                                    visible: true,
                                    horizontalAlignment : 'right',
                                    offset: { x: 5, y: 0 }
                             },
                                formatFunction: function (value) {
                                	if(value > 0)
                                   		 return value;
                                },
							   lineColor:'#0000ff',
							   lineWidth: 0.5
							}		
								]
						}
					]
			};

			// setup the chart
			$("#"+tag).jqxChart(settings);
	  }
	
			var m_interval_num = 4;
		var p_interval_num = 15;
		var member_interval = 0;
		var points_interval = 0;
		<?php if($type == 0): ?>		
			var myrank1 = 1;
			var myrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints1 as $i => $rank ): ?>
					myrank_pupils1 = myrank_pupils1 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						myrank1 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
			showBar("horizontal-chart1",points_data, points_interval, member_interval, my_points,myrank1+"位/"+myrank_pupils1+"人");

/////////////////////////////////////////////////////////
			var myrank2 = 1;
			var myrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints2 as $i => $rank ): ?>
					myrank_pupils2 = myrank_pupils2 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						myrank2 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
			showBar("horizontal-chart2",points_data, points_interval, member_interval, my_points,myrank2+"位/"+myrank_pupils2+"人");

		<?php endif; ?>

			var myrank3 = 1;
			var myrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints3 as $i => $rank ): ?>
					myrank_pupils3 = myrank_pupils3 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						myrank3 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart3",points_data, points_interval, member_interval, my_points,myrank3+"位/"+myrank_pupils3+"人");

			var myrank4 = 1;
			var myrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints4 as $i => $rank ): ?>
					myrank_pupils4 = myrank_pupils4 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						myrank4 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart4",points_data, points_interval, member_interval, my_points, myrank4+"位/"+myrank_pupils4+"人");

			var myrank5 = 1;
			var myrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints5 as $i => $rank ): ?>
					myrank_pupils5 = myrank_pupils5 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						myrank5 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart5",points_data, points_interval, member_interval, my_points, myrank5+"位/"+myrank_pupils5+"人");

			//
		<?php if($type == 0): ?>	

			var threemonthrank1 = 1;
			var threemonthrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank ): ?>
					threemonthrank_pupils1 = threemonthrank_pupils1 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						threemonthrank1 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart1",points_data, points_interval, member_interval, my_points, threemonthrank1+"位/"+threemonthrank_pupils1+"人", '人');

			var threemonthrank2 = 1;
			var threemonthrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank ): ?>
					threemonthrank_pupils2 = threemonthrank_pupils2 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						threemonthrank2 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart2",points_data, points_interval, member_interval, my_points, threemonthrank2+"位/"+threemonthrank_pupils2+"人", '人');
		<?php endif; ?>

			var threemonthrank3 = 1;
			var threemonthrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank ): ?>
					threemonthrank_pupils3 = threemonthrank_pupils3 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						threemonthrank3 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart3",points_data, points_interval, member_interval, my_points, threemonthrank3+"位/"+threemonthrank_pupils3+"人", '人');
	
			var threemonthrank4 = 1;
			var threemonthrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank ): ?>
					threemonthrank_pupils4 = threemonthrank_pupils4 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						threemonthrank4 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart4",points_data, points_interval, member_interval, my_points, threemonthrank4+"位/"+threemonthrank_pupils4+"人", '人');

	
			var threemonthrank5 = 1;
			var threemonthrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank ): ?>
					threemonthrank_pupils5 = threemonthrank_pupils5 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						threemonthrank5 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart5",points_data, points_interval, member_interval, my_points, threemonthrank5+"位/"+threemonthrank_pupils5+"人", '人');

			//
		<?php if($type == 0): ?>

			var allrank1 = 1;
			var allrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints1 as $i => $rank ): ?>
					allrank_pupils1 = allrank_pupils1 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						allrank1 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart1",points_data, points_interval, member_interval, my_points, allrank1+"位/"+allrank_pupils1+"人");

			var allrank2 = 1;
			var allrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints2 as $i => $rank ): ?>
					allrank_pupils2 = allrank_pupils2 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						allrank2 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart2",points_data, points_interval, member_interval, my_points, allrank2+"位/"+allrank_pupils2+"人");
		<?php endif; ?>
			
			var allrank3 = 1;
			var allrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints3 as $i => $rank ): ?>
					allrank_pupils3 = allrank_pupils3 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						allrank3 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart3",points_data, points_interval, member_interval, my_points, allrank3+"位/"+allrank_pupils3+"人");

			
			var allrank4 = 1;
			var allrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints4 as $i => $rank ): ?>
					allrank_pupils4 = allrank_pupils4 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						allrank4 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart4",points_data, points_interval, member_interval, my_points, allrank4+"位/"+allrank_pupils4+"人");

			
			var allrank5 = 1;
			var allrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints5 as $i => $rank ): ?>
					allrank_pupils5 = allrank_pupils5 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						allrank5 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart5",points_data, points_interval, member_interval, my_points, allrank5+"位/"+allrank_pupils5+"人");

		});
		$(document).ready(function(){
			$(".print").click(function(){
				$(".form-horizontal").submit();
			});
		});
		var initBody;
		function beforeprint(){
			initBody = document.body.innerHTML;
			document.body.innerHTML = idprint.innerHTML;
		}
		function afterprint(){
			document.body.innerHTML = initBody;
			location.href = "/mypage/recent_report/";
		}
		//window.onbeforeprint = beforeprint;
		//window.onafterprint = afterprint;
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>