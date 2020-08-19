@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
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
                        > 会員検索
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
					<h3>会員検索結果</h3>
				</div>
			</div>
			<form class="form form-horizontal" id="search-form" name="search-form" method="get">
				{{csrf_field()}}
			<div class="row">
				<div class="col-md-12">
					
					<input type="hidden" name="address1" id="address1" @if(isset($address1)) value="{{$address1}}" @endif>
					<input type="hidden" name="address2" id="address2" @if(isset($address2)) value="{{$address2}}" @endif>
					<input type="hidden" name="gender" id="gender" @if(isset($gender)) value="{{$gender}}" @endif>
					<input type="hidden" name="rank" id="rank" @if(isset($rank)) value="{{$rank}}" @endif>
					<input type="hidden" name="action" id="action" @if(isset($action)) value="{{$action}}" @endif>
					<input type="hidden" name="years" id="years" @if(isset($years)) value="{{$years}}" @endif>
					<input type="hidden" name="username" id="username" @if(isset($username)) value="{{$username}}" @endif>
					<input type="hidden" name="firstname" id="firstname" @if(isset($firstname)) value="{{$firstname}}" @endif>
					<input type="hidden" name="lastname" id="lastname" @if(isset($lastname)) value="{{$lastname}}" @endif>
					<input type="hidden" name="onesearch_flag" id="onesearch_flag" @if(isset($onesearch_flag)) value="{{$onesearch_flag}}" @endif>
					<input type="hidden" name="ids" id="ids" >
					<input type="hidden" name="checkallview" id="checkallview" >
						<div class="form-group" style="margin-bottom:10px;">
							<label class="col-form-label col-md-2 text-md-right">
								作業を選択
							</label>
							<div class="col-md-4">
								<select class="form-control select2me" name="job" id="job" placeholder="選択...">
									<option value="1">マイ書斎閲覧</option>
									<option value="2">マイ書斎連絡帳へメッセージ</option>
									<option value="3">団体アカTOP画面お知らせ欄へメッセージ</option>
									<option value="4">団体アカ閲覧</option>
									<option value="5">団体教師画面お知らせ欄へメッセージ</option>
									<option value="6">団体教師画面閲覧</option>
									<option value="7">Eメールを個別に送信</option>
									<option value="8">会員データカード</option>
									<option value="9">団体データカード</option>
								</select>
							</div>
						</div>
						<span class="offset-md-1 col-md-4"style="font-size:14px;color:red;"><input type="checkbox" id="check_all" /> 検出された人全てにチェックを入れる</span>
						<span class="col-md-4"style="font-size:14px;color:red;">@if(isset($alluserscnt)){{$alluserscnt}}人　検出されました@endif</span>
				</div>
			</div>
			<div class="row">
				<div class="dataTables_wrapper no-footer col-md-10 offset-md-1">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover data-table no-footer" id="member_table">
							<thead class="blue">
								<tr class="blue">
									<th class="table-checkbox sorting_disabled">
										<!-- <input type="checkbox" class="group-checkable" data-set="#member_table .checkboxes"/> -->
									</th>
									<th>読Qネーム</th>
									<th>本名（正式名称）</th>
									<th>会員種類</th>
									<th>地域</th>
									<th>入会日</th>
								</tr>
							</thead>
							<tbody class="text-md-center">							
							@foreach($users as $user)
								<tr>
									<td style="vertical-align:middle;">
										<input type="checkbox" class="checkboxes" id="{{$user->id}}" role="{{$user->role}}" email="{{$user->email}}" active="{{$user->active}}" name="teacher" value="{{$user->id}}" />
									</td>
									<td>{{$user->username}}</td>
									<td>@if($user->role == config('consts')['USER']['ROLE']['GROUP']){{$user->group_name}}@else{{$user->fullname()}}@endif</td>
									<td>{{config('consts')['USER']['TYPE'][$user->role]}}</td>
									<td>{{$user->address1}} {{$user->address2}} {{$user->address3}} {{$user->address6}} {{$user->address7}} {{$user->address8}} {{$user->address9}} {{$user->address10}}</td>
									<td>{{with($user->created_at)->format('Y/m/d')}}</td>
								</tr>	
							@endforeach	
							</tbody>	
						</table>
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-3 offset-md-1">
					<span style="font-size:14px;color:red;"><input type="checkbox" id="check_all_users" @if(isset($checkallview) && $checkallview) checked="true" @endif/> 検出された人全部表示</span>
				</div>
				<div class="col-md-1 offset-md-6">
					<button type="button" class="next btn btn-primary">次　へ</button>
				</div>
			</div>			
			<div class="row">
				<div class="offset-md-2 col-md-8">
							<div class="row">
								<div class="input-cont col-md-10">
									<input class="form-control" type="text" id="msg_txt" name="msg_txt" placeholder="メッセージ入力欄">
								</div>
								<div class="btn-cont  col-md-2">
									<span class="arrow">
									</span>
									<button type="button" class="send btn btn-primary icn-only" disabled="true">送　信</button>
								</div>
							</div>
				</div>
			</div>
		</form>
			<div class="row">
				<div class="col-md-12">
					@if(!isset($onesearch_flag) || !$onesearch_flag)
					
						<table class="table table-striped table-bordered table-hover dataTable no-footer">
							<thead class="blue">
								<tr class="blue">
									<th rowspan="2" style="padding:0px;vertical-align:middle;" width="15%">日時</th>
									<th rowspan="2" style="padding:0px;vertical-align:middle;" width="15%">協会員ID</th>
									<!-- <th colspan="6" style="padding:0px;border:1px solid #ddd;vertical-align:middle;">送信先検索条件</th> -->
									<th rowspan="2" style="padding:0px;vertical-align:middle;" width="60%">文面</th>
									<th rowspan="2" style="padding:0px;;vertical-align:middle;" width="10%">人数</th>
								</tr>
								<tr class="blue">
									<!-- <th style="padding:0px;vertical-align:middle;" width="10%">都道府県</th>
									<th style="padding:0px;vertical-align:middle;" width="10%">市区郡町村</th>
									<th style="padding:0px;vertical-align:middle;" width="5%">性別</th>
									<th style="padding:0px;vertical-align:middle;" width="5%">級</th>
									<th style="padding:0px;vertical-align:middle;" width="8%">会員種別</th>
									<th style="padding:0px;vertical-align:middle;" width="8%">年代</th> -->
								</tr>
							</thead>

							<tbody class="text-md-center">
							@if(isset($messages2) && count($messages2) > 0)
								@foreach($messages2 as $message)
								    
									<tr>
										<td style="vertical-align:middle;">{{$message->created_at}}</td>
										<td style="vertical-align:middle;">@if(isset($message->username) && $message->username != '' && $message->username !== null){{$message->username}} @else 協会 @endif</td>
										<!-- <td style="vertical-align:middle;">@if(isset($address1)){{$address1}} @endif</td>
										<td style="vertical-align:middle;">@if(isset($address2)){{$address2}} @endif</td>
										<td style="vertical-align:middle;">@if(isset($gender)) @if($gender == 2) 男 @else 女 @endif @endif</td>
										<td style="vertical-align:middle;">@if(isset($rank)){{$rank}} @endif</td>
										<td style="vertical-align:middle;">@if(isset($action)) @if($action == 1) 団体 @elseif($action == 2) 一般 @elseif($action == 3) 監修者 @elseif($action == 4) 著者 @endif @endif</td>
										<td style="vertical-align:middle;">@if(isset($years)) 
												@if($years == 1) 小学生 
												@elseif($years == 2) 中学生 
												@elseif($years == 3) 高校生 
												@elseif($years == 4) 大学生 
												@elseif($years == 5) １０代 
												@elseif($years == 6) ２０代 
												@elseif($years == 7) ３０代 
												@elseif($years == 8) ４０代 
												@elseif($years == 9) ５０代 
												@elseif($years == 10) ６０代 
												@elseif($years == 11) ７０代
												@elseif($years == 12) ８０代以降全ての年代
												@endif 
											@endif
										</td> -->
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
							@else
							 	<tr>
									<td colspan="5" style="vertical-align:middle;">{{config('consts')['MESSAGES']['DATA_NO']}}</td>
								</tr>
							@endif
							</tbody>
						</table>
					@else
						<div class="clearfix"></div>
						<div class="clearfix"></div>
					
						<table class="table table-striped table-bordered table-hover dataTable no-footer">
							<thead class="blue">
								<tr class="blue text-md-center">
									<th rowspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;" width="15%">日時</th>
									<th style="padding:0px;vertical-align:middle;" width="15%">発信者</th>
									<th colspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;">宛　　先</th>
									<th rowspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;" width="50%">文面</th>
								</tr>
								<tr class="blue text-md-center">
									<th style="padding:0px;vertical-align:middle;">協会員ID</th>
									<th style="padding:0px;vertical-align:middle;" width="10%">読Ｑネーム</th>
									<th style="padding:0px;vertical-align:middle;" width="10%">名前・団体名</th>
									
								</tr>
							</thead>
							
							<tbody class="text-md-center">
							@if(isset($messages1) && count($messages1) > 0)
								@foreach($messages1 as $message)
									<tr>
										<td style="vertical-align:middle;">{{$message->created_at}}</td>
										<td style="vertical-align:middle;">@if(isset($message->adminname) && $message->adminname != '' && $message->adminname !== null){{$message->adminname}} @else 協会 @endif</td>
										<td style="vertical-align:middle;">@if(isset($message->username) && $message->username != '' && $message->username !== null){{$message->username}} @endif</td>
										<td style="vertical-align:middle;">@if($message->role == config('consts')['USER']['ROLE']['AUTHOR']){{$message->firstname_nick.' '.$message->lastname_nick}}
											@elseif($message->role == config('consts')['USER']['ROLE']['GROUP']) {{$message->group_name}}
											@else {{$message->firstname.' '.$message->lastname}}
											@endif</td>
										<td class="text-md-left" style="vertical-align:middle;"><?php echo $message->content ?></td>
									</tr>	
								@endforeach
							@else
							 	<tr>
									<td colspan="5" style="vertical-align:middle;">{{config('consts')['MESSAGES']['DATA_NO']}}</td>
								</tr>
							@endif
							</tbody>
						</table>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-md-11">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
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
            <button type="button" data-dismiss="modal" class="btn btn-info" >確　認</button>
        </div>
    </div>

  </div>
