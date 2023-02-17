@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' )}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-datepicker/css/datepicker3.css')}}">
<style type="text/css">
    td{
        text-align: center;
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
                        > 読Qトップお知らせ追加編集
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
					<h3>読Qトップ画面のお知らせ 追加編集</h3>
				</div>
			</div>
            <div class="row">
                <div class="col-md-11">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">読Qホーム画面　　お知らせ文面の追加</div>
                        </div>
                        <div class="portlet-body">
                            <form id = "add_form" class="form form-horizontal" method="get" action="{{url('admin/notice')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-1" for="pwd">日付:</label>
                                        <div class="col-sm-3">          
                                            <input type="text" class="form-control form-control-inline date-picker" name = "add_date" id="add_date" readonly>
                                        </div>
                                        
                                        <label class="control-label col-sm-1" for="pwd">文面:</label>
                                        <div class="col-sm-5 {{ $errors->has('content') ? ' has-danger' : '' }}">          
                                            <input required type="text" class="form-control" id="content" name="content" >
                                            @if ($errors->has('content'))
                                                <span class="form-control-feedback">
                                                    <span>{{ $errors->first('content') }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">                                   
                                        <label class="control-label col-sm-1" for="outside_link">外部 URL:</label>
                                        <div class="col-sm-5 {{ $errors->has('content') ? ' has-danger' : '' }}">          
                                            <input required type="text" class="form-control" id="outside_link" name="outside_link" >
                                            @if ($errors->has('content'))
                                                <span class="form-control-feedback">
                                                    <span>{{ $errors->first('content') }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <input type="hidden" id="contentflag" name="contentflag" value="{{isset($contentflag)? $contentflag : ''}}" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-1" style="align-self: center;">
                    
                    <button id = "add_notice" type="button" class="btn btn-primary" style="margin-bottom:8px;">
                        送　信
                    </button>
           
                    <span id="mail_send" class="form-control-feedback hidden" style="color:red; font-size:10px">
                        <span>{{config('consts')['MESSAGES']['MSG_MAIL_SEND']}}</span>
                    </span>
                   
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">読Qホーム画面　　お知らせ文面の編集</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1">
                                <thead>
                                    <tr>
                                        <th>日付</th>
                                        <th>文面</th>
                                        <th>外部 URL</th>
                                        <th style="text-align:center;">編集する</th>
                                        <th style="text-align:center;">削除</th>
                                    </tr>
                                </thead>
                                <tbody class="text-md-center">
                                    @foreach($notices as $notice)
                                    <tr>
                                        
                                            <td id = "update-date{{$notice->id}}"> 
                                                {{date_format($notice->updated_at,"Y")."-".date_format($notice->updated_at,"m")."-".date_format($notice->updated_at,"d")}}
                                            </td>
                                            <td id = "update-content{{$notice->id}}">
                                                {{$notice->content}}
                                            </td>
                                            <td id = "update-outside_link{{$notice->id}}">
                                                {{$notice->outside_link}}
                                            </td>
                                        <td>
                                            <a class="edit" id = "{{$notice->id}}" href="javascript:;">
                                                編集する
                                            </a>
                                        </td>
                                        <td>
                                            <a id = "{{$notice->id}}" class="delete" href="javascript:;">
                                                削除
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $notices->render() !!}
                            <form style = "display:none;" id = "update_form" class="form form-horizontal" action="{{url('admin/notice_update_edit')}}">
                                <div class="form-body">
                                    <div class="form-group">
                                        <input type="hidden" name ="update_id" id ="update_id"> 
                                        <input type="hidden" name ="update_date" id ="update_date"> 
                                        <input type="hidden" name ="update_content" id ="update_content"> 
                                        <input type="hidden" name ="update_outside_link" id ="update_outside_link"> 
                                    </div>
                                </div> 
                            </form>
                            <form style = "display:none;" id = "delete_form" class="form form-horizontal" action="{{url('admin/notice_delete_edit')}}">
                                <div class="form-body">
                                    <div class="form-group">
                                        <input type="hidden" name ="delete_id" id ="delete_id"> 
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-md-center">
                    <a href="{{url('/')}}" class="btn btn-success" role="button" style="margin-bottom:8px;">読Qトップ画面を確認する</a>
                </div>
                <div class="col-md-4">
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
            <h4 class="modal-title"><strong>読Q</strong></h4>
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
@stop
@section('scripts')
        
    <script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables.min.js' )}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' )}}"></script>
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    <script src="{{asset('js/data-table-search.js')}}"></script>
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
    <script>
        jQuery(document).ready(function() {
            TableEditable.init();
           // $('body').addClass('page-full-width');
            ComponentsDropdowns.init();

            if($("#contentflag").val() !=""){
                $("#mail_send").removeClass("hidden");
            }else{
                $("#mail_send").addClass("hidden");   
            }

            

            //remove search_input and pagination bar
            $("#sample_editable_1_wrapper").children("div").remove(".row");
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: 'ja'
            });
            $("#add_notice").click(function(){
                 // if($("#content").val() != ""){
                        //$("#add_form").submit();
                //}
                var info = {
                    add_date: $("#add_date").val(),
                    content: $("#content").val(),
                    outside_link: $("#outside_link").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    type: "post",
                    url: "{{url('/admin/notice_add_edit')}}",
                    data: info,

                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response){
                        if(response.status == 'success'){
                            $("#contentflag").val(1)
                            $("#add_form").submit();
                        } else if(response.status == 'failed') {
                        }
                    },
                    error: function (err) {
                        alert("error");
                        $(".failed-alert").css('display','block');
                    }
                });
            });
            $(".delete").click(function () {
                $("#delete_id").val($(this).attr("id"));
                $("#alert_text").html("{{config('consts')['MESSAGES']['CONFIRM_DELETE']}}");
                $("#alertModal").modal();
            });
            $(".confirm").click(function() {
                $("#delete_form").submit();
            });
        });
    </script>

@stop

