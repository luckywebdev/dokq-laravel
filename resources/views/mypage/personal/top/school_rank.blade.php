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
		                > 学校対抗 読書量ランキング
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
				学校対抗 読書量ランキング<br>
			</h3>
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box yellow">
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
											<th>獲得ポイント/1人</th>
											<th>市区町村内順位</th>
											<th>都道府県内順位</th>
											<th>全国順位</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<tr class="danger">
											<td>{{Date('Y')}}年度 冬</td>
											<td>{{$school_avg_point['winter']}}</td>
											<td>{{$school_rank_city['winter']}}</td>
											<td>{{$school_rank_province['winter']}}</td>
											<td>{{$school_rank_overall['winter']}}</td>
										</tr>
										<tr class="warning">
											<td>{{Date('Y')}}年度 秋</td>
											<td>{{$school_avg_point['autumn']}}</td>
											<td>{{$school_rank_city['autumn']}}</td>
											<td>{{$school_rank_province['autumn']}}</td>
											<td>{{$school_rank_overall['autumn']}}</td>
										</tr>
										<tr class="danger">
											<td>{{Date('Y')}}年度 夏</td>
											<td>{{$school_avg_point['summer']}}</td>
											<td>{{$school_rank_city['summer']}}</td>
											<td>{{$school_rank_province['summer']}}</td>
											<td>{{$school_rank_overall['summer']}}</td>
										</tr>
										<tr class="warning">
											<td>{{Date('Y')}}年度 春</td>
											<td>{{$school_avg_point['spring']}}</td>
											<td>{{$school_rank_city['spring']}}</td>
											<td>{{$school_rank_province['spring']}}</td>
											<td>{{$school_rank_overall['spring']}}</td>
										</tr>
										<tr class="danger">
											<td>{{Date('Y')}}年度 累計</td>
											<td>{{$school_avg_point['year']}}</td>
											<td>{{$school_rank_city['year']}}</td>
											<td>{{$school_rank_province['year']}}</td>
											<td>{{$school_rank_overall['year']}}</td>
										</tr>
										<tr class="warning">
											<td>{{Date('Y')-1}}年度</td>
											<td>{{$school_avg_point['year-1']}}</td>
											<td>{{$school_rank_city['year-1']}}</td>
											<td>{{$school_rank_province['year-1']}}</td>
											<td>{{$school_rank_overall['year-1']}}</td>
										</tr>
										<tr class="danger">
											<td>{{Date('Y')-2}}年度 </td>
											<td>{{$school_avg_point['year-2']}}</td>
											<td>{{$school_rank_city['year-2']}}</td>
											<td>{{$school_rank_province['year-2']}}</td>
											<td>{{$school_rank_overall['year-2']}}</td>
										</tr>
										<tr class="warning">
											<td>生涯</td>
											<td>{{$school_avg_point['all']}}</td>
											<td>{{$school_rank_city['all']}}</td>
											<td>{{$school_rank_province['all']}}</td>
											<td>{{$school_rank_overall['all']}}</td>
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
					<a href="{{url('/')}}" class="btn btn-info pull-right">戻　る</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
		});
    </script>
@stop