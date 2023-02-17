@extends('layout')

@section('styles')
   <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="{{url('/mypage/top')}}">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 読Qポイント順位
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4"></div>
					<div class="col-md-5" >
						<div class="row " align="left">
							<h4 class="page-title">読Qポイント順位</h4>
							<h6  style="padding-left:15px;">（同学年内）</h6>
						</div>
					</div> 
					<div class="col-md-1">
						<input type="checkbox" @if ($point_ranking_is_public == 1)checked @endif class="make-switch" id="point_ranking_is_public" data-size="small">
					</div>
					<div class="col-md-2">
						<h6 class="pull-right">{{date('Y年m月d日')}}現在</h6>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="" style="background: #F78E1F; color: #FFF; font-weight: 400">
								<th class="col-md-2"></th>
								<th class="col-md-1">自分の<br>ポイント</th>
								<th class="col-md-1">クラス内順位<br>(位 / 人)</th>
								<th class="col-md-1">学年順位<br>(位 / 人)</th>
								<th class="col-md-2">市区町村内順位<br>(位 / 人)</th>
								<th class="col-md-2">都道府県内順位<br>(位 / 人)</th>
								<th class="col-md-2">全国順位<br>(位 / 人)</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							<tr class="warning text-md-center">
								<td class="align-middle">{{$current_season['season']}} {{$current_season['from_num']}}~{{$current_season['to_num']}}<br>(今　四半期)</td>
								<td class="align-middle">
								@if(isset($mysumpoint['this_season']->sum)){{floor($mysumpoint['this_season']->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[0]['class']}}/{{$count[0]['class']}}</td>
								<td class="align-middle">{{$myrank[0]['grade']}}/{{$count[0]['grade']}}</td>
								<td class="align-middle">{{$myrank[0]['city']}}/{{$count[0]['city']}}</td>
								<td class="align-middle">{{$myrank[0]['province']}}/{{$count[0]['province']}}</td>
								<td class="align-middle">{{$myrank[0]['nation']}}/{{$count[0]['nation']}}</td>
							</tr>
							<tr class="text-md-center">
								<td class="align-middle">{{$before_season['season']}} {{$before_season['from_num']}}~{{$before_season['to_num']}}<br>（前　四半期）</td>
								<td class="align-middle">
								@if(isset($mysumpoint['before_season']->sum)){{floor($mysumpoint['before_season']->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[1]['class']}}/{{$count[1]['class']}}</td>
								<td class="align-middle">{{$myrank[1]['grade']}}/{{$count[1]['grade']}}</td>
								<td class="align-middle">{{$myrank[1]['city']}}/{{$count[1]['city']}}</td>
								<td class="align-middle">{{$myrank[1]['province']}}/{{$count[1]['province']}}</td>
								<td class="align-middle">{{$myrank[1]['nation']}}/{{$count[1]['nation']}}</td>
							</tr>
							<tr class="warning text-md-center">
								<td class="align-middle">{{$current_season['year']}}年度<br>（今年度通算）</td>
								<td class="align-middle">
								@if(isset($mysumpoint['this_year']->sum)){{floor($mysumpoint['this_year']->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[2]['class']}}/{{$count[2]['class']}}</td>
								<td class="align-middle">{{$myrank[2]['grade']}}/{{$count[2]['grade']}}</td>
								<td class="align-middle">{{$myrank[2]['city']}}/{{$count[2]['city']}}</td>
								<td class="align-middle">{{$myrank[2]['province']}}/{{$count[2]['province']}}</td>
								<td class="align-middle">{{$myrank[2]['nation']}}/{{$count[2]['nation']}}</td>
							</tr>
							<tr class="text-md-center">
								<td class="align-middle">{{$current_season['year']-1}}年度<br>（前年度）</td>
								<td class="align-middle">
								@if(isset($mysumpoint['before_year']->sum)){{floor($mysumpoint['before_year']->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[3]['class']}}/{{$count[3]['class']}}</td>
								<td class="align-middle">{{$myrank[3]['grade']}}/{{$count[3]['grade']}}</td>
								<td class="align-middle">{{$myrank[3]['city']}}/{{$count[3]['city']}}</td>
								<td class="align-middle">{{$myrank[3]['province']}}/{{$count[3]['province']}}</td>
								<td class="align-middle">{{$myrank[3]['nation']}}/{{$count[3]['nation']}}</td>
							</tr>
							<tr class="warning text-md-center">
								<td class="align-middle" style="padding-left:0px;padding-right:0px;">生涯<br>（現在まで累計）</td>
								<td class="align-middle">
								@if(isset($mysumpoint['all']->sum)){{floor($mysumpoint['all']->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[4]['class']}}/{{$count[4]['class']}}</td>
								<td class="align-middle">{{$myrank[4]['grade']}}/{{$count[4]['grade']}}</td>
								<td class="align-middle">{{$myrank[4]['city']}}/{{$count[4]['city']}}</td>
								<td class="align-middle">{{$myrank[4]['province']}}/{{$count[4]['province']}}</td>
								<td class="align-middle">{{$myrank[4]['nation']}}/{{$count[4]['nation']}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="offset-md-5 col-md-2">
					<!-- <button type="button" class="btn btn-warning">グラフで見る</button> -->
					<a type="button" class="btn btn-warning" href="{{url('/mypage/rank_graph/'.$id.'?otherview_flag='.$otherview_flag)}}">グラフで見る</a>
				</div>
				<div class="col-md-5">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});
			$(".make-switch").on('switchChange.bootstrapSwitch', function(event, state){
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
						console.log(response);
			    	}
				});
			});

			@if($otherview_flag)
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
			@endif
		});

	</script>

@stop