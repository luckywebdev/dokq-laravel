@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}">
<style>
	tbody tr td{
		vertical-align: middle !important;			
	}
    .paddingleftzero{
        padding-left: 0px !important;
    }

    .paddingrightzero{
        padding-right: 0px !important;
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
	            	> <a href="{{url('/mypage/top')}}">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修者プロフィール編集
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者紹介：自分のプロフィール</h3>
			<form action="{{url('/mypage/my_profile/update')}}" method="post" name="profile_form" id="profile_form" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="row">
				<div class="col-md-2">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                <img src="@if(Auth::user()->myprofile != null) {{url(Auth::user()->myprofile)}} @endif" alt=""/>
                            </div>
                            
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                            </div>
                            <div class="text-md-center"><br>
                                <span class="btn btn-primary btn-file btn-primary">
                                    <span class="fileinput-new">ファイルを選択</span>
                                    <span class="fileinput-exists">変　更</span>
                                    <input type="file" name="my_img" value="@if(Auth::user()->myprofile != null) {{url(Auth::user()->myprofile)}} @endif">
                                </span>
                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">キャンセル </a>
                                @if ($errors->has('filemaxsize'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('filemaxsize') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
				</div>

				<div class="col-md-10">
					<div class="portlet" style="margin-bottom:5px;">
						<div class="portlet-body">
                            <div class="form-group row {{ $errors->has('firstname') ? ' has-danger' : '' }} {{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-2 text-md-right" for="firstname">名前(全角）姓名:</label>
                                <label class="control-label col-md-6" for="lastname">@if(Auth::user()->isAuthor()){{ $user->fullname_nick() }}@else{{ $user->fullname() }}@endif</label>
                            </div>

                            <div class="form-group row
                                @if($errors->has('address1') || $errors->has('address2'))
                                    has-danger
                                @endif">
                                <label class="control-label col-md-2 text-md-right" for="address1">居住地 :</label>
                                <div class="col-md-2">
                                    @if($user->address1_is_public == 0)
                                    <input type="password" name="address1" value="aa" class="form-control" placeholder="神奈川県">
                                    @else
                                    <input required type="text" name="address1" value="{{ $user->address1 }}" class="form-control" placeholder="神奈川県">
                                    @endif
                                    @if($errors->has('address1') || $errors->has('address2'))
                                    <span class="form-control-feedback">
                                        <span>居住地を正確に入力してください。</span>
                                    </span>
                                    @endif
                                </div>
                                <span  style="margin-top:5px">―</span>
                                <div class="col-md-2 ">
                                    @if($user->address2_is_public == 0)
                                    <input type="password" name="address2" value="bb" class="form-control" placeholder="横浜市青葉区">
                                    @else
                                    <input required type="text" name="address2" value="{{ $user->address2 }}" class="form-control" placeholder="横浜市青葉区">
                                    @endif
                                </div>
                            </div>
							<div class="form-group row {{ $errors->has('scholarship') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-2 text-md-right" for="address1">最終学歴 :</label>
                                <div class="col-md-10">
                                    <input required type="text" id="scholarship" name="scholarship" value="{{ $user->scholarship }}" class="form-control" placeholder="茨城大学文学部">
                                    @if ($errors->has('scholarship'))
                                    <span class="form-control-feedback">
                                        <span>{{ $errors->first('scholarship') }}</span>
                                    </span>
                                    @endif
                                </div>
							</div>
							<div class="form-group row {{ $errors->has('job') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-2 text-md-right" for="address1">職業 :</label>
                                <div class="col-md-10">
                                    <input required type="text" id="job" name="job" value="{{ $user->job }}" class="form-control" placeholder="元　高校教諭">
                                    @if ($errors->has('job'))
                                    <span class="form-control-feedback">
                                        <span>{{ $errors->first('job') }}</span>
                                    </span>
                                    @endif
                                </div>
							</div>
							<div class="form-group row {{ $errors->has('about') ? ' has-danger' : '' }}">
                                <label class="control-label col-md-2 text-md-right" for="address1">読書について :</label>
                                <div class="col-md-10">
                                    <textarea required id="about" name="about" class="form-control"style="height: 100px;"  placeholder="...">{{$user->about}}</textarea>
                                    @if ($errors->has('about'))
                                    <span class="form-control-feedback">
                                        <span>{{ $errors->first('about') }}</span>
                                    </span>
                                    @endif
                                </div>
							</div>
							<div class="form-group row">
                                <label class="control-label col-md-2 text-md-right" for="address1">監修本 :</label>
								<div class="col-md-10">
									<select class="form-control select2me calc" name="categories[]" id="categories[]" multiple placeholder="選択...">
                                        <option></option>
                                        @foreach($books as $book)
                                        @if (count(old('books')) > 0)
                                            <option value="{{ $book->id }}" @if (in_array($book->id,  old('books'))) selected @endif>{{ $book->title }}</option>
                                        @elseif(isset($overseerbook_list)&&count($overseerbook_list) > 0)
                                            <option value="{{ $book->id }}" @if (in_array($book->id,  $overseerbook_list)) selected @endif>{{ $book->title }}</option>
                                        @elseif(count(old('books')) == 0 && (!isset($data) || count($data['books']) == 0))
                                            <option value="{{ $book->id }}" >{{ $book->title }}</option>
                                        @else
                                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                                        @endif
                                        @endforeach
                                    </select>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="form-group row col-md-12">
                    <button type="button" id="update_btn" class="offset-md-10 btn btn-success">確認して更新</button>
                </div>
			</div>
			</form>
            
		</div>
	</div>

    <div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>おたずね</strong></h4>
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
	<script type="text/javascript">
<!--
	var handleDupUserCheck = function() {
        var params = "firstname=" + $("#firstname").val() + "&lastname=" + $("#lastname").val() + "&birthday=" + $("#birthday").val();
        $.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/user/dupdoqusercheck?" + params,
            function(data, status){
                if(data.result=="dup") {
                    $("#alert_text").html("{{config('consts')['MESSAGES']['DOQUSER_EXIST']}}");
                    $("#alertModal").modal();
                }
            });
        };
     var oldBirthday = "";
    $("#firstname").blur(handleDupUserCheck);
    $("#lastname").blur(handleDupUserCheck);
    $("#birthday").change(function() {
        if ($("#birthday").val() == "" || oldBirthday == $("#birthday").val()) {
            return;
        }
        oldBirthday = $("#birthday").val()
        handleDupUserCheck();
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
            $("#phone").inputmask("mask", {
                "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
            });
            $("#address5").inputmask("mask",{
                "mask":"9999"
            });
            $("#address4").inputmask("mask",{
                "mask":"999"
            });
            $("#address6").inputmask("mask",{
                "mask":"99999"
            });
            $("#address7").inputmask("mask",{
                "mask":"9999"
            });
            $("#address8").inputmask("mask",{
                "mask":"9999"
            });
            $("#address10").inputmask("mask",{
                "mask":"*****"
            });

        }
        handleDatePickers();
        handleInputMasks();
        $(".help").click(function(){
            $(".popover-help").popover('show')
            setTimeout(function(){
                $(".popover-help").popover('hide')
            },3000)
        })
       
        
        $(document).ready(function(){
			$('#update_btn').click(function(){
				$('#profile_form').submit();
			})
		})

//-->
</script>
	
@stop