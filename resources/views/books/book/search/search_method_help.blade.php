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
			<small align="center">けんさく</small>
			<h3 class="page-title">検索のしかた</h3>

			<div class="row">
				<div class="col-md-12">
					<p>読みたい本や受検したい本が、読Qに登録されているかどうか、検索しましょう。<br><br>


					<strong>タイトルの入力</strong><br>
					　　入力欄に、漢字またはひらがなで入力してください。<br>
					　　プルダウンメニューで、「から始まる」　「を含む」　「と一致する」の中でどれか当てはまるものを選択してください。うろ覚えの場合は「を含む」を選択しましょう。<br>
					　　特定の著者の本のどれかを選びたいという場合は、タイトル欄は空欄で大丈夫です。<br>
					<br>
					<strong>著者の入力</strong><br>
					　　入力欄に、漢字またはひらがなで入力してください。<br>
					　　プルダウンメニューで、「から始まる」　「を含む」　「と一致する」の中でどれか当てはまるものを選択してください。うろ覚えの場合は「を含む」を選択しましょう。<br>
					　　タイトルを入力してあれば、著者欄は空欄でも大丈夫です。ただし、別々の著者の同じタイトルの著作がある場合、その両方が検出されます。<br>
					<br>
					<strong>ISBNの入力</strong><br>
					　　下１桁を除いた、４から始まる9桁の数字を入力してください。例：夏目漱石「坊ちゃん」：IBSN978-4-80-204179-9 の場合、最後の9を除き、４から始まる下9桁「480204179」と入力。<br><br>
					
					
					<p><strong>読みたい本が決まっていない場合</strong></p>
					
					　　帯文のキーワードから探す<br>
					　　　　　帯文とは、その本の内容について15文字以内で表した文です。読Q受検に合格した人々によって沢山作成されます。例えば、女の子が出てくる話を読みたいと思ったら、キーワードに「女の子」と入力します。<br>
					　　　　　すると、例えば「小さな女の子が主人公」とか、「海辺の町に住む女の子の話」　「女の子と犬の物語です」など「女の子」という言葉が含まれた帯文を持つ本が検出されます。<br><br>
					　
					　　良さそうな本を選びたい場合<br>
					　　　　　プルダウンメニューから、「年代別おすすめ本からさがす」、「新しく認定された読Q本からさがす」、「ジャンルからさがす」、「ランキングからさがす」のいずれかを選択し「次へ」を押すとそれぞれのページへ。<br><br><br>
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