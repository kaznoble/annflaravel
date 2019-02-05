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
		<li><a href="{{ URL::to('loanappprimary') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('loanappprimary') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('loanappprimary/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'loanappprimary/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>App Primary Id</td>
						<td>{{ $row->app_primary_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Application Number</td>
						<td>{{ $row->loan_application_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Amount</td>
						<td>{{ $row->loan_amount }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->title }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>First Name</td>
						<td>{{ $row->first_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Last Name</td>
						<td>{{ $row->last_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dob</td>
						<td>{{ $row->dob }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email Address</td>
						<td>{{ $row->email_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>First Line Address</td>
						<td>{{ $row->first_line_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Second Line Address</td>
						<td>{{ $row->second_line_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Town City</td>
						<td>{{ $row->town_city }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Postcode</td>
						<td>{{ $row->postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Years At Address</td>
						<td>{{ $row->years_at_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone Landline</td>
						<td>{{ $row->phone_landline }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone Mobile</td>
						<td>{{ $row->phone_mobile }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Home Status</td>
						<td>{{ $row->home_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Marita Status</td>
						<td>{{ $row->marita_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Child</td>
						<td>{{ $row->no_child }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created Date</td>
						<td>{{ $row->created_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Timestamp</td>
						<td>{{ $row->timestamp }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Firstline Prev Address</td>
						<td>{{ $row->firstline_prev_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Secondline Prev Address</td>
						<td>{{ $row->secondline_prev_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Town City Prev</td>
						<td>{{ $row->town_city_prev }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Postcode Prev</td>
						<td>{{ $row->postcode_prev }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Years At Addres Prev</td>
						<td>{{ $row->years_at_addres_prev }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Confirm Cust Can Afford Loan</td>
						<td>{{ $row->confirm_cust_can_afford_loan }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Confirm Cust Gives Content</td>
						<td>{{ $row->confirm_cust_gives_content }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Successful Applicant</td>
						<td>{{ $row->successful_applicant }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reason</td>
						<td>{{ $row->reason }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Processed</td>
						<td>{{ $row->processed }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  