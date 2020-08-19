
@extends('layout')
@section('styles')
    
@stop


@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-title">ポップアップ文章リスト</div>
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">自動メッセージの設定（会員マイ書斎内連絡帳へ自動入力）</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ページ</th>
								<th>用途</th>
								<th>形態</th>
								<th>文面</th>
							</tr>
						</thead>
						<style>
							td {text-align:center;}
						</style>
						<tbody>
							<tr>
								<td>ログイン画面</td>
								<td>読Qネームorパスワードエラー</td>
								<td>赤字</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">読Qネームまたはパスワードが違います。3回間違えて入力すると、ロックがかかります。</textarea></td>
							</tr>
							<tr>
								<td>パスワード再設定</td>
								<td></td>
								<td>赤字</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">すでに使用されているパスワード、または無効のパスワードです。８～15文字の半角英数字で、違うパスワードをご登録願います。</textarea></td>
							</tr>
							<tr>
								<td>団体基本情報編集</td>
								<td></td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">読Q団体パスワードを入力　（入力スペース）　「送信」</textarea></td>
							</tr>
							<tr>
								<td>教職員検索</td>
								<td>教職員検索</td>
								<td>赤字</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">読Qに登録がありません。登録してください。</textarea></td>
							</tr>
							<tr>
								<td>児童生徒検索</td>
								<td>F ログインエラー ロック解除</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">ログインエラーによるロックを解除しました。　　「OK」</textarea></td>
							</tr>
							<tr>
								<td>児童生徒検索</td>
								<td>G 顔認証エラーの解除と顔登録</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">顔認証エラーを解除し、登録画面を表示しました。　　「OK」</textarea></td>
							</tr>
							<tr>
								<td>合格記録の取り消し</td>
								<td>合格記録を取り消し、不合格にする</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">削除しますか？　　□削除する　　「実行」</textarea></td>
							</tr>
							<tr>
								<td>団体教師パスワード</td>
								<td>作業B～Gをする際の教師認証</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">パスワード入力　　　□パスワード表示　　　「送信」　　(2.3o画面の通り）</textarea></td>
							</tr>
							<tr>
								<td>お問い合わせ</td>
								<td>送信したことの確認</td>
								<td>赤字</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">送信しました</textarea></td>
							</tr>
							<tr>
								<td>クイズ送信完了</td>
								<td>作成したクイズを管理者へ送信</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">ありがとうございました。作成いただいたクイズを、管理者へ送信しました。認定審査にしばらくお時間をいただきます。結果が出ましたら、マイ書斎内連絡帳でお知らせします。　「「トップへ戻る」ボタン</textarea></td>
							</tr>
							<tr>
								<td></td>
								<td>読みたい本リストに追加</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">この本を読みたい本リストに追加しました。マイ書斎の読みたい本リストで確認できます。（5.4b 読みたい本リストに追加）参照</textarea></td>
							</tr>
							<tr>
								<td>受検の確認</td>
								<td>年齢制限で受検できない</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">この本は年齢制限のある本なので、受検できません。　　「OK」</textarea></td>
							</tr>
							<tr>
								<td>受検の確認</td>
								<td>3日経たないうちに再々受検しようとしたら</td>
								<td>ダイアログbox</td>
								<td><div class="col-md-1"></div><textarea class="col-md-10">この本のクイズに2度目も不合格でしたので、3日間この本を受検できません。他の本の受検はできます。OK</textarea></td>
							</tr>
						</tbody>
					</table>
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