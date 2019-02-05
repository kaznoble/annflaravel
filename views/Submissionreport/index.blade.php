<style>
    .DisplayArea{
        border: 1px solid lightgray;
        height: 800px;
        overflow: auto;
        padding: 10px 10px 10px 10px;
    }
    #HistoryTable tr th{
        border-bottom: 1px solid lightgray !important;
    }
    #HistoryTable {
        border: 1px solid lightgray;
    }
</style>
<div class="page-content">
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small>
            <a href="regulatory_home" class="btn btn-xs btn-danger pull-right" title="Back To regulatory Home Page">Home</a>
            </h3>
        </div>
    </div>
    <br><br>
    <section>
        {{ Form::open(array('url'=>'RunSubmission', 'method' => 'get', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="Submission Start Date" class=" control-label col-lg-4 text-left "> Submission Start Date </label>
                        <div class="col-lg-8">
                            @if(!is_null(Request::get('submission_start_date')))
                                {{ Form::text('submission_start_date', Request::get('submission_start_date'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @else
                                {{ Form::text('submission_start_date', date('d/m/Y'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="Submission End Date" class=" control-label col-lg-4 text-left"> Submission End Date </label>
                        <div class="col-lg-8">
                            @if(!is_null(Request::get('submission_end_date')))
                                {{ Form::text('submission_end_date', Request::get('submission_end_date'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @else
                                {{ Form::text('submission_end_date', date('d/m/Y'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><input type="submit" class="btn btn-sm btn-success do-quick-search" value="Run report"></div>
                    @if(!empty($rowData))
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button type="button" class="btn btn-sm btn-primary SaveReport">Save Report</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{ Form::close() }}
        @if(!empty($rowData))
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="Submission Report Name" class=" control-label col-lg-4 text-left "> Submission Report Name </label>
                        <div class="col-lg-8">
                                {{ Form::text('submission_report_name', '',array('class'=>'form-control', 'placeholder'=>'' )) }}
                            <br>
                            <span class="SpanError" style="color:red"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7"></div>
            </div>
        </div>
        @endif
    </section>
    <br><br><br><br>
    <div class="DisplayArea">
        @if(!is_null(Request::get('submission_start_date')) && !is_null(Request::get('submission_end_date')))
            <div class="table-responsive">
                <table id="HistoryTable" class="table table-striped ">
                    <thead>
                    <tr>
                        <th><b>No</b></th>
                        @foreach($TableFields as $key=>$value)
                            <th><b>{{ $value }}</b></th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    {{--*/ $i= $pagination->getFrom() /*--}}
                    @if(!empty($rowData))
                    @foreach ($rowData as $row)
                        <tr>
                            <td>{{$i}}</td>
                            @foreach($TableFields as $key=>$value)
                                @if($key == 'loan_amount' || $key == 'arrangement_fee' || $key == 'total_amount_payable' || $key == 'monthly_income' || $key == 'order_rollover')
                                    <td>{{ round($row->$key) }}</td>
                                @elseif($key == 'apr')
                                    <td>{{ number_format($row->$key,2) }}</td>
                                @elseif($key == 'rollover')
                                    <td>N</td>
                                @else
                                    <td>{{ $row->$key }}</td>
                                @endif
                            @endforeach
                        </tr>
                        {{--*/  $i++; /*--}}
                    @endforeach
                        @else
                        <tr><td colspan="22"><center><h3>No Record Found</h3></center></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{--*/  $total = ceil($pagination->getTotal() / $recordsperpage) /*--}}
            @if(Request::get('page') > $total )
                {{--*/ $flag = 1 /*--}}
            @else
                {{--*/ $flag = 0 /*--}}
            @endif
            @if($flag == 0)
                <div class="table-footer">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="table-actions">
                                {{ Form::open(array('url'=>$pageModule,'method' => 'get')) }}
                                {{--*/ $pages = array(5,10,20,30,50) /*--}}
                                {{--*/ $orders = array('asc','desc') /*--}}
                                @if(!is_null(Request::get('submission_start_date')) && !is_null(Request::get('submission_end_date')))
                                    <input type="hidden" name="submission_start_date" value="{{ Request::get('submission_start_date') }}">
                                    <input type="hidden" name="submission_end_date" value="{{ Request::get('submission_end_date') }}">
                                @endif
                                <select name="rows" data-placeholder="{{ Lang::get('core.grid_show') }}" class="select-liquid"  >
                                    <option value=""></option>
                                    @foreach($pages as $p)
                                        <option value="{{ $p }}"
                                                @if(isset($pager['rows']) && $pager['rows'] == $p)
                                                selected="selected"
                                                @endif
                                                >{{ $p }}</option>
                                    @endforeach
                                </select>
                                <select name="sort" data-placeholder="{{ Lang::get('core.grid_sort') }}" class="select-liquid" style="width:100px;" >
                                    <option value=""></option>
                                    @foreach($TableFields as $key=>$value)
                                        <option value="{{ $key }}"
                                                @if(isset($pager['sort']) && $pager['sort'] == $key)
                                                selected="selected"
                                                @endif
                                                >{{ $value }}</option>
                                    @endforeach
                                </select>
                                <select name="order" data-placeholder="{{ Lang::get('core.grid_order') }}" class="select-liquid">
                                    <option value=""></option>
                                    @foreach($orders as $o)
                                        <option value="{{ $o }}"
                                                @if(isset($pager['order']) && $pager['order'] == $o)
                                                selected="selected"
                                                @endif
                                                >{{ ucwords($o) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-info">GO</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <p class="text-left" style="line-height:30px;">
                                {{ Lang::get('core.grid_displaying') }} :  <b>{{ $pagination->getFrom() }}</b>
                                {{ Lang::get('core.grid_to') }} <b>{{ $pagination->getTo() }}</b>
                                {{ Lang::get('core.grid_of') }} <b>{{ $pagination->getTotal() }}</b>
                            </p>
                        </div>
                        <div class="col-sm-4">
                            {{ $pagination->appends($pager)->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
    <div class="loader" style="top:50%;left: 45%;z-index: 1000;position: absolute;display: none;"><img src="{{ URL::to('')}}/sximo/images/ajax-loader.gif"> </div>
    <script>
        $(document).ready(function()
        {
            $('input[name="submission_start_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
            $('input[name="submission_end_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
        });

        $('.SaveReport').click(function()
        {
            var StartDate = $('input[name="submission_start_date"]').val();
            var EndDate = $('input[name="submission_end_date"]').val();
            var ReportName = $('input[name="submission_report_name"]').val();
            if(ReportName != '')
            {
                $('.SpanError').html('');
                $('.loader').show();
                $.ajax({
                    url: "DisplayGrid",
                    type:"POST",
                    data:{"StartDate":StartDate, "EndDate":EndDate, "ReportName":ReportName, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        $('.loader').hide();
                        window.location = result;
                    }});
            }else{
                $('.SpanError').html('Please Enter Report Name');
            }
        });
    </script>