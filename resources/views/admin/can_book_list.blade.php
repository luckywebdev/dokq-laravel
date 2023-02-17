@extends('layout')

@section('styles')
    <style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
		}
	</style>
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
			            > 	<a href="{{url('/top')}}">協会トップ</a>
		            </li>
		            <li class="hidden-xs">
	                	> 候補本リスト（未審査）
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">候補本リスト（未審査）</h3>
			<h3 class="page-title">認定後、監修者募集とクイズ募集ページへ</h3>
			
			<div class="row">
				<div class="col-md-12">
					@if(isset($message))
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							{{$message}}
						</p>
					</div>
					@endif
					<table class="table table-hover table-bordered">
					    <thead>
					      <tr class="success">
					        <th class="col-md-1" style="padding:0px">受付日</th>
					        <th class="col-md-1" style="padding:0px">作成者<br>（掲載する名）</th>
					        <th class="col-md-2" style="padding:0px">タイトル</th>
					        <th class="col-md-1" style="padding:0px">著者</th>
					        <th class="col-md-1" style="padding:0px">読Q本ID</th>					        
					        <th class="col-md-2" style="padding:0px">推奨年代</th>
					        <th class="col-md-1" style="padding:0px">算出ポイント</th>
					        <th class="col-md-1" style="padding:0px">クイズス<br>トック数</th>
					        <th class="col-md-1" style="padding:0px">
					        		詳細を見る<br>（認定審査<br>画面へ）
					        </th>
					        <th class="col-md-1" style="padding:0px">認定・却下</th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							@foreach ($books as $book)
							<tr>
								<td style="vertical-align:middle">{{ with($book->created_at)->format('Y/m/d') }}</td>
								<td style="vertical-align:middle">@if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)<a id="user_a" href="{{url('mypage/other_view/' . $book->Register->id)}}" class="font-blue" oncontextmenu="handleRightClick('{{$book->Register->id}}','{{$book->Register->email}}','{{$book->Register->active}}'); return false;">{{ $book->register_visi_type == 0? $book->Register->fullname(): $book->Register->username }}</a>@endif</td>
								<td style="vertical-align:middle"><a id="book_a" @if($book->active >= 3) href="{{url('/book/' . $book->id . '/detail')}}" class="font-blue" @endif   oncontextmenu="handlebookRightClick('{{$book->id}}','{{$book->active}}'); return false;">{{$book->title}}</a></td>
								<td style="vertical-align:middle"><a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue">{{$book->fullname_nick()}}</a></td>
								<td style="vertical-align:middle">@if($book->active >= 3 && $book->active < 7)dq{{$book->id}}@endif</td>
								<td style="vertical-align:middle">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
								<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
								<td style="vertical-align:middle">{{$book->PendingQuizes()->count()}}</td>
								<td>
									<a href="{{url('/admin/can_book_a/'.$book->id)}}">詳細を見る</a>
								</td>
								<td>
									@if($book->active >= 3)認定@endif
									@if($book->active == 2)却下@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{ $books->links() }}
				</div>
			</div>
			<div id="popup" style="display:none;z-index:1000;">
               <div id="email_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a href='#' >Eメールを送る</a></div>  
               <div id="userdata_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a  href="javascript:;" style='pointer-events:none;color:#757b87;'>データ画面へ遷移</a></div>    
		    </div>
		    <div id="bookpopup" style="display:none;z-index:1001;">
                 <div id="bookdata_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a  href="javascript:;" style='pointer-events:none;color:#757b87;'>読Q本カードへ遷移</a></div> 
                 <div id="quizdata_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a  href="javascript:;" style='pointer-events:none;color:#757b87;'>クイズ情報</a></div>  
		    </div>
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>

@stop
@section('scripts')
	<script type="text/javascript">
	function handleRightClick(user_id, user_email, user_active) {
         
		var str="<a href='mailto:"+user_email+"' style='color:#757b87;'>Eメールを送る</a>"	
		$("#email_tag").html(str);
		
		if(user_active == 1){
			var str="<a href='/admin/personaldata/"+user_id+"' style='color:#757b87;'>データ画面へ遷移</a>"	
			$("#userdata_tag").html(str);
		}

     };
    function handlebookRightClick(book_id, book_active) {
        
		if(book_active >= 1){
			var str="<a href='/admin/bookdata/"+book_id+"' style='color:#757b87;'>読Q本カードへ遷移</a>"	
			$("#bookdata_tag").html(str);
			var str="<a href='/admin/quizdata/"+book_id+"' style='color:#757b87;'>クイズ情報</a>"	
			$("#quizdata_tag").html(str);
		}

     };     
	$(function () {
       
  		var $contextMenu = $("#contextMenu");
  		$("body").click(function(){
		    $("#popup").hide();
		    $("#bookpopup").hide();
		});
		$("body").on("contextmenu", "a#user_a", function(e) {
		    $contextMenu.css({
		      display: "block",
		      left: e.pageX,
		      top: e.pageY
		    });
		   
		    $("#popup").show();
		    $("#popup").css("position","absolute");
		    $("#popup").css("left",e.pageX-30);
		    $("#popup").css("top",e.pageY-120);
		    return false;
		});
		$("body").on("contextmenu", "a#book_a", function(e) {
		    $contextMenu.css({
		      display: "block",
		      left: e.pageX,
		      top: e.pageY
		    });
		   
		    $("#bookpopup").show();
		    $("#bookpopup").css("position","absolute");
		    $("#bookpopup").css("left",e.pageX-30);
		    $("#bookpopup").css("top",e.pageY-120);
		    return false;
		});
	});
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop