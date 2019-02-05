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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('cardpayment') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('cardpayment/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'cardpayment/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Account Id</td>
						<td>{{ $row->account_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Account No</td>
						<td>{{ $row->account_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer No</td>
						<td>{{ $row->customer_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>User Id</td>
						<td>{{ $row->user_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Amount Borrowed</td>
						<td>{{ $row->amount_borrowed }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Payment</td>
						<td>{{ $row->payment }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Interest Payable</td>
						<td>{{ $row->interest_payable }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Paid To Date</td>
						<td>{{ $row->total_paid_to_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Last Payment Made</td>
						<td>{{ $row->last_payment_made }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Balance</td>
						<td>{{ $row->balance }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Early Payment Rebate</td>
						<td>{{ $row->early_payment_rebate }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Early Settlement Balance</td>
						<td>{{ $row->early_settlement_balance }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Payable</td>
						<td>{{ $row->total_payable }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Period</td>
						<td>{{ $row->loan_period }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Start Date</td>
						<td>{{ $row->loan_start_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan End Date</td>
						<td>{{ $row->loan_end_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>First Payment</td>
						<td>{{ $row->first_payment }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Percentage Apr</td>
						<td>{{ $row->percentage_apr }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>T And C</td>
						<td>{{ $row->t_and_c }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Week No</td>
						<td>{{ $row->week_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Miss Payment</td>
						<td>{{ $row->no_miss_payment }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reason For Loan</td>
						<td>{{ $row->reason_for_loan }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Period No</td>
						<td>{{ $row->period_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reason</td>
						<td>{{ $row->reason }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Status</td>
						<td>{{ $row->loan_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Status Reduced Desc</td>
						<td>{{ $row->loan_status_reduced_desc }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Arrears</td>
						<td>{{ $row->arrears }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Frequency Of Payment</td>
						<td>{{ $row->frequency_of_payment }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Payment Still Due</td>
						<td>{{ $row->total_payment_still_due }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Next Payment Due Date</td>
						<td>{{ $row->next_payment_due_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Payer Ref</td>
						<td>{{ $row->payer_ref }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Pmt Ref</td>
						<td>{{ $row->pmt_ref }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ $row->updated_at }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  