</div>
<div id="alertSuccessModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>成功</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text1"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >確　認</button>
        </div>
    </div>

  </div>
</div>
<div id="alertMessageModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text2"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info message_btn" >確　認</button>
        </div>
    </div>

  </div>
</div>
@stop
@section('scripts')
<script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('js/data-table.js')}}"></script>
<script src="{{asset('js/components-dropdowns.js')}}"></script>
<script type="text/javascript">
		
$(document).ready(function(){
	TableManaged.init();
	var items = [];
	

	$(".checkboxes").click(function(){
		
		var checkboxes = [];
		var checkids = $(".checkboxes");
		
		for(var i = 0; i < checkids.length; i++){
			if($(checkids[i]).parent().hasClass("checked")){
				checkboxes[checkboxes.length]= $(checkids[i]);
			}					
		}
		
		/*if(checkboxes.length == 0)
			$(".group-checkable").parent().removeClass("checked");
		else if(checkboxes.length == checkids.length)
			$(".group-checkable").parent().addClass("checked");*/
		if(checkboxes.length == 0)
			$("#check_all").parent().removeClass("checked");
		else if(checkboxes.length == checkids.length)
			$("#check_all").parent().addClass("checked");
	})

	$("#check_all").click(function(){
		
		var checkboxes = [];
		var checkids = $(".checkboxes");
		
		for(var i = 0; i < checkids.length; i++){
			if($("#check_all").parent().hasClass("checked")){
				$(checkids[i]).parent().addClass("checked");
			}else{
				$(checkids[i]).parent().removeClass("checked");
			}					
		}
	})

	$("#check_all_users").click(function(){
		
		var checkallview = 0;
		if($("#check_all_users").parent().hasClass("checked")){
			checkallview = 1;
		}else{
			checkallview = 0;
		}					
		
		$("#checkallview").val(checkallview); 
		$("#search-form").attr("action", "{{url('/admin/several_search_result')}}").attr("method","post");
        $("#search-form").submit();
	})

	$("#job").change(function(){
		var next_flag = false;
		var send_flag = false;
		//var checkboxes = $('input:checked');
		var checkboxes = [];
		var checkids = $(".checkboxes");
		for(var i = 0; i < checkids.length; i++){
			if($(checkids[i]).parent().hasClass("checked")){
				checkboxes[checkboxes.length]= $(checkids[i]);
			}					
		}
		if($(':selected').val() == 1){
			$(".send").attr('disabled', true);

			/*if(checkboxes.length > 1){
				$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			if(checkboxes.length == 0){
				next_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
	        }
            if(next_flag){
            	$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }*/

			
			$(".next").attr('disabled', false);
		}else if($(':selected').val() == 2){
			$(".next").attr('disabled', true);
			/*if(checkboxes.length == 0){
				send_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
	                	send_flag = true;
	                	break;
					}
	            }
	        }
            if(send_flag){
            	$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }*/
			$(".send").attr('disabled', false);
			
		}else if($(':selected').val() == 3){
			$(".next").attr('disabled', true);
			/*if(checkboxes.length == 0){
				send_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
	                	send_flag = true;
	                	break;
					}
	            }
	        }
            if(send_flag){
            	$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }*/

			$(".send").attr('disabled', false);
			
		}else if($(':selected').val() == 4){
			$(".send").attr('disabled', true);

			/*if(checkboxes.length > 1){
				$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			if(checkboxes.length == 0){
				next_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
	        }
            if(next_flag){
            	$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }*/

			$(".next").attr('disabled', false);
		}else if($(':selected').val() == 5){
			$(".next").attr('disabled', true);	
			/*if(checkboxes.length == 0){
				send_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
	                	send_flag = true;
	                	break;
					}
	            }
	        }
            if(send_flag){
            	$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['TEACHERSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }*/

			$(".send").attr('disabled', false);
			
		}else if($(':selected').val() == 6){
			$(".send").attr('disabled', true);

			/*if(checkboxes.length > 1){
				$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			if(checkboxes.length == 0){
				next_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
	        }
            if(next_flag){
            	$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['TEACHERSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }*/

			$(".next").attr('disabled', false);
		}else if($(':selected').val() == 7){
			$(".send").attr('disabled', true);
			$(".next").attr('disabled', false);	
		}else if($(':selected').val() == 8){
			$(".send").attr('disabled', true);

			/*if(checkboxes.length > 1){
				$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			if(checkboxes.length == 0){
				next_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}" ||
					   $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
	        }
            if(next_flag){
            	$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }*/
			$(".next").attr('disabled', false);
		}else if($(':selected').val() == 9){
			$(".send").attr('disabled', true);

			/*if(checkboxes.length > 1){
				$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			if(checkboxes.length == 0){
				next_flag = true;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
	        }
            if(next_flag){
            	$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }*/
			
			$(".next").attr('disabled', false);
		}
		else{
			$(".send").attr('disabled', true);
			$(".next").attr('disabled', true);	
		}
	});
 	$(".next").click(function(){
 		
 		var checkboxes = [];
		var checkids = $(".checkboxes");
		next_flag = false;
		send_flag = false;
		for(var i = 0; i < checkids.length; i++){
			if($(checkids[i]).parent().hasClass("checked")){
				checkboxes[checkboxes.length]= $(checkids[i]);
			}					
		}

 		for(var i=0; i<checkboxes.length; i++){
 			var key =  $(checkboxes[i]).val();
 			items.push(key);
 		}

 		if(items.length == 0){
			
			$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_USER']}}");
			$("#alertModal").modal();
			$(this).val("");
			return;
		}

		if($('#job').val() == 1){
			//$(".send").attr('disabled', true);

			if(checkboxes.length > 1){
				//$(".next").attr('disabled', true);
				
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}else{
				for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
	                	next_flag = true;
	                	break;
					}
	            }
			}
			
            if(next_flag){
            	//$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".next").attr('disabled', false);

		}else if($('#job').val() == 2){
			//$(".next").attr('disabled', true);
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
                	send_flag = true;
                	break;
				}
            }
	        
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".send").attr('disabled', false);

		}else if($('#job').val() == 3){
			//$(".next").attr('disabled', true);
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
                	send_flag = true;
                	break;
				}
            }
	       
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".send").attr('disabled', false);

		}else if($('#job').val() == 4){
			//$(".send").attr('disabled', true);
			
			if(checkboxes.length > 1){
				//$(".next").attr('disabled', true);
				
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}

			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
                	next_flag = true;
                	break;
				}
            }
	        
            if(next_flag){
            	//$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".next").attr('disabled', false);

		}else if($('#job').val() == 5){
			//$(".next").attr('disabled', true);
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
                	send_flag = true;
                	break;
				}
            }
	       
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['TEACHERSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".send").attr('disabled', false);

		}else if($('#job').val() == 6){
			//$(".send").attr('disabled', true);

			if(checkboxes.length > 1){
				//$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
                	next_flag = true;
                	break;
				}
            }
	       
            if(next_flag){
            	//$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['TEACHERSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".next").attr('disabled', false);

		}else if($('#job').val() == 8){
			//$(".send").attr('disabled', true);

			if(checkboxes.length > 1){
				//$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}" ||
				   $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}"){
                	next_flag = true;
                	break;
				}
            }
	        
            if(next_flag){
            	//$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPANDADMINSELECTNO']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".next").attr('disabled', false);

		}else if($('#job').val() == 9){
			//$(".send").attr('disabled', true);
			if(checkboxes.length > 1){
				//$(".next").attr('disabled', true);
				$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEUSER']}}");
				$("#alertModal").modal();
				return;
			}
			

			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
                	next_flag = true;
                	break;
				}
            }
	        
            if(next_flag){
            	//$(".next").attr('disabled', true);
            	$("#alert_text").html("{{config('consts')['MESSAGES']['GROUPSELECTONLY']}}");
				$("#alertModal").modal();
            	return;
            }

            //$(".next").attr('disabled', false);

		}
		

	   	switch($('#job').val()){
	   		case '1':
	   			if($('.checker .checked .checkboxes').attr('role') == {{config('consts')['USER']['ROLE']['PUPIL']}} && $('.checker .checked .checkboxes').attr('active') == 1)
	   				$("#search-form").attr("action", "{{url('/')}}" + "/mypage/pupil_view/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
	   			else
	   				$("#search-form").attr("action", "{{url('/')}}" + "/mypage/other_view/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
                $("#search-form").submit();
	   			break;
	   		case '4':
	   			$("#search-form").attr("action", "{{url('/')}}" + "/group/basic_info/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
                $("#search-form").submit();
	   			break;
	   		case '6':
	   			$("#search-form").attr("action", "{{url('/')}}" + "/admin/teachertop/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
                $("#search-form").submit();
	   			break;
	   		case '7':
	   			//window.open('mailto:sjm@doq.com?bcc=kjn@doq.com&subject=hello');
	   			var emails = "";
	   			for(var i=0; i<checkboxes.length; i++){
		 			emails +=  $(checkboxes[i]).attr('email');
		 			if(i != checkboxes.length - 1)
		 				emails += ";";
		 		}
	   			window.open("mailto:?bcc="+emails);
	   			break;
            case '8':
	   			$("#search-form").attr("action", "{{url('/')}}" + "/admin/personaldata/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
                $("#search-form").submit();
	   			break;
	   		case '9':
	   			$("#search-form").attr("action", "{{url('/')}}" + "/admin/data_card_org/" + $('.checker .checked .checkboxes').attr('id')).attr("method","get");
                $("#search-form").submit();
	   			break;
	   		default:
                
                break;
	   	}
			
   	});
	
	$(".send").click(function(){
		var checkboxes = [];
		var items = [];
		var ids = "";
		
		var next_flag = false;
		var send_flag = false;
		var checkids = $(".checkboxes");
		for(var i = 0; i < checkids.length; i++){
			if($(checkids[i]).parent().hasClass("checked")){
				checkboxes[checkboxes.length]= $(checkids[i]);
			}					
		}
 		
		if($('.checker .checked').length == 0){
			
			$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_USER']}}");
			$("#alertModal").modal();
			$(this).val("");
			return;
		}

		
		if($("#msg_txt").val() == ""){
			$("#alert_text").html("{{config('consts')['MESSAGES']['MESSAGE_INPUT']}}");
			$("#alertModal").modal();
			return;
		}

		if($('#job').val() == 1){
			
		}else if($('#job').val() == 2){
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
                	send_flag = true;
                	break;
				}
            }
	        
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	for(i =0; i < checkboxes.length; i++){
            		
					if($(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['GROUP']}}" || $(checkboxes[i]).attr("role") == "{{config('consts')['USER']['ROLE']['ADMIN']}}"){
	                	$(checkboxes[i]).parent().removeClass("checked");
					}
	            }
            	$("#alert_text2").html("{{config('consts')['MESSAGES']['GROUPMESSAGESNEDNO']}}");
				$("#alertMessageModal").modal();
            }

            //$(".send").attr('disabled', false);

		}else if($('#job').val() == 3){
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
                	send_flag = true;
                	break;
				}
            }
	       
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['GROUP']}}"){
	                	$(checkboxes[i]).parent().removeClass("checked");
					}
	            }
            	$("#alert_text2").html("{{config('consts')['MESSAGES']['GROUPSENDONLY']}}");
				$("#alertMessageModal").modal();
            	return;
            }
		}else if($('#job').val() == 4){
			

		}else if($('#job').val() == 5){
			//$(".next").attr('disabled', true);
			
			for(i =0; i < checkboxes.length; i++){
				if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
				   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
                	send_flag = true;
                	break;
				}
            }
	       
            if(send_flag){
            	//$(".send").attr('disabled', true);
            	for(i =0; i < checkboxes.length; i++){
					if($(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['TEACHER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['LIBRARIAN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['REPRESEN']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['ITMANAGER']}}" &&
					   $(checkboxes[i]).attr("role") != "{{config('consts')['USER']['ROLE']['OTHER']}}"){
	                		$(checkboxes[i]).parent().removeClass("checked");
					}
	            }
            	$("#alert_text2").html("{{config('consts')['MESSAGES']['TEACHERSENDONLY']}}");
				$("#alertMessageModal").modal();
            	return;
            }

            //$(".send").attr('disabled', false);
		}

 		for(var i=0; i<checkboxes.length; i++){
 			var key =  $(checkboxes[i]).val();
 			//items.push(key);
 			ids += key;
 			if(i < checkboxes.length - 1)
 				ids += ',';
 		}
 		$("#ids").val(ids); 
		switch($('#job').val()){
	   		case '2':
				
				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend").attr("method","post");
                $("#search-form").submit();
	   			break;
	   		case '3':
				
				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend1").attr("method","post");
                $("#search-form").submit();
	   			break;
			case '5':
	   			
				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend1").attr("method","post");
                $("#search-form").submit();
	   			break;
	   		default:
                
                break;
	   	}
	});
	
	$('.message_btn').click(function(){
		var checkboxes = [];
		var ids = "";
		var checkids = $(".checkboxes");
		for(var i = 0; i < checkids.length; i++){
			
			if($(checkids[i]).parent().hasClass("checked")){
				checkboxes[checkboxes.length]= $(checkids[i]);
			}					
		}

		
 		for(var i=0; i<checkboxes.length; i++){
 			var key =  $(checkboxes[i]).val();
 			//items.push(key);
 			ids += key;
 			if(i < checkboxes.length - 1)
 				ids += ',';
 		}
 		$("#ids").val(ids); 
		switch($('#job').val()){
	   		case '2':
				/*var info = {
					_token: $('meta[name="csrf-token"]').attr('content'),
					ids: items,
					msg_txt: $("#msg_txt").val()
				}
				$.ajax({
					type: "post",
		      		url: "/admin/messagesend",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf_token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	
				    	if(response.status == 'success'){

				    		$("#msg_txt").val("");
				    		$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    						$("#alertSuccessModal").modal();
				    	}
			    	}
				})*/

				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend").attr("method","post");
                $("#search-form").submit();
	   			break;
	   		case '3':
				/*var info = {
					_token: $('meta[name="csrf-token"]').attr('content'),
					ids: items,
					msg_txt: $("#msg_txt").val()
				}
				$.ajax({
					type: "post",
		      		url: "/admin/messagesend1",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf_token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	
				    	if(response.status == 'success'){

				    		$("#msg_txt").val("");
				    		$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    						$("#alertSuccessModal").modal();
				    	}
			    	}
				})*/
				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend1").attr("method","post");
                $("#search-form").submit();
	   			break;
			case '5':
	   			/*var info = {
					_token: $('meta[name="csrf-token"]').attr('content'),
					ids: items,
					msg_txt: $("#msg_txt").val()
				}
				$.ajax({
					type: "post",
		      		url: "/admin/messagesend1",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf_token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	
				    	if(response.status == 'success'){

				    		$("#msg_txt").val("");
				    		$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    						$("#alertSuccessModal").modal();
				    	}
			    	}
				})*/
				$("#search-form").attr("action", "{{url('/')}}" + "/admin/messagesend1").attr("method","post");
                $("#search-form").submit();
	   			break;
	   		default:
                
                break;
	   	}
	});
	
});
</script>
@stop