@extends('layout')

@section('styles')
    <style type="text/css">
    	.btn{
    		margin-bottom: 10px;
    	}
    	.form-group{
    		margin-left: 0px;
    		margin-right: 0px;
    		margin-bottom: 30px;
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
                        > 読Qトップお知らせ追加編集
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-head">
				<div class="page-title">
					<h3>連絡帳メッセージ個別送信履歴</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped table-bordered table-hover dataTable no-footer">
						<thead>
							
							<tr class="blue">
								<th rowspan="2" style="padding:0px;vertical-align:middle;" width="13%">日時</th>
								<th rowspan="2" style="padding:0px;vertical-align:middle;" width="10%">協会員ID</th>
								<th colspan="6" style="padding:0px;border:1px solid #ddd;vertical-align:middle;">送信先検索条件</th> 
								<th rowspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;" width="30%">文面</th>
								<th rowspan="2" style="padding:0px;;vertical-align:middle;" width="10%">人数</th>
							</tr>
							<tr class="blue">
								 <th style="padding:0px;vertical-align:middle;" width="8%">都道府県</th>
								<th style="padding:0px;vertical-align:middle;" width="8%">市区郡町村</th>
								<th style="padding:0px;vertical-align:middle;" width="4%">性別</th>
								<th style="padding:0px;vertical-align:middle;" width="4%">級</th>
								<th style="padding:0px;vertical-align:middle;" width="7%">会員種別</th>
								<th style="padding:0px;vertical-align:middle;" width="6%">年代</th> 
							</tr>
						</thead>

						<tbody class="text-md-center">
							@foreach($messages2 as $message)
							    
								<tr>
									<td style="vertical-align:middle;">{{$message->created_at}}</td>
									<td style="vertical-align:middle;">@if(isset($message->adminname) && $message->adminname != '' && $message->adminname !== null){{$message->adminname}} @else 協会 @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_address1)){{$message->search_address1}} @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_address1)){{$message->search_address2}} @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_gender)) {{$message->search_gender}} @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_rank)){{$message->search_rank}} @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_action)) {{$message->search_action}} @endif</td>
									<td style="vertical-align:middle;">@if(isset($message->search_year)) {{$message->search_year}} @endif</td>
									<td class="text-md-left" style="vertical-align:middle;"><?php echo $message->content ?></td>
									<td style="vertical-align:middle;">@if(isset($message->message_ct) && $message->message_ct == 1)	
																			@if($message->role != config('consts')['USER']['ROLE']['GROUP'] && $message->role != config('consts')['USER']['ROLE']['ADMIN'])
																				<a href="{{url('mypage/other_view/' . $message->to_id)}}" class="font-blue">{{$message->username}} </a>
																			@else
																				{{$message->username}}
																			@endif
																		 @else 
																		 	{{$message->message_ct}} 
																		 @endif</td>
								</tr>	
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="margin-top:8px">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>

<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
 <script>
	   $(document).ready(function(){
	   		$("#next_btn1").click(function(){
	   			//if ($('#single').hasClass('active')) {
	   				if ( $("#username").val() == null || $("#username").val() == '') {
		                $("#alert_text").html("{{config('consts')['MESSAGES']['USERNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#username").focus();
		                return;
		    	    } 
			    	
		    	    if($("#firstname").val() == null || $("#firstname").val() == ''){
			    		
		                $("#alert_text").html("{{config('consts')['MESSAGES']['FIRSTNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#firstname").focus();
		                return;
			    	    
			    	}
			    	if($("#lastname").val() == null || $("#lastname").val() == ''){
		    		    $("#alert_text").html("{{config('consts')['MESSAGES']['LASTNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#lastname").focus();
		                return;
			    	     
			    	}
			    	
			    	/*else if ($("#fullname").val() == null || $("#fullname").val() == '') {
		                $("#alert_text").html("{{config('consts')['MESSAGES']['FULLNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                return;
		    	    }*/
			    	$("#mem-search-form").submit();
	   			//}
			});	
			
			$("#next_btn2").click(function(){
	   			//if($('#several').hasClass('active')){

	   				if($("#gender").val() == '' && $("#rank").val() == '' && $("#action").val() == '' && $("#years").val() == ''){
	   					if($("#address1").val() == null || $("#address1").val() == ''){
	   						$("#alert_text").html("{{config('consts')['MESSAGES']['ADDRESS1_REQUIRED']}}");
			                $("#alertModal").modal();
			                return;
	   					}
	   					if($("#address2").val() == null || $("#address2").val() == ''){
	   						$("#alert_text").html("{{config('consts')['MESSAGES']['ADDRESS2_REQUIRED']}}");
			                $("#alertModal").modal();
			                return;
	   					}
	   					
	   				}
	   				$("#search-form").submit();
	   			//}
			});

			$('#action').change(function(){
   				if ($('#action').val() == 4) {
   					$("#years1").attr("disabled", false);
   					$("#years2").attr("disabled", false);
   					$("#years3").attr("disabled", false);
   					$("#years4").attr("disabled", false);
   				}else{
   					$("#years1").attr("disabled", true);
   					$("#years2").attr("disabled", true);
   					$("#years3").attr("disabled", true);
   					$("#years4").attr("disabled", true);
   				}
   			});
   			$('#years').change(function(){
   				if ($('#years').val() == 1 || $('#years').val() == 2 || $('#years').val() == 3 || $('#years').val() == 4) {
   					$("#action1").attr("disabled", true);
   					$("#action2").attr("disabled", true);
   					$("#action3").attr("disabled", true);
   					$("#action5").attr("disabled", true);
   					$("#action6").attr("disabled", true);
   					$("#action7").attr("disabled", true);
   					$("#action8").attr("disabled", true);
   					$("#action9").attr("disabled", true);
   				}else{
   					$("#action1").attr("disabled", false);
   					$("#action2").attr("disabled", false);
   					$("#action3").attr("disabled", false);
   					$("#action5").attr("disabled", false);
   					$("#action6").attr("disabled", false);
   					$("#action7").attr("disabled", false);
   					$("#action8").attr("disabled", false);
   					$("#action9").attr("disabled", false);
   				}
   			});	

   			$('.btn_cancel').click(function(){
				//location.reload();
				$("input").val('');
				var rank = $("#rank").select2();
				var action = $("#action").select2();
				var years = $("#years").select2();
				var gender = $("#gender").select2();
				rank.select2('val', ""); //初期化
				action.select2('val', ""); //初期化
				years.select2('val', ""); //初期化
				gender.select2('val', ""); //初期化
				/*$(".form-control").each(function(index, item){
					$(item).val("");
				})
				
				if ($("select[name=rank]").val()== 1){
					$(".param").each(function(index, item){
						if($(item).val() == '')
							$(item).val("0");
					})
					$("input[name=total_chars]").val("");
					$("input[name=point]").val(0);
				}

				var isChecked = $(this).parent().hasClass("checked")?true:false;
		    	$(".checkboxes").parent().removeClass("checked");*/
			});	
		});
 </script>
@stop