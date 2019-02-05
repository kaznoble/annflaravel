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
		<li><a href="{{ URL::to('Usermanagement') }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
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
		 {{ Form::open(array('url'=>'Usermanagement/save/'.(isset($row[0]) ? SiteHelpers::encryptID($row[0]->id)  : ''), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
		 
		 <?php //print_r($row); exit; ?>
				<div class="col-md-12">
		<div class="row">
			<div class="col-sm-6">
				<fieldset>
					<legend> User Management</legend>
					<div class="row">
						<div class="form-group  " >
							<div class="col-sm-4">
							{{isset($row[0]) ? $row[0]->staff_id  : ''}}
							{{ Form::hidden('staff_id', isset($row[0]) ? $row[0]->staff_id : '') }}
							</div>
							<div class="col-sm-4">
								{{ Form::text('first_name',  isset($row[0]) ? $row[0]->first_name : '' ,array('class'=>'form-control','placeholder'=>'First Name')) }}
							</div>
							<div class="col-sm-4">
								{{ Form::text('last_name', isset($row[0]) ? $row[0]->last_name : ''  ,array('class'=>'form-control','placeholder'=>'Last Name')) }} 
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group  " >
							<div class="col-sm-4">
								{{ Form::text('username', isset($row[0]) ? $row[0]->username : ''  ,array('class'=>'form-control','placeholder'=>'username')) }} 
							</div>
							<div class="col-sm-4">
							{{ isset($row[0]) ? $row[0]->email : '' }}
							</div>
							<div class="col-sm-4">
								<select name='group_id' rows='5' id='group_id' code='{$group_id}' 
							class='form-control '></select> 
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group  " >
							<div class="col-sm-4">
								{{ Form::text('round_number',isset($row[0]) ? $row[0]->round_number : '',array('readonly'=>'readonly','class'=>'form-control','placeholder'=>'Round Number' )) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12"><p></p>	</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h6>Working Week</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="row">
								<div class="weekDays-selector">
									{{ Form::checkbox('monday',isset($row[0]) ? $row[0]->monday : '1', ((isset($row[0]) ? $row[0]->monday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-mon')) }}
									<label for="weekday-mon">Mon</label>
									
									{{ Form::checkbox('tuesday',isset($row[0]) ? $row[0]->tuesday : '1',((isset($row[0]) ? $row[0]->tuesday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-tue')) }}
									<label for="weekday-tue">Tue</label>
									{{ Form::checkbox('wednesday',isset($row[0]) ? $row[0]->wednesday : '1',((isset($row[0]) ? $row[0]->wednesday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-wed')) }}
									
									<label for="weekday-wed">Wed</label>
									{{ Form::checkbox('thursday',isset($row[0]) ? $row[0]->thursday : '1',((isset($row[0]) ? $row[0]->thursday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-thu')) }}
									
									<label for="weekday-thu">Thu</label>
									{{ Form::checkbox('friday',isset($row[0]) ? $row[0]->friday : '1',((isset($row[0]) ? $row[0]->friday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-fri')) }}
									
									<label for="weekday-fri">Fri</label>
									{{ Form::checkbox('saturday',isset($row[0]) ? $row[0]->saturday : '0',((isset($row[0]) ? $row[0]->saturday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-sat')) }}
									
									<label for="weekday-sat">Sat</label>
									{{ Form::checkbox('sunday',isset($row[0]) ? $row[0]->sunday : '0',((isset($row[0]) ? $row[0]->sunday : '0')==1) ? true : false,array('class'=>'weekday check','id'=>'weekday-sun')) }}
									
									<label for="weekday-sun">Sun</label>
								</div>
								
									
							</div> 
						</div>
					</div>
					<div class="row" style="margin-top:20px">
						<p>Account Status</p>
						<div class="form-group" >
							<div class="col-sm-4">
								<select name="account_status" class='form-control'>
									<option @if(isset($row[0])) @if($row[0]->account_status == 1) 'selected' @endif @endif value="1">Enabled</option>
									<option @if(isset($row[0])) @if($row[0]->account_status == 0) selected='selected' @endif @endif value="0">Disabled</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:20px">
						<p>Commission</p>
						<div class="form-group" >
							<div class="col-sm-4">
								<select name="commission_payed" class='form-control sel_commission'>
									<option @if(isset($row[0])) @if($row[0]->commission_payed == 0) 'selected' @endif @endif value="0">No</option>
									<option @if(isset($row[0])) @if($row[0]->commission_payed == 1) selected='selected' @endif @endif value="1">Yes</option>
								</select>
							</div>						
						</div>
					</div>			
					<div class="row div_commission" {{ ($row[0]->commission_payed == 1 ? '' : 'style="display:none;"') }} >
						<p>Percentage commission</p>
						<div class="form-group" >
							<div class="col-sm-4">
								<select name="percentage_commission_payed" id="percentage_commission_payed" class='form-control sel_commission'>
									<option value="" >--select--</option>								
									@foreach($staffComm As $staffCo)
										<option value="{{ $staffCo->sys_id }}" {{ ($row[0]->percentage_commission_payed == $staffCo->sys_id ? 'selected' : '') }} >{{ $staffCo->description }}</option>
									@endforeach
								</select>								
								<!--{{ Form::text('percentage_commission_payed',$row[0]->percentage_commission_payed,array('class' => 'form-control')); }}-->
							</div>						
						</div>
					</div>
				<fieldset>
			</div>
			<div class="col-sm-6">
				<fieldset>
					<legend>USER PROFILE PAGE</legend>
					<div class="form-group  " >
						<div class="col-sm-6">
							{{ Form::file('avatar','',array('id'=>'avatar','placeholder'=>'Home Phone' )) }}

							{{ Form::hidden('avatar1', isset($row[0]) ? $row[0]->avatar : '') }}
							{{ SiteHelpers::showUploadedFile( isset($row[0]) ? $row[0]->avatar : '','/uploads/users/') }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							{{ date('d/m/Y H:m:s', strtotime(isset($row[0]) ? $row[0]->last_login : '')) }}
							
						</div>
					</div>
					<div class="form-group  " >
						<div class="col-sm-6">
							{{ Form::text('home_number',isset($row[0]) ? $row[0]->home_number : '',array('class'=>'form-control','placeholder'=>'Home Phone' )) }}							
						</div>
					</div>
					<div class="form-group  " >
						<div class="col-sm-6">
							{{ Form::text('mobile_number',isset($row[0]) ? $row[0]->mobile_number : '',array('class'=>'form-control','placeholder'=>'Mobile Number' )) }}
						</div>
					</div>
					<div class="form-group  " >
						<div class="col-sm-6">
							{{ Form::text('mobile_device_number',isset($row[0]) ? $row[0]->mobile_device_number : '',array('class'=>'form-control','placeholder'=>'Mobile Device ID' )) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							{{ Form::text('upcoming_holidays',date('d/m/Y',strtotime(isset($row[0]) ? $row[0]->upcoming_holidays : '')),array('class'=>'form-control','id'=>'upcoming_holidays','placeholder'=>'Upcoming Holidays' )) }}
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>Emergency Contact Details</legend>
					<div class="form-group" >
						<div class="col-sm-6">
							{{ Form::text('emergency_contact_name',isset($row[0]) ? $row[0]->emergency_contact_name : '',array('class'=>'form-control','placeholder'=>'Name' )) }}
						</div>
					</div>
					<div class="form-group" >
						<div class="col-sm-6">
							{{ Form::text('emergency_contact_home',isset($row[0]) ? $row[0]->emergency_contact_home : '',array('class'=>'form-control','placeholder'=>'Home Number' )) }}
						</div>
					</div>
					<div class="form-group" >
						<div class="col-sm-6">
							{{ Form::text('emergency_contact_mobile',isset($row[0]) ? $row[0]->emergency_contact_mobile : '',array('class'=>'form-control','placeholder'=>'Mobile Number' )) }}
						</div>
					</div>
				</fieldset>
			</div>
		</div> 
		<div style="clear:both"></div>	
		<div class="form-group">
			<label class="col-sm-4 text-right">&nbsp;</label>
			<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Usermanagement') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
			</div>	  
		</div>
		{{ Form::close() }}

		@if(Session::get('gid') ==1 || Session::get('gid') ==2)
		<div class="form-group div_reset_password">
			{{ Form::open(array('url' => '/Usermanagement/request','class' => 'reset_password')) }}
				{{ Form::submit('Reset Password', array('class' => 'btn user_reset_password')); }}
				{{ Form::hidden('reset_id', SiteHelpers::encryptID($row[0]->id)); }}
				{{ Form::hidden('credit_email', $row[0]->email); }}
			{{ Form::close() }}
		</div>
		@endif
		
	</div>	
</div>	

 
<script type="text/javascript">
	$(document).ready(function() { 
		$('.user_reset_password').on('click',function() {
			var txt;
			var r = confirm("Are you sure you want to reset staff's password?");
			if (r == true) {
				return true;
			} else {
				return false;
			}
		});
		 
		$("#group_id").jCombo("{{ URL::to('Usermanagement/comboselect?filter=tb_groups:group_id:name') }}",
		{  selected_value : '{{ isset($row[0]) ? $row[0]->group_id : '' }}' });	
		
		$("#upcoming_holidays").datepicker({ format: 'dd/mm/yyyy' });
		
		$('.sel_commission').change(function() {
			var comm_selected = $('.sel_commission option:selected').val();
			if( comm_selected === '1' )
			{
				$('.div_commission').show();
			}
			else
			{
				$('.div_commission').hide();	
				$('input[name=percentage_commission_payed]').val('');
			}
		});
		
		
	});
	$(function() {
		$(".check").on("change", function() {			
			if($(this).val()=="1") {
					$(this).val("0");
					}
			else {
				    $(this).val("1");
				}
			});
		});
	</script>		 