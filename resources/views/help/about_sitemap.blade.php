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
                	<a href="{{url('/about_site')}}"> > 読Qとは</a>
	            </li>
	             <li class="hidden-xs">
                	<a href="#"> > サイトマップ</a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">サイトマップ</span>
				</div>
			</div>
			<div class="row" style="margin-top: 1%">
				<div class="col-md-12">
					<div class="col-md-2 ">
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">読Qトップページ</a></li>
							<li><a href="{{ url('/') }}" style="font-size: 150%">新しい読Q本</a></li>
							<li><a href="{{ url('/') }}" style="font-size: 150%">クイズ募集中の本</a></li>
							<li><a href="{{ url('/') }}" style="font-size: 150%">監修者募集中の本</a></li>
							<li style="font-size: 150%">お知らせ</li>
							<li><a href="{{ url('/mypage/book_ranking') }}" style="font-size: 150%">読書量ランキング100</a></li>
							<li style="font-size: 150%">読Ｑポイント順位</li>
							<li style="font-size: 150%">試験監督をする</li>
							<li style="font-size: 150%">読書認定書閲覧</li>
						</ul>
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">新規登録/ ログイン</a></li>
							<li><a href="{{ url('/auth/login') }}" style="font-size: 150%">ログイン</a></li>
							<li><a href="{{ url('/auth/register/0/1') }}" style="font-size: 150%">学校団体新規登録</a></li>
							<li><a href="{{ url('/auth/viewpdf/group') }}" style="font-size: 150%">学校団体利用規約と申し込みの流れ（PDF)</a></li>
							<li><a href="{{ url('/auth/register/1/1') }}" style="font-size: 150%">一般会員新規登録</a></li>
							<li><a href="{{ url('/auth/viewpdf/user') }}" style="font-size: 150%">一般会員利用規約と申し込みの流れ（PDF)</a></li>
							<li><a href="{{ url('/auth/register/2/1') }}" style="font-size: 150%">監修者会員新規登録</a></li>
							<li><a href="{{ url('/auth/viewpdf/overseer') }}" style="font-size: 150%">監修者会員利用規約と申し込みの流れ（PDF)</a></li>
							<li><a href="{{ url('/auth/register/3/1') }}" style="font-size: 150%">著者会員新規登録</a></li>
							<li><a href="{{ url('/auth/viewpdf/author') }}" style="font-size: 150%">著者会員利用規約と申し込みの流れ（PDF)</a></li>
						</ul>
					</div>
					<div class="col-md-2">
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">読Qとは</a></li>
							<li><a href="{{ url('/about_site') }}" style="font-size: 150%">読Qの特長</a></li>
							<li><a href="{{ url('/about_score') }}" style="font-size: 150%">読Qの使い方</a></li>
							<li><a href="{{ url('/about_target') }}" style="font-size: 150%">ポイントのしくみと取得目標</a></li>
							<li><a href="{{ url('/about_overseer') }}" style="font-size: 150%">監修者紹介</a></li>
							<li><a href="{{ url('/about_test') }}" style="font-size: 150%">受検問題サンプル</a></li>
							<li><a href="{{ url('/about_recog') }}" style="font-size: 150%">顔認証について</a></li>
							<li><a href="{{ url('/outline') }}" style="font-size: 150%">法人概要</a></li>
							<li><a href="{{ url('/agreement') }}" style="font-size: 150%">利用規約</a></li>
							<li><a href="{{ url('/about_pay') }}" style="font-size: 150%">会費・料金について</a></li>
							<li><a href="{{ url('/security') }}" style="font-size: 150%">個人情報保護方針</a></li>
							<li><a href="{{ url('/ask') }}" style="font-size: 150%">お問合せ</a></li>
							<li><a href="{{ url('/faq') }}" style="font-size: 150%">よくある質問</a></li>
						</ul>
					</div>

					<div class="col-md-2">
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">本の検索</a></li>
							<li><a href="{{ url('/book/search') }}" style="font-size: 150%">本の検索</a></li>
							<li><a href="{{ url('/book/search/help') }}" style="font-size: 150%">検索のしかた</a></li>
							<li><a href="{{ url('/book/result/help') }}" style="font-size: 150%">検索結果の見方</a></li>
						</ul>
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">本の登録とクイズ作成</a></li>
							<li style="font-size: 150%">本を登録する際の注意事項</li>
							<li style="font-size: 150%">本の登録画面</li>
							<li style="font-size: 150%">クイズ作成画面</li>
							<li style="font-size: 150%">作成クイズ確認画面</li>
						</ul>
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">受検</a></li>
							<li style="font-size: 150%">受検の注意事項</li>
						</ul>
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">本のページ</a></li>
							<li style="font-size: 150%">クイズストック</li>
							<li style="font-size: 150%">合格者検索</li>
							<li style="font-size: 150%">帯文投稿</li>
						</ul>
					</div>

					<div class="col-md-2">
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">マイ書斎</a></li>
							<li style="font-size: 150%">マイ書斎</li>
							<li style="font-size: 150%">読Qからの連絡帳</li>
							<li style="font-size: 150%">読みたい本リスト</li>
							<li style="font-size: 150%">マイ本棚</li>
							<li style="font-size: 150%">読Q活動の全記録</li>
							<li style="font-size: 150%">読Q合格履歴</li>
							<li style="font-size: 150%">ポイントランキング（順位）</li>
							<li style="font-size: 150%">読Qポイント順位グラフ</li>
							<li style="font-size: 150%">読書推進活動ランキング</li>
							<li style="font-size: 150%">本の登録認定記録</li>
							<li style="font-size: 150%">作成クイズの認定記録</li>
							<li style="font-size: 150%">読Qレポート</li>
							<li style="font-size: 150%">帯文投稿履歴</li>
							<li style="font-size: 150%">試験監督履歴</li>
							<li style="font-size: 150%">読書認定書発行</li>
							<li style="font-size: 150%">基本情報</li>
							<li style="font-size: 150%">お支払い</li>
							<li style="font-size: 150%">監修本リスト（監修者会員）</li>
							<li style="font-size: 150%">自著リスト（著者会員)</li>
						</ul>
					</div>

					<div class="col-md-3">
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">会員学校トップページ</a></li>
							<li style="font-size: 150%">団体の読Q基本情報</li>
							@if(Auth::check() && Auth::user()->isGroupSchoolMember())
							<li><a href="{{ url('/auth/viewpdf?role=100&helpdoc=/manual/group_manual.pdf') }}" style="font-size: 150%">団体読Qマニュアル</a></li>
							@else
							<li style="font-size: 150%">団体読Qマニュアル</li>
							@endif
							<li style="font-size: 150%">読Qクラス設定</li>
							<li style="font-size: 150%">読Q担任登録</li>
							<li style="font-size: 150%">クラス対抗読Qランキング</li>
							<li style="font-size: 150%">学校対抗読Qランキング</li>
							<li style="font-size: 150%">小中学校読Qランキング全国順位</li>
						</ul>
						<ul style="list-style:none">
							<li><a href="" style="font-weight: bold; color: #fd73cf; font-size: 180%">教職員トップページ</a></li>
							<li style="font-size: 150%">クラスの読書量</li>
							<li style="font-size: 150%">担任クラス一括受検</li>
							<li style="font-size: 150%">クラス内読Qランキング</li>
						</ul>
					</div>


				</div>
			</div>
			
		</div>
	</div>
@stop
@section('scripts')
    
@stop