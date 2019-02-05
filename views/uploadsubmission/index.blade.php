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
        {{ Form::open(array('url'=>'UploadSubmission', 'method' => 'get', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Submission Start Date" class=" control-label col-lg-4 text-left ">Select Submission</label>
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
                <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
                    <input type="submit" class="btn btn-sm btn-success do-quick-search" value="Submit">
                </div>
                {{ Form::close() }}

                @if(!empty($rowData))
                {{ Form::open(array('url'=>'GenerateXML', 'method' => 'get', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
                <div class="col-lg-2 col-md-5 col-sm-6 col-xs-12">
                    <input type="hidden" name="SubmissionID" value="{{ Request::get('SubmissionID') }}">
                    {{--<input type="submit" class="btn btn-sm btn-default do-quick-search" value="Show which period is still to be uploaded">--}}
                    <input type="submit" class="btn btn-sm btn-default do-quick-search pull-right" value="Download XML">
                </div>
                {{ Form::close() }}
                {{--<div class="col-lg-1"></div>--}}
                {{--<div class="col-lg-2 col-md-5 col-sm-6 col-xs-12">--}}
                    {{--<input type="button" class="btn btn-sm btn-default do-quick-search pull-left" value="Show number of records pending upload">--}}
                {{--</div>--}}
                 @endif
            </div>
        </div>
    </section>
    <br><br><br><br>
    <div class="DisplayArea">
        @if(!is_null(Request::get('SubmissionID')))
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
                                @if(!is_null(Request::get('SubmissionID')))
                                    <input type="hidden" name="SubmissionID" value="{{ Request::get('SubmissionID') }}">
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
                            <p class="text-left" style="line-height:30px;display:block;">
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