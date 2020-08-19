
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
		                 > 団体教師トップ
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	

	<div class="page-content-wrapper">
		<div class="page-content">
			
			<div class="row form-group">
                <label class="control-label col-md-1">お知らせ</label>
                <div class="col-md-11 note note-danger" >
                	<div class="scroller" style="height:70px;">
	                    <p>
	                    <?php if(count($messages)): ?>
	                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							(<?php echo e(with((date_create($msg->created_at)))->format('Y.m.d')); ?>)
							<?php if($msg->from_id == 0): ?>['協会']
							<?php else: ?>['団体']
							<?php endif; ?>
							<?php echo e($msg->content); ?> <br>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						</p>
					</div>
                </div>
			</div>
			
			<form method="get" action="<?php echo e(url('class/rank/5')); ?>" id="form">
				<input type="hidden" name="class_id" value="" id="class_id"/>
			</form>
			<div class="row form-group">
                <label class="control-label col-md-1">学級を選択</label>
                <div class="col-md-4">
                    <select id="sel_class" name="sel_class" class="bs-select form-control">
                    	<option></option>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($class->id); ?>">
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
			</div>

			<div class="row">
				<div class="col-md-6 column">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>全学級　今年度読書量比較グラフ
							</div>
						</div>
						<div class="portlet-body">
							<div id="chart_1_1_legendPlaceholder">
							</div>
							<div id="chart_1_1" class="chart">
							</div>
						</div>
					</div>

					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase">
									今期（<?php echo e($curQuartDateString); ?>)1人あたりの読書目標
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<table class="table no_header_table">
									<tbody class="text-md-center">
									
										<tr>
											<td>1年生</td>
											<td>7ポイント </td>
										</tr>
										<tr>
											<td>2年生</td>
											<td>13ポイント </td>
										</tr>
										<tr>
											<td>3年生</td>
											<td>20ポイント </td>
										</tr>
										<tr>
											<td>4年生</td>
											<td>35ポイント </td>
										</tr>
										<tr>
											<td>5年生</td>
											<td>50ポイント </td>
										</tr>
										<tr>
											<td>6年生</td>
											<td>70ポイント </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 column">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase">
									今期の読書量 学年トップを走るクラス
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<table class="table no_header_table">
									<tbody class="text-md-center">
										<tr>
											<td><?php if(isset($top_class_names[1])): ?> <?php echo e($top_class_names[1]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
											<td><?php if(isset($top_class_names[4])): ?> <?php echo e($top_class_names[4]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
										</tr>
										<tr>
											<td><?php if(isset($top_class_names[2])): ?> <?php echo e($top_class_names[2]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
											<td><?php if(isset($top_class_names[5])): ?> <?php echo e($top_class_names[5]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
										</tr>
										<tr>
											<td><?php if(isset($top_class_names[3])): ?> <?php echo e($top_class_names[3]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
											<td><?php if(isset($top_class_names[6])): ?> <?php echo e($top_class_names[6]); ?> 学級  <?php else: ?> &nbsp; <?php endif; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase">
									各学年で一番の読書家
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:255px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<table class="table no_header_table">
									<tbody class="text-md-center">
										<tr>
											<td>1年 <?php if($top_student_names[1]!=null): ?><?php echo e($top_student_names[1]->PupilsClass->class_number); ?> 組<?php endif; ?></td>
											<td><?php if($top_student_names[1]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[1]->id)); ?>" class="font-blue"><?php echo e($top_student_names[1]->fullname()); ?> </a> <?php endif; ?></td>
										</tr>
										<tr>
											<td>2年 <?php if($top_student_names[2]!=null): ?><?php echo e($top_student_names[2]->PupilsClass->class_number); ?> 組<?php endif; ?></td>
											<td><?php if($top_student_names[2]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[2]->id)); ?>" class="font-blue"><?php echo e($top_student_names[2]->fullname()); ?> </a> <?php endif; ?> </td>
										</tr>
										<tr>
											<td>3年 <?php if($top_student_names[3]!=null): ?><?php echo e($top_student_names[3]->PupilsClass->class_number); ?>組<?php endif; ?></td>
											<td><?php if($top_student_names[3]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[3]->id)); ?>" class="font-blue"><?php echo e($top_student_names[3]->fullname()); ?> </a> <?php endif; ?> </td>										
										</tr>
										<tr>
											<td>4年 <?php if($top_student_names[4]!=null): ?><?php echo e($top_student_names[4]->PupilsClass->class_number); ?> 組<?php endif; ?></td>
											<td><?php if($top_student_names[4]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[4]->id)); ?>" class="font-blue"><?php echo e($top_student_names[4]->fullname()); ?> </a> <?php endif; ?> </td>
										</tr>
										<tr>
											<td>5年 <?php if($top_student_names[5]!=null): ?><?php echo e($top_student_names[5]->PupilsClass->class_number); ?> 組<?php endif; ?></td>
											<td><?php if($top_student_names[5]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[5]->id)); ?>" class="font-blue"><?php echo e($top_student_names[5]->fullname()); ?> </a> <?php endif; ?> </td>
										</tr>
										<tr>
											<td>6年 <?php if($top_student_names[6]!=null): ?><?php echo e($top_student_names[6]->PupilsClass->class_number); ?> 組<?php endif; ?></td>
											<td><?php if($top_student_names[6]!=null): ?><a href="<?php echo e(url('mypage/pupil_view/' .$top_student_names[6]->id)); ?>" class="font-blue"><?php echo e($top_student_names[6]->fullname()); ?> </a> <?php endif; ?> </td>
										</tr>										
									</tbody>
								</table>
							</div>
						</div>
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
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.min.js')); ?>"></script>
<!--	<script src="<?php echo e(asset('plugins/flot/jquery.flot.resize.min.js')); ?>"></script>-->
<!--	<script src="<?php echo e(asset('plugins/flot/jquery.flot.pie.min.js')); ?>"></script>-->
<!--	<script src="<?php echo e(asset('plugins/flot/jquery.flot.stack.min.js')); ?>"></script>-->
<!--	<script src="<?php echo e(asset('plugins/flot/jquery.flot.crosshair.min.js')); ?>"></script>-->
<!--	<script src="<?php echo e(asset('plugins/flot/jquery.flot.categories.min.js')); ?>" type="text/javascript"></script>-->
	<!-- END PAGE LEVEL PLUGINS -->
    <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php if(isset($noSideBar) && $noSideBar): ?>
				$('body').addClass('page-full-width');
			<?php endif; ?>
			ComponentsDropdowns.init();
			ChartsFlotcharts.initBarCharts();

			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});

			$(".make-switch").on('switchChange.bootstrapSwitch', function(){
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
				$.ajax({
					type: "post",
		      		url: post_url,
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
			    	}
				});	
		    });

			ChartsFlotcharts.initBarCharts();
		});
			
			$('#sel_class').change(function(){
				$("#class_id").val($(this).val());
				$("#form").submit();
		    });

			var data = JSON.parse('<?php echo json_encode($total_class_points)?>');
            var options = {
            	xaxis: {
                        ticks: JSON.parse('<?php echo json_encode($total_class_names)?>'),
                        
                        font: {
							size: 14,
							color: 'black'
                        }
                },
                yaxis: {
                    min: 0,
                },
                series: {
                    bars: {
                        show: true
                    }
                },
                bars: {
                    barWidth: 0.8,
                    lineWidth: 0, // in pixels
                    shadowSize: 0,
                    align: 'center'
                },

                grid: {
                    tickColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1
                }                
            };

            if ($('#chart_1_1').size() !== 0) {
                $.plot($("#chart_1_1"), [{
                    data: data,
                    lines: {
                        lineWidth: 1
                    },
                    shadowSize: 0
                }], options);
            }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>