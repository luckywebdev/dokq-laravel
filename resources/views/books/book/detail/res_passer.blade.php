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
	            <li>
	                > <a href="{{url('/book/search')}}">本を検索</a>
	            </li>
	            <li>
	                > <a @if($book->active >= 3) href="<?php echo url('book').'/'.$book->id.'/detail'; ?>" @endif>本のページ</a>
	            </li>
	            <li class="hidden-xs">
	                > 読Q合格者検索結果
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Q合格者の検索結果</h3>

			<div class="row">
				<div class="offset-md-1 col-md-10">						
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="yellow">
								<th class="col-md-3">氏名</th>
								<th class="col-md-3">読Qネーム</th>
								<th class="col-md-3">本の名前</th>
								<th class="col-md-3">合格日</th>
							</tr>
						</thead>
						<tbody class="text-md-center">
						    @if(count($bookPasses) > 0)
						    	<?php $index = 1; ?>
							    @foreach($bookPasses as $key => $one)
								<tr @if($key % 2 == 0) class="warning" @endif>
									<td><a href="{{url('mypage/other_view/' . $one->id)}}" class="font-blue-madison">
										@if($one->age() < 15 && $schoolmember == 0)
							                中学生以下ー{{$index}}
							            @else
							            	<?php if($one->role != config('consts')['USER']['ROLE']['AUTHOR']){
							                            if($one->fullname_is_public) 
							                            	$title = $one->fullname(); 
							                            else $title = '●●●'; 
							                        }else{
							                            if($one->fullname_is_public) 
							                            	$title = $one->fullname_nick();
							                            else $title = '●●●'; 
							                        } 
							                        echo $title;?> 
							            @endif
							           </a></td>
									<td><a href="{{url('mypage/other_view/' . $one->id)}}" class="font-blue-madison">
										@if($one->age() < 15 && $schoolmember == 0)
							                中学生以下ー{{$index++}}
							            @else
							            	<?php if($one->role != config('consts')['USER']['ROLE']['AUTHOR']){
							                            if($one->fullname_is_public) 
							                            	$title = '●●●'; 
							                            else $title = $one->username; 
							                        }else{
							                            if($one->fullname_is_public) 
							                            	$title = '●●●';
							                            else $title = $one->username; 
							                        } 
							                        echo $title;?> 
							            @endif
							            </a></td>
									<td><a href="{{url('/book/'.$book->id.'/detail')}}" class="font-blue-madison">{{$one->title}}</a></td>
									<td>{{date_format(date_create($one->finished_date), "Y/m/d")}}</td>
								</tr>
								@endforeach
							@else
							<tr class="warning">
								<td colspan="4" class="text-md-center">該当がありませんでした。</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
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
		$(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
@stop