@extends('layout')
@section('styles')
	<style>
		.full-response-width {
			width: 100%;
		}
		@media screen and (max-width: 590px) {
			.full-response-width {
				width: 120%;
			}
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
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> 検索結果
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">検索結果 @if($counts >= 0) {{$counts}} 件   @endif </h3>
			<br><br>
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form">
					{{csrf_field()}}
						<input type="hidden" name="book_id" id="book_id" value="">
						<input type="hidden" name="work_test" id="work_test" value="@if(isset($work_test)){{$work_test}} @endif">
						<input type="hidden" name="content" id="content" value="@if(isset($content)){{$content}} @endif">
						
						<div class="form-body row">
							@if($counts > 0)
							<div class="col-md-12" style="width: 100%; overflow-x: auto">
								@include('books.book.search_result.results')
							</div>
							@elseif ($counts == 0)
							<div class="offset-md-2 col-md-6"> 
								@include('books.book.search_result.none')
							</div>
							<div class="col-md-4">
								@if((isset($keywordSearch) && $keywordSearch) || (isset($specSearch) && $specSearch == 1))
								@else
								<div class="form-group row">
									<div class="col-md-12">
										<input type="hidden" name="cautionflag" id="cautionflag" value="">
										<button type="button" class="btn yellow-crusta" style="background-color:#f0ad4e" id="bookregister">まず本を登録する</button>
									</div>
								</div>
								@endif
								
								<div class="form-group row">
									<div class="col-md-12">
										<a href="{{url('/about_score')}}" class="btn btn-warning">読Qの特長や、クイズの作り方を見る</a>
									</div>
								</div>

								<div class="form-group row" style="margin-top:40px">
									<div class="col-md-12">
										@if((isset($keywordSearch) && $keywordSearch) || (isset($specSearch) && $specSearch == 1))
											<button type="button" class="btn btn-info" onclick="javascript:history.go(-1)">戻　る</button>
										@else
											<a href="{{url('book/search')}}" class="btn btn-info">本の検索トップへ戻る</a>
										@endif
									</div>
								</div>
							</div>
							@else
							<div class="offset-md-2 col-md-6"> 
								@include('books.book.search_result.not_allowed')
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<div class="col-md-12">
										<a href="{{url('about_site')}}" class="btn btn-warning">読Qの特長と使い方</a>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<a href="{{url('book/search')}}" class="btn btn-warning">本の検索トップへ戻る</a>
									</div>
								</div>
							</div>
							@endif
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myAuthorModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>著者はシステムに登録されていないため、プロファイルを表示できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
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
	<div class="modal fade" id="deleteModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本を削除しますか？</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-primary modal-delete" >削  除</button>
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >キャンセル</button>
	        </div>
	      </div>
	    </div>
	</div>
@stop
@section('scripts')
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
	<script src="{{asset('js/data-table-search.js')}}"></script>
	<!-- 1676733165 -->
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();

			$(".author_view").on('click', function(e){
				var writher_id = $(this).attr('did');
				var fullname = $(this).attr('fullname');
				if(writher_id == 0 || writher_id == "" || writher_id == null){
					var queryString = window.location.search;
					var baseUrl = location.origin;

					location.href = "{{url('book/search_books_byauthor')}}" + "?fullname=" + fullname;
					// $("#myAuthorModal").modal('show');
				}
				else{
					location.href = "{{url('mypage/other_view')}}/" + writher_id
				}
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

			//TableManaged.init();
			$("#bookregister").click(function() {
				var data = {_token: $('meta[name="csrf-token"]').attr('content')};
            
	            $.ajax({
	                type: "post",
	                url: "{{url('/book/bookregisterAjax')}}",
	                data: data,
	                
	                beforeSend: function (xhr) {
	                    var token = $('meta[name="csrf_token"]').attr('content');
	                    if (token) {
	                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	                    }
	                },          
	                success: function (response){
	                    if(response.status == 'success'){
	                        $("#cautionflag").val(1);
						    $(".form-horizontal").attr("action", "<?php echo url('/book/register/caution') ?>");
			   		    	$(".form-horizontal").attr("method", "get");
			   		    	$(".form-horizontal").submit();
	                    }
	                }
	            })

				
			});

			$(".test_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/test') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".quiz_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('quiz/make/caution1') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".overseer_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('mypage/demand_list') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".detail_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/detail') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".btn_delete").click(function(){
				$("#book_id").val($(this).attr("id")); 
				$("#deleteModal").modal('show');
			})

			$(".modal-delete").click(function() {
				var book_id = $("#book_id").val();
				$(".form-horizontal").attr("action", "<?php echo url('book/delete_book/') ?>" + "/" + book_id);
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			$(".age_limit").click(function() {
				$('#myModal').modal('show');
			});
			$(".book_equal").click(function() {
				$('#passModal').modal('show');
			});
			
		});
    </script>
@stop