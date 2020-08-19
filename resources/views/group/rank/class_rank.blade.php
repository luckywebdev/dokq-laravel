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
		                > クラス対抗 読書量ランキング
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				クラス対抗：読書量ランキング
			</h3>
			
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control">
					@foreach ($classes as $class)
						<option  @if($class_selected['id'] == $class->id) selected  @endif id = '{{$class->id}}'>
							@if(isset($class->group_name) && $class->group_name != '' && $class->group_name != null){{$class->group_name}}@endif
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
											<td>{{$current_season['year']}}年度 冬</td>
											<td>{{$avg_point['winter']}}</td>
											<td>{{$rank_grade['winter']}}</td>
											<td>{{$rank_city['winter']}}</td>
											<td>{{$rank_province['winter']}}</td>
											<td>{{$rank_overall['winter']}}</td>
										</tr>
										<tr class="warning">
											<td>{{$current_season['year']}}年度 秋</td>
											<td>{{$avg_point['autumn']}}</td>
											<td>{{$rank_grade['autumn']}}</td>
											<td>{{$rank_city['autumn']}}</td>
											<td>{{$rank_province['autumn']}}</td>
											<td>{{$rank_overall['autumn']}}</td>
										</tr>
										<tr class="danger">
											<td>{{$current_season['year']}}年度 夏</td>
											<td>{{$avg_point['summer']}}</td>
											<td>{{$rank_grade['summer']}}</td>
											<td>{{$rank_city['summer']}}</td>
											<td>{{$rank_province['summer']}}</td>
											<td>{{$rank_overall['summer']}}</td>
										</tr>
										<tr class="warning">
											<td>{{$current_season['year']}}年度 春</td>
											<td>{{$avg_point['spring']}}</td>
											<td>{{$rank_grade['spring']}}</td>
											<td>{{$rank_city['spring']}}</td>
											<td>{{$rank_province['spring']}}</td>
											<td>{{$rank_overall['spring']}}</td>
										</tr>
										<tr class="danger">
											<td>{{$current_season['year']}}年度 累計</td>
											<td>{{$avg_point['year']}}</td>
											<td>{{$rank_grade['year']}}</td>
											<td>{{$rank_city['year']}}</td>
											<td>{{$rank_province['year']}}</td>
											<td>{{$rank_overall['year']}}</td>
										</tr>
										<tr class="warning">
											<td>生涯</td>
											<td>{{$avg_point['all']}}</td>
											<td>{{$rank_grade['all']}}</td>
											<td>{{$rank_city['all']}}</td>
											<td>{{$rank_province['all']}}</td>
											<td>{{$rank_overall['all']}}</td>
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
					<!-- <a href="@if(Auth::user()->role == config('consts')['USER']['ROLE']['PUPIL']){{url('/mypage/top')}} @else{{url('/')}}@endif" class="btn btn-info pull-right">戻　る</a> -->
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
		<form action={{url('/group/rank/1')}} id="selectClass" name="rank1-form" method = "GET">
					<input type="hidden" name="_token" value="{{ csrf_field()}}">
					<input type="hidden" name="class_id" id="class_id" value=""/>
		</form>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			@if($other_id != $user->id)
				$('body').addClass('page-full-width');
			@endif
			ComponentsDropdowns.init();
			$("select").change(function(){
				$("#class_id").val($(":selected").attr("id"));
				
				$("#selectClass").submit();
//				alert($(":selected").attr("id"));
			});
		});
    </script>
@stop