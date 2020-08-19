@extends('layout')
@section('styles')
@stop
<?php
  if($type=='gene') 
	$page_title = $page_title;
  else if($type=='category')
  	$page_title = $page_title;
  else if($type=='latest')
  	$page_title = $page_title;
  else if($type=='ranking'){
  	$page_title = '';
  	foreach(config('consts')['BOOK']['RANKINGS_title'] as $key=>$ranking){
  		if($key== $rank) $page_title = $ranking.'の';
  	}
  	if($gender== 1) $page_title .= '女子';
  	else if($gender== 2)	$page_title .= '男子';
  	else $page_title .= '男女子';
	$page_title .= 'によく読まれている読Q本ランキング';
  }
?>
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
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> {{$page_title}}
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				@if($type=='ranking')
					{{$page_title}}(合格者人数ランキング）
				@else
					{{$page_title}}
				@endif
			</h3>
			
			@if($type=='ranking')
			<div class="form form-horizontal">
				<form class="form-horizontal" action="{{url('book/search/ranking')}}" method="post">
				{{csrf_field()}}
					<input type="hidden" name="rank" value="{{$rank}}"/>
					<input type="hidden" name="work_test" id="work_test" value="@if(isset($work_test)){{$work_test}} @endif">
					<div class="form-group row">
						<label class="control-label col-md-1 text-md-right">性別</label>
						<div class="col-md-2">
							<select class="bs-select form-control" name="gender">
								<option></option>
								<option value="2" @if(isset($gender) && $gender == 2) selected @endif>男</option>
								<option value="1" @if(isset($gender) && $gender == 1) selected @endif>女</option>
								<option value="3" @if(isset($gender) && $gender == 3) selected @endif>男女分けない</option>
							</select>
						</div>

						<label class="control-label col-md-1 text-md-right">期間</label>
						<div class="col-md-3">
							<select class="bs-select form-control" name="period">
								<option></option>
								@foreach(config('consts')['BOOK']['RANKING_PERIOD'] as $key=>$p)
									<option value="{{$key}}" @if(isset($period) && $period == $key) selected @endif>{{$p}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<button class="btn btn-primary">次 へ<i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			@else
				<form class="form-horizontal" action="" method="post">
				{{csrf_field()}}
					<input type="hidden" name="book_id" id="book_id" value="">
					<input type="hidden" name="work_test" id="work_test" value="@if(isset($work_test)){{$work_test}} @endif">
					<input type="hidden" name="content" id="content" value="@if(isset($content)){{$content}} @endif">
				</form>
			@endif

			<div class="row">
				<div class="col-md-12">
					@include('books.book.search.table')
				</div>
				{!! $books->render() !!}
			</div>
			
			<div class="row">
				<div class="col-md-12 margin-bottom-10">
					<a href="{{url('book/search/sort?key=A')}}" class="btn btn-info pull-right">戻　る</a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<h4>
						この本を、読みたい本に登録しました。
					</h4>
					<h4>
						マイ書斎の、読みたい本リストで確認できます。
					</h4>

				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade draggable draggable-modal" id="confirmModal1" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<h4>
						既に読みたい本に登録されたほんです。
					</h4>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は年齢制限のある本なので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
	  <div class="modal fade" id="myfailedModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
	          <p>この本のクイズに2度目も不合格でしたので、3日間この本を受検できません。他の本の受検はできます。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="modal fade" id="passModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は、すでに合格していますので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
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

			$('.towishlist1').click(function(){
				@if(Auth::check())
					var info = {
			    		user_id: {{Auth::id()}},
			    		book_id: $(".towishlist1").attr('id'),
			    		work_test: $("#work_test").val(),
			    		content: $("#content").val(),
			    		_token: $('meta[name="csrf-token"]').attr('content')
			    	}
					$.ajax({
						type: "post",
			      		url: "{{url('/book/regWishlist')}}",
					    data: info,
					    
						beforeSend: function (xhr) {
				            var token = $('meta[name="csrf-token"]').attr('content');
				            if (token) {
				                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				            }
				        },		    
					    success: function (response){
					    	if(response.status == 'success'){
					    		$("#"+$(".towishlist1").attr('id')).addClass('disabled');
			//			    		$('.towishlist1').removeClass('towishlist1');

					    		$("#confirmModal").modal('show');	
					    	}else if(response.status == 'failed'){
			//			    		bootboxNotification(response.message);
					    		$("#confirmModal1").modal('show');
					    	}
					    	
				    	}
					});	
				@endif
			});
			
			$(".test_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/test') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});
			$(".detail_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/detail') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});


			@if($errors == "false")
				$('#myModal').modal('show');
			@endif
			@if($errors == "alert")
				$('#myfailedModal').modal('show');
			@endif
			@if($errors == "pass")
				$('#passModal').modal('show');
			@endif

			$(".age_limit").click(function() {
				$('#myModal').modal('show');
			});
			$(".book_equal").click(function() {
				$('#passModal').modal('show');
			});
		});
    </script>
@stop