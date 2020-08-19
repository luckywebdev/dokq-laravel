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
                        > お問合せ対応
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-head">
				<div class="page-title">
					<h3>お問合せ対応</h3>
				</div>
			</div>
            <div class="row">
            
                <div class="col-md-12">
                <form class="form-horizontal form" id="form" role="form" action="">
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr class="blue">
                                    <th>
                                       閲覧
                                    </th>
                                    <th>受付日</th>
                                    <th>発信者名</th>
                                    <th>会員種類非会員</th>
                                    <th>メールアドレス</th>
                                    <th>問い合わせ文 冒頭</th>
                                    <th>返信全文</th>
                                    <th>返信日</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            @foreach($inquiris as $key=>$inquiry)
                                <tr class="info">
                                    <td>
                                        <input type="checkbox" name="chbItem" id="{{$inquiry->id}}" class="checkboxes"  value="{{$inquiry->id}}">
                                    </td>
                                    <td>{{with((date_create($inquiry->created_at)))->format('Y.m.d')}}</td>
                                    <td>@if($inquiry->role == (config('consts')['USER']['ROLE']['GROUP'] || config('consts')['USER']['ROLE']['GENERAL'] ||
                                                            config('consts')['USER']['ROLE']['OVERSEER'] || config('consts')['USER']['ROLE']['AUTHOR'] ||
                                                            config('consts')['USER']['ROLE']['TEACHER'] || config('consts')['USER']['ROLE']['LIBRARIAN'] ||
                                                            config('consts')['USER']['ROLE']['REPRESEN'] || config('consts')['USER']['ROLE']['ITMANAGER'] ||
                                                            config('consts')['USER']['ROLE']['OTHER'] || config('consts')['USER']['ROLE']['PUPIL'] ||
                                                            config('consts')['USER']['ROLE']['ADMIN']))
                                                    <a href="{{url('mypage/other_view/' . $inquiry->from_id)}}" class="font-blue">{{$inquiry->name}}</a>
                                        @else {{$inquiry->name}} @endif</td>
                                    <td>
                                    @if($inquiry->from_id != 0)
                                        @if($inquiry->role == config('consts')['USER']['ROLE']['GROUP']) {{config('consts')['USER']['TYPE'][0]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['GENERAL']) {{config('consts')['USER']['TYPE'][1]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['OVERSEER']) {{config('consts')['USER']['TYPE'][2]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['AUTHOR']) {{config('consts')['USER']['TYPE'][3]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['TEACHER']) {{config('consts')['USER']['TYPE'][4]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['LIBRARIAN']) {{config('consts')['USER']['TYPE'][5]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['REPRESEN']) {{config('consts')['USER']['TYPE'][6]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['ITMANAGER']) {{config('consts')['USER']['TYPE'][7]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['OTHER']) {{config('consts')['USER']['TYPE'][8]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['PUPIL']) {{config('consts')['USER']['TYPE'][9]}}
                                        @elseif($inquiry->role == config('consts')['USER']['ROLE']['ADMIN']) 管理者
                                        @endif
                                    @else 非会員@endif</td>
                                    <td><a href="mailto:{{$inquiry->email}}">{{$inquiry->email}}</a></td>
                                    <td>{{$inquiry->content}}</td>
                                    <td>{{$inquiry->post}}</td>
                                    <td>{{with((date_create($inquiry->updated_at)))->format('Y.m.d')}}</td>
                                </tr>
                            @endforeach   
                            </tbody>    
                        </table>
                    </div>
                </div>
            </form>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <a href="../" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
 <!-- data table -->
    <script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/data-table.js')}}"></script>
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
    <!-- data table -->
    <script type="text/javascript">
        $(document).ready(function(){
            ComponentsDropdowns.init();
            
            $(".checkboxes").change(function(){
               // alert($(".checkboxes").val());
                var checkboxes = $('input:checked');
                for(i =0;i<checkboxes.length;i++){
                    
                   // $('#selected').val($(checkboxes[i]).val());                          
                    $("#form").attr("method", "get")
                    $("#form").attr("action",'{{url("/admin/quiz_answer_card")}}');
                    $("#form").submit();
                    
                }
            });
        });
        TableManaged.init();
     </script>
@stop