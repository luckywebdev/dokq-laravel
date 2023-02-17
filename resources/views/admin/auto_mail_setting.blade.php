
@extends('layout')
@section('styles')
    
@stop


@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-title">連絡帳への自動メッセージの設定</div>
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">自動メッセージの設定（会員マイ書斎内連絡帳へ自動入力）</div>
				</div>
				<div class="portlet-body form">
					<form class="form form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">不合格した時点ですぐ案内</label>
								<div class="col-md-9">
									<textarea class="form-control">〇月〇日に受検された「〇〇〇〇」の再受検は、〇月〇日〇時からできます。
									</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">本の認定</label>
								<div class="col-md-9">
									<textarea class="form-control">あなたが読Q本に登録申請をしていた「〇〇〇〇」が、読Q本に認定されました。これにより、読Q本ポイントの１０％が、あなたの読Qポイントに加算されます。
									</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">本の認定却下</label>
								<div class="col-md-9">
									<textarea class="form-control">〇月〇日に読Q本に登録申請していただいた「〇〇〇〇」は、残念ながら登録できません。</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3"></label>
								<div class="col-md-9">
									<textarea class="form-control">読Q本への登録が途中保存されています。編集へ戻るには、こちらをクリックしてください。</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">監修者に認定</label>
								<div class="col-md-9">
									<textarea class="form-control">あなたを、監修者に認定します。読Qクイズの選定や、担当本のページの投稿管理をお任せします。</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">監修者認定却下</label>
								<div class="col-md-9">
									<textarea class="form-control">残念ながら、あなたを監修者に認定することはできません。今後はぜひクイズ作成や本の登録などで、共に読書推進を行っていただきたく、引き続きよろしくお願いいたします。
									</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">作成クイズ認定</label>
								<div class="col-md-9">
									<textarea class="form-control">あなたが作成されたクイズが、読Qの認定ｸｲｽﾞになりました。　読Q本ﾎﾟｲﾝﾄの10％が、あなたのポイントに付与されます。マイ書斎内の「読Q活動の全履歴」をご確認ください。</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">作成クイズ却下</label>
								<div class="col-md-9">
									<textarea class="form-control">残念ながら、あなたが作成されたクイズは、認定に至りませんでした。マイ書斎内の　読Q活動の全履歴をご確認ください。</textarea>
								</div>							
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">監修者に決定</label>
								<div class="col-md-9">
									<textarea class="form-control">あなたを、監修者に決定します。マイ書斎内の監修応募履歴をご確認ください。読Qクイズの選定や、担当本のページの投稿管理をよろしくお願いいたします。</textarea>
								</div>							
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">監修者落選</label>
								<div class="col-md-9">
									<textarea class="form-control">残念ながら、本の監修者に選ばれませんでした。マイ書斎内の監修応募履歴をご確認ください。</textarea>
								</div>							
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript">
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop