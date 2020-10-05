@extends('layout')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}">
    <style type="text/css">
	.caution{
		font-size: 16px;
	}
	.caution tr{
		margin-bottom: 10px;
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
                        > データ選択・作業選択
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">団体カード</h3>
        
        <h5 class="page-title" style="text-align: center;font-size: 20px;">{{$user->address2}}{{$user->group_name}} {{$user->username}}</h5>
        <div class="form-body">
        <form class="form register-form"  id="validate-form" method="post" role="form" action="{{url('/admin/save_org_data')}}"  enctype="multipart/form-data">
        {{ csrf_field() }}
        @if(count($errors) > 0)
            @include('partials.alert', array('errors' => $errors->all()))
        @endif
        <input type="hidden" name="id" id="id" value="{{$user->id}}"> 
            <div class="row form-group">
                <div class="col-md-1 text-md-right"></div> 
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">読Ｑネーム(ID)</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="username" name="username" value="{{$user->username}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">パスワード</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="r_password" name="r_password" value="{{$user->r_password}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">団体名</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="group_name" name="group_name" value="{{$user->group_name}}">
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">よみがな</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="group_yomi" name="group_yomi" value="{{$user->group_yomi}}">
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">ローマ字</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="group_roma" name="group_roma" value="{{$user->group_roma}}">
                </div>
                <div class="col-md-1 text-md-right"></div> 
            </div>
            <div class="row form-group">
                <div class="col-md-1 text-md-right"></div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">代表者役職</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="rep_post"  id="rep_post" value="{{$user->rep_post}}" class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">代表者</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="rep_name"  id="rep_name" value="{{$user->rep_name}}" class="form-control text-md-right" readonly>
                </div>
                
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">ＩＴ担当者</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="teacher" name="teacher" value="{{$user->teacher}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">担当者ﾒｰﾙｱﾄﾞﾚｽ</label>                                                   
                    </div>
                    <input type="{{"text"}}" name="email"  id="email" value="{{$user->email}}" class="form-control text-md-right" readonly>  
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">電話番号</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="phone"  id="phone" value="{{$user->phone}}" class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-1 text-md-right"></div>
            </div>

            <div class="row form-group">
                <div class="col-md-1 text-md-right"></div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">所在地〒１</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address4}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">所在地〒2</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address5}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">都道府県</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address1}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">市区町村</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address2}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">ところ番地</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address3}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-1 text-md-right"></div>
            </div>
            <div class="row form-group"> 
                <div class="col-md-1 text-md-right"></div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">団体形態</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="group_type" name="group_type" value="{{config('consts')['USER']['GROUP_TYPE'][1][$user->group_type]}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">代表者確認書類</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="r_password" name="r_password" value="{{config('consts')['USER']['AUTH_TYPE'][0]['CONTENT'][$user->auth_type]}}" readonly>
                </div>               
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">入会日時</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="replied_date3" name="replied_date3" value="{{$user->replied_date2}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">現有効期限</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="period"  id="period" value="{{$user->period}}" class="form-control text-md-right base_info date-picker" >
                </div> 
                <div class="col-md-2 text-md-right">                        
                </div> 
                <div class="col-md-1 text-md-right"></div>
            </div>
            <div class="row form-group"> 
                <div class="col-md-1 text-md-right"></div>
               <!-- <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">Wi-Fi番号</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="wifi" name="wifi" value="{{$user->wifi}}" placeholder="53257">
                </div> -->
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">学校IPアドレス</label>                                                   
                    </div>  
                    <input type="{{"text"}}" class="form-control base_info text-md-right" name="ip_address"  id="ip_address" value="{{$user->ip_address}}" placeholder="192.100.10.21">
                </div> 
                <!-- <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">NAT利用?</label>                                                   
                    </div>
                    <div style="padding-top:8px;">
                        <input type="{{"checkbox"}}" class="checkboxes" id="nat_flag" name="nat_flag" @if ($user->nat_flag == 1) checked @endif>
                    </div>
                </div>               
                
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">IP帯域</label>                                                   
                    </div>  
                    <input type="{{"text"}}" class="form-control base_info text-md-right" name="ip_global_address"  id="ip_global_address" value="{{$user->ip_global_address}}" placeholder="192.100.10.1">
                </div> -->
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">ネットマスク</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="mask" name="mask" value="{{$user->mask}}" placeholder="255.255.0.0">
                </div>
                <div class="col-md-3 text-md-right pt-2" style="padding-top: 15%">               
					<div class="col-md-1" style="padding-top:30px; display: inline">
                        <input type="{{"checkbox"}}" class="checkboxes" id="fixed_flag" name="fixed_flag" @if ($user->fixed_flag == 1) checked @endif>
                    </div>
                    <div class="tools col-md-6" style="padding-top: 10px"> 
                        <label class="label-above">学内IPで制限を行う。<br>(固定IPのみ）</label>                                                   
                    </div>
                </div> 
                <div class="col-md-2 text-md-right">                        
                </div> 
                <div class="col-md-1 text-md-right"></div>
            </div>
            <div class="col-md-12">
                <div class="portlet box green col-md-5" style="">
                    <div class="portlet-title">
                        <div class="caption">
                            教員情報
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                             <tbody class="text-md-center">
                                <tr class="text-md-center">
                                    <th class="col-md-3">教頭 {{count($represens)}}名</th>
                                    <th class="col-md-3">
                                        @foreach($represens as $key=> $represen)
                                            @if($key + 1 == count($represens))
                                                {{$represen->firstname.' '.$represen->lastname}}
                                            @else
                                                {{$represen->firstname.' '.$represen->lastname}}、
                                            @endif
                                        @endforeach
                                    </th>
                                </tr>
                                <tr class="text-md-center">
                                    <th class="col-md-3">司書 {{count($librarians)}}名</th>
                                    <th class="col-md-3">
                                        @foreach($librarians as $key=> $librarian)
                                            @if($key + 1 == count($librarians))
                                                {{$librarian->firstname.' '.$librarian->lastname}}
                                            @else
                                                {{$librarian->firstname.' '.$librarian->lastname}}、
                                            @endif
                                        @endforeach
                                    </th>
                                </tr>
                               
                                @foreach($teachers_ary as $teacher)
                                    <tr class="text-md-center">
                                    <td class="col-md-3">
                                    {{$teacher['classname']}}
                                    </td>

                                    <td class="col-md-3">{{$teacher['fullname']}}</td>
                                    </tr>        
                                @endforeach
                                <tr class="text-md-center">
                                    <td class="col-md-3" style="color:red;">教職員人数</td>
                                    <td class="col-md-3" style="color:red;">{{$teacher_numbers}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="portlet box purple col-md-6">
                    <div class="portlet-title">
                        <div class="caption">
                            生徒情報
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <tbody class="text-md-center">
                                    @foreach($classes as $class)
                                        <tr class="info">
                                            <td class="col-md-3">
                                            @if($class->grade == 0)                                 
                                                    {{$class->class_number}}組
                                            @elseif($class->class_number == '' || $class->class_number == null)
                                                {{$class->grade}}年
                                            @else
                                                {{$class->grade}}年{{$class->class_number}}組 
                                            @endif 
                                            @if($class->member_counts != 0 && $class->member_counts !== null)
                                                 {{$class->member_counts}}名
                                             @endif          
                                            </td>

                                            <td class="col-md-9">
                                                @foreach($pupils as $key=>$pupil)
                                                    @if($class->id == $pupil->id)
                                                        {{$pupil->username}}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>        
                                    @endforeach
                                    <tr class="info">
                                        <td class="col-md-3" style="color:red;">児童生徒人数</td>
                                        <td class="col-md-9" style="color:red;">{{count($pupils)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-content1">
                <table class="table table-striped table-bordered table-hover data-table">
                    <thead>
                        <tr class="bg-blue">
                            <th class="col-sm-6">本人確認書類画像</th>
                            <th class="col-sm-6">資格書類画像</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="@if($user->file != null) {{url($user->file)}} @endif" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;@if($user->authfile_date)画像登録日 : {{$user->authfile_date}}@endif</span></div>
                                    <div class="text-md-center">
                                        <span class="btn btn-file btn-primary">
                                            <span class="fileinput-new">ファイルを選択</span>
                                            <span class="fileinput-exists">変　更</span>
                                            <input type="file" name="authfile" >
                                        </span>
                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">キャンセル </a>
                                        @if ($errors->has('filemaxsize'))
                                        <span class="form-control-feedback">
                                            <span>{{ $errors->first('filemaxsize') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <span style="color:red">本人確認画像のチェック</span>
                                    <input type="checkbox" class="form-control" id="authfile_check" name="authfile_check" @if($user->authfile_check == 1) {{"checked"}} @endif >
                                </div>
                            </td>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="@if($user->certifile != null) {{url($user->certifile)}} @endif" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;@if($user->certifile_date)画像登録日 : {{$user->certifile_date}}@endif</span></div>
                                    <div class="text-md-center">
                                        <span class="btn btn-file btn-primary">
                                            <span class="fileinput-new">ファイルを選択</span>
                                            <span class="fileinput-exists">変　更</span>
                                            <input type="file" name="certificatefile" >
                                        </span>
                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">キャンセル </a>
                                        @if ($errors->has('filemaxsize1'))
                                        <span class="form-control-feedback">
                                            <span>{{ $errors->first('filemaxsize1') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <span style="color:red">資格書類画像のチェック</span>
                                    <input type="checkbox" class="form-control" id="certifile_check" name="certifile_check" @if($user->certifile_check == 1) {{"checked"}} @endif >
                                </div>
                            </td>
                        </tr>                                              
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-green">
                            <th class="col-sm-12">メモ</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;">
                                <textarea id="memo" class="form-control" name="memo" maxlength="80" rows="3">{{old('memo')!=""? old('memo') : (isset($user) ? $user->memo : '')}}</textarea>
                            </td>
                        </tr>                                              
                    </tbody>
                </table>
            </div>
        </form>
        </div>
        <div class="row" style="margin-top:8px">
            <div class="col-md-4 text-md-left"></div>
            <div class="col-md-1 text-md-right col-xs-6">
                <button type="button" class="btn btn-success save-continue"  style="margin-bottom:8px">保　存</button>
            </div>
            <div class="offset-md-1 col-md-1 text-md-right col-xs-4">
                <button type="button" class="btn btn-danger delete-continue" style="margin-bottom:8px">削　除</button>
            </div>
            <div class="col-md-5 text-md-right col-xs-4">
                <a href="{{url('/top')}}" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
            </div>
        </div>
    </div>
</div>
<div id="perdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_perdel_text"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning perdelete modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>
  </div>
</div>

@stop
@section('scripts')
<script type="text/javascript" src="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script src="{{asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/components-dropdowns.js')}}"></script>
    <script type="text/javascript">
    ComponentsDropdowns.init();
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });            
        $("#address4").inputmask("mask", {
            "mask":"999"
        });
        $("#address5").inputmask("mask", {
            "mask":"9999"
        });
        $(".save-continue").click(function(){
            $("#validate-form").submit();
        });
        $(".delete-continue").click(function(){
            $("#alert_perdel_text").html("{{config('consts')['MESSAGES']['CONFIRM_ORG_DELETE']}}");
            $("#perdelModal").modal();
        });
        $(".perdelete").click(function() {
            $("#validate-form").attr("action", '{{url("/admin/deleteorgByAdmin")}}');
            $("#validate-form").submit();
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
        var handleComponents = function() {
            $('#memo').maxlength({
                limitReachedClass: "label label-danger",
                alwaysShow: true
            });
        }
        handleComponents();
        handleDatePickers();
        handleInputMasks();
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop

<!-- 120.74.2.108 -->