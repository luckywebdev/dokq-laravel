@extends('layout')
@section('styles')
    
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container-fluid">
	    	<div class="row">
		        <ol class="breadcrumb">
		            <li>
		                <a href="{{url('/')}}">
		                	読Qトップ
		                </a>
		            </li>
		            <li class="hidden-xs">
			            > 	<a href="{{url('/top')}}">団体アカウントトップ</a>
		            </li>
		            <li class="hidden-xs">
		               > 教師トップページの編集
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<form id="msgForm" action="{{url('/message/create')}}" method="post">
			<div class="row  form-group">
			    <label class="control-label col-md-1">お知らせ</label>
				<div class="col-md-8">
					{{csrf_field()}}
					<textarea required name="content" id="content" rows="3" class="form-control"></textarea>
					<input type="hidden" name="from_id" value="{{Auth::id()}}"/>
					<input type="hidden" name="type" value="1"/>
					<input type="hidden" name="to_id" value="{{$to_id}}"/>
				</div>
				<div class="col-md-3">
					<button type="submit" id="edit_layout" class="btn btn-warning" style="margin-top:8px;">お知らせの送信</button>
				</div>
			</div>
			<div class="row  form-group">
				<div class="col-md-1"></div>
				<div class="col-md-8 portlet-body">
					<div class="scroller" style="height:70px;">
				        <table cellpadding="0" cellspacing="0">
					        @foreach($message as $msg)
					        <tr>
					            <td width="20"><input type="checkbox" name="chbItem[]" value="{{$msg->id}}"></td>
					            <td>{{$msg->content}}({{with((date_create($msg->created_at)))->format('Y.m.d')}})</td>
					        </tr>
					        @endforeach
			        	</table>
				    </div>

				    
				</div>
			    <div class="col-md-3">
					<button type="button" id="delete" class="btn btn-danger">削除</button>
				</div>
			</div>
			</form>

			<div class="row form-group">
                <label class="control-label col-md-1">学級を選択</label>
                <div class="col-md-4">
                    <select id="sel_class" class="bs-select form-control">
                        @foreach($classes as $class)
                        <option value="{{$class->id}}" @if($class->id==$class_id) selected @endif>
                        	@if($class->grade == 0)
								{{$class->class_number}} {{$class->teacher_name}}
								@if(($class->class_number != '' && $class->class_number != null) || ($class->teacher_name != '' && $class->teacher_name != null))
									学級/
								@endif
							@elseif($class->class_number == '' || $class->class_number == null)
								{{$class->grade}} {{$class->teacher_name}}年/
							@else
								{{$class->grade}}-{{$class->class_number}} {{$class->teacher_name}}学級/
							@endif
							{{$class->year}}年度
							@if($class->member_counts != 0 && $class->member_counts !== null)
							 	{{$class->member_counts}}名
							@endif	
                        </option>
                        @endforeach
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
									今期（{{$curQuartDateString}})1人あたりの読書目標
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
											<td>@if(isset($top_class_names[1])) {{$top_class_names[1]}} 学級  @else &nbsp; @endif</td>
											<td>@if(isset($top_class_names[4])) {{$top_class_names[4]}} 学級  @else &nbsp; @endif</td>
										</tr>
										<tr>
											<td>@if(isset($top_class_names[2])) {{$top_class_names[2]}} 学級  @else &nbsp; @endif</td>
											<td>@if(isset($top_class_names[5])) {{$top_class_names[5]}} 学級  @else &nbsp; @endif</td>
										</tr>
										<tr>
											<td>@if(isset($top_class_names[3])) {{$top_class_names[3]}} 学級  @else &nbsp; @endif</td>
											<td>@if(isset($top_class_names[6])) {{$top_class_names[6]}} 学級  @else &nbsp; @endif</td>
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
											<td>1年 @if($top_student_names[1]!=null){{$top_student_names[1]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[1]!=null){{$top_student_names[1]->fullname()}} @endif</td>
										</tr>
										<tr>
											<td>2年 @if($top_student_names[2]!=null){{$top_student_names[2]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[2]!=null){{$top_student_names[2]->fullname()}} @endif </td>
										</tr>
										<tr>
											<td>3年 @if($top_student_names[3]!=null){{$top_student_names[3]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[3]!=null){{$top_student_names[3]->fullname()}} @endif </td>
										</tr>
										<tr>
											<td>4年 @if($top_student_names[4]!=null){{$top_student_names[4]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[4]!=null){{$top_student_names[4]->fullname()}} @endif </td>
										</tr>
										<tr>
											<td>5年 @if($top_student_names[5]!=null){{$top_student_names[5]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[5]!=null){{$top_student_names[5]->fullname()}} @endif </td>
										</tr>
										<tr>
											<td>6年 @if($top_student_names[6]!=null){{$top_student_names[6]->PupilsClass->class_number}} 学級@endif</td>
											<td>@if($top_student_names[6]!=null){{$top_student_names[6]->fullname()}} @endif </td>
										</tr>										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{asset('plugins/flot/jquery.flot.min.js')}}"></script>
<!--	<script src="{{asset('plugins/flot/jquery.flot.resize.min.js')}}"></script>-->
<!--	<script src="{{asset('plugins/flot/jquery.flot.pie.min.js')}}"></script>-->
<!--	<script src="{{asset('plugins/flot/jquery.flot.stack.min.js')}}"></script>-->
<!--	<script src="{{asset('plugins/flot/jquery.flot.crosshair.min.js')}}"></script>-->
<!--	<script src="{{asset('plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>-->
	<!-- END PAGE LEVEL PLUGINS -->
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			
			$('#sel_class').change(function(){
				var info = {
		    		sel_class: $('#sel_class').val(),
		    		_token: $('meta[name="csrf-token"]').attr('content')
		    	}
				$.ajax({
					type: "post",
		      		url: "{{url('/group/selClassAjax')}}",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	if(response.status == 'success'){
				    		
				    	}
			    	}
				});	
		    });

		    $("#delete").click(function() {
		    	$("#msgForm").attr("action", "/message/delete");
		    	$("#msgForm").submit();
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
                      min:0
                       
                },
                series: {
                    bars: {
                        show: true
                    }
                },
                bars: {
                    barWidth: 0.6,
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
		});
    </script>
@stop