
@extends('layout')
@section('styles')
@stop


@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-title">
				<h3>個別送信用Eメールアドレス：　　〇〇〇〇〇〇＠〇〇〇〇</h3>
				<h3>個別送信用メールのパスワード：　　●● ●● ●● ●●</h3>
			</div>
			<div class="row">
				<div class="col-md-12 portlet box purple">
					<div class="portlet-title">
						<div class="caption">新規メッセージ</div>
					</div>
					<div class="portlet-body form">
						<form class="form-horizontal">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label col-md-1">配信日</label>
									<div class="col-md-2">
										<input class="form-control form-control-inline date-picker" readonly>
										<span class="help-block">春期末</span>
									</div>
									<div class="col-md-2">
										<input class="form-control form-control-inline date-picker" readonly>
										<span class="help-block">夏期末</span>
									</div>
									<div class="col-md-2">
										<input class="form-control form-control-inline date-picker" readonly>
										<span class="help-block">秋期末</span>
									</div>
									<div class="col-md-2">
										<input class="form-control form-control-inline date-picker" readonly>
										<span class="help-block">冬期末</span>
									</div>
									<label class="control-label col-md-1">の年4回</label>
								</div>
								<div class="form-group">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<p>個人会員へ、流れて消えてしまう記録を、レポートという形で年4回、その時点のランキングなど、記録を残してあとで閲覧できるようにする。</p>
										<p>保存期間　　　3年間</p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<p>一般会員読Qレポート</p>
										<p>内容は、7.4e 読Qレポートの通り。冬期末のみ、四半期末と年度末レポートの2種類になるので、量が多い。</p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<p>監修者会員読Qレポート</p>
										<p>7.4e 読Qレポートに加えて、その四半期の間の、監修した本リストと監修応募履歴を加えたもの。</p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<p>著者会員読Qレポート</p>
										<p>7.4e 読Qレポートに加えて、読Qにおける自著の読者数比較グラフ、自著リスト、監修した本リストを加えたもの。</p>
									</div>
								</div>
							</div>
						</form>
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
	 jQuery(document).ready(function() {       
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: 'ja'
            });
        }
	});   
	</script>
@stop
	