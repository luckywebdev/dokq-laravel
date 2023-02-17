@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' )}}"/>
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
					<h3>協会の基本情報</h3>
				</div>
			</div>
            <div class="row">
                <div class="col-md-11">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">読Qホーム画面　　お知らせ文面の追加</div>
                        </div>
                        <div class="portlet-body">
                            <form class="form form-horizontal" >
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-1" for="pwd">日付:</label>
                                        <div class="col-sm-3">          
                                            <input type="text" class="form-control form-control-inline date-picker" id="date" readonly>
                                        </div>
                                        
                                        <label class="control-label col-sm-1" for="pwd">文面:</label>
                                        <div class="col-sm-5">          
                                            <input type="text" class="form-control" id="message" >
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-1" style="align-self: center;">
                    <button type="button" class="btn btn-warning">
                        送信
                    </button>
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
                                        <th style="text-align:center;">編集する</th>
                                        <th style="text-align:center;">削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2017/7/8</td>
                                        <td>
                                           
                                                読Q会員が〇〇〇〇〇人になりました！
                                         
                                        </td>
                                        <td>
                                            <a class="edit" href="javascript:;">
                                                編集する
                                            </a>
                                        </td>
                                        <td>
                                            <a class="delete" href="javascript:;">
                                                削除
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2017/7/1</td>
                                        <td>
                                           
                                                読Q本が、〇〇〇〇〇冊を突破しました！
                                         
                                        </td>
 
                                        <td>
                                            <a class="edit" href="javascript:;">
                                                編集する
                                            </a>
                                        </td>
                                        <td>
                                            <a class="delete" href="javascript:;">
                                                削除
                                            </a>
                                        </td>
                                    </tr>
   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-1" style="align-self: center;">
                    <button type="button" class="btn btn-warning">
                        送信
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-md-center">
                    <a href="#" class="btn btn-success" role="button">読Qトップ画面を確認する</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{url('/')}}" class="btn yellow pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
        <script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables.min.js' )}}"></script>
        <script type="text/javascript" src="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' )}}"></script>
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    <script>
        jQuery(document).ready(function() {
            TableEditable.init();
            //remove search_input and pagination bar
            $("#sample_editable_1_wrapper").children("div").remove(".row");
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: 'ja'
            });
        });
    </script>

@stop

