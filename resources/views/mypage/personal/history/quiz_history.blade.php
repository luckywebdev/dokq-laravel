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
	            	> 読Q活動の履歴
	            </li>
	            <li class="hidden-xs">
	            	> クイズ作成記録
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
					<h3 class="page-title caption col-md-11">作成クイズの認定記録</h3>
					@if(!$otherview_flag)			
					<div class="tools" style="float:right;">
						<input type="checkbox" @if ($quiz_allowed_record_is_public == 1)checked @endif class="make-switch" id="quiz_allowed_record_is_public" data-size="small">
					</div>
					@endif
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable table-scrollable-borderless scroller" style="height:400px;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
						<table class="table table-bordered table-hover" id="table-quiz-allowed-records">
							<thead>
								<tr class="blue">
									<th class="col-md-1">認定日</th>
									<th class="col-md-2">タイトル</th>
									<th class="col-md-1">著者</th>
									<th class="col-md-1">著者名ひらがな</th>
									<th class="col-md-3">クイズ</th>
									<th class="col-md-1">読Q本ID</th>
									<th class="col-md-1">クイズ№</th>
									<th class="col-md-2">得たポイント</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								@foreach ($allowed_quizes as $allowed_quiz)
								
								<tr class="info">
									<td>{{date_create($allowed_quiz->created_at)->format('Y/m/d')}}</td>
									<td><a @if($allowed_quiz->Book->active >= 3) href="{{url('book/' . $allowed_quiz->book_id . '/detail')}}" @endif class="font-blue-madison">{{$allowed_quiz->Book->title}}</a></td>
									<td><a href="{{url('/book/search_books_byauthor?writer_id=' . $allowed_quiz->Book->writer_id.'&fullname='.$allowed_quiz->Book->fullname_nick())}}" class="font-blue-madison">{{$allowed_quiz->Book->fullname_nick()}}</a></td>
									<td>{{$allowed_quiz->Book->fullname_yomi()}}</td>
									<td>@if($otherview_flag)
											******
										@else
										<?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $allowed_quiz->question); $st = str_replace_first("#", "</u>", $st); 
															$st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
															for($i = 0; $i < 30; $i++) {
															 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
																$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
															} echo $st  ?>
										@endif
									</td>
									<td><a @if($allowed_quiz->Book->active >= 3) href="{{url('book/' . $allowed_quiz->book_id . '/detail')}}" @endif class="font-blue-madison">dq{{$allowed_quiz->book_id}}</a></td>
									<td>{{$allowed_quiz->doq_quizid}}</td>
									<td>{{floor($allowed_quiz->point*100)/100}}</td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-3">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
	<!-- <script src="{{asset('js/quiz-allowed-records.js')}}"></script> -->
	<script>
		jQuery(document).ready(function() {
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
		});   
	</script>
@stop