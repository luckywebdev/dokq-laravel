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
			<h6 class="page-subtitle mb-5">※ 合格履歴から、20冊以内のリストを作成します</h6>
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

						 <div class="form-group row">
							<label class="text-md-right col-md-2 control-label">タイトルから検索</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="title" id="title"  value="{{isset($_GET['title']) ? $_GET['title'] : ''}}">
							</div>
						</div>

						<!--<div class="form-group row">
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
								<button type="button" class="btn btn-success next_btn" <?php if(isset($books) && count($books) > 0) echo "disabled"; ?> style="margin-top:8px;">次　へ</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row search_row">
				<div class="col-md-12">						
					<div class="col-md-3"><h5>検索結果</h5></div>
					<div class="col-md-6"><h6>※ リストに追加、または削除を選択してください。全て選択し終えると、再び検索ができます。</h6></div>
				</div>						
			</div>
			
			<input type="hidden" id="book_count" value="<?php if(isset($books)) { echo count($books); } else echo 0; ?>" />

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
								<th class="col-md-1">リストに追加・削除</th>
							</tr>
						</thead>
						<tbody class="text-md-center search_result" >
							<?php $k = 0; ?>
							@foreach ($books as $book)
								<tr id="tr_<?php echo $book->id ?>">
									<td>{{$book->finished_date}}</td>
									<td><a @if($book->active >= 3) href="{{url('/book/' . $book->id . '/detail')}}" @endif class='font-blue-madison'>{{$book->title}}</a></td>
									<td><a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)}}" class="font-blue">{{$book->firstname_nick.' '.$book->lastname_nick}}</a></td>
									<td class="point">{{floor($book->point*100)/100}}</td>
									<td>@if($book->is_public == 1)公開@else非公開@endif</td>
									<td>
										<button type="button" class="btn btn-success add_btn" book_data="{{$book->finished_date}}, {{$book->title}}, {{$book->firstname_nick.' '.$book->lastname_nick}}, {{floor($book->point*100)/100}}, @if($book->is_public == 1)公開@else非公開@endif, @if($book->active >= 3) {{url('/book/' . $book->id . '/detail')}} @endif, {{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)}}, {{$book->id}}" style="padding-top:1px; padding-bottom: 1px" id="add_<?php echo $k ?>_<?php echo $book->id ?>">追加</button>
										<button type="button" class="btn btn-default del_btn" style="padding-top:1px; padding-bottom: 1px" id="del_<?php echo $book->id ?>">削除</button>
									</td>
								</tr>
								<?php $k++; ?>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="row selected_row hidden">
				<div class="col-md-12">						
					<div class="col-md-3"><h5>読書認定</h5></div>
				</div>						
			</div>

			<div class="row">
				<div class="col-md-12">						
					<table class="table table-hover table-bordered hidden" id="sample_test1_2">
						<thead>
							<tr class="bg-primary">
								<th class="col-md-1"></th>
								<th class="col-md-2">受検日時</th>
								<th class="col-md-3">タイトル</th>
								<th class="col-md-3">著者</th>
								<th class="col-md-2">ポイント</th>
								<th class="col-md-1">公開非公開</th>
								<th class="col-md-1">削除</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-5">
					<button type="button" id = "total_btn" class="btn btn-warning pull-left" disabled style="margin-bottom:8px;">完了してプレビューと支払</button>
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
		$(document).ready(function(){
			var certi_list = [];
			var count = 1;
			var t = $('#sample_test1_2').DataTable( {
				data: certi_list,
				"columnDefs": [ {
					"searchable": false,
					"orderable": false,
					"targets": 0
				} ],
				columns: [{
					"orderable": false
				},{
					"orderable": true
				}, {
					"orderable": false
				}, {
					"orderable": true
				}, {
					"orderable": false
				}, {
					"orderable": false
				}, {
					"orderable": false
				}]
			} );
			t.on( 'order.dt search.dt', function () {
				t.column(0, {search:'', order:''}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();
			if(localStorage.getItem('certi_list') != null && localStorage.getItem('certi_list') != ""){
				$('#sample_test1_2').removeClass('hidden');
				$(".selected_row").removeClass("hidden");
				$("#total_btn").attr('disabled', false);
				var certi_list_temp = localStorage.getItem('certi_list').split('~~~');
				for(var k in certi_list_temp){
					var book_arr = certi_list_temp[k].split(',');
					certi_list.push(book_arr);
					t.row.add( [
						count,
						book_arr[0],
						'<a href="'+ book_arr[5] +'" >' + book_arr[1] + '</a>',
						'<a href="'+ book_arr[6] +'" >' + book_arr[2] + '</a>',
						book_arr[3],
						book_arr[4],
						'<button type="button" class="btn btn-default d_btn" style="padding-top:1px; padding-bottom: 1px" id="d_'+book_arr[7]+'">削除</button>'
					] ).draw( false );
					count++;
				}
			}
			console.log("certi", certi_list);



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

			$("#total_btn").click(function(){
            	
            	var items = [];
				
				certi_list.forEach(item => {
					items.push(Number(item[7].trim()));
				})
            	
            	$("#items").val(items);
            	$("#search_form").attr("method", "post");
                                                      
            	@if($index == 3)
            		$("#search_form").attr("action", '{{url("/mypage/preview_certi/3")}}');
            	@else
            		$("#search_form").attr("action", '{{url("/mypage/preview_certi/4")}}');
            	@endif
            	$("#search_form").submit();
            });


			$(".del_btn").click(function() {
				var idTemp = $(this).attr('id').split('_');
				var book_id = idTemp[1];
				$("#tr_" + book_id).remove();
				if($("#sample_test1 tbody").children().length == 0){
					$("#sample_test1").addClass("hidden");
					$(".search_row").addClass("hidden");
					$(".next_btn").removeAttr('disabled');
					$("#sample_test1_wrapper .table-scrollable").css("border", "none");
				}
				if($("#sample_test1").hasClass('hidden') && $("#sample_test1_2").hasClass('hidden')){
					$(".next_btn").removeAttr('disabled');
					$("#total_btn").attr('disabled', true);
				}
			})

			$('#sample_test1_2 tbody').on( 'click', 'td', function () {
				var obj = $(this).children("button");
				if(obj.length > 0){
					var idTemp = obj.attr('id').split('_');
					var book_id = idTemp[1];
					var book_arr = "";
					var index = certi_list.findIndex(item => Number(item[7].trim()) == Number(book_id));
					console.log(index);
					certi_list.splice(index, 1);
					for(var m in certi_list) {
						if(m != 0){
							book_arr += "~~~";
						}
						book_arr += certi_list[m]
					}
					localStorage.setItem('certi_list', book_arr);
					console.log(certi_list, "removed certilist");
					$(this).parent().addClass('selected');
					t.row('.selected').remove().draw( false );
				}
				if($("#sample_test1_2 tr").children(".dataTables_empty").length > 0){
					$("#sample_test1_2").addClass('hidden');
					$(".selected_row").addClass("hidden");
					$("#total_btn").attr('disabled', true);
				}
				if($("#sample_test1").hasClass('hidden') && $("#sample_test1_2").hasClass('hidden')){
					$(".next_btn").removeAttr('disabled');
					$("#total_btn").attr('disabled', true);
				}
			});


			$(".add_btn").click(function(){
				var idTemp = $(this).attr('id').split('_');
				var book_count = $("#book_count").val();
				var book_id = idTemp[2];
				var index = idTemp[1];
				var book_data = $(this).attr('book_data');
				var index = certi_list.findIndex(item => Number(item[7].trim()) == Number(book_id));
				if(index == -1){
					$("#tr_" + book_id).remove();
					var book_arr = book_data.split(',');
					certi_list.push(book_arr);

					var book_temp = "";
					if(localStorage.getItem('certi_list') != null && localStorage.getItem('certi_list') != ""){
						book_temp =  localStorage.getItem('certi_list');
						book_temp += '~~~';
						book_temp += book_data;
					}
					else{
						book_temp = book_data;
					}
					localStorage.setItem('certi_list', book_temp);

					if($("#sample_test1 tbody").children().length == 0){
						$("#sample_test1").addClass("hidden");
						$(".search_row").addClass("hidden");
						$("#sample_test1_wrapper .table-scrollable").css("border", "none");
						$(".next_btn").removeAttr('disabled');
					}
					console.log(certi_list);
					if($("#sample_test1_2").hasClass("hidden")){
						$("#sample_test1_2").removeClass("hidden")
					}
					t.row.add( [
						count,
						book_arr[0],
						'<a href="'+ book_arr[5] +'" >' + book_arr[1] + '</a>',
						'<a href="'+ book_arr[6] +'" >' + book_arr[2] + '</a>',
						book_arr[3],
						book_arr[4],
						'<button type="button" class="btn btn-default d_btn" style="padding-top:1px; padding-bottom: 1px" id="d_'+book_arr[7]+'">削除</button>'
					] ).draw( false );
					count++;
					$(".selected_row").removeClass("hidden");
					$("#total_btn").removeAttr('disabled');
				}
				else{

				}
			})
		});

    </script>
@stop
