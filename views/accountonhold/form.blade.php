
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
		<li><a href="{{ URL::to('accountonhold') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'accountonhold/save/'.SiteHelpers::encryptID($row['account_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Account on hold</legend>
									
								  <div class="form-group  " >
									<label for="Account Id" class=" control-label col-md-4 text-left"> Account Id </label>
									<div class="col-md-8">
									  {{ Form::text('account_id', $row['account_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left"> Account No </label>
									<div class="col-md-8">
									  {{ Form::text('account_no', $row['account_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  {{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Amount Borrowed" class=" control-label col-md-4 text-left"> Amount Borrowed </label>
									<div class="col-md-8">
									  {{ Form::text('amount_borrowed', $row['amount_borrowed'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Payment" class=" control-label col-md-4 text-left"> Payment </label>
									<div class="col-md-8">
									  {{ Form::text('payment', $row['payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Payment Type" class=" control-label col-md-4 text-left"> Payment Type </label>
									<div class="col-md-8">
									  {{ Form::text('payment_type', $row['payment_type'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Interest Payable" class=" control-label col-md-4 text-left"> Interest Payable </label>
									<div class="col-md-8">
									  {{ Form::text('interest_payable', $row['interest_payable'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Paid To Date" class=" control-label col-md-4 text-left"> Total Paid To Date </label>
									<div class="col-md-8">
									  {{ Form::text('total_paid_to_date', $row['total_paid_to_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Last Payment Made" class=" control-label col-md-4 text-left"> Last Payment Made </label>
									<div class="col-md-8">
									  {{ Form::text('last_payment_made', $row['last_payment_made'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Balance" class=" control-label col-md-4 text-left"> Balance </label>
									<div class="col-md-8">
									  {{ Form::text('balance', $row['balance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Payable" class=" control-label col-md-4 text-left"> Total Payable </label>
									<div class="col-md-8">
									  {{ Form::text('total_payable', $row['total_payable'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Period" class=" control-label col-md-4 text-left"> Loan Period </label>
									<div class="col-md-8">
									  {{ Form::text('loan_period', $row['loan_period'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Start Date" class=" control-label col-md-4 text-left"> Loan Start Date </label>
									<div class="col-md-8">
									  {{ Form::text('loan_start_date', $row['loan_start_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan End Date" class=" control-label col-md-4 text-left"> Loan End Date </label>
									<div class="col-md-8">
									  {{ Form::text('loan_end_date', $row['loan_end_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Payment" class=" control-label col-md-4 text-left"> First Payment </label>
									<div class="col-md-8">
									  {{ Form::text('first_payment', $row['first_payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Percentage Apr" class=" control-label col-md-4 text-left"> Percentage Apr </label>
									<div class="col-md-8">
									  {{ Form::text('percentage_apr', $row['percentage_apr'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="T And C" class=" control-label col-md-4 text-left"> T And C </label>
									<div class="col-md-8">
									  {{ Form::text('t_and_c', $row['t_and_c'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Week No" class=" control-label col-md-4 text-left"> Week No </label>
									<div class="col-md-8">
									  {{ Form::text('week_no', $row['week_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Miss Payment" class=" control-label col-md-4 text-left"> No Miss Payment </label>
									<div class="col-md-8">
									  {{ Form::text('no_miss_payment', $row['no_miss_payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reason For Loan" class=" control-label col-md-4 text-left"> Reason For Loan </label>
									<div class="col-md-8">
									  {{ Form::text('reason_for_loan', $row['reason_for_loan'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Period No" class=" control-label col-md-4 text-left"> Period No </label>
									<div class="col-md-8">
									  {{ Form::text('period_no', $row['period_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reason" class=" control-label col-md-4 text-left"> Reason </label>
									<div class="col-md-8">
									  {{ Form::text('reason', $row['reason'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Status" class=" control-label col-md-4 text-left"> Loan Status </label>
									<div class="col-md-8">
									  <select name='loan_status' rows='5' id='loan_status' code='{$loan_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Status Reduced Desc" class=" control-label col-md-4 text-left"> Loan Status Reduced Desc </label>
									<div class="col-md-8">
									  <textarea name='loan_status_reduced_desc' rows='2' id='loan_status_reduced_desc' class='form-control '  
				           >{{ $row['loan_status_reduced_desc'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Arrears" class=" control-label col-md-4 text-left"> Arrears </label>
									<div class="col-md-8">
									  {{ Form::text('arrears', $row['arrears'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Frequency Of Payment" class=" control-label col-md-4 text-left"> Frequency Of Payment </label>
									<div class="col-md-8">
									  {{ Form::text('frequency_of_payment', $row['frequency_of_payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Payment Still Due" class=" control-label col-md-4 text-left"> Total Payment Still Due </label>
									<div class="col-md-8">
									  {{ Form::text('total_payment_still_due', $row['total_payment_still_due'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Next Payment Due Date" class=" control-label col-md-4 text-left"> Next Payment Due Date </label>
									<div class="col-md-8">
									  {{ Form::text('next_payment_due_date', $row['next_payment_due_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Payer Ref" class=" control-label col-md-4 text-left"> Payer Ref </label>
									<div class="col-md-8">
									  {{ Form::text('payer_ref', $row['payer_ref'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Pmt Ref" class=" control-label col-md-4 text-left"> Pmt Ref </label>
									<div class="col-md-8">
									  {{ Form::text('pmt_ref', $row['pmt_ref'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('accountonhold') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#user_id").jCombo("{{ URL::to('accountonhold/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#loan_status").jCombo("{{ URL::to('accountonhold/comboselect?filter=loan_status:id:id') }}",
		{  selected_value : '{{ $row["loan_status"] }}' });
		 
	});
	</script>		 