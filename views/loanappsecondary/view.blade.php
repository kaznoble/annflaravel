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
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('loanappsecondary') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('loanappsecondary/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'loanappsecondary/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Loan Secondary Id</td>
						<td>{{ $row->loan_secondary_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Application Number</td>
						<td>{{ $row->loan_application_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Primary Income</td>
						<td>{{ $row->total_primary_income }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Secondary Income</td>
						<td>{{ $row->total_secondary_income }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Child Maintenace</td>
						<td>{{ $row->child_maintenace }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Child Tax Credit</td>
						<td>{{ $row->child_tax_credit }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Child Benefit</td>
						<td>{{ $row->child_benefit }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Income</td>
						<td>{{ $row->total_income }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Declare Other Person Income</td>
						<td>{{ $row->declare_other_person_income }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Contribution Details</td>
						<td>{{ $row->contribution_details }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ccj</td>
						<td>{{ $row->ccj }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ccj Details</td>
						<td>{{ $row->ccj_details }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Rent Mortgage</td>
						<td>{{ $row->rent_mortgage }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loacal Tax</td>
						<td>{{ $row->loacal_tax }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Electric</td>
						<td>{{ $row->electric }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Gas</td>
						<td>{{ $row->gas }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Telephone</td>
						<td>{{ $row->telephone }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Mobile</td>
						<td>{{ $row->mobile }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tv License</td>
						<td>{{ $row->tv_license }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>House Insurance</td>
						<td>{{ $row->house_insurance }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle</td>
						<td>{{ $row->vehicle }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle Insurance</td>
						<td>{{ $row->vehicle_insurance }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Road Tax</td>
						<td>{{ $row->road_tax }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle Service</td>
						<td>{{ $row->vehicle_service }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle Fuel</td>
						<td>{{ $row->vehicle_fuel }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Public Transport</td>
						<td>{{ $row->public_transport }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Weekly Monthly</td>
						<td>{{ $row->weekly_monthly }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Food</td>
						<td>{{ $row->food }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Clothing</td>
						<td>{{ $row->clothing }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>School Meals</td>
						<td>{{ $row->school_meals }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Hairdressing</td>
						<td>{{ $row->hairdressing }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Contingency</td>
						<td>{{ $row->contingency }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other1</td>
						<td>{{ $row->other1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other2</td>
						<td>{{ $row->other2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other3</td>
						<td>{{ $row->other3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other1 Details</td>
						<td>{{ $row->other1_details }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other2 Details</td>
						<td>{{ $row->other2_details }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other3 Details</td>
						<td>{{ $row->other3_details }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total In</td>
						<td>{{ $row->total_in }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Out</td>
						<td>{{ $row->total_out }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Difernece</td>
						<td>{{ $row->difernece }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  