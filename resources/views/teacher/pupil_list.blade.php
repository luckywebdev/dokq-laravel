@extends('layout')

@section('styles')
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{url('/plugins/icheck/skins/all.css')}}" rel="stylesheet"/>
	<!-- END PAGE LEVEL SCRIPTS -->
	 <!-- data table -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
	 <!-- data table -->
	<style>
		td.primary{
			background: #007ACC;
			color: #FFF;
		}
		td.warning{
			background: #F0AD4E;
			color: #FFF;
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
		            	<a href="{{url('/')}}">
		                	> 団体教師トップ
		                </a>
		            </li>
		            <li class="hidden-xs">
		                > クラス内の読書量
		            </li>
		            <li class="hidden-xs">
		                > クラス生徒一覧(一括操作用)
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				クラス 一括操作
			</h3>

			<div class="row">
				<div class="col-md-12">
					<form id="select_class_form" action="{{url('/teacher/class_list')}}" method="get">
						<input type="hidden" name="class_id" id="class_id"/>
					</form>
					
					<form class="form-horizontal form" role="form">
						<div class="form-group row">
							<div class="col-md-4">
								<select class="bs-select form-control" id="select_class">
									<option value=""></option>
									@foreach($classes as $class)
									@if((Auth::user()->isLibrarian() && Auth::user()->active==1) && ($class->grade == 0 && ($class->class_number == 0 || $class->class_number == null || $class->class_number == '')))
										continue;
									@else
										<option value="{{$class->id}}" @if($classId == $class->id) selected @endif>
										@if(Auth::user()->isLibrarian() && Auth::user()->active==1)
											{{$class->school->group_name}}
										@endif
										@if($class->grade != 0) {{$class->grade}}- @endif
										{{$class->class_number}} @if($class->TeacherOfClass !== null){{$class->TeacherOfClass->fullname()}}@endif学級/{{$class->year}}年度
										@if($class->member_counts != 0 && $class->member_counts !== null)
											{{$class->member_counts}}名
										@endif	
										</option>
									@endif
									@endforeach
								</select>
							</div>

							<label class="control-label col-md-2 text-md-right">作業を選択</label>
							<div class="col-md-4">
								@if(Auth::user()->isLibrarian() && Auth::user()->active==1)							
									<select class="bs-select form-control" id="form_action">
										<option value="A" disabled="true">A 一括（選択した生徒）で読Qネーム入力</option>
										<option value="B" disabled="true">B 一括（選択した生徒）教師パスワード入力</option>
										<option value="C" disabled="true">C 一括(選択した生徒）ログアウト</option>
										<option value="D" @if(!Auth::user()->getWifiFlag()) disabled @endif>D 一括（選択した生徒）でお知らせを入力</option>
										<option value="E" disabled="true">E 選択した生徒の合格記録の取り消し</option>
										<option value="F" disabled="true">F 選択した生徒のログインエラーロック解除</option>
										<option value="G" disabled="true">G 選択した生徒の顔認証エラーを顔登録画面へ</option>
									</select>
								@else
									<select class="bs-select form-control" id="form_action">
										<option value="A" @if($fixed_flag != 1) disabled @endif>A 一括（選択した生徒）で読Qネーム入力</option>
										<option value="B" @if($fixed_flag != 1) disabled @endif>B 一括（選択した生徒）教師パスワード入力</option>
										<option value="C" @if($fixed_flag != 1) disabled @endif>C 一括(選択した生徒）ログアウト</option>
										<option value="D" @if(!Auth::user()->getWifiFlag()) disabled @endif @if($teacher_belong == 0) disabled @endif>D 一括（選択した生徒）でお知らせを入力</option>
										<option value="E" @if(!Auth::user()->getWifiFlag()) disabled @endif @if($teacher_belong == 0) disabled @endif>E 選択した生徒の合格記録の取り消し</option>
										<option value="F" @if(!Auth::user()->getWifiFlag()) disabled @endif @if($teacher_belong == 0) disabled @endif>F 選択した生徒のログインエラーロック解除</option>
										<option value="G" @if(!Auth::user()->getWifiFlag()) disabled @endif @if($teacher_belong == 0) disabled @endif>G 選択した生徒の顔認証エラーを顔登録画面へ</option>
									</select>	
								@endif							
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-2 ">
								<label style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 15px;">
									
								</label>
							</div>
							<div class="col-md-4">
								<h4 class="text-md-center">クラス生徒選択</h4>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-danger pull-right cancel_btn">キャンセル</button>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-8">
								<table class="table table-striped table-hover data-table" id="member_table">
									<thead style="border:0px solid #999;">
										<tr>
											<th width="33%" class="table-checkbox text-md-left"  style="border:0px solid #999;">
												<input type="checkbox" class="group-checkable" data-set="#member_table .checkboxes"/>全員を選択
											</th>
											<th width="33%" style="border:0px solid #999;"></th>
											<th width="33%" style="border:0px solid #999;"></th>
										</tr>
									</thead>
									<tbody class="text-md-center">
											@for($i = 0; $i < count($pupil); $i+=3)
											<tr>
												<td width="33%" tdid="@if(isset($pupil[$i])){{$pupil[$i]->id}}@endif" class="pupil @if(isset($pupil[$i])) @if($pupilStatus[$i] == 5) grey @endif @endif" style="border:1px solid #999;">
													@if(isset($pupil[$i]))
													<input type="checkbox" class="checkboxes p_check_class" id="{{$pupil[$i]->id}}" pid="{{$pupil[$i]->id}}" value="{{$pupil[$i]->id}}"/>
													{{$pupil[$i]->fullname()}}
													@if($wishStatus[$i] == 1) ● @endif
													@endif
												</td>
												<td width="33%" tdid="@if(isset($pupil[$i+1])){{$pupil[$i+1]->id}}@endif" class="pupil @if(isset($pupil[$i+1])) @if($pupilStatus[$i+1] == 5) grey @endif @endif" style="border:1px solid #999;">
													@if(isset($pupil[$i+1]))
													<input type="checkbox" class="checkboxes p_check_class" id="{{$pupil[$i+1]->id}}" pid="{{$pupil[$i+1]->id}}" value="{{$pupil[$i+1]->id}}"/>
													{{$pupil[$i+1]->fullname()}}
													@if($wishStatus[$i+1] == 1) ● @endif
													@endif
												</td>
												<td width="33%" tdid="@if(isset($pupil[$i+2])){{$pupil[$i+2]->id}}@endif" class="pupil @if(isset($pupil[$i+2])) @if($pupilStatus[$i+2] == 5) grey @endif @endif" style="border:1px solid #999;">
													@if(isset($pupil[$i+2]))
													<input type="checkbox" class="checkboxes p_check_class" id="{{$pupil[$i+2]->id}}" pid="{{$pupil[$i+2]->id}}" value="{{$pupil[$i+2]->id}}"/>
													{{$pupil[$i+2]->fullname()}}
													@if($wishStatus[$i+2] == 1) ● @endif
													@endif
												</td>
												
											</tr>
											@endfor										
									</tbody>
								</table>
							</div>
							<div class="col-md-3 text-md-center">
								<button type="button" class="btn btn-warning" id="btn_process" style="margin-bottom:8px;" @if(!Auth::user()->getWifiFlag()) disabled @endif>実　行</button>
							</div>
							<div class="row">
								<div class="col-md-3">
									<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)" style="margin-bottom:8px;">戻　る</button>
								</div>
							</div>
						</div>
						
					</form>	
					<form action="" method="get" id="action_form">
						<input type="hidden" name="pupil" id="pupil" />
						<input type="hidden" name="class" value="{{$classId}}"/>
					</form>				
				</div>
			</div>
			
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
		    <input type="hidden" name="id" id="id" value="{{Auth::id()}}">
		    <input type="hidden" name="unlock" id="unlock" value="{{isset($unlock)? $unlock : 0}}">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>{{config('consts')['MESSAGES']['PASSWORD_INPUT']}}</strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							<span class="help-block " id="password_error"></span>
								<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">パスワードを表示する</label>
			                @if ($errors->has('password'))
			                    <span class="help-block">
			                        <strong>{{ $errors->first('password') }}</strong>
			                    </span>
			                @endif
					 	</div>
					 </div>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-loading-text="確認中..." class="send_teacherpassword btn btn-primary">送　信</button>
					<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="reloadFlag" name="reloadFlag" value="@if(isset($user)){{$user->reload_flag}}@endif" />
	
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
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
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
@stop
@section('scripts')
	
	 <script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/data-table.js')}}"></script>
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<!-- BEGIN END LEVEL SCRIPTS -->
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			
			if($("#unlock").val() == 1){
				$("#alert_text1").html("{{config('consts')['MESSAGES']['LOGINERROR_ROCK_REMOVE']}}");
    			$("#alertSuccessModal").modal();
			}
			var movetopages = function () {	 
	    		flag = 100;
				
				if($("#reloadFlag").val()){
					flag =$("#reloadFlag").val();
				}
				if(flag != 2){
					$("#authModal").modal({
		   				backdrop: 'static',
						keyboard: false
					});
				}else{
					sendPage();
                	
				}
			}

			$("#authModal .send_teacherpassword").click(function(){
				var password = $("#password").val()
				if (password == ''){
					$("#password").focus()
					$("#password").parent('.form-group').addClass('has-error')
					return;
				}
				var data = {_token: $('meta[name="csrf-token"]').attr('content') , password: password, id: $("#id").val()};
				$.ajax({
					type: "post",
		      		url: "/api/user/passwordcheck",
				    data: data,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf_token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	
				    	if(response.status == 'success'){
				    		$("#authModal").modal('hide');
				    		sendPage();
				    		
						}else{
							$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
							$("#password_error").html('読Q教師パスワードが違います。')
							$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
						}
			    	}
				})
			})
			
			$(".cancel_btn").click(function(){
				var isChecked = $(this).parent().hasClass("checked")?true:false;
		    	$(".checkboxes").parent().removeClass("checked");
			    	
			});

			$("#authModal .modal-close").click(function(){
				//history.go(-1);
				$("#authModal").modal('hide');
			});
			$("#alertSuccessModal .btn-info").click(function(){
				$("#alertSuccessModal").modal('hide');
			});
			$("#show_pwd").change(function() {
			    if($(this).attr("checked")) {
			        $("#password").attr("type", "text");
			    } else {
			        $("#password").attr("type", "password");
			    }
			});

			
	        $("#select_class").change(function(){
		        if($(this).val() != ""){
					$("#class_id").val($(this).val());
					$("#select_class_form").submit();
		        }
		    });

		    /*$("#check_all").change(function(){
			    var isChecked = $(this).parent().hasClass("checked")?true:false;
			    if(isChecked){
					$(".checkboxes").parent().addClass("checked");
			    }else{
			    	$(".checkboxes").parent().removeClass("checked");
			    }			
			});*/

			//=============tester enter check =====================//
			// var socket = io('http://localhost:3000');

			var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
			socket.on('test-pupil', function(msg){
				console.log(msg);
				var data = JSON.parse(msg);
				var id = '<?php echo Auth::id();?>';
				var pupil_id = data.id;
				var pupils = $(".pupil");
				console.log(pupil_id);
				pupils.each(function(){
					var p_id_temp = $(this).attr("tdid");
					if(p_id_temp == pupil_id){
						console.log(p_id_temp);
						$(this).addClass('danger');
					}
					else{
						// $(this).removeClass('danger');
					}
				});
		    }); 
			socket.on('test-start', function(msg){
				console.log(msg);
				var data = JSON.parse(msg);
				var id = '<?php echo Auth::id();?>';
				var pupil_id = data.id;
				var pupils = $(".pupil");
				console.log(pupil_id);
				pupils.each(function(){
					var p_id_temp = $(this).attr("tdid");
					if(p_id_temp == pupil_id){
						console.log(p_id_temp);
						$(this).removeClass('danger');
						$(this).addClass('primary');
					}
					else{
						// $(this).removeClass('danger');
					}
				});
		    }); 
			socket.on('test-failed', function(msg){
				console.log(msg);
				var data = JSON.parse(msg);
				var id = '<?php echo Auth::id();?>';
				var pupil_id = data.id;
				var pupils = $(".pupil");
				console.log(pupil_id);
				pupils.each(function(){
					var p_id_temp = $(this).attr("tdid");
					if(p_id_temp == pupil_id){
						console.log(p_id_temp);
						$(this).removeClass('primary');
						$(this).addClass('warning');
					}
					else{
						// $(this).removeClass('danger');
					}
				});
		    }); 
			socket.on('test-success', function(msg){
				console.log(msg);
				var data = JSON.parse(msg);
				var id = '<?php echo Auth::id();?>';
				var pupil_id = data.id;
				var pupils = $(".pupil");
				console.log(pupil_id);
				pupils.each(function(){
					var p_id_temp = $(this).attr("tdid");
					if(p_id_temp == pupil_id){
						console.log(p_id_temp);
						$(this).removeClass('primary');
						$(this).addClass('danger');
					}
					else{
						// $(this).removeClass('danger');
					}
				});
		    }); 
			var data = {
				test: 1
			}
			socket.emit('test-overseer', JSON.stringify(data));


			$("#btn_process").click(function(){
				//get pupil ids
				var checkids = [];
				var checkboxes = $(".checkboxes");
				for(var i = 0; i < checkboxes.length; i++){
					if($(checkboxes[i]).parent().hasClass("checked")){
						checkids[checkids.length]= $(checkboxes[i]).attr("pid");
					}					
				}
				if(checkids.length <= 0) {
					//alert("please select at least one student");
					$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_STUDENT']}}");
    				$("#alertModal").modal();
    				return;
				}
				

				var action = $("#form_action").val();
				//init socket
				//var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
				 
				switch(action){
					case "A":
						movetopages();
						break;
					case "B":
						movetopages();						
						break;
	
					case "C":
						movetopages();
						break;
					case "D":
						movetopages();
						break;
	
					case "E":
						movetopages();
						break;
	
					case "F":
						movetopages();
						break;
					case "G":
						movetopages();	
						break;
				}
				
			});
			
			var sendPage = function () {
				//get pupil ids
				var checkids = [];
				var checkboxes = $(".checkboxes");
				for(var i = 0; i < checkboxes.length; i++){
					if($(checkboxes[i]).parent().hasClass("checked")){
						checkids[checkids.length]= $(checkboxes[i]).attr("pid");
					}					
				}
				var action = $("#form_action").val();
				//init socket
				// var socket = io('http://localhost:3000');

				var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
				
				switch(action){
					case "A":
						var pupilids = checkids.join(",");
						var info = {
							_token: $('meta[name="csrf-token"]').attr('content'),
							pupilids: pupilids
						}
						var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/teacher/movewtoUsername";
						$.ajax({
							type: "post",
				      		url: "/teacher/movewtoUsername",
						    data: info,
						    
							beforeSend: function (xhr) {
					            var token = $('meta[name="csrf_token"]').attr('content');
					            if (token) {
					                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					            }
					        },		    
						    success: function (response){
						    	
						    	if(response.status == 'success'){
						    		$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    								$("#alertSuccessModal").modal();
						    	}else{
						    		
						    	}
					    	}
						})
						break;
					case "B":
												
						var pupilids = checkids.join(",");
						var data = {
							password: '<?php echo Auth::user()->r_password?>',
							ids: pupilids
						};
						socket.emit('test-password', JSON.stringify(data));
						/*setTimeout(function() {
							history.go(0);
							
						}, 500);*/													
						$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    					$("#alertSuccessModal").modal();
						break;
	
					case "C":
						
						var pupilids = checkids.join(",");
						socket.emit('logout', pupilids);
						/*setTimeout(function(){
							history.go(0);	
						}, 500);*/							
						$("#alert_text1").html("{{config('consts')['MESSAGES']['SUCCEED']}}");
    					$("#alertSuccessModal").modal();
						break;
					case "D":
						
						var id = checkids.join(",");
						$("#action_form").attr("action","<?php echo url('teacher/send_notify')?>");
						$("#pupil").val(id);
						$("#action_form").submit();
						
						break;
	
					case "E":
						
						var id = checkids.join(",");
						$("#action_form").attr("action","<?php echo url('teacher/cancel_pass')?>");
						$("#pupil").val(id);
						$("#action_form").submit();
						
						break;
	
					case "F":
						
						var id = checkids.join(",");
						$("#action_form").attr("action","<?php echo url('class/pupil/unlock')?>");
						$("#pupil").val(id);
						$("#action_form").submit();

						break;
					case "G":
						
						var pupilids = checkids.join(",");
						socket.emit('faceverifyerror', pupilids);

						$("#alert_text1").html("{{config('consts')['MESSAGES']['FACEVERIFY_DELETE_TOREGISTER']}}");
    					$("#alertSuccessModal").modal();
						break;
				}
			}

			//var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
            @if(Auth::check())
	            socket.on('msglogin', function(msg){
			var pupilid = msg;
			$("#"+pupilid).removeClass("grey");
	            });
                socket.on('msglogout', function(msg){
			var pupilid = msg;
			$("#"+pupilid).addClass("grey");
            });
		@endif
			
		$(".group-checkable").change(function(e){
			if($(".group-checkable").prop('checked')){
				$(".p_check_class").each(function(){
					var chk_id = $(this).attr('id');
					$("#"+chk_id).prop('checked', true);
					$("#"+chk_id).parent().addClass("checked");

				});
			}
			else{
				$(".p_check_class").each(function(){
					$(this).prop('checked', false);
					$(this).parent().removeClass("checked");
				});
			}
		});
	});

// TableManaged.init();
    </script>
@stop