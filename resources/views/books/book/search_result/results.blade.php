	
		@include('partials.books.book_list_item')
	
	
{!! $books->render() !!}
<div class="row">
	<div class="col-md-12 margin-bottom-10">
		@if(isset($_GET['page']) && $_GET['page'] !== null)
			<a href="{{url('book/search')}}" class="btn btn-info pull-right">戻　る</a>
		@else
			<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
		@endif
	</div>
</div>