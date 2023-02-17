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
                        >   <a href="{{url('/top')}}">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 協会の基本情報
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">協会の基本情報(メンバーリスト)</h3>
			
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover table-bordered">
					    <thead>
					      <tr class="blue">
					        <th class="col-md-2" style="padding:0px">協会メンバーの<br>読Qネーム</th>
					        <th class="col-md-2" style="padding:0px">送信専用<br>メールアドレス</th>
					        <th class="col-md-2" style="padding:0px">個別用<br>メールアドレス１</th>
					        <th class="col-md-2" style="padding:0px">個別用<br>メールアドレス2</th>
					        <th class="col-md-2" style="padding:0px">メンバー名</th>					        
					        <th class="col-md-1" style="padding:0px">決算</th>
					        <th class="col-md-1" style="padding:0px">
					        		詳細を見る
					        </th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							@foreach ($users as $user)
							<tr>
								<td style="vertical-align:middle">{{$user->username}}</td>
								<td style="vertical-align:middle">{{$user->email}}</td>
								<td style="vertical-align:middle">{{$user->email1}}</td>
								<td style="vertical-align:middle">{{$user->email2}}</td>
								<td style="vertical-align:middle">{{$user->member_name}}</td>
								<td style="vertical-align:middle">{{$user->society_settlement_date}}</td>
								<td>
									<a href="{{url('/admin/basic_info/'.$user->id)}}">詳細を見る</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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