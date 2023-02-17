
@extends('layout')
@section('styles')
    
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
                        > 画面アクセス数、検索履歴
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">ページビュー時間データ</h3>
			<div class="panel panel-primary">
				<div class="panel-heading">
					クイズ文について
				</div>
				<div class="panel-body">
					

					<form class="form-horizontal" action="" method="post" id="data_result">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-md-3">大項</label>
							<div class="col-md-4">
								<select class="form-control input-large select2me" name="history_item" id="history_item" data-placeholder="選択...">
									<option value=""></option>
									@foreach($history_item as $item_key => $item)
										@if($item_key == 'home_top' || $item_key == 'book_page' || $item_key == 'my_page' || $item_key == 'otherviewer' || $item_key == 'admin_page')
											<?php $disabled = 'disabled'; ?>
										@else
											<?php $disabled = ''; ?>
										@endif
										<option value="{{$item_key}}" {{$disabled}} @if($item_key == $selected_item) selected @endif>{{ $item }}</option>
									@endforeach
								</select>
							</div>
						</div>            
						<div class="form-group">
							<label class="control-label col-md-3">期間選択</label>
							<div class="col-md-4">
								<select class="form-control input-large select2me" name="period_sel" id="period_sel" data-placeholder="選択..." onchange="preiod_chk()">
									<option value="0"></option>
									<option value="1">直近12時間</option>
									<option value="2">昨日 午前（0:00~11:59）</option>
									<option value="3">昨日 午後（12:00~23:59）</option>
									<option value="4">昨日までの3日間(72時間)</option>
									<option value="5">昨日までの7日間</option>
									<option value="6">昨日までの1か月</option>
									<option value="7">昨日までの3か月</option>
									<option value="8">昨日までの6か月</option>
									<option value="9">昨日までの全期間</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">期間範囲(日にち入力)</label>
							<div class="col-md-2">
							<input type="text"  name="start_date" value="" id="start_date" class="form-control date-picker" >
							</div>
							<div class="col-md-2">
							<input type="text"  name="finished_date" value="" id="finished_date" class="form-control date-picker" >
							</div>
						</div>
					</form> 
					<div class="row">
						<div class="offset-md-3 col-md-5 text-md-center">
						<span class="form-control-feedback">
							@if ($errors->has('nouser'))
							<span class="offset-md-3 col-md-5 text-md-center" style="color:#ff005e;font-size:16px">
							{{ $errors->first('nouser') }}
							</span>    
							@endif
						</span>                                                            
						</div>
					</div>
					<div class="row">
						<div class="offset-md-5  col-md-6">
							<button id="next_btn" class="btn btn-primary">表　示</button>    
							<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript">
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
		var handleDatePickers = function () {

			if (jQuery().datepicker) {
				$('.date-picker').datepicker({
					rtl: Metronic.isRTL(),
					orientation: "left",
					autoclose: true,
					language: 'ja'
				});
			}
		}
		handleDatePickers();
		function preiod_chk(){
			if($("select[name=period_sel]").val() == null || $("select[name=period_sel]").val() == ''){
				$("#start_date").attr("disabled", false);
				$("#finished_date").attr("disabled", false);
			}
			else{
				$("#start_date").prop("disabled", true);
				$("#finished_date").attr("disabled", true);
			}
		}
		$("#next_btn").click(function(){
            if($("select[name=history_item]").val() == null || $("select[name=history_item]").val() == ''){
                 $("#alert_text").html("{{config('consts')['MESSAGES']['DATATYPE_REQUIRED']}}");
                 $("#alertModal").modal();
                 return;
            }

            if($("select[name=history_item]").val() == 'home_top'){
                $("#data_result").attr('action', '/admin/exportHometop');
                $("#data_result").submit();
                return;
            }else if($("select[name=history_item]").val() == 'search_book'){
                $("#data_result").attr('action', '/admin/exportSearchbook');
                $("#data_result").submit();
                return;
            }else if($("select[name=history_item]").val() == 'quize_make'){
                $("#data_result").attr('action', '{{url("/admin/exportQuizemake")}}');
                $("#data_result").submit();
                return;
            }else if($("select[name=history_item]").val() == 'book_page'){
                $("#data_result").attr('action', '/admin/exportBookpage');
                $("#data_result").submit();
                return;
            }else if($("select[name=history_item]").val() == 'my_page'){
                $("#data_result").attr('action', '/admin/exportMypage');
                $("#data_result").submit();
                return;
            }else if($("select[name=history_item]").val() == 'overseer'){
                $("#data_result").attr('action', '/admin/exportOverseer');
                $("#data_result").submit();
                return;
			}else if($("select[name=history_item]").val() == 'help_page'){
				$("#data_result").attr('action', '/admin/exportHelppage');
				$("#data_result").submit();
				return;
			}else if($("select[name=history_item]").val() == 'otherviewer'){
				$("#data_result").attr('action', '/admin/exportOtherviewer');
				$("#data_result").submit();
				return;
			}else if($("select[name=history_item]").val() == 'admin_page'){
                $("#data_result").attr('action', '/admin/exportAdminpage');
                $("#data_result").submit();
                return;
            }
        });

	</script>
	
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop