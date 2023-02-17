@extends('layout')

@section('styles')
    <style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
		}
	</style>
@stop
@section('breadcrumb')
    <div class="breadcum">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{url('/')}}">
                            読Qトップ
                        </a>
                    </li>
                    <li class="hidden-xs">
                        >   <a href="{{url('/top')}}">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 監修者募集本リストと応募
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者募集本リスト</h3>

			@include('partials.mypage.overseer_demand')
			
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
@stop
@section('scripts')
	<script type="text/javascript">
	        jQuery(document).ready(function() {       
	        	$(".proposal").click(function(){
	        		var txt1 = "<h5>「" + $(this).siblings(".didor").text() + "」</h5>";
	        		var txt2 = "<p>" + $(this).siblings(".xin").text() + " の監修者に応募します。</p>"
	        		$("#reply").html(txt1+txt2);
					$("#book_id").val($(this).attr("bid"));
	        	});

	        	$("#btn_submit").click(function(){
					var bookId = $("#book_id").val();
					var reason = $("#reason").val();

					if(bookId == "" || bookId == 0){
						$("#alert_text").html("{{config('consts')['MESSAGES']['BOOK_REQUIRED']}}");
                		$("#alertModal").modal();
					}else if(reason == ""){
						$("#alert_text").html("{{config('consts')['MESSAGES']['REASON_REQUIRED']}}");
               			$("#alertModal").modal();
					}else{
						$("#book_form").submit();
					}
	        	});
	        });  	
	</script>
@stop