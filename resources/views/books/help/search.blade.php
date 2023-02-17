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
					<a href="#"> > 検索のしかた</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<!--<small class="page-title" align="center" style="font-size: 16px" st>けんさく</small>-->
			<h3 class="page-title">検索のしかた</h3>
			<h5 class="text-center">読Ｑに認定されている本（読Ｑ本）を検索します</h5>

			<div class="row">
				<div class="col-md-12" style="font-size: 16px">
					<p><strong>1.読みたい本や受検したい本、クイズを作りたい本が、すでに読Ｑに登録されていないかどうか検索する場合</strong></p><br>
					<strong>タイトルからさがす</strong><br>
					　　・入力欄にタイトルを入力。スペースを開けずに、漢字、ひらがな、カタカナで入力してください。<br>
					　　・プルダウンメニューで、「を含む」　「から始まる」　「と一致する」の中でどれか当てはまるものを選択してください。うろ覚えの場合は「を含む」を選択しましょう。<br>
					<br>
					<strong>著者名からさがす</strong><br>
					　　・姓、名それぞれの入力欄に、漢字、ひらがな、カタカナで入力してください。<br>
					　　・プルダウンメニューで、「を含む」　「から始まる」　「と一致する」の中でどれか当てはまるものを選択してください。うろ覚えの場合は「を含む」を選択しましょう。<br>
					<br>
					<strong>ＩＳＢＮからさがす</strong><br>
					　　・下１桁を除いた、４から始まる9桁の数字を入力してください。<br>
						<br>入力例：　夏目漱石「坊ちゃん」：IBSN978-4-80-204179-9 の場合、末尾の９を除き、４から始まる下９桁「480204179」　と入力します。<br><br>
					
					<p><strong>2.読Ｑ本の中で、好みの本を見つけたい場合</strong></p><br>
						<strong>帯文のキーワードからさがす</strong><br>
						&nbsp;&nbsp;&nbsp;&nbsp;・ 読Ｑ本の帯文とは、その本をまだ読んでいない人へ向けて、１９文字以内で表したおすすめ文です。その本の読Ｑ受検に合格した人が投稿できます。<br>
						&nbsp;&nbsp;&nbsp;&nbsp;・ キーワードは１つだけです。複数入力すると検出されません。<br>
						&nbsp;&nbsp;&nbsp;&nbsp;・ 例えば、女の子が出てくる話を読みたいと思ったら、キーワードに「女の子」と入力します。すると、例えば「小さな女の子が主人公」、「海辺の町に住む女の子の話」、「女の子と犬の物語です」など「女の子」という言葉が含まれた帯文を持つ本が検出されます。<br>
						&nbsp;&nbsp;&nbsp;&nbsp;・タイトルや著者名欄に入力がある状態でも、帯文キーワード検索は出来ます。より絞られた検索結果になります。<br><br>
						 <strong>良さそうな本を選びたい場合</strong><br>
						 &nbsp;&nbsp;&nbsp;&nbsp;・「年代別おすすめ本からさがす」：　小学校～中学校までの読Ｑ推薦図書から選択。新登録順に表示されます。<br>
						 &nbsp;&nbsp;&nbsp;&nbsp;・「ジャンルからさがす」: ジャンルは複数選択できます。<br>
						 &nbsp;&nbsp;&nbsp;&nbsp;・「新しく認定された読Q本からさがす」：　新しく認定された順に表示されます。<br>
						 &nbsp;&nbsp;&nbsp;&nbsp;・「ランキングからさがす」：　種類、男女別、期間についてプルダウンメニューから選択して表示します。<br><br>
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