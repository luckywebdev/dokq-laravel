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
			            > 	<a href="<?php echo e(url('/top')); ?>">団体アカウントトップ</a>
		            </li>
		            <li class="hidden-xs">
		                > クラス対抗 読書量ランキング
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				クラス対抗：読書量ランキング
			</h3>
			
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control">
					<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option  <?php if($class_selected['id'] == $class->id): ?> selected  <?php endif; ?> id = '<?php echo e($class->id); ?>'>
							<?php if(isset($class->group_name) && $class->group_name != '' && $class->group_name != null): ?><?php echo e($class->group_name); ?><?php endif; ?>
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
						</option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<div class="col-md-4 text-md-center">（同学年内順位）
				</div>		
			</div>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="tools">
								<?php echo date("Y年 m月 d日");?> 現在
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th></th>
											<th>獲得ポイント/1人&nbsp;&nbsp;<span style="font-size:12px">(クラス平均）</span></th>
											<th>学年順位</th>
											<th>市区町村内順位</th>
											<th>都道府県内順位</th>
											<th>全国順位</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<tr class="danger">
											<td><?php echo e($current_season['year']); ?>年度 冬</td>
											<td><?php echo e($avg_point['winter']); ?></td>
											<td><?php echo e($rank_grade['winter']); ?></td>
											<td><?php echo e($rank_city['winter']); ?></td>
											<td><?php echo e($rank_province['winter']); ?></td>
											<td><?php echo e($rank_overall['winter']); ?></td>
										</tr>
										<tr class="warning">
											<td><?php echo e($current_season['year']); ?>年度 秋</td>
											<td><?php echo e($avg_point['autumn']); ?></td>
											<td><?php echo e($rank_grade['autumn']); ?></td>
											<td><?php echo e($rank_city['autumn']); ?></td>
											<td><?php echo e($rank_province['autumn']); ?></td>
											<td><?php echo e($rank_overall['autumn']); ?></td>
										</tr>
										<tr class="danger">
											<td><?php echo e($current_season['year']); ?>年度 夏</td>
											<td><?php echo e($avg_point['summer']); ?></td>
											<td><?php echo e($rank_grade['summer']); ?></td>
											<td><?php echo e($rank_city['summer']); ?></td>
											<td><?php echo e($rank_province['summer']); ?></td>
											<td><?php echo e($rank_overall['summer']); ?></td>
										</tr>
										<tr class="warning">
											<td><?php echo e($current_season['year']); ?>年度 春</td>
											<td><?php echo e($avg_point['spring']); ?></td>
											<td><?php echo e($rank_grade['spring']); ?></td>
											<td><?php echo e($rank_city['spring']); ?></td>
											<td><?php echo e($rank_province['spring']); ?></td>
											<td><?php echo e($rank_overall['spring']); ?></td>
										</tr>
										<tr class="danger">
											<td><?php echo e($current_season['year']); ?>年度 累計</td>
											<td><?php echo e($avg_point['year']); ?></td>
											<td><?php echo e($rank_grade['year']); ?></td>
											<td><?php echo e($rank_city['year']); ?></td>
											<td><?php echo e($rank_province['year']); ?></td>
											<td><?php echo e($rank_overall['year']); ?></td>
										</tr>
										<tr class="warning">
											<td>生涯</td>
											<td><?php echo e($avg_point['all']); ?></td>
											<td><?php echo e($rank_grade['all']); ?></td>
											<td><?php echo e($rank_city['all']); ?></td>
											<td><?php echo e($rank_province['all']); ?></td>
											<td><?php echo e($rank_overall['all']); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- <a href="<?php if(Auth::user()->role == config('consts')['USER']['ROLE']['PUPIL']): ?><?php echo e(url('/mypage/top')); ?> <?php else: ?><?php echo e(url('/')); ?><?php endif; ?>" class="btn btn-info pull-right">戻　る</a> -->
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
		<form action=<?php echo e(url('/group/rank/1')); ?> id="selectClass" name="rank1-form" method = "GET">
					<input type="hidden" name="_token" value="<?php echo e(csrf_field()); ?>">
					<input type="hidden" name="class_id" id="class_id" value=""/>
		</form>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php if($other_id != $user->id): ?>
				$('body').addClass('page-full-width');
			<?php endif; ?>
			ComponentsDropdowns.init();
			$("select").change(function(){
				$("#class_id").val($(":selected").attr("id"));
				
				$("#selectClass").submit();
//				alert($(":selected").attr("id"));
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>