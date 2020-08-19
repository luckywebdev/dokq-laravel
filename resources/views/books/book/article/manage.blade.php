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
	            	> <a href="{{url('/mypage/top')}}">
	                	 マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="{{url('/mypage/overseer_books')}}">
	                	 監修本リスト
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> 帯文の管理
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">帯文の管理</h3>
							
			<div class="row">
				<div class="col-md-12">
					<form class="form form-horizontal" action="{{url('/book/' . $book->id . '/article/delete')}}" method="post">
					<input type="hidden" name="book_id" value="{{ $book->id }}">
					{{csrf_field()}}
						<div class="form-body">
							<div class="row">
								<label class="offset-md-1 col-md-7 pull-left">
								<h4>タイトル: 
								@if($book->active >= 3)
									<a href="{{url('book/'.$book->id.'/detail')}}" class="font-blue-madison">{{$book->title}}</a>
								@else
									{{$book->title}}
								@endif
								</h4></label>
								<label class="offset-md-1 col-md-2"><h4>読Q本ID: dq{{$book->id}}</h4></label>
							</div>
							<div class="row">
								<label class="offset-md-1 col-md-9"><h4>著者: {{$book->fullname_nick()}}</h4></label>
							</div>

							<div class="row">
								<div class="offset-md-1 col-md-10">
									<div class="portlet light">
										<div class="portlet-body" style="height: 300px;">
											<div class="table-scrollable table-scrollable-borderless scroller" style="height:280px;width:100%" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
												<table class="table table-bordered table-hover table-striped">
													<thead>
                                                        <tr class="blue" style="width:100% !important;vertical-align:middle;">
                                                            <th style="width:15% !important;vertical-align:middle;">投稿日</th>
                                                            <th style="width:15% !important;vertical-align:middle;">投稿者</th>
                                                            <th style="width:50% !important;vertical-align:middle;">帯文</th>
                                                            <th style="width:10% !important;vertical-align:middle;">いいね！と<br>言っている<br>人数</th>
                                                            <th style="width:10% !important;vertical-align:middle;">この投稿を<br>削除</th>
														</tr>
													</thead>
													<tbody class="text-md-center">
														<?php $index = 1; ?>
													    @foreach($articles as $one)
														<tr style="width:100% !important;vertical-align:middle;text-align:center;">
															<td style="vertical-align:middle;text-align:center;">{{ $one->created_at?with(date_create($one->created_at))->format('Y/m/d'):"" }}</td>
															<td style="vertical-align:middle;text-align:center;"><a href="{{url('mypage/other_view/' . $one->register_id)}}" class="font-blue-madison">
																@if($one->User->age() < 15)
														            中学生以下ー{{$index++}}
														        @else
													                @if($one->register_visi_type == 0) @if($one->User->role  != config('consts')['USER']['ROLE']['AUTHOR']) {{$one->User->fullname()}} @else {{$one->User->fullname_nick()}} @endif @else {{$one->User->username}} @endif
													            @endif
														        </a>
														    </td>
															<td style="vertical-align:middle;text-align:center;">{{ $one->content }}</td>
															<td style="vertical-align:middle;text-align:center;">
															<!-- <a id ="{{$one->id}}" class="font-blue-madison" data-toggle="popover" title=" " data-placement="right">  -->
															<a id ="{{$one->id}}" class="font-blue-madison"> {{ count($one->Votes) }}人 </a></td>
															<td style="vertical-align:middle;text-align:center;"><input type="checkbox" name="checkboxes[]" class="checkboxes" value="{{ $one->id }}"></td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-11 text-md-right">
									<button type="button" class="offset-md-1 btn btn-warning btn-success">実　行</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div id="popup" style="display:none;z-index:1000;">
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
	<script type="text/javascript">
    	$(document).ready(function() {
    		@if(Auth::user()->role == config('consts')['USER']['ROLE']['AUTHOR'])
    			$('body').addClass('page-full-width');
    		@endif
    	    $(".btn-success").click(function() {
                $(".form-horizontal").submit();
    	    });

    	    /*$('[data-toggle="popover"]').popover();
    	    $(".font-blue-madison").click(function(){
    	    	
    	    	$('[data-toggle="popover"]').popover('destroy'); 
    	    	
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/article_history_ajax/" + $(this).attr('id');
                $.ajax({
                    type: "post",
                    url: post_url,
                    data: info,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response){
                    	
                    	$('[data-toggle="popover"]').popover(); 
                        $(".popover-content").html(response);
                       
                    }
                });
            });*/
    	    
    	    $(".font-blue-madison").click(function(){
    	    	
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/article_history_ajax/" + $(this).attr('id');
                $.ajax({
                    type: "post",
                    url: post_url,
                    data: info,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response){
                    	
                        $("#popup").html(response);
                       
                    }
                });
            });

			$("body").on("click", "a.font-blue-madison", function(e) {
			    			   
			    $("#popup").show();
			    $("#popup").css("position","absolute");
			    var pageWidth = $(window).width();
			    
			    if(pageWidth > 768){
			    	$("#popup").css("left",e.pageX-130);
			    	$("#popup").css("top",e.pageY-160);
			    }else{
			    	$("#popup").css("left",e.pageX-130);
			    	$("#popup").css("top",e.pageY-200);
			    }
			    
			    return false;
			});

			$("body").click(function(){
			    $("#popup").hide();
			});
		});
    </script>
@stop