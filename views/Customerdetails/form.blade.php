	<link rel="stylesheet" href="{{URL::to('')}}/sximo/js/datepicker/css/datepicker.css" type="text/css" />

	<!--<script type="text/javascript" src="{{URL::to('')}}/sximo/js/datepicker/js/jquery.js"></script>-->
	<script type="text/javascript" src="{{URL::to('')}}/sximo/js/datepicker/js/bootstrap-datepicker.js"></script>
    
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
		<li><a href="{{ URL::to('Customerdetails') }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	</div>  
	
	@if(!empty(Session::get('round_number')))
	<div >
		<a href="/ViewEdit/{{Session::get('round_number')}}" ><< RETURN TO ADMIN ROUND</a>
	</div>	
	<br />
	@endif		
	
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
		
		<div class="require_style" >* - Requirement field</div>
		
		 {{ Form::open(array('url'=>'Customerdetails/save/'.SiteHelpers::encryptID($row['id'].'page='.$page).'?customer='.$isNewCustomer, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-6">
						<fieldset><legend> Customer Details</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Title" class=" control-label col-md-4 text-left"> Title <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='title' rows='5' id='title' code='{$title}' style="width:100px;" class='select2 ' ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Forename" class=" control-label col-md-4 text-left"> Forename <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('forename', $row['forename'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Surname" class=" control-label col-md-4 text-left"> Surname <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('surname', $row['surname'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Middle Names" class=" control-label col-md-4 text-left"> Middle Names </label>
									<div class="col-md-8">
									  {{ Form::text('middle_names', $row['middle_names'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Date Of Birth" class=" control-label col-md-4 text-left"> Date Of Birth <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('date_of_birth', (!empty($row['date_of_birth']) ? date("d/m/Y", strtotime($row['date_of_birth'])) : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Marital Status" class=" control-label col-md-4 text-left"> Marital Status <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='marital_status' rows='5' id='marital_status' code='{$marital_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Ni Number" class=" control-label col-md-4 text-left"> Ni Number <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('ni_number', $row['ni_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Children Under 18" class=" control-label col-md-4 text-left"> Number Children Under 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_children_under_18', $row['no_children_under_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Res Over 18" class=" control-label col-md-4 text-left"> Number Residence Over 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_res_over_18', $row['no_res_over_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Home Telephone" class=" control-label col-md-4 text-left"> Home Telephone <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_1', $row['telephone_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Mobile Phone" class=" control-label col-md-4 text-left"> Mobile Telephone <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_2', $row['telephone_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 3" class=" control-label col-md-4 text-left"> Work Telephone </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_3', $row['telephone_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <!--<div class="form-group  " @if( Session::get('gid') != 1 && Session::get('gid') != 2 && Session::get('gid') != 4 ) style="display:none;" @endif >-->
								  <div class="form-group  " >								  
									<label for="Bank Account No" class=" control-label col-md-4 text-left"> Bank Account No </label>
									<div class="col-md-8">
									  {{ Form::text('bank_account_no', $row['bank_account_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 													  
								  <div class="form-group  " >
									<label for="T And C" class=" control-label col-md-4 text-left"> Terms And Conditions </label>
									<div class="col-md-8">
									  
					<select name='t_and_c' rows='5' id='t_and_c'    
					class='select2 form-control '   >
						
							<option  value ='0' 
							@if($row['t_and_c'] =='0')
								selected="selected"
							@endif
							>No</option>
							<option  value ='1' 
							@if($row['t_and_c'] =='1')
								selected="selected"
							@endif
							>Yes</option>
					</select> 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Customer check ID" class=" control-label col-md-4 text-left"> Customer check ID </label>
									<div class="col-md-8">
									  <select name='cust_check_id' rows='5' id='cust_check_id' code='{$cust_check_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>								  
								  
								  </fieldset>
								  
						<fieldset><legend> Email</legend>
								  <div class="form-group  " >
									<label for="Username" class=" control-label col-md-4 text-left"> Username(Email) <span class="require_style">*</span> </label>
									<div class="col-md-8">
										<input class="form-control" type="text" name="username" value="{{ (!empty($row['username']) ? $row['username'] : '') }}" {{ (!empty($row['username']) ? 'readonly="true"' : '') }} />
									 </div> 
								  </div> 						
								  <div class="form-group  " >
									<label for="Primary Email" class=" control-label col-md-4 text-left"> Secondary Email <span class="require_style">*</span> </label>
									<div class="col-md-8">
										<input class="form-control" type="text" name="secondary_email" value="{{ (!empty($row['secondary_email']) ? $row['secondary_email'] : '') }}" {{ (!empty($row['secondary_email']) ? '' : '') }} />
									 </div> 
								  </div> 
								  <br>
								  <br>
								  <!--start mycode-->
								  <div class="form-group  " >
									<label for="Customer_recommend" class=" control-label col-md-4 text-left">Customer Recommended By:<span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='customer_recommended' rows='5' id='customer_recommended' code='{$customer_recommended}' 
							class='select3 '>
							  <option value="1"  @if($row['customer_recommended'] =='1')
								selected="selected"
							@endif>No recommendation set</option>
							  <option value="2" @if($row['customer_recommended'] =='2')
								selected="selected"
							@endif>Staff recommendation</option>
							  <option value="3" @if($row['customer_recommended'] =='3')
								selected="selected"
							@endif>Customer recommendation</option>
							</select> 
									 </div> 
								  </div> 
								  
								  <div id='cust_staff_number' class="form-group  " >
									<label for="cust_staff_number" class=" control-label col-md-4 text-left"> Customer/Staff Number </label>
									<div class="col-md-8">
									  {{ Form::text('cust_staff_number', $row['cust_staff_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <!--end mycode-->
								  <!--<div class="form-group  " >
									<label for="Email" class=" control-label col-md-4 text-left"> Email <span class="require_style">*</span> </label>
									<div class="col-md-8">
										<input class="form-control" type="text" name="email" value="{{ (!empty($row['email']) ? $row['email'] : '') }}" />
									 </div> 
								  </div> 
								  <div class="form-group  " >
									<label for="ConformEmail" class=" control-label col-md-4 text-left"> Confirm Email <span class="require_style">*</span> </label>
									<div class="col-md-8">
										<input class="form-control" type="text" name="email_confirmation" value="" />
									 </div> 
								  </div>--> 			
								  @if( empty($row['password']) && FALSE )					  
								  <div class="form-group  " >
									<label for="Password" class=" control-label col-md-4 text-left"> Password <span class="require_style">*</span> </label>
									<div class="col-md-8">
										<input class="form-control" type="text" name="password" value="" />
									 </div> 
								  </div> 				
								  @endif	
						</fieldset>
								  
			</div>
			
			<div class="col-md-6">
						<fieldset><legend> Address(es)</legend>
									
								  <div class="form-group  " >
									<label for="Address 1" class=" control-label col-md-4 text-left"> First line of Address <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('address_1', $row['address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 2" class=" control-label col-md-4 text-left"> Town <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('address_2', $row['address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 3" class=" control-label col-md-4 text-left"> City </label>
									<div class="col-md-8">
									  {{ Form::text('address_3', $row['address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="City" class=" control-label col-md-4 text-left"> County <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('address_4', $row['address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode" class=" control-label col-md-4 text-left"> Postcode <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('postcode', $row['postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 	
								  <div class="form-group  " >
									<label for="Time at this Address" class=" control-label col-md-4 text-left"> Time at this Address <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('time_address', (!empty($row['time_address']) ? $row['time_address'] : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Cus Residential Status" class=" control-label col-md-4 text-left"> Customer Residential Status <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='cus_residential_status' rows='5' id='cus_residential_status' code='{$cus_residential_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 													  
								  </fieldset>
								  
						<fieldset><legend> Previous Address</legend>
								  <div class="form-group  " >
									<label for="Previous Address 1" class=" control-label col-md-4 text-left"> First line of previous address </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_1', $row['previous_address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 2" class=" control-label col-md-4 text-left"> Previous Town </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_2', $row['previous_address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 3" class=" control-label col-md-4 text-left"> Previous City </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_3', $row['previous_address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="City" class=" control-label col-md-4 text-left"> Previous County </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_4', $row['previous_address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Postcode" class=" control-label col-md-4 text-left"> Previous Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('previous_postcode', $row['previous_postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Time at this Address" class=" control-label col-md-4 text-left"> Time at this Address </label>
									<div class="col-md-8">
									  {{ Form::text('previous_time_address', (!empty($row['previous_time_address']) ? $row['previous_time_address'] : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>								  
								  </fieldset>								  
								  
			</div>
			
			<div class="col-md-6 div_occupation">
						<fieldset><legend> Occupation</legend>
									
								  <div class="form-group  " >
									<label for="Employment Status" class=" control-label col-md-4 text-left">  Status <span class="main_require_style" style="color:red;" >*</span> </label>
									<div class="col-md-8">
									  <select name='employment_status' rows='5' id='employment_status' code='{$employment_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Occupation" class=" control-label col-md-4 text-left"> Occupation </label>
									<div class="col-md-8">
									  {{ Form::text('occupation', $row['occupation'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Employer Name" class=" control-label col-md-4 text-left"> Company Name <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('employer_name', $row['employer_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 
								  <div class="form-group  " >
									<label for="Employer Telephone" class=" control-label col-md-4 text-left"> Company Telephone <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('employer_telephone', $row['employment_phone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 
								  <div class="form-group  " >
									<label for="Work Address 1" class=" control-label col-md-4 text-left"> First line of Company Address <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_1', $row['work_address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 2" class=" control-label col-md-4 text-left"> Company Town <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_2', $row['work_address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 3" class=" control-label col-md-4 text-left"> Company City </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_3', $row['work_address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="City" class=" control-label col-md-4 text-left"> Company County <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_4', $row['work_address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Postcode" class=" control-label col-md-4 text-left"> Company Postcode <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_postcode', $row['work_postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
							</fieldset>
			</div>			
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customerdetails') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				<input type="hidden" name="page" value="{{ $page }}" />
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#title").jCombo("{{ URL::to('Customerdetails/comboselect?filter=customer_title:id:title') }}",
		{  selected_value : '{{ $row["title"] }}' });
		
		$("#marital_status").jCombo("{{ URL::to('Customerdetails/comboselect?filter=marital_status:id:description') }}",
		{  selected_value : '{{ $row["marital_status"] }}' });
		
		$("#employment_status").jCombo("{{ URL::to('Customerdetails/comboselect?filter=employment_status:id:description') }}",
		{  selected_value : '{{ $row["employment_status"] }}' });
		
		$("#cus_residential_status").jCombo("{{ URL::to('Customerdetails/comboselect?filter=residential_status:id:description') }}",
		{  selected_value : '{{ $row["cus_residential_status"] }}' });
		
		$("#cust_check_id").jCombo("{{ URL::to('Customerdetails/comboselect?filter=customer_id_check:cust_check_id:cust_check_desc') }}",
		{  selected_value : '{{ $row["customer_id_check"] }}' });		
		
		$('[name="date_of_birth"]').datepicker({format: 'dd/mm/yyyy'});		
		
		$('#employment_status').change(function(){
			var empOption = $('#employment_status option:selected').val();
			if(empOption == '4' || empOption == '6' || empOption == '7' || empOption == '8' || empOption == '9')
			{
				$('.div_occupation .require_style').hide();
			}
			else
			{
				$('.div_occupation .require_style').show();
			}
		});
		
		
		$("#customer_recommended").change(function(){
			if($("#customer_recommended").val() == '1'){
				$("#cust_staff_number").hide();
			}else if($("#customer_recommended").val() == '2' || $("#customer_recommended").val() == '3'){
				$("#cust_staff_number").show();
			}
		});
		
		if($("#customer_recommended").val() == '1'){
				$("#cust_staff_number").hide();
		}else if($("#customer_recommended").val() == '2' || $("#customer_recommended").val() == '3'){
				$("#cust_staff_number").show();
		}
		 
	});
	</script>		 