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
	                	 > 読Qからの連絡帳
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Qからの連絡帳</h3>

			<div class="portlet-body" style="height: 420px;">
				<div class="table-scrollable table-scrollable-borderless scroller" style="height:400px;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">						
					<table class="table table-no-border" >
						
						@foreach($messages as $message)
						<tr class="text-md-center info" style="font-size:16px;white-space:nowrap;">						   
						    <td class="col-md-2 col-xs-2">{{date_format(date_create($message->created_at), "Y/m/d")}}</td>
						    <td class="col-md-2 col-xs-2" >
						    	@if($message->from_id == $user->id)<?php echo  '協会' ?>
								@elseif($message->from_id == 1)<?php echo  '協会' ?>
								@else
									<?php echo $message->name ?>
								@endif
						    </td>
							<td class="col-md-8 col-xs-8 text-md-left" >
								@if($message->from_id == $user->id)
									@if($message->type == 2)
										@if($message->post) 
									 		{{"「返信内容」".$message->post."「お問合せ」".$message->content}}
									 	@else
									 		{{"「お問合せ」".$message->content}}
									 	@endif
									@else
										<?php echo  $message->post ?>
									@endif
								@else
									<?php echo $message->content ?>
								@endif
							</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
			<div class="row">
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