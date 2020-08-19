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
	            <li class="hidden-xs">
	            	> <a href="<?php echo e(url('/top')); ?>">
	                	団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > クラス内の読書量
	            </li>
	            <li class="hidden-xs">
	                >
	                <?php if($type == 5): ?>最近の読Q活動
	                <?php elseif($type == 1): ?>今期順位
	                <?php elseif($type == 2): ?>前回順位
	                <?php elseif($type == 3): ?>今年度通算順位
	                <?php elseif($type == 4): ?>生涯順位
	                <?php endif; ?>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				<?php if($type == 5): ?>
				クラス内 最近の読Q活動	
				<?php endif; ?>
				<?php if($type == 4): ?>
				クラス内 生涯ポイント順位<br>
				（読Qを始めてから現在までの合計ポイント順位）
				<?php endif; ?>
				<?php if($type == 3): ?>
				クラス内 今年度通算ポイント順位 (<?php echo e($current_season['begin_thisyear']); ?>.4.1~<?php echo e($current_season['end_thisyear']); ?>.3.31)
				<?php endif; ?>
				<?php if($type == 2): ?>
				クラス内 前回順位  (<?php echo e($preQuartDateString); ?>)
				<?php endif; ?>
				<?php if($type == 1): ?>
				クラス内 今期順位 (<?php echo e($curQuartDateString); ?>)
				<?php endif; ?>
			</h3>
			
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control" id="class_select" name="class_select">
						<option value="-1"></option>
						<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option  <?php if($classid == $class->id): ?> selected <?php endif; ?> value="<?php echo e($class->id); ?>">
						<?php if($class->grade == 0): ?>
							<?php echo e($class->class_number); ?> <?php echo e($class->teacher_name); ?>

							<?php if(($class->class_number != '' && $class->class_number != null) || ($class->teacher_name != '' && $class->teacher_name != null)): ?>
								学級/
							<?php endif; ?>
						<?php elseif($class->class_number == '' || $class->class_number == null): ?>
							<?php echo e($class->grade); ?> <?php echo e($class->teacher_name); ?>年/
						<?php else: ?>
							<?php echo e($class->grade); ?>-<?php echo e($class->class_number); ?> <?php echo e($class->teacher_name); ?>学級/
						<?php endif; ?>
						<?php echo e($class->year); ?>年度
						<?php if($class->member_counts != 0 && $class->member_counts !== null): ?>
						 	<?php echo e($class->member_counts); ?>名
						<?php endif; ?>	
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</option>
					</select>
				</div>
				<div class="col-md-8">
					<p class="pull-right"><?php echo e(date('Y.m.d')); ?>  現在</p>
				</div>	
			</div>
			
			<form method="get" action="<?php echo e(url('class/rank/'.$type)); ?>" id="form">
				<input type="hidden" name="class_id" value="" id="class_id"/>
			</form>
			
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i><?php echo $current_season['year'] ?>年度に獲得
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-purple">
								<li class="<?php if(isset($type) && $type == '1'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/class/rank/1?class_id='.$classid)); ?>"><strong>
									今期ポイント順位</strong></a>
								</li>
								<li class="<?php if(isset($type) && $type == '2'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/class/rank/2?class_id='.$classid)); ?>"><strong>
									前回ポイント順</strong></a>
								</li>
								<li class="<?php if(isset($type) && $type == '3'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/class/rank/3?class_id='.$classid)); ?>"><strong>
									今年度通算ポイント順 </strong></a>
								</li>
								<li class="<?php if(isset($type) && $type == '4'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/class/rank/4?class_id='.$classid)); ?>"><strong>
									生涯ポイント順位</strong></a>
								</li>
								<li class="<?php if(isset($type) && $type == '5'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/class/rank/5?class_id='.$classid)); ?>"><strong>
									直近の読Q活動を見る</strong></a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade <?php if(isset($type) && $type == '1'): ?> active in <?php endif; ?>" id="tab_1">
									<table class="table table-bordered table-hover" id="sample_rank1">
										<thead>
											<tr style="color: black;" role="row" width="100%">
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">直近の<br>受検日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">今期獲得<br>ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">現在の目標<br>達成率</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br><?php if($classnumber != ''): ?>/<?php echo e($classnumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br><?php if($gradenumber != ''): ?>/<?php echo e($gradenumber); ?><?php endif; ?></th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										<?php if(isset($type) && $type == '1'): ?>
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>												
												<tr>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname." ".$user->lastname); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname_yomi." ".$user->lastname_yomi); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->username); ?></td>
													<td style="vertical-align:middle; background-color:white">
														<?php if($user->cur_point >= 0 && $user->cur_point < 20): ?>
											               10 級
											            <?php elseif($user->cur_point >= 20 && $user->cur_point < 60): ?>
											                9 級
											            <?php elseif($user->cur_point >= 60 && $user->cur_point < 120): ?>
											                8 級
											            <?php elseif($user->cur_point >= 120 && $user->cur_point < 220): ?>
											                7 級
											            <?php elseif($user->cur_point >= 220 && $user->cur_point < 370): ?>
											               6 級
											            <?php elseif($user->cur_point >= 370 && $user->cur_point < 870): ?>
											                5 級
											            <?php elseif($user->cur_point >= 870 && $user->cur_point < 2070): ?>
											                4 級
											            <?php elseif($user->cur_point >= 2070 && $user->cur_point < 6070): ?>
											                3 級
											            <?php elseif($user->cur_point >= 6070 && $user->cur_point < 14070): ?>
											                2 級
											            <?php elseif($user->cur_point >= 14070 && $user->cur_point < 29070): ?>
											                1 級
											            <?php else: ?>
											                超段
											            <?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(config('consts')['USER']['GENDER'][$user->gender]); ?></td>
													<td style="vertical-align:middle; background-color:white">
														<?php if(isset($user->userquiz) && $user->userquiz->type == 2 && $user->userquiz->finished_date1 !== null && $user->userquiz->finished_date1 != ''): ?>
														<?php echo e(date_format(date_create($user->userquiz->finished_date1), "Y/m/d")); ?>

														<?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(floor($user->userquiz->cur_point*100)/100); ?>


													<?php if($user->PupilsClass->type == 0): ?> /
														<?php if($user->PupilsClass->grade == 1): ?> 7
														<?php elseif($user->PupilsClass->grade == 2): ?> 13
														<?php elseif($user->PupilsClass->grade == 3): ?> 20
														<?php elseif($user->PupilsClass->grade == 4): ?> 35
														<?php elseif($user->PupilsClass->grade == 5): ?> 50
														<?php else: ?> 70
														<?php endif; ?>
													<?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white">
													<?php if($user->PupilsClass->type == 0): ?> 
														<?php if($user->PupilsClass->grade == 1): ?> <?php echo e(floor($user->userquiz->cur_point*100/7)); ?>%
														<?php elseif($user->PupilsClass->grade == 2): ?> <?php echo e(floor($user->userquiz->cur_point*100/13)); ?>%
														<?php elseif($user->PupilsClass->grade == 3): ?> <?php echo e(floor($user->userquiz->cur_point*100/20)); ?>%
														<?php elseif($user->PupilsClass->grade == 4): ?> <?php echo e(floor($user->userquiz->cur_point*100/35)); ?>%
														<?php elseif($user->PupilsClass->grade == 5): ?> <?php echo e(floor($user->userquiz->cur_point*100/50)); ?>%
														<?php else: ?> <?php echo e(floor($user->userquiz->cur_point*100/70)); ?>%
														<?php endif; ?>
													<?php endif; ?>	
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->classrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->graderank); ?>位</td>
													
												</tr>												
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										<?php endif; ?>
										</tbody>
											<tr >
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($totalPoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($avgpoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade <?php if(isset($type) && $type == '2'): ?> active in <?php endif; ?>" id="tab_2">
									<table class="table table-bordered table-hover" id="sample_rank2">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px; vertical-align:middle;background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">前回ポイント</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br><?php if($classnumber != ''): ?>/<?php echo e($classnumber); ?><?php endif; ?></th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br><?php if($gradenumber != ''): ?>/<?php echo e($gradenumber); ?><?php endif; ?></th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br><?php if($citynumber != ''): ?>/<?php echo e($citynumber); ?><?php endif; ?></th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br><?php if($provincenumber != ''): ?>/<?php echo e($provincenumber); ?><?php endif; ?></th>												
											</tr>
										</thead>
										<tbody class="text-md-center">
										<?php if(isset($type) && $type == '2'): ?>
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>												
												<tr>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname." ".$user->lastname); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname_yomi." ".$user->lastname_yomi); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->username); ?></td>
													<td style="vertical-align:middle; background-color:white">
											            <?php if($user->cur_point >= 0 && $user->cur_point < 20): ?>
											               10 級
											            <?php elseif($user->cur_point >= 20 && $user->cur_point < 60): ?>
											                9 級
											            <?php elseif($user->cur_point >= 60 && $user->cur_point < 120): ?>
											                8 級
											            <?php elseif($user->cur_point >= 120 && $user->cur_point < 220): ?>
											                7 級
											            <?php elseif($user->cur_point >= 220 && $user->cur_point < 370): ?>
											               6 級
											            <?php elseif($user->cur_point >= 370 && $user->cur_point < 870): ?>
											                5 級
											            <?php elseif($user->cur_point >= 870 && $user->cur_point < 2070): ?>
											                4 級
											            <?php elseif($user->cur_point >= 2070 && $user->cur_point < 6070): ?>
											                3 級
											            <?php elseif($user->cur_point >= 6070 && $user->cur_point < 14070): ?>
											                2 級
											            <?php elseif($user->cur_point >= 14070 && $user->cur_point < 29070): ?>
											                1 級
											            <?php else: ?>
											                超段
											            <?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(config('consts')['USER']['GENDER'][$user->gender]); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(floor($user->userquiz->cur_point*100)/100); ?>

													<?php if($user->PupilsClass->type == 0): ?> /
														<?php if($user->PupilsClass->grade == 1): ?> 7
														<?php elseif($user->PupilsClass->grade == 2): ?> 13
														<?php elseif($user->PupilsClass->grade == 3): ?> 20
														<?php elseif($user->PupilsClass->grade == 4): ?> 35
														<?php elseif($user->PupilsClass->grade == 5): ?> 50
														<?php else: ?> 70
														<?php endif; ?>
													<?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->classrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->graderank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->cityrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->provincerank); ?>位</td>
												</tr>												
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										<?php endif; ?>	
										</tbody>
											<tr >
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($totalPoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($avgpoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade <?php if(isset($type) && $type == '3'): ?> active in <?php endif; ?>" id="tab_3">
									<table class="table table-bordered table-hover" id="sample_rank3">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px;vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">今年度通算<br>ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br><?php if($classnumber != ''): ?>/<?php echo e($classnumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br><?php if($gradenumber != ''): ?>/<?php echo e($gradenumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br><?php if($citynumber != ''): ?>/<?php echo e($citynumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br><?php if($provincenumber != ''): ?>/<?php echo e($provincenumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">全国順位<br><?php if($countrynumber != ''): ?>/<?php echo e($countrynumber); ?><?php endif; ?></th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										<?php if(isset($type) && $type == '3'): ?>
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>												
												<tr>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname." ".$user->lastname); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname_yomi." ".$user->lastname_yomi); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->username); ?></td>
													<td style="vertical-align:middle; background-color:white">
														<?php if($user->cur_point >= 0 && $user->cur_point < 20): ?>
											               10 級
											            <?php elseif($user->cur_point >= 20 && $user->cur_point < 60): ?>
											                9 級
											            <?php elseif($user->cur_point >= 60 && $user->cur_point < 120): ?>
											                8 級
											            <?php elseif($user->cur_point >= 120 && $user->cur_point < 220): ?>
											                7 級
											            <?php elseif($user->cur_point >= 220 && $user->cur_point < 370): ?>
											               6 級
											            <?php elseif($user->cur_point >= 370 && $user->cur_point < 870): ?>
											                5 級
											            <?php elseif($user->cur_point >= 870 && $user->cur_point < 2070): ?>
											                4 級
											            <?php elseif($user->cur_point >= 2070 && $user->cur_point < 6070): ?>
											                3 級
											            <?php elseif($user->cur_point >= 6070 && $user->cur_point < 14070): ?>
											                2 級
											            <?php elseif($user->cur_point >= 14070 && $user->cur_point < 29070): ?>
											                1 級
											            <?php else: ?>
											                超段
											            <?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(config('consts')['USER']['GENDER'][$user->gender]); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(floor($user->userquiz->cur_point*100)/100); ?>

													<!-- <?php if($user->PupilsClass->type == 0): ?> /
														<?php if($user->PupilsClass->grade == 1): ?> 7
														<?php elseif($user->PupilsClass->grade == 2): ?> 13
														<?php elseif($user->PupilsClass->grade == 3): ?> 20
														<?php elseif($user->PupilsClass->grade == 4): ?> 35
														<?php elseif($user->PupilsClass->grade == 5): ?> 50
														<?php else: ?> 70
														<?php endif; ?>
													<?php endif; ?> -->
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->classrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->graderank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->cityrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->provincerank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->countryrank); ?>位</td>

												</tr>												
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										<?php endif; ?>
											
										</tbody>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($totalPoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($avgpoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade <?php if(isset($type) && $type == '4'): ?> active in <?php endif; ?>" id="tab_4">
									<table class="table table-bordered table-hover" id="sample_rank4">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px;vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">生涯ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br><?php if($classnumber != ''): ?>/<?php echo e($classnumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br><?php if($gradenumber != ''): ?>/<?php echo e($gradenumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br><?php if($citynumber != ''): ?>/<?php echo e($citynumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br><?php if($provincenumber != ''): ?>/<?php echo e($provincenumber); ?><?php endif; ?></th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">全国順位<br><?php if($countrynumber != ''): ?>/<?php echo e($countrynumber); ?><?php endif; ?></th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										<?php if(isset($type) && $type == '4'): ?>
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>												
												<tr>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname." ".$user->lastname); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname_yomi." ".$user->lastname_yomi); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->username); ?></td>
													<td style="vertical-align:middle; background-color:white">
														<?php if($user->cur_point >= 0 && $user->cur_point < 20): ?>
											               10 級
											            <?php elseif($user->cur_point >= 20 && $user->cur_point < 60): ?>
											                9 級
											            <?php elseif($user->cur_point >= 60 && $user->cur_point < 120): ?>
											                8 級
											            <?php elseif($user->cur_point >= 120 && $user->cur_point < 220): ?>
											                7 級
											            <?php elseif($user->cur_point >= 220 && $user->cur_point < 370): ?>
											               6 級
											            <?php elseif($user->cur_point >= 370 && $user->cur_point < 870): ?>
											                5 級
											            <?php elseif($user->cur_point >= 870 && $user->cur_point < 2070): ?>
											                4 級
											            <?php elseif($user->cur_point >= 2070 && $user->cur_point < 6070): ?>
											                3 級
											            <?php elseif($user->cur_point >= 6070 && $user->cur_point < 14070): ?>
											                2 級
											            <?php elseif($user->cur_point >= 14070 && $user->cur_point < 29070): ?>
											                1 級
											            <?php else: ?>
											                超段
											            <?php endif; ?>
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(config('consts')['USER']['GENDER'][$user->gender]); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e(floor($user->userquiz->cur_point*100)/100); ?>

													<!-- <?php if($user->PupilsClass->type == 0): ?> /
														<?php if($user->PupilsClass->grade == 1): ?> 7
														<?php elseif($user->PupilsClass->grade == 2): ?> 13
														<?php elseif($user->PupilsClass->grade == 3): ?> 20
														<?php elseif($user->PupilsClass->grade == 4): ?> 35
														<?php elseif($user->PupilsClass->grade == 5): ?> 50
														<?php else: ?> 70
														<?php endif; ?>
													<?php endif; ?> -->
													</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->classrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->graderank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->cityrank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->provincerank); ?>位</td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->countryrank); ?>位</td>

												</tr>												
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										<?php endif; ?>
										</tbody>
										<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($totalPoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white"><?php echo e(floor($avgpoint*100)/100); ?></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade <?php if(isset($type) && $type == '5'): ?> active in <?php endif; ?>" id="tab_5">
									<table class="table table-bordered table-hover" id="sample_rank5">
										<thead>
											<tr style="color: black;height:40px" role="row">
												<th width="10%" style="padding:0px; vertical-align:middle;background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">受検日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クイズ作成日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">書籍登録日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">本のタイトル</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">獲得ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">備考</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										<?php if(isset($type) && $type == '5'): ?>	
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>												
												<tr>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname." ".$user->lastname); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->firstname_yomi." ".$user->lastname_yomi); ?></td>
													<td style="vertical-align:middle; background-color:white"><?php echo e($user->username); ?></td>
													<td style="vertical-align:middle; background-color:white">
														<?php if($user->cur_point >= 0 && $user->cur_point < 20): ?>
											               10 級
											            <?php elseif($user->cur_point >= 20 && $user->cur_point < 60): ?>
											                9 級
											            <?php elseif($user->cur_point >= 60 && $user->cur_point < 120): ?>
											                8 級
											            <?php elseif($user->cur_point >= 120 && $user->cur_point < 220): ?>
											                7 級
											            <?php elseif($user->cur_point >= 220 && $user->cur_point < 370): ?>
											               6 級
											            <?php elseif($user->cur_point >= 370 && $user->cur_point < 870): ?>
											                5 級
											            <?php elseif($user->cur_point >= 870 && $user->cur_point < 2070): ?>
											                4 級
											            <?php elseif($user->cur_point >= 2070 && $user->cur_point < 6070): ?>
											                3 級
											            <?php elseif($user->cur_point >= 6070 && $user->cur_point < 14070): ?>
											                2 級
											            <?php elseif($user->cur_point >= 14070 && $user->cur_point < 29070): ?>
											                1 級
											            <?php else: ?>
											                超段
											            <?php endif; ?>
													</td>
													<?php if(isset($user->userquiz) && $user->userquiz->type == 2): ?>
													<td style="vertical-align:middle; background-color:white"><?php echo e(date_format(date_create($user->userquiz->created_date), "Y/m/d")); ?></td>
													<?php else: ?>
													<td style="vertical-align:middle; background-color:white"></td>
													<?php endif; ?>

													<?php if(isset($user->userquiz) && $user->userquiz->type == 1): ?>
													<td style="vertical-align:middle; background-color:white"><?php echo e(date_format(date_create($user->userquiz->created_date),"Y/m/d")); ?></td>
													<?php else: ?>
													<td style="vertical-align:middle; background-color:white"></td>
													<?php endif; ?>

													<?php if(isset($user->userquiz) && $user->userquiz->type == 0): ?>													
													<td style="vertical-align:middle; background-color:white"><?php echo e(date_format(date_create($user->userquiz->created_date), "Y/m/d")); ?></td>
													<?php else: ?>
													<td style="vertical-align:middle; background-color:white"></td>
													<?php endif; ?>

													<td style="vertical-align:middle; background-color:white"><?php if(isset($user->userquiz)): ?><?php echo e($user->userquiz->Book->title); ?><?php endif; ?></td>

													<td style="vertical-align:middle; background-color:white"><?php if(isset($user->userquiz)): ?><?php echo e(floor($user->userquiz->point*100)/100); ?><?php endif; ?></td>

													<?php if(isset($user->userquiz) && $user->userquiz->type == 2): ?>
														<?php if(isset($user->userquiz) && ($user->userquiz->status == 3 || $user->userquiz->status == 4)): ?>
														<td style="vertical-align:middle; background-color:white"><?php echo e($userQuizStatus[$user->userquiz->status]); ?></td>
														<?php else: ?>
														<td style="vertical-align:middle; background-color:white"></td>									
														<?php endif; ?>
													<?php else: ?>
														<td style="vertical-align:middle; background-color:white"></td>
													<?php endif; ?>
												</tr>												
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>																					
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">読Qトップへ戻る</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();

			$("#class_select").change(function(){
				$("#class_id").val($(this).val());
				$("#form").submit();
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>