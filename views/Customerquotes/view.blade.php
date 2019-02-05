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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customerquotes') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customerquotes/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customerquotes/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Quote No</td>
						<td>{{ $row->quote_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer No</td>
						<td>{{ $row->customer_no }} </td>
						
					</tr>
				
					<!--<tr>
						<td width='30%' class='label-view text-right'>User Id</td>
						<td>{{ $row->user_id }} </td>
						
					</tr>-->
				
					<tr>
						<td width='30%' class='label-view text-right'>Amount Borrowed</td>
						<td>{{ $row->amount_borrowed }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Monthly Payment</td>
						<td>{{ $row->monthly_payment }} </td>
						
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
						<td>{{ date("d/m/Y", strtotime($row->loan_start_date)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan End Date</td>
						<td>{{ date("d/m/Y", strtotime($row->loan_end_date)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>First Payment</td>
						<td>{{ date("d/m/Y", strtotime($row->first_payment)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Percentage Apr</td>
						<td>{{ $row->percentage_apr }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Home Visit</td>
						<td>{{ $row->home_visit }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>T And C</td>
						<td>{{ $row->t_and_c }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Existing Customer</td>
						<td>{{ $row->existing_customer }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email</td>
						<td>{{ $row->email }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($row->created_at)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($row->updated_at)) }} </td>
						
					</tr>
				
					<!--<tr>
						<td width='30%' class='label-view text-right'>Deleted At</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($row->deleted_at)) }} </td>
						
					</tr>-->
				
		</tbody>	
	</table>    
	</div>
</div>
	  