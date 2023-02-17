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
	            <li class="hidden-xs">
	            	<a href="{{url('/mypage/top')}}">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	> 試験監督をする
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">試験監督をする</h3>

			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8">
					<p>PCやスマートフォンで行う読Q受検において、不正が無いよう受検者を監督します。</p>
					<p>読Qでは、スマートフォンをお持ちで20歳以上の良識のある方ならだれでも、試験監督をしていただけます。</p>
					<p style="color:#f00;">（初めての場合は適性検査を受けてください。適性と判断されなければ試験監督は出来ません。適性検査の所要時間は約5分です。）</p>
				</div>
			</div>
			
			<form class="form form-horizontal" action="{{ url("/mypage/overseer_test_start") }}" method="post">
			{{ csrf_field() }}
				<div class="form-group row">
					
					<div class="col-md-3">
						
					</div>
					<div class="col-md-3">
						@if(Auth::user()->aptitude != 0 && Auth::user()->age() > 20)
						<a href="{{url('/mypage/test_overseer')}}" class="btn btn-warning pull-right">適性検査へ</a>
						@else
						<span class="btn btn-warning pull-right disabled">適性検査へ</span>
						@endif
					</div>
				</div>

				<div class="form-group row">
					<div class="offset-md-2 col-md-8">
						<div class="news-blocks">
							<h4 class="text-md-center">読Q試験監督の心得</h4>
							<p>受検者から目を離さない。</p>
							<p>受検が始まったら、受検者と言葉を交わさない。</p>
							<p>受検者が他の人とも言葉を交わさないよう監督する。</p>
							<p>受検者が、問題を読み上げるなど、声を出したらやめさせる。</p>
							<p>不正があったら、受検者のクイズ画面で「中止」を押し、不合格にする。</p>
							<button type="button" class="btn btn-warning offset-md-5 btn-confirm @if(Auth::user()->aptitude == 0) disabled @endif">確認しました</button>
						</div>
					</div>
				</div>
			</form>
			
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>

<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>読Q</strong></h4>
      	</div>
      	<div class="modal-body">
            <h4>受検者の端末に、あなたのパスワード入力＆顔認証すると、検定が開始されます。</h4>
            <h4 class="text-md-right">現在時刻  {{Date('Y.m.d H:i:s')}}</h4>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >次　へ</button>
        </div>
    </div>

  </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
    $(".btn-confirm").click(function() {
        $("#alertModal").modal();
    });
    $(".modal-close").click(function() {
        $(".form-horizontal").submit();
    });
</script>
@stop