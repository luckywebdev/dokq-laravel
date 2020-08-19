@extends('layout')

@section('styles')
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
	            	
	                	 > 自著リスト
	               
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">自著リスト</h3>

			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="blue">
									<th class="col-md-1">監修決定日</th>
									<th class="col-md-2">タイトル</th>
									<th class="col-md-1">読Q本ID</th>
									<th class="col-md-1" style="padding-left:0px;padding-right:0px;">読Q本認定日</th>
									<th class="col-md-1">出題数</th>
									<th class="col-md-1">認定ｸｲｽﾞ数</th>
									<th class="col-md-1">帯文管理</th>
									<th class="col-md-2" style="padding-left:0px;padding-right:0px;">各書籍のクイズストックへ</th>
									<th class="col-md-1">読Q合格者数(女）</th>
									<th class="col-md-1">読Q合格者数（男）</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								@foreach($mywriteBooks as $book)
								<tr>
									<td style="vertical-align:middle;">@if(count($book->Overseer) == 0) {{with((date_create($book->replied_date1)))->format('Y/m/d')}} @else {{with((date_create($book->replied_date3)))->format('Y/m/d')}}@endif</td>
									<td style="vertical-align:middle;"><a @if($book->active >= 3) href="{{url('/book/'.$book->id.'/detail')}}" @endif class="font-blue-madison">{{$book->title}}</a></td>
									<td style="vertical-align:middle;">dq{{$book->id}}</td>
									<td style="vertical-align:middle;">{{with((date_create($book->updated_at)))->format('Y/m/d')}}</td>								
									<td style="vertical-align:middle;">{{$book->quiz_count}}</td>
									<td style="vertical-align:middle;">{{$book->ActiveQuizes()->count()}}</td>
									<td style="vertical-align:middle;">
									@if(Auth::id() == $book->writer_id)
									<a href="{{url('/book/'.$book->id.'/article/manage')}}" class="font-blue-madison">帯文管理</a>
									@else
									...
									@endif
									</td>
									<td style="vertical-align:middle;">
									@if(Auth::id() == $book->writer_id)
									<a href="{{url('/mypage/quiz_store/1/'.$book->id)}}" class="font-blue-madison">クイズストック</a>
									@else
									...
									@endif
									</td>
									<td style="vertical-align:middle;">{{count($book->passedwomanNum)}}</td>
									<td style="vertical-align:middle;">{{count($book->passedmanNum)}}</td>
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