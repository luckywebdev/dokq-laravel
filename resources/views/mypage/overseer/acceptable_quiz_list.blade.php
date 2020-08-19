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
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="{{url('/mypage/top')}}">
	                    本の検索
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="#">
	                	 クイズを作る
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修者による認定審査
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズの認定審査リスト</h3>
			<form class="form-horizontal form" id="form-validation" action="{{ url('/book/accept') }}" role="form" method="post">
			<input type="hidden" name="bookId" value="{{$book->id}}">
						{{csrf_field()}}
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-3">タイトル：<span style="color:black;">{{$book->title}}</span></div>
								<div class="col-md-3">著者：<span style="color:black;">{{$book->fullname_nick()}}</span></div>
								<div class="col-md-3">読Q本ID　：　<span style="color:black;">dq{{$book->id}}</span>  </div>
								<div class="col-md-3">　出題数：<span style="color:black;">全{{$book->quiz_count}} 問</span></div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3">読Q本ポイント：<span style="color:black;">{{floor($book->point*100)/100}}</span></div>
								<div class="col-md-3">クイズ認定ポイント：<span style="color:black;">{{floor($book->point * 0.1*100)/100}} / 1問</span></div>
								<div class="col-md-3">認定に必要なｸｲｽﾞの最低数：<span style="color:black;">{{$book->quiz_count * 3}} 問</span>  </div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr class="success">
										<th>受付日</th>
										<th width="40%">クイズ本文</th>
										<th>正解</th>
										<th>出典ページ</th>
										<th>名前</th>
										<th>認定</th>
										<th width="10%">クイズ認定ポイント付与</th>
										<th>不採択理由</th>
									</tr>
								</thead>
								<tbody class="text-md-center">
									@foreach($book->PendingQuizes as $key => $quiz)
									<tr>
										<td>{{with($quiz->created_at)->format("Y/m/d")}} @if($quiz->active < 2) <br><span style="color:red">新着</span> @endif</td>
										<td><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
														$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
														for($i = 0; $i < 30; $i++) {
														 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
															$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
														} echo $st  ?></td>
										<td>@if($quiz->answer == 1) ① @elseif($quiz->answer == 0) ② @endif</td>
										<td><?php echo $quiz->AppearPosition() ?></td>
										<td>{{$quiz->RegisterShow()}}</td>
										<td>
											<p>
												<input type="checkbox" qid="{{$quiz->id}}" class="accept_quiz{{$quiz->id}}" onchange="javascript:onChangeAccept(this);" value="1" name="accept_quiz{{$quiz->id}}" checked> 採択
											</p>
											<p>
												<input type="checkbox" qid="{{$quiz->id}}" class="reject_quiz{{$quiz->id}}" onchange="javascript:onChangeReject(this);" value="0" name="reject_quiz{{$quiz->id}}"> X
											</p>
										</td>
										<td>@if($quiz->active != 3){{floor($book->point * 0.1*100)/100}}  @else 0 @endif</td>
										<td>
											<select class="form-control select2me" name="reason{{$quiz->id}}" placeholder="選択..." style="width:100px; height:33px !important">
												<option></option>
												<option value="1">{{ config('consts')['QUIZ']['REJECT_REASON'][0] }}</option>
												<option value="2">{{ config('consts')['QUIZ']['REJECT_REASON'][1] }}</option>
												<option value="3">{{ config('consts')['QUIZ']['REJECT_REASON'][2] }}</option>
											</select>
										</td>
									</tr>
									@endforeach
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>合計 <span class="success_total">{{count($book->Quizes)}}</span></td>
										<td></td>
										<td>合計 <span class="fail_total">0</span></td>
									</tr>
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 text-md-center">
					<br>
					<p>認定したｸｲｽﾞが出題数の3倍に達していて、出典ページがまんべんなく揃っていれば、この本を読Q本認定できます。認定後は原則としてもうクイズ募集しないので、充分に揃ってから登録しまし</p>
					<br>
                    <button type="button" id="btn_submit" class="btn btn-primary" style="margin-bottom:8px">クイズを認定し、読Q本へ登録</button>
				</div>
			</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/')}}" class="btn btn-info pull-right" role="button">戻 る</a>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			$("#btn_submit").click(function(){
			    $(".form-horizontal").submit();
			});
		});

		function onChangeAccept(obj) {
            var set = jQuery(this).attr("data-set");
            if($(obj).attr("checked")) {
                $(".success_total").html(parseInt($(".success_total").html()) + 1);
                $(".fail_total").html(parseInt($(".fail_total").html()) - 1);
                $(".reject_quiz" + $(obj).attr("qid")).attr("checked", false);
            } else {
                $(".success_total").html(parseInt($(".success_total").html()) - 1);
                $(".fail_total").html(parseInt($(".fail_total").html()) + 1);
                $(".reject_quiz" + $(obj).attr("qid")).attr("checked", true);
            }
            jQuery.uniform.update($(".reject_quiz" + $(obj).attr("qid")));
		}

		function onChangeReject(obj) {
            if($(obj).attr("checked")) {
                $(".success_total").html(parseInt($(".success_total").html()) - 1);
                $(".fail_total").html(parseInt($(".fail_total").html()) + 1);
                $(".accept_quiz" + $(obj).attr("qid")).attr("checked", false);
            } else {
                $(".success_total").html(parseInt($(".success_total").html()) + 1);
                $(".fail_total").html(parseInt($(".fail_total").html()) - 1);
                $(".accept_quiz" + $(obj).attr("qid")).attr("checked", true);
            }
            jQuery.uniform.update($(".accept_quiz" + $(obj).attr("qid")));
		}
	</script>
@stop
