<style>
.subject-info-box-1,
.subject-info-box-2 {
    float: left;
    width: 23%;
    
    select {
        height: 200px;
        padding: 0;
        option {
            padding: 4px 10px 4px 10px;
        }
        option:hover {
            background: #EEEEEE;
        }
    }
}
.subject-info-arrows {
    float: left;
    width: 10%;
	padding-top: 20px;
    input {
        width: 70%;
        margin-bottom: 5px;
    }
}

#lstBox1, #lstBox2 {
	width: 320px;
}

#btnRight {
	background-color: #ff7777;
}
#btnLeft {
	background-color: #9ddb9f;
}
</style>

<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small>
                <a href="/adminround" class="btn btn-xs btn-danger pull-right" title="Back To regulatory Home Page">Back</a>
            </h3>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('add_delete_round') }}">{{ $pageTitle }}</a></li>
            <li class="active">{{ Lang::get('core.delete_round') }} </li>
        </ul>
        <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
        <ul class="breadcrumb-buttons collapse">
                <li><a href="{{ URL::to('add_delete_round/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
                        <i class="icon-plus-circle2"></i>&nbsp;
                    </a>
                </li>
        </ul>
    </div>
    <div class="panel-default panel" style="max-height: 500px;overflow: auto;">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <fieldset><legend> Listing of Rounds</legend>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Round Number</th>
                                    <th>Round Name</th>
                                    <th>Collector Name</th>
                                    <th>Days of the week</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Round as $round)
                                <tr>
                                    <td>{{ $round->round_number }}</td>
                                    <td>{{ $round->round_name }}</td>
                                    <td>{{ $round->staff_name }}</td>
                                    <td>{{ $round->days_of_week }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
<br><br>

<div class="panel-default panel" style="max-height: 500px;overflow: auto;">
    <div class="panel-body">
        <fieldset><legend> Change or Delete Round</legend>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Tran Ref" class=" control-label col-md-4 text-left"> Select Round </label>
                        <div class="col-md-8">
                            <select name="round" id="round_no" class="form-control" onchange="Find_round();">
                                <option>Select Round</option>
                                @foreach($Round as $round)
                                <option value="{{ $round->round_number }}">{{ $round->round_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div><br><br><br><br>
            <div class="row htmldiv" style="display: none;">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Round Number</th>
                                <th>Collector Name</th>
                                <th>Round Name</th>
                                <th>Confirm Delete</th>
                                <th>Change Staff</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
</div>

@if($gid == 1 || $gid == 2)
<div class="panel-default panel" style="max-height: 500px;overflow: auto;">
    <div class="panel-body">
	<fieldset><legend> Admin Only</legend>
		<div class="subject-info-box-1">
		<strong>Staff</strong>
		  <select multiple="multiple" id='lstBox1' class="form-control">
			@foreach($roundNoAdmin as $round)
            <option value="{{ $round->round_number }}">{{ $round->round_name }} - {{ $round->staff_name }}</option>
            @endforeach
		  </select>
		</div>
		<div class="subject-info-arrows text-center">
		  <!--<input type="button" id="btnAllRight" value=">>" class="btn btn-default" /><br />-->
		  <input type="button" id="btnRight" value=">>" class="btn btn-default" /><br />
		  <input type="button" id="btnLeft" value="<<" class="btn btn-default" /><br />
		  <!--<input type="button" id="btnAllLeft" value="<<" class="btn btn-default" />-->
		</div>
		<div class="subject-info-box-2">
		<strong>Admin</strong>
		  <select multiple="multiple" id='lstBox2' class="form-control">
			@foreach($roundAdmin as $round)
            <option value="{{ $round->round_number }}">{{ $round->round_name }} - {{ $round->staff_name }}</option>
            @endforeach
		  </select>
		</div>
		<div class="hide_round_status" style="display:none; clear:both; padding-top: 10px;" >
			<input type="button" id="but_adminonly" value="CONFIRM UPDATE" />
		</div>
	</fieldset>
    </div>
</div>
@endif

<script type="text/javascript">
	$(document).ready(function() {
		$('#btnRight').on('click', function (e) {	
			$(".hide_round_status").show();			
			var selectedOpts = $('#lstBox1 option:selected');
			if (selectedOpts.length == 0) {
				alert("Nothing to move.");
				e.preventDefault();
			}

			$('#lstBox2').append($(selectedOpts).clone());
			$(selectedOpts).remove();
			e.preventDefault();						
		});
		$('#btnLeft').on('click', function (e) {	
			$(".hide_round_status").show();			
			var selectedOpts = $('#lstBox2 option:selected');
			if (selectedOpts.length == 0) {
				alert("Nothing to move.");
				e.preventDefault();
			}

			$('#lstBox1').append($(selectedOpts).clone());
			$(selectedOpts).remove();
			e.preventDefault();	
		});
		
		$('#but_adminonly').on('click', function() {		
			clear_all_staff();						
			$('#lstBox2 > option').each(function(i, selected){ 
				staff_only(this.value);
			});			
			$(".hide_round_status").hide();			
		});
	});


        function Find_round()
        {
            var round_no = $('#round_no').val();
            $.ajax({
                url: "/RoundDetails",
                type:"POST",
                data:{"round_no":round_no, "_token": "{{csrf_token()}}"},
                success: function(result){
                    var obj = JSON.parse(result);
                    $('.htmldiv').css('display','block');
                    $('.tbody').html(obj.html);
                }
            });
        }

        function delete_round(id)
        {
            if(confirm('{{ Lang::get('core.confirm_delete') }}'))
            {
                $.ajax({
                    url: "/deleteRound",
                    type:"POST",
                    data:{"id":id, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        if(obj.ResponseCode == 0)
                        {
                            alert('{{ Lang::get('core.delete_warning') }}');
                        }else{
                            window.location.reload();
                        }
                    }
                });
            }
        }
		
		function clear_all_staff()
		{		
			$.ajax({				
                url: "/ClearAllStaff",
				async: false,
				cache: false,
                method:"POST",
                data:{"_token":"{{csrf_token()}}", delay: 1},
				beforeSend: function() {

				},				
                success: function(result){

                }
            });			
		}
		
        function staff_only(id)
        {
			var val = 1;

            $.ajax({
                url: "/StaffOnly",
                type:"POST",
				async: false,
				cache: false,
				timeout: 1000,			
                data:{"id":id, "val":val, "_token":"{{csrf_token()}}"},
				beforeSend: function() {

				},					
                success: function(result){
					
                }
            });
        }		
		
</script>