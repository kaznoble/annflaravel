
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
		<li><a href="{{ URL::to('incomeexpenditure') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'incomeexpenditure/save/'.SiteHelpers::encryptID($row['cust_outg_id']).(!empty(Session::get('round_number')) ? '?flag=adminround&round_number='.Session::get('round_number') : ''), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
		 
				<div class="col-md-12">
				
								<div style="float: left; width: 45%" >
								  <div class="form-group  " >
									<label for="Created At" class=" control-label col-md-4 text-left"> Customer Name </label>
									<div class="col-md-8">
				{{ Form::text('customer_name', $row['customer']->forename . ' ' . $row['customer']->surname,array('class'=>'form-control', 'style'=>'width:150px !important;', 'disabled'=>'true')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Updated At" class=" control-label col-md-4 text-left"> Customer No. </label>
									<div class="col-md-8">
									  
				{{ Form::text('customer_no', $row['customer']->customer_no, array('class'=>'form-control', 'style'=>'width:150px !important;', 'disabled'=>'true')) }} 
									 </div> 
								  </div>
								</div>
								  
								<div style="float: left; width: 45%" >								  
								 <div class="form-group  " >
									<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
									<div class="col-md-8">
									  
				{{ Form::text('created_at', date('d/m/Y', strtotime($row['created_at'])),array('class'=>'form-control', 'style'=>'width:150px !important;', 'disabled'=>'true')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
									<div class="col-md-8">
									  
				{{ Form::text('updated_at', date('d/m/Y H:i:s', strtotime($row['updated_at'])),array('class'=>'form-control', 'style'=>'width:150px !important;', 'disabled'=>'true')) }} 
									 </div> 
								  </div> 	
								 </div>
								 
								 <div style="clear:both;" ></div>
				
						<fieldset><legend> Income</legend>
									
								@if(!empty($row['income']->cust_income_id))
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Income Id" class=" control-label col-md-4 text-left"> Cust Income Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_income_id', $row['income']->cust_income_id,array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								@endif
								  <div class="form-group hidethis  " style="display:none;">
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  <select name='customer_no_hide' rows='5' id='customer_no' code='{$customer_no}' class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;" >
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id_hide' rows='5' id='user_id' code='{$user_id}' class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group " >
									<label for="Income Frequency" class=" control-label col-md-4 text-left"> Income Frequency <span class="red_asteriod">*</span></label>
									<div class="col-md-8">
									  <select name='income_frequency' rows='5' id='income_frequency' code='{$income_frequency}' class='select2 ' ></select> 									  
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Wage 1" class=" control-label col-md-4 text-left"> Primary Wages </label>
									<div class="col-md-8">
									  £{{ Form::text('wage_1', (!empty($row['income']->wage_1) ? $row['income']->wage_1 : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 
								  <div class="form-group  " >
									<label for="Secondary Wages" class=" control-label col-md-4 text-left"> Secondary Wages </label>
									<div class="col-md-8">
									  £{{ Form::text('sec_wage_2', (!empty($row['income']->wage_2) ? $row['income']->wage_2 : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 
								  <div class="form-group hidethis " style="display:none;" >
									<label for="Wage 2" class=" control-label col-md-4 text-left"> Wage 2 </label>
									<div class="col-md-8">
									  £{{ Form::text('wage_2', (!empty($row['income']->wage_2) ? $row['income']->wage_2 : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Benefit" class=" control-label col-md-4 text-left"> Child Benefit </label>
									<div class="col-md-8">
									  £{{ Form::text('child_benefit', (!empty($row['income']->child_benefit) ? $row['income']->child_benefit : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Tax Credit" class=" control-label col-md-4 text-left"> Child Tax Credit </label>
									<div class="col-md-8">
									  £{{ Form::text('child_tax_credit', (!empty($row['income']->child_tax_credit) ? $row['income']->child_tax_credit : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Maintenance Payments" class=" control-label col-md-4 text-left"> Maintenance Payments </label>
									<div class="col-md-8">
									  £{{ Form::text('maintenance_payments', (!empty($row['income']->maintenance_payments) ? $row['income']->maintenance_payments : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis  " style="display:none;" >
									<label for="Other" class=" control-label col-md-4 text-left"> Other </label>
									<div class="col-md-8">
									  {{ Form::text('other', (!empty($row['income']->other) ? $row['income']->other : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;" >
									<label for="Other Description" class=" control-label col-md-4 text-left"> Other Description </label>
									<div class="col-md-8">
									  {{ Form::text('other_description', (!empty($row['income']->other_description) ? $row['income']->other_description : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Income Total" class=" control-label col-md-4 text-left"> Income Total </label>
									<div class="col-md-8">
									  £{{ Form::text('income_total', (!empty($row['income']->income_total) ? $row['income']->income_total : ''),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Ccj" class=" control-label col-md-4 text-left label_bold"> County Court Judgement <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='ccj' rows='5' id='ccj' code='{$ccj}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>					
								  <div class="form-group  " >
									<label for="Ccj Details" class=" control-label col-md-4 text-left label_bold"> County Court Judgement Details </label>
									<div class="col-md-8">
									  {{ Form::text('ccj_details', $row['income']->ccj_details,array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  </fieldset>
			</div>		 
		 	
		 	<div style="clear:both;padding-top:20px;" ></div>
		 
				<div class="col-md-6" >
						<fieldset><legend> Expenditure</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Outg Id" class=" control-label col-md-4 text-left"> Cust Outg Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_outg_id', $row['cust_outg_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  {{ Form::text('customer_no_hide', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  {{ Form::text('user_id', $row['user_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Frequency" class=" control-label col-md-4 text-left"> Frequency <span class="red_asteriod">*</span></label>
									<div class="col-md-8">
									  <select name='outgoing_frequency' rows='5' id='outgoing_frequency' code='{$outgoing_frequency}' class='select2 ' ></select> 									  
									 </div> 
								  </div> 													  
								  <div class="form-group  " >
									<label for="Rent Mortgage" class=" control-label col-md-4 text-left"> Rent Mortgage </label>
									<div class="col-md-8">
									  £{{ Form::text('rent_mortgage', $row['rent_mortgage'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Gas" class=" control-label col-md-4 text-left"> Gas </label>
									<div class="col-md-8">
									  £{{ Form::text('gas', $row['gas'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Electric" class=" control-label col-md-4 text-left"> Electric </label>
									<div class="col-md-8">
									  £{{ Form::text('electric', $row['electric'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Phone" class=" control-label col-md-4 text-left"> Phone </label>
									<div class="col-md-8">
									  £{{ Form::text('phone', $row['phone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Transport" class=" control-label col-md-4 text-left"> Transport </label>
									<div class="col-md-8">
									  £{{ Form::text('transport', $row['transport'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Local Tax" class=" control-label col-md-4 text-left"> Local Tax </label>
									<div class="col-md-8">
									  £{{ Form::text('local_tax', $row['local_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Water" class=" control-label col-md-4 text-left"> Water </label>
									<div class="col-md-8">
									  £{{ Form::text('water', $row['water'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Mobile Phone" class=" control-label col-md-4 text-left"> Mobile Phone </label>
									<div class="col-md-8">
									  £{{ Form::text('mobile_phone', $row['mobile_phone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tv License" class=" control-label col-md-4 text-left"> Tv License </label>
									<div class="col-md-8">
									  £{{ Form::text('tv_license', $row['tv_license'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Road Tax" class=" control-label col-md-4 text-left"> Vehicle Road Tax </label>
									<div class="col-md-8">
									  £{{ Form::text('vehicle_road_tax', $row['vehicle_road_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Service" class=" control-label col-md-4 text-left"> Vehicle Service </label>
									<div class="col-md-8">
									  £{{ Form::text('vehicle_service', $row['vehicle_service'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Fuel" class=" control-label col-md-4 text-left"> Fuel </label>
									<div class="col-md-8">
									  £{{ Form::text('fuel', $row['fuel'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Car Insurance" class=" control-label col-md-4 text-left"> Car Insurance </label>
									<div class="col-md-8">
									  £{{ Form::text('car_insurance', $row['car_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend> Expenditure</legend>
									
								  <div class="form-group  " >
									<label for="Public Transport" class=" control-label col-md-4 text-left"> Public Transport </label>
									<div class="col-md-8">
									  £{{ Form::text('public_transport', $row['public_transport'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Food" class=" control-label col-md-4 text-left"> Food </label>
									<div class="col-md-8">
									  £{{ Form::text('food', $row['food'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Clothing" class=" control-label col-md-4 text-left"> Clothing </label>
									<div class="col-md-8">
									  £{{ Form::text('clothing', $row['clothing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="School Meals" class=" control-label col-md-4 text-left"> School Meals </label>
									<div class="col-md-8">
									  £{{ Form::text('school_meals', $row['school_meals'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Sports Hobbies" class=" control-label col-md-4 text-left"> Sports Hobbies </label>
									<div class="col-md-8">
									  £{{ Form::text('sports_hobbies', $row['sports_hobbies'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contents Insurance" class=" control-label col-md-4 text-left"> Contents Insurance </label>
									<div class="col-md-8">
									  £{{ Form::text('contents_insurance', $row['contents_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Hairdressing" class=" control-label col-md-4 text-left"> Hairdressing </label>
									<div class="col-md-8">
									  £{{ Form::text('hairdressing', $row['hairdressing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contingency" class=" control-label col-md-4 text-left"> Contingency </label>
									<div class="col-md-8">
									  £{{ Form::text('contingency', $row['contingency'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 1" class=" control-label col-md-4 text-left"> Other 1 </label>
									<div class="col-md-8">
									  £{{ Form::text('other_1', $row['other_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 1" class=" control-label col-md-4 text-left"> Other Description 1 </label>
									<div class="col-md-8">
									  <textarea name='other_description_1' rows='2' id='other_description_1' class='form-control '  
				           >{{ SiteHelpers::clean_paragraph($row['other_description_1']) }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 2" class=" control-label col-md-4 text-left"> Other 2 </label>
									<div class="col-md-8">
									  £{{ Form::text('other_2', $row['other_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 2" class=" control-label col-md-4 text-left"> Other Description 2 </label>
									<div class="col-md-8">
									  <textarea name='other_description_2' rows='2' id='other_description_2' class='form-control '  
				           >{{ SiteHelpers::clean_paragraph($row['other_description_2']) }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 3" class=" control-label col-md-4 text-left"> Other 3 </label>
									<div class="col-md-8">
									  £{{ Form::text('other_3', $row['other_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 3" class=" control-label col-md-4 text-left"> Other Description 3 </label>
									<div class="col-md-8">
									  <textarea name='other_description_3' rows='2' id='other_description_3' class='form-control '  
				           >{{ SiteHelpers::clean_paragraph($row['other_description_3']) }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;" >
									<label for="Outgoing Total" class=" control-label col-md-4 text-left"> Outgoing Total </label>
									<div class="col-md-8">
									  {{ Form::text('outgoing_total', $row['outgoing_total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " style="height:30px;" >
									<label for="Total" class=" control-label col-md-4 text-left">  </label>
									<div class="col-md-8"></div> 
								  </div>								   					
								  <div class="form-group  " >
									<label for="Total" class=" control-label col-md-4 text-left"> <strong>Total Expenditure</strong> </label>
									<div class="col-md-8">
									  £{{ Form::text('total_expenditure', $row['total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Total" class=" control-label col-md-4 text-left"> <strong>Total Income</strong> </label>
									<div class="col-md-8">
									  £{{ Form::text('total_income', '0.00',array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>								  
								  <div class="form-group diff_total " >
									<label for="Total" class=" control-label col-md-4 text-left"> <strong>Difference Income/Expenditure</strong> </label>
									<div class="col-md-8">
									  £{{ Form::text('total_difference', '0.00',array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>								  
								  
								  
								  </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<input type="hidden" id="type" name="type" value="{{ $page_type }}" />
				<input type="hidden" id="customer_no" name="customer_no" value="{{ $row['customer']->customer_no }}" />
				<input type="hidden" id="user_id" name="user_id" value="{{ $row['customer']->user_id }}" />				
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('incomeexpenditure') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
   	function incomeTotal()
   	{
		var incomeTotal = 0;
		var wage1 = '0.00';
		var secwage2='0.00';
		var childBenefit = '0.00';
		var childTaxCredit = '0.00';
		var maintenancePayments = '0.00';
		
		if($('input[name="wage_1"]').val() !== '')
			wage1 = $('input[name="wage_1"]').val();
		if($('input[name="sec_wage_2"]').val() !== '')
			secwage2 = $('input[name="sec_wage_2"]').val();
		if($('input[name="child_benefit"]').val() !== '')
			childBenefit = $('input[name="child_benefit"]').val();			
		if($('input[name="child_tax_credit"]').val() !== '')
			childTaxCredit = $('input[name="child_tax_credit"]').val();
		if($('input[name="maintenance_payments"]').val() !== '')
			maintenancePayments = $('input[name="maintenance_payments"]').val();
		incomeTotal = Math.abs(parseFloat(wage1)+ parseFloat(secwage2) + parseFloat(childBenefit) + parseFloat(childTaxCredit) + parseFloat(maintenancePayments)).toFixed(2);
		$('input[name="income_total"], input[name="total_income"]').val(incomeTotal);
		return incomeTotal;
	}
	
   	function outgoingTotal()
   	{
		var outgoingTotal = 0;
		var rent_mortgage = '0.00';
		var gas = '0.00';
		var electric = '0.00';
		var phone = '0.00';
		var transport = '0.00';
		var local_tax = '0.00';
		var water = '0.00';
		var mobile_phone = '0.00';
		var tv_license = '0.00';
		var vehicle_road_tax = '0.00';
		var vehicle_service = '0.00';
		var fuel = '0.00';
		var car_insurance = '0.00';														
		var public_transport = '0.00';	
		var food = '0.00';													
		var clothing = '0.00';														
		var school_meals = '0.00';														
		var sports_hobbies = '0.00';														
		var contents_insurance = '0.00';														
		var hairdressing = '0.00';														
		var contingency = '0.00';														
		var other_1 = '0.00';														
		var other_2 = '0.00';																		
		var other_3 = '0.00';																		
		
		if($('input[name="rent_mortgage"]').val() !== '')
			rent_mortgage = $('input[name="rent_mortgage"]').val();
		if($('input[name="gas"]').val() !== '')
			gas = $('input[name="gas"]').val();			
		if($('input[name="electric"]').val() !== '')
			electric = $('input[name="electric"]').val();						
		if($('input[name="phone"]').val() !== '')
			phone = $('input[name="phone"]').val();
		if($('input[name="transport"]').val() !== '')
			transport = $('input[name="transport"]').val();
		if($('input[name="local_tax"]').val() !== '')
			local_tax = $('input[name="local_tax"]').val();
		if($('input[name="water"]').val() !== '')
			water = $('input[name="water"]').val();
		if($('input[name="mobile_phone"]').val() !== '')
			mobile_phone = $('input[name="mobile_phone"]').val();
		if($('input[name="tv_license"]').val() !== '')
			tv_license = $('input[name="tv_license"]').val();
		if($('input[name="vehicle_road_tax"]').val() !== '')
			vehicle_road_tax = $('input[name="vehicle_road_tax"]').val();
		if($('input[name="vehicle_service"]').val() !== '')
			vehicle_service = $('input[name="vehicle_service"]').val();
		if($('input[name="fuel"]').val() !== '')
			fuel = $('input[name="fuel"]').val();			
		if($('input[name="car_insurance"]').val() !== '')
			car_insurance = $('input[name="car_insurance"]').val();
		if($('input[name="public_transport"]').val() !== '')
			public_transport = $('input[name="public_transport"]').val();
		if($('input[name="food"]').val() !== '')
			food = $('input[name="food"]').val();			
		if($('input[name="clothing"]').val() !== '')
			clothing = $('input[name="clothing"]').val();
		if($('input[name="school_meals"]').val() !== '')
			school_meals = $('input[name="school_meals"]').val();
		if($('input[name="sports_hobbies"]').val() !== '')
			sports_hobbies = $('input[name="sports_hobbies"]').val();
		if($('input[name="contents_insurance"]').val() !== '')
			contents_insurance = $('input[name="contents_insurance"]').val();
		if($('input[name="hairdressing"]').val() !== '')
			hairdressing = $('input[name="hairdressing"]').val();						
		if($('input[name="contingency"]').val() !== '')
			contingency = $('input[name="contingency"]').val();						
		if($('input[name="other_1"]').val() !== '')
			other_1 = $('input[name="other_1"]').val();
		if($('input[name="other_2"]').val() !== '')
			other_2 = $('input[name="other_2"]').val();
		if($('input[name="other_3"]').val() !== '')
			other_3 = $('input[name="other_3"]').val();																																					
		outgoingTotal = Math.abs(parseFloat(rent_mortgage) + parseFloat(gas) + parseFloat(electric) + parseFloat(phone) + parseFloat(transport) + parseFloat(local_tax) + parseFloat(water) + parseFloat(mobile_phone) + parseFloat(tv_license) + parseFloat(vehicle_road_tax) + parseFloat(vehicle_service) + parseFloat(fuel) + parseFloat(car_insurance) + parseFloat(public_transport) + parseFloat(food) + parseFloat(clothing) + parseFloat(school_meals) + parseFloat(sports_hobbies) + parseFloat(contents_insurance) + parseFloat(hairdressing) + parseFloat(contingency) + parseFloat(other_1) + parseFloat(other_2) + parseFloat(other_3)).toFixed(2);
		
		$('input[name="total_expenditure"]').val(outgoingTotal);
		return outgoingTotal;
	}	
	
	$(document).ready(function() { 
	
		$("#ccj").jCombo("{{ URL::to('Customercreditors/comboselect?filter=ccj:id:ccj') }}",
		{  selected_value : '{{ $row['income']->ccj }}' });	
	
		var incomeTot = incomeTotal();
		var outgoingTot = outgoingTotal();
		var totDiff = parseInt(incomeTot, 10) - parseInt(outgoingTot, 10);
		
		if( totDiff < 0 )
		{
			$('.diff_total').attr('style','color:red;');	
		}
		else
		{
			$('.diff_total').attr('style','color:green;');			
		}		
		
		$('input[name="total_difference"]').val(totDiff);
	
		/*$("#customer_no").jCombo("{{ URL::to('Customerincome/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Customerincome/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });*/

		$("#income_frequency").jCombo("{{ URL::to('Customerincome/comboselect?filter=customer_frequency:freq_id:freq_name') }}",
		{  selected_value : '{{ (!empty($row["income"]->income_frequency) ? $row["income"]->income_frequency : '') }}' });	
		
		$("#outgoing_frequency").jCombo("{{ URL::to('Customerincome/comboselect?filter=customer_frequency:freq_id:freq_name') }}",
		{  selected_value : '{{ $row["outgoing_frequency"] }}' });			
		
		$('input').blur(function() {
			var incomeTot = incomeTotal();
			var outgoingTot = outgoingTotal();
			var totDiff = parseInt(incomeTot, 10) - parseInt(outgoingTot, 10);
			$('input[name="total_difference"]').val(totDiff);
			if( totDiff < 0 )
			{
				$('.diff_total').attr('style','color:red;');	
			}
			else
			{
				$('.diff_total').attr('style','color:green;');			
			}				
		});
		 
	});
	</script>		 