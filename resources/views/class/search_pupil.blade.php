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
	            	> <a href="{{url('/top')}}">
                		団体教師トップ
                	</a>
	            </li>
            	<li class="hidden-xs">
                	> 児童生徒検索
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">児童生徒検索</h3>			
			<div class="row">
				<div class="col-md-12">
					<form class="form form-horizontal" id="search-form" method="get">
						{{csrf_field()}}
						@if(count($errors) > 0)
							@include('partials.alert', array('errors' => $errors->all()))
						@endif
						<div class="form-group">
							<label class="control-label offset-md-2 col-md-2 text-md-right">
								学級を選択
							</label>
							<div class="col-md-3">
								<select class="form-control select2me" name="class" id="class" placeholder="選択...">
								    <option></option>
									@foreach($the_classes as $class)
										<option value="{{$class->id}}" @if (isset($the_class) && ($class->id == $the_class->id)) selected @endif>
										@if(Auth::user()->isLibrarian() && Auth::user()->active==1)
										{{$class->school->group_name}}
										@endif
										@if($class->grade == 0)
											{{$class->class_number}} {{$class->teacher_name}}
											@if(($class->class_number != '' && $class->class_number != null) || ($class->teacher_name != '' && $class->teacher_name != null))
												学級/
											@endif
										@elseif($class->class_number == '' || $class->class_number == null)
											{{$class->grade}} {{$class->teacher_name}}年/
										@else
											{{$class->grade}}-{{$class->class_number}} {{$class->teacher_name}}学級/
										@endif
										{{$class->year}}年度
										@if($class->member_counts != 0 && $class->member_counts !== null)
										 	{{$class->member_counts}}名
										@endif	
										</option>
									@endforeach	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label offset-md-2 col-md-2 text-md-right">
								児童生徒を選択
							</label>
							<div class="col-md-3">
								<select class="form-control select2me" name="pupil" id="pupil" placeholder="選択..." >
									<option></option>							    
									@if(isset($pupils))
										@foreach($pupils as $pupil)
											<option value="{{$pupil->id}}">{{$pupil->firstname}} {{$pupil->lastname}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group last">
							<label class="control-label offset-md-2 col-md-2 text-md-right">
								作業を選択
							</label>
							<div class="col-md-3">
								<select class="form-control select2me" name="action" id="action" placeholder="選択...">
									@foreach(config('consts')['TEACHER']['ACTIONS'] as $key=>$action)
										<option value="{{$action['ACTION']}}"   
											@if((isset($_REQUEST['mode']) && $key == $_REQUEST['mode']) || (isset($the_action) && $the_action == $action['ACTION'])) 
											selected 
											@endif
											<?php if (isset($the_class))
														$teacherid = $the_class->teacher_id;
											?>
     
									        @if($action['ACTION'] == config('consts')['TEACHER']['ACTIONS']['A']['ACTION'])
									          
									        @elseif((Auth::user()->isRepresen() || Auth::user()->isItmanager() || isset($teacherid) && $teacherid == Auth::id()) && Auth::user()->getWifiFlag())
									            
									        @elseif($action['ACTION'] == config('consts')['TEACHER']['ACTIONS']['B']['ACTION'] && Auth::user()->isLibrarian() && Auth::user()->getWifiFlag())
									        
									        @else
									            disabled = "true"
									        @endif
										>
											{{$action['TITLE']}}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="offset-md-3 col-md-5 text-md-center" style="text-align:center;">
								<button type="button" class="btn btn-primary next"> 次　へ </button>
								<button type="button" class="btn btn-danger btn_cancel" > キャンセル </button>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
		    <input type="hidden" name="id" id="id" value="{{Auth::id()}}">
		    
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

	<input type="hidden" id="reloadFlag" name="reloadFlag" value="{{$class1->reload_flag}}" />

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
<div id="alertFaceModal" class="modal fade draggable draggable-modal" role="dialog">
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
    <script type="text/javascript">
	$(document).ready(function(){
	    	var movetopages = function () {	 
	    		flag = 100;
				
				if($("#reloadFlag").val()){
					flag =$("#reloadFlag").val();
				}
				if(flag == 2 && $('#action').val() == "{{config('consts')['TEACHER']['ACTIONS']['G']['ACTION']}}"){
					
					var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
					var pupilid = $("#pupil").val();
					socket.emit('faceverifyerror', pupilid);

					$("#alert_text1").html("{{config('consts')['MESSAGES']['FACEVERIFY_DELETE_TOREGISTER']}}");
	        		$("#alertFaceModal").modal();
				}else if(flag == 2 && $('#action').val() == "{{config('consts')['TEACHER']['ACTIONS']['G']['ACTION']}}"){
					$("#search-form").attr("action", "{{url('/')}}" + $('#action').val()).attr("method","get");
                	$("#search-form").submit();

                	$("#alert_text1").html("{{config('consts')['MESSAGES']['LOGINERROR_ROCK_REMOVE']}}");
	        		$("#alertFaceModal").modal();
				}else if(flag == 2 || $('#action').val() == "{{config('consts')['TEACHER']['ACTIONS']['A']['ACTION']}}"){
					$("#search-form").attr("action", "{{url('/')}}" + $('#action').val()).attr("method","get");
                	$("#search-form").submit();
				}else{
					
                	$("#authModal").modal({
		   				backdrop: 'static',
						keyboard: false
					});
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
				    		if($('#action').val() == "{{config('consts')['TEACHER']['ACTIONS']['G']['ACTION']}}"){
					
								var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
								var pupilid = $("#pupil").val();
								socket.emit('faceverifyerror', pupilid);

								$("#alert_text1").html("{{config('consts')['MESSAGES']['FACEVERIFY_DELETE_TOREGISTER']}}");
	        					$("#alertFaceModal").modal();
							}else{

								$("#search-form").attr("action", "{{url('/')}}" + $('#action').val()).attr("method","get");
                				$("#search-form").submit();

                				if($('#action').val() == "{{config('consts')['TEACHER']['ACTIONS']['F']['ACTION']}}"){
                					$("#alert_text1").html("{{config('consts')['MESSAGES']['LOGINERROR_ROCK_REMOVE']}}");
	        						$("#alertFaceModal").modal();
                				}
							}
				    		
						}else{
							$("#password").parent('.form-group').addClass('has-error').removeClass('has-error',3000);
							$("#password_error").html('読Q教師パスワードが違います。')
							$("#password_error").removeClass('display-hide').addClass('display-hide',3000)
						}
			    	}
				})
			})
			$("#authModal .modal-close").click(function(){
				history.go(-1);
			});
			$("#alertFaceModal .btn-info").click(function(){
				$("#alertFaceModal").modal('hide');
			});
		
		$("#show_pwd").change(function() {
		    if($(this).attr("checked")) {
		        $("#password").attr("type", "text");
		    } else {
		        $("#password").attr("type", "password");
		    }
		});
		
    	$("#class").change(function(){
    		$("#search-form").submit();
    	});

    	$(".next").click(function(){
    		
    	    if ($("#class").val() == -1 || $("#class").val() == null || $("#class").val() == '') {
                $("#alert_text").html("{{config('consts')['MESSAGES']['CLASS_REQUIRED']}}");
                $("#alertModal").modal();
                return;
    	    } else if ($("#pupil").val() == -1 || $("#pupil").val() == null|| $("#pupil").val() == '') {
                $("#alert_text").html("{{config('consts')['MESSAGES']['PUPIL_REQUIRED']}}");
                $("#alertModal").modal();
                return;
    	    } 
    	    movetopages();
    	    
    	    /*var info = {_token: $('meta[name="csrf-token"]').attr('content') ,
    	    			 selclassid: $("#class").val(), 
    	    			 selactionid: $("#action").val()};
          
			var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/class/search_pupil/check";
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
			    	
			    	if(response.status == 'success'){
	                    $("#search-form").attr("action", "{{url('/')}}" + $('#action').val()).attr("method","get");
                		$("#search-form").submit();
	                }else{
	                    $("#alert_text").html("{{config('consts')['MESSAGES']['EDIT_RIGHT_NO']}}");
                		$("#alertModal").modal();
	                }
		    	}
			});*/

      	});

		$('.btn_cancel').click(function(){
			//location.reload();
			var class_sel = $("#class").select2();
			var action = $("#action").select2();
			var pupil = $("#pupil").select2();
			
			class_sel.select2('val', ""); //初期化
			pupil.select2('val', ""); //初期化
			
			
		});	
	});
    </script>
@stop