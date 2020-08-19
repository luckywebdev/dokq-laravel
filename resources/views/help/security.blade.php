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
                	<a href="#"> > 個人情報保護方針</a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12" style="margin-bottom:1%">
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">個人情報保護方針</span>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12" style="font-size:16px;">
					一般社団法人読書認定協会（以下「当協会」という）は、多くの個人情報を取り扱う法人として、個人情報の保護が事業活動の基本であるとともに、その適切な管理を行うことが社会的責務と考えております。
					当協会では、職員全員がこのような共通認識を持ち、下記に定める個人情報保護方針に沿った事業運営に取り組みます。
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center" style="font-size:16px;">
					<h3>記</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<ul>
						<li style="font-size:16px;">１．個人情報をご提供いただく場合には、その利用目的を明らかにするとともに個人情報の利用についてご本人の同意を得ます。</li>
						<li style="font-size:16px;">２．法令で定められた場合を除き、ご本人の同意なく利用目的の達成に必要な範囲を超えた個人情報の取り扱いは行いません。また目的外利用を禁止し、そのために必要な措置を講じます。また、目的外利用を行う必要が生じた場合は、法令で定められた場合を除き、ご本人にその目的をご連絡し、同意を得たうえで行います。</li>
						<li style="font-size:16px;">３．ご本人から提供いただいた個人情報は次の場合を除き第三者に開示または提供しません。
							<ul>
								<li style="font-size:16px;">① ご本人の同意がある場合</li>
								<li style="font-size:16px;">② 個人情報についての機密保持契約を締結している業務委託会社へ、ご本人にお知らせした目的の達成に必要な範囲で個人情報の取り扱いを委託する場合</li>
								<li style="font-size:16px;">③ 統計的なデータとして、匿名加工情報（特定の個人を識別できないように個人情報を加工して得られる個人に関する情報）にした場合</li>
								<li style="font-size:16px;">④ 法的な命令等により、個人情報の開示等を求められた場合</li>
							</ul>
						</li>
						<li style="font-size:16px;">４．取得した個人情報について、ご本人から当該個人情報の開示、訂正、削除、利用停止等の要請および苦情や相談があった場合には、合理的な範囲で速やかに対応いたします。</li>
						<li style="font-size:16px;">５．個人情報を厳格に管理するとともに、不正アクセスの防止、個人情報の紛失、破壊、改ざんおよび漏洩に対し、適切なセキュリティ対策を講じます。</li>
						<li style="font-size:16px;">６．個人情報保護に関する法令を遵守し、また個人情報保護に関する協会内規程を定め、継続的な見直しを行い遵守します。</li>
						<li class="col-md-12 text-md-right"></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
                <a class="btn btn-info pull-right" href="javascript:history.go(-1)">戻　る</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    
@stop