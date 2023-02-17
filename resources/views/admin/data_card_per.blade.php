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
        <h3 class="page-title">会員情報カード</h3>
        
        <div class="form-body">
        <form class="form register-form"  id="validate-form" method="post" role="form" action="{{url('/admin/save_personal_data')}}"  enctype="multipart/form-data">
        @if(count($errors) > 0 && $errors->has('servererr'))
            @include('partials.alert', array('errors' => $errors->all()))
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id" value="{{$user->id}}"> 
            <div class="row form-group">
                <div class="col-md-2 text-md-right {{ $errors->has('username') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">読Qネーム</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="username" name="username" value="{{old('username') !='' ? old('username') : (isset($user) ?  $user->username : '') }}">
                    @if ($errors->has('username'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('username') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('r_password') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">パスワード</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="r_password" name="r_password" value="{{old('r_password') !='' ? old('r_password') : (isset($user) ?  $user->r_password : '') }}">
                    @if ($errors->has('r_password'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('r_password') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('firstname') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">姓</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="firstname" name="firstname" value="{{old('firstname') !='' ? old('firstname') : (isset($user) ?  $user->firstname : '') }}">
                    @if ($errors->has('firstname'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('firstname') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('lastname') ? ' has-danger' : '' }}">                 
                    <div class="tools">
                        <label class="label-above">名</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="lastname" name="lastname" value="{{old('lastname') !='' ? old('lastname') : (isset($user) ?  $user->lastname : '') }}">
                    @if ($errors->has('lastname'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('lastname') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('firstname_yomi') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">姓よみがな</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="firstname_yomi" name="firstname_yomi" value="{{old('firstname_yomi') !='' ? old('firstname_yomi') : (isset($user) ?  $user->firstname_yomi : '') }}">
                    @if ($errors->has('firstname_yomi'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('firstname_yomi') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('lastname_yomi') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">名よみがな</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="lastname_yomi" name="lastname_yomi" value="{{old('lastname_yomi') !='' ? old('lastname_yomi') : (isset($user) ?  $user->lastname_yomi : '') }}">
                    @if ($errors->has('lastname_yomi'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('lastname_yomi') }}</span>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right {{ $errors->has('firstname_roma') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">姓ローマ字</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="firstname_roma" name="firstname_roma" value="{{old('firstname_roma') !='' ? old('firstname_roma') : (isset($user) ?  $user->firstname_roma : '') }}">
                    @if ($errors->has('firstname_roma'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('firstname_roma') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right {{ $errors->has('lastname_roma') ? ' has-danger' : '' }}">               
                    <div class="tools">
                        <label class="label-above">名ローマ字</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="lastname_roma" name="lastname_roma" value="{{old('lastname_roma') !='' ? old('lastname_roma') : (isset($user) ?  $user->lastname_roma : '') }}">
                    @if ($errors->has('lastname_roma'))
                    <span class="form-control-feedback" style="color:red">
                        <span>{{ $errors->first('lastname_roma') }}</span>
                    </span>
                    @endif
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">著者ペンネーム 姓</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="firstname_nick"  id="firstname_nick" value="{{old('firstname_nick') !='' ? old('firstname_nick') : (isset($user) ?  $user->firstname_nick : '') }}" class="form-control text-md-right" @if(!$user->isAuthor()) readonly @endif>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">著者ペンネーム 名</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="lastname_nick"  id="lastname_nick" value="{{old('lastname_nick') !='' ? old('lastname_nick') : (isset($user) ?  $user->lastname_nick : '') }}" class="form-control text-md-right" @if(!$user->isAuthor()) readonly @endif>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">ペンネームよみがな 姓</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="firstname_nick_yomi"  id="firstname_nick_yomi" value="{{old('firstname_nick_yomi') !='' ? old('firstname_nick_yomi') : (isset($user) ?  $user->firstname_nick_yomi : '') }}" class="form-control text-md-right" @if(!$user->isAuthor()) readonly @endif>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">ペンネームよみがな 名</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="lastname_nick_yomi"  id="lastname_nick_yomi" value="{{old('lastname_nick_yomi') !='' ? old('lastname_nick_yomi') : (isset($user) ?  $user->lastname_nick_yomi : '') }}" class="form-control text-md-right" @if(!$user->isAuthor()) readonly @endif>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">性別</label>                                                   
                    </div>
                    <select class="bs-select form-control base_info text-md-right" name="gender" id="gender">
                        @for($i = 1; $i < 3; $i++)
                            <option value="{{$i}}" @if(isset($user)&& $user->gender == $i) selected @endif>{{config('consts')['USER']['GENDER'][$i]}}</option>
                        @endfor
                    </select>  
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">生年月日</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="birthday" name="birthday" value="{{old('birthday') !='' ? old('birthday') : (isset($user) ?  $user->birthday : '') }}" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">電話</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="phone"  id="phone" value="{{$user->phone}}" class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">メールアドレス</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="email" name="email" value="{{$user->email}}">
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">保護者メアド</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="teacher" name="teacher" value="{{$user->teacher}}" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">現表示名</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="fullname_is_public"  id="fullname_is_public" value="@if($user->fullname_is_public){{$user->fullname()}}@else{{$user->username}}@endif" class="form-control text-md-right" readonly>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">現住所〒1</label>
                    </div>
                    <input type="{{"text"}}" name="address4" value="{{$user->address4}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">現住所〒2</label>
                    </div>
                    <input type="{{"text"}}" name="address5" value="{{$user->address5}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">都道府県</label>
                    </div>
                    <input type="{{"text"}}" name="address1" value="{{$user->address1}}"  class="form-control text-md-right " readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">市区町村</label>
                    </div>
                    <input type="{{"text"}}" name="address2" value="{{$user->address2}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">町名</label>
                    </div>
                    <input type="{{"text"}}" name="address3" value="{{$user->address3}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地１</label>
                    </div>
                    <input type="{{"text"}}" name="address6" value="{{$user->address6}}"  class="form-control text-md-right" readonly>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地２</label>
                    </div>
                    <input type="{{"text"}}" name="address7" value="{{$user->address7}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地３</label>
                    </div>
                    <input type="{{"text"}}" name="address8" value="{{$user->address8}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">建物名</label>
                    </div>
                    <input type="{{"text"}}" name="address9" value="{{$user->address9}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">部屋番号・階</label>
                    </div>
                    <input type="{{"text"}}" name="address10" value="{{$user->address10}}"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">入会日時</label>                                                   
                    </div>  
                    <input type="{{"text"}}" name="replied_date3"  id="replied_date3" value="{{old('replied_date3') !='' ? old('replied_date3') : (isset($user) ?  $user->replied_date3 : '') }}" class="form-control text-md-right" readonly>
                </div> 
                
                
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">現有効期限</label>                                                   
                    </div>  
                    @if($user->isPupil())
                    <input type="{{"text"}}" name="payment" class="form-control" id="payment" value="@if($user->active >= 2){{date_format(date_create($user->updated_at), 'Y年m月d日').'より準会員'}} @else @if($user->properties == 0){{config('consts')['PAYMENT_METHOD'][0]}}@elseif($user->pay_content !== null && $user->pay_content !== ''){{config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'.$user->period}}@else{{''}}@endif @endif"  readonly>
                    @else
                    <input type="{{"text"}}" name="payment" class="form-control" id="payment" value="@if($user->active >= 2){{date_format(date_create($user->updated_at), 'Y年m月d日').'より準会員'}} @else @if($user->properties == 0){{''}}@elseif($user->pay_content !== null && $user->pay_content !== ''){{config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'.$user->period}}@else{{''}}@endif @endif"  readonly>
                    @endif

                </div>
            </div>                       
                    
            
            <div class="tab-content1">
                <table class="table table-bordered">
                    <tr>
                        <td class="col-md-2 text-md-center">現生涯ポイント</td><td class="col-md-1 text-md-center">{{$user->total_point}}</td>
                        <td class="col-md-2 text-md-center">現在の級</td><td class="col-md-1 text-md-center">{{$user->rank}}</td>
                        <td class="col-md-2 text-md-center">登録した本の数</td><td class="col-md-1 text-md-center">{{$user->allowedbooks->count()}}</td>
                        <td class="col-md-2 text-md-center">認定されたクイズ数</td><td class="col-md-1 text-md-center">{{$user->allowedquizes}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2 text-md-center">受検回数</td><td class="col-md-1 text-md-center">{{$user->testquizes}}</td>
                        <td class="col-md-2 text-md-center">合格回数</td><td class="col-md-1 text-md-center">{{$user->testallowedquizes}}</td>
                        <td class="col-md-2 text-md-center">試験監督した回数</td><td class="col-md-1 text-md-center">{{$user->testoverseer}}</td>
                        <td class="col-md-2 text-md-center">試験監督した実人数</td><td class="col-md-1 text-md-center">{{$user->testoverseers}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2 text-md-center">適性検査合格日</td><td class="col-md-1 text-md-center">{{$user->replied_date4?with(date_create($user->replied_date4))->format("Y-m-d"):""}}</td>
                        <td class="col-md-2 text-md-center">監修本数</td><td class="col-md-1 text-md-center">{{$user->overseerbooks->count()}}</td>
                        <td class="col-md-2 text-md-center">著書読Ｑ本の数</td><td class="col-md-1 text-md-center">{{count($user->authorbooks)}}</td>
                        <td class="col-md-2 text-md-center">本棚公開非公開</td><td class="col-md-1 text-md-center">@if($user->book_allowed_record_is_public == 1)公開@else非公開@endif</td>
                    </tr>
                </table>
                @if($user->role == config('consts')['USER']['ROLE']["PUPIL"])
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th class="col-sm-2">所属先(生徒)</th>
                            <th class="col-sm-1">現学年</th>
                            <th class="col-sm-1">現学級</th>
                            <th class="col-sm-2">現　担任</th>
                            <th class="col-sm-2">入学・転入日</th>
                            <th class="col-sm-2">卒業・転出日</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">
                    @foreach($user->pupilHistories as $key=>$pupilHistory)                                                              
                        <tr class="info">
                            <td style="vertical-align:middle;">{{$pupilHistory->group_name}}</td>
                            <td style="vertical-align:middle;">@if($pupilHistory->grade != 0){{$pupilHistory->grade}}@endif</td>
                            <td style="vertical-align:middle;">{{$pupilHistory->class_number}}</td>
                            <td style="vertical-align:middle;">{{$pupilHistory->teacher_name}}</td>
                            <td style="vertical-align:middle;">{{$pupilHistory->created_at}}</td>
                            <td style="vertical-align:middle;">{{$pupilHistory->updated_at}}</td>
                        </tr> 
                    @endforeach                                             
                    </tbody>
                </table>
                @endif
                @if($user->isSchoolMember())
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-yellow">
                            <th class="col-sm-2">所属先(教員)</th>
                            <th class="col-sm-1">役職名</th>
                            <th class="col-sm-2">所属日</th>
                            <th class="col-sm-1">担任学年</th>
                            <th class="col-sm-1">担任学級</th>
                            <th class="col-sm-2">異動転出日</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">  
                    @foreach($user->teacherHistories as $key=>$teacherHistory)                                                                 
                        <tr >
                            <td style="vertical-align:middle;">{{$teacherHistory->group_name}}</td>
                            <td style="vertical-align:middle;">
                                @if($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['TEACHER']) 教員
                                @elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['LIBRARIAN']) 司書
                                @elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['REPRESEN']) 代表（校長、教頭等）
                                @elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['ITMANAGER']) IT担当者
                                @elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['OTHER']) その他
                                @endif
                            </td>
                            <td style="vertical-align:middle;">{{$teacherHistory->created_at}}</td>
                            <td style="vertical-align:middle;">@if($teacherHistory->grade != 0){{$teacherHistory->grade}}@endif</td>
                            <td style="vertical-align:middle;">{{$teacherHistory->class_number}}</td>
                            <td style="vertical-align:middle;">{{$teacherHistory->updated_at}}</td>
                        </tr> 
                    @endforeach                                                
                    </tbody>
                </table>
                @endif
                <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
                    <div class="col-md-4" style="padding-left:0px;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="align-middle" style="width:30%;padding-left:0px;padding-right:0px;">登録読Ｑ本ＩＤ</th>                            
                                    <th class="align-middle" style="width:70%;">登録読Ｑ本</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            @foreach($user->allowedbooks as $key=>$allowedbook)                                                                  
                                <tr>
                                    <td class="align-middle">dq{{$allowedbook->bookid}}</td>
                                    <td class="align-middle">{{$allowedbook->title}}</td>
                                </tr> 
                            @endforeach                                             
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4" style="padding-left:0px;">
                        @if(count($user->authorbooks) > 0 && !$user->isGeneral() && $user->isPupil())
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="col-sm-1" style="padding-left:0px;padding-right:0px;">監修読Ｑ本ＩＤ</th>
                                        <th class="col-sm-2">監修読Ｑ本</th>
                                    </tr>
                                </thead>
                                <tbody class="text-md-center">   
                                @foreach($user->overseerbooks as $key=>$overseerbook)                                                               
                                    <tr >
                                        <td style="vertical-align:middle;">dq{{$overseerbook->id}}</td>
                                        <td style="vertical-align:middle;">{{$overseerbook->title}}</td>
                                    </tr>  
                                @endforeach                                             
                                </tbody>
                            </table>
                        @endif
                    </div>
                    
                    <div class="col-md-4" style="padding-left:0px;padding-right:0px;">
                        @if(count($user->authorbooks) > 0 && ($user->isAuthor() || $user->isAdmin()))
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="col-sm-1" style="padding-left:0px;padding-right:0px;">著書読Ｑ本ＩＤ</th>
                                    <th class="col-sm-2">著書読Ｑ本</th>                            
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                            @foreach($user->authorbooks as $key=>$authorbook)                                                               
                                <tr >
                                    <td style="vertical-align:middle;">dq{{$authorbook->id}}</td>
                                    <td style="vertical-align:middle;">{{$authorbook->title}}</td>
                                </tr>  
                            @endforeach                                             
                            </tbody>
                        </table>
                         @endif
                    </div>
                   
                </div>
                <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
                   
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="align-middle" style="width:20%;padding-left:0px;padding-right:0px;">合格読Ｑ本ＩＤ</th>                            
                                    <th class="align-middle" style="width:70%;">合格読Ｑ本</th>
                                    <th class="align-middle" style="width:10%;">削除</th>                            
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            @foreach($user->myAllHistories as $key=>$myAllHistory)                                                                  
                                <tr>
                                    <td class="align-middle">dq{{$myAllHistory->book_id}}</td>
                                    <td class="align-middle">{{$myAllHistory->title}}</td>
                                    <td class="align-middle"><input type="checkbox" class="checkboxes" id="{{$myAllHistory->id}}" name="myAllHistory" value="{{$myAllHistory->id}}"/></td>
                                </tr> 
                            @endforeach                                             
                            </tbody>
                        </table>
                        <div class="col-md-12 text-md-center col-xs-12 pull-right" style="text-align:center;">
                            <button type="button" class="btn btn-primary success_cancel"  style="margin-bottom:8px">合格記録を削除</button>
                        </div>
                        <input type="hidden" name="selected" id="selected" value=""/>
                    
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-blue">
                            <th class="col-sm-3">画像枠予備</th>
                            <th class="col-sm-3">著者、監修者ﾌﾟﾛﾌｨｰﾙ画像</th>
                            <th class="col-sm-3">本人確認書類画像</th>
                            <th class="col-sm-3">資格書類画像</th>                            
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;"></td>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="@if($user->myprofile != null) {{url($user->myprofile)}} @endif" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;@if($user->myprofile_date)画像登録日 : {{$user->myprofile_date}}@endif</span></div>
                                    <div class="text-md-center" style="height: 34px;">                                      
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                            </td>
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
                                @if ($user->authfile != null && $user->authfile != '' && $user->authfile_check == 1)
                                <div>
                                    <a href="#" id="authfile_download" style="color:blue; font-weight: bold">ダウンロード</a>
                                    <span>&nbsp;/&nbsp;</span>
                                    <a href="#" id="authfile_delete" style="color:red; font-weight: bold">ファイル削除</a>
                                </div>
                                @endif
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
                                @if ($user->certifilename != null && $user->certifilename != '' && $user->certifile_check == 1)
                                <div>
                                    <a href="#" id="certifile_download" style="color:blue; font-weight: bold">ダウンロード</a>
                                    <span>&nbsp;/&nbsp;</span>
                                    <a href="#" id="certifile_delete" style="color:red; font-weight: bold">ファイル削除</a>
                                </div>
                                @endif
                            </td>
                        </tr>                                              
                    </tbody>
                </table>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-green">
                            <th class="col-sm-6">現顔登録</th>
                            <th class="col-sm-6">前回顔登録</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        @if($user->imagepath_check != 1)
                                            <img src="@if($user->image_path != null) {{url($user->image_path)}} @endif" alt=""/>
                                        @endif
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;@if($user->imagepath_date)登録日 : {{$user->imagepath_date}}@endif</span></div>
                                    <div class="text-md-center" style="height: 34px;">                                      
                                    </div>
                                </div>
                                <div>
                                    <span style="color:red">顔と書類画像の照合</span>
                                    <input type="checkbox" class="form-control" id="imagepath_check" name="imagepath_check" @if($user->imagepath_check == 1) {{"checked"}} @endif >
                                </div>
                            </td>
                            <td style="vertical-align:middle;"></td>
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
            <div class="offset-md-4 col-md-1 text-md-right col-xs-4">
                <button type="button" class="btn btn-success save-continue" style="margin-bottom:8px">保　存</button>
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
<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
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
<div id="TdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span>合格記録を削除しますか?</span>
        </div>
        <div class="modal-footer">
            <button type="button" data-loading-text="確認中..." class="delete_booksuccess btn btn-primary">は い</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close">いいえ</button>
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
            $("#alert_perdel_text").html("{{config('consts')['MESSAGES']['CONFIRM_PER_DELETE']}}");
            $("#perdelModal").modal();
        });

        $(".perdelete").click(function() {
            $("#validate-form").attr("action", '{{url("/admin/deleteperByAdmin")}}');
            $("#validate-form").submit();
        });

        $(".success_cancel").click(function(){
            var checkboxes = [];
            var checkids = $(".checkboxes");
            
            for(var i = 0; i < checkids.length; i++){
                if($(checkids[i]).parent().hasClass("checked")){
                    checkboxes[checkboxes.length]= $(checkids[i]);
                }                   
            }
            if(checkboxes.length == 0){
                $("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_BOOK_CANCEL']}}");
                $("#alertModal").modal();
                $(this).val("");
                return;
            }else{
                $("#TdelModal").modal();
            }

           
        });

        $(".delete_booksuccess").click(function(){
            var t = '';
            var checkboxes = [];
            var checkids = $(".checkboxes");
            
            for(var i = 0; i < checkids.length; i++){
                if($(checkids[i]).parent().hasClass("checked")){
                    checkboxes[checkboxes.length]= $(checkids[i]);
                }                   
            }

            for(i =0;i<checkboxes.length;i++){
                t+=$(checkboxes[i]).attr("id");
                if(i < checkboxes.length-1){
                    t+=",";
                }
            }

            $('#selected').val(t);

            $("#validate-form").attr("action", "{{url('/admin/success_cancel')}}");
            $("#validate-form").submit();
        });

        $("#authfile_download").click(function(e) {
            e.preventDefault();
            const link = document.createElement('a')
            link.href = "{{$user->file}}"
            link.download = downloadFileName("{{$user->file}}", "{{$user->username}}")
            document.body.appendChild(link)
            link.click();
            document.body.removeChild(link);
        })

        $("#authfile_delete").click(function (e) {
            e.preventDefault();

            var info = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: `{{$user->id}}`
            }
            $.ajax({
                type: "post",
                url: "{{url('/admin/deleteAuthFileByAdmin')}}",
                data: info,
            
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },           
                success: function (response){
                    console.log('response', response)
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            });
        });

        $("#certifile_download").click(function(e) {
            e.preventDefault();
            const link = document.createElement('a')
            link.href = "{{$user->certifile}}"
            link.download = downloadFileName("{{$user->certifile}}", "{{$user->username}}")
            document.body.appendChild(link)
            link.click();
            document.body.removeChild(link);
        })

        $("#certifile_delete").click(function (e) {
            e.preventDefault();

            var info = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: `{{$user->id}}`
            }
            $.ajax({
                type: "post",
                url: "{{url('/admin/deleteCertiFileByAdmin')}}",
                data: info,
            
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },           
                success: function (response){
                    console.log('response', response)
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            });
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

        var downloadFileName = function (path, name) {
            var ext = path.slice(-4);
            return name + ext;
        }
    </script>
    <script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop