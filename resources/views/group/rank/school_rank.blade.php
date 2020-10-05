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
		                > 学年単位 読書量ランキング
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
				学年：読書量ランキング
			</h3>
			
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control" name="selgrade" id="selgrade">
						@foreach ($grades as  $key=>$grade)
						<option value="{{$key+1}}" @if($selected_grade['id'] == $key+1) selected @endif  id = '{{$key+1}}' grade='{{$grade->grade}}' gid='{{$grade->group_id}}' syear='{{$grade->year}}'>@if(Auth::user()->role == config('consts')['USER']['ROLE']['LIBRARIAN']){{$grade->group_name}}@else{{$schoolName}}@endif {{$grade->grade == 0?'無':$grade->grade}}年生 / {{$grade->year}}年度 </option>
						@endforeach
					</select>
				</div>
				<div class="col-md-4 text-md-center">（同学年内順位）
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
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
											<th>獲得ポイント/1人&nbsp;&nbsp;<span style="font-size:12px">(学年平均）</th>
											<th>市区町村内順位</th>
											<th>都道府県内順位</th>
											<th>全国順位</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<tr class="danger">
											<td>{{$current_season['year']}}年度 冬</td>
											<td>{{$current_season['term'] >= 3 ? $grade_avg_point['winter'] : '-'}}</td>
											<td>{{$current_season['term'] >= 3 ? $grade_rank_city['winter'] : '-'}}</td>
											<td>{{$current_season['term'] >= 3 ? $grade_rank_province['winter'] : '-'}}</td>
											<td>{{$current_season['term'] >= 3 ? $grade_rank_overall['winter'] : '-'}}</td>
										</tr>
										<tr class="warning">
											<td>{{$current_season['year']}}年度 秋</td>
											<td>{{$current_season['term'] >= 2 ? $grade_avg_point['autumn'] : '-'}}</td>
											<td>{{$current_season['term'] >= 2 ? $grade_rank_city['autumn'] : '-'}}</td>
											<td>{{$current_season['term'] >= 2 ? $grade_rank_province['autumn'] : '-'}}</td>
											<td>{{$current_season['term'] >= 2 ? $grade_rank_overall['autumn'] : '-'}}</td>
										</tr>
										<tr class="danger">
											<td>{{$current_season['year']}}年度 夏</td>
											<td>{{$current_season['term'] >= 1 ? $grade_avg_point['summer'] : '-'}}</td>
											<td>{{$current_season['term'] >= 1 ? $grade_rank_city['summer'] : '-'}}</td>
											<td>{{$current_season['term'] >= 1 ? $grade_rank_province['summer'] : '-'}}</td>
											<td>{{$current_season['term'] >= 1 ? $grade_rank_overall['summer'] : '-'}}</td>
										</tr>
										<tr class="warning">
											<td>{{$current_season['year']}}年度 春</td>
											<td>{{$current_season['term'] >= 0 ? $grade_avg_point['spring'] : '-'}}</td>
											<td>{{$current_season['term'] >= 0 ? $grade_rank_city['spring'] : '-'}}</td>
											<td>{{$current_season['term'] >= 0 ? $grade_rank_province['spring'] : '-'}}</td>
											<td>{{$current_season['term'] >= 0 ? $grade_rank_overall['spring'] : '-'}}</td>
										</tr>
										<tr class="danger">
											<td>{{$current_season['year']}}年度 累計</td>
											<td>{{$grade_avg_point['year']}}</td>
											<td>{{$grade_rank_city['year']}}</td>
											<td>{{$grade_rank_province['year']}}</td>
											<td>{{$grade_rank_overall['year']}}</td>
										</tr>
										<tr class="warning">
											<td>生涯</td>
											<td>{{$grade_avg_point['all']}}</td>
											<td>{{$grade_rank_city['all']}}</td>
											<td>{{$grade_rank_province['all']}}</td>
											<td>{{$grade_rank_overall['all']}}</td>
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
		<form action={{url('/group/rank/2')}} id="selectGrade" name="rank2-form" method = "GET">
					<!-- <input type="hidden" name="_token" value="{{ csrf_field()}}"> -->
					<input type="hidden" name="ids" id="ids" value=""/>
					<input type="hidden" name="grade" id="grade" value=""/>
					<input type="hidden" name="group_id" id="group_id" value=""/>
					<input type="hidden" name="sel_year" id="sel_year" value=""/>
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
				// alert($(":selected").attr("grade"));
				$("#ids").val($(":selected").attr("id"));
				$("#grade").val($(":selected").attr("grade"));
				$("#group_id").val($(":selected").attr("gid"));
				$("#sel_year").val($(":selected").attr("syear"));
				$("#selectGrade").submit();
//				alert($(":selected").attr("id"));
			});
		});
    </script>
@stop