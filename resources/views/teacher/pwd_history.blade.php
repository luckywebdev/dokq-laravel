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
	            	> <a href="{{url('/')}}">
	                	団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > 試験監督パスワード送信履
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				受検する児童への試験監督パスワード送信履歴
			</h3>

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="info">
                                    <th>パスワード送信日時</th>
                                    <th>受検者</th>
                                    <th>開始時</th>
                                    <th>合格時</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-left">
                                @foreach($overseers as $overseer)
                                <tr class="text-md-center">
                                    <td>{{$overseer->created_at}}</td>
                                    <td>{{$overseer->User->fullname()}}</td>
                                    @if($overseer->type == 1)
                                    <td>〇</td>
                                    <td></td>
                                    @else
                                    <td></td>
                                    <td>〇</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')

@stop