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
			<div class="page-head">
				<div class="page-title">
					<h3>協会メンバーの基本情報</h3>
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal form" method="post" id="form-validation" role="form" action="{{ url('/admin/updatebasicinfo') }}">
                        {{csrf_field()}}    
                        <input type="hidden" id='id' name="id" value="{{$user->id}}"> 
                        <div class="form-group row {{ $errors->has('username') ? ' has-danger' : '' }}">
                            <label class="control-label col-md-3 text-md-right" for="username">協会メンバーの読Qネーム:</label>
                            <div class="col-md-3">
                                <input type="text" value="{{old('username') !='' ? old('username') : (isset($user) ?  $user->username : '') }}" class="form-control" name="username" id="username" readonly>
                                
                                @if ($errors->has('username'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('username') }}</span>
                                </span>
                                @endif
                                                        
                            </div>
                            
                        </div>
                        <div class="form-group row {{ $errors->has('r_password') ? ' has-danger' : '' }}">
                            <label class="control-label col-md-3 text-md-right" for="firstname_roma">ログインパスワード:</label>
                            <div class="col-md-3">
                                <input type="password" value="{{old('r_password') !='' ? old('r_password') : (isset($user) ?  $user->r_password : '') }}" class="form-control" name="r_password" id="r_password">
                                
                                @if ($errors->has('r_password'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('r_password') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="firstname_roma">保有メールアドレスとパスワード:</label>
                            <label class="control-label col-md-1 text-md-right" for="lastname_roma">個別用１:</label>
                            <div class="col-md-2 {{ $errors->has('email1') ? ' has-danger' : '' }}">
                                <input type="text" value="{{old('email1') !='' ? old('email1') : (isset($user) ?  $user->email1 : '') }}" class="form-control" name="email1" id="email1">
                                
                                @if ($errors->has('email1'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email1') }}</span>
                                </span>
                                @endif
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2  {{ $errors->has('email1_password') ? ' has-danger' : '' }}">
                                @if($user->id == Auth::user()->id)
                                    <input type="text" value="{{old('email1_password') !='' ? old('email1_password') : (isset($user) ?  $user->email1_password : '') }}" class="form-control" name="email1_password" id="email1_password">
                                @else
                                    <input type="text" value="••••••" class="form-control" name="email1_password" id="email1_password">
                                @endif
                                @if ($errors->has('email1_password'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email1_password') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('email2') ? ' has-danger' : '' }}">
                            <label class="control-label col-md-4 text-md-right" for="">個別用2:</label>
                            <div class="col-md-2">
                                <input type="text" value="{{old('email2') !='' ? old('email2') : (isset($user) ?  $user->email2 : '') }}" class="form-control" name="email2" id="email2">
                                
                                @if ($errors->has('email2'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email2') }}</span>
                                </span>
                                @endif
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2 {{ $errors->has('email2_password') ? ' has-danger' : '' }}">
                                @if($user->id == Auth::user()->id)
                                    <input type="text" value="{{old('email2_password') !='' ? old('email2_password') : (isset($user) ?  $user->email2_password : '') }}" class="form-control" name="email2_password" id="email2_password">
                                @else
                                    <input type="text" value="••••••" class="form-control" name="email2_password" id="email2_password">
                                @endif
                                @if ($errors->has('email2_password'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email2_password') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-4 text-md-right" for="">送信専用:</label>
                            <div class="col-md-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="text" value="{{old('email') !='' ? old('email') : (isset($user) ?  $user->email : '') }}" class="form-control" name="email" id="email">
                                
                                @if ($errors->has('email'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email') }}</span>
                                </span>
                                @endif
                            </div>
            
                            <label class="control-label col-md-1 text-md-right" for=""> パスワード:</label>
                            <div class="col-md-2 {{ $errors->has('email_password') ? ' has-danger' : '' }}">
                                @if($user->id == Auth::user()->id)
                                    <input type="text" value="{{old('email_password') !='' ? old('email_password') : (isset($user) ?  $user->email_password : '') }}" class="form-control" name="email_password" id="email_password">
                                @else
                                    <input type="text" value="••••••" class="form-control" name="email_password" id="email_password">
                                @endif
                                @if ($errors->has('email_password'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('email_password') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="member_name">メンバー名:</label>
                            <div class="col-md-3 {{ $errors->has('member_name') ? ' has-danger' : '' }}">
                                <textarea id="member_name" class="form-control" name="member_name" rows="3">{{old('member_name')!=""? old('member_name') : (isset($user) ? $user->member_name : '')}}</textarea>
                                @if ($errors->has('member_name'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('member_name') }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="control-label col-md-3 text-md-right" for="society_settlement_date">決算:</label>
                            <div class="col-md-3 ">
                                 <input type="{{"text"}}" name="society_settlement_date"  id="society_settlement_date" value="{{$user->society_settlement_date}}" class="form-control text-md-right base_info date-picker" readonly>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="row" style="margin-top:8px">
                <div class="col-md-6 text-md-right">
                    @if($user->id == Auth::user()->id)<button type="button" class="btn btn-success save-continue"  style="margin-bottom:8px">保　存</button>@endif
                </div>
                <div class="col-md-6">
                    <a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
<script src="{{asset('js/components-dropdowns.js')}}"></script>
<script type="text/javascript"> 
    ComponentsDropdowns.init();  
    $(".save-continue").click(function(){
        $("#form-validation").submit();
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

        $("#society_settlement_date").inputmask("y/m/d", {
            "placeholder": "yyyy/mm/dd"
        }); //multi-char placeholder
       

    }
    handleDatePickers();
    handleInputMasks();
</script>
@stop