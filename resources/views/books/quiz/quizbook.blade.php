@extends('layout')

@section('styles')
    <style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
		}
	</style>
@stop

@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズ募集中の本リスト</h3>

			<div class="row">
				<div class="col-md-12">
					@if(isset($message))
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							{{$message}}
						</p>
					</div>
					@endif
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
						    <thead>
						    	<tr class="success">
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>					        
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>
							        <th>出題数</th>
							        <th>今集まっているクイズ数</th>
							        
						        </tr>
						    </thead>
						    <tbody class="text-md-center">
								@foreach ($books as $book)
								<tr>
									<td style="vertical-align:middle">{{ with((date_create($book->replied_date1)))->format('Y/m/d') }}</td>
									<td style="vertical-align:middle"><a @if($book->active >= 3) href="{{url('/book/' . $book->id . '/detail')}}" @endif class="font-blue">{{$book->title}}</a></td>
									<td style="vertical-align:middle"><a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue">{{$book->fullname_nick()}}</a></td>
									<td style="vertical-align:middle">dq{{$book->id}}</td>
									<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
									<td style="vertical-align:middle">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
									<td style="vertical-align:middle">{{$book->quiz_count}}</td>
									<td style="vertical-align:middle">{{$book->ActiveQuizes()->count()}}</td>
									
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/')}}" class="btn btn-info pull-right" role="button">戻　る</a>
				</div>
			</div>
		</div>
	</div>

@stop
@section('scripts')
<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
        $(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop