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
        <h3 class="page-title">読Q本カード</h3>
        
        <div class="form-body">
            <form class="form register-form"  id="validate-form" method="post" role="form" action="{{url('/admin/save_book_data')}}"  enctype="multipart/form-data">
            {{ csrf_field() }}
            @if(count($errors) > 0)
                @include('partials.alert', array('errors' => $errors->all()))
            @endif
            <input type="hidden" name="id" id="id" value="{{$book->id}}"> 
            <input type="hidden" name="delete_id" id="delete_id" value=""> 
                <div class="row form-group">
                    <div class="col-md-1"></div>   
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">読Q本ID</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="dqid" name="dqid" value="dq{{$book->id}}" readonly>
                    </div>
                    <div class="col-md-4 margin-bottom-5 {{ $errors->has('title') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">タイトル</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="title" name="title" value="{{ old('title')!='' ? old('title'):( isset($book)? $book->title: '')}}" >
                        @if ($errors->has('title'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('title') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-4 margin-bottom-5 {{ $errors->has('title_furi') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">タイトルよみがな</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="title_furi" name="title_furi" value="{{ old('title_furi')!='' ? old('title_furi'):( isset($book)? $book->title_furi: '')}}">
                        @if ($errors->has('title_furi'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('title_furi') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1 "></div>
                    <div class="col-md-2  margin-bottom-5 {{ $errors->has('firstname_nick') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">著者ペンネーム 姓</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="firstname_nick" name="firstname_nick" value="{{ old('firstname_nick')!='' ? old('firstname_nick'):( isset($book)? $book->firstname_nick: '')}}">
                        @if ($errors->has('firstname_nick'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('firstname_nick') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2  margin-bottom-5 {{ $errors->has('lastname_nick') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">著者ペンネーム 名</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="lastname_nick" name="lastname_nick" value="{{ old('lastname_nick')!='' ? old('lastname_nick'):( isset($book)? $book->lastname_nick: '')}}">
                        @if ($errors->has('lastname_nick'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('lastname_nick') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('firstname_yomi') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">著者よみがな 姓</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="firstname_yomi" name="firstname_yomi" value="{{ old('firstname_yomi')!='' ? old('firstname_yomi'):( isset($book)? $book->firstname_yomi: '')}}" >
                        @if ($errors->has('firstname_yomi'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('firstname_yomi') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('lastname_yomi') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">著者よみがな 名</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="lastname_yomi" name="lastname_yomi" value="{{ old('lastname_yomi')!='' ? old('lastname_yomi'):( isset($book)? $book->lastname_yomi: '')}}" >
                        @if ($errors->has('lastname_yomi'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('lastname_yomi') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2 ">               
                        <div class="tools">
                            <label class="label-above">著者読Qネーム</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info " id="username" name="username" value="{{ old('username')!='' ? old('username'):( isset($book)? $book->username: '')}}" readonly>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('point') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">読Q本ポイント</label>                                                   
                        </div>
                        <input type="{{"number"}}" min="0" class="form-control base_info" id="point" name="point" value="{{ old('point')!='' ? old('point'):( isset($book)? $book->point: '')}}">
                        @if ($errors->has('point'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('point') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('quiz_count') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">出題数</label>                                                   
                        </div>
                        <input type="{{"number"}}" min="0" class="form-control base_info" id="quiz_count" name="quiz_count" value="{{ old('quiz_count')!='' ? old('quiz_count'):( isset($book)? $book->quiz_count: '')}}">
                        @if ($errors->has('quiz_count'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('quiz_count') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('test_short_time') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">時短最大秒数</label>                                                   
                        </div>
                        <input type="{{"number"}}" min="0" class="form-control base_info" id="test_short_time" name="test_short_time" value="{{ ( isset($book)? $book->test_short_time: (old('test_short_time')!='' ? old('test_short_time') : ''))}}">
                        @if ($errors->has('test_short_time'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('test_short_time') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">読Q推薦図書か</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control text-md-right base_info date-picker" id="recommend_flag" name="recommend_flag" value="@if($book->recommend_flag !== null && $book->recommend_flag != '0000-00-00') {{$book->recommend_flag}}@endif">
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">アマゾンURL</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="url" name="url" value="{{ old('url')!='' ? old('url'):( isset($book)? $book->url: '')}}">
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">               
                        <div class="tools">
                            <label class="label-above">本の形態</label>                                                   
                        </div>
                        <select class="bs-select" name="type" id="type" style="height:33px !important">
                            @foreach(config('consts')['BOOK']['TYPE'] as $key=>$type)
                                <option value="{{$key}}" @if(old('type')!='') 
                                                            @if(old('type') == $key) selected @endif
                                                        @else
                                                             @if(isset($book) && $book->type == $key) selected @endif
                                                        @endif>{{$type}}</option>
                                                        
                                            
                            @endforeach
                        </select>
                        @if ($errors->has('type'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('type') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-3 margin-bottom-5 {{ $errors->has('recommend') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">推奨年代</label>                                                   
                        </div>
                        <select name="recommend" class="form-control select2me calc"  placeholder="選択..." style="height:33px !important">
                            <option></option>
                            @foreach(config('consts')['BOOK']['RECOMMEND'] as $key=> $recommend)
                                <option value="{{$key}}" @if(old('recommend') != '') @if(old('recommend')== $key) selected @endif @elseif (isset($book)&& $book->recommend == $key) selected @endif>{{$recommend['TITLE']}}</option>
                            @endforeach          
                        </select>
                        @if ($errors->has('recommend'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('recommend') }}</span>
                        </span>
                    @endif
                    </div>
                    <div class="col-md-2 margin-bottom-5 {{ $errors->has('recommend_coefficient') ? ' has-danger' : '' }}">               
                        <div class="tools">
                            <label class="label-above">係数</label>                                                   
                        </div>
                        <input type="{{"number"}}" min="0" class="form-control base_info" id="recommend_coefficient" name="recommend_coefficient" value="{{ old('recommend_coefficient')!='' ? old('recommend_coefficient'):( isset($book)? $book->recommend_coefficient: '')}}" >
                         @if ($errors->has('recommend_coefficient'))
                        <span class="form-control-feedback">
                            <span>{{ $errors->first('recommend_coefficient') }}</span>
                        </span>
                        @endif   
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">認定日</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="replied_date1" name="replied_date1" value="{{$book->replied_date1?with(date_create($book->replied_date1))->format("Y-m-d"):""}}" readonly>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">               
                        <div class="tools">
                            <label class="label-above">ジャンル</label>                                                   
                        </div>
                        <select class="form-control select2me calc" name="categories[]" id="categories[]" multiple placeholder="選択..." style="min-width:100px;" required>
                                <option></option>
                                @foreach($categories as $key=>$category)
                                    @if (!is_null(old('categories')) && count(old('categories')) > 0)
                                        <option value="{{ $category->id }}" @if (in_array($category->id,  old('categories'))) selected @endif>{{ $category->name }}</option>
                                    @elseif(isset($book) && !is_null($book->category_ids()) && count($book->category_ids()) > 0)
                                        <option value="{{ $category->id }}" @if (in_array($category->id,  $book->category_ids())) selected @endif>{{ $category->name }}</option>
                                    @elseif((!is_null(old('categories')) && count(old('categories')) == 0) && (!isset($book) || (is_object($book->category_ids()) && count($book->category_ids()) == 0)) && $key == 8)
                                        <option value="{{ $category->id }}" selected >{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('categories'))
                            <span class="form-control-feedback" style="color:red">
                                <span>{{ $errors->first('categories') }}</span>
                            </span>
                            @endif
                    </div>
                    <div class="col-md-2 ">               
                        <div class="tools">
                            <label class="label-above">出版社</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="publish" name="publish" value="{{ old('publish')!='' ? old('publish'):( isset($book)? $book->publish: '')}}">
                        @if ($errors->has('publish'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('publish') }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">ISBN</label>                                                   
                        </div>
                        <input type="{{"text"}}" class="form-control base_info" id="isbn" name="isbn" value="{{ old('isbn')!='' ? old('isbn'):( isset($book)? $book->isbn: '')}}">
                        @if ($errors->has('isbn'))
                        <span class="form-control-feedback" style="color:red">
                            <span>{{ $errors->first('isbn') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">行数</th><td class="col-md-1 text-md-center align-middle">{{$book->max_rows}}</td>
                            <th class="col-md-2 text-md-center align-middle">1行字数</th><td class="col-md-1 text-md-center align-middle">{{$book->max_chars}}</td>
                            <th class="col-md-2 text-md-center align-middle">本文ページ数</th><td class="col-md-1 text-md-center align-middle">{{$book->pages}}</td>
                            <th class="col-md-2 text-md-center align-middle"></th><td class="col-md-1 text-md-center align-middle"></td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">空白のページ数</th><td class="col-md-1 text-md-center align-middle">{{$book->entire_blanks}}</td>
                            <th class="col-md-2 text-md-center align-middle">3/4空白頁数</th><td class="col-md-1 text-md-center align-middle">{{$book->quarter_filled}}</td>
                            <th class="col-md-2 text-md-center align-middle">1/2空白頁数</th><td class="col-md-1 text-md-center align-middle">{{$book->half_blanks}}</td>
                            <th class="col-md-2 text-md-center align-middle">1/4空白頁数</th><td class="col-md-1 text-md-center align-middle">{{$book->quarter_blanks}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">p30短行数</th><td class="col-md-1 text-md-center align-middle">{{$book->p30}}</td>
                            <th class="col-md-2 text-md-center align-middle">p50短行数</th><td class="col-md-1 text-md-center align-middle">{{$book->p50}}</td>
                            <th class="col-md-2 text-md-center align-middle">p70短行数</th><td class="col-md-1 text-md-center align-middle">{{$book->p70}}</td>
                            <th class="col-md-2 text-md-center align-middle">p90短行数</th><td class="col-md-1 text-md-center align-middle">{{$book->p90}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">p110短行数</th><td class="col-md-1 text-md-center align-middle">{{$book->p110}}</td>
                            <th class="col-md-2 text-md-center align-middle">総字数</th><td class="col-md-1 text-md-center align-middle">{{$book->total_chars}}</td>
                            <th class="col-md-2 text-md-center align-middle">参考字数</th><td class="col-md-1 text-md-center align-middle" colspan="2">
                            <input type="text" class="form-control base_info" id="recog_total_chars" name="recog_total_chars" value="{{ old('recog_total_chars')!='' ? old('recog_total_chars'):( isset($book)? $book->recog_total_chars: '')}}" placeholder="{{$book->recog_total_chars}}"></td>
                            <td class="col-md-1 text-md-center"></td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">登録者読Ｑネーム</th><td class="col-md-2 text-md-center" style="vertical-align:middle;">@if(isset($book->Register) && $book->Register !== null && $book->register_id != 0) {{$book->Register->username}} @endif</td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">監修者読Ｑネーム</th><td class="col-md-2 text-md-center" style="vertical-align:middle;">@if(isset($book->Overseer)){{$book->Overseer->username}}@endif</td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">著者監修者</th><td class="col-md-2 text-md-center" style="vertical-align:middle;">
                                <input type="checkbox" id="author_overseer_flag" name="author_overseer_flag" class="form-control" @if($book->author_overseer_flag == 1) checked @endif>
                           </td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">保有クイズ数</th><td class="col-md-2 text-md-center" style="vertical-align:middle;">{{$book->ActiveQuizes->count()}}</td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;"></th><td class="col-md-2 text-md-center" style="vertical-align:middle;"></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;"></th><td class="col-md-2 text-md-center" style="vertical-align:middle;"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1 col-md-10">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-green">
                                    <th class="col-sm-1">№</th>
                                    <th class="col-sm-10">帯文</th>
                                    <th class="col-md-1"></th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center article_body">
                                 @foreach($book->Articles as $article_id=>$article)                                                                 
                                <tr class="info">
                                    <td style="vertical-align:middle;">{{$article_id+1}}</td>
                                    <td style="vertical-align:middle;">{{$article->content}}</td>
                                    <td style="vertical-align:middle;">
                                        <a id = "{{$article->id}}" onclick="articledel({{$article->id}});">削除</a>
                                    </td>
                                </tr>   
                                 @endforeach                                           
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1 col-md-10">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-green">
                                    <th class="col-sm-1">№</th>
                                    <th class="col-sm-11">保有クイズ本文</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                                  @foreach($book->ActiveQuizes as $quiz_id=>$quize)                                                                 
                                <tr class="info">
                                    <td style="vertical-align:middle;">{{$quiz_id+1}}</td>
                                    <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $quize->question); $st = str_replace_first("#", "</u>", $st); 
                                                        $st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
                                                        for($i = 0; $i < 30; $i++) {
                                                            $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                            $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                        } 
                                                        echo $st  ?></td>
                                </tr>   
                                 @endforeach                                                 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-blue">
                                    <th class="col-sm-6">表紙画像1</th>
                                    <th class="col-sm-6">表紙画像2</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                                <img src="@if($book->cover_img != null) {{url($book->cover_img)}} @endif" @if($book->url !== null && $book->url != '') onclick="javascript:location.href='{{url($book->url)}}'" @endif alt=""/>
                                            </div>
                                            <div class="text-md-center"><span>&nbsp;@if($book->coverimg_date)画像登録日 : {{$book->coverimg_date}}@endif</span></div>
                                            <div class="text-md-center">
                                                <span class="btn btn-file btn-primary">
                                                    <span class="fileinput-new">ファイルを選択</span>
                                                    <span class="fileinput-exists">変　更</span>
                                                    <input type="file" name="coverimg" >
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
                                            <span style="color:red">表紙画像1のチェック</span>
                                            <input type="checkbox" class="form-control" id="coverimge_check" name="coverimge_check" @if($book->coverimge_check == 1) {{"checked"}} @endif >
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="text-md-center"><span>&nbsp;</span></div>
                                            <div class="text-md-center">
                                                <span class="btn btn-file btn-primary">
                                                    <span class="fileinput-new">ファイルを選択</span>
                                                    <span class="fileinput-exists">変　更</span>
                                                    <input type="file" name="coverimg1" >
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
                                            <span style="color:red">表紙画像2のチェック</span>
                                            <input type="checkbox" class="form-control" id="coverimg_check2" name="coverimg_check2"  >
                                        </div>
                                    </td>
                                </tr>                                              
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center">受検回数</th><td class="col-md-2 text-md-center">{{$book->TestedNums->count()}}</td>
                            <th class="col-md-2 text-md-center">受検者実数</th><td class="col-md-2 text-md-center">{{$book->TestedRealNums->count()}}</td>
                            <th class="col-md-2 text-md-center">合格者数</th><td class="col-md-2 text-md-center">{{$book->passedNums->count()}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">帯文数</th><td class="col-md-2 text-md-center" style="vertical-align:middle">{{$book->Articles->count()}}</td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">良書認数</th><td class="col-md-2 text-md-center" style="vertical-align:middle">{{$book->angate}}</td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">前年度合格者数順位/全登録冊数</th><td class="col-md-2 text-md-center" style="vertical-align:middle">{{$book->Rank_tested_lastyear($book->id)}}/{{$book->Registered_book_counter()->count()}}</td>
                        </tr>
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
            <button type="button" data-dismiss="modal" class="btn btn-warning confirm modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>
  </div>
</div>

<div id="bookdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_bookdel_text"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning bookdelete modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
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
<script type="text/javascript" src="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
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
            $("#alert_bookdel_text").html("{{config('consts')['MESSAGES']['CONFIRM_BOOK_DELETE']}}");
            $("#bookdelModal").modal();
        });

        $(".bookdelete").click(function() {
            $("#validate-form").attr("action", '{{url("/admin/deletebookByAdmin")}}');
            $("#validate-form").submit();
        });

        var recommend = 0;
       
        $("select[name=recommend]").change(function(){
            var temp = $("select[name=recommend]").val();
            var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];

            if( temp != ""){
                recommend = pointarray[temp];
            }
            $("input[name=recommend_coefficient]").val(recommend);
            
        });

        var articledel = function(delete_id){
            $("#delete_id").val(delete_id); 
            $("#alert_text").html("{{config('consts')['MESSAGES']['CONFIRM_DELETE']}}");
            $("#alertModal").modal();
        }
        $(".confirm").click(function() {
            var data = {_token: $('meta[name="csrf-token"]').attr('content') ,
                        book_id: {{$book->id}},
                         delete_id: $("#delete_id").val()};
            
            $.ajax({
                type: "post",
                url: "{{url('/admin/deletearticlebyadmin')}}",
                data: data,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },          
                success: function (response){
                    if(response.status == 'success'){
                        $(".article_body").html("");
                        var html = "";
                        var articles = response.articles;
                        for(var i=0; i < articles.length; i++){
                            html += "<tr class='info'><td style='vertical-align:middle;'>";
                            html += i+1;
                            html += "</td><td style='vertical-align:middle;'>";
                            html += articles[i]['content'];
                            html += "</td><td style='vertical-align:middle;'>";
                            html += "<a id = '";
                            html += articles[i]['id'] + "' onclick='articledel(";
                            html +=  articles[i]['id'] + ");'>削除</a></td></tr>";
                        } 
                        $(".article_body").html(html);
                        $("#alert_text1").html("{{config('consts')['MESSAGES']['ARTICLE_DELETE_SUCCEED']}}");
                        
                    }
                    $("#alertSuccessModal").modal();
                }
            })
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
        handleDatePickers();

	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop