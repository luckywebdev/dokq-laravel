@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
<style>
    .arrow{
        display: none!important;
    }
    .popover{
        float: right!important;
        margin-left: -135px!important;
        margin-top: 10px;
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
                    <a href="{{url('/mypage/top')}}">
                         > マイ書斎
                    </a>
                </li>
                <li class="hidden-xs">
                    <a href="#">
                         > 読Q活動の履歴
                    </a>
                </li>
                <li class="hidden-xs">
                    <a href="#">
                        > 帯文投稿履歴といいね！
                    </a>
                </li>
            </ol>
        </div>
    </div>
@stop
@section('contents')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12"> 
                    <h3 class="page-title caption col-md-11">帯文投稿履歴といいね！</h3>
                    @if(!$otherview_flag)
                    <h5>公開</h5>                   
                    @endif
                </div>
            </div>
            <div class="row">
                <div class = "col-md-12">               
                    <form class="form form-horizontal" >
                        <div class="">
                            <table class="table table-bordered table-hover" @if(!$otherview_flag) id="article_history1" @else id="article_history2" @endif >
                                <thead>
                                    <tr class="blue">
                                        @if(!$otherview_flag) <th class="col-md-1">選択</th> @endif
                                        <th class="col-md-1">投稿日</th>
                                        <th class="col-md-2">タイトル</th>
                                        <th class="col-md-1">著者</th>
                                        <th class="col-md-3">帯文</th>
                                        <th class="col-md-2">いいね！人数</th>
                                        <th class="col-md-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-md-center">
                                    @foreach($articles as $article)
                                        <tr class="info">
                                            @if(!$otherview_flag) <td class="align-middle"><input id ="{{$article->id}}" type="checkbox" class="checkboxes"></td> @endif
                                            <td class="align-middle">{{date_format(date_create($article->created_at), "Y/m/d")}}</td>
                                            <td class="align-middle">{{$article->title}}</td>
                                            <td class="align-middle">{{$article->firstname_nick.' '.$article->lastname_nick}}</td>
                                            <td class="align-middle">{{$article->content}}</td>
                                            <td class="align-middle">{{$article->cnt}}人</td>
                                            <td class="align-middle">
                                            <!-- <a id ="{{$article->id}}" class="font-blue-madison" data-toggle="popover" title=" " data-placement="left"> -->
                                            <a id ="{{$article->id}}" class="font-blue-madison">いいね！した人を見る</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       
                        <div class="text-md-left">
                             @if(!$otherview_flag)  <button id = "delete_btn" type="button" class="offset-md-1 btn btn-primary">選択した投稿を削除する</button> @endif  
                            <button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="popup" style="display:none;z-index:1000;">
                       </div>
            <form class="form form-horizontal" name = "value" id = "value" action = "/mypage/article_history">
                <input type = "hidden" id = "idarry" name = "idarry">
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(window).load(function(){
            
        });
        $(document).ready(function(){
            @if($otherview_flag)
                $('body').addClass('page-full-width');
                var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
            @endif
            $('.make-switch').bootstrapSwitch({
                onText: "公開",
                offText: "非公開"
            });
            
            $("#delete_btn").click(function(){
                var idarry = "";
                $(".checked").each(function() {
                    if (idarry.length > 0)
                        idarry += ",";
                    idarry += $(this).find("input").attr("id");
                });
                $("#idarry").val(idarry);
                $("#value").submit();
            });

            $(".make-switch").on('switchChange.bootstrapSwitch', function(){
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
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
                    }
                });
            });
            
            /*$('[data-toggle="popover"]').popover(); 
            $(".font-blue-madison").click(function(){
                $('[data-toggle="popover"]').popover('destroy'); 
                
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/article_history_ajax/" + $(this).attr('id');
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
                        $('[data-toggle="popover"]').popover(); 
                        $(".popover-content").html(response);
                        //$("#user_list").modal();
                    }
                });
            });*/
            $(".font-blue-madison").click(function(){
                
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/article_history_ajax/" + $(this).attr('id');
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
                        
                        $("#popup").html(response);
                       
                    }
                });
            });

            $("body").on("click", "a.font-blue-madison", function(e) {
                               
                $("#popup").show();
                $("#popup").css("position","absolute");
                var pageWidth = $(window).width();
                
                if(pageWidth > 768){
                    $("#popup").css("left",e.pageX-130);
                    $("#popup").css("top",e.pageY-160);
                }else{
                    $("#popup").css("left",e.pageX-130);
                    $("#popup").css("top",e.pageY-200);
                }
                
                return false;
            });

            $("body").click(function(){
                $("#popup").hide();
            });
            
            /*$(".bootstrap-switch-id-vote_record_is_public").click(function(){
                var innerHtml = $("#switch-wrapper").html();
                if (innerHtml.search("bootstrap-switch-on") == -1)  $cnt = 0;
                else $cnt = 1;
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    cnt: $cnt
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/article_history/";
                $.ajax({
                    type: "get",
                    url: post_url,
                    data: info,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response){
                    }
                });
                
            });*/
        });
    </script>
@stop