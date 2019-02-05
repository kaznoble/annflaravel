
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
		<li><a href="{{ URL::to('cardpayment') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'cardpayment/save/'.SiteHelpers::encryptID($row['account_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Cardpayment</legend>
									
							<div class="cash_payment_summary" >
								  <div class="form-group  " >
									<label for="Total arrears" class=" control-label col-md-4 text-left"> Total arrears </label>
									<div class="col-md-8">
									  £{{ Form::text('arrears', $row['arrears'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Number of Missed Payment" class=" control-label col-md-4 text-left"> Number of Missed Payment </label>
									<div class="col-md-8">
									  &nbsp;&nbsp;{{ Form::text('no_miss_payment', $row['no_miss_payment'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Balance" class=" control-label col-md-4 text-left"> Balance </label>
									<div class="col-md-8">
									  £{{ Form::text('balance', $row['balance'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Cash Payment" class=" control-label col-md-4 text-left"> Total Cash Payment </label>
									<div class="col-md-8">
									  £{{ Form::text('payment', $row['payment'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Current Next Payment Due Date" class=" control-label col-md-4 text-left"> Current Next Payment Due Date </label>
									<div class="col-md-8">
									  &nbsp;&nbsp;{{ Form::text('next_payment_due_date', date('d/m/Y', strtotime($row['next_payment_due_date'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div>
							</div>
							
						</fieldset>
						
						<div style="height:20px;" ></div>
						
						<div class="form-group  " >
							<label for="Miss payment to pay" class=" control-label col-md-4 text-left"> How many missed payments would you like to pay? </label>
							<div class="col-md-8">
								&nbsp;&nbsp;{{ Form::text('miss_payment_pay', '0',array('class'=>'form-control', 'placeholder'=>'', 'style'=>'width:60px;' )) }} 
							</div> 
						</div>	
						
						<div class="form-group  " >
							<label for="Miss payment to pay total" class=" control-label col-md-4 text-left"> Total </label>
							<div class="col-md-8">
								£{{ Form::text('miss_payment_pay_total', '0',array('class'=>'form-control', 'placeholder'=>'', 'style'=>'width:60px;',  'readonly'=>'true' )) }} 
							</div> 
						</div>												
						
						<div class="form-group  " >
							<label for="Keep Current Next Payment Due Date" class=" control-label col-md-4 text-left"> Keep Current Next Payment Due Date </label>
							<div class="col-md-8">
								&nbsp;&nbsp;<input type="checkbox" name="keep_next_payment_date" id="keep_next_payment_date" class="" value="" /> ({{ date('d/m/Y', strtotime($row['next_payment_due_date'])) }})
								<input type="hidden" name="hid_keep_payment_date" id="hid_keep_payment_date" value="FALSE" />
							</div> 
						</div>							
						
						<div class="form-group change-next-payment " >
							<label for="Change next payment date" class=" control-label col-md-4 text-left"> Change current next payment due date </label>
							<div class="col-md-8">
								&nbsp;&nbsp;{{ Form::text('change_next_payment_due_date', date('d/m/Y', strtotime($row['next_payment_due_date'])), array('class'=>'form-control datepicker', 'placeholder'=>'', 'style'=>'width:150px;' )) }} 
							</div> 
						</div>						

						<div class="form-group  " >
							<label for="Total paid payment" class=" control-label col-md-4 text-left"> Total cash payment to be made </label>
							<div class="col-md-8">
								£{{ Form::text('total_paid_payment', '0', array('class'=>'form-control', 'placeholder'=>'', 'style'=>'width:60px;' )) }} 
							</div> 
						</div>	
						
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary save-button" >  Make Payment </button>
				<button type="button" onclick="location.href='{{ URL::to('Customeraccounts?search=customer_no:') }}{{ $row['customer_no'] }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				<input type="hidden" name="account_no" id="account_no" value="{{ $row->account_no }}" />
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
	
		$('#keep_next_payment_date').click(function(){
			if($('#keep_next_payment_date').is(':checked'))
			{
				$('input[name="change_next_payment_due_date"]').val($('input[name="next_payment_due_date"]').val());	
				$('#hid_keep_payment_date').val('TRUE');						
				$('input[name="change_next_payment_due_date"]').attr('readonly', true);		
				$('.change-next-payment').hide(200);
			}	
			else
			{
				$('#hid_keep_payment_date').val('FALSE');						
				$('input[name="change_next_payment_due_date"]').attr('readonly', false);		
				$('.change-next-payment').show(200);
			}
		;})
		
		$('input[name="change_next_payment_due_date"]').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true
		});
		
		$('input[name="change_next_payment_due_date"]').on("changeDate", function(e) {
			$('input[name="change_next_payment_due_date"]').val($('input[name="change_next_payment_due_date"]').datepicker('getFormattedDate'));
		});
		
		$('input[name="miss_payment_pay"]').blur(function() {
			var miss_no = $('input[name="miss_payment_pay"]').val();
			var payment = $('input[name="payment"]').val();
			var total = miss_no * payment;
			$('input[name="miss_payment_pay_total"]').val(total);
			$('input[name="total_paid_payment"]').val(total);
		});
		
		$('.save-button').click(function() {
			if( $('input[name="miss_payment_pay_total"]').val() != '0' || $('input[name="total_paid_payment"]').val() != '0' )
			{
				var payoff_arrears = $('input[name="miss_payment_pay_total"]').val();
				var no_of_arrears = $('input[name="miss_payment_pay"]').val();
				var keep_current_date = 0;
				if( $('#keep_next_payment_date').is(':checked') )
				{
					$('input[name="keep_next_payment_date"]').val('1');
				}
				else
				{
					$('input[name="keep_next_payment_date"]').val('0');
				}
			}
			else
			{
				alert('No total value?');
				return false;
			}
		});
		 
	});
	</script>		 