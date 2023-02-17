

<?php $__env->startSection('styles'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
   
     <style type="text/css">
   		.nav > li > a:hover{
   			color: #777777!important;
   		}
   		.nav > li:first-child a{
   			background-color: transparent!important;
   			color: #777777!important;
   		}
   </style>
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
   		.font_gogic{
	        font-family:HGP明朝B; 
	    }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<script src="<?php echo e(asset('js/charts/Chart.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				<?php
				$title = '';
				if($user->isPupil() && $user->active ==1){
			    	$title .= $user->ClassOfPupil->fullTitle();
			     	if($user->gender == 1) $title .= "女子"; else $title .= "男子";
                }else{
                	if($user->age() >= 15)
                		if($user->role != config('consts')['USER']['ROLE']['AUTHOR']){
                            if($user->fullname_is_public) 
                            	$title .= $user->fullname(); 
                            else $title .= $user->username; 
                        }else{
                            if($user->fullname_is_public) 
                            	$title .= $user->fullname_nick();
                            else $title .= $user->username; 
                        }
                	else{
						//$title .= $user->age().'歳';
						$title .= '中学生以下';
						if($user->gender == 1) $title .= "女子"; else $title .= "男子";
					}
				}	
			    $title .= 'さんのマイ書斎';
			    ?>
			    <?php echo e($title); ?>

			</h3>

			<div class="row">
				<div class="col-md-6 column">
					<?php if($otherviewable == 1): ?>
					<div class="news-blocks white">
						<h4 class="font-blue-madison">読Qからの連絡帳</h4>
						<p>
							<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li style="margin-left:10px; margin-right:5px;">
								<?php if($message->from_id == Auth::id()): ?><?php echo  date_format($message->updated_at,'Y/m/d'). '->' . $message->post ?>
								<?php else: ?>
									<?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $message->content); $st = str_replace_first("#", "</u>", $st); 
										$st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
										for($i = 0; $i < 30; $i++) {
										 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
											$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
										}   ?>
										<?php echo  date_format($message->updated_at,'Y/m/d'). '->' . $st ?>
								<?php endif; ?>
							</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</p>
						<a href="<?php echo e(url('/mypage/site_notify/'.$user->id)); ?>" class="news-block-btn font-blue-madison">もっと見る</a>
					</div>
					<?php endif; ?>

					<?php if($user->isAuthor()): ?>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								自著リスト
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="col-md-4">タイトル</th>
											<th class="col-md-2">読Q本ID</th>
											<th class="col-md-4">ジャンル</th>
											<th class="col-md-2">ポイント</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
									     <?php $__currentLoopData = $mywriteBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="info">
											<td><a <?php if($book->active >= 3): ?> href="<?php echo e(url("/book/" . $book->id . "/detail")); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($book->title); ?></a></td>
											<td>dq<?php echo e($book->id); ?></td>
											<td><?php $__currentLoopData = $book->category_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($one."、"); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
											<td><?php echo e(floor($book->point*100)/100); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
							<a class="text-md-center font-blue-madison" href="<?php echo e(url('/mypage/mybooklist/'.$user->id)); ?>">もっと見る</a>
						</div>
					</div>
					<?php endif; ?>

					<?php if($otherviewable == 1 && $user->isOverseerAll()): ?>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								監修者募集中の本
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="col-md-3">タイトル</th>
											<th class="col-md-2">著者</th>
											<th class="col-md-2">読Q本ID</th>
											<th class="col-md-3">ジャンル</th>
											<th class="col-md-2">ポイント</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
									<?php if(isset($waitOverseerBooks)): ?>
									    <?php $__currentLoopData = $waitOverseerBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="info">
											<td><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/' . $book->id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($book->title); ?></a></td>
											<td><a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)); ?>" class="font-blue-madison"><?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?></a></td>
											<td>dq<?php echo e($book->id); ?></td>
											<td><?php $__currentLoopData = $book->category_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($one."、"); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
											<td><?php echo e(floor($book->point*100)/100); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
									</tbody>
								</table>
							</div>
							<a class="text-md-center font-blue-madison"  href="<?php echo e(url('/mypage/demand_list/'.$user->id)); ?>">もっと見る</a>
						</div>
					</div>
					<?php endif; ?>

                    <?php if($user->targetpercent_is_public == 1 || $user->age() < 15 || $otherviewable == 1): ?>
                    	<div class="portlet box blue">
                    	<?php if($type == 0): ?>
							<div class="portlet-title">
								<div class="caption">
									現在までの各期　目標達成率（同学年全国平均との比較)
								</div>
							</div>
							<div class="portlet-body" style="width: 640px; height: 320px; padding: 0px; position: relative;">
								<canvas id="bar" width="620" height="300" style="width: 617px; height: 300px;"></canvas>
								<div class="legend">
									<div style="position: absolute; width: 70px; height: 40px; top: 8.5px; right: 8.5px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
									<table style="position:absolute;top: 8.5px; right: 8.5px;font-size:smaller;color:#545454">
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
							<div class="portlet-title">
								<div class="caption">
									3カ月間で獲得するポイント推移（同年代全国平均との比較）
								</div>
							</div>
							<div class="portlet-body" style="height: 350px;">
								<div id="target-chart" class="dqtarget-chart chart-holder" style="width: 600px; height: 320px;"></div>
							</div>
						<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if(($user->author_readers_is_public == 1 || $otherviewable == 1) && $user->isAuthor()): ?>
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								読Qにおける自著の読者数比較
							</div>
						</div>
						<div class="portlet-body">
							<div id = "canvas_parent" class="portlet-body table-scrollable-all scroller" style = "width:100%;height:300px;alignment:center">
								<canvas id="authorbar" width = "617px" height= "300px" style = "width:617px;height:300px;float:left"></canvas>
							</div>
						</div>
					</div>
					<?php endif; ?>


					<?php if(($user->wishlists_is_public == 1 && $user->age() >= 15) || $otherviewable == 1): ?>
                    	<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
									読みたい本リスト
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-scrollable">
									<table class="table table-bordered table-hover">
										<thead>
											<tr class="success">
												<th class="col-md-6" style="vertical-align:middle;">タイトル</th>
												<th class="col-md-2" style="vertical-align:middle;">著者</th>
												<th class="col-md-1" style="vertical-align:middle;">ページ数</th>
												<th class="col-md-1" style="vertical-align:middle;">ポイント</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
											<?php $__currentLoopData = $wishBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($book->is_public): ?>
											<tr>
												<td class="text-md-center align-middle"><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" <?php endif; ?>><?php echo e($book->title); ?></a></td>
												<td class="text-md-center align-middle"><a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)); ?>"><?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?></a></td>
												<td class="text-md-center align-middle"><?php echo e($book->pages); ?></td>
												<td class="text-md-center align-middle"><?php echo e(floor($book->point*100)/100); ?></td>
											</tr>
											<?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
									</table>
								</div>
								<a class="text-md-center font-blue-madison" href="<?php echo e(url('/mypage/wish_list/'.$user->id)); ?>">もっと見る</a>
							</div>
						</div>
					<?php endif; ?>

					<?php if($user->mybookcase_is_public == 1 || $otherviewable == 1): ?>
                    	<div class="portlet box red">
							<div class="portlet-title">
								<div class="caption">マイ本棚（クイズに合格した本リスト）</div>
							</div>
							<div class="portlet-body">
					 			<div class="row">	
									<div class="col-md-12"> 
									<table class="table table-bordered table-hover table-category">
										<tbody class="text-md-center">
											
											<tr style="height:300px;padding:12px;">
												<?php for($i = 0; $i < (12 - count($myBooks)); $i++): ?>
												<td class="col-md-1"></td>
												<?php endfor; ?>
												<?php $j = 0; ?>
												<?php $__currentLoopData = $myBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
														if($j % 4 == 0)     $color = "#FFB5FC";
														elseif($j % 4 == 1) $color = "#F6F99A";
														elseif($j % 4 == 2) $color = "#92FAB2";
														elseif($j % 4 == 3) $color = "#A7D4FB";
												?>

												<td class="col-md-1 text-md-center" style="background-color:<?php echo e($color); ?>;padding-left:0px;padding-right:0px;">
													<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:200px;">
														<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
															<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" <?php endif; ?>>
															<?php echo e($book->title); ?>

															</a>
														</h5>
													</div>
													<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:100px;">
														<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
															<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)); ?>">
															<?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?>

															</a>
														</h5>
													</div>
												</td>
												<?php $j++; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>																					
											</tr>
										</tbody>
									</table>
									<a href="<?php echo e(url('/mypage/category/'.$user->id)); ?>" class="news-block-btn font-blue-madison">もっと見る</a>
									</div>
								</div>	
							</div>
						</div>
					<?php endif; ?>

					<?php if(($user->overseerbook_is_public == 1 || $otherviewable == 1) && $user->isOverseerAll()): ?>
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								監修した本リスト
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="col-md-3">タイトル</th>
											<th class="col-md-3">著者</th>
											<th class="col-md-2">読Q本ID</th>
											<th class="col-md-3">ジャンル</th>
											<th class="col-md-1">ポイント</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
									    <?php $__currentLoopData = $overseerBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="info text-md-center">
											<td class="align-middle"><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/' . $book->id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($book->title); ?></a></td>
											<td class="align-middle"><a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)); ?>" class="font-blue-madison"><?php echo e($book->firstname_nick.' '.$book->lastname_nick); ?></a></td>
											<td class="align-middle">dq<?php echo e($book->id); ?></td>
											<td class="align-middle"><?php $__currentLoopData = $book->category_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($one."、"); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
											<td class="align-middle"><?php echo e(floor($book->point*100)/100); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
							<a class="text-md-center font-blue-madison" href="<?php echo e(url('/mypage/overseer_books/'.$user->id)); ?>">もっと見る</a>
						</div>
					</div>
					<?php endif; ?>

					<?php if($otherviewable == 1 && $user->isOverseerAll()): ?>
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								監修応募履歴
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="col-md-3">タイトル</th>
											<th class="col-md-2">著者</th>
											<th class="col-md-2">読Q本ID</th>
											<th class="col-md-3">ジャンル</th>
											<th class="col-md-2">ポイント</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
									    <?php $__currentLoopData = $demandBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="info">
											<td><a <?php if($demand->Book->active >= 3): ?> href="<?php echo e(url('/book/' . $demand->Book->id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($demand->Book->title); ?></a></td>
											<td><a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $demand->Book->writer_id.'&fullname='.$demand->Book->firstname_nick.' '.$demand->Book->lastname_nick)); ?>" class="font-blue-madison"><?php echo e($demand->Book->firstname_nick.' '.$demand->Book->lastname_nick); ?></a></td>
											<td>dq<?php echo e($demand->Book->id); ?></td>
											<td><?php $__currentLoopData = $demand->Book->category_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($one."、"); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
											<td><?php echo e(floor($demand->Book->point*100)/100); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
							<a class="text-md-center font-blue-madison" href="<?php echo e(url('/mypage/bid_history/'.$user->id)); ?>">もっと見る</a>
						</div>
					</div>
					<?php endif; ?>

					<div class="news-blocks lime">
						<h4 class="font-blue">読Q活動の履歴</h4>
						
						<table class="table table-no-border">
							<tr>
								<td class="col-md-8 col-xs-8">
									<?php if($user->history_all_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/history_all/'.$user->id.'/true')); ?>" class="font-blue-madison">読Q活動の全履歴を見る</a>
								    <?php else: ?>
									読Q活動の全履歴を見る
									<?php endif; ?>
								</td>
								<td class="col-md-4 col-xs-4"><?php if(!$user->history_all_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								    <?php if($user->passed_records_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/pass_history/'.$user->id.'/true')); ?>" class="font-blue-madison">合格履歴を見る</a>
								    <?php else: ?>
								    合格履歴を見る
								    <?php endif; ?>
								</td>
								<td><?php if(!$user->passed_records_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								    <?php if($user->point_ranking_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/rank_by_age/'.$user->id.'/true')); ?>" class="font-blue-madison">ポイントランキングを見る</a>
								    <?php else: ?>
								    ポイントランキングを見る
								    <?php endif; ?>
								</td>
								<td><?php if(!$user->point_ranking_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								    <?php if($user->register_point_ranking_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/rank_bq/'.$user->id.'/true')); ?>" class="font-blue-madison">読書推進活動ランキングを見る</a>
								    <?php else: ?>
								    読書推進活動ランキングを見る
								    <?php endif; ?>
								</td>
								<td><?php if(!$user->register_point_ranking_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								    <?php if($user->book_allowed_record_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/book_reg_history/'.$user->id.'/true')); ?>" class="font-blue-madison">本の登録認定記録を見る</a>
								    <?php else: ?>
								    本の登録認定記録を見る
								    <?php endif; ?>
								</td>
								<td><?php if(!$user->book_allowed_record_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								    <?php if($user->quiz_allowed_record_is_public || $otherviewable == 1): ?>
								    <a href="<?php echo e(url('mypage/quiz_history/'.$user->id.'/true')); ?>" class="font-blue-madison">作成クイズの認定記録</a>
								    <?php else: ?>
								    作成クイズの認定記録
								    <?php endif; ?>
								</td>
								<td><?php if(!$user->quiz_allowed_record_is_public): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td>
								<?php if($user->last_report_is_public || $otherviewable == 1): ?>
							    <a href="<?php echo e(url('mypage/last_report/0/'.$user->id.'/true')); ?>" class="font-blue-madison">読Qレポートバックナンバーを見る</a>
							    <?php else: ?>
								読Qレポートバックナンバーを見る
								<?php endif; ?>
								</td>
								<td>非公開</td>
							</tr>
							<tr>
								<td>
									<a href="<?php echo e(url('mypage/article_history/'.$user->id)); ?>" class="font-blue-madison">帯文投稿履歴を見る</a>
								</td>
								<td><?php if($user->article_is_public == 0): ?> 非公開 <?php endif; ?></td>
							</tr>
							<tr>
								<td><a href="<?php echo e(url('mypage/other_view_info/'.$user->id.'/true')); ?>" class="font-blue-madison">公開基本情報を見る</a></td>
								<td></td>
							</tr>
						</table>
					</div>

					<div class="top-news">
						<?php echo $advertise->mystudy_bottom; ?>
					</div>
				</div>

				<div class="col-md-6 column">
                    <?php if($user->profile_is_public == 1 || $user->age() < 15 || $otherviewable == 1): ?>
					<div class="news-blocks lime">
						<h4 class="font-blue">現在の読Q資格、ポイントと目標</h4>

						<p>
							<div name = "student_show" id = "student_show" style = "display:none;">
								<?php echo e($current_season['from'] . '～' . $current_season['to'] . 'の目標・・'.$tagrgetpoint.'ポイント獲得'); ?><br>
								現在の目標達成率・・・・・・・・・・<?php if(isset($current_user) && $tagrgetpoint != 0): ?><?php echo e(floor($current_user->sumpoint*100/$tagrgetpoint)); ?><?php elseif(!isset($current_user) || $current_user == null): ?> 0 <?php endif; ?>％<br>
							</div>
							読Q資格・・・・・・・・・・・・・ <?php echo e($my_rank); ?>級、クイズ作成者<br>
							<div name = "myallpoints_show" id = "myallpoints_show" style = "display:none;">
								生涯ポイント・・・・・・・・・・・<?php echo e($total_point); ?>ポイント<br>
							</div>
							
							昇級まであと・・・・・・・・・・・<?php echo e($my_addpoint); ?>ポイント<br>
						</p>
					</div>
					<?php endif; ?>

                    <?php if($user->ranking_order_is_public == 1 || $user->age() < 15 || $otherviewable == 1): ?>
                    <div class="caption" style="font-size:16px">
						マイ読書量順位
					</div>
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
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">クラス</span></div>
							<div id="threemonth-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px;position:absolute;left:70px;text-align:center'>(pt)</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">学年</span></div>
							<div id="threemonth-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px;position:absolute;left:70px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
						<div class="portlet-body" style="height: 350px;">
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">市区<br>町村内</span></div>
							<div id="threemonth-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px;position:absolute;left:70px;text-align:center'>(pt)</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">都道<br>府県内</span></div>
							<div id="threemonth-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px;position:absolute;left:70px;text-align:center'>(pt)</div>
						</div>
						<div class="portlet-body" style="height: 360px;">
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">国内</span></div>
							<div id="threemonth-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px;position:absolute;left:70px;text-align:center'>(pt)</div>
							<a class="text-md-center font-blue-madison" href="<?php if(Auth::user()->isPupil()): ?><?php echo e(url('/mypage/rank_child_pupil/'.$user->id)); ?><?php else: ?><?php echo e(url('/mypage/rank_by_age/'.$user->id)); ?><?php endif; ?>">もっと見る</a>
						</div>
						<input type="hidden" id="currentSeason" name="currentSeason" value="<?php echo e($current_season['term']); ?>">
						<input type="hidden" id="arraySeason" name="arraySeason" value="<?php echo e($current_season['term']); ?>">
					</div>
					<?php endif; ?>
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
	<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
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
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="<?php echo e(asset('js/charts-flotcharts.js')); ?>"></script>
	<script src="<?php echo e(asset('js/charts/Chart.js')); ?>"></script>
	<link rel="stylesheet" href="<?php echo e(asset('css/jqwidgets/styles/jqx.base.css')); ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxcore.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdraw.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxchart.core.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdata.js')); ?>"></script>
	
	
	<script type="text/javascript">
		//$(window).load(function() {
		//	$('.nav > li > a').removeAttr('href');
		//	$('.nav > li > a').css('cursor','not-allowed');
		//	$('.dropdown > a').attr('data-toggle','');
		//});
	</script>
	<script>
		
		$('body').addClass('page-full-width');
		<?php if($otherview_flag): ?>
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
		var current_year = new Date().getYear() + 1900;
		var point_now = 0;
		var point = [];
		var avg_now = 0;
		var avg = [];
		var current_season = $("#currentSeason").val();
		var array_season = [<?php echo e($array_season[0]); ?>,<?php echo e($array_season[1]); ?>,<?php echo e($array_season[2]); ?>,<?php echo e($array_season[3]); ?>];

		<?php if($type == 0): ?>
			<?php if(isset($grade) && $grade != 0): ?>
				$("#student_show").css('display','block');
				$("#myallpoints_show").css('display','none');
			<?php else: ?>
				$("#student_show").css('display','none');
				$("#myallpoints_show").css('display','block');
			<?php endif; ?>
		<?php else: ?>
			$("#student_show").css('display','none');
			$("#myallpoints_show").css('display','block');
		<?php endif; ?>
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
		<?php if($user->author_readers_is_public == 1 && $user->isAuthor()): ?>
			var authorbarChartData = {						
				labels : [
				<?php foreach ($mywriteChartBooks as $book ): ?>
				'<?php echo e($book->title); ?>',
				<?php endforeach ?>
				],
				datasets : [
					{
						fillColor : "#d0cece",
						strokeColor : "#d0cece",
						data : [
						<?php foreach ($mywriteChartBooks as $book ): ?>
							'<?php echo e(count($book->passedwomanNum)); ?>',
						<?php endforeach ?>]
					},
					{
						fillColor : "#f8cbad",
						strokeColor : "#f8cbad",
						data : [
						<?php foreach ($mywriteChartBooks as $book ): ?>
							'<?php echo e(count($book->passedmanNum)); ?>',
						<?php endforeach ?>]
					}
				]
			};
			new Chart(document.getElementById("authorbar").getContext("2d")).Bar(authorbarChartData);
		<?php endif; ?>
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
				$xstr = "<div class='tickLabel' style='position:absolute;text-align:center;left:-12px;top:300px;width:60px'>"+<?php echo e($cur_season[0]['year']); ?> + "年度<br> <?php echo e($cur_season[0]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:70px;top:300px;width:60px'>"+<?php echo e($cur_season[1]['year']); ?> + "年度<br> <?php echo e($cur_season[1]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:152px;top:300px;width:60px'>"+<?php echo e($cur_season[2]['year']); ?> + "年度<br> <?php echo e($cur_season[2]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:234px;top:300px;width:60px'>"+<?php echo e($cur_season[3]['year']); ?> + "年度<br> <?php echo e($cur_season[3]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:316px;top:300px;width:60px'>"+<?php echo e($cur_season[4]['year']); ?> + "年度<br> <?php echo e($cur_season[4]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:398px;top:300px;width:60px'>"+<?php echo e($cur_season[5]['year']); ?> + "年度<br> <?php echo e($cur_season[5]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:480px;top:300px;width:60px'>"+<?php echo e($cur_season[6]['year']); ?> + "年度<br> <?php echo e($cur_season[6]['season']); ?>"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:562px;top:300px;width:60px'>"+<?php echo e($cur_season[7]['year']); ?> + "年度<br> <?php echo e($cur_season[7]['season']); ?>"+"</div>";
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
		jQuery(document).ready(function() {
					
			$('body').addClass('page-full-width');
			
			
			//$('body').attr('oncontextmenu', 'return false;');
			/*document.addEventListener('contextmenu', function(e) {
			  alert('Right click');
			});
*/
			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});
			ChartsFlotcharts.initBarCharts();
		});   

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
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>