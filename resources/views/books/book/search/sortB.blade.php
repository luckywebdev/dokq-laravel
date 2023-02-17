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
					<a href="{{url('book/search')}}"> > 読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					<a href="#"> > 読Q本ランキングからさがす</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Q本ランキングからさがす</h3>
			<br><br>				
			<div class="row">
				<div class="col-md-12">
					<div class="form form-horizontal">
						<form class="form-horizontal" action="{{url('book/search/ranking')}}" method="post">
						{{csrf_field()}}
							<div class="form-group row">
								<div class="offset-md-1 col-md-4">
									<h4 class="text-md-right"> 読Q本ランキングからさがす</h4>
								</div>
								<div class="col-md-4">
									<select class="bs-select form-control" name="rank">									
										@foreach(config('consts')['BOOK']['RANKINGS'] as $key=>$ranking)
											<option value="{{$key}}"  
												@if(Auth::check() && Auth::user()->isPupil() && Auth::user()->active == 1) 
												@else 
													@if($key==13 || $key==14)disabled  @endif 
												@endif>
												{{$ranking}}
											</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="offset-md-1 col-md-4">
									<h4 class="text-md-right"> 男女別選択</h4>
								</div>
								<div class="col-md-2">
									<select class="bs-select form-control" name="gender">
										<option value="3">男女分けない</option>
										<option value="2">男</option>
										<option value="1">女</option>										
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="offset-md-1 col-md-4">
									<h4 class="text-md-right"> ランキング集計期間</h4>
								</div>
								<div class="col-md-4">
									<select class="bs-select form-control" name="period">									
										@foreach(config('consts')['BOOK']['RANKING_PERIOD'] as $key=>$period)
											<option value="{{$key}}">{{$period}}</option>
										@endforeach
									</select>
								</div>								
							</div>
							<div class="form-group">
								<div class="col-md-12 text-md-center">
									<button class="btn btn-primary">次 へ<i class="fa fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('book/search')}}" class="btn btn-info pull-right" >戻　る</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();

		});
    </script>
@stop