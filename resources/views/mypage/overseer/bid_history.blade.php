@extends('layout')

@section('styles')
	<style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;
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
	            	> <a href="{{url('/mypage/top')}}">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修応募履歴
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修応募履歴</h3>

			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="blue">
									<th class="col-md-2 col-xs-2">応募日</th>
									<th class="col-md-2 col-xs-2">タイトル</th>
									<th class="col-md-2 col-xs-2">著者</th>
									<th class="col-md-1 col-xs-1">読Q本ID</th>
									<th class="col-md-2 col-xs-2">応募理由</th>
									<th class="col-md-2 col-xs-2">決定通知日</th>
									<th class="col-md-1 col-xs-1">監修</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								@foreach($demands as $demand)
								<tr>
									<td>{{with((date_create($demand->updated_at)))->format('Y/m/d')}}</td>
									<td><a @if($demand->Book->active >= 3) href="{{url('/book/' . $demand->book_id . '/detail')}}" @endif class="font-blue-madison">{{$demand->Book->title}}</a></td>
									<td><a href="{{url('/book/search_books_byauthor?writer_id=' . $demand->Book->writer_id.'&fullname='.$demand->Book->fullname_nick())}}" class="font-blue-madison">{{$demand->Book->fullname_nick()}}</a></td>
									<td>dq{{$demand->book_id}}</td>
									<td>{{$demand->reason}}</td>
									<td>
										@if($demand->overseer_id == $user->id && $demand->Book->active >= 5)
										{{with((new Date($demand->Book->replied_date3)))->format("Y/m/d")}}
										@endif
									</td>
									<td>
										@if($demand->Book->active >= 5)
											@if($demand->overseer_id == $user->id && $demand->status == 1)
											〇
											@else
											X
											@endif
										{{--@elseif($book->active == 3)--}}
										    {{--<a class="btn btn-warning doq_btn" href="{{url('/mypage/demand/'.$book->id)}}">申請</a>--}}
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>	
					</div>
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