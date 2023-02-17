@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
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
	                	 > 試験監督履歴
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
					<div class="col-md-5"></div>	
					<div class="col-md-3">	
						<h3 class="page-title" >試験監督履歴</h3>
					</div>
					<div class="col-md-4">	
						<div class="row">
							<span>監督人数順位：{{$userrank}}位/{{count($aptitudes)}}人  これまでに監督した実人数 {{count($user_histories)}}人</span>
						</div>
						<div class="row">
							<span>監督回数順位：{{$rank}}位/{{count($aptitudes)}}人  これまでに監督した検定回数 {{count($histories)}}回</span>
						</div>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="blue">
								<th class="col-md-2">開始日時</th>
								<th class="col-md-2">終了日時</th>
								<th class="col-md-2">受検者</th>
								<th class="col-md-2">タイトル</th>
								<th class="col-md-1">読Q本ID</th>
								<th class="col-md-1">合否</th>
								<th class="col-md-2">試験監督の方法</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						    @foreach($histories as $history)
							<tr class="info text-md-center">
								<td>{{ $history->created_date }}</td>
								<td @if($history->finished_date == "") style="color:#f00" @endif>@if($history->finished_date == "") （検定中） @else {{ $history->finished_date }} @endif</td>
								<td><a href="{{ url("/mypage/other_view/" . $history->user_id) }}" class="font-blue-madison">@if($history->User->fullname_is_phblic) {{ $history->User->fullname() }} @else {{ $history->User->username }} @endif
								</a></td>
								<td><a @if($history->Book->active >= 3) href="{{ url("/book/" . $history->Book->id . "/detail") }}" @endif class="font-blue-madison">{{ $history->Book->title }}</a></td>
								<td><a @if($history->Book->active >= 3) href="{{ url("/book/" . $history->Book->id . "/detail") }}" @endif class="font-blue-madison">dq{{ $history->Book->id }}</a></td>
								<td>@if($history->status == 3) 合格 @elseif($history->status == 4) 不 @else （検定中） @endif</td>
								<td>@if($history->examinemethod == 0) 顔認証 @elseif($history->examinemethod == 1) パスワード入力 @else  @endif</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="row margin-top-10">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
<script>
	jQuery(document).ready(function() {
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
	});   
</script>
@stop