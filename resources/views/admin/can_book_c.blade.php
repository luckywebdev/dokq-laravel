@extends('layout')

@section('styles')
    <style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
		}
	</style>
@stop
@section('breadcrumb')
    <div class="breadcum">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{url('/')}}">
                            読Qトップ
                        </a>
                    </li>
                    <li class="hidden-xs">
                        >   <a href="{{url('/top')}}">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 監修者決定：クイズ編集権限移譲
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者決定：クイズ編集権限移譲</h3>

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
							        <th>監修募集開始日</th>
							        <th>書籍名</th>
							        <th>読Q本ID</th>					        
							        <th>監修希望者名</th>
							        <th>受付日</th>
							        <th>希望する理由</th>
							        <th>監修している本の数</th>
							        <th>選択して決定  返信日</th>
						        </tr>
						    </thead>
 						    <tbody class="text-md-center">	
						    	@foreach($books as $key => $book)
								<tr>
									<td rowspan="{{count($overseers[$key]) + 1}}" style="vertical-align:middle">{{ $book->replied_date1?with(date_create($book->replied_date1))->format('Y/m/d'):"" }}</td>
									<td rowspan="{{count($overseers[$key]) + 1}}" style="vertical-align:middle"><a @if($book->active >= 3) href="{{url('/book/' . $book->id . '/detail')}}" @endif class="font-blue">{{$book->title}}</a></td>
									<td rowspan="{{count($overseers[$key]) + 1}}" style="vertical-align:middle">dq{{$book->id}}</td>
								@if(!$overseers[$key] || count($overseers[$key]) == 0)
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td style="text-align: left !important"></td>
								@endif
								</tr>
								@foreach($overseers[$key] as $demand)
								<tr>
									<td style="vertical-align:middle;border-left-width:1px"><a href="{{url('mypage/other_view/' . $demand->User->id)}}" class="font-blue">@if($demand->User->role == config('consts')['USER']['ROLE']['AUTHOR']) {{$demand->User->fullname_nick()}} @else {{$demand->User->fullname()}} @endif</td>
									<td style="vertical-align:middle">{{with(date_create($demand->updated_at))->format('Y/m/d')}}</td>
									<td style="vertical-align:middle">{{$demand->reason}}</td>
									<td style="vertical-align:middle">{{$demand->User->overseerBookCount()}}</td>
									<td style="text-align: center !important">
										<input type="checkbox" class="book_check" oid="{{$demand->overseer_id}}" bid="{{$book->id}}" @if($demand->overseer_id == $book->overseer_id) checked @endif> @if($demand->overseer_id == $book->overseer_id) {{with((date_create($book->replied_date3)))->format('Y/m/d')}} @endif
									</td>
								</tr>
								@endforeach
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
				    @if(count($books) > 0)
					<form action="{{url('/admin/do_can_book_c')}}" method="post" id="book_form">
						{{csrf_field()}}
						<input type="hidden" name="book_id" id="book_id"/>
						<input type="hidden" name="user_id" id="user_id"/>
						
					</form>
					@endif
				</div>
			</div>	
			<div class="row">
				<div class="offset-md-5  col-md-6">
					<button type="button" class="btn btn-primary" id="btn_submit">送　信</button>
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
	<script type="text/javascript">		
        $(document).ready(function(){
            $("#btn_submit").click(function(){
				var book_checks = $(".checked .book_check");
				if(book_checks.length != 1){
					$("#alert_text").html("{{config('consts')['MESSAGES']['CHECK_ONEQUIZUSER']}}");
	                $("#alertModal").modal();
	                return;
				}else{
					$("#book_id").val($(".checked .book_check").attr("bid"));
					$("#user_id").val($(".checked .book_check").attr("oid"));
					$("#book_form").submit();
				}
            });
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop