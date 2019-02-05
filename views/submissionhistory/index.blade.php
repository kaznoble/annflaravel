<style>
    .DisplayArea{
        border: 1px solid lightgray;
        height: 650px;
        overflow: auto;
        padding: 10px 10px 10px 10px;
    }
    #HistoryTable tr td, #HistoryTable tr th{
        padding: 15px;
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
        {{ Form::open(array('url'=>'SubmissionHistory', 'method' => 'get', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="Select Submission" class=" control-label col-lg-4 text-left">Select Submission</label>
                        <div class="col-lg-8">
                            <select name="SubmissionID" class="form-control">
                                <option value="">Select Submission</option>
                                @foreach($ReportNames as $K => $Names)
                                    <option value="{{ $Names->ReportID }}" @if( $Names->ReportID == Request::get('SubmissionID')) selected="selected" @endif >{{ $Names->SubmissionReportName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="Submission Start Date" class=" control-label col-lg-4 text-left ">Submission Start Date</label>
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
                        <label for="Submission End Date" class=" control-label col-lg-4 text-left">Submission End Date</label>
                        <div class="col-lg-8">
                            @if(!is_null(Request::get('submission_end_date')))
                                {{ Form::text('submission_end_date', Request::get('submission_end_date'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @else
                                {{ Form::text('submission_end_date', date('d/m/Y'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    <input type="submit" class="btn btn-sm btn-success do-quick-search" value="Get History">
                </div>
            </div>
        </div>
        {{ Form::close() }}
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
                {{--*/ $i= $pagination->getFrom(); /*--}}
                @foreach ($rowData as $row)
                    <tr>
                        <td>{{$i}}</td>
                        @foreach ($TableFields as $key => $value)
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
                        {{--*/  $i++; /*--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            {{--*/ $total = ceil($pagination->getTotal() / $recordsperpage) /*--}}
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
                                <input type="hidden" name="SubmissionID" value="{{ Request::get('SubmissionID') }}">
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

    <script>
        $(document).ready(function()
        {
            $('input[name="submission_start_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
            $('input[name="submission_end_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
        });
    </script>