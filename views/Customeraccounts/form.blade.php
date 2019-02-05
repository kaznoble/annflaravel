<div class="loader loader-image"><img src="/images/Eclipse-1s-200px.gif" /></div>

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
			{{ Form::open(array('url'=>'Customeraccounts/save/'.SiteHelpers::encryptID($row['account_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
                        <div class="col-md-12" >
                            <button type="button" id="butt_reduce_payment" class="btn btn-primary ">Reduce Payment</button>
                            <div style="height: 20px;" ></div>
                            <fieldset><legend> Add/Edit Customer Accounts</legend>
                        </div>
                        <div class="col-xs-6">
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
								{{ Form::text('account_no', $row['account_no'],array('class'=>'input-sm', 'placeholder'=>''   )) }}
							@else
								<input class="input-sm" type="text" value="" name="account_no" placeholder="auto" disabled="disabled">
							@endif

						</div>
					</div>
					<div class="form-group  " >
						<label for="Customer No" class=" control-label col-md-4 text-left {{ (!empty($row['customer_no']) ? 'label_bold' : '') }}"> Customer No </label>
						<div class="col-md-8">
							<input class="input-sm" type="text" value="{{ (!empty($row['customer_no']) ? $row['customer_no'] : $cu) }}" name="customer_no" readonly="true" placeholder="{{ (!empty($row['customer_no']) ? $row['customer_no'] : $cu) }}">
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
							£{{ Form::text('amount_borrowed', $row['amount_borrowed'],array('class'=>'input-sm', 'placeholder'=>'', 'id'=>'amount_borrowed'   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Frequency" class=" control-label col-md-4 text-left"> Frequency <span class="red_asteriod" >*</span></label>
						<div class="col-md-8">
							<select name='frequency_of_payment' rows='5' id='frequency' code='{$frequency}'
									class='select2 '    ></select>
						</div>
					</div>
					<div class="form-group  " >
						<label for="Loan Period" class=" control-label col-md-4 text-left"> Loan Period <span class="red_asteriod" >*</span></label>
						<div class="col-md-8">
							<select name='loan_period' rows='5' id='loan_period' code='{$loan_period}'
									class='select2 '    ></select>   {{ ($row['frequency_of_payment'] == '4' && $row['loan_period'] == '30' ? '' : '') }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Round Number" class=" control-label col-md-4 text-left"> Round Number </label>
						<div class="col-md-8">
							{{ Form::text('round_number', (!empty($rd_number) ? $rd_number : 0),array('class'=>'input-sm', 'placeholder'=>'', 'readonly'=>true   )) }}
						</div>
					</div>					

					<div class="form-group  " >
						<label for="Payment Type" class=" control-label col-md-4 text-left"> Payment Type <span class="red_asteriod" >*</span></label>
						<div class="col-md-8">
							<select name='payment_type' rows='5' id='payment_type' code='{$payment_type}'
									class='select2 '  >
								<option value="Auto " @if($row['payment_type'] == "Auto") selected="selected" @endif >Auto Payment</option>
								<option value="Cash " @if($row['payment_type'] == "Cash") selected="selected" @endif >Cash Payment</option>
							</select>
						</div>
					</div>


					<div class="form-group  " >
						<label for="Monthly Payment" class=" control-label col-md-4 text-left"> Payment </label>
						<div class="col-md-8">
							£{{ Form::text('payment', $row['payment'],array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Interest Payable" class=" control-label col-md-4 text-left"> Interest Payable </label>
						<div class="col-md-8">
							£{{ Form::text('interest_payable', $row['interest_payable'],array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Total Paid To Date" class=" control-label col-md-4 text-left {{ (!empty($row['total_paid_to_date']) ? 'label_bold' : '') }}"> Total Paid To Date </label>
						<div class="col-md-8">
							@if( !empty($row['total_paid_to_date']) )
								£{{ Form::text('total_paid_to_date', (!empty($row['total_paid_to_date']) ? $row['total_paid_to_date'] : '0'),array('class'=>'input-sm', 'placeholder'=>'' )) }}
							@else
								£{{ Form::text('total_paid_to_date', (!empty($row['total_paid_to_date']) ? $row['total_paid_to_date'] : '0'),array('class'=>'input-sm', 'placeholder'=>'', )) }}
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="Last Payment Made" class=" control-label col-md-4 text-left"> Last Payment Made </label>
						<div class="col-md-8">
						@if( !empty($row['last_payment_made']) && $row['last_payment_made'] != '0000-00-00' && $row['last_payment_made'] != '1970-01-01'  )
							{{ Form::text('last_payment_made', date('d/m/Y', strtotime($row['last_payment_made'])),array('class'=>'input-sm', 'placeholder'=>''   )) }}
						@else
							<!--{{ Form::text('last_payment_made', '0000-00-00', array('class'=>'form-control', 'placeholder'=>'0000-00-00', 'readonly'=>'true' )) }}-->
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="Last Payment Made" class=" control-label col-md-4 text-left"> Balance </label>
						<div class="col-md-8">
							£{{ Form::text('balance', $row['balance'], array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Early Payment Rebate" class=" control-label col-md-4 text-left"> Early Payment Rebate </label>
						<div class="col-md-8">
							£{{ Form::text('early_payment_rebate', $row['early_payment_rebate'],array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Early Settlement Balance" class=" control-label col-md-4 text-left"> Early Settlement Balance </label>
						<div class="col-md-8">
							£{{ Form::text('early_settlement_balance', $row['early_settlement_balance'],array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Total Payable" class=" control-label col-md-4 text-left"> Total Payable </label>
						<div class="col-md-8">
							£{{ Form::text('total_payable', $row['total_payable'],array('class'=>'input-sm', 'placeholder'=>'','readonly'=>'true'   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Loan Start Date" class=" control-label col-md-4 text-left {{ (!empty($row['loan_start_date']) ? 'label_bold' : '') }}"> Loan Start Date </label>
						<div class="col-md-8">
							@if( !empty($row['loan_start_date']) )
								<!--{{ Form::text('loan_start_date', date('d/m/Y', strtotime($row['loan_start_date'])),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true' )) }}-->
								{{ Form::text('loan_start_date', date('d/m/Y', strtotime($row['loan_start_date'])),array('class'=>'input-sm', 'placeholder'=>'' )) }}							
							@else
								{{ Form::text('loan_start_date', date('d/m/Y'),array('class'=>'input-sm ', 'placeholder'=>'', 'readonly'=>'true' )) }}
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="Loan End Date" class=" control-label col-md-4 text-left"> Loan End Date </label>
						<div class="col-md-8">
							{{ Form::text('loan_end_date', date('d/m/Y', strtotime($row['loan_end_date'])),array('class'=>'input-sm', 'placeholder'=>'' )) }}
						</div>
					</div>
				</fieldset>
			</div>
                        
                        <div class="col-xs-6">
                            <fieldset>
					<div class="form-group  " >
						<label for="First Payment" class=" control-label col-md-4 text-left {{ (!empty($row['first_payment']) ? 'label_bold' : '') }}"> First Payment </label>
						<div class="col-md-8">
							@if( !empty($row['first_payment']) )
								{{ Form::text('first_payment', date('d/m/Y', strtotime($row['first_payment'])),array('class'=>'input-sm datepicker', 'placeholder'=>'' )) }}
							@else
								{{ Form::text('first_payment', date('d/m/Y'),array('class'=>'input-sm ', 'placeholder'=>'', 'readonly'=>'true' )) }}								
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="Percentage Apr" class=" control-label col-md-4 text-left"> APR </label>
						<div class="col-md-8">
							{{ Form::text('percentage_apr', $row['percentage_apr'].'',array('class'=>'input-sm', 'placeholder'=>'%'   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Next Payment Due" class=" control-label col-md-4 text-left"> Next Payment Due </label>
						<div class="col-md-8">
							{{ Form::text('next_payment_due_date', date('d/m/Y', strtotime($row['next_payment_due_date'])),array('class'=>'input-sm datepicker', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="T And C" class=" control-label col-md-4 text-left {{ (!empty($row['t_and_c']) ? 'label_bold' : '') }}"> Terms & Conditions <span class="red_asteriod" >*</span></label>
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
								{{ Form::text('week_no', ( !empty($row['week_no']) ? $row['week_no'] : 0 ),array('class'=>'input-sm', 'placeholder'=>'' )) }}
							@else
								{{ Form::text('week_no', $row['week_no'],array('class'=>'input-sm', 'placeholder'=>'', )) }}
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="No Miss Payment" class=" control-label col-md-4 text-left"> Number of Missed Payments </label>
						<div class="col-md-8">
							{{ Form::text('no_miss_payment', (!empty($row['no_miss_payment']) ? $row['no_miss_payment'] : '0'),array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Arrears" class=" control-label col-md-4 text-left"> Arrears </label>
						<div class="col-md-8">
							{{ Form::text('arrears', (!empty($row['arrears']) ? $row['arrears'] : '0'),array('class'=>'input-sm', 'placeholder'=>''   )) }}
						</div>
					</div>
				<!--<div class="form-group  " >
									<label for="Period No" class=" control-label col-md-4 text-left"> Period No </label>
									<div class="col-md-8">
									  {{ Form::text('period_no', $row['period_no'],array('class'=>'form-control', 'placeholder'=>''   )) }}
						</div>
                     </div>-->
					<div class="form-group  " >
						<label for="Reason for loan" class=" control-label col-md-4 text-left {{ (!empty($row['reason_for_loan']) ? '' : '') }}"> Reason for Loan <span class="red_asteriod" >*</span></label>
						<div class="col-md-8">
							<select name='reason_for_loan' rows='5' id='reason_for_loan' code='{$reason_for_loan}'
									class='select2' ></select>
						<!--{{ Form::text('t_and_c', $row['t_and_c'],array('class'=>'form-control', 'placeholder'=>'',   )) }}-->
						@if( !empty($row['reason_for_loan']) )
							<!--<input type='hidden' name="reason_for_loan" value="{{ $row['reason_for_loan'] }}" />-->
							@endif
						</div>
					</div>
					<div class="form-group  " >
						<label for="Loan Status" class=" control-label col-md-4 text-left"> Loan Status <span class="red_asteriod" >*</span></label>
						<div class="col-md-8">
							<select name='loan_status' rows='5' id='loan_status' code='{$loan_status}'
									class='select2 '    ></select>
						</div>
					</div>
					<div class="form-group div_loan_status_reduced " style='display:none;' >
						<label for="Loan Status Reduced" class=" control-label col-md-4 text-left"> Loan Status Reduced Reason </label>
						<div class="col-md-8">
							{{ Form::textarea('loan_status_reduced_desc', $row['loan_status_reduced_desc'],array('class'=>'input-sm', 'placeholder'=>'',   )) }}
						</div>
					</div>
					<div class="form-group  " >
						<label for="Arrears Letter No" class=" control-label col-md-4 text-left"> Arrears Letter No.</label>
						<div class="col-md-8">
							<select name='arrears_letter' rows='5' id='arrears_letter' code='{$arrears_letter}'
									class='select2 '    ></select>
						</div>
					</div>	
					<div class="form-group  " >
						<label for="Letter Sent" class=" control-label col-md-4 text-left"> Letter Sent?</label>
						<div class="col-md-8">
                                                        {{--*/ $lettersentstatus = SiteHelpers::lettersent($row['account_no'], $row['arrears_letter']) /*--}}
                                                        {{ Form::text('lettersent', $lettersentstatus, array('class'=>'input-sm','readonly'=>'1')) }}
						</div>
					</div>                                
                                        <div class="form-group  " >
						<label for="Reason" class=" control-label col-md-4 text-left"> Comments </label>
						<div class="col-md-8">
							{{ Form::textarea('reason', $row['reason'],array('class'=>'input-sm', 'placeholder'=>'',   )) }}
						</div>
					</div>
				</fieldset>                            
                            
                        </div>


			<div style="clear:both"></div>

			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary btn-submit ">  {{ Lang::get('core.sb_save') }} </button>
					<button type="button" onclick="location.href='{{ URL::to('Customeraccounts?search=customer_no:') . (!empty($row['customer_no']) ? $row['customer_no'] : $cu) }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
					<input type="hidden" name="account_id" value="{{ $row['account_id'] }}" />
				<!--<input type="hidden" name="arrears" value="{{ $row['arrears'] }}" />-->
				</div>

			</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
		
		var account_id = $('input[name=account_id]').val();
		if(account_id == '')
		{
			$('.btn-submit').click(	function() {
				var dateString = $('input[name=loan_start_date]').val();
				var minSplit = [];
				minSplit = dateString.split("/");
				var dateString = (minSplit[2]+"-"+minSplit[1]+"-"+minSplit[0]);
				var myDate = new Date(dateString);
				var today = new Date();
				today = today.setHours(0,0,0,0);
				//today = new Date(today.getYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate());
				if ( myDate < today ) { 
					alert('You cannot enter a Loan Start Date in the past.');
					return false;
				}
				return true;
			});
		}

        $('input[name="first_payment"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
        $('input[name="next_payment_due_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
		
		$('input[name="next_payment_due_date"]').on('change', function(){
			var time = $(this).val();
			var date = time.split(' ')[0].split('/');
			var dateFull = new Date(date[2], date[1], date[0]);
			var dateString = dateFull.getFullYear() + '-' + dateFull.getMonth() + '-' + dateFull.getDate();
			
			var date = new Date(dateString);
			var nowdate = new Date();
			nowdate.setDate(nowdate.getDate() - 1);
			if (date <= nowdate){
				alert('You cannot set the date to a date in the past, please check and try again');
				$('input[name="next_payment_due_date"]').attr('style','border-color:red;');
				$('input[name="next_payment_due_date"]').datepicker('update','');
				$(this).val('');
				return false;
			}
			else
			{
				$('input[name="next_payment_due_date"]').attr('style','border-color:#DDDDDD;');				
			}
		});		

        $('#frequency').change(function(e) {
            var frequency = $('#frequency').val();
            if(frequency === '1')
            {
                //$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period:number_of_weeks:number_of_weeks') }}",
                //    {  selected_value : '{{ $row["loan_period"] }}' });
				var toAppend = '<option value="">-- Please Select --</option>';
				$.each({{ $nonfourweekloanperiod }},function(i,o){
					var selected = '';
					if( '{{$row["loan_period"] }}' == o.number_of_weeks )
						selected = 'SELECTED';
					toAppend += '<option value="'+o.number_of_weeks+'" '+selected+' >'+o.number_of_weeks+'</option>';
				});							
				$('#loan_period').html(toAppend);  						
            }
            if(frequency === '2')
            {
                $("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period_month:number_of_months:number_of_months') }}",
                    {  selected_value : '{{ $row["loan_period"] }}' });
            }
            if(frequency === '3')
            {
                //$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period:number_of_weeks:number_of_weeks') }}",
                //    {  selected_value : '{{ $row["loan_period"] }}' });
				var toAppend = '<option value="">-- Please Select --</option>';
				$.each({{ $nonfourweekloanperiod }},function(i,o){
					var selected = '';
					if( '{{$row["loan_period"] }}' == o.number_of_weeks )
						selected = 'SELECTED';
					toAppend += '<option value="'+o.number_of_weeks+'" '+selected+' >'+o.number_of_weeks+'</option>';
				});							
				$('#loan_period').html(toAppend);  
            }
            if(frequency === '4')
            {
                //$("#loan_period").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_period:number_of_weeks:number_of_weeks') }}",
                //    {  selected_value : '{{ $row["loan_period"] }}' });
				var toAppend = '<option value="">-- Please Select --</option>';	
				var is30 = true;
				if('{{$row["loan_period"]}}' == '30')
					is30 = false;
				if(is30)
				{
					$.each({{ $fourweekloanperiod }},function(i,o){
						var selected = '';
						if( '{{$row["loan_period"] }}' == o.number_of_weeks )
							selected = 'SELECTED';
						toAppend += '<option value="'+o.number_of_weeks+'" ' + selected + ' >'+o.number_of_weeks+'</option>';
					});							
				}
				else
				{
					$.each({{ $nonfourweekloanperiod }},function(i,o){
						var selected = '';
						if( '{{$row["loan_period"] }}' == o.number_of_weeks )
							selected = 'SELECTED';
						toAppend += '<option value="'+o.number_of_weeks+'" ' + selected + ' >'+o.number_of_weeks+'</option>';
					});											
				}
				$('#loan_period').html(toAppend); 				
            }
        });

        $('input[name="loan_start_date"]').on("changeDate", function(e) {
            $('input[name="loan_start_date"]').datepicker('update',$('input[name="loan_start_date"]').val());
            $('input[name="loan_start_date"]').datepicker('hide');
            var frequency = $('#frequency').val();
            if(frequency === '1')
                frequency = 'week';
            if(frequency === '2')
                frequency = 'month';
            if(frequency === '3')
                frequency = 'two week';
            if(frequency === '4')
                frequency = 'four week';
            loanCalculate(frequency, false);
        });

        $('input[name="first_payment"]').change(function(e) {
            var frequency = $('#frequency').val();
            if(frequency === '1')
                frequency = 'week';
            if(frequency === '2')
                frequency = 'month';
            if(frequency === '3')
                frequency = 'two week';
            if(frequency === '4')
                frequency = 'four week';
            loanCalculate(frequency, true);
        });

        $('#loan_period').change(function(e) {
            var frequency = $('#frequency').val();
            if(frequency === '1')
                frequency = 'week';
            if(frequency === '2')
                frequency = 'month';
            if(frequency === '3')
                frequency = 'two week';
            if(frequency === '4')
                frequency = 'four week';
            if( $('input[name="account_no"]').val() == '' )
                loanCalculate(frequency, false);
        });

        $('#loan_status').change(function() {
            var loan_status = $('#loan_status').val();
            if(loan_status == 7)
            {
                $('.div_loan_status_reduced').show();
            }
            else
            {
                $('.div_loan_status_reduced').hide();
            }
        });

        $('#butt_reduce_payment').click(function(e) {
            e.preventDefault();
            if(window.confirm("Are you sure?")) {
                var loanPeriod = document.getElementById('loan_period');
                loanPeriod.selectedIndex = 4;
                $('#loan_period').addClass('input_background_alert');
                var loanStatus = document.getElementById('loan_status');
                loanStatus.selectedIndex = 7;
                $('#loan_status').addClass('input_background_alert');
                $('input[name=payment]').val('0');
                $('input[name=payment]').addClass('input_background_alert');
                $('input[name=loan_end_date]').addClass('input_background_alert');
                $('input[name=next_payment_due_date]').addClass('input_background_alert');
                $('input[name=week_no]').val('0');
                $('input[name=week_no]').addClass('input_background_alert');
                $('input[name=loan_status_reduced_desc]').addClass('input_background_alert');
                $('.div_loan_status_reduced').show();
            }
            else {
                //alert('No');
            }
        });

        function loanCalculate(frequency,scheduleEdit) {
            var startLoanDate = $("input[name='loan_start_date']").val();
            var datePart = startLoanDate.match(/\d+/g),
                year = datePart[2].substring(2), // get only two digits
                month = datePart[1], day = datePart[0];
            month = eval(month);
            startLoanDate = '20'+year+'/'+month+'/'+day;

            var firstPaymentDate = $("input[name='first_payment']").val();
            var getfirstPaymentDate = $("input[name='first_payment']").val();
            var datePart = getfirstPaymentDate.match(/\d+/g),
                year = datePart[2].substring(2), // get only two digits
                month = datePart[1], day = datePart[0];
            month = eval(month);
            getfirstPaymentDate = '20'+year+'/'+month+'/'+day;
			
            firstStartLoanDate = new Date(startLoanDate);
            startLoanDate = new Date(startLoanDate);
            getfirstPaymentDate = new Date(getfirstPaymentDate);
            endLoanDate = '20'+year+'/'+month+'/'+day;
            endLoanDate = new Date(endLoanDate);
            var loan_period = $('#loan_period option:selected').text();
            var loan_week_period = loan_period * 7;
            var loan_two_week_period = loan_period * 14;
            var loan_four_week_period = loan_period * 28;
            var loan_monthly_period = $('#loan_period option:selected').text();
            var loan_times = 0;

            var endLoanMonth = endLoanDate.getMonth();
            if(endLoanMonth == 0 || firstPaymentDate == 0)
            {
                //endLoanMonth = 12;
                //firstPaymentDate = 12;
            }

            if(frequency === 'month')
            {
                if( scheduleEdit === true )
                {
                    //$('input[name="loan_start_date"]').datepicker('update',startLoanDate.getDate() + '/' + eval(startLoanDate.getMonth()+1) + '/' + startLoanDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').val(getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').datepicker('update',getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    var endLoanDate = new Date(getfirstPaymentDate.setMonth(eval(getfirstPaymentDate.getMonth())+eval(loan_monthly_period)+1));
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()) + '/' + endLoanDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('hide');
                }
                else
                {
                    //alert('month');
                    var firstPaymentDate = new Date(firstStartLoanDate.setMonth(eval(firstStartLoanDate.getMonth())+1));
                    var endLoanDate = new Date(startLoanDate.setMonth(eval(startLoanDate.getMonth())+eval(loan_monthly_period)+1));
                    $('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="next_payment_due_date"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                }
            }
            if(frequency === 'week')
            {
                if( scheduleEdit === true)
                {
                    //$('input[name="loan_start_date"]').datepicker('update',startLoanDate.getDate() + '/' + eval(startLoanDate.getMonth()+1) + '/' + startLoanDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').val(getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').datepicker('update', getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    var endLoanDate = new Date(endLoanDate.setDate(eval(getfirstPaymentDate.getDate()+loan_week_period)));
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('hide');
                }
                else
                {
                    var firstPaymentDate = new Date(startLoanDate.setDate(startLoanDate.getDate()+7));				
                    //var endLoanDate = new Date(endLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));
                    var endLoanDate = new Date(startLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));
                    $('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());	
                    $('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="next_payment_due_date"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                }
            }
            if(frequency === 'two week')
            {
                //alert('two week');
                if( scheduleEdit === true)
                {
                    //$('input[name="loan_start_date"]').datepicker('update',startLoanDate.getDate() + '/' + eval(startLoanDate.getMonth()+1) + '/' + startLoanDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').val(getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').datepicker('update', getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    var endLoanDate = new Date(endLoanDate.setDate(eval(getfirstPaymentDate.getDate()+loan_week_period)));
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('hide');
                }
                else
                {
                    var firstPaymentDate = new Date(startLoanDate.setDate(startLoanDate.getDate()+14));
                    //var endLoanDate = new Date(endLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));
                    var endLoanDate = new Date(startLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));					
                    $('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="next_payment_due_date"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                }
            }
            if(frequency === 'four week')
            {
                //alert('four week');
                if( scheduleEdit === true)
                {
                    //$('input[name="loan_start_date"]').datepicker('update',startLoanDate.getDate() + '/' + eval(startLoanDate.getMonth()+1) + '/' + startLoanDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').val(getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    //$('input[name="next_payment_due_date"]').datepicker('update', getfirstPaymentDate.getDate() + '/' + eval(getfirstPaymentDate.getMonth()+1) + '/' + getfirstPaymentDate.getFullYear());
                    var endLoanDate = new Date(endLoanDate.setDate(eval(getfirstPaymentDate.getDate()+loan_week_period)));
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('hide');
                }
                else
                {
                    var firstPaymentDate = new Date(startLoanDate.setDate(startLoanDate.getDate()+28));
                    //var endLoanDate = new Date(endLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));
                    var endLoanDate = new Date(startLoanDate.setDate(eval(firstPaymentDate.getDate()+loan_week_period)));					
                    $('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="first_payment"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + eval(endLoanDate.getMonth()+1) + '/' + endLoanDate.getFullYear());
                    $('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                    $('input[name="next_payment_due_date"]').datepicker('update',firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear());
                }
            }

            $('input[name="loan_start_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true});
            $('input[name="first_payment"]').datepicker({format: 'dd/mm/yyyy', autoclose: true, startDate: firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear()});
            $('input[name="next_payment_due_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true, startDate: firstPaymentDate.getDate() + '/' + eval(firstPaymentDate.getMonth()+1) + '/' + firstPaymentDate.getFullYear()});

            //endLoanDate = endLoanDate.toLocaleString(endLoanDate);
            //firstPaymentDate = firstPaymentDate.toLocaleString(firstPaymentDate);

            //$('input[name="loan_end_date"]').val(endLoanDate.getDate() + '/' + endLoanMonth + '/' + endLoanDate.getFullYear());
            //$('input[name="first_payment"]').val(firstPaymentDate.getDate() + '/' + firstPaymentDate.getMonth() + '/' + firstPaymentDate.getFullYear());
            //$('input[name="next_payment_due_date"]').val(firstPaymentDate.getDate() + '/' + firstPaymentDate.getMonth() + '/' + firstPaymentDate.getFullYear());

			/*e.preventDefault();*/
            // WHERE sys_string.id IS NOT NULL
            var periodLoanVal = $('#loan_period').val();
            var frequencyVal = frequency;
            if(frequency === 'two week' || frequency === 'four week')
                frequencyVal = 'week';
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
                var newPayment = parseFloat(eval($('input[name="total_payable"]').val())/eval(loan_period)).toFixed(2);
                if(frequency === 'two week')
                    var newPayment = parseFloat(newPayment * 2).toFixed(2);
                if(frequency === 'four week')
                    var newPayment = parseFloat(newPayment * 4).toFixed(2);
                $('input[name="payment"]').val(newPayment);

				/* Rebate calculate
				 step 1 - ((1+'Customer accounts'!$I$19)^(1/12)-1)
				 */
                CalcRebate();

            });

        }

		/*$('[name="first_payment"]').datepicker({format: 'dd/mm/yyyy', autoclose: true, startDate: $('[name="first_payment"]').val()});
		 $('[name="next_payment_due_date"]').datepicker({format: 'dd/mm/yyyy', autoclose: true, startDate: $('[name="next_payment_due_date"]').val()});*/

        //$("#customer_no").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=customer_main:customer_no:customer_no') }}",
        //    {  selected_value : '{{ $row["customer_no"] }}' });

        //$("#user_id").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=users:id:id') }}",
        //    {  selected_value : '{{ $row["user_id"] }}' });

		if('{{$row["frequency_of_payment"]}}' !== 4)
		{
			var toAppend = '<option value="">-- Please Select --</option>';
			$.each({{ $nonfourweekloanperiod }},function(i,o){
				toAppend += '<option value="'+o.number_of_weeks+'" {{ ($row["loan_period"] == '+o.number_of_weeks+' ? "selected" : "none") }} >'+o.number_of_weeks+'</option>';
			});							
			$('#loan_period').html(toAppend);  	
		}
		else
		{
			var toAppend = '<option value="">-- Please Select --</option>';
			if('{{$row["loan_period"]}}' !== 30)
			{
				$.each({{ $fourweekloanperiod }},function(i,o){
					toAppend += '<option value="'+o.number_of_weeks+'" {{ ($row["loan_period"] == '+o.number_of_weeks+' ? "selected" : "none") }} >'+o.number_of_weeks+'</option>';
				});							
			}
			else
			{
				$.each({{ $nonfourweekloanperiod }},function(i,o){
					toAppend += '<option value="'+o.number_of_weeks+'" {{ ($row["loan_period"] == '+o.number_of_weeks+' ? "selected" : "none") }} >'+o.number_of_weeks+'</option>';
				});											
			}
			$('#loan_period').html(toAppend);
		}
		
        $("#frequency").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=frequency:id:freq_desc&order=freq_order') }}",
            {  selected_value : '{{ $row["frequency_of_payment"] }}' });

        $("#t_and_c").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=yesno:id:desc') }}",
            {  selected_value : '{{ $row["t_and_c"] }}' });

        var account_no = $('input[name="account_no"]').val();
        if( account_no === '' )
        {
            $("#loan_status").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_status:id:description') }}",
                {  selected_value : '1' });
        }
        else
        {
            $("#loan_status").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=loan_status:id:description') }}",
                {  selected_value : '{{ $row["loan_status"] }}' });
        }

        $("#reason_for_loan").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=reason_for_loan:reason_for_loan_id:reason_for_loan_desc') }}",
            {  selected_value : '{{ $row["reason_for_loan"] }}' });
			
        $("#round_number").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=round_config:round_number:round_name') }}",
            {  selected_value : '{{ $row["round_number"] }}' });	
            
        $("#arrears_letter").jCombo("{{ URL::to('Customeraccounts/comboselect?filter=arrears_letter:al_id:al_desc') }}",
            {  selected_value : '{{ $row["arrears_letter"] }}' });            
    });

    function CalcRebate() {

        setPPA(12);

        var payment = $('input[name="payment"]').val();
        if($('#frequency').val() == 3)
            payment = $('input[name="payment"]').val() / 2;
        if($('#frequency').val() == 4)
            payment = $('input[name="payment"]').val() / 4;


        var p=getVal($('#amount_borrowed').val());
        var i=getVal(payment);
        var a=getVal(payment);
        var n=Math.floor($('#loan_period option:selected').text());
        var f=getVal(payment);
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

<script type="text/javascript">
$(window).load(function() {
    setTimeout('$(".loader").fadeOut("slow");', 4000);
});
</script>