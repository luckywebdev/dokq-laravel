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
	            	<a href="{{url('/mypage/create_certi')}}">
	                	 > 読書認定書の発行依頼
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 読書認定書用検索
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読書認定書発行用検索</h3>
			<h6 class="page-subtitle mb-5 time_content">※ 合格履歴から、20冊以内のリストを作成します</h6>
			<div class="row">
				<div class="col-md-12">
					<form class="form form-horizontal" name = "search_form" action = "/mypage/search_certi" id = "search_form">
					{{ csrf_field() }}
					<input type="hidden" name="search" id="search" value="1">
					<input type="hidden" id="items" name="items" value="">
						<div class="form-group row ">
							<div class="col-md-12">
								<label class="control-label col-md-2 text-md-right">著者から検索</label>
								<div class="col-md-2">
									<label class="control-label col-md-2 text-md-right">姓:</label>
									<div class="col-md-10"><input type="text" id="firstname_nick" name="firstname_nick" value="{{isset($_GET['firstname_nick']) ? $_GET['firstname_nick'] : ''}}" class="form-control"></div>
								</div>
								<div class="col-md-2">
									<label class="control-label col-md-2 text-md-right">名: </label>
									<div class="col-md-10"><input type="text" id="lastname_nick" name="lastname_nick" value="{{isset($_GET['lastname_nick']) ? $_GET['lastname_nick'] : ''}}"  class="form-control"></div>
								</div>
							</div>
						</div>

						<!-- <div class="form-group row">
							<label class="text-md-right col-md-2 control-label">タイトルから検索</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="title" id="title"  value="{{isset($_GET['title']) ? $_GET['title'] : ''}}">
							</div>
						</div>

						<div class="form-group row">
							<label class="text-md-right col-md-2 control-label">読Q本IDから検索</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="book_id" id="book_id" value="{{isset($_GET['book_id']) ? $_GET['book_id'] : ''}}">
							</div>
						</div> -->

						<div class="form-group row">
							<label class="text-md-right col-md-2 control-label">日にちから検索</label>
							<div class="col-md-3">
								<input type="text" class="form-control date-picker" name="key_s_date" id="key_s_date" value="{{isset($_GET['key_s_date']) ? $_GET['key_s_date'] : ''}}" readonly>
							</div>
							<label class="text-md-center col-md-1 control-label">~</label>
							<div class="col-md-3">
								<input type="text" class="form-control date-picker"  name="key_e_date" id="key_e_date" value="{{isset($_GET['key_e_date']) ? $_GET['key_e_date'] : ''}}" readonly>
							</div>
						</div>

						<div class="form-group row">
							<label class="text-md-right col-md-2 control-label">ジャンルから検索</label>
							<div class="col-md-3">
								<select class="form-control select2me calc" name="categories[]" id="categories[]" multiple placeholder="選択..." style="min-width:100px;">
									<option></option>
									@foreach($categories as $key=>$category)
										@if (isset($_GET['categories']))
											<option value="{{ $category->id }}" @if (in_array($category->id,  $_GET['categories'])) selected @endif>{{ $category->name }}</option>
										@else
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endif
									@endforeach
								</select>
							</div>

							<div class="offset-md-1 col-md-4">
								<button type="button" class="btn btn-success next_btn" style="margin-top:8px;">次　へ</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">						
					<div class="col-md-3"><h5>検索結果</h5></div>
					<div class="col-md-6 time_content"><h6>※ リストに追加、または削除を選択してください。全て選択し終えると、再び検索ができます。</h6></div>
				</div>						
			</div>
			

			<div class="row">
				<div class="col-md-12">						
					<table class="table table-hover table-bordered" id="sample_test1">
						<thead>
							<tr class="bg-primary">
								<th class="col-md-2">受検日時</th>
								<th class="col-md-3">タイトル</th>
								<th class="col-md-3">著者</th>
								<th class="col-md-2">ポイント</th>
								<th class="col-md-2">公開非公開</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							@foreach ($books as $book)
								<tr>
									<td>{{$book->finished_date}}</td>
									<td><a @if($book->active >= 3) href="{{url('/book/' . $book->id . '/detail')}}" @endif class='font-blue-madison'>{{$book->title}}</a></td>
									<td><a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)}}" class="font-blue">{{$book->firstname_nick.' '.$book->lastname_nick}}</a></td>
									<td class="point">{{floor($book->point*100)/100}}</td>
									<td>@if($book->is_public == 1)公開@else非公開@endif</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<button type="button" id = "checked_btn" class="btn btn-primary pull-right" style="margin-bottom:8px;">チェックを入れたものを認定書に掲載する</button>
				</div>
				<div class="col-md-6">
					<button type="button" id = "total_btn" class="btn btn-warning pull-left" style="margin-bottom:8px;">完了してプレビュー</button>
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)" style="margin-bottom:8px;">戻　る</button>
					<!-- <button type="button" class="btn btn-danger pull-right">キャンセル</button> -->
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(window).load(function(){
			$(".checkboxes").attr('disabled', true);
			//$(".checkboxes").parent().removeAttr('class');
		});
		$(document).ready(function(){
			ComponentsDropdowns.init();
			$('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: 'ja'
            });
            $(".next_btn").click(function(){
            	@if($index == 3)
            	    $("#search_form").attr("action", '{{url("/mypage/search_certi/3")}}');
            	@else
            		$("#search_form").attr("action", '{{url("/mypage/search_certi/4")}}');
            	@endif
				$("#search_form").submit();
            });
            $("#checked_btn").click(function(){
            	$(".checkboxes").removeAttr('disabled');
            });
            $("#total_btn").click(function(){
            	
            	var items = [];
            	$(".checkboxes").each(function() {
            		if($(this).attr("checked") == "checked"){
            			var id =  $(this).attr('id');
            			items.push(id);
            		}
            	});
            	
            	$("#items").val(items);
            	$("#search_form").attr("method", "post");
                                                      
            	@if($index == 3)
            		$("#search_form").attr("action", '{{url("/mypage/preview_certi/3")}}');
            	@else
            		$("#search_form").attr("action", '{{url("/mypage/preview_certi/4")}}');
            	@endif
            	$("#search_form").submit();
            });

            $(".checkboxes").click(function(){
            	
				if($('.checked').length == 20){
					$(".checkboxes").each(function() {

						if($(this).attr("checked") != "checked")
							$(this).attr('disabled',true);
					});
				}else{
					$(".checkboxes").removeAttr('disabled');
				}
			});
		});
    </script>
@stop
