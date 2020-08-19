@extends('layout')

@section('styles')
   <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
   <style>
   .table-scrollable > .table > thead > tr > th, .table-scrollable > .table > tbody > tr > th, .table-scrollable > .table > tfoot > tr > th, .table-scrollable > .table > tfoot > tr > th, .table-scrollable > .table > tfoot > tr > td{
		word-wrap: break-word !important;
		white-space: normal !important;
   }
   @media (max-width: 560px){
	   table{
		   width: 1024px !important;
	   }
   }
   </style>
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
	            	> <a href="{{url('/mypage/top')}}">
	                	 マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> 読みたい本リスト
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
					<h3 class="page-title caption col-md-11">読みたい本リスト</h3>
					@if(!$otherview_flag)
						@if ($age >= 15)
						<div class="tools" style="float:right;">
							<input type="checkbox" @if ($wishlists_is_public == 1)checked @endif class="make-switch" id="wishlists_is_public" data-size="small">
						</div>
						@else
						<div class="tools" style="float:right;">非公開</div>
						@endif
					@endif
				</div>
			</div>
			<form class="form-horizontal" action="d" method="post">
					{{csrf_field()}}
				<input type="hidden" name="book_id" id="book_id" value="">
				<div class="row">
					<div class="col-md-12" style="overflow-x: auto; min-width: 100%">	
						@if(!$otherview_flag)				
						<table class="table table-bordered table-hover" id="" width="100%">
							<thead>
								<tr class="blue">
									<th style="padding:0px;vertical-align:middle;" width="10%">リストに登録した日</th>
									<th style="vertical-align:middle" width="10%">タイトル</th>
									<th style="vertical-align:middle" width="10%">著者</th>
									<th style="vertical-align:middle" width="8%">ポイント</th>
									<th style="vertical-align:middle" width="25%">帯文</th>
									<th style="vertical-align:middle" width="12%">読み終わった日</th>
									<th style="vertical-align:middle" width="8%">この本を受検する</th>
									<th style="vertical-align:middle" width="10%">公開<br>非公開</th>
									<th style="vertical-align:middle" width="7%">リストから<br>削除</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								@foreach($wishlists as $item)
								<tr class="info text-md-center">
									<td class="align-middle text-md-center" width="10%">{{date_format(date_create($item->created_at),'Y/m/d')}}</td>
									<td class="align-middle" width="10%"><a @if($item->Book->active >= 3) href="{{url('/book/'.$item->Book->id.'/detail')}}" @endif>{{$item->Book->title}}</a></td>
									<td class="align-middle" width="10%"><a href="{{url('/book/search_books_byauthor?writer_id='.$item->Book->writer_id.'&fullname='.$item->Book->fullname_nick())}}">{{$item->Book->fullname_nick()}}</a></td>
									<td class="align-middle" width="8%">{{floor($item->Book->point*100)/100}}</td>
									<td class="align-middle text-md-left" width="25%">
										@foreach($item->Book->Articles as $key => $article)
											@if($key <= 1)
											{{$article->content}}<br>
											@endif
										@endforeach
									</td>
									<td class="align-middle" width="12%"><input type="text"  readonly name="finished_date" value="{{isset($item->finished_date)? date_format(date_create($item->finished_date),'Y/m/d'):''}}" wid="{{$item->id}}" id="finished_date" class="form-control date-picker" onchange="javascript:finishDate(this);"></td>
									<td class="align-middle" width="8%">
									@if($item->book->active == 6 && Auth::check() && (!$user->isGroup()) && ($item->Book->isAdult()) && !$user->isGroupSchoolMember() && $user->active==1)
										@if($user->getBookyear($item->Book->id) !== null)
										<span class="btn btn-info age_limit" >受検</span>
										@elseif($user->getDateTestPassedOfBook($item->Book->id) !== null || $user->getEqualBooks($item->Book->id) !== null)
										<span class="btn btn-info book_equal ">受検</span>
										@else
										<button type="button" id="{{$item->Book->id}}" class="test_btn btn btn-info">受検</button>
										@endif
									@else
										<span class="btn btn-info disabled">受検</span>
									@endif

									</td>
									<td class="align-middle" width="10%">@if ($age >= 15) <input type="checkbox" class="make-switch onebook" data-size="small" id="{{$item->id}}"  @if($item->is_public == 1)checked @endif> @else 非公開 @endif</td>
									<td class="align-middle" width="7%"><a href="{{url('/book/'.$item->Book->id.'/delete')}}">削除</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
						@else
						<table class="table table-bordered table-hover" @if ($age >= 15) id="wishlist_author_order2" @else id="wishlist_author_order3" @endif>
							<thead>
								<tr>
									<th class="col-md-3">タイトル</th>
									<th class="col-md-2">著者</th>
									<th class="col-md-1">ページ数</th>
									<th class="col-md-2">ポイント</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								@foreach($wishlists as $item)
								@if($item->is_public)
								<tr>
									<td width="50%" class="text-md-center align-middle"><a @if($item->Book->active >= 3) href="{{url('/book/'.$item->Book->id.'/detail')}}" @endif>{{$item->Book->title}}</a></td>
									<td width="20%" class="text-md-center align-middle"<a href="{{url('/book/search_books_byauthor?writer_id='.$item->Book->writer_id.'&fullname='.$item->Book->fullname_nick())}}">{{$item->Book->fullname_nick()}}</a></td>
									<td width="15%" class="text-md-center align-middle">{{$item->Book->pages}}</td>
									<td width="15%" class="text-md-center align-middle">{{floor($item->Book->point*100)/100}}</td>
								</tr>
								@endif
								@endforeach
							</tbody>
						</table>
						@endif
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は年齢制限のある本なので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
	<div class="modal fade" id="myfailedModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
	          <p>この本のクイズに2度目も不合格でしたので、3日間この本を受検できません。他の本の受検はできます。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
	<div class="modal fade" id="passModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は、すでに合格していますので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
	 
