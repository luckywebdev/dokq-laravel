@extends('layout')
@section('styles')
    <!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{asset('css/pages/timeline.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('css/pages/news.css')}}" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
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
                	<a href="{{url('/about_site')}}"> > 読Qとは</a>
	            </li>
	             <li class="hidden-xs">
                	<a href="#"> > 監修者紹介</a>
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
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">監修者紹介</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<p style="font-size:16px;">
						監修者とは、担当する本の、クイズを監修する人です。会員が作ったクイズを選定し、正式な検定問題として認定する権限を持ちます。認定後も、クイズや帯文投稿など、その本のページの監修を続けていただきます。<br>
						監修者には、著者の方や学校教師の方もいます。
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<select class="bs-select form-control">
						<option value="0" @if($order == 0) selected @endif>ポイント順に並べ替え</option>
						<option id="name_order" value="1" @if($order == 1) selected @endif>五十音順に並べ替え</option>
					</select>
				</div>
			
			</div>

			<!-- BEGIN PAGE CONTENT-->
			<div class="timeline">
				<!-- TIMELINE ITEM -->
				@foreach($overseers as $overseer)
				<div class="timeline-item">
					<div class="timeline-badge">
						<img class="timeline-badge-userpic" src="{{asset($overseer->myprofile)}}">
					</div>
					<div class="timeline-body" style="padding-top:0px;padding-bottom:0px;">
						<div class="timeline-body-arrow">
						</div>
						<div class="timeline-body-head">
							<div class="timeline-body-head-caption">
								<a class="timeline-body-title font-blue-madison" href="{{url('mypage/other_view/' . $overseer->id)}}">@if($overseer->isAuthor()){{$overseer->fullname_nick()}}@else{{$overseer->fullname()}}@endif</a>
							</div>
						</div>
						<div class="timeline-body-content">
							<table class="table table-no-border" style="margin-top:5px;margin-bottom:5px;">
								<tr>
									<td style="padding-top:0px;padding-bottom:0px; width: 35%">居住地</td>
									<td style="padding-top:0px;padding-bottom:0px; width: 65%">@if($overseer->address1_is_public == 1){{$overseer->address1}}@else @endif&nbsp;&nbsp; @if($overseer->address2_is_public == 1){{$overseer->address2 }}@else @endif</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">監修した本の合計読Qﾎﾟｲﾝﾄ</td>
									<td style="padding-top:0px;padding-bottom:0px;">{{floor($overseer->point*100)/100}}ポイント</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">監修した本</td>
									<td style="padding-top:0px;padding-bottom:0px;">
									 <?php
									 if($overseer->overseerbook_list !== null && $overseer->overseerbook_list != '')
									 	$overseerbook_list = preg_split('/,/', $overseer->overseerbook_list);
									 else
									 	$overseerbook_list = $overseer->overseerBooks($overseer);
									 ?>
									 @foreach($overseerbook_list as $key=> $book_id)
									 	<?php $book = $overseer->getBook($book_id); ?>
									 	 @if($key + 1 == count($overseerbook_list))
									 		<a href="{{url('/book/'.$book['id'].'/detail' )}}">{{$book['title']}}</a>
									 	 @else
									 	 	<a href="{{url('/book/'.$book['id'].'/detail' )}}">{{$book['title']}}、&nbsp;</a>
									 	 @endif
									 @endforeach
									</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">最終学歴</td>
									<td style="padding-top:0px;padding-bottom:0px;">{{$overseer->scholarship}}</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">職業</td>
									<td style="padding-top:0px;padding-bottom:0px;">{{$overseer->job}}</td>
								</tr>
								<tr>
									<td style="padding-top:0px;padding-bottom:0px;">読書について</td>
									<td style="padding-top:0px;padding-bottom:0px;">{{$overseer->about}}</td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
				<!-- END TIMELINE ITEM -->
				<!-- TIMELINE ITEM -->
				@endforeach
				<!-- END TIMELINE ITEM -->
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	
	<form id="order_form" action="" method="get">
		<input type="hidden" id="order" name="order" value="">
	</form>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script src="{{asset('js/timeline.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('body').addClass('page-container-bg-solid');
			ComponentsDropdowns.init();
//			Timeline.init(); // init timeline page
//			alert("dd");
			$('select').change(function(){
//				if($(':selected').attr('id') == 'name_order'){
//					
//					}
   
				$("#order").val($(this).val());
				$("#order_form").attr("method", "get");
				$("#order_form").attr("action", "{{url('/about_overseer')}}");
				$("#order_form").submit();
				})

		});
    </script>
@stop