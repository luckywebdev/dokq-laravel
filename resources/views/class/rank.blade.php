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
	            	> <a href="{{url('/top')}}">
	                	団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > クラス内の読書量
	            </li>
	            <li class="hidden-xs">
	                >
	                @if($type == 5)最近の読Q活動
	                @elseif($type == 1)今期順位
	                @elseif($type == 2)前回順位
	                @elseif($type == 3)今年度通算順位
	                @elseif($type == 4)生涯順位
	                @endif
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				@if($type == 5)
				クラス内 最近の読Q活動	
				@endif
				@if($type == 4)
				クラス内 生涯ポイント順位<br>
				（読Qを始めてから現在までの合計ポイント順位）
				@endif
				@if($type == 3)
				クラス内 今年度通算ポイント順位 ({{$current_season['begin_thisyear']}}.4.1~{{$current_season['end_thisyear']}}.3.31)
				@endif
				@if($type == 2)
				クラス内 前回順位  ({{$preQuartDateString}})
				@endif
				@if($type == 1)
				クラス内 今期順位 ({{$curQuartDateString}})
				@endif
			</h3>
			
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control" id="class_select" name="class_select">
						<option value="-1"></option>
						@foreach($classes as $class)
						<option  @if($classid == $class->id) selected @endif value="{{$class->id}}">
						@if($class->grade == 0)
							{{$class->class_number}} {{$class->teacher_name}}
							@if(($class->class_number != '' && $class->class_number != null) || ($class->teacher_name != '' && $class->teacher_name != null))
								学級/
							@endif
						@elseif($class->class_number == '' || $class->class_number == null)
							{{$class->grade}} {{$class->teacher_name}}年/
						@else
							{{$class->grade}}-{{$class->class_number}} {{$class->teacher_name}}学級/
						@endif
						{{$class->year}}年度
						@if($class->member_counts != 0 && $class->member_counts !== null)
						 	{{$class->member_counts}}名
						@endif	
						@endforeach
						</option>
					</select>
				</div>
				<div class="col-md-8">
					<p class="pull-right">{{date('Y.m.d')}}  現在</p>
				</div>	
			</div>
			
			<form method="get" action="{{url('class/rank/'.$type)}}" id="form">
				<input type="hidden" name="class_id" value="" id="class_id"/>
			</form>
			
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i><?php echo $current_season['year'] ?>年度に獲得
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-purple">
								<li class="@if(isset($type) && $type == '1') active @endif">
									<a href="{{url('/class/rank/1?class_id='.$classid)}}"><strong>
									今期ポイント順位</strong></a>
								</li>
								<li class="@if(isset($type) && $type == '2') active @endif">
									<a href="{{url('/class/rank/2?class_id='.$classid)}}"><strong>
									前回ポイント順</strong></a>
								</li>
								<li class="@if(isset($type) && $type == '3') active @endif">
									<a href="{{url('/class/rank/3?class_id='.$classid)}}"><strong>
									今年度通算ポイント順 </strong></a>
								</li>
								<li class="@if(isset($type) && $type == '4') active @endif">
									<a href="{{url('/class/rank/4?class_id='.$classid)}}"><strong>
									生涯ポイント順位</strong></a>
								</li>
								<li class="@if(isset($type) && $type == '5') active @endif">
									<a href="{{url('/class/rank/5?class_id='.$classid)}}"><strong>
									直近の読Q活動を見る</strong></a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade @if(isset($type) && $type == '1') active in @endif" id="tab_1">
									<table class="table table-bordered table-hover" id="sample_rank1">
										<thead>
											<tr style="color: black;" role="row" width="100%">
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">直近の<br>受検日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">今期獲得<br>ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">現在の目標<br>達成率</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br>@if($classnumber != '')/{{$classnumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br>@if($gradenumber != '')/{{$gradenumber}}@endif</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if(isset($type) && $type == '1')
											@foreach($users as $user)												
												<tr>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname." ".$user->lastname}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname_yomi." ".$user->lastname_yomi}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->username}}</td>
													<td style="vertical-align:middle; background-color:white">
														@if($user->cur_point >= 0 && $user->cur_point < 20)
											               10 級
											            @elseif($user->cur_point >= 20 && $user->cur_point < 60)
											                9 級
											            @elseif($user->cur_point >= 60 && $user->cur_point < 120)
											                8 級
											            @elseif($user->cur_point >= 120 && $user->cur_point < 220)
											                7 級
											            @elseif($user->cur_point >= 220 && $user->cur_point < 370)
											               6 級
											            @elseif($user->cur_point >= 370 && $user->cur_point < 870)
											                5 級
											            @elseif($user->cur_point >= 870 && $user->cur_point < 2070)
											                4 級
											            @elseif($user->cur_point >= 2070 && $user->cur_point < 6070)
											                3 級
											            @elseif($user->cur_point >= 6070 && $user->cur_point < 14070)
											                2 級
											            @elseif($user->cur_point >= 14070 && $user->cur_point < 29070)
											                1 級
											            @else
											                超段
											            @endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{config('consts')['USER']['GENDER'][$user->gender]}}</td>
													<td style="vertical-align:middle; background-color:white">
														@if(isset($user->userquiz) && $user->userquiz->type == 2 && $user->userquiz->finished_date1 !== null && $user->userquiz->finished_date1 != '')
														{{date_format(date_create($user->userquiz->finished_date1), "Y/m/d")}}
														@endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{floor($user->userquiz->cur_point*100)/100}}

													@if($user->PupilsClass->type == 0) /
														@if($user->PupilsClass->grade == 1) 7
														@elseif($user->PupilsClass->grade == 2) 13
														@elseif($user->PupilsClass->grade == 3) 20
														@elseif($user->PupilsClass->grade == 4) 35
														@elseif($user->PupilsClass->grade == 5) 50
														@else($user->PupilsClass->grade == 6) 70
														@endif
													@endif
													</td>
													<td style="vertical-align:middle; background-color:white">
													@if($user->PupilsClass->type == 0) 
														@if($user->PupilsClass->grade == 1) {{floor($user->userquiz->cur_point*100/7)}}%
														@elseif($user->PupilsClass->grade == 2) {{floor($user->userquiz->cur_point*100/13)}}%
														@elseif($user->PupilsClass->grade == 3) {{floor($user->userquiz->cur_point*100/20)}}%
														@elseif($user->PupilsClass->grade == 4) {{floor($user->userquiz->cur_point*100/35)}}%
														@elseif($user->PupilsClass->grade == 5) {{floor($user->userquiz->cur_point*100/50)}}%
														@else($user->PupilsClass->grade == 6) {{floor($user->userquiz->cur_point*100/70)}}%
														@endif
													@endif	
													</td>
													<td style="vertical-align:middle; background-color:white">{{$user->classrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->graderank}}位</td>
													
												</tr>												
											@endforeach
											
										@endif
										</tbody>
											<tr >
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white">{{floor($totalPoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white">{{floor($avgpoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade @if(isset($type) && $type == '2') active in @endif" id="tab_2">
									<table class="table table-bordered table-hover" id="sample_rank2">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px; vertical-align:middle;background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">前回ポイント</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br>@if($classnumber != '')/{{$classnumber}}@endif</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br>@if($gradenumber != '')/{{$gradenumber}}@endif</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br>@if($citynumber != '')/{{$citynumber}}@endif</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br>@if($provincenumber != '')/{{$provincenumber}}@endif</th>												
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if(isset($type) && $type == '2')
											@foreach($users as $user)												
												<tr>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname." ".$user->lastname}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname_yomi." ".$user->lastname_yomi}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->username}}</td>
													<td style="vertical-align:middle; background-color:white">
											            @if($user->cur_point >= 0 && $user->cur_point < 20)
											               10 級
											            @elseif($user->cur_point >= 20 && $user->cur_point < 60)
											                9 級
											            @elseif($user->cur_point >= 60 && $user->cur_point < 120)
											                8 級
											            @elseif($user->cur_point >= 120 && $user->cur_point < 220)
											                7 級
											            @elseif($user->cur_point >= 220 && $user->cur_point < 370)
											               6 級
											            @elseif($user->cur_point >= 370 && $user->cur_point < 870)
											                5 級
											            @elseif($user->cur_point >= 870 && $user->cur_point < 2070)
											                4 級
											            @elseif($user->cur_point >= 2070 && $user->cur_point < 6070)
											                3 級
											            @elseif($user->cur_point >= 6070 && $user->cur_point < 14070)
											                2 級
											            @elseif($user->cur_point >= 14070 && $user->cur_point < 29070)
											                1 級
											            @else
											                超段
											            @endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{config('consts')['USER']['GENDER'][$user->gender]}}</td>
													<td style="vertical-align:middle; background-color:white">{{floor($user->userquiz->cur_point*100)/100}}
													@if($user->PupilsClass->type == 0) /
														@if($user->PupilsClass->grade == 1) 7
														@elseif($user->PupilsClass->grade == 2) 13
														@elseif($user->PupilsClass->grade == 3) 20
														@elseif($user->PupilsClass->grade == 4) 35
														@elseif($user->PupilsClass->grade == 5) 50
														@else($user->PupilsClass->grade == 6) 70
														@endif
													@endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{$user->classrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->graderank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->cityrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->provincerank}}位</td>
												</tr>												
											@endforeach
											
										@endif	
										</tbody>
											<tr >
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white">{{floor($totalPoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white">{{floor($avgpoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade @if(isset($type) && $type == '3') active in @endif" id="tab_3">
									<table class="table table-bordered table-hover" id="sample_rank3">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px;vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">今年度通算<br>ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br>@if($classnumber != '')/{{$classnumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br>@if($gradenumber != '')/{{$gradenumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br>@if($citynumber != '')/{{$citynumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br>@if($provincenumber != '')/{{$provincenumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">全国順位<br>@if($countrynumber != '')/{{$countrynumber}}@endif</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if(isset($type) && $type == '3')
											@foreach($users as $user)												
												<tr>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname." ".$user->lastname}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname_yomi." ".$user->lastname_yomi}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->username}}</td>
													<td style="vertical-align:middle; background-color:white">
														@if($user->cur_point >= 0 && $user->cur_point < 20)
											               10 級
											            @elseif($user->cur_point >= 20 && $user->cur_point < 60)
											                9 級
											            @elseif($user->cur_point >= 60 && $user->cur_point < 120)
											                8 級
											            @elseif($user->cur_point >= 120 && $user->cur_point < 220)
											                7 級
											            @elseif($user->cur_point >= 220 && $user->cur_point < 370)
											               6 級
											            @elseif($user->cur_point >= 370 && $user->cur_point < 870)
											                5 級
											            @elseif($user->cur_point >= 870 && $user->cur_point < 2070)
											                4 級
											            @elseif($user->cur_point >= 2070 && $user->cur_point < 6070)
											                3 級
											            @elseif($user->cur_point >= 6070 && $user->cur_point < 14070)
											                2 級
											            @elseif($user->cur_point >= 14070 && $user->cur_point < 29070)
											                1 級
											            @else
											                超段
											            @endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{config('consts')['USER']['GENDER'][$user->gender]}}</td>
													<td style="vertical-align:middle; background-color:white">{{floor($user->userquiz->cur_point*100)/100}}
													<!-- @if($user->PupilsClass->type == 0) /
														@if($user->PupilsClass->grade == 1) 7
														@elseif($user->PupilsClass->grade == 2) 13
														@elseif($user->PupilsClass->grade == 3) 20
														@elseif($user->PupilsClass->grade == 4) 35
														@elseif($user->PupilsClass->grade == 5) 50
														@else($user->PupilsClass->grade == 6) 70
														@endif
													@endif -->
													</td>
													<td style="vertical-align:middle; background-color:white">{{$user->classrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->graderank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->cityrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->provincerank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->countryrank}}位</td>

												</tr>												
											@endforeach
											
										@endif
											
										</tbody>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white">{{floor($totalPoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white">{{floor($avgpoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade @if(isset($type) && $type == '4') active in @endif" id="tab_4">
									<table class="table table-bordered table-hover" id="sample_rank4">
										<thead>
											<tr style="color: black;" role="row">
												<th width="10%" style="padding:0px;vertical-align:middle; background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">性別</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">生涯ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クラス内順位<br>@if($classnumber != '')/{{$classnumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">学年順位<br>@if($gradenumber != '')/{{$gradenumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">市区町村内順位<br>@if($citynumber != '')/{{$citynumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">都道府県内順位<br>@if($provincenumber != '')/{{$provincenumber}}@endif</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">全国順位<br>@if($countrynumber != '')/{{$countrynumber}}@endif</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if(isset($type) && $type == '4')
											@foreach($users as $user)												
												<tr>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname." ".$user->lastname}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname_yomi." ".$user->lastname_yomi}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->username}}</td>
													<td style="vertical-align:middle; background-color:white">
														@if($user->cur_point >= 0 && $user->cur_point < 20)
											               10 級
											            @elseif($user->cur_point >= 20 && $user->cur_point < 60)
											                9 級
											            @elseif($user->cur_point >= 60 && $user->cur_point < 120)
											                8 級
											            @elseif($user->cur_point >= 120 && $user->cur_point < 220)
											                7 級
											            @elseif($user->cur_point >= 220 && $user->cur_point < 370)
											               6 級
											            @elseif($user->cur_point >= 370 && $user->cur_point < 870)
											                5 級
											            @elseif($user->cur_point >= 870 && $user->cur_point < 2070)
											                4 級
											            @elseif($user->cur_point >= 2070 && $user->cur_point < 6070)
											                3 級
											            @elseif($user->cur_point >= 6070 && $user->cur_point < 14070)
											                2 級
											            @elseif($user->cur_point >= 14070 && $user->cur_point < 29070)
											                1 級
											            @else
											                超段
											            @endif
													</td>
													<td style="vertical-align:middle; background-color:white">{{config('consts')['USER']['GENDER'][$user->gender]}}</td>
													<td style="vertical-align:middle; background-color:white">{{floor($user->userquiz->cur_point*100)/100}}
													<!-- @if($user->PupilsClass->type == 0) /
														@if($user->PupilsClass->grade == 1) 7
														@elseif($user->PupilsClass->grade == 2) 13
														@elseif($user->PupilsClass->grade == 3) 20
														@elseif($user->PupilsClass->grade == 4) 35
														@elseif($user->PupilsClass->grade == 5) 50
														@else($user->PupilsClass->grade == 6) 70
														@endif
													@endif -->
													</td>
													<td style="vertical-align:middle; background-color:white">{{$user->classrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->graderank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->cityrank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->provincerank}}位</td>
													<td style="vertical-align:middle; background-color:white">{{$user->countryrank}}位</td>

												</tr>												
											@endforeach
											
										@endif
										</tbody>
										<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">合計</td>
												<td style="vertical-align:middle; background-color:white">{{floor($totalPoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
											<tr>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white">クラス平均</td>
												<td style="vertical-align:middle; background-color:white">{{floor($avgpoint*100)/100}}</td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
												<td style="vertical-align:middle; background-color:white"></td>
											</tr>
									</table>
								</div>
								<div class="tab-pane fade @if(isset($type) && $type == '5') active in @endif" id="tab_5">
									<table class="table table-bordered table-hover" id="sample_rank5">
										<thead>
											<tr style="color: black;height:40px" role="row">
												<th width="10%" style="padding:0px; vertical-align:middle;background-color:#dbbbe8">名前</th>
												<th width="15%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">よ み</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">読Qネーム</th>
												<th width="5%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">級</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">受検日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">クイズ作成日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">書籍登録日</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">本のタイトル</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">獲得ポイント</th>
												<th width="10%" style="padding:0px; vertical-align:middle; background-color:#dbbbe8">備考</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if(isset($type) && $type == '5')	
											@foreach($users as $user)												
												<tr>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname." ".$user->lastname}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->firstname_yomi." ".$user->lastname_yomi}}</td>
													<td style="vertical-align:middle; background-color:white">{{$user->username}}</td>
													<td style="vertical-align:middle; background-color:white">
														@if($user->cur_point >= 0 && $user->cur_point < 20)
											               10 級
											            @elseif($user->cur_point >= 20 && $user->cur_point < 60)
											                9 級
											            @elseif($user->cur_point >= 60 && $user->cur_point < 120)
											                8 級
											            @elseif($user->cur_point >= 120 && $user->cur_point < 220)
											                7 級
											            @elseif($user->cur_point >= 220 && $user->cur_point < 370)
											               6 級
											            @elseif($user->cur_point >= 370 && $user->cur_point < 870)
											                5 級
											            @elseif($user->cur_point >= 870 && $user->cur_point < 2070)
											                4 級
											            @elseif($user->cur_point >= 2070 && $user->cur_point < 6070)
											                3 級
											            @elseif($user->cur_point >= 6070 && $user->cur_point < 14070)
											                2 級
											            @elseif($user->cur_point >= 14070 && $user->cur_point < 29070)
											                1 級
											            @else
											                超段
											            @endif
													</td>
													@if(isset($user->userquiz) && $user->userquiz->type == 2)
													<td style="vertical-align:middle; background-color:white">{{date_format(date_create($user->userquiz->created_date), "Y/m/d")}}</td>
													@else
													<td style="vertical-align:middle; background-color:white"></td>
													@endif

													@if(isset($user->userquiz) && $user->userquiz->type == 1)
													<td style="vertical-align:middle; background-color:white">{{date_format(date_create($user->userquiz->created_date),"Y/m/d")}}</td>
													@else
													<td style="vertical-align:middle; background-color:white"></td>
													@endif

													@if(isset($user->userquiz) && $user->userquiz->type == 0)													
													<td style="vertical-align:middle; background-color:white">{{date_format(date_create($user->userquiz->created_date), "Y/m/d")}}</td>
													@else
													<td style="vertical-align:middle; background-color:white"></td>
													@endif

													<td style="vertical-align:middle; background-color:white">@if(isset($user->userquiz)){{$user->userquiz->Book->title}}@endif</td>

													<td style="vertical-align:middle; background-color:white">@if(isset($user->userquiz)){{floor($user->userquiz->point*100)/100}}@endif</td>

													@if(isset($user->userquiz) && $user->userquiz->type == 2)
														@if(isset($user->userquiz) && ($user->userquiz->status == 3 || $user->userquiz->status == 4))
														<td style="vertical-align:middle; background-color:white">{{$userQuizStatus[$user->userquiz->status]}}</td>
														@else
														<td style="vertical-align:middle; background-color:white"></td>									
														@endif
													@else
														<td style="vertical-align:middle; background-color:white"></td>
													@endif
												</tr>												
											@endforeach
										@endif																					
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">読Qトップへ戻る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();

			$("#class_select").change(function(){
				$("#class_id").val($(this).val());
				$("#form").submit();
			});
		});
    </script>
@stop