@stop
@section('scripts')
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
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

			@if($errors == "false")
				$('#myModal').modal('show');
			@endif
			@if($errors == "alert")
				$('#myfailedModal').modal('show');
			@endif
			@if($errors == "pass")
				$('#passModal').modal('show');
			@endif

			if($("#viceLogin").val() == "vice_log"){
	            $("#alert_text").html("{{config('consts')['MESSAGES']['ASSOCIATE_MEMBER_ALERT']}}");
	            $("#alertModal").modal();
	        }

			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});

			$("#wishlists_is_public").on('switchChange.bootstrapSwitch', function(){
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

			var info = {
			    	_token: $('meta[name="csrf-token"]').attr('content')
			}
			$(".onebook").on('switchChange.bootstrapSwitch', function(){
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/wish_list/setpublic/is_public/" + $(this).attr('id');
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


			$(".test_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/test') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".age_limit").click(function() {
				$('#myModal').modal('show');
			});

			$(".book_equal").click(function() {
				$('#passModal').modal('show');
			});
		});
		var handleDatePickers = function () {

	        if (jQuery().datepicker) {
	            $('.date-picker').datepicker({
	                rtl: Metronic.isRTL(),
	                orientation: "left",
	                autoclose: true,
	                language: 'ja'
	            });
	        }
	    }
		function finishDate(obj) {
            var info = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                finished_date: $(obj).val(),
                wish_id: $(obj).attr("wid")
            };
            var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/api/user/updateWishDate";
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
                success: function (response) {
                	
            		if(response.quizable == 'success'){
            			$('.test' + $(obj).attr("wid")).attr('href',"/book/"+$(".test" + $(obj).attr("wid")).attr('id')+"/test");
                		$('.test' + $(obj).attr("wid")).css('color','#64AED9');
//                    jQuery.uniform.update($(".test") + $(obj).attr("wid"));
            		}
            }
            });
		}
	    handleDatePickers();

	</script>

@stop