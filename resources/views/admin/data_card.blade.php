
@extends('layout')
@section('styles')
    <style type="text/css">
	.caution{
		font-size: 16px;
	}
	.caution tr{
		margin-bottom: 10px;
	}
    </style>
@stop
@section('contents')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">会員データカード　受検データ</h3>

        <div class="row margin-top-20">
            <div class="col-md-12">
                <table class="table table-no-border caution">
                    <tr>
                        <td class="col-md-3">会員種別</td>
                        <td>一般、監修者、著者、団体教師、協会</td>
                    </tr>
                    <tr>
                        <td>会員の基本情報</td>
                        <td>本名、読Qネーム、パスワード、生年月日、住所電話、メールアドレス、顔認証データ、有効期限、現在の級、過去の昇級日時、昇級まであと何ポイント、現在の生涯ポイント、現在の今年度ポイント、現在の今四半期ポイント</td>
                    </tr>
                    <tr>
                        <td>所属団体（あれば）</td>
                        <td>団体名、団体へ入学、転入日、卒業、転校日、団体読Qネーム、所属学級</td>
                    </tr>
                    <tr>
                        <td>ログイン情報</td>
                        <td>ログイン、ログアウト日時</td>
                    </tr>
                    <tr>
                        <td>受検データ</td>
                        <td>受検開始と終了日時秒、合否、タイトル、ISBN、この本の受検何回目か、2回目以降の不合格の場合、同タイトル受検不可3日間（72時間）が終わるのはいつか、試験監督名、得た合格ポイント、得た時短加算ポイント、合格本の公開非公開、回答した各クイズ文№、そのクイズ文を解くのが1度目、2度目を記録、クイズ文出題順番、そのクイズ文の正誤、そのクイズ文に答えるのにかかった時間</td>
                    </tr>
                    <tr>
                        <td>本の登録データ</td>
                        <td>タイトル、読Q本ID、送信日、認定日、得た本の登録ポイント、読Q認定された本の数</td>
                    </tr>
                    <tr>
                        <td>作成クイズデータ</td>
                        <td>送信日、タイトル、読Q本ID、クイズ文面、認定されたｸｲｽﾞ№、認定日、得たクイズ作成ポイント、認定されたクイズ文の数、クイズが認定された本の数、得たクイズ作成ポイント累計</td>
                    </tr>
                    <tr>
                        <td>その他の読Q活動全記録データ</td>
                        <td>（クイズや本、監修希望など応募して不採択のものなど）</td>
                    </tr>
                    <tr>
                        <td>一言あらすじ投稿</td>
                        <td>投稿日時、本文、いいね！の数、いいね！してくれた人の読Qネーム</td>
                    </tr>
                    <tr>
                        <td colspan="2">読みたい本リストに追加した本タイトル、ISBN、追加した日、読み終わって受検準備完了しているか否かの表示</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <a id = "export" href = "{{url('/admin/export_personal_data')}}" class="btn btn-warning pull-right" role="button" style="margin-bottom:8px;">ExcelExport</a>
            </div>
            <div class="col-md-2">
                <a href="{{url('/')}}" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
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