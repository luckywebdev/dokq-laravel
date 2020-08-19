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
	            	> 読書推進活動ランキング
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
					<h3 class="page-title col-md-11">読書推進活動ランキング<br></h3>
					<input type="checkbox" class="make-switch col-md-1" @if ($register_point_ranking_is_public == 1)checked @endif id="register_point_ranking_is_public" data-size="small">
				</div>
			</div>
			<div class="row margin-top-10 margin-bottom-20">
				<label class="text-md-right col-md-5 control-label">自分と比較する年代設定</label>
				<div class="col-md-2">
					<select id="compareYear" name="compareYear" class="bs-select form-control"  @if($otherview_flag) disabled="true" @endif>
						<option id="1" value="1" @if($ranking_age == 1) selected @endif>小学生</option>
						<option id="2" value="2" @if($ranking_age == 2) selected @endif>中学生</option>
						<option id="3" value="3" @if($ranking_age == 3) selected @endif>高校生</option>
						<option id="4" value="4" @if($ranking_age == 4) selected @endif>大学生</option>
						<option id="5" value="5" @if($ranking_age == 5) selected @endif>10代後半</option>
						<option id="6" value="6" @if($ranking_age == 6) selected @endif>20代</option>
						<option id="7" value="7" @if($ranking_age == 7) selected @endif>30代</option>
						<option id="8" value="8" @if($ranking_age == 8) selected @endif>40代</option>
						<option id="9" value="9" @if($ranking_age == 9) selected @endif>50代</option>
						<option id="10" value="10" @if($ranking_age == 10) selected @endif>60代</option>
						<option id="11" value="11" @if($ranking_age == 11) selected @endif>70代</option>
						<option id="12" value="12" @if($ranking_age == 12) selected @endif>80代以降</option>
						<option id="13" value="13" @if($ranking_age == 13) selected @endif>全ての年代</option>
					</select>
				</div>
				<div class="col-md-5">
					<h6 class="pull-right">{{date('Y年m月d日')}}現在</h6>
				</div>
			</div>
			<form action="@if($otherview_flag) {{url('/mypage/rank_bq/'.$id)}}@else{{url('/mypage/rank_bq')}}@endif" method="get" id="rankingage_form">
				<input type="hidden" name="ranking_age" id="ranking_age" value="">
			</form>
			<div class="row">
				<div class="col-md-12">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="blue">
								<th class="col-md-2 align-middle">本の登録とクイズ作成</th>
								<th class="col-md-2 align-middle">自分の読書推進ポイント</th>
								<th class="col-md-1 align-middle">市区町村内順位<br>(位 / 人)</th>
								<th class="col-md-1 align-middle">都道府県内順位<br>(位 / 人)</th>
								<th class="col-md-1 align-middle">全国順位<br>(位 / 人)</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							<tr class="warning" id="curQuarter">
								<td class="align-middle">{{$current_season['season']}} {{$current_season['from_num']}}~{{$current_season['to_num']}}<br>(今　四半期)</td>
								<td class="align-middle">
								@if(isset($mysumpoint[0]->sum)){{floor($mysumpoint[0]->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[0]['city']}}/{{$count['city']}}</td>
								<td class="align-middle">{{$myrank[0]['province']}}/{{$count['province']}}</td>
								<td class="align-middle">{{$myrank[0]['nation']}}/{{$count['nation']}}</td>
							</tr>
							<tr id="preQuarter">
								<td class="align-middle">{{$before_season['season']}} {{$before_season['from_num']}}~{{$before_season['to_num']}}<br>（前　四半期）</td>
								<td class="align-middle">
								@if(isset($mysumpoint[1]->sum)){{floor($mysumpoint[1]->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[1]['city']}}/{{$count['city']}}</td>
								<td class="align-middle">{{$myrank[1]['province']}}/{{$count['province']}}</td>
								<td class="align-middle">{{$myrank[1]['nation']}}/{{$count['nation']}}</td>
							</tr>
							<tr class="warning" id="curYear">
								<td class="align-middle">{{$current_season['year']}}年度<br>（今年度通算）</td>
								<td class="align-middle">
								@if(isset($mysumpoint[2]->sum)){{floor($mysumpoint[2]->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[2]['city']}}/{{$count['city']}}</td>
								<td class="align-middle">{{$myrank[2]['province']}}/{{$count['province']}}</td>
								<td class="align-middle">{{$myrank[2]['nation']}}/{{$count['nation']}}</td>
							</tr>
							<tr id="lastYear">
								<td class="align-middle">{{$current_season['year']-1}}年度<br>（前年度）</td>
								<td class="align-middle">
								@if(isset($mysumpoint[3]->sum)){{floor($mysumpoint[3]->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[3]['city']}}/{{$count['city']}}</td>
								<td class="align-middle">{{$myrank[3]['province']}}/{{$count['province']}}</td>
								<td class="align-middle">{{$myrank[3]['nation']}}/{{$count['nation']}}</td>
							</tr>
							<tr class="warning" id="allQuiz">
								<td class="align-middle">生涯<br>（現在まで累計）</td>
								<td class="align-middle">
								@if(isset($mysumpoint[4]->sum)){{floor($mysumpoint[4]->sum*100)/100}}
								@else 
									0
								@endif
								</td>
								<td class="align-middle">{{$myrank[4]['city']}}/{{$count['city']}}</td>
								<td class="align-middle">{{$myrank[4]['province']}}/{{$count['province']}}</td>
								<td class="align-middle">{{$myrank[4]['nation']}}/{{$count['nation']}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
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


			ComponentsDropdowns.init();
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
			$("select").change(function(){
				$("#ranking_age").val($(this).val());
				$('#rankingage_form').submit();
				})
			
			changeYear();
			
			$("#compareYear").change(function(){
				changeYear();
			});

			function changeYear() {
				
				$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/rank_bq?compareYear=" + $('#compareYear').val(),
					
					function(data, status){
							//alert(data);
							
							var res = JSON.parse(data);

					    	//今　四半期
							curQuarter = res.curQuarter;
							arr = curQuarter.split(",");
							$("#curQuarter td:nth-child(1)").html(arr[0]);
							// $("#curQuarter td:nth-child(2)").html(arr[1]);

					    	//前　四半期
							preQuarter = res.preQuarter;
							arr = preQuarter.split(",");
							$("#preQuarter td:nth-child(1)").html(arr[0]);
							// $("#preQuarter td:nth-child(2)").html(arr[1]);
							// $("#preQuarter td:nth-child(3)").html(arr[2]);
							// $("#preQuarter td:nth-child(4)").html(arr[3]);

							//今年度通算
							curYear = res.curYear;
							arr = curYear.split(",");
							$("#curYear td:nth-child(1)").html(arr[0]);
							// $("#curYear td:nth-child(2)").html(arr[1]);
							// $("#curYear td:nth-child(3)").html(arr[2]);
							// $("#curYear td:nth-child(4)").html(arr[3]);

							//前年度通算
							lastYear = res.lastYear;
							arr = lastYear.split(",");
							$("#lastYear td:nth-child(1)").html(arr[0]);
							// $("#lastYear td:nth-child(2)").html(arr[1]);
							// $("#lastYear td:nth-child(3)").html(arr[2]);
							// $("#lastYear td:nth-child(4)").html(arr[3]);
							
							
							//現在まで累計
							allRank = res.allRank;
							arr = allRank.split(",");
							// $("#allQuiz td:nth-child(2)").html(arr[0]);
							
							
					});
			}
		});
    </script>
@stop