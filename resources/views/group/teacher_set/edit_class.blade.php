@extends('layout')

@section('styles')
    
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
	                	 > 団体アカウント 
		            </li>
	            	<li class="hidden-xs">
	                	<a href="#"> > 担任の編集・削除</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">担任の編集・削除</h3>

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
					<form class="form-horizontal form" id="form-validation" role="form" action="/group/teacher/doedit_class" method="post">
						{{csrf_field()}}
						<input type="hidden" id="reloadFlag" name="reloadFlag" value="{{$group->reload_flag}}" />
						<input type="hidden" id="obj_flag" name="obj_flag" value="" />
						<div class="form-group {{ $errors->has('year') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right" for="year">年度を選択<span class="text-danger">*</span></label>
							
							<div id="year" class="col-md-2">
								<div class="input-group">
									<input type="number" name="year" id="year" min="2000" maxlength="4" minlength="4" class="spinner-input form-control" value="{{isset($selclass->year) ? $selclass->year : $year }}" placeholder="入力例：<?php echo Date('Y')?>">
									@if ($errors->has('year'))
										<span class="form-control-feedback">
											<span>{{ $errors->first('year') }}</span>
										</span>
									@endif
								</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('grade') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right" for="grade">学年を選択<span class="text-danger">*</span></label>
							<div class="col-md-2">
								<select name="grade" id="grade" class="bs-select form-control search" placeholder="選択...">
									@foreach(config('consts')['CLASS_GRADE'] as $key=>$grade1)
										<option value="{{$key}}" @if(isset($grade) && $grade == $key) selected @endif>{{$grade1}}</option>
									@endforeach
								</select>
								@if ($errors->has('grade'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('grade') }}</span>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('class_number') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right" for="class_number">学級名<span class="text-danger">*</span></label>
							<div class="col-md-2">
								<select class="bs-select form-control search" name="class_number" id="class_number" enabled="true" placeholder="選択...">			
									@foreach($classnumbers as $member)
										<option value="{{$member->id}}" @if(isset($selclass->id) && $member->id == $selclass->id) selected @endif>{{$member->class_number}}</option>
									@endforeach
								</select>
								@if ($errors->has('class_number'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('class_number') }}</span>
									</span>
								@endif
							</div>
							<label class="control-label col-sm-2 text-md-left label-after-input">学級</label>
						</div>
						<div class="form-group {{ $errors->has('teacher_id') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2">担任教師名</label>
							<div class="col-md-3">
								<select class="bs-select form-control search" name="teacher_id" id="teacher_id"  enabled="true" placeholder="選択...">
									<option value=""></option>
									@foreach($members as $member)
										<option value="{{$member->id}}" @if(isset($selclass->teacher_id) && $selclass->teacher_id == $member->id) selected @endif>{{$member->firstname}} {{$member->lastname}}</option>
									@endforeach
								</select>
								@if ($errors->has('teacher_id'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('teacher_id') }}</span>
									</span>
								@endif
							</div>
						</div>
						
						<div class="form-group {{ $errors->has('member_counts') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right" for="member_counts">児童生徒人数(半角)<span class="text-danger">*</span></label>
							<div id="member_counts" class="col-md-2">
								<div class="input-group">
									<input type="number" name="member_counts" id="member_counts" class="spinner-input form-control" value="{{isset($selclass->member_counts)? $selclass->member_counts: ''}}" maxlength="3">
									@if ($errors->has('member_counts'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('member_counts') }}</span>
									</span>
								@endif
								</div>
							</div>
							<label class="control-label col-sm-2 text-md-left label-after-input">名</label>
						</div>

						 <div class="form-group">
							@if(isset($selclass) && isset($selclass->teacher_id) && $selclass->teacher_id !== null)
								<label class="control-label col-md-5 text-md-right" style="font-size: 16px;">
									@if($selclass->grade != 0)
										学級の表示 : {{$selclass->grade}}-{{$selclass->class_number}} {{$selclass->TeacherOfClass->firstname}} {{$selclass->TeacherOfClass->lastname}}学級 / {{$selclass->year}}年度 / {{$selclass->member_counts}} 名
									@else
										学級の表示 : {{$selclass->class_number}} {{$selclass->TeacherOfClass->firstname}} {{$selclass->TeacherOfClass->lastname}}学級 / {{$selclass->year}}年度 / {{$selclass->member_counts}} 名
									
									@endif
								</label>
							@endif
							
						</div>

						<div class="form-group row">
							<input type="hidden" id="btnflag" name="btnflag" />
							<div class="offset-md-2 col-md-2" style="margin-bottom:8px">
								<button id="register" class="btn btn-primary"  disabled="true">修正して終了</button>
							</div>
							<div class="col-md-2" style="margin-bottom:8px">
								<button type="button" id="register_delete" class="btn btn-danger" disabled="true">この学級を削除</button>
							</div>
							<!--<div class="col-md-2" style="margin-bottom:8px">
								<button id="teacher_delete" class="btn btn-danger" disabled="true">担任を削除</button>
							</div>-->
							<div class="offset-md-1 col-md-1" style="margin-bottom:8px">
								<a href="{{url('/top')}}" class="btn btn-info" id="back"  disabled="true">戻　る</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>{{config('consts')['MESSAGES']['21B1']}}</strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							{{csrf_field()}}
							<input type="hidden" name="id" id="id" value="{{Auth::id()}}">
							 <input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							 <span class="help-block " id="password_error">
							 </span>
					 	</div>
					 </div>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
					<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<div id="TdelModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
	      	</div>
	      	<div class="modal-body">
	        	<span>所属生徒はいませんか？</span>
				<span>本当に削除しますか？</span>
	     	</div>
	        <div class="modal-footer">
	            <button type="button" data-loading-text="確認中..." class="delete_teacher btn btn-primary">削除</button>
				<button type="button" data-dismiss="modal" class="btn btn-info modal-close">削除しない</button>
	        </div>
	    </div>

	  </div>
	</div>
	
@stop
@section('scripts')
	<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/localization/messages_ja.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/fuelux/js/spinner.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/group/editclass.js')}}"></script>
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			

   			flag = 100;
			if($("#reloadFlag").val()){
				flag = $("#reloadFlag").val();
			}
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});
				$("#class_number").attr("disabled", true);
				$("#teacher_id").attr("disabled", true);
				$("#register").attr("disabled", true);
				$("#register_delete").attr("disabled", true);
				$("#teacher_delete").attr("disabled", true);
				$("#back").attr("disabled", true);
			}else{
				$("#class_number").attr("disabled", false);
				$("#teacher_id").attr("disabled", false);
				$("#register").attr("disabled", false);
				$("#register_delete").attr("disabled", false);
				$("#teacher_delete").attr("disabled", false);
				$("#back").attr("disabled", false);
			}
			$("#authModal .modal-close").click(function(){
				history.go(-1);
			});
		
//		    FormValidation.init();
		    $("#year").change(function(){				
				//if($('#year').val() != "" && $('#grade').val() != "" && $('#class_number').val() != ""){
//					alert($('#year').val());
					$("#obj_flag").val(1);
			    	$("#form-validation").attr("method", "get")
			    	$("#form-validation").attr("action",'{{url("/group/teacher/edit_class")}}');
			    	$("#form-validation").submit();
				//}
			})
			$("#grade").change(function(){
				//if($('#year').val() != "" && $('#grade').val() != "" && $('#class_number').val() != ""){
					$("#obj_flag").val(2);
			    	$("#form-validation").attr("method", "get")
			    	$("#form-validation").attr("action",'{{url("/group/teacher/edit_class")}}');
			    	$("#form-validation").submit();
				//}
			})
			$("#class_number").change(function(){
				//if($('#year').val() != "" && $('#grade').val() != "" && $('#class_number').val() != ""){
					$("#obj_flag").val(3);
			    	$("#form-validation").attr("method", "get")
			    	$("#form-validation").attr("action",'{{url("/group/teacher/edit_class")}}');
			    	$("#form-validation").submit()
				//}
			})

			$("#class_number").keyup(function(){
				//if($('#year').val() != "" && $('#grade').val() != "" && $('#class_number').val() != ""){
					$("#obj_flag").val(3);
			    	$("#form-validation").attr("method", "get")
			    	$("#form-validation").attr("action",'{{url("/group/teacher/edit_class")}}');
			    	$("#form-validation").submit()
				//}
				/*var info = {_token: $('meta[name="csrf-token"]').attr('content') ,
    	    			 selyearid: $("#year").val(), 
    	    			 selgradeid: $("#grade").val(),
    	    			 selclassid: $("#class_number").val()};
          
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/group/teacher/selteachername";
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
			})
			$("#register").click(function(){
				$("#btnflag").val(1);
				//FormValidation.init();
				$("#form-validation").submit();
			})
			$("#register_delete").click(function() {
				$("#TdelModal").modal();
		    	
		    });
		    $(".delete_teacher").click(function() {
		    	$("#btnflag").val(2);
				//FormValidation.init();
				$("#form-validation").submit();
		    });
			$("#teacher_delete").click(function() {
		    	$("#btnflag").val(3);
				//FormValidation.init();
				$("#form-validation").submit();
		    });
		    
   		})
    </script>
@stop