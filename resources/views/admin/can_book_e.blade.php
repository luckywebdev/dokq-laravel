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
                        > クイズ募集中の本リスト
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">未認定クイズのストック</h3>
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
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="col-md-3">タイトル：<span style="color:black; vertical-align:middle;">{{$book->title}}</span></div>
							<div class="col-md-3">著者：<span style="color:black; vertical-align:middle;">{{$book->firstname_nick.' '.$book->lastname_nick}}</span></div>
							<div class="col-md-3">読Q本ID：　<span style="color:black; vertical-align:middle;">dq{{$book->id}}</span>  </div>
							<div class="col-md-3">　読Q本ポイント：<span style="color:black; vertical-align:middle;">{{floor($book->point*100)/100}}</span></div>
							<br>
						</div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
							    <thead>
							    	<tr class="success">
								        <th>受付日</th>
								        <th width="40%">クイズ本文</th>
								        <th>正解</th>					        
								        <th>出典ページ</th>
								        <th>作成者表示名</th>
							        </tr>
							    </thead>
							    <tbody class="text-md-center">		
							    	@foreach($book->PendingQuizes as $quiz)							
									<tr>
										<td style="vertical-align:middle">{{with($quiz->created_at)->format("Y/m/d")}}</td>
										<td style="vertical-align:middle">
											<?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $quiz->question); $st = str_replace_first("#", "</u>", $st); 
														$st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
														for($i = 0; $i < 30; $i++) {
														 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
															$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
														} 
														echo $st  ?>
										</td>
										<td style="vertical-align:middle">@if($quiz->answer == 1) ① @elseif($quiz->answer == 0) ② @endif</td>
										<td style="vertical-align:middle"><?php echo $quiz->AppearPosition() ?></td>
										<td style="vertical-align:middle">
											<?php   if($quiz->register_visi_type == 1){
											            if($quiz->Register->role == config('consts')['USER']['ROLE']['AUTHOR'])
											                $quiz_register_name = $quiz->Register->fullname_nick();
											            else
											    		  $quiz_register_name = $quiz->Register->fullname();
											    	}else{
											            $quiz_register_name = $quiz->Register->username;
											        } ?>
											<a href="{{url('mypage/other_view/' . $quiz->Register->id)}}" class="font-blue">
											{{$quiz_register_name}}</a>	</td>
									</tr>	
									@endforeach								
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>

@stop
@section('scripts')
	<script type="text/javascript">
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop