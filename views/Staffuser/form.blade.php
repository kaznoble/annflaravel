
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
		<li><a href="{{ URL::to('Staffuser') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Staffuser/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Staff User</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Id" class=" control-label col-md-4 text-left"> Staff Number </label>
									<div class="col-md-8">
										@if( empty($row['id']) )
									  		<!--{{ Form::text('staff_id', $row['staff_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }}-->
									  		<input type="text" id="staff_id" disabled="disabled" class="form-control" placeholder="auto" />
									  	@else
									  		{{ $row['staff_id'] }}
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Group Id" class=" control-label col-md-4 text-left"> Group Id </label>
									<div class="col-md-8">
									  <select name='group_id' rows='5' id='group_id' code='{$group_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Username" class=" control-label col-md-4 text-left"> Username </label>
									<div class="col-md-8">
									  {{ Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  @if( $groupid == 2 || $groupid == 1 )
								  <div class="form-group  " >
									<label for="Password" class=" control-label col-md-4 text-left"> New Password </label>
									<div class="col-md-8">
									  {{ Form::text('password', '',array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									  <input type="hidden" name="hid_password" id="hid_password" value="{{ $row['password'] }}" />
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Password" class=" control-label col-md-4 text-left"> Confirm Password </label>
									<div class="col-md-8">
									  {{ Form::text('password_confirmation', '',array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>			
								  @endif					  
								  <div class="form-group  " >
									<label for="Email" class=" control-label col-md-4 text-left"> Email </label>
									<div class="col-md-8">
									  {{ Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Name" class=" control-label col-md-4 text-left"> First Name </label>
									<div class="col-md-8">
									  {{ Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Last Name" class=" control-label col-md-4 text-left"> Last Name </label>
									<div class="col-md-8">
									  {{ Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="Avatar" class=" control-label col-md-4 text-left"> Avatar </label>
									<div class="col-md-8">
									  {{ Form::text('avatar', $row['avatar'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> 					
								  <div class="form-group  " >
									<label for="Active" class=" control-label col-md-4 text-left"> Active </label>
									<div class="col-md-8">
									  <select name='active' rows='5' id='active' code='{$active}' 
							class='select2 '    >
										<option value="1" {{ ($row['active'] == '1' ? 'selected="selected"' : '') }} >Live</option>
										<option value="0" {{ ($row['active'] == '0' ? 'selected="selected"' : '') }} >Disable</option>
							</select> 									
									  <!--{{ Form::text('active', $row['active'],array('class'=>'form-control', 'placeholder'=>'',   )) }}-->
									 </div> 
								  </div>
								  <!--<div class="form-group  " >
									<label for="Reminder" class=" control-label col-md-4 text-left"> Reminder </label>
									<div class="col-md-8">
									  {{ Form::text('reminder', $row['reminder'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> 					
								  <!--<div class="form-group  " >
									<label for="Activation" class=" control-label col-md-4 text-left"> Activation </label>
									<div class="col-md-8">
									  {{ Form::text('activation', $row['activation'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> 					
								  <!--<div class="form-group  " >
									<label for="Remember Token" class=" control-label col-md-4 text-left"> Remember Token </label>
									<div class="col-md-8">
									  <textarea name='remember_token' rows='2' id='remember_token' class='form-control '  
				           >{{ $row['remember_token'] }}</textarea> 
									 </div> 
								  </div>--> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Staffuser') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#group_id").jCombo("{{ URL::to('Staffuser/comboselect?filter=tb_groups:group_id:name') }}",
		{  selected_value : '{{ $row["group_id"] }}' });
		 
	});
	</script>		 