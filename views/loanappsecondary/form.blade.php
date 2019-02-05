
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
		<li><a href="{{ URL::to('loanappsecondary') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'loanappsecondary/save/'.SiteHelpers::encryptID($row['loan_secondary_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Loan app secondary</legend>
									
								  <div class="form-group  " >
									<label for="Loan Secondary Id" class=" control-label col-md-4 text-left"> Loan Secondary Id </label>
									<div class="col-md-8">
									  {{ Form::text('loan_secondary_id', $row['loan_secondary_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Application Number" class=" control-label col-md-4 text-left"> Loan Application Number </label>
									<div class="col-md-8">
									  {{ Form::text('loan_application_number', $row['loan_application_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Primary Income" class=" control-label col-md-4 text-left"> Total Primary Income </label>
									<div class="col-md-8">
									  {{ Form::text('total_primary_income', $row['total_primary_income'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Secondary Income" class=" control-label col-md-4 text-left"> Total Secondary Income </label>
									<div class="col-md-8">
									  {{ Form::text('total_secondary_income', $row['total_secondary_income'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Maintenace" class=" control-label col-md-4 text-left"> Child Maintenace </label>
									<div class="col-md-8">
									  {{ Form::text('child_maintenace', $row['child_maintenace'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Tax Credit" class=" control-label col-md-4 text-left"> Child Tax Credit </label>
									<div class="col-md-8">
									  {{ Form::text('child_tax_credit', $row['child_tax_credit'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Benefit" class=" control-label col-md-4 text-left"> Child Benefit </label>
									<div class="col-md-8">
									  {{ Form::text('child_benefit', $row['child_benefit'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Income" class=" control-label col-md-4 text-left"> Total Income </label>
									<div class="col-md-8">
									  {{ Form::text('total_income', $row['total_income'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Declare Other Person Income" class=" control-label col-md-4 text-left"> Declare Other Person Income </label>
									<div class="col-md-8">
									  {{ Form::text('declare_other_person_income', $row['declare_other_person_income'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contribution Details" class=" control-label col-md-4 text-left"> Contribution Details </label>
									<div class="col-md-8">
									  {{ Form::text('contribution_details', $row['contribution_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Ccj" class=" control-label col-md-4 text-left"> Ccj </label>
									<div class="col-md-8">
									  {{ Form::text('ccj', $row['ccj'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Ccj Details" class=" control-label col-md-4 text-left"> Ccj Details </label>
									<div class="col-md-8">
									  {{ Form::text('ccj_details', $row['ccj_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Rent Mortgage" class=" control-label col-md-4 text-left"> Rent Mortgage </label>
									<div class="col-md-8">
									  {{ Form::text('rent_mortgage', $row['rent_mortgage'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loacal Tax" class=" control-label col-md-4 text-left"> Loacal Tax </label>
									<div class="col-md-8">
									  {{ Form::text('loacal_tax', $row['loacal_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Electric" class=" control-label col-md-4 text-left"> Electric </label>
									<div class="col-md-8">
									  {{ Form::text('electric', $row['electric'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Gas" class=" control-label col-md-4 text-left"> Gas </label>
									<div class="col-md-8">
									  {{ Form::text('gas', $row['gas'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone" class=" control-label col-md-4 text-left"> Telephone </label>
									<div class="col-md-8">
									  {{ Form::text('telephone', $row['telephone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Mobile" class=" control-label col-md-4 text-left"> Mobile </label>
									<div class="col-md-8">
									  {{ Form::text('mobile', $row['mobile'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tv License" class=" control-label col-md-4 text-left"> Tv License </label>
									<div class="col-md-8">
									  {{ Form::text('tv_license', $row['tv_license'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="House Insurance" class=" control-label col-md-4 text-left"> House Insurance </label>
									<div class="col-md-8">
									  {{ Form::text('house_insurance', $row['house_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle" class=" control-label col-md-4 text-left"> Vehicle </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle', $row['vehicle'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Insurance" class=" control-label col-md-4 text-left"> Vehicle Insurance </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle_insurance', $row['vehicle_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Road Tax" class=" control-label col-md-4 text-left"> Road Tax </label>
									<div class="col-md-8">
									  {{ Form::text('road_tax', $row['road_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Service" class=" control-label col-md-4 text-left"> Vehicle Service </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle_service', $row['vehicle_service'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Fuel" class=" control-label col-md-4 text-left"> Vehicle Fuel </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle_fuel', $row['vehicle_fuel'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Public Transport" class=" control-label col-md-4 text-left"> Public Transport </label>
									<div class="col-md-8">
									  {{ Form::text('public_transport', $row['public_transport'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Weekly Monthly" class=" control-label col-md-4 text-left"> Weekly Monthly </label>
									<div class="col-md-8">
									  {{ Form::text('weekly_monthly', $row['weekly_monthly'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Food" class=" control-label col-md-4 text-left"> Food </label>
									<div class="col-md-8">
									  {{ Form::text('food', $row['food'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Clothing" class=" control-label col-md-4 text-left"> Clothing </label>
									<div class="col-md-8">
									  {{ Form::text('clothing', $row['clothing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="School Meals" class=" control-label col-md-4 text-left"> School Meals </label>
									<div class="col-md-8">
									  {{ Form::text('school_meals', $row['school_meals'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Hairdressing" class=" control-label col-md-4 text-left"> Hairdressing </label>
									<div class="col-md-8">
									  {{ Form::text('hairdressing', $row['hairdressing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contingency" class=" control-label col-md-4 text-left"> Contingency </label>
									<div class="col-md-8">
									  {{ Form::text('contingency', $row['contingency'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other1" class=" control-label col-md-4 text-left"> Other1 </label>
									<div class="col-md-8">
									  {{ Form::text('other1', $row['other1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other2" class=" control-label col-md-4 text-left"> Other2 </label>
									<div class="col-md-8">
									  {{ Form::text('other2', $row['other2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other3" class=" control-label col-md-4 text-left"> Other3 </label>
									<div class="col-md-8">
									  {{ Form::text('other3', $row['other3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other1 Details" class=" control-label col-md-4 text-left"> Other1 Details </label>
									<div class="col-md-8">
									  {{ Form::text('other1_details', $row['other1_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other2 Details" class=" control-label col-md-4 text-left"> Other2 Details </label>
									<div class="col-md-8">
									  {{ Form::text('other2_details', $row['other2_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other3 Details" class=" control-label col-md-4 text-left"> Other3 Details </label>
									<div class="col-md-8">
									  {{ Form::text('other3_details', $row['other3_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total In" class=" control-label col-md-4 text-left"> Total In </label>
									<div class="col-md-8">
									  {{ Form::text('total_in', $row['total_in'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Out" class=" control-label col-md-4 text-left"> Total Out </label>
									<div class="col-md-8">
									  {{ Form::text('total_out', $row['total_out'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Difernece" class=" control-label col-md-4 text-left"> Difernece </label>
									<div class="col-md-8">
									  {{ Form::text('difernece', $row['difernece'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('loanappsecondary') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 