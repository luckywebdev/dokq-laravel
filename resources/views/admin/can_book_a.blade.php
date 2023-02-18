@extends('layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}">
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
                        > 候補本リスト（未審査）
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">候補本の認定審査</h3>

			<div class="row">
				<div class="col-md-12">
                    <div class="caption caption-md">
                        <span class="caption-subject bold">
                        登録者　： <span>@if(isset($book->Register) && $book->Register !== null && $book->register_id != 0) {{$book->register_visi_type == 0? $book->Register->fullname(): $book->Register->username}} @endif</span>
                        </span>
                    </div>
                    <form action="{{url('/admin/do_can_book_a')}}" method="post" id="book-register-form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" id="img" name="img" value="{{ $book->cover_img }}"/>
                    <div class="form">
                        @include('books.book.form')
                        <div class="row  col-md-12">
                            <div class="offset-md-1 col-md-3">
                                <label class="radio"><input type="radio" name="answer" id="answer1" value="1" @if($book->active >= 3 && ($book->recommend_flag == '0000-00-00' || $book->recommend_flag == null)) checked @endif>&nbsp;&nbsp;この本を認定する。</label>
                            </div>
                        </div>
                        <div class="row  col-md-12">
                            <div class="offset-md-1 col-md-12">
                                <label class="radio"><input type="radio" name="answer" id="answer3" value="3" @if($book->active >= 3 && $book->recommend_flag != '0000-00-00' && $book->recommend_flag !== null) checked @endif>&nbsp;&nbsp;この本を読Q本に認定し、さらに読Q推薦図書に認定する。</label>
                            </div>
                        </div>
                        <div class="row  col-md-12">
                            <div class="offset-md-1 col-md-3">
                                <label class="radio "><input type="radio" name="answer" id="answer2" value="0" @if($book->active < 3) checked @endif>&nbsp;&nbsp;この本は認定しない。</label>
                            </div>
                            <div class="col-md-1">
                                <label class="offset-md-1">理由 :</label>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <select class="bs-select form-control"  data-placeholder="選択..." id="reason1" name="reason1" enabled="false" >
                                        @foreach(config('consts')['BOOK']['REASON'] as $key=>$reason1)
                                            <option value="{{$key+1}}" @if(old('reason1')!='') 
                                                                            @if(old('reason1') == $key+1) selected @endif
                                                                        @else
                                                                             @if(isset($book) && $book->reason1 == $key+1) selected @endif
                                                                        @endif>{{$reason1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">&nbsp;
                                </div>
                                <div class="row @if(session('noreason')) has-danger @endif">
                                    <input type="text"  class="form-control" name="reason2" id="reason2" value="{{($book->reason2 && $book->active == 2 )? $book->reason2: ''}}">
                                     @if (session('noreason'))
                                    <span class="form-control-feedback">
                                        <span>{{config('consts')['MESSAGES']['REASON_REQUIRED']}}</span>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row  col-md-12">
                            <div class="offset-md-8 col-md-2">
                                <button type="button" class="btn btn-primary pull-right save-close">送　信</button>
                            </div>
                            <div class=" col-md-2">
                                <a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                    
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="certWaningModal" role="dialog">
	    <div class="modal-dialog modal-md">
	      <div class="modal-content">
            <div class="modal-header">
	          <h4 class="modal-title"></h4>
	        </div>
	        <div class="modal-body">
	          <p>却下すると、もとに戻せません。</p>
              <p>本当に却下しますか？</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-ok" >はい却下します</button>
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >いいえ、却下しません</button>
	        </div>
	      </div>
	    </div>
	</div>


@stop
@section('scripts')
    <script type="text/javascript" src="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
	   $(document).ready(function(){
//			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
            //$('.fileinput-filename').text($("#img").val());
            $("#phone").inputmask("mask", {
                "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
            });
			$("#cancel").click(function(){
				$(".form-control").each(function(index, item){
					$(item).val("");
				})
			});
            $("#answer1").click(function(){
                if($(this).val() == 1) {
                    $("#reason1").attr("disabled", true);
                    $("#reason2").attr("disabled", true);
                }
            });
            $("#answer3").click(function(){
                if($(this).val() == 3) {
                    $("#reason1").attr("disabled", true);
                    $("#reason2").attr("disabled", true);
                }
            });
            $("#answer2").click(function(){
                if($(this).val() == 0) {
                    $("#reason1").attr("disabled", false);
                    $("#reason2").attr("disabled", false);
                }
            });
			$("select[name=type]").change(function(){
				if ($(this).val() == "1"){
					$(".param").each(function(index, item){
							$(item).val("");
					})
                    $("input[name=pages]").val("");
					$("input[name=total_chars]").val("");
					$("input[name=point]").val("");
				}
				else if (($(this).val() == "0")){
					$(".param").each(function(index, item){
						$(item).val("0");
					})
                    $("input[name=pages]").val("");
					$("input[name=total_chars]").val("");
					$("input[name=point]").val("");
				}
			});

            var handleSpinners = function () {
        
            $('.spinner-input').parent().parent().spinner({value:0, min: 0});
            
            }

		    $(".save-close").click(function(){
                var uncertCheck = $("#answer2").attr('checked');
                if (uncertCheck) {
                    $("#certWaningModal").modal('show');
                } else {
		    	    $("#book-register-form").submit();
                }
		    });

            $(".modal-ok").click(function() {
		    	$("#book-register-form").submit();
            })

            $('#input_3').keyup(function(){
                bookout();
                
            }); 
            
            $('#input_1').keyup(function(){
                bookout();
            }); 

            var bookout = function () {
                var writer = $('#input_3').val();
                var title = $('#input_1').val();
                if(title != '' && writer != ''){
                    var info = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        writer: writer,
                        title: title
                    };
                    var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/book/search/bookoutAjax";
                    $.ajax({
                        type: "post",
                        url: post_url,
                        data: info,

                        beforeSend: function (xhr) {
                            var token = $('meta[name="csrf-token"]').attr('content');
                            if (token) {
                                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                            }
                        },
                        success: function (response) {

                            if(response.hasbookout){
                                $("#Errorbookout").show();
                            }
                            else
                                $("#Errorbookout").hide();  
                        }
                    }); 
                }
            }
		});
	    var recommend = 0;
	    setInterval(function(){
	    	var temp = $("select[name=recommend]").val()
	    	var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];
	    	if( temp != ""){
				recommend = pointarray[temp]
			}
	    },500);
	</script>
    <script type="text/javascript" src="{{asset('js/book/book.js')}}"></script>
@stop