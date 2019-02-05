
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
		<li><a href="{{ URL::to('Customerquotes') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Customerquotes/save/'.SiteHelpers::encryptID($row['quote_no']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Quotes</legend>
									
								  <div class="form-group  " >
									<label for="Quote No" class=" control-label col-md-4 text-left"> Quote No </label>
									<div class="col-md-8">
										@if( empty($row['quotenumber']) )
									  		{{ Form::text('quotenumber', $row['quotenumber'],array('class'=>'form-control', 'placeholder'=>'auto',   )) }} 
									  	@else
									  		{{ Form::text('quotenumber', $row['quotenumber'],array('class'=>'form-control', 'placeholder'=>'',   )) }}
									  	@endif
									 </div> 
								  </div>
								  <input type="hidden" name="quote_no" id="quote_no" value="{{ $row['quote_no'] }}" />			
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  <select name='customer_no_select' rows='5' id='customer_no_select' code='{$customer_no}' 
							class='select2 '    ></select>
										<input type="hidden" id="customer_no" name="customer_no" value="" />
										<!--{{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'C123456789',   )) }}--> 
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>--> 					
								  <input type="hidden" name="user_id" id="user_id" value="{{ $row['user_id'] }}" />	
								  <div class="form-group  " >
									<label for="Amount Borrowed" class=" control-label col-md-4 text-left"> Amount Borrowed </label>
									<div class="col-md-8">
									  {{ Form::text('amount_borrowed', $row['amount_borrowed'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 	
								  <div class="form-group  " >
									<label for="Frequency" class=" control-label col-md-4 text-left"> Frequency </label>
									<div class="col-md-8">
									  <select name='frequency_of_payment' rows='5' id='frequency' code='{$frequency}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Monthly Payment" class=" control-label col-md-4 text-left"> Monthly Payment </label>
									<div class="col-md-8">
									  {{ Form::text('monthly_payment', $row['monthly_payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Interest Payable" class=" control-label col-md-4 text-left"> Interest Payable </label>
									<div class="col-md-8">
									  {{ Form::text('interest_payable', $row['interest_payable'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="Total Paid To Date" class=" control-label col-md-4 text-left"> Total Paid To Date </label>
									<div class="col-md-8">
									  {{ Form::text('total_paid_to_date', $row['total_paid_to_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Early Payment Rebate" class=" control-label col-md-4 text-left"> Early Payment Rebate </label>
									<div class="col-md-8">
									  {{ Form::text('early_payment_rebate', $row['early_payment_rebate'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Early Settlement Balance" class=" control-label col-md-4 text-left"> Early Settlement Balance </label>
									<div class="col-md-8">
									  {{ Form::text('early_settlement_balance', $row['early_settlement_balance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> 					
								  <div class="form-group  " >
									<label for="Total Payable" class=" control-label col-md-4 text-left"> Total Payable </label>
									<div class="col-md-8">
									  {{ Form::text('total_payable', $row['total_payable'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Period" class=" control-label col-md-4 text-left"> Loan Period </label>
									<div class="col-md-8">
									  <select name='loan_period' rows='5' id='loan_period' code='{$loan_period}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Start Date" class=" control-label col-md-4 text-left"> Date of Quote </label>
									<div class="col-md-8">
										@if( empty($row['loan_start_date']) )
									  		{{ Form::text('loan_start_date', date("d/m/Y"),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									  	@else
									  		{{ Form::text('loan_start_date', date("d/m/Y", strtotime($row['loan_start_date'])),array('class'=>'form-control', 'placeholder'=>'',   )) }}									  	
									  	@endif
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="Loan End Date" class=" control-label col-md-4 text-left"> Loan End Date </label>
									<div class="col-md-8">
									  {{ Form::text('loan_end_date', date("d/m/Y", strtotime($row['loan_end_date'])),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Payment" class=" control-label col-md-4 text-left"> First Payment </label>
									<div class="col-md-8">
									  {{ Form::text('first_payment', date("d/m/Y", strtotime($row['first_payment'])),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> 					
								  <div class="form-group  " >
									<label for="Percentage Apr" class=" control-label col-md-4 text-left"> Percentage Apr </label>
									<div class="col-md-8">
									  {{ Form::text('percentage_apr', $row['percentage_apr'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Home Visit" class=" control-label col-md-4 text-left"> Home Visit </label>
									<div class="col-md-8">
									  
					<select name='home_visit' rows='5' id='home_visit'    
					class='select2 form-control '   >
						
							<option  value ='0' 
							@if($row['home_visit'] =='0')
								selected="selected"
							@endif
							>No</option>
							<option  value ='1' 
							@if($row['home_visit'] =='1')
								selected="selected"
							@endif
							>Yes</option>
					</select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="T And C" class=" control-label col-md-4 text-left"> T And C </label>
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
									<label for="Existing Customer" class=" control-label col-md-4 text-left"> Existing Customer </label>
									<div class="col-md-8">
									  
					<select name='existing_customer' rows='5' id='existing_customer'    
					class='select2 form-control '   >
						
							<option  value ='0' 
							@if($row['existing_customer'] =='0')
								selected="selected"
							@endif
							>No</option>
							<option  value ='1' 
							@if($row['existing_customer'] =='1')
								selected="selected"
							@endif
							>Yes</option>
					</select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Email" class=" control-label col-md-4 text-left"> Email </label>
									<div class="col-md-8">
									  {{ Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customerquotes') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
	
		$('#customer_no_select').change(function() {
			$('#customer_no').val($('#customer_no_select option:selected').text());	
			$('#user_id').val($('#customer_no_select option:selected').val());	
		});
		
		$("#customer_no_select").jCombo("{{ URL::to('Customerquotes/comboselect?filter=customer_main:user_id:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Customerquotes/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#loan_period").jCombo("{{ URL::to('Customerquotes/comboselect?filter=loan_period:id:number_of_weeks') }}",
		{  selected_value : '{{ $row["loan_period"] }}' });
		
		$("#frequency").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=frequency:id:freq_desc') }}",
		{  selected_value : '{{ $row["frequency_of_payment"] }}' });		
		 
	});
	</script>		 