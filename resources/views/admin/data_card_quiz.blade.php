
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
        <h3 class="page-title">クイズ情報</h3>
        <div class="row">
            <div class="col-md-10">
                <a id = "export" href = "@if(isset($quizid)) {{url('/admin/export_quiz_data/'.$bookid.'/'.$quizid)}} @else {{url('/admin/export_quiz_data/'.$bookid.'/null')}}@endif" class="btn btn-warning pull-right" role="button" style="margin-bottom:8px;">CSV Export</a>
            </div>
            <div class="col-md-2">
                <a href="{{url('/top')}}" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="form register-form"  id="validate-form" method="post" role="form" action="{{url('/admin/save_quiz_data')}}"  enctype="multipart/form-data">
                {{ csrf_field() }}
                @if(count($errors) > 0)
                    @include('partials.alert', array('errors' => $errors->all()))
                @endif
                <input type="hidden" name="id" id="id" value="{{$bookid}}"> 
                <table class="table table-striped table-bordered table-hover data-table">
                    <thead>
                        <tr class="bg-blue">
                            <th class="col-sm-1">クイズ№</th>
                            <th class="col-sm-3">文面</th>
                            <th class="col-sm-1">出典</th>
                            <th class="col-sm-1">認定日</th>
                            <th class="col-sm-1">作成者</th>
                            <th class="col-sm-1">認定した<br>監修者ID</th>
                            <th class="col-sm-1">出題回数</th>
                            <th class="col-sm-1">正答数</th>
                            <th class="col-sm-1">誤答数</th>
                            <th class="col-sm-1">時短<br>正答数</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">  
                        @if(isset($quizid))
                            <tr class="info">
                                <td style="vertical-align:middle;">@if(isset($quiz->doq_quizid) && $quiz->doq_quizid !==null){{$quiz->doq_quizid}}@endif</td>
                                <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
                                                            $st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
                                                            for($i = 0; $i < 30; $i++) {
                                                                $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                                $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                            } 
                                                            echo $st  ?></td>
                                <td style="vertical-align:middle;">{{config('consts')['QUIZ']['APP_RANGES'][$quiz->app_range]}}</td>
                                <td style="vertical-align:middle;">{{date_format(date_create($quiz->published_date),'Y-m-d')}}</td>
                                <td style="vertical-align:middle;">{{$quiz->RegisterShow()}}</td>
                                <td style="vertical-align:middle;">{{$quiz->OverseerShow()}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswer}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswerright}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswerwrong}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswershorttime}}</td>
                            </tr>
                        @else                                                              
                            @foreach($quizes as $key=>$quiz)                                                                 
                            <tr class="info">
                                <td style="vertical-align:middle;">@if(isset($quiz->doq_quizid) && $quiz->doq_quizid !==null){{$quiz->doq_quizid}}@endif</td>
                                <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
        													$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
                                                            for($i = 0; $i < 30; $i++) {
                                                                $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                                $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                            } 
                                                            echo $st  ?></td>
                                <td style="vertical-align:middle;">{{config('consts')['QUIZ']['APP_RANGES'][$quiz->app_range]}}</td>
                                <td style="vertical-align:middle;">{{date_format(date_create($quiz->published_date),'Y-m-d')}}</td>
                                <td style="vertical-align:middle;">{{$quiz->RegisterShow()}}</td>
                                <td style="vertical-align:middle;">{{$quiz->OverseerShow()}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswer}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswerright}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswerwrong}}</td>
                                <td style="vertical-align:middle;">{{$quiz->quizanswershorttime}}</td>
                            </tr>   
                            @endforeach   
                        @endif                                              
                    </tbody>
                </table>
                </form>
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
        var recommend = 0;
       
        $("select[name=recommend]").change(function(){
            var temp = $("select[name=recommend]").val();
            var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];

            if( temp != ""){
                recommend = pointarray[temp];
            }
            $("input[name=recommend_coefficient]").val(recommend);
            
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop