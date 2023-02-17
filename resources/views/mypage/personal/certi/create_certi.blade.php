@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}">
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
	                	 > 読書認定書の発行
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-10">
					<h3 class="page-title">読書認定書の発行</h3>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-warning pull-right btn-sample">見本を見る</button>
				</div>
			</div>
			

			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8" style="font-size:16px">
					<p>・　読書認定書は、学校や企業などに提出するための証明書類です。郵送や印刷のご依頼は受け付けておりません</p>
					<p>・　発行手続きが終わると、マイ書斎連絡帳へ、閲覧用パスコードをご連絡いたします。</p>
					<p>・　トップ画面最下部のパスコード入力欄は、提出先の方などがログインせずに入力でき、閲覧できます。</p>
					<p>・　発行手数料は300円です。 閲覧有効期限6か月延長も300円です。最後にPaypal決済画面に移ります。"</p>
				</div>
			</div>
			<form class="form form-horizontal offset-md-2 margin-top-20">
				<div class="form-group row">
					<label class="control-label col-md-2 pull-right">認定書の種類</label>
					<div class="col-md-5">
						<select class="bs-select form-control" name="sort" id="sort">
							<option value="1">現在のポイントと級のみ記載</option>
							<option value="2">現在のポイントと級および公開している全ての合格履歴を記載</option>
							<option value="3">現在のポイントと級および選択した合格履歴を記載（２０冊まで）</option>
							<option value="4">選択した合格履歴（２０冊まで）のみ記載</option>
							<option value="5">今の認定書の閲覧を6カ月間延長</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12 text-md-center">
						<button type="button" class="btn btn-success btn-press">プレビュー画面へ</button>
						<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
					</div>
				</div>
			</form>

			<div class="row" style = "display:none;" id = "include">
				<div class="row">
				<div class="col-md-6">						
					<div style="width:100%;height:100%;border:solid 1px;">
						<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
                            <div class="row">
                                <div class="col-md-12">  
                                    <div class="tools" style="float: left;">
                                        <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読<span style="font-family: 'Judson'">Q</span></h2>
                                    </div>                       
                                    <div class="tools text-md-right" style="float: right;">
                                        <span class="text-md-right text-md-top" style="float:right;">2〇〇〇年〇月〇日</span>
                                    </div>
                                </div>
                                <div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div>
								<div class="col-md-12">
									<h4 class="text-md-center">読書認定書</h4>
									<h5 class="text-md-center">（パスコード：　〇〇〇〇〇）</h5>
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">〇〇 〇〇　様</div>
								<div class="col-md-12 text-md-left">(読Qネーム：　〇〇〇〇〇〇)</div>
								<div class="col-md-12 text-md-right" style="float:right;">一般社団法人読書認定協会</div>
								<div class="col-md-12 text-md-right" style="float:right;">代表理事　神部ゆかり</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　〇〇級</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">合計取得ポイント　　〇〇〇〇ポイント</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">(2〇〇〇年〇月〇日 現在)</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-right">以上</div>
							</div>
						</div>
					</div>
				</div>
                
				<div class="col-md-6">						
					<div style="width:100%;height:100%;border:solid 1px;">
						<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
							<div class="row">
								<div class="col-md-12">  
                                    <div class="tools" style="float: left;">
                                        <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2>
                                    </div>                       
                                    <div class="tools text-md-right" style="float: right;">
                                        <span class="text-md-right text-md-top" style="float:right;">2〇〇〇年〇月〇日</span>
                                    </div>
                                </div>
								<div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div>
								<div class="col-md-12">
									<h4 class="text-md-center">読書認定書</h4>
									<h5 class="text-md-center">（パスコード：　〇〇〇〇〇）</h5>
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">〇〇 〇〇　様</div>
								<div class="col-md-12 text-md-left">(読Qネーム：　〇〇〇〇〇〇)</div>
								<div class="col-md-12 text-md-right" style="float:right;">一般社団法人読書認定協会</div>
								<div class="col-md-12 text-md-right" style="float:right;">代表理事　神部ゆかり</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　〇〇級</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">合計取得ポイント　　〇〇〇〇ポイント</div>	
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍一覧（抜粋）(2〇〇〇年〇月〇日 現在)</div>    
								<div class="col-md-12 text-md-left">&nbsp;</div>						
								<div class="col-md-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="col-md-2 align-middle">合格日</th>
												<th class="col-md-2 align-middle">タイトル</th>
												<th class="col-md-2 align-middle">著者</th>
												<th class="col-md-2 align-middle">出版社</th>
												<th class="col-md-1 align-middle">読Q本ID</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-md-6">						
					<div style="width:100%;height:100%;border:solid 1px;">
						<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
							<div class="row">
                                <div class="col-md-12">  
                                    <div class="tools" style="float: left;">
                                        <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2>
                                    </div>                       
                                    <div class="tools text-md-right" style="float: right;">
                                        <span class="text-md-right text-md-top" style="float:right;">2〇〇〇年〇月〇日</span>
                                    </div>
                                </div>
								<div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div>
								<div class="col-md-12">
									<h4 class="text-md-center">読書認定書</h4>
									<h5 class="text-md-center">（パスコード：　〇〇〇〇〇）</h5>
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">〇〇 〇〇　様</div>
								<div class="col-md-12 text-md-left">(読Qネーム：　〇〇〇〇〇〇)</div>
								<div class="col-md-12 text-md-right" style="float:right;">一般社団法人読書認定協会</div>
								<div class="col-md-12 text-md-right" style="float:right;">代表理事　神部ゆかり</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　〇〇級</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">合計取得ポイント　　〇〇〇〇ポイント</div>	
								<div class="col-md-12 text-md-left">&nbsp;</div>	
								<div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍一覧（著者名順）(2〇〇〇年〇月〇日 現在)</div>    
								<div class="col-md-12 text-md-left">&nbsp;</div>						
								<div class="col-md-12">
									<table class="table table-bordered">
										<tbody class="text-md-center">
										
											<tr style="height: 100px;">
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr style="height: 100px;">
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">						
					<div style="width:100%;height:100%;border:solid 1px;">
						<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
							<div class="row">
								<div class="col-md-12">  
                                    <div class="tools" style="float: left;">
                                        <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2>
                                    </div>                       
                                    <div class="tools text-md-right" style="float: right;">
                                        <span class="text-md-right text-md-top" style="float:right;">2〇〇〇年〇月〇日</span>
                                    </div>
                                </div>
								<div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div>
								<div class="col-md-12">
									<h4 class="text-md-center">読書認定書</h4>
									<h5 class="text-md-center">（パスコード：　〇〇〇〇〇）</h5>
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">〇〇 〇〇　様</div>
								<div class="col-md-12 text-md-left">(読Qネーム：　〇〇〇〇〇〇)</div>
								<div class="col-md-12 text-md-right" style="float:right;">一般社団法人読書認定協会</div>
								<div class="col-md-12 text-md-right" style="float:right;">代表理事　神部ゆかり</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									あなたは、当協会の運営する読Q検定において、下表の通り、書籍についての検定試験に合格されました。
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍一覧（抜粋）(2〇〇〇年〇月〇日 現在)</div>    
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>							
								<div class="col-md-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="col-md-2 align-middle">合格日</th>
												<th class="col-md-2 align-middle">タイトル</th>
												<th class="col-md-2 align-middle">著者</th>
												<th class="col-md-2 align-middle">出版社</th>
												<th class="col-md-1 align-middle">読Q本ID</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
										
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
                                                          
			ComponentsDropdowns.init();
			$(".btn-press").click(function(){
				index = $("#sort").val();
				location.href = '{{url("/mypage/certi_check")}}' + "/" + index;
				// if ($index == 1) {             
                    
                             
				// 	location.href = '{{url("/mypage/preview_certi/1")}}';
                    
				// } else if($index == 2){
  
				// 	location.href = '{{url("/mypage/preview_certi/2")}}';
				// } else if($index == 3 || $index == 4){
  
				// 	location.href = '{{url("/mypage/search_certi/")}}' + "/" + $index;
				// }else if($index == 5){
                                        
				// 	location.href = '{{url("/mypage/preview_certi/5")}}';
                    
				// }
				//location.href = "/mypage/last_report/" + $("#sort").val();
			});
			$(".btn-sample").click(function(){
				$index = $("#sort").val();
				if ($index == 1) {
					$("#include").css("display","block");
				}
			});
		});
    </script>
@stop