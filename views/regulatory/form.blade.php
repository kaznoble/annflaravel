<style>
    .DisplayArea{
        border: 1px solid lightgray;
        height: 800px;
        overflow: auto;
        padding: 10px 10px 10px 10px;
    }
    #MyTable tr th{
        border-bottom: 1px solid lightgray !important;
    }
    #MyTable {
        border: 1px solid lightgray;
    }
</style>
<div class="page-content">
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
    </div>
    <br><br>
    <section>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="Submission Start Date" class=" control-label col-lg-4 text-left "> Submission Start Date </label>
                            <div class="col-lg-8">
                                {{ Form::text('submission_start_date', date('d/m/Y'),array('class'=>'form-control datepicker', 'placeholder'=>'' )) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group" >
                            <label for="Submission End Date" class=" control-label col-lg-4 text-left"> Submission End Date </label>
                            <div class="col-lg-8">
                                {{ Form::text('submission_end_date', date('d/m/Y'),array('class'=>'form-control', 'placeholder'=>'' )) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-sm btn-success SearchBtn">Run Report</button></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-sm btn-primary SaveReport" style="display: none;">Save Report</button></div>
                    </div>
                </div>
            </div>
    </section>

    <br><br><br><br>
    <div class="DisplayArea">
        <div class="table-responsive TableDiv">
        {{-- Used to merge search data and display search result--}}
        </div>
    </div>
    <div class="loader" style="top:50%;left: 45%;z-index: 1000;position: absolute;display: none;"><img src="{{ URL::to('')}}/sximo/images/ajax-loader.gif"> </div>
    <script>
    $('.SearchBtn').click(function()
    {
        $('.loader').show();
        var StartDate = $('input[name="submission_start_date"]').val();
        var EndDate = $('input[name="submission_end_date"]').val();
            $.ajax({
                url: "DisplayGrid",
                type:"POST",
                data:{"Action":"ViewReport", "StartDate":StartDate, "EndDate":EndDate, "_token": "{{csrf_token()}}"},
                success: function(result){
                    var obj = JSON.parse(result);
                    $('.TableDiv').html(obj.html);
                    if(obj.count > 0)
                    {
                        $('#MyTable').dataTable();
                        $('.SaveReport').show();
                    }else{
                        $('.SaveReport').hide();
                    }
                    $('.loader').hide();
            }});
    });

    $('.SaveReport').click(function()
    {
        $('.loader').show();
        var StartDate = $('input[name="submission_start_date"]').val();
        var EndDate = $('input[name="submission_end_date"]').val();
        $.ajax({
            url: "DisplayGrid",
            type:"POST",
            data:{"Action":"SaveReport", "StartDate":StartDate, "EndDate":EndDate, "_token": "{{csrf_token()}}"},
            success: function(result){
                $('.loader').hide();
                window.location = result;
            }});
    });

    $(document).ready(function()
    {
        $('input[name="submission_start_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
        $('input[name="submission_end_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
    });
    </script>