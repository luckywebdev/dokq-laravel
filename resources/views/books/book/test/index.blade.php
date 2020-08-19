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
	            <li>
	                <a href="{{url('/book/search')}}">
	                	> 本を検索 
	                </a>
	            </li>
	            <li>
	                <a href="#">
	                	> 受検 > @if($mode == 'before_recog') 受検の確認  @elseif ($mode == 'after_recog') 受検開始 @endif
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
		@if($mode == 'before_recog')
		<form class="form form-horizontal" action="{{url('book/test/caution')}}" method="post">
		{{csrf_field()}}
			<h3 class="page-title">読Q受検を始めます</h3>
			<div class="row margin-top-20">
				<div class="offset-md-3 col-md-5">
					
					@if(isset($book)&&Auth::check())
						<input type="hidden" name="book_id" value="{{$book->id}}">
					@endif
						<div class="form-body">
							<table class="table table-no-border table-hover">
								<tbody class="h4 ">
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">タイトル　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">{{$book->title}}
														(@foreach($book->categories as $key=>$category)
															@if($key + 1 == count($book->categories))
																{{$category->name}}
															@else
																{{$category->name}}、
															@endif
														@endforeach)</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">著者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">{{$book->fullname_nick()}}</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Q本登録者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">@if(isset($book->Register) && $book->Register !== null && $book->register_id != 0) @if($book->register_visi_type == 0){{$book->Register->fullname()}}@else{{$book->Register->username}}@endif @endif</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">クイズ監修者　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">@if($book->author_overseer_flag == 1)著者、@endif
											@if(isset($quiz_overseer) && $quiz_overseer !== null){{$quiz_overseer->fullname()}}@endif</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Q本ID　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">dq{{$book->id}}</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">読Qポイント　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">{{floor($book->point*100)/100}}</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">短時間加算　　　<br>ポイント　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px"><br>{{floor(($book->point/10)*100)/100}}</td>
									</tr>
									<tr>
										<td align="right" style="width:40%;vertical-align:middle;padding:1px;">問題数　···　</td>
										<td align="left" style="vertical-align:middle;padding:1px">
											@if($book->quiz_count >15)
												{{$book->quiz_count}}問以下
												<input type="hidden" name="quiz_count" value="{{$book->quiz_count}}">
											@else
												{{$book->quiz_count}}問以下
												<input type="hidden" name="quiz_count" value="{{$book->quiz_count}}">
											@endif
										</td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>
			</div>
			<h3 class="page-title">回答方法</h3>
			<div class="row margin-top-20">
				<div class="offset-md-2 col-md-10">
					<div class="form-body h4">
					問題文の<span style='text-decoration:underline !important'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>線部が、本の内容(ないよう)と合(あ)っていれば〇（①）、違(ちが)っていれば×（②）を選(えら)んで、「次へ」をクリックしてください。
					</div>
				</div>
			</div>
			<div class="form-body text-md-center col-xs-12" style="text-align:center;">
				<button class="btn btn-primary" >確認して次へ</button>
			</div>
		</form>
		@elseif($mode == 'after_recog')
		<form class="form form-horizontal" action="{{url('book/test/quiz')}}" method="post">
		{{csrf_field()}}
		@if(isset($book)&&Auth::check())
			<input type="hidden" name="book_id" value="{{$book->id}}">
		@endif
			<h3 style="text-align:center;">{{$book->title}}
									(@foreach($book->categories as $key=>$category)
										@if($key + 1 == count($book->categories))
											{{$category->name}}
										@else
											{{$category->name}}、
										@endif
									@endforeach)</h3>
			<h4 style="text-align:center;">{{$book->fullname_nick()}}</h4>
			<div class="clearfix"></div>
			<h4 style="text-align:center;">問題数　···　
											@if($book->quiz_count >15)
												{{$book->quiz_count}}問以下
												<input type="hidden" name="quiz_count" value="{{$book->quiz_count}}">
											@else
												{{$book->quiz_count}}問以下
												<input type="hidden" name="quiz_count" value="{{$book->quiz_count}}">
											@endif</h34>
			<div class="clearfix">&nbsp;</div>

			<h4 style="text-align:center;color:red;">回答方法</h4>
			<div class="row">
				<div class="offset-md-2 col-md-10">
					<div class="form-body h4"  style="color:red;">
					問題文の<span style='text-decoration:underline !important'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>線部が、本の内容と合っていれば〇（①）、違っていれば×（②）を選んで、「次へ」をクリックしてください。
					</div>
				</div>
			</div>
			<div class="form-body text-md-center col-xs-12" style="text-align:center;">
				<button class="btn btn-primary" >受検スタート</button>
				@if($mode == 'after_recog')
					<label class="help-block" style="text-align:center;">
						＊このボタンを押すとすぐにクイズ第１問が始まります。
					</label>
				@endif
			</div>
		</form>
		@endif
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
@stop