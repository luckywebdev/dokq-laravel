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
		                > 前々年度学校対抗 全国読書量ランキング ベスト５
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
				トップ校ベスト５ 全国読書量ランキング<br>
				<small><?php echo $current_season['year']-2 ?>年度に獲得したポイント</small>
			</h3>
			<?php if(Auth::user()->role == config('consts')['USER']['ROLE']['LIBRARIAN']): ?>
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control">
						<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option <?php if($group_id == $group->group_id): ?> selected <?php endif; ?> id='<?php echo e($group->group_id); ?>'><?php echo e($group->school->group_name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box purple">
						<div class="portlet-body">
							<ul class="nav nav-margent">
								<?php if(isset($schoolUser) && $schoolUser !== null && ($schoolUser->group_type == 0 || $schoolUser->group_type == 1)): ?>
							    <li class="active text-md-center">
									<a href="#tab_2_1" data-toggle="tab">
									市区町村内小学校ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_2" data-toggle="tab">
									都道府県内小学校ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_3" data-toggle="tab">
									全国小学校ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_4" data-toggle="tab">
									市区町村内中学校ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_5" data-toggle="tab">
									都道府県内中学校ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_6" data-toggle="tab">
									全国中学校ランキング </a>
								</li>
							    <?php else: ?>
								<li class="active text-md-center">
									<a href="#tab_2_1" data-toggle="tab">
									市区町村内ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_2" data-toggle="tab">
									都道府県内ランキング </a>
								</li>
								<li class=" text-md-center">
									<a href="#tab_2_3" data-toggle="tab">
									全国ランキング </a>
								</li>
								<?php endif; ?>
							</ul>
							<?php if($schoolUser->group_type == 0 || $schoolUser->group_type == 1): ?>
							<div class="tab-content"  style="background: #fcc5fa;">
								<div class="tab-pane fade active in" id="tab_2_1">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($cityTopSchools[0]); $i ++): ?>
												<tr>
													<td><?php echo e($cityTopSchools[0][$i]['rank']); ?>位</td>
													<td><?php echo e($cityTopSchools[0][$i]['name']); ?></td>
													<td><?php echo e(floor($cityTopSchools[0][$i]['point']*100)/100); ?>/ 1人</td>
													
												</tr>
											<?php endfor; ?>
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_2">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($provinceTopSchools[0]); $i ++): ?>
												<tr>
													<td><?php echo e($provinceTopSchools[0][$i]['rank']); ?>位</td>
													<td><?php echo e($provinceTopSchools[0][$i]['name']); ?></td>
													<td><?php echo e(floor($provinceTopSchools[0][$i]['point']*100)/100); ?>/ 1人</td>
												</tr>
											<?php endfor; ?>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_3">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($overallTopSchools[0]); $i ++): ?>
												<tr>
													<td><?php echo e($overallTopSchools[0][$i]['rank']); ?>位</td>
													<td><?php echo e($overallTopSchools[0][$i]['name']); ?></td>
													<td><?php echo e(floor($overallTopSchools[0][$i]['point']*100)/100); ?>/ 1人</td>
												</tr>
											<?php endfor; ?>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_4">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($cityTopSchools[1]); $i ++): ?>
												<tr>
													<td><?php echo e($cityTopSchools[1][$i]['rank']); ?>位</td>
													<td><?php echo e($cityTopSchools[1][$i]['name']); ?></td>
													<td><?php echo e(floor($cityTopSchools[1][$i]['point']*100)/100); ?>/ 1人</td>
													
												</tr>
											<?php endfor; ?>
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_5">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($provinceTopSchools[1]); $i ++): ?>
												<tr>
													<td><?php echo e($provinceTopSchools[1][$i]['rank']); ?>位</td>
													<td><?php echo e($provinceTopSchools[1][$i]['name']); ?></td>
													<td><?php echo e(floor($provinceTopSchools[1][$i]['point']*100)/100); ?>/ 1人</td>
												</tr>
											<?php endfor; ?>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_6">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($overallTopSchools[1]); $i ++): ?>
												<tr>
													<td><?php echo e($overallTopSchools[1][$i]['rank']); ?>位</td>
													<td><?php echo e($overallTopSchools[1][$i]['name']); ?></td>
													<td><?php echo e(floor($overallTopSchools[1][$i]['point']*100)/100); ?>/ 1人</td>
												</tr>
											<?php endfor; ?>
										</tbody>
									</table>
								</div>
							</div>
							<?php else: ?>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_2_1">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($cityTopSchools); $i ++): ?>
												<tr>
													<td><?php echo e($cityTopSchools[$i]['rank']); ?>位</td>
													<td><?php echo e($cityTopSchools[$i]['name']); ?></td>
													<td><?php echo e(floor($cityTopSchools[$i]['point']*100)/100); ?>/ 1人</td>
													
												</tr>
											<?php endfor; ?>
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_2">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($provinceTopSchools); $i ++): ?>
												<tr>
													<td><?php echo e($provinceTopSchools[$i]['rank']); ?>位</td>
													<td><?php echo e($provinceTopSchools[$i]['name']); ?></td>
													<td><?php echo e(floor($provinceTopSchools[$i]['point']*100)/100); ?>/ 1人</td>
													
												</tr>
											<?php endfor; ?>
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_3">
									<table class="table table-striped table-bordered table-hover  data-table">
										<tbody class="text-md-center">
											<?php for($i = 0; $i < count($overallTopSchools); $i ++): ?>
												<tr>
													<td><?php echo e($overallTopSchools[$i]['rank']); ?>位</td>
													<td><?php echo e($overallTopSchools[$i]['name']); ?></td>
													<td><?php echo e(floor($overallTopSchools[$i]['point']*100)/100); ?>/ 1人</td>
													
												</tr>
											<?php endfor; ?>
											
										</tbody>
									</table>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- <a href="<?php if(Auth::user()->role == config('consts')['USER']['ROLE']['PUPIL']): ?><?php echo e(url('/mypage/top')); ?> <?php else: ?><?php echo e(url('/')); ?><?php endif; ?>" class="btn btn-info pull-right">戻　る</a> -->
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
		<form action=<?php echo e(url('/group/rank/5')); ?> id="selectGrade" name="rank5-form" method = "GET">
			<input type="hidden" name="_token" value="<?php echo e(csrf_field()); ?>">
			<input type="hidden" name="group_id" id="group_id" value=""/>
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
//				alert($(":selected").attr("id"));
				$("#group_id").val($(":selected").attr("id"));
				$("#selectGrade").submit();
//				alert($(":selected").attr("id"));
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>