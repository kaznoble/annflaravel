
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
		<li><a href="{{ URL::to('Customeraccounts') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Customeraccounts/save/'.SiteHelpers::encryptID($row['account_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Accounts</legend>
									
								  <!--<div class="form-group  " >
									<label for="Account Id" class=" control-label col-md-4 text-left"> Account Id </label>
									<div class="col-md-8">
									  {{ Form::text('account_id', $row['account_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>-->
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left {{ (!empty($row['account_no']) ? 'label_bold' : '') }}"> Account No </label>
									<div class="col-md-8">
										@if( !empty($row['account_no']) )
											{{ Form::text('account_no', $row['account_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }}
										@else
											<input class="form-control" type="text" value="" name="account_no" placeholder="auto" disabled="disabled">
										@endif
									  
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left {{ (!empty($row['customer_no']) ? 'label_bold' : '') }}"> Customer No </label>
									<div class="col-md-8">
										<input class="form-control" type="text" value="{{ (!empty($row['customer_no']) ? $row['customer_no'] : $cu) }}" name="customer_no" readonly="true" placeholder="{{ (!empty($row['customer_no']) ? $row['customer_no'] : $cu) }}">
										<input type="hidden" name="user_id" value="{{ (!empty($row['user_id']) ? $row['user_id'] : $userID) }}" />
									  <!--<select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' 
							class='select2 '    ></select>-->
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>--> 					
								  <div class="form-group  " >
									<label for="Amount Borrowed" class=" control-label col-md-4 text-left"> Amount Borrowed </label>
									<div class="col-md-8">
									  {{ Form::text('amount_borrowed', $row['amount_borrowed'],array('class'=>'form-control', 'placeholder'=>'', 'id'=>'amount_borrowed'   )) }} 
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
									<label for="Loan Period" class=" control-label col-md-4 text-left"> Loan Period </label>
									<div class="col-md-8">
									  <select name='loan_period' rows='5' id='loan_period' code='{$loan_period}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 													  									  			
								  <div class="form-group  " >
									<label for="Monthly Payment" class=" control-label col-md-4 text-left"> Payment </label>
									<div class="col-md-8">
									  {{ Form::text('payment', $row['payment'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Interest Payable" class=" control-label col-md-4 text-left"> Interest Payable </label>
									<div class="col-md-8">
									  {{ Form::text('interest_payable', $row['interest_payable'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Paid To Date" class=" control-label col-md-4 text-left {{ (!empty($row['total_paid_to_date']) ? 'label_bold' : '') }}"> Total Paid To Date </label>
									<div class="col-md-8">
										@if( !empty($row['total_paid_to_date']) )
									  		{{ Form::text('total_paid_to_date', (!empty($row['total_paid_to_date']) ? $row['total_paid_to_date'] : '0'),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true' )) }} 
									  	@else
									  		{{ Form::text('total_paid_to_date', (!empty($row['total_paid_to_date']) ? $row['total_paid_to_date'] : '0'),array('class'=>'form-control', 'placeholder'=>'', )) }} 
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Last Payment Made" class=" control-label col-md-4 text-left"> Last Payment Made </label>
									<div class="col-md-8">
									@if( !empty($row['last_payment_made']) && $row['last_payment_made'] != '0000-00-00'  )
										{{ Form::text('last_payment_made', date('d/m/Y', strtotime($row['last_payment_made'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 									
									@else
									  	{{ Form::text('last_payment_made', '',array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }}
									@endif
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Last Payment Made" class=" control-label col-md-4 text-left"> Balance </label>
									<div class="col-md-8">
									  {{ Form::text('balance', $row['balance'], array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 			
								  <div class="form-group  " >
									<label for="Early Payment Rebate" class=" control-label col-md-4 text-left"> Early Payment Rebate </label>
									<div class="col-md-8">
									  {{ Form::text('early_payment_rebate', $row['early_payment_rebate'],array('class'=>'form-control', 'placeholder'=>'','readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Early Settlement Balance" class=" control-label col-md-4 text-left"> Early Settlement Balance </label>
									<div class="col-md-8">
									  {{ Form::text('early_settlement_balance', $row['early_settlement_balance'],array('class'=>'form-control', 'placeholder'=>'','readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Payable" class=" control-label col-md-4 text-left"> Total Payable </label>
									<div class="col-md-8">
									  {{ Form::text('total_payable', $row['total_payable'],array('class'=>'form-control', 'placeholder'=>'','readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Start Date" class=" control-label col-md-4 text-left {{ (!empty($row['loan_start_date']) ? 'label_bold' : '') }}"> Loan Start Date </label>
									<div class="col-md-8">
										@if( !empty($row['loan_start_date']) )
									  		{{ Form::text('loan_start_date', date('d/m/Y', strtotime($row['loan_start_date'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true' )) }}
									  	@else
									  		{{ Form::text('loan_start_date', date('d/m/Y'),array('class'=>'form-control', 'placeholder'=>'', 'readonly' => 'true' )) }}
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan End Date" class=" control-label col-md-4 text-left"> Loan End Date </label>
									<div class="col-md-8">
									  {{ Form::text('loan_end_date', date('d/m/Y', strtotime($row['loan_end_date'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true' )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Payment" class=" control-label col-md-4 text-left {{ (!empty($row['first_payment']) ? 'label_bold' : '') }}"> First Payment </label>
									<div class="col-md-8">
									  		{{ Form::text('first_payment', date('d/m/Y', strtotime($row['first_payment'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly' => 'true' )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Percentage Apr" class=" control-label col-md-4 text-left"> APR </label>
									<div class="col-md-8">
									  {{ Form::text('percentage_apr', $row['percentage_apr'].'%',array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Next Payment Due" class=" control-label col-md-4 text-left"> Next Payment Due </label>
									<div class="col-md-8">
									  {{ Form::text('next_payment_due_date', date('d/m/Y', strtotime($row['next_payment_due_date'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 													  
								  <div class="form-group  " >
									<label for="T And C" class=" control-label col-md-4 text-left {{ (!empty($row['t_and_c']) ? 'label_bold' : '') }}"> Terms & Conditions </label>
									<div class="col-md-8">
										<select name='t_and_c' rows='5' id='t_and_c' code='{$t_and_c}' 
							class='select2' {{ (!empty($row['t_and_c']) ? 'disabled="disabled"' : '') }} ></select>
									  <!--{{ Form::text('t_and_c', $row['t_and_c'],array('class'=>'form-control', 'placeholder'=>'',   )) }}-->
									  	@if( !empty($row['t_and_c']) )
									  		<input type='hidden' name="t_and_c" value="{{ $row['t_and_c'] }}" />
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Week No" class=" control-label col-md-4 text-left {{ (!empty($row['week_no']) || $row['week_no'] == 0 ? 'label_bold' : '') }}"> Period Number </label>
									<div class="col-md-8">
										@if( !empty($row['week_no']) || $row['week_no'] == 0 )
									  		{{ Form::text('week_no', ( !empty($row['week_no']) ? $row['week_no'] : 0 ),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true' )) }}
									  	@else
									  		{{ Form::text('week_no', $row['week_no'],array('class'=>'form-control', 'placeholder'=>'', )) }} 
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Miss Payment" class=" control-label col-md-4 text-left"> Number of Missed Payments </label>
									<div class="col-md-8">
									  {{ Form::text('no_miss_payment', $row['no_miss_payment'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Period No" class=" control-label col-md-4 text-left"> Period No </label>
									<div class="col-md-8">
									  {{ Form::text('period_no', $row['period_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
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
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customeraccounts') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				<input type="hidden" name="account_id" value="{{ $row['account_id'] }}" />
				</div>	  
		
			  </div> 
		 {{ Form::close() }}
		 						 
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
     
	$(document).ready(function() { 
		
		$('#frequency').change(function(e) {					
			var frequency = $('#frequency').val();
			if(frequency === 'week')
			{
				$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period:number_of_weeks:number_of_weeks') }}",
				{  selected_value : '{{ $row["loan_period"] }}' });							
			}
			if(frequency === 'month')
			{
				$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period_month:number_of_months:number_of_months') }}",
				{  selected_value : '{{ $row["loan_period"] }}' });
			}
		});	
		$('#loan_period').change(function(e) {					
			var frequency = $('#frequency').val();		
			if( $('input[name="account_no"]').val() == '' )
				loanCalculate(frequency);
		});			
		
		function loanCalculate(frequency) {
			var startLoanDate = $("input[name='loan_start_date']").val();
			var firstPaymentDate = $("input[name='first_payment']").val();;			
			var datePart = startLoanDate.match(/\d+/g),
			year = datePart[2].substring(2), // get only two digits
			month = datePart[1], day = datePart[0];
			month = eval(month) + 1;
			startLoanDate = '20'+year+'/'+month+'/'+day;			
			startLoanDate = new Date(startLoanDate);
			endLoanDate = '20'+year+'/'+month+'/'+day;			
			endLoanDate = new Date(endLoanDate);
			var loan_period = $('#loan_period option:selected').text();
			var loan_week_period = loan_period * 7;
			var loan_monthly_period = $('#loan_period option:selected').text();
			var loan_times = 0;						
			if(frequency === 'month')
			{
				//alert('month');
				var firstPaymentDate = new Date(startLoanDate.setMonth(startLoanDate.getMonth()+1));							
				//var endLoanDate = new Date(endLoanDate.setDate(firstPaymentDate.getDate()+loan_monthly_period));								
				var endLoanDate = new Date(startLoanDate.setMonth(startLoanDate.getMonth()+eval(loan_monthly_period)));
			}
			if(frequency === 'week')
			{
				var firstPaymentDate = new Date(startLoanDate.setDate(startLoanDate.getDate()+7));
				var endLoanDate = new Date(endLoanDate.setDate(firstPaymentDate.getDate()+loan_week_period));
			}
			//endLoanDate = endLoanDate.toLocaleString(endLoanDate);		
			//firstPaymentDate = firstPaymentDate.toLocaleString(firstPaymentDate);
			$('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + endLoanDate.getMonth() + '/' + endLoanDate.getFullYear());
			$('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + firstPaymentDate.getMonth() + '/' + firstPaymentDate.getFullYear());
			$('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + firstPaymentDate.getMonth() + '/' + firstPaymentDate.getFullYear());			
			
			/*e.preventDefault();*/
			// WHERE sys_string.id IS NOT NULL
			var periodLoanVal = $('#loan_period').val();
			var frequencyVal = $('#frequency').val();
			var interest_payable = 0;
			var amount_borrow = $('#amount_borrowed').val();
			//alert(periodLoanVal);
			$.get('../../getapr', {periodLoanVal: periodLoanVal, frequencyVal: frequencyVal}, function(data){
				//alert(data);
				var aprArray = data.split(',');
				$('input[name="percentage_apr"]').val(aprArray[1]+'%');
				$('input[name="percentage_apr"]').attr('id',aprArray[1]);
				interest_payable = (aprArray[0] / 100) * $('#amount_borrowed').val();
				$('input[name="interest_payable"]').val(parseFloat(interest_payable).toFixed(2));
				$('input[name="total_payable"], input[name="balance"]').val(parseFloat(eval(interest_payable,10) + eval(amount_borrow,10)).toFixed(2));
				$('input[name="payment"]').val(parseFloat(eval($('input[name="total_payable"]').val())/eval(loan_period)).toFixed(2));
				
				/* Rebate calculate
				step 1 - ((1+'Customer accounts'!$I$19)^(1/12)-1)
				*/
				CalcRebate();
			
			});
		
		}
		
		$("#customer_no").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period:number_of_weeks:number_of_weeks') }}",
		{  selected_value : '{{ $row["loan_period"] }}' });
		
		$("#frequency").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=frequency:freq_short:freq_desc') }}",
		{  selected_value : '{{ $row["frequency_of_payment"] }}' });		
		
		$("#t_and_c").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=yesno:id:desc') }}",
		{  selected_value : '{{ $row["t_and_c"] }}' });		
		
		$("#loan_status").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_status:id:description') }}",
		{  selected_value : '{{ $row["loan_status"] }}' });
				 
	});
	
	function CalcRebate() {

		setPPA(12);

		var p=getVal($('#amount_borrowed').val());
		var i=getVal($('input[name="payment"]').val());
		var a=getVal($('input[name="payment"]').val());
		var n=Math.floor($('#loan_period option:selected').text());
		var f=getVal($('input[name="payment"]').val());
		var st=Math.floor(getVal($('input[name="week_no"]').val()));

		//calculate tap, tcc and paid ...
		var tap=i+a*n+f;
		var tcc=tap-p;
		var paid=i+a*st;  if (st==n) paid=tap;

		//calculate weighting ...
		var w=0;
		if (m==12) {w=2; if (n>60) w=1}
		if (m==52) {w=8; if (n>260) w=4}

		//calculate rebate and settlement ...
		var nyd=n-(st+w);
		var frc=(a*nyd*(nyd+1)/2+f*nyd)/(a*n*(n+1)/2+f*n);
		if (f>=p) frc=nyd/n;
		var r=tcc*frc;  if (r<0) r=0;
	  	var s=tap-paid-r;

		//alert(TwoDP(r));
		$('input[name="early_payment_rebate"]').val(TwoDP(r));
		//alert(TwoDP(s));
		$('input[name="early_settlement_balance"]').val(TwoDP(s));		
	}

	function TwoDP(num) {
	  if (isNaN(num)) num="0"
	  num="$"+Math.round(100*num)/100
	  if (num.indexOf(".")==-1) num+=".00"
	  if (num.indexOf(".")==num.length-2) num+="0"
	  return num.substring(1,num.length)
	}

	function getVal(x)  {
	  x=parseFloat(x)
	  if (isNaN(x)) x=0
	  //alert(x);
	  return x
	}

	function setPPA(x)  {
	  m=x
	}		

	</script>		 