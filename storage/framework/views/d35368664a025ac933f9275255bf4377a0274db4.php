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
   			padding: 0 0px;
   		}
   		.chart_kind ul li.clast{
   			margin-left: 0%;
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
	            	<a href="<?php echo e(url('/mypage/top')); ?>">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 読書量ランキンググラフ
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Qポイント順位グラフ<span style="font-size:12px"><?php if($user->isPupil() && $user->active == 1): ?>（同学年内） <?php else: ?>（同年代と競うグラフ）<?php endif; ?></span>
			</h3>
			<div class="row ">
				<div class="col-md-12"  style="text-align:right;">	
					<span style="font-size:12px;">※人数分布グラフです。（赤色が自分の位置）</span>

				</div>
			</div>
			<div class="row">
				<div class="col-md-6">						
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<?php echo e($season_str); ?> 読書量順位
							</div>
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:20%;text-align:center;">クラス</li>
									<li style="width:20%;text-align:center;">学年</li>
									<li style="width:20%;text-align:center;">市区町村内</li>
									<li style="width:20%;text-align:center;">都道府県内</li>
									<li style="width:20%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="threemonth-chart1" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart2" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart3" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart4" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart5" style="width:20%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php else: ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:33%;text-align:center;">市区町村内</li>
									<li style="width:33%;text-align:center;">都道府県内</li>
									<li style="width:33%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="threemonth-chart3" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart4" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="threemonth-chart5" style="width:33%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-md-6">						
					
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<?php echo e($beforeseason_str); ?> 読書量順位
							</div>
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:20%;text-align:center;">クラス</li>
									<li style="width:20%;text-align:center;">学年</li>
									<li style="width:20%;text-align:center;">市区町村内</li>
									<li style="width:20%;text-align:center;">都道府県内</li>
									<li style="width:20%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="beforethreemonth-chart1" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart2" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart3" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart4" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart5" style="width:20%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php else: ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:33%;text-align:center;">市区町村内</li>
									<li style="width:33%;text-align:center;">都道府県内</li>
									<li style="width:33%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="beforethreemonth-chart3" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart4" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="beforethreemonth-chart5" style="width:33%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								今年度読書量順位（現在まで）
							</div>
							
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:20%;text-align:center;">クラス</li>
									<li style="width:20%;text-align:center;">学年</li>
									<li style="width:20%;text-align:center;">市区町村内</li>
									<li style="width:20%;text-align:center;">都道府県内</li>
									<li style="width:20%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="horizontal-chart1" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart2" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart3" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart4" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart5" style="width:20%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php else: ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:33%;text-align:center;">市区町村内</li>
									<li style="width:33%;text-align:center;">都道府県内</li>
									<li style="width:33%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="horizontal-chart3" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart4" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart5" style="width:33%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
					</div>						
					
				</div>

				<div class="col-md-6">	
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<?php echo e($current_season['year']-1); ?>年度読書量順位　
							</div>
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:20%;text-align:center;">クラス</li>
									<li style="width:20%;text-align:center;">学年</li>
									<li style="width:20%;text-align:center;">市区町村内</li>
									<li style="width:20%;text-align:center;">都道府県内</li>
									<li style="width:20%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="lastyear-chart1" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart2" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart3" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart4" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart5" style="width:20%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php else: ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:33%;text-align:center;">市区町村内</li>
									<li style="width:33%;text-align:center;">都道府県内</li>
									<li style="width:33%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="lastyear-chart3" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart4" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="lastyear-chart5" style="width:33%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
					</div>					
					
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">						
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								生涯読書量順位
							</div>
						</div>
						<?php if($type == 0): ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:20%;text-align:center;">クラス</li>
									<li style="width:20%;text-align:center;">学年</li>
									<li style="width:20%;text-align:center;">市区町村内</li>
									<li style="width:20%;text-align:center;">都道府県内</li>
									<li style="width:20%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="all-chart1" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="all-chart2" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="all-chart3" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="all-chart4" style="width:20%; float:left;" class="chart-holder"></div>
							<div id="all-chart5" style="width:20%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php else: ?>
						<div class="portlet-title" style="min-height:18px">
							<div class="chart_kind text-md-center" style="width:100%;">
								<ul>
									<li style="width:33%;text-align:center;">市区町村内</li>
									<li style="width:33%;text-align:center;">都道府県内</li>
									<li style="width:33%;text-align:center;" class="clast">国内</li>
								</ul>
							</div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div id="all-chart3" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="all-chart4" style="width:33%; float:left;" class="chart-holder"></div>
							<div id="all-chart5" style="width:33%; float:left;" class="chart-holder"></div>
							<div style = 'font-size:8px; color:#000000;position:absolute;left:30px;text-align:center'>(pt)</div>
						</div>
						<?php endif; ?>
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
	<link rel="stylesheet" href="<?php echo e(asset('css/jqwidgets/styles/jqx.base.css')); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxcore.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdraw.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxchart.core.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdata.js')); ?>"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="<?php echo e(asset('js/charts-flotcharts.js')); ?>"></script>

	<script>
		jQuery(document).ready(function() {
			ChartsFlotcharts.initBarCharts();
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
			/// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("horizontal-chart1",points_data, points_interval, member_interval, my_points,myrank1+"位/"+myrank_pupils1+"人", '人');

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
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
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
			showBar("threemonth-chart2",points_data, points_interval, member_interval, my_points, threemonthrank2+"位/"+threemonthrank_pupils2+"人");
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
			showBar("threemonth-chart3",points_data, points_interval, member_interval, my_points, threemonthrank3+"位/"+threemonthrank_pupils3+"人");
	
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
			showBar("threemonth-chart4",points_data, points_interval, member_interval, my_points, threemonthrank4+"位/"+threemonthrank_pupils4+"人");

	
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
			showBar("threemonth-chart5",points_data, points_interval, member_interval, my_points, threemonthrank5+"位/"+threemonthrank_pupils5+"人");

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
			showBar("all-chart1",points_data, points_interval, member_interval, my_points, allrank1+"位/"+allrank_pupils1+"人", '人');

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
				//
		<?php if($type == 0): ?>
			var lastrank1 = 1;
			var lastrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($lastyearrankPoints1 as $i => $rank ): ?>
					lastrank_pupils1 = lastrank_pupils1 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						lastrank1 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($lastyearrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("lastyear-chart1",points_data, points_interval, member_interval, my_points,lastrank1+"位/"+lastrank_pupils1+"人", '人');


			var lastrank2 = 1;
			var lastrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($lastyearrankPoints2 as $i => $rank ): ?>
					lastrank_pupils2 = lastrank_pupils2 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						lastrank2 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($lastyearrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("lastyear-chart2",points_data, points_interval, member_interval, my_points,lastrank2+"位/"+lastrank_pupils2+"人");
		<?php endif; ?>
			var lastrank3 = 1;
			var lastrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($lastyearrankPoints3 as $i => $rank ): ?>
					lastrank_pupils3 = lastrank_pupils3 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						lastrank3 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($lastyearrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("lastyear-chart3",points_data, points_interval, member_interval, my_points,lastrank3+"位/"+lastrank_pupils3+"人");

			var lastrank4 = 1;
			var lastrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($lastyearrankPoints4 as $i => $rank ): ?>
					lastrank_pupils4 = lastrank_pupils4 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						lastrank4 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($lastyearrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("lastyear-chart4",points_data, points_interval, member_interval, my_points,lastrank4+"位/"+lastrank_pupils4+"人");

			var lastrank5 = 1;
			var lastrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($lastyearrankPoints5 as $i => $rank ): ?>
					lastrank_pupils5 = lastrank_pupils5 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						lastrank5 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($lastyearrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("lastyear-chart5",points_data, points_interval, member_interval, my_points,lastrank5+"位/"+lastrank_pupils5+"人");
			
		<?php if($type == 0): ?>
			var beforethreemonthrank1 = 1;
			var beforethreemonthrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($beforethreemonthrankPoints1 as $i => $rank ): ?>
					beforethreemonthrank_pupils1 = beforethreemonthrank_pupils1 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						beforethreemonthrank1 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($beforethreemonthrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("beforethreemonth-chart1",points_data, points_interval, member_interval, my_points,beforethreemonthrank1+"位/"+beforethreemonthrank_pupils1+"人", '人');


			var beforethreemonthrank2 = 1;
			var beforethreemonthrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($beforethreemonthrankPoints2 as $i => $rank ): ?>
					beforethreemonthrank_pupils2 = beforethreemonthrank_pupils2 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						beforethreemonthrank2 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($beforethreemonthrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("beforethreemonth-chart2",points_data, points_interval, member_interval, my_points,beforethreemonthrank2+"位/"+beforethreemonthrank_pupils2+"人");
		<?php endif; ?>
			var beforethreemonthrank3 = 1;
			var beforethreemonthrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($beforethreemonthrankPoints3 as $i => $rank ): ?>
					beforethreemonthrank_pupils3 = beforethreemonthrank_pupils3 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						beforethreemonthrank3 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($beforethreemonthrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("beforethreemonth-chart3",points_data, points_interval, member_interval, my_points,beforethreemonthrank3+"位/"+beforethreemonthrank_pupils3+"人");

			var beforethreemonthrank4 = 1;
			var beforethreemonthrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($beforethreemonthrankPoints4 as $i => $rank ): ?>
					beforethreemonthrank_pupils4 = beforethreemonthrank_pupils4 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						beforethreemonthrank4 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($beforethreemonthrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			// When the graph is a good one, draw a larger bar so that the number does not go into the graph.
			showBar("beforethreemonth-chart4",points_data, points_interval, member_interval, my_points,beforethreemonthrank4+"位/"+beforethreemonthrank_pupils4+"人");

			var beforethreemonthrank5 = 1;
			var beforethreemonthrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($beforethreemonthrankPoints5 as $i => $rank ): ?>
					beforethreemonthrank_pupils5 = beforethreemonthrank_pupils5 + <?php echo e($rank->pupil_numbers); ?>;
					<?php if($rank->flag=='1'): ?>
						beforethreemonthrank5 = <?php echo e($i+1); ?>;
						my_points = <?php echo e($rank -> sum); ?>;
					<?php endif; ?>		
					top_point = Math.max(top_point, <?php echo e($rank->sum); ?>);
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($beforethreemonthrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor(<?php echo e($rank->sum); ?>/points_interval)]+=<?php echo e($rank->pupil_numbers); ?>;
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			
			//when the graph fixed, if the value is in the graph, draw unvisible bigger bar 
			showBar("beforethreemonth-chart5",points_data, points_interval, member_interval, my_points,beforethreemonthrank5+"位/"+beforethreemonthrank_pupils5+"人");
		
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>