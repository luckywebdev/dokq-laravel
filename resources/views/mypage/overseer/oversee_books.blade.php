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
	            	<a href="{{url('/mypage/top')}}">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 監修本一覧
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修本一覧</h3>

			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="blue">
									<th class="col-md-1" style="padding:0px">監修決定日</th>
									<th class="col-md-2" style="padding:0px">タイトル</th>
									<th class="col-md-1" style="padding:0px">著者</th>
									<th class="col-md-1" style="padding:0px">読Q本ID</th>
									<th class="col-md-1" style="padding:0px">読Q本認定日</th>
									<th class="col-md-1" style="padding:0px">出題数</th>
									<th class="col-md-1" style="padding:0px">認定ｸｲｽﾞ数</th>
									<th class="col-md-2" style="padding:0px">帯文管理</th>
									<th class="col-md-2" style="padding:0px;font-size:13px">各書籍のクイズストックへ</th>
								</tr>
							</thead>
							<tbody class="text-md-left">
								@foreach($books as $book)
									<tr>
										
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script>
		jQuery(document).ready(function() {
		});   
	</script>
@stop