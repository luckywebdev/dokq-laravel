
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
                        >   <a href="{{url('/top')}}">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 読書量ランキング１００
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content" style="height: 700px">
			<h3 class="page-title">読書量ランキング100：　読Qポイント獲得者上位100人</h3>
			<div class="form">
				<form class="form-horizontal form-row-separated"  action="{{url('/admin/book_ranking')}}" method="get" id="book_form">
					<div class="form-body">
						<div class="form-group col-md-6">
							<label class="control-label col-md-2">期間</label>
							<div class="col-md-4">
								<select class="form-control input-small select2me" name="rankperiod" id="rankperiod" data-placeholder="選択...">
									<option></option>
									@foreach(config('consts')['USER']['RANKPERIOD'] as $key=>$rperiod)
										<option value="{{$key+1}}" @if($rankperiod == $key+1) selected @endif>{{$rperiod}}</option>
									@endforeach
								</select>
							</div>							
						</div>
						<div class="form-group col-md-4">
							<label class="control-label col-md-2">年代</label>
							<div class="col-md-3">
								<select class="form-control input-small select2me" name="rankyear" id="rankyear" data-placeholder="選択...">
									<option></option>
									@foreach(config('consts')['USER']['RANKYEARS'] as $key=>$ryear)
										<option value="{{$key+1}}"  @if($rankyear == $key+1) selected @endif>{{$ryear}}</option>
									@endforeach
								</select>
							</div>							
						</div>
						<div class="form-group col-md-2">
						<button type="button" id="btn_submit" class="btn btn-warning pull-right" role="button">実　行</button>
						</div>
					</div>
				</form>
			</div>

			<div class="form-body col-md-12">
				<div class="form-group col-md-6" style="max-height: 500px; overflow-y: auto">
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="blue">
								<th>順位</th>
								<th>名前</th>
								<th>級</th>
								<th>居住地</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						   @foreach($ranks as $key => $rank)
						   @if($key < ceil(count($ranks)/2))
							<tr>
								<td>{{$key+1}}</td>
								<td>@if(Date("Y") - Date("Y", strtotime($rank->birthday)) >= 15)
										@if($rank->firstname != '' && $rank->firstname !== null && $rank->fullname_is_public == 1) 
											<a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue">{{$rank->firstname}} {{$rank->lastname}}</a>
										@else
											<a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue"> {{$rank->username}}</a>
										@endif
									@else 
										<a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue">中学生以下非表示</a>
									@endif
								</td>
								<td>
									@if($rank->cur_point >= 0 && $rank->cur_point < 20)
						               10 級
						            @elseif($rank->cur_point >= 20 && $rank->cur_point < 60)
						                9 級
						            @elseif($rank->cur_point >= 60 && $rank->cur_point < 120)
						                8 級
						            @elseif($rank->cur_point >= 120 && $rank->cur_point < 220)
						                7 級
						            @elseif($rank->cur_point >= 220 && $rank->cur_point < 370)
						               6 級
						            @elseif($rank->cur_point >= 370 && $rank->cur_point < 870)
						                5 級
						            @elseif($rank->cur_point >= 660 && $rank->cur_point < 2070)
						                4 級
						            @elseif($rank->cur_point >= 1060 && $rank->cur_point < 6070)
						                3 級
						            @elseif($rank->cur_point >= 1610 && $rank->cur_point < 14070)
						                2 級
						            @elseif($rank->cur_point >= 2400 && $rank->cur_point < 29070)
						                1 級
						            @else
						                超段
						            @endif
								</td>
								<td>@if($rank->address1 != '' && $rank->address1 !== null) {{$rank->address1 != '0' ? $rank->address1 : '国外'}} @endif</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="form-group col-md-6" style="max-height: 500px; overflow-y: auto">
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="blue">
								<th>順位</th>
								<th>名前</th>
								<th>級</th>
								<th>居住地</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						   @foreach($ranks as $key => $rank)
						   @if($key >= ceil(count($ranks)/2))
							<tr>
								<td>{{$key+1}}</td>
								<td>@if(Date("Y") - Date("Y", strtotime($rank->birthday)) >= 15)
										@if($rank->firstname != '' && $rank->firstname !== null && $rank->fullname_is_public == 1) 
											<a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue">{{$rank->firstname}} {{$rank->lastname}}</a>
										@else
											<a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue"> {{$rank->username}}</a>
										@endif
									@else <a href="{{url('mypage/other_view/' . $rank->id)}}" class="font-blue">中学生以下非表示</a> @endif
								</td>
								<td>
									@if($rank->cur_point >= 0 && $rank->cur_point < 20)
						               10 級
						            @elseif($rank->cur_point >= 20 && $rank->cur_point < 60)
						                9 級
						            @elseif($rank->cur_point >= 60 && $rank->cur_point < 120)
						                8 級
						            @elseif($rank->cur_point >= 120 && $rank->cur_point < 220)
						                7 級
						            @elseif($rank->cur_point >= 220 && $rank->cur_point < 370)
						               6 級
						            @elseif($rank->cur_point >= 370 && $rank->cur_point < 870)
						                5 級
						            @elseif($rank->cur_point >= 660 && $rank->cur_point < 2070)
						                4 級
						            @elseif($rank->cur_point >= 1060 && $rank->cur_point < 6070)
						                3 級
						            @elseif($rank->cur_point >= 1610 && $rank->cur_point < 14070)
						                2 級
						            @elseif($rank->cur_point >= 2400 && $rank->cur_point < 29070)
						                1 級
						            @else
						                超段
						            @endif
								</td>
								<td>@if($rank->address1 != '' && $rank->address1 !== null) {{$rank->address1 != '0' ? $rank->address1 : '国外'}}  @endif</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript">
		
        $("#btn_submit").click(function(){
			
			$("#book_form").submit();
			
    	});
	</script>
@stop