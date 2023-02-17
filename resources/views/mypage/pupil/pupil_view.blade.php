@extends('layout')
@section('styles')
   <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
   <style type="text/css">
   		.chart_kind{
   			float: left;
   		}
   		.chart_kind ul{
   			margin-left: -7%;
   		}
   		.chart_kind ul li{
   			float: left;
   			padding: 0 35px;
   		}
   		.chart_kind ul li.clast{
   			margin-left: 0%;
   		}
   </style>
@stop
@section('breadcrumb')
	<script src="{{asset('js/charts/Chart.js')}}"></script>
	<div class="breadcum">
	    <div class="container">	    	
		        <ol class="breadcrumb">
		            <li>
		                <a href="{{url('/')}}">
		                	読Qトップ 
		                </a>
		            </li>
		            <li class="hidden-xs">
		            	> マイ書斎
		            </li>
		        </ol>
	        </div>	    
	</div>
@stop
@section('contents')

<input type="hidden" name="viceLogin" value="{{isset($confirm)?$confirm:"" }}" id="viceLogin"/>
            
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
			    <?php
				$title = '';
				if($user->isPupil() && $user->active ==1){
			    	$title .= $user->ClassOfPupil->fullTitle();
			     	if($user->gender == 1) $title .= "女子"; else $title .= "男子";
                }else{
                	if($user->age() >= 15)
                		$title .= $user->username;
                	else{
						$title .= $user->age().'歳';
						if($user->gender == 1) $title .= "女子"; else $title .= "男子";
					}
				}	
			    $title .= 'さんのマイ書斎';
			    ?>
			    {{$title}} 
				<a href='' id="user_name" userId="{{$user->id}}">{{Auth::user()->role == config('consts')['USER']['ROLE']['ADMIN'] ? $user->username : ''}}</a>
			</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="top-news" style="width:320px;height:50px">
						<a class="btn blue" @if(Auth::check() && Auth::user()->getWifiFlag() == 0) href="#" @else disabled @endif>
							<span class="text-md-center">バナー広告</span>
						</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="news-blocks white">
						<h4>
						    <span class="font-blue-madison col-md-7">読Qからの連絡帳</span>
						    <label class="text-md-right col-md-5">非公開</label>
						</h4>
						
						<p>
						    <?php foreach($messages as $message) { ?>
							<li style="margin-left:10px; margin-right:5px;">
								@if($message->from_id == $id)<?php echo  date_format($message->updated_at,'Y/m/d'). '->' . $message->post ?>
								@else
									<?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $message->content); $st = str_replace_first("#", "</u>", $st); 
										$st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
										for($i = 0; $i < 30; $i++) {
										 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
											$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
										}   ?>
										<?php echo  date_format($message->updated_at,'Y/m/d'). '->' . $st ?>
								@endif
							</li>
							<?php } ?>
						</p>
						<a href="{{url('/mypage/site_notify/'.$user->id)}}" class="news-block-btn font-blue-madison">もっと見る</a>
					</div>
				</div>

				<div class="col-md-6">
					<div class="news-blocks lime">
						<div class="row">
							<div class="col-md-12">
							<h4>
								<span class="font-blue-madison col-md-8">現在の読Q資格、ポイントと目標</span>
								@if ($age >= 15)
								<div class="tools" style="float:right;">
									<input type="checkbox" @if ($profile_is_public == 1) checked @endif class="make-switch" data-size="small" id="profile_is_public">
								</div>
								@else
								<label class="text-md-right col-md-4">公開</label>
								@endif
							</h4>
							</div>
						</div>
						
							<div name = "student_show" id = "student_show" style = "display:none;">
								{{$current_season['from'] . '～' . $current_season['to'] . 'の目標・・'.$tagrgetpoint.'ポイント獲得'}}<br>
								現在の目標達成率・・・・・・・・・・@if (isset($current_user) && $tagrgetpoint !=0){{floor($current_user->sumpoint*100/$tagrgetpoint)}} @else 0 @endif％<br>
							</div>
							<div>読Q資格・・・・・・・・・・・・・ {{$my_rank}}級、クイズ作成者<br></div>
							<div name = "myallpoints_show" id = "myallpoints_show" style = "display:none;">
								生涯ポイント・・・・・・・・・・・{{floor($total_point*100)/100}}ポイント<br>
							</div>
							<div>昇級まであと・・・・・・・・・・・{{floor($my_addpoint*100)/100}}ポイント<br></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 column">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								読みたい本リスト
							</div>
							@if ($age >= 15)
							<div class="tools">
								<input type="checkbox" @if ($wishlists_is_public == 1)checked @endif class="make-switch" id="wishlists_is_public" data-size="small">
							</div>
							@else
							<div class="tools">非公開</div>
							@endif
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="success">
											<th class="col-md-6">タイトル</th>
											<th class="col-md-2">著者</th>
											<th class="col-md-1">ページ数</th>
											<th class="col-md-1">ポイント</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										@foreach($wishBooks as $book)
										@if($book->is_public)
										<tr>
											<td class="text-md-center align-middle"><a @if($book->active >= 3) href="{{url('/book/'.$book->id.'/detail')}}" @endif>{{$book->title}}</a></td>
											<td class="text-md-center align-middle"><a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)}}">{{$book->firstname_nick.' '.$book->lastname_nick}}</a></td>
											<td class="text-md-center align-middle">{{$book->pages}}</td>
											<td class="text-md-center align-middle">{{floor($book->point*100)/100}}</td>
										</tr>
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
							<a class="text-md-center font-blue-madison" href="{{url('/mypage/wish_list/'.$user->id)}}">閲覧、編集画面へ</a>
						</div>
					</div>
						@if ($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->active == 1)
						<form class="form-horizontal" method="get" role="form" action="">
						 <input type="hidden" id="id" name="id" value="{{$id}}">
							<div class="news-blocks lime">
								<h4 class="font-blue-madison">学校ランキング</h4>
								<p>
									{{$user->address2}}{{$user->group_name}}児童の読書量・・・市で{{$school_rank_city}}位!
								</p>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-1"></div>
										<div class="col-md-5" style="padding-top:16px"><button type="button" class="btn btn-warning btn-rank1">クラス対抗読書量順位</button></div>
										<div class="col-md-5" style="padding-top:16px"><button type="button" class="btn btn-warning btn-rank2">所属学年の読書量順位</button></div>
										<div class="col-md-1"></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-1"></div>
										<div class="col-md-5" style="padding-top:16px"><button type="button" class="btn btn-warning btn-rank3">所属学校の読書量順位</button></div>
										<div class="col-md-5" style="padding-top:16px"><button type="button" class="btn btn-warning btn-rank4">読書量全国トップ校</button></div>
										<div class="col-md-1"></div>
									</div>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
					<h4 class="font-blue">読書推進活動ランキング<span class="font-blue" style="font-size:14px">（同学年内順位）</span></h4>
					<table class="table table-bordered table-hover" style="margin-bottom:0px">
						<thead>
							<tr class="yellow">
								<th class="col-md-3">本の登録とクイズ作成</th>
								<th class="col-md-3">自分の読書<br>推進ポイント</th>
								<th class="col-md-2">市区町村内順位<br>（位/人）</th>
								<th class="col-md-2">都道府県内順位<br>（位/人）</th>
								<th class="col-md-2">全国順位<br>（位/人）</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
							<tr class="warning">
								<td class="align-middle">{{$current_season['season']}}{{$current_season['from_num'] . '～' . $current_season['to_num']}}<br>(今　四半期)</td>
								<td class="align-middle">@foreach($myquizPoints1 as $i =>$myquiz_Points1)
										@if($myquizPoints1[$i]->sum != 0)
											{{floor($myquiz_Points1->sum*100)/100}}
										@else
											0
										@endif
									@endforeach
								</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints2); $i++)
										@if($myquizPoints2[$i]->sum == $myquiz_Points1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints2[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints3); $i++)
										@if($myquizPoints3[$i]->sum == $myquiz_Points1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints3[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints4); $i++)
										@if($myquizPoints4[$i]->sum == $myquiz_Points1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints4[$i]->pupil_numbers; ?>
									@endfor
									 / {{$total_people}}</td>
							</tr>
							<tr>
								<td class="align-middle">{{$array_season_obj[1]['season']}}{{$array_season_obj[1]['from_num'] . '～' . $array_season_obj[1]['to_num']}}<br>(前　四半期)</td>
								<td class="align-middle">@foreach($myquizPoints_before1 as $i =>$myquiz_Points_before1)
										@if($myquizPoints_before1[$i]->sum != 0)
											{{floor($myquiz_Points_before1->sum*100)/100}}
										@else
											0
										@endif
									@endforeach
								</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_before2); $i++)
										@if($myquizPoints_before2[$i]->sum == $myquiz_Points_before1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_before2[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_before3); $i++)
										@if($myquizPoints_before3[$i]->sum == $myquiz_Points_before1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_before3[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_before4); $i++)
										@if($myquizPoints_before4[$i]->sum == $myquiz_Points_before1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_before4[$i]->pupil_numbers; ?>
									@endfor
									 / {{$total_people}}</td>
							</tr>
							<tr class="warning">
								<td class="align-middle">{{$current_season['year']}}年度<br>（今年度通算）</td>
								<td class="align-middle">@foreach($myquizPoints_this1 as $i =>$myquiz_Points_this1)
										@if($myquizPoints_this1[$i]->sum != 0)
											{{floor($myquiz_Points_this1->sum*100)/100}}
										@else
											0
										@endif
									@endforeach
								</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_this2); $i++)
										@if($myquizPoints_this2[$i]->sum == $myquiz_Points_this1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_this2[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_this3); $i++)
										@if($myquizPoints_this3[$i]->sum == $myquiz_Points_this1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_this3[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_this4); $i++)
										@if($myquizPoints_this4[$i]->sum == $myquiz_Points_this1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_this4[$i]->pupil_numbers; ?>
									@endfor
									 / {{$total_people}}</td>
							</tr>
							<tr>
								<td class="align-middle">{{$current_season['year']-1}}年度<br>（前年度）</td>
								<td class="align-middle">@foreach($myquizPoints_last1 as $i =>$myquiz_Points_last1)
										@if($myquizPoints_last1[$i]->sum != 0)
											{{floor($myquiz_Points_last1->sum*100)/100}}
										@else
											0
										@endif
									@endforeach
								</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_last2); $i++)
										@if($myquizPoints_last2[$i]->sum == $myquiz_Points_last1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_last2[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_last3); $i++)
										@if($myquizPoints_last3[$i]->sum == $myquiz_Points_last1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_last3[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_last4); $i++)
										@if($myquizPoints_last4[$i]->sum == $myquiz_Points_last1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_last4[$i]->pupil_numbers; ?>
									@endfor
									 / {{$total_people}}</td>
							</tr>
							<tr class="warning">
								<td class="align-middle">生涯<br>（現在まで累計）</td>
								<td class="align-middle">@foreach($myquizPoints_all1 as $i =>$myquiz_Points_all1)
										@if($myquizPoints_all1[$i]->sum != 0)
											{{floor($myquiz_Points_all1->sum*100)/100}}
										@else
											0
										@endif
									@endforeach
								</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_all2); $i++)
										@if($myquizPoints_all2[$i]->sum == $myquiz_Points_all1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_all2[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_all3); $i++)
										@if($myquizPoints_all3[$i]->sum == $myquiz_Points_all1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_all3[$i]->pupil_numbers; ?>
									@endfor
									
									 / {{$total_people}}</td>
								<td class="align-middle">@for($total_people=0,$i = 0; $i < count($myquizPoints_all4); $i++)
										@if($myquizPoints_all4[$i]->sum == $myquiz_Points_all1->sum)
											{{$i + 1}}
										@endif
										<?php $total_people+=$myquizPoints_all4[$i]->pupil_numbers; ?>
									@endfor
									 / {{$total_people}}</td>
							</tr>
						</tbody>
					</table>
					<a href="{{url('/mypage/rank_bq')}}" class="news-block-btn font-blue-madison"  style="float:right;margin-bottom:20px">もっと見る</a>
					<div class="clearfix"></div>
						@endif			
				<!-- 	<div class="row"> -->
						<!-- <div class="col-md-5 column" > -->
							<!-- BEGIN SAMPLE TABLE PORTLET-->
							<div class="portlet box red">
								<div class="portlet-title">
									<div class="caption">マイ本棚（クイズに合格した本リスト）</div>
									@if ($age >= 15)
									<div class="tools">
										<input type="checkbox" @if ($mybookcase_is_public == 1) checked @endif class="make-switch" data-size="small" id="mybookcase_is_public">
									</div>
									@else
									<div class="tools">公開</div>
									@endif
								</div>
								<div class="portlet-body">
						 			<div class="row">	
										<div class="col-md-12"> 
										<table class="table table-bordered table-hover table-category">
											<tbody class="text-md-center">
												
												<tr style="height:300px;padding:12px;">
													@for($i = 0; $i < (12 - count($myBooks)); $i++)
													<td class="col-md-1"></td>
													@endfor
													@foreach($myBooks as $book)
													<?php if($book->point >= 0 && $book->point <= 2) $color = '#ffb5fc'; //help.about_target.blade.php
														  elseif($book->point > 2 && $book->point <= 5) $color = '#facaca';//ff0000 
														  elseif($book->point > 5 && $book->point <= 8) $color = '#f9d195'; //FF9900
														  elseif($book->point > 8 && $book->point <= 11) $color = '#f6f99a'; //f4fd00
														  elseif($book->point > 11 && $book->point <= 15) $color = '#e1f98f'; //d6f432
														  elseif($book->point > 15 && $book->point <= 19) $color = '#92fab2'; //26a69a
														  elseif($book->point > 19 && $book->point <= 25) $color = '#a7d4fb'; //5C9BD1
														  elseif($book->point > 25) $color = '#f0f5fa';	
													?>
													<td class="col-md-1 text-md-center" style="background-color:{{$color}};padding-left:0px;padding-right:0px;">
														<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:200px;">
															<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
																<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" @if($book->active >= 3) href="{{url('/book/'.$book->id.'/detail')}}" @endif>
																{{$book->title}}
																</a>
															</h5>
														</div>
														<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:100px;">
															<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
																<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->firstname_nick.' '.$book->lastname_nick)}}">
																{{$book->firstname_nick.' '.$book->lastname_nick}}
																</a>
															</h5>
														</div>
													</td>
													@endforeach																					
												</tr>
											</tbody>
										</table>
										<a href="{{url('/mypage/category/'.$user->id)}}" class="news-block-btn font-blue-madison">もっと見る</a>
										
								</div>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
					<div class="news-blocks lime">
						<h4 class="font-blue">読Q活動の履歴</h4>
						
						<table class="table table-no-border">
							<tr>
								<td class="col-md-8" ><a style="text-decoration:none;" href="{{url('mypage/history_all/'.$user->id)}}">読Q活動の全履歴を見る</a></td>
								<td class="col-md-4">非公開</td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/pass_history/'.$user->id)}}">合格履歴を見る</a></td>
								<td><input type="checkbox" @if ($passed_records_is_public == 1)checked @endif class="make-switch" id="passed_records_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/rank_by_age/'.$user->id)}}">ポイントランキングを見る</a></td>
								<td><input type="checkbox" @if ($point_ranking_is_public == 1)checked @endif class="make-switch" id="point_ranking_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/rank_bq/'.$user->id)}}">読書推進活動ランキングを見る</a></td>
								<td><input type="checkbox" @if ($register_point_ranking_is_public == 1)checked @endif class="make-switch" id="register_point_ranking_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/book_reg_history/'.$user->id)}}">本の登録認定記録を見る</a></td>
								<td><input type="checkbox" @if ($book_allowed_record_is_public == 1)checked @endif class="make-switch" id="book_allowed_record_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/quiz_history/'.$user->id)}}">作成クイズの認定記録</a></td>
								<td><input type="checkbox" @if ($quiz_allowed_record_is_public == 1)checked @endif class="make-switch" id="quiz_allowed_record_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/last_report/0/'.$user->id)}}">読Qレポートバックナンバーを見る</a></td>
								<td>非公開</td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/article_history/'.$user->id)}}">帯文投稿履歴を見る</a></td>
								<td>公開</td>
							</tr>
							<!-- <tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/history_oversee')}}">試験監督履歴を見る</a></td>
								<td>非公開</td>
							</tr> -->
						</table>
					</div>

					<div class="news-blocks lime">
						<h4 class="font-blue">読書認定書の発行依頼</h4>
						
						<p>
							読書認定書を発行します。(有料）
						</p>
						<a href="{{url('mypage/create_certi')}}" class="btn btn-warning offset-md-5" disabled="true">次　へ</a>
					</div>

					<div class="news-blocks lime">
						<h4 class="font-blue">
							試験監督をする
							<small style="color: #909090"><br>（初めての場合は適性検査を受けてください。所要時間は約5分です。）</small>
						</h4>
						<a href="{{ url("/mypage/test_overseer") }}" class="btn btn-warning offset-md-2 @if($user->aptitude == 1 || $user->age() <= 20) disabled @endif" style="margin-bottom:8px;" disabled="true">適性検査を受ける</a>
						<a href="{{ url("/mypage/oversee_test") }}" class="btn btn-warning @if($user->aptitude == 0 || $user::user()->age() <= 20) disabled @endif" style="margin-bottom:8px;" disabled="true">試験監督を始める</a>
					</div>
				</div>

				<div class="col-md-6 column">
					<div class="portlet box blue">
						@if($type == 0)
						<div class="portlet-title">
							<div class="caption col-md-9 col-xs-9" style="text-align:left;padding-bottom:5px;">
								現在までの各期　目標達成率<span class="hidden-xs"  style="font-size:12px">(同年代全国平均との比較)</span>
							</div>
							<div class="tools col-md-3 col-xs-3">
								@if ($age >= 15)
									<input type="checkbox" @if ($targetpercent_is_public == 1) checked @endif class="make-switch" data-size="small" id="targetpercent_is_public">
								@else
									公開
								@endif
							</div>
							<div class="col-md-12 col-xs-9" style="padding-left:0px">
							 <span class="show-xs" style="text-align:left;font-size:12px">(同年代全国平均との比較)</span>
							</div>	
						</div>
						<div class="portlet-body col-md-12">
							<canvas id="bar" width="617" height="300" style="width: 617px; height: 300px;"></canvas>
							<div class="legend">
								<div style="position: absolute; width: 70px; height: 40px; top: 14px; right: 13px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
								<table style="position:absolute;top:14px;right:13px;font-size:smaller;color:#545454">
								<tbody>
								<tr>
								<td class="legendColorBox">
								<div style="border:1px solid #ccc;padding:1px">
								<div style="width:4px;height:0;border:5px solid #d0cece;overflow:hidden">
								</div>
								</div>
								</td>
								<td class="legendLabel">全国平均</td>
								</tr>
								<tr>
								<td class="legendColorBox">
								<div style="border:1px solid #ccc;padding:1px">
								<div style="width:4px;height:0;border:5px solid #f8cbad;overflow:hidden">
									
								</div>
								</div>
								</td>
								<td class="legendLabel">自分</td>
								</tr>
								
								</tbody></table>
							</div>
						</div>
						@else
						<div class="portlet-title">
							<div class="caption col-md-9 col-xs-9" style="text-align:left;padding-bottom:5px;">
								3カ月間で獲得するポイント推移<span class="hidden-xs"  style="font-size:12px">(同年代全国平均との比較)</span>
							</div>
							<div class="tools col-md-3 col-xs-3">
								@if ($age >= 15)
									<input type="checkbox" @if ($targetpercent_is_public == 1) checked @endif class="make-switch" data-size="small" id="targetpercent_is_public">
								@else
									公開
								@endif
							</div>
							<div class="col-md-12 col-xs-9" style="padding-left:0px">
							 <span class="show-xs" style="text-align:left;font-size:12px">(同年代全国平均との比較)</span>
							</div>	
						</div>
						<div class="portlet-body  col-md-12" style="height: 350px;">
							<div id="target-chart" class="dqtarget-chart chart-holder" style="width: 480px; height: 320px;"></div>
						</div>
						@endif
					</div>
					<div class="caption" style="font-size:16px:">
						&nbsp;<br>
						マイ読書量順位
					</div>
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption col-md-9 col-xs-9" style="text-align:left;padding-bottom:5px;">
								現在までの、獲得ポイント順位<span class="hidden-xs"  style="font-size:12px">（同年代と競うグラフ）</span>
							</div>
							<div class="tools col-md-3 col-xs-3">
								@if ($age >= 15)
									<input type="checkbox" @if ($ranking_order_is_public == 1) checked @endif class="make-switch" data-size="small" id="ranking_order_is_public">
								@else
									公開
								@endif
							</div>
							<div class="col-md-12 col-xs-9" style="padding-left:0px">
							 <span class="show-xs" style="text-align:left;font-size:12px">（同年代と競うグラフ）</span>
							</div>
						</div>
						<div class="portlet-title" style="min-height:18px">
							<div class="row">
								<table class="col-md-12">
									<tr class="text-md-center">
										<td width="10%"></td>
										<td width="30%" style="text-align: center!important;">四半期（3カ月間）</td>
										<td width="30%" style="text-align: center!important;">年度（1年間）</td>
										<td width="30%" style="text-align: center!important;">生涯</td>
									</tr>
								</table> 
							</div>
						</div>
						@if($type == 0)
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">クラス</span></div>
							<div id="threemonth-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart1" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart1" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">学年</span></div>
							<div id="threemonth-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart2" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart2" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						@endif
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">市区<br>町村内</span></div>
							<div id="threemonth-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart3" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart3" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 350px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">都道<br>府県内</span></div>
							<div id="threemonth-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart4" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart4" style="width:30%; float:left;" class="chart-holder"></div>
						</div>
						<div class="portlet-body" style="height: 360px;">
							<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
							<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">国内</span></div>
							<div id="threemonth-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="horizontal-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<div id="all-chart5" style="width:30%; float:left;" class="chart-holder"></div>
							<a class="text-md-center font-blue-madison" href="@if($user->isPupil()){{url('/mypage/rank_child_pupil/'.$user->id)}}@else{{url('/mypage/rank_by_age')}}@endif">もっと見る</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 column">
					
				</div>

				<div class="col-md-6 column">
					@if (!($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->active == 1))
					<div class="news-blocks blue">
						<h4 class="font-blue">お支払い</h4>
						
						<p>
							読Q有効期限（会費払込済期間）・・・ 年 月 日<br>
							会費や読書認定書発行手数料のお支払い、または支払い履歴へアクセスするには、パスワードと顔認証が必要です。
						</p>
						<a href="{{ url('/mypage/face_verify/1') }}" class="btn btn-warning offset-md-5" disabled="true">顔認証画面へ</a>
					</div>
					@endif
					<div class="news-blocks blue">
						<div class="row" style="padding-left:15px">
							<h4 class="font-blue">基本情報</h4>
							<h6 class="font-red" style="padding-left:15px;margin-top:15px;">基本情報の閲覧、編集には、顔認証が必要です。</h6> 
						</div>
						<table class="table table-bordered">
							<tr>
								<td>生年月日</td>
								<td>••••</td>
							</tr>
							<tr>
								<td>メールアドレス</td>
								<td><?php $firststr = substr ($user->email, 0, 1); $email = $firststr."••••";?>{{$email}}</td>
							</tr>
							<tr>
								<td>パスワードなど</td>
								<td>••••••••</td>
							</tr>
						</table>
						<a href="{{ url('/mypage/other_view_info') }}" class="btn btn-warning offset-md-1" style="margin-bottom:8px;" disabled="true">外部から見た基本情報を見る</a>
						<a href="{{ url('/mypage/face_verify/2') }}" class="btn btn-warning" style="margin-bottom:8px;" disabled="true">顔認証画面へ</a>
					</div>

					<div class="top-news" style="width:320px;height:50px">
						<a class="btn blue" @if(Auth::check() && Auth::user()->getWifiFlag() == 0) href="#" @else disabled @endif>
							<span class="text-md-center">バナー広告</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="currentSeason" name="currentSeason" value="{{$current_season['term']}}">
	<input type="hidden" id="arraySeason" name="arraySeason" value="{{$current_season['term']}}">
	<input type="hidden" id="arraySeason" name="arraySeason" value="{{$current_season['term']}}">

	<!--<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

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
	</div>-->
@stop
@section('scripts')
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{asset('plugins/flot/jquery.flot.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.resize.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.pie.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.stack.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.crosshair.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('js/Theme.js')}}"></script>
	<script src="{{asset('js/Charts.js')}}"></script>
	<script src="{{asset('js/flot/jquery.flot.js')}}"></script>
	<script src="{{asset('js/flot/jquery.flot.orderBars.js')}}"></script>
	<link rel="stylesheet" href="{{asset('css/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
	<script type="text/javascript" src="{{asset('css/jqwidgets/jqxcore.js')}}"></script>
	<script type="text/javascript" src="{{asset('css/jqwidgets/jqxdraw.js')}}"></script>
	<script type="text/javascript" src="{{asset('css/jqwidgets/jqxchart.core.js')}}"></script>
	<script type="text/javascript" src="{{asset('css/jqwidgets/jqxdata.js')}}"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="{{asset('js/charts-flotcharts.js')}}"></script>

	<script>
		$('body').addClass('page-full-width');
		var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
		/*jQuery(document).ready(function() {
		    jQuery(window).scroll(function() {  
		    	            
                if (jQuery(window).scrollTop()>37){
                    jQuery("body").addClass("page-header-fixed");
                }
                else {
                    jQuery("body").removeClass("page-header-fixed");
                }
            });
		});*/ 
		//init socket 
		var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
		//login view in 一括操作
		var msgloginid = '{!! Request::session()->get('msglogin') !!}';
		if(msgloginid != '' && msgloginid !== null){
			var msglogin = '{!! Request::session()->put('msglogin', '') !!}';
			socket.emit('msglogin', msgloginid);
		}
		
		var current_year = new Date().getYear() + 1900;
		var point_now = 0;
		var point = [];
		var avg_now = 0;
		var avg = [];
		var current_season = $("#currentSeason").val();
		
		var array_season = [{{$array_season[0]}},{{$array_season[1]}},{{$array_season[2]}},{{$array_season[3]}}];
		
		$(".btn-rank1").click(function(){
			$(".form-horizontal").attr("action", "/group/rank/1");
		    $(".form-horizontal").submit();
		});

		$(".btn-rank2").click(function(){
			$(".form-horizontal").attr("action", "/group/rank/2");
		    $(".form-horizontal").submit();
		});

		$(".btn-rank3").click(function(){
			$(".form-horizontal").attr("action", "/group/rank/3");
		    $(".form-horizontal").submit();
		});

		$(".btn-rank4").click(function(){
			$(".form-horizontal").attr("action", "/group/rank/6");
		    $(".form-horizontal").submit();
		});
		$("#user_name").click(function(e) {
			e.preventDefault();
			var queryString = window.location.search;
			var baseUrl = location.origin;
			var userId = $("#user_name").attr("userId");
			console.log('[go detail]', queryString, baseUrl, userId)
			window.location.href=`${baseUrl}/admin/personaldata/${userId}${queryString}`
		})

		/*
		var quarters_point = [
			@for($i = 0; $i < 4; $i++)
				@if(isset($quarters_point[$i]))
					@if($i == 3)
						{{$quarters_point[$i]->sumpoint}}
					@else
						{{$quarters_point[$i]->sumpoint}},
					@endif
				@else
					@if($i == 3)
						{{0}}
					@else
						{{0}},
					@endif
				@endif
			@endfor
		];*/
		@if ($type == 0)
			@if (isset($grade) && $grade != 0)
				$("#student_show").css('display','block');
				$("#myallpoints_show").css('display','block');
			@else
				$("#student_show").css('display','none');
				$("#myallpoints_show").css('display','block');
			@endif
		@else
			$("#student_show").css('display','none');
			$("#myallpoints_show").css('display','block');
		@endif
		/*var quarters_avg = [
			@for($i = 0; $i < 4; $i++)
				@if(isset($quarters_avg[$i]))
					@if($i == 3)
						{{$quarters_avg[$i]}}
					@else
						{{$quarters_avg[$i]}},
					@endif
				@else
					@if($i == 3)
						{{0}}
					@else
						{{0}},
					@endif
				@endif
			@endfor
		];
		
		
		for($i = 0; $i <= current_season; $i ++){
			if(current_season == array_season[$i]){
				point_now = quarters_point[$i];
				avg_now = quarters_avg[$i];
			}else{
				point[$i] = quarters_point[$i];
				avg[$i] = quarters_avg[$i];
			}
		}
		*/
		@if($type == 0)
			var barChartData = {
				labels : [{{$cur_season[0]['year']}} + "年度 {{$cur_season[0]['season']}}"  ,{{$cur_season[1]['year']}} + "年度 {{$cur_season[1]['season']}}",{{$cur_season[2]['year']}} + "年度 {{$cur_season[2]['season']}}",{{$cur_season[3]['year']}} + "年度 {{$cur_season[3]['season']}}"],
				datasets : [
					{
						fillColor : "#d0cece",
						strokeColor : "#d0cece",
						data : [{{$myavgPoints[0][0]}},{{$myavgPoints[1][0]}},{{$myavgPoints[2][0]}},{{$myavgPoints[3][0]}}]
					},
					{
						fillColor : "#f8cbad",
						strokeColor : "#f8cbad",
						data : [{{$myavgPoints[0][1]}},{{$myavgPoints[1][1]}},{{$myavgPoints[2][1]}},{{$myavgPoints[3][1]}}]
					}
				]
				
			};
			new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
		@else
			//Interactive Chart
	        $(function () {
	            if ($('#target-chart').size() != 1) {
	                return;
	            }

	            var pageviews = [
	                [1,{{$myavgPoints[0][0]}}],
	                [2,{{$myavgPoints[1][0]}}],
	                [3,{{$myavgPoints[2][0]}}],
	                [4,{{$myavgPoints[3][0]}}],
	                [5,{{$myavgPoints[4][0]}}],
	                [6,{{$myavgPoints[5][0]}}],
	                [7,{{$myavgPoints[6][0]}}],
	                [8,{{$myavgPoints[7][0]}}],
	            ];
	            var visitors = [
	                [1,{{$myavgPoints[0][1]}}],
	                [2,{{$myavgPoints[1][1]}}],
	                [3,{{$myavgPoints[2][1]}}],
	                [4,{{$myavgPoints[3][1]}}],
	                [5,{{$myavgPoints[4][1]}}],
	                [6,{{$myavgPoints[5][1]}}],
	                [7,{{$myavgPoints[6][1]}}],
	                [8,{{$myavgPoints[7][1]}}],
	            ];

	            var plot = $.plot($("#target-chart"), [{
	                data: pageviews,
	                label: "全国平均",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0

	            }, {
	                data: visitors,
	                label: "自分",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0
	            }], {
	                series: {
	                    lines: {
	                        show: true,
	                        lineWidth: 2,
	                        fill: true,
	                        fillColor: {
	                            colors: [{
	                                opacity: 0.05
	                            }, {
	                                opacity: 0.01
	                            }]
	                        }
	                    },
	                    points: {
	                        show: true,
	                        radius: 3,
	                        lineWidth: 1
	                    },
	                    shadowSize: 2
	                },
	                grid: {
	                    hoverable: true,
	                    clickable: true,
	                    tickColor: "#eee",
	                    borderColor: "#eee",
	                    borderWidth: 1
	                },
	                colors: ["#d0cece", "#d12610", "#52e136"],
	                xaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                    mode: '',
	                },
	                yaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                }
	            });
				$(".dqtarget-chart .tickLabels .xAxis").empty();
				$xstr = "<div class='tickLabel' style='position:absolute;text-align:center;left:-12px;top:300px;width:60px'>"+{{$cur_season[0]['year']}} + "年度<br> {{$cur_season[0]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:54px;top:300px;width:60px'>"+{{$cur_season[1]['year']}} + "年度<br> {{$cur_season[1]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:119px;top:300px;width:60px'>"+{{$cur_season[2]['year']}} + "年度<br> {{$cur_season[2]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:185px;top:300px;width:60px'>"+{{$cur_season[3]['year']}} + "年度<br> {{$cur_season[3]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:250px;top:300px;width:60px'>"+{{$cur_season[4]['year']}} + "年度<br> {{$cur_season[4]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:316px;top:300px;width:60px'>"+{{$cur_season[5]['year']}} + "年度<br> {{$cur_season[5]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:381px;top:300px;width:60px'>"+{{$cur_season[6]['year']}} + "年度<br> {{$cur_season[6]['season']}}"+"</div><div class='tickLabel' style='position:absolute;text-align:center;left:447px;top:300px;width:60px'>"+{{$cur_season[7]['year']}} + "年度<br> {{$cur_season[7]['season']}}"+"</div>";
				$(".dqtarget-chart .tickLabels .xAxis").html($xstr);

	            function showTooltip(x, y, contents) {
	                $('<div id="tooltip">' + contents + '</div>').css({
	                    position: 'absolute',
	                    display: 'none',
	                    top: y + 5,
	                    left: x + 15,
	                    border: '1px solid #333',
	                    padding: '4px',
	                    color: '#fff',
	                    'border-radius': '3px',
	                    'background-color': '#333',
	                    opacity: 0.80
	                }).appendTo("body").fadeIn(200);

	            }

	            var previousPoint = null;
	            /*$("#target-chart").bind("plothover", function(event, pos, item) {
	                $("#x").text(pos.x.toFixed(2));
	                $("#y").text(pos.y.toFixed(2));
	               
	                if (item) {
	                    if (previousPoint != item.dataIndex) {
	                        previousPoint = item.dataIndex;

	                        $("#tooltip").remove();
	                        var x = item.datapoint[0].toFixed(2),
	                            y = item.datapoint[1].toFixed(2);

	                        showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
	                    }
	                } else {
	                    $("#tooltip").remove();
	                    previousPoint = null;
	                }
	            });*/
	        });

		@endif
		jQuery(document).ready(function() {
			if($("#viceLogin").val() == "vice_log"){
	            $("#alert_text").html("{{config('consts')['MESSAGES']['ASSOCIATE_MEMBER_ALERT']}}");
	            $("#alertModal").modal();
	        }

			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});

			$(".make-switch").on('switchChange.bootstrapSwitch', function(){
				var info = {
				    _token: $('meta[name="csrf-token"]').attr('content')
				}
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
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
				    	if(response.type = 'wishlists_is_public'){
				    		
			    			@foreach($wishBooks as $book)
			    				if(response.status)
			    					$("#{{$book->id}}").html("公開");
			    				else
			    					$("#{{$book->id}}").html("非公開");
			    			@endforeach
				    	}
			    	}
				});
			});
			ChartsFlotcharts.initBarCharts();
		});
		$(function () {
			Theme.init ();
		});
		$(function () {
		    // var arrVal = [];
      //       for (var i = 0; i < 20; i++) {
      //           if(i == 19) {
      //               arrVal +="[35," + i * 5 + "]";
      //           } else if(i == 0) {
      //               arrVal += "[56,1],";
      //           } else {
      //               arrVal += "[56," + i * 5 + "],";
      //           }
      //       }
		function showBar(tag, points_data, points_interval, member_interval, my_points, legend_text = '',axis_label = 'null'){
	 	  	var settings = {
				title:null,
				description: null,
				showLegend: true,
				showToolTips: false,
				enableAnimations: true,
				showBorderLine: false,
				legendLayout : { left:0 , top: 5, width:100, height:100, flow: 'vertical' },
				padding: { left: 0, top: 5, right: 20, bottom: 0 },
				source: points_data,
				xAxis:
				{
					dataField: 'x_point',
					gridLines: { visible: false },
					flip: true,
					minValue:0,
					unitInterval:points_interval,
					visible:true,
					labels:{
						angle:90,
						offset:{x:0,y:10}
					}
				},
				valueAxis:
				{
					flip: true,
					minValue:0,
					unitInterval:member_interval,
					labels: {
						visible: true,
						horizontalAlignment: 'left',
						formatFunction: function (value) {
							return parseInt(value);
						}
					},
					title: { text: axis_label,
                    		horizontalAlignment:'right'
                	}
				},
				colorScheme: 'scheme01',
				seriesGroups:
					[
						{
							type: 'column',
							orientation: 'horizontal',
							columnsGapPercent: 40,
							series: [
							{ dataField: 'value_member', displayText:legend_text, colorFunction: function (value, itemIndex, serie, group) {
											return (itemIndex == [Math.floor(my_points/points_interval)] ) ? '#FF0000' : '#0000ff';
							},
							labels: { 
                                    visible: true,
                                    horizontalAlignment : 'right',
                                    offset: { x: 5, y: 0 }
                             },
                                formatFunction: function (value) {
                                	if(value > 0)
                                   		 return value;
                                },
							   lineColor:'#0000ff',
							   lineWidth: 0.5
							}		
								]
						}
					]
			};

			// setup the chart
			$("#"+tag).jqxChart(settings);
	  }
	  	@if ($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->active == 1)
		var m_interval_num = 4;
		var p_interval_num = 15;
		var member_interval = 0;
		var points_interval = 0;
		@if($type == 0)		
			var myrank1 = 1;
			var myrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints1 as $i => $rank ): ?>
					myrank_pupils1 = myrank_pupils1 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						myrank1 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
			showBar("horizontal-chart1",points_data, points_interval, member_interval, my_points,myrank1+"位/"+myrank_pupils1+"人");


			var myrank2 = 1;
			var myrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints2 as $i => $rank ): ?>
					myrank_pupils2 = myrank_pupils2 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						myrank2 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
			showBar("horizontal-chart2",points_data, points_interval, member_interval, my_points,myrank2+"位/"+myrank_pupils2+"人");

		@endif

			var myrank3 = 1;
			var myrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints3 as $i => $rank ): ?>
					myrank_pupils3 = myrank_pupils3 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						myrank3 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart3",points_data, points_interval, member_interval, my_points,myrank3+"位/"+myrank_pupils3+"人");

			var myrank4 = 1;
			var myrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints4 as $i => $rank ): ?>
					myrank_pupils4 = myrank_pupils4 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						myrank4 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart4",points_data, points_interval, member_interval, my_points, myrank4+"位/"+myrank_pupils4+"人");

			var myrank5 = 1;
			var myrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints5 as $i => $rank ): ?>
					myrank_pupils5 = myrank_pupils5 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						myrank5 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart5",points_data, points_interval, member_interval, my_points, myrank5+"位/"+myrank_pupils5+"人");

			//
		@if($type == 0)	

			var threemonthrank1 = 1;
			var threemonthrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank ): ?>
					threemonthrank_pupils1 = threemonthrank_pupils1 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						threemonthrank1 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart1",points_data, points_interval, member_interval, my_points, threemonthrank1+"位/"+threemonthrank_pupils1+"人", '人');

			var threemonthrank2 = 1;
			var threemonthrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank ): ?>
					threemonthrank_pupils2 = threemonthrank_pupils2 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						threemonthrank2 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart2",points_data, points_interval, member_interval, my_points, threemonthrank2+"位/"+threemonthrank_pupils2+"人", '人');
		@endif

			var threemonthrank3 = 1;
			var threemonthrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank ): ?>
					threemonthrank_pupils3 = threemonthrank_pupils3 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						threemonthrank3 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart3",points_data, points_interval, member_interval, my_points, threemonthrank3+"位/"+threemonthrank_pupils3+"人", '人');
	
			var threemonthrank4 = 1;
			var threemonthrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank ): ?>
					threemonthrank_pupils4 = threemonthrank_pupils4 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						threemonthrank4 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart4",points_data, points_interval, member_interval, my_points, threemonthrank4+"位/"+threemonthrank_pupils4+"人", '人');

	
			var threemonthrank5 = 1;
			var threemonthrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank ): ?>
					threemonthrank_pupils5 = threemonthrank_pupils5 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						threemonthrank5 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart5",points_data, points_interval, member_interval, my_points, threemonthrank5+"位/"+threemonthrank_pupils5+"人", '人');

			//
		@if($type == 0)

			var allrank1 = 1;
			var allrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints1 as $i => $rank ): ?>
					allrank_pupils1 = allrank_pupils1 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						allrank1 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart1",points_data, points_interval, member_interval, my_points, allrank1+"位/"+allrank_pupils1+"人");

			var allrank2 = 1;
			var allrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints2 as $i => $rank ): ?>
					allrank_pupils2 = allrank_pupils2 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						allrank2 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart2",points_data, points_interval, member_interval, my_points, allrank2+"位/"+allrank_pupils2+"人");
		@endif
			
			var allrank3 = 1;
			var allrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints3 as $i => $rank ): ?>
					allrank_pupils3 = allrank_pupils3 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						allrank3 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart3",points_data, points_interval, member_interval, my_points, allrank3+"位/"+allrank_pupils3+"人");

			
			var allrank4 = 1;
			var allrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints4 as $i => $rank ): ?>
					allrank_pupils4 = allrank_pupils4 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						allrank4 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart4",points_data, points_interval, member_interval, my_points, allrank4+"位/"+allrank_pupils4+"人");

			
			var allrank5 = 1;
			var allrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints5 as $i => $rank ): ?>
					allrank_pupils5 = allrank_pupils5 + {{$rank->pupil_numbers}};
					@if($rank->flag=='1')
						allrank5 = {{$i+1}};
						my_points = {{$rank -> sum}};
					@endif		
					top_point = Math.max(top_point, {{$rank->sum}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->sum}}/points_interval)]+={{$rank->pupil_numbers}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart5",points_data, points_interval, member_interval, my_points, allrank5+"位/"+allrank_pupils5+"人");


		@endif
		});
 
	</script>
@stop