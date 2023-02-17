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
					<a href="#"> > 検索結果の見方</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">検索結果の見方</h3>

			<div class="row">
				<div class="col-md-12">
					<p>読Q本ランキング（合格者数ランキング）や検索結果画面、推薦図書一覧表画面でのクリック操作は下記の通りです。<br><br>
						<p>タイトルをクリック・・・　その本のページへ</p>
						<p>著者名をクリック・・・　著書一覧表が表示される。</p>
						<p>プルダウンメニュー・・合格者数順や五十音順の昇順降順が選べる</p>
						<p>「この本を受検」をクリック・・・受検画面へ　（既に合格済の本の場合は、薄く表示されて、クリックできない）</p>
						<p>「この本の詳細を見る」をクリック・・・本のページへ</p>
						<p>「読みたい本に追加」をクリック・・・マイ書斎の、読みたい本リストに追加される。（既に合格済の本の場合は、薄く表示されて、クリックできない）</p>
						 <p>「この本のクイズを作る」をクリック・・・クイズを募集中の読Q本の場合は、これをクリックするとクイズ作成画面へ	</p>					

					<br><br><br>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('book/search')}}" class="btn btn-info pull-right">戻　る</a>
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