@extends('layout')

@section('styles')
    
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
		                > 	<a href="{{url('/top')}}">団体アカウントトップ</a>
		            </li>
		            <li class="hidden-xs">
		                > トップ校 過去5年
		            </li>
		        </ol>
		      </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				トップ校ランキング<br>
			</h3>
			@if(Auth::user()->role == config('consts')['USER']['ROLE']['LIBRARIAN'])
			<div class="row" style="margin-top:10px;margin-bottom:20px;">
				<div class="col-md-4">
					<select class="bs-select form-control">
						@foreach ($groups as $group)
						<option @if($group_id == $group->group_id) selected @endif id='{{$group->group_id}}'>{{$group->school->group_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box red">
						<div class="portlet-body">
							<ul class="nav nav-margent">
								@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
							    <li class="active">
									<a href="#tab_2_1" data-toggle="tab">
									市区町村内小学校ランキング </a>
								</li>
								<li>
									<a href="#tab_2_2" data-toggle="tab">
									都道府県内小学校ランキング </a>
								</li>
								<li>
									<a href="#tab_2_3" data-toggle="tab">
									全国小学校ランキング </a>
								</li>
								<li>
									<a href="#tab_2_4" data-toggle="tab">
									市区町村内中学校ランキング </a>
								</li>
								<li>
									<a href="#tab_2_5" data-toggle="tab">
									都道府県内中学校ランキング </a>
								</li>
								<li>
									<a href="#tab_2_6" data-toggle="tab">
									全国中学校ランキング </a>
								</li>
							    @else
								<li class="active">
									<a href="#tab_2_1" data-toggle="tab">
									市区町村内ランキング </a>
								</li>
								<li>
									<a href="#tab_2_2" data-toggle="tab">
									都道府県内ランキング </a>
								</li>
								<li>
									<a href="#tab_2_3" data-toggle="tab">
									全国ランキング </a>
								</li>
								@endif
							</ul>
							<div class="tab-content" style="background: #fcc5fa;">
								<div class="tab-pane fade active in" id="tab_2_1">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($cityTopSchools_1[0]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$cityTopSchools_1[0][$i]['name']}}</td>
													<td>{{$cityTopSchools_2[0][$i]['name']}}</td>
													<td>{{$cityTopSchools_3[0][$i]['name']}}</td>
													<td>{{$cityTopSchools_4[0][$i]['name']}}</td>
													<td>{{$cityTopSchools_5[0][$i]['name']}}</td>
												</tr>
											@endfor
										@else
											@for($i = 0; $i < count($cityTopSchools_1); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$cityTopSchools_1[$i]['name']}}</td>
													<td>{{$cityTopSchools_2[$i]['name']}}</td>
													<td>{{$cityTopSchools_3[$i]['name']}}</td>
													<td>{{$cityTopSchools_4[$i]['name']}}</td>
													<td>{{$cityTopSchools_5[$i]['name']}}</td>
												</tr>
											@endfor
										@endif	
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_2">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr  class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($provinceTopSchools_1[0]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$provinceTopSchools_1[0][$i]['name']}}</td>
													<td>{{$provinceTopSchools_2[0][$i]['name']}}</td>
													<td>{{$provinceTopSchools_3[0][$i]['name']}}</td>
													<td>{{$provinceTopSchools_4[0][$i]['name']}}</td>
													<td>{{$provinceTopSchools_5[0][$i]['name']}}</td>
												</tr>
											@endfor
										@else
											@for($i = 0; $i < count($provinceTopSchools_1); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$provinceTopSchools_1[$i]['name']}}</td>
													<td>{{$provinceTopSchools_2[$i]['name']}}</td>
													<td>{{$provinceTopSchools_3[$i]['name']}}</td>
													<td>{{$provinceTopSchools_4[$i]['name']}}</td>
													<td>{{$provinceTopSchools_5[$i]['name']}}</td>
												</tr>
											@endfor
										@endif
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_3">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr  class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($overallTopSchools_1[0]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$overallTopSchools_1[0][$i]['name']}}</td>
													<td>{{$overallTopSchools_2[0][$i]['name']}}</td>
													<td>{{$overallTopSchools_3[0][$i]['name']}}</td>
													<td>{{$overallTopSchools_4[0][$i]['name']}}</td>
													<td>{{$overallTopSchools_5[0][$i]['name']}}</td>
												</tr>
											@endfor
										@else
											@for($i = 0; $i < count($overallTopSchools_1); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$overallTopSchools_1[$i]['name']}}</td>
													<td>{{$overallTopSchools_2[$i]['name']}}</td>
													<td>{{$overallTopSchools_3[$i]['name']}}</td>
													<td>{{$overallTopSchools_4[$i]['name']}}</td>
													<td>{{$overallTopSchools_5[$i]['name']}}</td>
												</tr>
											@endfor
										@endif
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_4">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($cityTopSchools_1[1]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$cityTopSchools_1[1][$i]['name']}}</td>
													<td>{{$cityTopSchools_2[1][$i]['name']}}</td>
													<td>{{$cityTopSchools_3[1][$i]['name']}}</td>
													<td>{{$cityTopSchools_4[1][$i]['name']}}</td>
													<td>{{$cityTopSchools_5[1][$i]['name']}}</td>
												</tr>
											@endfor
										@endif	
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_5">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr  class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($provinceTopSchools_1[1]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$provinceTopSchools_1[1][$i]['name']}}</td>
													<td>{{$provinceTopSchools_2[1][$i]['name']}}</td>
													<td>{{$provinceTopSchools_3[1][$i]['name']}}</td>
													<td>{{$provinceTopSchools_4[1][$i]['name']}}</td>
													<td>{{$provinceTopSchools_5[1][$i]['name']}}</td>
												</tr>
											@endfor
										@endif
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_2_6">
									<table class="table table-striped table-bordered table-hover  data-table">
										<thead>
											<tr  class="success">
												<th width="10%"></th>
												<th width="18%"><?php echo $current_season['year']-1;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-2;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-3;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-4;?>年度</th>
												<th width="18%"><?php echo $current_season['year']-5;?>年度</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										@if($schoolUser->group_type == 0 || $schoolUser->group_type == 1)
											@for($i = 0; $i < count($overallTopSchools_1[1]); $i ++)
												<tr>
													<td>{{$i + 1}}位</td>
													<td>{{$overallTopSchools_1[1][$i]['name']}}</td>
													<td>{{$overallTopSchools_2[1][$i]['name']}}</td>
													<td>{{$overallTopSchools_3[1][$i]['name']}}</td>
													<td>{{$overallTopSchools_4[1][$i]['name']}}</td>
													<td>{{$overallTopSchools_5[1][$i]['name']}}</td>
												</tr>
											@endfor
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
					<!-- <a href="@if(Auth::user()->role == config('consts')['USER']['ROLE']['PUPIL']){{url('/mypage/top')}} @else{{url('/')}}@endif" class="btn btn-info pull-right">戻　る</a> --> 
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
		<form action={{url('/group/rank/6')}} id="selectGrade" name="rank6-form" method = "GET">
			<input type="hidden" name="_token" value="{{ csrf_field()}}">
			<input type="hidden" name="group_id" id="group_id" value=""/>
		</form>
	</div>
@stop
@section('scripts')
<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			@if($other_id != $user->id)
				$('body').addClass('page-full-width');
			@endif
			ComponentsDropdowns.init();
			$("select").change(function(){
//				alert($(":selected").attr("id"));
				$("#group_id").val($(":selected").attr("id"));
				$("#selectGrade").submit();
//				alert($(":selected").attr("id"));
			});
		});
    </script>
@stop