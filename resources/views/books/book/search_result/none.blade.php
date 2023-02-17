<div class="col-md-12">
	@if((isset($keywordSearch) && $keywordSearch) || (isset($specSearch) && $specSearch == 1))
	<h4>
	検索結果0件です。
	</h4>
	@else
	<h4>
	まだ読Q本がありません。
	</h4>
	<h4>
	あなたが、読Qに登録して、クイズを作りませんか？
	</h4>
	@endif
</div>
