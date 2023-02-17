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
	                	> 入会手続き中団体リスト
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">入会手続き中 団体　メール送受信履歴</h3>

			<div class="row">
				
				@if(isset($message))
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
					<strong>お知らせ!</strong>
					<p>
						{{$message}}
					</p>
				</div>
				@endif
				@if(count($errors) > 0)
					@include('partials.alert', array('errors' => $errors->all()))
				@endif

				<div class="table-scrollable">	
					<table class="table table-striped table-bordered table-hover data-table" cellpadding="0" cellspacing="0"  width="100%">
					    <thead>
					      <tr class="bg-primary">
					        <th >申請受付日</th>
					        <th >団体名</th>
					        <th >代表者名</th>
					        <th >所在地</th>
					        <th >メールアドレス</th>
					        <th >人数</th>
					        <th >返信日</th>
					        <th >仮ID</th>
					        <th >仮パスワード</th>
					        <th >正式登録受付日</th>
					        <th >読Qネーム</th>
					        <th >パスワード</th>
					        <th >正式受理し、返信</th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							@foreach ($users as $user)
							<tr>
								<td width="5%">{{with($user->created_at)->format("Y/m/d")}}</td>
								<td width="20%" >
									<a id="user_a" href="/admin/data_card_org/{{$user->id}}" oncontextmenu="handleRightClick('{{$user->id}}','{{$user->email}}','{{$user->active}}'); return false;">
										{{ $user->group_name }}
									</a>
								</td>
								<td width="5%">{{$user->rep_name}}</td>
								<td width="20%">〒 {{$user->address4}}―{{$user->address5}} {{$user->address1}} {{$user->address2}} {{$user->address3}}</td>
								<td width="5%"><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
								<td width="5%">{{$user->totalMemberCounts()}}</td>
								<td width="5%" style="white-space: nowrap">
								@if ($user->replied_date1)
									{{with(date_create($user->replied_date1))->format("Y/m/d")}}
								@else
									<a class="btn btn-info sendmail" href="{{url('/admin/reg_sendMail/'.$user->id)}}" data-user="{{$user->id}}" >送信</a>
									<a class="btn btn-danger" href="{{url('/admin/unapproved/'.$user->id)}}">削除</button>
								@endif
								</td>
								<td width="5%">{{$user->t_username}}</td>
								<td width="5%">{{$user->t_password}}</td>
								<td width="5%">{{$user->replied_date2?with(date_create($user->replied_date2))->format("Y/m/d"):""}}</td>
								<td width="5%"><a id="user_a" href="/admin/data_card_org/{{$user->id}}" oncontextmenu="handleRightClick('{{$user->id}}','{{$user->email}}','{{$user->active}}'); return false;">{{$user->username}}</a></td>
								<td width="5%">{{$user->r_password}}</td>
								<td width="5%">{{$user->replied_date3?with(date_create($user->replied_date3))->format("Y/m/d"):""}}</td>
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
            
			//$("#testvalue").html(user_id);  
			//mailto(user_email);
			var str="<a href='mailto:"+user_email+"' style='color:#757b87;'>Eメールを送る</a>"	
			$("#email_tag").html(str);
			
			if(user_active == 1){
				$("#userdata_tag").attr('disabled', true);
			}
			var str="<a href='/admin/data_card_org/"+user_id+"' style='color:#757b87;'>データ画面へ遷移</a>"	
				$("#userdata_tag").html(str);

	     };
        
        $(function () {
       
	  		var $contextMenu = $("#contextMenu");
	  		$("body").click(function(){
			    $("#popup").hide();
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
		});

		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });

        function do_escape() {
			
				bootbox.dialog({
	                message: "Invalid password.",
	                title: "読Q",
	                closeButton: false,
	                buttons: {
	                  success: {
	                    label: "確認",
	                    className: "btn-primary",
	                    callback: function() {
	                    	
	                    }
	                  }
	                }
	            });
			
		}

		// $(".sendmail").click(function() {
		// 	var user_id = $(this).data("user");
		// 	reg_sendMail(user_id);
		// })

		// function reg_sendMail (userId) {
		// 	var info = {
		// 		_token: $('meta[name="csrf-token"]').attr('content'),
		// 		userId: userId
		// 	};
		// 	var post_url = "/register/reg_sendMail";
		// 	$.ajax({
		// 		type: "post",
		// 		url: post_url,
		// 		data: info,
		// 		beforeSend: function (xhr) {
		// 			var token = $('meta[name="csrf-token"]').attr('content');
		// 			if (token) {
		// 					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
		// 			}
		// 		},
		// 		success: function (response) {
		// 			console.log("response===>", response);
		// 			if(response.sendStatus){
		// 				// window.location.reload();
		// 			}
		// 			else
		// 				alert('{{config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']}}') ;
		// 		}
		// 	}); 

		// }
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop