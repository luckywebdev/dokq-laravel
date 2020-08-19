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
                	> 団体教員・司書の検索と新規登録
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')

	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">団体教員・司書の検索と新規登録</h3>
			
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
					<div class="form">
					<form class="form-horizontal form" id="form" method="get" role="form" action="{{url('/group/search_teacher')}}">

						<!-- <div class="form-group row {{ $errors->has('current_year') ? 'has-danger' : '' }}">
							<label class="control-label col-md-2">現在の年度を入力:</label>

							<div class="col-md-2">
							<input type="number" min="2000" name="year" value="{{isset($year) ? $year : '' }}" id="year" class="form-control" placeholder="<?php echo Date('Y')?>">
							
								@if ($errors->has('current_year'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('current_year') }}</span>
								</span>
								@endif
							</div>

							<label class="control-label col-sm-2 text-md-left label-after-input">西暦(半角)</label>
						</div> -->
						@if(!is_null($members) && count($members) == 1 && $name_search == 1)
						<div class="form-group {{ $errors->has('firstname') ? 'has-danger' : '' }}">

							<label class="control-label col-md-2">姓:</label>
							<div class="col-sm-4 col-md-2">
								<input type="text" name="firstname" value="{{ $members[0]->firstname }}" class="form-control">
								@if ($errors->has('firstname'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('firstname') }}</span>
								</span>
								@endif
							</div>

							<label class="control-label col-md-1"> 名:</label>
							<div class="col-md-2">
								<input type="text" name="lastname" value="{{ $members[0]->lastname }}" class="form-control">
								@if ($errors->has('lastname'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('lastname') }}</span>
								</span>
								@endif
							</div>

							
						</div>
						
						<div class="form-group {{ $errors->has('birthday') ? 'has-danger' : '' }}">

							<label class="control-label col-md-2">生年月日:</label>
							
							<div class="col-md-2">
								
									<input type="text" name="birthday" id="birthday" value="{{ $members[0]->birthday }}" class="form-control date-picker">
								
								@if ($errors->has('birthday'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('birthday') }}</span>
								</span>
								@endif
							</div>

							<div class="col-md-2">
								
							</div>

							<div class="col-md-2">
								<button type="submit" id="search" class="btn btn-warning">検 索</button>
							</div>
						</div>
						@else
						<div class="form-group {{ $errors->has('firstname') ? 'has-danger' : '' }}">

							<label class="control-label col-md-2">姓:</label>
							<div class="col-sm-4 col-md-2">
								<input type="text" name="firstname" value="{{ old('firstname') !='' ? old('firstname') : (isset($_GET['firstname']) ?  $_GET['firstname'] : '') }}" class="form-control">
								@if ($errors->has('firstname'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('firstname') }}</span>
								</span>
								@endif
							</div>

							<label class="control-label col-md-1"> 名:</label>
							<div class="col-md-2">
								<input type="text" name="lastname" value="{{ old('lastname') !='' ? old('lastname') : (isset($_GET['lastname']) ?  $_GET['lastname'] : '') }}" class="form-control">
								@if ($errors->has('lastname'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('lastname') }}</span>
								</span>
								@endif
							</div>
						</div>
						
						<div class="form-group {{ $errors->has('birthday') ? 'has-danger' : '' }}">

							<label class="control-label col-md-2">生年月日:</label>
							
							<div class="col-md-2">
								
									<input type="text" name="birthday" id="birthday" value="{{ old('birthday') !='' ? old('birthday') : (isset($_GET['birthday']) ?  $_GET['birthday'] : '') }}" class="form-control date-picker">
								
								@if ($errors->has('birthday'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('birthday') }}</span>
								</span>
								@endif
							</div>

							<div class="col-md-2">
								
							</div>

							<div class="col-md-2">
								<button type="submit" id="search" class="btn btn-warning">検 索</button>
							</div>
						</div>
						@endif
						<div class="form-group {{ $errors->has('username') ? 'has-danger' : '' }}">
							@if(!is_null($members) && count($members) > 0 && $name_search == 0)
							<label class="control-label col-md-2">読Qネーム:</label>
							<div class="col-md-3">
								<select class="bs-select form-control" name="selected" style="height: 33px !important">
									@foreach($members as $member)
										<option value="{{$member->id}}" @if(old('selected') == '{{$member->id}}') selected @endif >  {{$member->username}} </option>
									@endforeach					
								</select>
								@if ($errors->has('username'))
								<span class="form-control-feedback">
									<span>{{ $errors->first('username') }}</span>
								</span>
								@endif
							</div>
							@elseif(!is_null($members) && count($members) == 1 && $name_search == 1)
								<label class="control-label col-md-2" style="opacity:0.5;">読Qネーム:</label>
								<div class="col-md-3">
									<input class="form-control name_search" name="name_search" value="{{ $members[0]->username }}" style="height: 33px !important">
								</div>
								<input type="hidden" id="name_search_id" name="name_search_id" value="{{ $members[0]->id }}" class="form-control" />
							@else
							<label class="control-label col-md-2" style="opacity:0.5;">読Qネーム:</label>
								<div class="col-md-3">
									<input class="form-control name_search" name="name_search" value="" style="height: 33px !important">
								</div>
							@endif
						</div>
						<div class="form-group">
							@if(count($members)> 0)
								<h3 class="text-center text-danger" style="margin: 20px;">検索結果が{{count($members)}}人です。具体的な情報を入力して下さい。</h3>
							@endif
							@if($searchflag && count($members)==0)
								<h3 class="text-center text-danger" style="margin: 20px;">読Qに登録されていません。登録してください。</h3>
							@endif
						</div>
						<div class="form-group row">
							<div class="col-md-8 text-md-center col-sm-12">
								<button type="button" id="teacher_register"  class="btn btn-primary" style="margin-bottom:8px;" disabled>当団体の教員カードに登録し、権限の委譲をする</button>
							</div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-info pull-right" id="back" style="margin-bottom:8px;" disabled>戻　る</button>
                            </div>
						</div>

							<input type="hidden" id="searchflag" name="searchflag" value="{{ $searchflag }}" class="form-control" />
							<input type="hidden" id="name_search_flag" name="name_search_flag" value="{{ $name_search }}" class="form-control" />

					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade draggable draggable-moda" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
		    <input type="hidden" name="id" id="id" value="{{Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id}}">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>{{config('consts')['MESSAGES']['21B1']}}</strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							<span class="help-block " id="password_error"></span>
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
	<input type="hidden" id="reloadFlag" name="reloadFlag" value="{{$group->reload_flag}}" />
