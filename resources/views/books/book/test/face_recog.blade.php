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
	            <li class="breadcrumb-item">
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="breadcrumb-item">
					> <a href="{{url('book/test/caution')}}">受検の注意</a>
				</li>
				<li class="breadcrumb-item">
					> 顔認証
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">顔認証</h3>
			<div class="camera-widget camera-placeholder" align="center">
			    <video style="width:80%; height:80%;" autoplay="autoplay"></video>
            </div>				
			<div class="row">
				<div class="offset-md-1 col-md-10">
					
				</div>
			</div>
		</div>
	</div>
<!-- Modal -->
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
            <button type="button" data-dismiss="modal" class="btn btn-info" > 戻る </button>
        </div>
    </div>

  </div>
</div>
@stop
@section('scripts')
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
			if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	          // access the web cam
	          navigator.mediaDevices.getUserMedia({ video: true })
	          // permission granted:
	            .then(function (stream) {
	                //video.src = window.URL.createObjectURL(stream);
					try {
					  video.srcObject = stream;
					} catch (error) {
					  video.src = window.URL.createObjectURL(stream);
					}
	                
	              $(".camera-widget").removeClass('camera-placeholder');
	              $("#btn_verify").removeClass('disabled');
	            })
	            // permission denied:
	            .catch(function (error) {
	                //alert('Could not access the camera. Error: ' + error.name);
	                $("#alert_text").html('カメラにアクセスできません。');
	        		$("#alertModal").modal();
	            });
	      } else {
	          //alert('お使いのブラウザのバージョンではHTML5がサポートされていないため、正しく動作しません。ブラウザのバージョンをアップグレードしてから再度お試しください。');
	          $("#alert_text").html('お使いのブラウザのバージョンではHTML5がサポートされていないため、正しく動作しません。ブラウザのバージョンをアップグレードしてから再度お試しください。');
	          $("#alertModal").modal();
	      }
	
			var video = document.querySelector('video'), canvas;
	   });
    </script>
@stop