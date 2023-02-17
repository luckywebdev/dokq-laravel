<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	<strong> {{$message->created_at->format('Y年 n月 d日')}} お知らせ!</strong>
	<strong class="float-right tooltips" data-toggle="tooltip" title="Tooltip on left" data-container="body" data-placement="top" data-title="{{$message->created_at->format('F d, Y')}}">
		{{$message->created_at->diffForHumans()}}
	</strong>
	<p>
		<?php echo $message->content ?>
	</p>
</div>
