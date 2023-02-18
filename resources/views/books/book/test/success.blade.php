@extends('layout')
@section('styles')
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
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> 受検
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">合格おめでとうございます！</h3>
							
			<div class="row margin-top-20">
				<div class="offset-md-1 col-md-10">
				    <input type="hidden" id="book_id" name="book_id" value="{{$bookId}}">
					<table class="table table-no-border table-hover">
						<tr>
							<td class="h4 text-md-right">合格した本のタイトル：</td>
							<td class="h4 text-md-left">{{$book->title}}</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">合格ポイント：</td>
							<td class="h4 text-md-left">{{floor($book->point*100)/100}}ポイント</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">受検に要した時間：</td>
							<td class="h4 text-md-left">
							 {{floor($test_time/60)}}分{{$test_time%60}}秒 /
							 {{floor($book->test_short_time/60)}}分{{$book->test_short_time%60}}秒 
							(全{{$quiz_count}}問)
							</td>
						</tr>
						@if($savetime == 1)
						<tr>
							<td class="h4 text-md-right">短時間加算ポイント：</td>
							<td class="h4 text-md-left">{{floor(($book->point/10)*100)/100}}ポイント</td>
						</tr>
						<tr>
							<td class="h4 text-md-right" style="color:red">合計：</td>
							<td class="h4 text-md-left" style="color:red">{{floor($book->point*100)/100 + floor(($book->point/10)*100)/100}}ポイントを取得しました。</td>
						</tr>
						@else
						<tr>
							<td class="h4 text-md-right" style="color:red">合計：</td>
							<td class="h4 text-md-left" style="color:red">{{floor($book->point*100)/100}}ポイントを取得しました。</td>
						</tr>
						@endif
						<tr>
							<td class="h4 text-md-right">続けて違う本を受検</td>
							<td class="text-md-left">
								<a href="{{url('/book/search')}}" class="btn btn-warning" style="margin-top: 5px; margin-bottom: 5px">本を検索して受検</a>
								<a href="{{url('/mypage/wish_list')}}" class="btn btn-warning" style="margin-top: 5px; margin-bottom: 5px">マイ書斎から受検</a>
							</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">終了してトップ画面に戻る</td>
							<td class="text-md-left">
								<a href="{{url('/')}}" class="btn btn-info" url="">読Qトップに戻る</a>
							</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">終了してログアウトする</td>
							<td class="text-md-left">
								<a href="{{route('logout')}}" class="btn btn-danger">終了してログアウト</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="about_bookModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title text-primary"><strong>合格者アンケート(必須）</strong></h3>
				</div>
				<div class="modal-body">
					<h5 class="text-md-center">この本は、みんなにおすすめしたい、良い本ですか？</h5>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-primary btn-yes">は　い</button>
					<button type="button" data-dismiss="modal" class="btn btn-warning btn-no">いいえ</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger btn-none modal-close">どちらともいえない</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script>
	   $(document).ready(function(){
			// var socket = io('http://192.168.1.51:3000');
			// var socket = io('http://localhost:3000');
			console.log("success page");
			var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
			var datas = {
				id: '<?php echo Auth::id(); ?>'
			};
			socket.emit('test-success-confirm', JSON.stringify(datas));
			socket.on('test-overseer', function(msg){
				console.log('test-overseer-test-success====>', msg);
				var data = JSON.parse(msg);
				if(data.test == 1){
					var datas = {
						id: '<?php echo Auth::id(); ?>'
					};
					socket.emit('test-success-confirm', JSON.stringify(datas));
				}
			});
		   

			history.pushState(null, null, location.href);
				window.onpopstate = function () {
				history.go(1);
			};


		
	   		// ajaxRegTest();
			$('body').addClass('page-full-width');
			$("#about_bookModal").modal({
   				backdrop: 'static',
				keyboard: false
			});

	            $(".btn-yes").click(function () {
	                postSuccess(1);
	            });

	            $(".btn-no").click(function () {
	                postSuccess(2);
	            });

	            $(".btn-none").click(function () {
	                postSuccess(3);
	            });
		});


		function postSuccess(angate) {
	            var params = "book_id=" + $("#book_id").val() + "&angate=" + angate;
	            $.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/book/test/post_success?" + params,
	                function(data, status){});
		}

		function ajaxRegTest() {
			var info = {
                book_id: $("#book_id").val(),
                passed_quiz_count: {{$quiz_count}},
                passed_test_time: {{$test_time}},
                passed_point: {{floor($passed_point*100)/100}},
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                type: "post",
                url: "{{url('/book/regTestSuccess')}}",
                data: info,

                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function (response){
                    if(response.status == 'success'){
                       
                        $("#success_form").submit();
                    } else if(response.status == 'failed') {
                    }
                },
                error: function (err) {
                    alert("error");
                    $(".failed-alert").css('display','block');
                }
            });
        }
    </script>
@stop
