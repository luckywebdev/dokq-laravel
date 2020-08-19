<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	<strong>エラー! &nbsp;
			@foreach($errors as $error)
				<span>{{$error}}</span>
			@endforeach
	</strong> 
</div>