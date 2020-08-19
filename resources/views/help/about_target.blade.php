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
                	<a href="#"> > ポイント取得目標</a>
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
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 300%; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">ポイントの仕組みと取得目標</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<br>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							<strong>読Ｑポイント</strong>・・・・・本のクイズ受検合格や、読書推進活動（クイズ作成と本の登録）で獲得できるポイントの総称。読Ｑでは、このポイントの獲得量が、級を上げ、読書量を表します。</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							読Ｑポイントには、下記の５つが含まれます。</p>	
						<p style="font-size:16px; text-align: left; line-height: 30px">
							・読Ｑ本ポイント・・・各書籍に、字数や難易度によって読Ｑ独自に設定したポイント。合格すると獲得できます。</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							  例：　夏目漱石「坊ちゃん」・・・・・・20.4ポイント</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							　神沢利子「くまの子ウーフ」・・・0.4ポイント。</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							・本の登録ポイント・・・本の基本情報、難易度、内容量等を読Ｑに登録すると獲得 （読Ｑ本ポイントの１０%）。</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							・クイズ作成ポイント・・本の内容に関するクイズを作成し、それが正式に読Ｑの検定問題として認定されると</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							獲得するポイント （1問につき、読Ｑ本ポイントの１０％）。</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							但し、クイズ作成ポイントがもらえるのは、1冊につき最高１０問までです。</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							・短時間加算ポイント・・受検において、規定所要時間の半分以下で合格した場合に加算されるポイント</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							（読Ｑ本ポイントの１０％）</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							※本の登録やクイズ作成は、より深くその本を理解した加算ポイントとして。短時間加算ポイントは、早く読め
							る力も読書力であるとして、読書量に含めることとしました。</p>
						<p style="font-size:16px; text-align: left; line-height: 30px">
							　　　　※全ての加算ポイントを取得後に受検すると、受検合格のみの場合の２．２倍のポイントを獲得できます。</p>
						<p style="font-size:16px; padding-left: 15%; text-align: left; line-height: 30px">
							読Ｑ本ポイントに応じて、出題数が決まります
						</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<br>
					<table class="table table-bordered table-hover">
						<tbody class="text-md-center">
							<tr>
								<td>読Ｑ本ポイント</td>
								<td>3.00まで</td>
								<td>3.01~7.00</td>
								<td>7.01~12.00</td>
								<td>12.01~15.00</td>
								<td>15.01~24.00</td>
								<td>24.01以上</td>
							</tr>
							<tr>
								<td>出題数</td>
								<td>8</td>
								<td>10</td>
								<td>12</td>
								<td>15</td>
								<td>18</td>
								<td>20</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<h3 class="text-md-center">級を取得するために必要な合計ポイント</h3>

			<div class="row">
				<div class="col-md-12">
					<p style="font-size:16px;">
						例：　6級になるためには、それまで読んだ本のポイントの合計が、220ポイントを超える必要があります。
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered table-hover">
						<tbody class="text-md-center">
							<tr class="info">
								<td class="col-md-1"></td>
								<td class="col-md-1">10級</td>
								<td class="col-md-1"></td>
								<td class="col-md-1">9級</td>
								<td class="col-md-1"></td>
								<td class="col-md-1">8級</td>
								<td class="col-md-1"></td>
								<td class="col-md-1">7級</td>
								<td class="col-md-1"></td>
								<td class="col-md-1">6級</td>
								<td class="col-md-1"></td>
							</tr>
							<tr>
								<td></td>
								<td>0</td>
								<td>+20</td>
								<td>20</td>
								<td>+40</td>
								<td>60</td>
								<td>+60</td>
								<td>120</td>
								<td>+100</td>
								<td>220</td>
								<td>+150</td>
							</tr>
							<tr class="info">
								<td>5級</td>
								<td></td>
								<td>4級</td>
								<td></td>
								<td>3級</td>
								<td></td>
								<td>2級</td>
								<td></td>
								<td>1級</td>
								<td></td>
								<td>初段</td>
							</tr>
							<tr>
								<td>370</td>
								<td>+500</td>
								<td>870</td>
								<td>+1200</td>
								<td>2070</td>
								<td>+4000</td>
								<td>6070</td>
								<td>+8000</td>
								<td>14070</td>
								<td>+15000</td>
								<td>29070</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<ul>
						<li style="font-size:16px;">・初段以降は固定で20000ポイント貯まる毎に段が上がります。段の上限はありません。</li>
						<li style="font-size:16px;">・読Q本ポイントは、変更することがあります。その結果、獲得ポイントも変わるため一時的に級が上下する場合がありますが、合格履歴は変わりません。</li>
					</ul>
				</div>
			</div>


			<h3 class="page-title">四半期の読書目標</h3>

			<div class="row">
				<div class="col-md-12">
					<p style="font-size:16px;">
						小学生の間は、3か月間に下記の読Qポイントを取得することを目標にして、どんどん本を読みましょう！
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered table-hover">
						<tbody class="text-md-center">
							<tr class="info">
								<td class="col-md-2; width: 16%">小1</td>
								<td class="col-md-2; width: 16%">小2</td>
								<td class="col-md-2; width: 16%">小3</td>
								<td class="col-md-2; width: 16%">小4</td>
								<td class="col-md-2; width: 16%">小5</td>
								<td class="col-md-2; width: 16%">小6</td>
							</tr>
							<tr>
								<td style="color:#3FBF1F; width: 16%">7</td>  <!-- <br>いやいやえん1.2を月２冊換算 -->
								<td style="color:#3FBF1F; width: 16%">13</td>  <!-- <br>ｽﾌﾟｰﾝおばさん3.0を月1.5冊換算 -->
								<td style="color:#3FBF1F; width: 16%">20</td>  <!-- <br>ホッツェンプロッツ3.3を月2冊換算 -->
								<td style="color:#3FBF1F; width: 16%">35</td>  <!-- <br>ルドルフとイッパイアッテナ7.9を月1.5冊換算 -->
								<td style="color:#3FBF1F; width: 16%">50</td>  <!-- <br>ライオンと魔女8.7を月2冊換算 -->
								<td style="color:#3FBF1F; width: 16%">70</td>  <!-- <br>坊ちゃん15.8を月1.5冊換算 -->
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<h3 class="text-md-center">背表紙シールについて</h3>

			<div class="row">
				<div class="col-md-12">
					<p style="font-size:16px;">
						読Qでは、読Q本ポイントに合わせて色分けした背表紙シールを推奨しています。書棚に入っている本が、一目で何ポイントの本なのかが分かります。
					</p>
					<p style="font-size:16px;">
						２まで・・・<span style="color:#ffb5fc">ピンク</span>、　５まで・・・<span style="color:#facaca">赤</span>、８まで・・・<span style="color:#f9d195">オレンジ</span>、11まで・・・<span style="color:#f6f99a">黄</span>、１５まで・・・<span style="color:#e1f98f">黄緑</span>、　１９まで・・・<span style="color:#92fab2">緑</span>、　25まで・・・<span style="color:#a7d4fb">青</span>、　　25.1以上・・・<span style="color:purple">紫</span>
					</p>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    
@stop