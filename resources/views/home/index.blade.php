@extends('layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/slider-revolution-slider/rs-plugin/css/settings.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/style-revolution-slider.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
@stop
@section('breadcrumb')
@stop
@section('contents')
    @include('home.slider')

	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="row">
			<div class="col-sm-3">
				<div class="news-blocks">
					<div class="news-block-tags">
						<h5><span class="caption-subject theme-font font-red bold uppercase">New!</span>&nbsp;&nbsp;&nbsp;
						<span class="caption-subject theme-font bold">新しい読Q本</span></h5>
					</div>
					@if(count($newBooks))
                    @foreach($newBooks as $newBook)
                    <p><a href="/book/search_one/{{$newBook->id}}">{{$newBook->title}}</a></p>
                    @endforeach
					@endif

					<a href="{{url('/book/search/latest1')}}" class="news-block-btn font-blue">もっと見る</a>

				</div>
			</div>

			<div class="col-md-6">
				<!-- BEGIN PORTLET-->
				<div class="portlet light bordered">
					<div class="portlet-body">
						<div class="slimScrollDiv scroller" style="position: relative; overflow: hidden; width: auto; height: 130px;">
						<div class="scroller" style="height: auto; overflow: hidden; width: auto; padding-bottom: 15px;" data-always-visible="1" data-rail-visible="0" data-initialized="1" id="notice_content">
							<ul class="feeds">
							    @foreach($notices as $notice)
								<li>
									<!-- <a href="#"> -->
										<div class="col1">
											<div class="date">
												  {{date_format($notice->updated_at,"Y")."-".date_format($notice->updated_at,"m")."-".date_format($notice->updated_at,"d")}}
											</div>
										</div>
										<div class="col2">
											<div class="cont">
												<div class="cont-col2">
													<div class="desc">
														{{$notice->content}}
													</div>
												</div>
											</div>
										</div>
										@if($notice->outside_link != '')
										<div class="col2" style="display: flex; flex-direction: column; align-items: flex-start">
											<div class="cont">
												<div class="cont-col2">
													<div class="desc">
														詳細については下記URLをクリック！
													</div>
												</div>
											</div>
											<div class="cont">
												<div class="cont-col2">
													<div class="desc">
														<a href="{{$notice->outside_link}}" target="__blank">{{$notice->outside_link}}</a>
													</div>
												</div>
											</div>
										</div>
										@endif
									<!-- </a> -->
								</li>
								@endforeach
							</ul>
						
						</div>
						<div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 39px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 190.873px;"></div>
						<div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
						<div class="scroller-footer">
							<div class="btn-arrow-link pull-right">
								@if(count($notices))
								<a style="cursor: pointer; color: #337ab7" id="notice_more_less">もっと見る</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->
			</div>
			<div class="col-sm-3">
				<div class="news-blocks">
					<div class="news-block-tags">
						<h5><span class="caption-subject theme-font bold">クイズ募集中の本</span></h5>
					</div>
					@if(count($quizBooks))
                    @foreach($quizBooks as $book)
                    <p><a href="/book/search_one/{{$book->id}}">{{$book->title}}</a></p>
                    @endforeach
                    <a href="{{url('/book/quizbook')}}" class="news-block-btn font-blue">もっと見る</a>
					@endif
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<div class="news-blocks">
					<div class="news-block-tags">
						<h5><span class="caption-subject theme-font bold">監修者募集中の本</span></h5>
					</div>
					@if(count($obBooks))
	                    @foreach($obBooks as $book)
	                    <p><a href="/book/search_one/{{$book->id}}">{{$book->title}}</a></p>
	                    @endforeach
                    
					@endif
					@if(count($obBooks) && Auth::check())
						<a href="{{url('/mypage/demand_list')}}" class="news-block-btn font-blue">もっと見る</a>
					@endif

				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-sm-4 rank-layout1">
						<div class="top-news">
							<a href="@if(Auth::check() && Auth::user()->isGroupSchoolMember()){{url('/group/rank/1')}}@elseif(Auth::check() && Auth::user()->isAdmin()){{url('/admin/book_ranking')}}@elseif(Auth::check() && Auth::user()->isPupil()){{url('/mypage/rank_child_pupil')}}@elseif(Auth::check() && Auth::user()->isPupil()){{url('/mypage/rank_child_pupil')}}@else{{url('mypage/rank_by_age')}}@endif" class="btn btn-danger">
								<span style="text-align:center;">読Qポイント順位</span>
							</a>
						</div>
					</div>
					<div class="col-sm-4 rank-layout2">
						<div class="top-news text-md-center">
							<a href="{{url('/mypage/book_ranking')}}" class="btn blue">
								<span style="text-align:center;">読書量ランキング100</span>
							</a>
						</div>
					</div>
					<div class="col-sm-4 rank-layout3">
						<div class="top-news text-md-center">
							<a href="{{url('/mypage/oversee_test')}}" class="btn purple">
								<span style="text-align:center;">試験監督をする</span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 text-left" style="display: flex; justify-content: center">
						<div class="top-news">
							<?php echo $advertise->top_page_left; ?>
						</div>
					</div>
					<div class="col-sm-6 text-right" style="display: flex; justify-content: center">
						<div class="top-news">
							<?php echo $advertise->top_page_right; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption">
							読書認定書閲覧はこちら
						</div>
					</div>
					<div class="portlet-body">
						<div class="row text-md-left" style="text-align:left">
							<label class="control-label offset-md-2 col-md-8">パスコード入力</label>
						</div>
						<div class="row">
							<div class="input-group offset-md-2 col-md-8 col-xs-12">
								<form class="form register-form"  id="validate-form" method="get" role="form" action="{{url('/mypage/passcode')}}">
								{{ csrf_field() }}
									<div class="show-xs col-md-2 col-xs-1" style="padding:0px;"></div>
									<div class="col-md-8 col-xs-7" style="padding:0px;">
										<input type="password" class="form-control" name="pwd" id="pwd">
									</div>
									<div class="col-md-4 col-xs-4" style="padding:0px;">
										<button type="button" class="btn btn-primary pull-left" id="pwd_checker" disabled>送　信</button>
									</div>
								</form>

							</div>
						</div>
						<div class="form-group row">
						@if($errors->has('invalid_pwd') || $errors->has('passcode_error'))
							<h5 class="offset-md-2 col-md-10 text-md-left" style="color:#f00;">パスコードが間違っています。</h5>
						<!-- @elseif($errors->has('passcode_error'))
							<h5 class="offset-md-2 col-md-10 text-md-left" style="color:#f00;">認定書の有効期限が切れてされました。</h5> -->
						@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-md-12">
				@if (Auth::check() && Auth::user()->isAdmin() && $self_evaluation != null && $self_evaluation->evaluation_button_url != '')
					<a href="{{url($self_evaluation->self_evaluation_sheet_url)}}" target="__blank" style="width: 200px; height: 60px">
						<img src="{{$self_evaluation->evaluation_button_url}}" alt="" style="width: 200px; height: 60px">
					</a>
				@endif
			</div>
		</div> -->
		</div>
	</div>
	
@stop
@section('scripts')
    <script type="text/javascript" src="{{asset('plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/revo-slider-init.js')}}"></script>
    <script>
        RevosliderInit.initRevoSlider();
		var notice = 0;
        $(function () {
            $('body').addClass('page-full-width');
        });

        @if($errors->has('invalid_pwd'))
        	window.scrollTo(100,document.lastChild.offsetHeight);
        @endif
		//init socket 
		var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
		//login view in 一括操作
		var msgloginid = '{!! Request::session()->get('msglogin') !!}';
		console.log("msg_id===>", msgloginid);
		if(msgloginid != '' && msgloginid !== null){
			var msglogin = '{!! Request::session()->put('msglogin', '') !!}';
			console.log("msglogin==>", msglogin);
			var data = {
				logedin_id: msgloginid
			}
			socket.emit('msglogin', JSON.stringify(data));
		}
		//logout view in 一括操作
		var msglogoutid = '{!! Request::session()->get('msglogout') !!}';
		if(msglogoutid != '' && msglogoutid !== null){
			var msglogout = '{!! Request::session()->put('msglogout', '') !!}';
			console.log("msglogout==>", msglogout);
			var data = {
				logedout_id: msglogoutid
			}
			socket.emit('msglogout', JSON.stringify(data));
		}

		$('#pwd_checker').click(function(){
			$('#validate-form').submit();
		});
		$('#pwd').keyup(function(){
			var pwd = $("#pwd").val();
			
			if(pwd.length > 0){
            	$("#pwd_checker").removeAttr("disabled");
            }else{
            	$("#pwd_checker").attr('disabled', true);
            }
			
			
		});

		$("#notice_more_less").click(function(){
			var url = "{{url('/get_notice')}}"
			if(notice == 0){
				$.ajax({
					type: "GET",
					cache: false,
					url: url,
					data: {notice: 1},
					dataType: "JSON",
					success: function(res){
						// var res_notice = JSON.parse(res);
						console.log(res);
						var content = '';
						content += '<ul class="feeds">';
						for(x in res){
							var notice_res = res[x];
							content += '<li>';
							// content += '<a href="#">';
							content += '<div class="col1">';
							content += '<div class="date">';
							var notice_date = notice_res.updated_at.split(" ")[0];
							content += notice_date;
							content += '</div>';
							content += '</div>';
							content += '<div class="col2">';
							content += '<div class="cont">';
							content += '<div class="cont-col2">';
							content += '<div class="desc">';
							content += notice_res.content;
							content += '</div>';
							content += '</div>';
							content += '</div>';
							content += '</div>';
							// content += '</a>';
							content += '</li>';
						}
						content += '</ul>';
						$("#notice_content").html(content);
						$("#notice_more_less").text('戻る')
						notice = 1;
					}
				});
			}
			else{
				$.ajax({
					type: "GET",
					cache: false,
					url: url,
					data: {notice: 0},
					dataType: "JSON",
					success: function(res){
						var content = '';
						content += '<ul class="feeds">';
						for(x in res){
							var notice_res = res[x];
							content += '<li>';
							// content += '<a href="#">';
							content += '<div class="col1">';
							content += '<div class="date">';
							var notice_date = notice_res.updated_at.split(" ")[0];
							content += notice_date;
							content += '</div>';
							content += '</div>';
							content += '<div class="col2">';
							content += '<div class="cont">';
							content += '<div class="cont-col2">';
							content += '<div class="desc">';
							content += notice_res.content;
							content += '</div>';
							content += '</div>';
							content += '</div>';
							content += '</div>';
							// content += '</a>';
							content += '</li>';
						}
						content += '</ul>';
						$("#notice_content").html(content);
						$("#notice_more_less").text('もっと見る')
						notice = 0;
					}
				});
			}
		})
    </script>
@stop