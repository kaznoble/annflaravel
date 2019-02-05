
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
		<li><a href="{{ URL::to('Customer') }}">{{ $pageTitle }}</a></li>
        <li class="active"> Add Or Edit </li>
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
		 {{ Form::open(array('url'=>'Customer/save/'.SiteHelpers::encryptID($row['customer_no']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-6">
						<fieldset><legend> Personal Details</legend>
									
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  <select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' 
							class='select2 form-control '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Title" class=" control-label col-md-4 text-left"> Title </label>
									<div class="col-md-8">
									  <select name='title' rows='5' id='title' code='{$title}' 
							class='select2 form-control '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Forename" class=" control-label col-md-4 text-left"> Forename </label>
									<div class="col-md-8">
									  {{ Form::text('forename', $row['forename'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Surname" class=" control-label col-md-4 text-left"> Surname </label>
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
									<label for="Date Of Birth" class=" control-label col-md-4 text-left"> Date Of Birth </label>
									<div class="col-md-8">
									  {{ Form::text('date_of_birth', $row['date_of_birth'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Marital Status" class=" control-label col-md-4 text-left"> Marital Status </label>
									<div class="col-md-8">
									  <select name='marital_status' rows='5' id='marital_status' code='{$marital_status}' 
							class='select2 form-control '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Ni Number" class=" control-label col-md-4 text-left"> Ni Number </label>
									<div class="col-md-8">
									  {{ Form::text('ni_number', $row['ni_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Children Under 18" class=" control-label col-md-4 text-left"> No Children Under 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_children_under_18', $row['no_children_under_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Res Over 18" class=" control-label col-md-4 text-left"> No Res Over 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_res_over_18', $row['no_res_over_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 1" class=" control-label col-md-4 text-left"> Telephone 1 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_1', $row['telephone_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 2" class=" control-label col-md-4 text-left"> Telephone 2 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_2', $row['telephone_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 3" class=" control-label col-md-4 text-left"> Telephone 3 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_3', $row['telephone_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Cus Residential Status" class=" control-label col-md-4 text-left"> Cus Residential Status </label>
									<div class="col-md-8">
									  <select name='cus_residential_status' rows='5' id='cus_residential_status' code='{$cus_residential_status}' 
							class='select2 form-control '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="T And C" class=" control-label col-md-4 text-left"> T And C </label>
									<div class="col-md-8">
									  {{ Form::text('t_and_c', $row['t_and_c'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
									<div class="col-md-8">
									  
				{{ Form::text('created_at', $row['created_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
									<div class="col-md-8">
									  
				{{ Form::text('updated_at', $row['updated_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Deleted At" class=" control-label col-md-4 text-left"> Deleted At </label>
									<div class="col-md-8">
									  
				{{ Form::text('deleted_at', $row['deleted_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend> Address(es)</legend>
									
								  <div class="form-group  " >
									<label for="Address 1" class=" control-label col-md-4 text-left"> Address 1 </label>
									<div class="col-md-8">
									  {{ Form::text('address_1', $row['address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 2" class=" control-label col-md-4 text-left"> Address 2 </label>
									<div class="col-md-8">
									  {{ Form::text('address_2', $row['address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 3" class=" control-label col-md-4 text-left"> Address 3 </label>
									<div class="col-md-8">
									  {{ Form::text('address_3', $row['address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 4" class=" control-label col-md-4 text-left"> Address 4 </label>
									<div class="col-md-8">
									  {{ Form::text('address_4', $row['address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode" class=" control-label col-md-4 text-left"> Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('postcode', $row['postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 1" class=" control-label col-md-4 text-left"> Previous Address 1 </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_1', $row['previous_address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 2" class=" control-label col-md-4 text-left"> Previous Address 2 </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_2', $row['previous_address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 3" class=" control-label col-md-4 text-left"> Previous Address 3 </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_3', $row['previous_address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Address 4" class=" control-label col-md-4 text-left"> Previous Address 4 </label>
									<div class="col-md-8">
									  {{ Form::text('previous_address_4', $row['previous_address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Previous Postcode" class=" control-label col-md-4 text-left"> Previous Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('previous_postcode', $row['previous_postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend>Work Address</legend>
								  <div class="form-group  " >
									<label for="Employment Status" class=" control-label col-md-4 text-left"> Employment Status </label>
									<div class="col-md-8">
									  <select name='employment_status' rows='5' id='employment_status' code='{$employment_status}' 
							class='select2 form-control '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Occupation" class=" control-label col-md-4 text-left"> Occupation </label>
									<div class="col-md-8">
									  {{ Form::text('occupation', $row['occupation'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Employer Name" class=" control-label col-md-4 text-left"> Employer Name </label>
									<div class="col-md-8">
									  {{ Form::text('employer_name', $row['employer_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 1" class=" control-label col-md-4 text-left"> Work Address 1 </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_1', $row['work_address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 2" class=" control-label col-md-4 text-left"> Work Address 2 </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_2', $row['work_address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 3" class=" control-label col-md-4 text-left"> Work Address 3 </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_3', $row['work_address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 4" class=" control-label col-md-4 text-left"> Work Address 4 </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_4', $row['work_address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Postcode" class=" control-label col-md-4 text-left"> Work Postcode </label>
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
				<button type="submit" class="btn btn-primary ">  Submit </button>
				<button type="button" onclick="location.href='{{ URL::to('Customer') }}' " id="submit" class="btn btn-success ">  Cancel </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#customer_no").jCombo("{{ URL::to('Customer/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row['customer_no'] }}' });
		
		$("#title").jCombo("{{ URL::to('Customer/comboselect?filter=customer_title:id:id') }}",
		{  selected_value : '{{ $row['title'] }}' });
		
		$("#marital_status").jCombo("{{ URL::to('Customer/comboselect?filter=marital_status:id:id') }}",
		{  selected_value : '{{ $row['marital_status'] }}' });
		
		$("#employment_status").jCombo("{{ URL::to('Customer/comboselect?filter=employment_status:id:id') }}",
		{  selected_value : '{{ $row['employment_status'] }}' });
		
		$("#cus_residential_status").jCombo("{{ URL::to('Customer/comboselect?filter=residential_status:id:id') }}",
		{  selected_value : '{{ $row['cus_residential_status'] }}' });
		 
	});
	</script>		 