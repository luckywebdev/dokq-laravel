
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
                        > データ選択・作業選択
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('contents')
    <div class="page-content-wrapper form-horizontal">
        <div class="page-content form-body">
            <h3 class="page-title">データ選択・作業選択</h3>
            <br>
            <form class="form-horizontal" action="" method="post" id="data_result">
            {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-md-3">データ種類選択</label>
                    <div class="col-md-4">
                        <select class="form-control input-large select2me" name="booktype_sel" id="booktype_sel" data-placeholder="選択...">
                            <option value=""></option>
                            <option value="data_card_per" @if(old('booktype_sel') == 'data_card_per') selected @endif>個人カード</option>
                            <option value="data_card_org" @if(old('booktype_sel') == 'data_card_org') selected @endif>団体カード</option>
                            <option value="data_card_book" @if(old('booktype_sel') == 'data_card_book') selected @endif>読Q本カード</option>
                            <option value="data_card_quiz" @if(old('booktype_sel') == 'data_card_quiz') selected @endif>読Q本クイズデータ</option>
                            <option value="per_use_history" @if(old('booktype_sel') == 'per_use_history') selected @endif>個人利用履歴</option>
                            <option value="org_use_history" @if(old('booktype_sel') == 'org_use_history') selected @endif>団体利用履歴</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control @if(old('booktype_sel')== '' || old('booktype_sel')== 'per_use_history' || old('booktype_sel')== 'org_use_history') hide @endif" 
                                type="text" id="username" name="username"  value="{{old('username')}}" 
                                placeholder="@if(old('booktype_sel') == 'data_card_book') 読Q本ID入力 @elseif(old('booktype_sel') == 'data_card_quiz') 読Qクイズ№入力 @else 読Qネーム入力欄 @endif">
                    </div>
                </div>            
                <div class="form-group">
                    <label class="control-label col-md-3">期間選択</label>
                    <div class="col-md-4">
                        <select class="form-control input-large select2me" name="period_sel" id="period_sel" data-placeholder="選択...">
                            <option value=""></option>
                            <option value="1">直近12時間</option>
                            <option value="2">昨日（0時～23時59分）</option>
                            <option value="3">直近1週間</option>
                            <option value="4">直近1か月</option>
                            <option value="5">直近3カ月</option>
                            <option value="6">直近6カ月</option>
                            <option value="7">直近1年</option>
                            <option value="8">全期間</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">利用履歴選択</label>
                    <div class="col-md-4">
                        
                        <select class="form-control input-large select2me" name="per_usehistory_sel" id="per_usehistory_sel" data-placeholder="選択...">
                            <option value=""></option>
                            <option value="1">クイズ受検</option>
                            <option value="2">会員履歴</option>
                            <option value="3">投稿</option>
                            <option value="4">本の登録とクイズ作成</option>
                            <option value="5">監修者</option>
                            <option value="6">試験監督</option>
                            <option value="7">本の検索</option>
                            <option value="8">協会</option>
                            <option value="9">すべて選択</option>
                        </select>
                        <select class="form-control input-large select2me hide" name="data_usehistory_sel" id="data_usehistory_sel" data-placeholder="選択...">
                            <option value=""></option>
                            <option value="1">ログイン・ログアウト</option>
                            <option value="2">団体試験監督</option>
                            <option value="3">児童生徒情報</option>
                            <option value="4">教職員情報</option>
                            <option value="5">お知らせ</option>
                            <option value="6">団体基本情報</option>
                            <option value="7">支払い</option>
                            <option value="8">すべて選択</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">作業/判定選択（任意）</label>
                    <div class="col-md-4">
                        <select class="form-control select2me calc" name="usetype_sel[]" id="usetype_sel" multiple placeholder="すべて選択..." style="min-width:100px;">
                            <option value=""></option>
                            <option value="1">開始</option>
                            <option value="2">誤答</option>
                            <option value="3">正答</option>
                            <option value="4">合格</option>
                            <option value="5">不合格1度目</option>
                            <option value="6">不合格2度目</option>
                            <option value="7">不合格2度目以上</option>
                        </select>
                    </div>
                </div>
               </form> 
               <div class="row">
                <div class="offset-md-3 col-md-5 text-md-center">
                <span class="form-control-feedback">
                    @if ($errors->has('nouser'))
                    <span class="offset-md-3 col-md-5 text-md-center" style="color:#ff005e;font-size:16px">
                    {{ $errors->first('nouser') }}
                    </span>    
                    @endif
                </span>                                                            
                </div>
            </div>
            <div class="row">
                <div class="offset-md-5  col-md-6">
                    <button id="display_btn" class="btn btn-primary">表　示</button>    
                    <button id="next_btn" class="btn btn-warning">CSVダウンロード</button>    
                    <a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>

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
@stop
@section('scripts')
    <script type="text/javascript">

        var period_sel = $("#period_sel").select2();
        var per_usehistory_sel = $("#per_usehistory_sel").select2();
        var data_usehistory_sel = $("#data_usehistory_sel").select2();
        var usetype_sel = $("#usetype_sel").select2();
        
        $("select[name=booktype_sel]").change(function(){
            if ($(this).val() == "data_card_per" || $(this).val() == "data_card_org" || $(this).val() == "data_card_book" || $(this).val() == "data_card_quiz"){
                $("#username").removeClass('hide');
                $("#display_btn").removeClass("hide");
 
                if($(this).val() == "data_card_per" || $(this).val() == "data_card_org"){
                    $("#username").attr('placeholder','読Qネーム入力');
                    $("#next_btn").removeClass("hide");
                    $("#period_sel").attr('disabled', false);
                }
                else if($(this).val() == "data_card_book"){
                    $("#username").attr('placeholder','読Q本ID入力');
                    $("#next_btn").removeClass("hide");
                    $("#period_sel").attr('disabled', false);
                }
                else if($(this).val() == "data_card_quiz"){
                    $("#username").attr('placeholder','読Qクイズ№入力');
                    $("#next_btn").addClass("hide");
                    $("#period_sel").attr('disabled', true);
            }

                period_sel.select2('val', ""); //初期化
                per_usehistory_sel.select2('val', ""); //初期化
                $("#per_usehistory_sel").attr('disabled', true);
                data_usehistory_sel.select2('val', ""); //初期化
                $("#data_usehistory_sel").attr('disabled', true);
                usetype_sel.select2('val', ""); //初期化
                $("#usetype_sel").attr('disabled', true);
            }else if($(this).val() == "per_use_history" || $(this).val() == "org_use_history"){
                $("#username").addClass('hide');
                $("#display_btn").addClass("hide");
                $("#next_btn").removeClass("hide");


                if($(this).val() == "per_use_history"){
                    $("#per_usehistory_sel").removeClass('hide');
                    $("#data_usehistory_sel").addClass('hide');
                }else if($(this).val() == "org_use_history"){
                    $("#per_usehistory_sel").addClass('hide');
                    $("#data_usehistory_sel").removeClass('hide');
                }
                period_sel.select2('val', ""); //初期化
                per_usehistory_sel.select2('val', ""); //初期化
                data_usehistory_sel.select2('val', ""); //初期化
                usetype_sel.select2('val', ""); //初期化
                $("#period_sel").attr('disabled', false);
                $("#per_usehistory_sel").attr('disabled', false);
                $("#data_usehistory_sel").attr('disabled', false);
                $("#usetype_sel").attr('disabled', false);
            }
        });

        $("select[name=per_usehistory_sel]").change(function(){
            
            var kind = new Array();
            var html = "";
            switch(parseInt($(this).val())){
                case 1:
                    <?php foreach (config('consts')['HISTORY']['QUIZTEST_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 2:
                    <?php foreach (config('consts')['HISTORY']['USERWORK_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 3:
                    <?php foreach (config('consts')['HISTORY']['CONTRIBUTION_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 4:
                    <?php foreach (config('consts')['HISTORY']['BOOKQUIZ_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 5:
                    <?php foreach (config('consts')['HISTORY']['OVERSEER_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 6:
                    <?php foreach (config('consts')['HISTORY']['TESTOVERSEE_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 7:
                    <?php foreach (config('consts')['HISTORY']['BOOKSEARCH_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 8:
                    <?php foreach (config('consts')['HISTORY']['ADMIN_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 9:
                    kind = new Array();
                    break;
            };

            usetype_sel.select2('val', ""); //初期化
            
            $("#usetype_sel").html("");
            $("#usetype_sel").html(html);
        });

        $("select[name=data_usehistory_sel]").change(function(){
            var kind = new Array();
            var html = "";
            switch(parseInt($(this).val())){
                case 1:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][0]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 2:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][1]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 3:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][2]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 4:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][3]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 5:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][4]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 6:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][5]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 7:
                    <?php foreach (config('consts')['HISTORY']['ORGWORK_HISTORY'][6]['WORK'] as $i => $work ): ?>
                        kind.push("{{$work}}");
                        html += "<option value='"+"{{$i}}"+"'>"+"{{$work}}"+"</option>";
                    <?php endforeach ?>;
                    break;
                case 8:
                    kind = new Array();
                    break;
            };

            usetype_sel.select2('val', ""); //初期化
            
            $("#usetype_sel").html("");
            $("#usetype_sel").html(html);
        });

        $("#next_btn").click(function(){
            if($("select[name=booktype_sel]").val() == null || $("select[name=booktype_sel]").val() == ''){
                 $("#alert_text").html("{{config('consts')['MESSAGES']['DATATYPE_REQUIRED']}}");
                 $("#alertModal").modal();
                 return;
            }
            if($("select[name=period_sel]").val() == ''){
                    $("#alert_text").html("{{config('consts')['MESSAGES']['PERIOD_SELECTED']}}");
                    $("#alertModal").modal();
                    return;
            }
            if($("select[name=booktype_sel]").val() == 'per_use_history'){
                if($("select[name=period_sel]").val() == ''){
                    $("#alert_text").html("{{config('consts')['MESSAGES']['PERIOD_SELECTED']}}");
                    $("#alertModal").modal();
                    return;
                }else{
                    if($("select[name=per_usehistory_sel]").val() == ''){
                        $("#alert_text").html("{{config('consts')['MESSAGES']['USEHISTORY_SELECTED']}}");
                        $("#alertModal").modal();
                        return;
                    }
                }
            }

            if($("select[name=booktype_sel]").val() == 'org_use_history' ){
                if($("select[name=period_sel]").val() == ''){
                    $("#alert_text").html("{{config('consts')['MESSAGES']['PERIOD_SELECTED']}}");
                    $("#alertModal").modal();
                    return;
                }else{
                    if($("select[name=data_usehistory_sel]").val() == ''){
                        $("#alert_text").html("{{config('consts')['MESSAGES']['USEHISTORY_SELECTED']}}");
                        $("#alertModal").modal();
                        return;
                    }
                }
            }

            if($("select[name=booktype_sel]").val() == 'data_card_per'){
                $("#data_result").attr('action', '/admin/export_personal_list');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_org'){
                $("#data_result").attr('action', '/admin/export_group_list');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_book'){
                $("#data_result").attr('action', '/admin/export_book_data');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_quiz'){
                $("#data_result").attr('action', '/admin/quizdata_view');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'per_use_history'){
                $("#data_result").attr('action', '/admin/exportPersonaluseData');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'org_use_history'){
                $("#data_result").attr('action', '/admin/export_school_data');
                $("#data_result").submit();
                return;
            }
        });

        $("#display_btn").click(function(){
            if($("select[name=booktype_sel]").val() == null || $("select[name=booktype_sel]").val() == ''){
                 $("#alert_text").html("{{config('consts')['MESSAGES']['DATATYPE_REQUIRED']}}");
                 $("#alertModal").modal();
                 return;
            }

            if(!$("#username").hasClass('hide') && $("#username").val() == ''){
                if($("select[name=booktype_sel]").val() == 'data_card_per' || $("select[name=booktype_sel]").val() == 'data_card_org')
                    $("#alert_text").html("{{config('consts')['MESSAGES']['USERNAME_REQUIRED']}}");
                else if($("select[name=booktype_sel]").val() == 'data_card_book')
                    $("#alert_text").html("{{config('consts')['MESSAGES']['BOOKID_REQUIRED']}}");
                else if($("select[name=booktype_sel]").val() == 'data_card_quiz')
                    $("#alert_text").html("{{config('consts')['MESSAGES']['QUIZID_REQUIRED']}}");
                
                $("#alertModal").modal();
                return;
            }
            if($("select[name=booktype_sel]").val() == 'data_card_per'){
                $("#data_result").attr('action', '/admin/data_card_per');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_org'){
                $("#data_result").attr('action', '/admin/data_card_org_view');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_book'){
                $("#data_result").attr('action', '{{url("/admin/bookdata_view")}}');
                $("#data_result").submit();
                return;
            }else if($("select[name=booktype_sel]").val() == 'data_card_quiz'){
                $("#data_result").attr('action', '/admin/quizdata_view');
                $("#data_result").submit();
                return;
            }

        });
    </script>
@stop