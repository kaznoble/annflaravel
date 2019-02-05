
<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('add_delete_round') }}">{{ $pageTitle }}</a></li>
            <li class="active">{{ Lang::get('core.add_round') }} </li>
        </ul>
        <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
        <ul class="breadcrumb-buttons collapse">
            <li><a href="{{ URL::to('add_delete_round') }}" class="tips"  title="{{ Lang::get('core.btn_view') }}">
                    <i class="icon-list"></i>&nbsp;</a></li>
        </ul>
    </div>
    @if(Session::has('message'))
        {{ Session::get('message') }}
    @endif
    <div class="panel-default panel">
        <div class="panel-body">

            <ul class="parsley-error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            {{ Form::open(array('url'=>'add_delete_round/save/', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
            <div class="col-md-12">
                <fieldset><legend> Add Round</legend>
                    <p class="daysDiv" style="display: none;"> {{ Lang::get('core.available_days') }}:&nbsp;&nbsp;<span id="WorkingDays" style="color: green;"></span></p>

                    <div class="form-group">
                        <label for="Reg Date" class=" control-label col-md-4 text-left"> Round Number </label>
                        <div class="col-md-8">
                            <input type="text" name="round_number" class="form-control" value="{{ Input::old('round_number'); }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Reg Date" class=" control-label col-md-4 text-left"> Round Name </label>
                        <div class="col-md-8">
                            <input type="text" name="round_name" class="form-control" value="{{ Input::old('round_name'); }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Tran Ref" class=" control-label col-md-4 text-left"> Collector Name </label>
                        <div class="col-md-8">
                            <select name="staff_number" class="form-control" id="staff_number" onclick="find_days()">
                                <option value="0">Select Collector</option>
                                @foreach($staff as $staff)
                                    <option value="{{ $staff->staff_id }}" @if(Input::old('staff_number') == $staff->staff_id) selected @endif>{{ $staff->first_name.' '.$staff->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>


            <div style="clear:both"></div>

            <div class="form-group">
                <label class="col-sm-4 text-right">&nbsp;</label>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
                    <button type="button" onclick="location.href='{{ URL::to('add_delete_round/') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
                </div>

            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>
<script type="text/javascript">
    function find_days()
    {
        var staff_no = $('#staff_number').val();
        if(staff_no != '0')
        {
            $.ajax({
                url: "/GetWorkingDays",
                type:"POST",
                data:{"staff_number":staff_no, "_token": "{{csrf_token()}}"},
                success: function(result){
                    var obj = JSON.parse(result);
					if(obj.html !== '')
					{
						$('.btn').show();
						$('.daysDiv').css('display','block');
						$('#WorkingDays').html(obj.html);
					}
                },
				error: function(result) {
					$('.btn').hide();
					$('.daysDiv').css('display','block');
					$('#WorkingDays').html('THIS COLLECTOR HAVEN`T SELECT THE DAYS');						
				}
            });
        }else{
            $('#WorkingDays').html('');
        }
    }
</script>