@stop
@section('scripts')
<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/localization/messages_ja.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/fuelux/js/spinner.min.js')}}"></script>
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			flag = 100;
			
			if($("#reloadFlag").val())
				flag =$("#reloadFlag").val();
			
			searchflag = 0;
			if($("#searchflag").val())
				searchflag =$("#searchflag").val();
			
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});

				$("#teacher_register").attr("disabled", true);
				$("#back").attr("disabled", true);
			}else if(searchflag != 0){
				$("#teacher_register").attr("disabled", false);
				$("#back").attr("disabled", false);
			}
			$("#authModal .modal-close").click(function(){
				history.go(-1);
			});
		
		    $("#teacher_register").click(function(){
		    /*	if($("#teacher_id") == '0'){
		    		$("#form").attr("action",'/group/teacher/register');
		    	}else{
		    		$("#form").attr("method", "get")
		    		$("#form").attr("action",'/group/teacher/' + $("#teacher_id").val() + '/edit/card');
		    	}*/
		    	$("#form").attr("method", "get");
		    	$("#form").attr("action",'{{url("/group/teacher/edit/card")}}');
		    	$("#form").submit();
		    })
		    $("#back").click(function(){
				history.go(-1);
			});

			var oldBirthday = "";

			 $("#birthday").change(function() {
			    if ($("#birthday").val() == "" || oldBirthday == $("#birthday").val()) {
			        return;
			    }
			    oldBirthday = $("#birthday").val()
			    //handleDupUserCheck();
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

		    var handleInputMasks = function () {
		        $.extend($.inputmask.defaults, {
		            'autounmask': true
		        });

		        $("#birthday").inputmask("y/m/d", {
		            "placeholder": "yyyy/mm/dd"
		        }); //multi-char placeholder
		       

		    }
		    handleDatePickers();
		    handleInputMasks();
		})
    </script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop