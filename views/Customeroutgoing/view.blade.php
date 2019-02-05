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
		<li><a href="{{ URL::to('Customeroutgoing') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customeroutgoing') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customeroutgoing/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customeroutgoing/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Customer No</td>
						<td>{{ $row->customer_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Rent Mortgage</td>
						<td>{{ $row->rent_mortgage }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Gas</td>
						<td>{{ $row->gas }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Electric</td>
						<td>{{ $row->electric }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->phone }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Transport</td>
						<td>{{ $row->transport }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Outgoing Total</td>
						<td>{{ $row->outgoing_total }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ $row->updated_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Local Tax</td>
						<td>{{ $row->local_tax }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Water</td>
						<td>{{ $row->water }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Mobile Phone</td>
						<td>{{ $row->mobile_phone }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tv License</td>
						<td>{{ $row->tv_license }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle Road Tax</td>
						<td>{{ $row->vehicle_road_tax }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Vehicle Service</td>
						<td>{{ $row->vehicle_service }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fuel</td>
						<td>{{ $row->fuel }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Car Insurance</td>
						<td>{{ $row->car_insurance }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Public Transport</td>
						<td>{{ $row->public_transport }} </td>
						
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
						<td width='30%' class='label-view text-right'>Sports Hobbies</td>
						<td>{{ $row->sports_hobbies }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Contents Insurance</td>
						<td>{{ $row->contents_insurance }} </td>
						
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
						<td width='30%' class='label-view text-right'>Other 1</td>
						<td>{{ $row->other_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other Description 1</td>
						<td>{{ $row->other_description_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other 2</td>
						<td>{{ $row->other_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other Description 2</td>
						<td>{{ $row->other_description_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other 3</td>
						<td>{{ $row->other_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other Description 3</td>
						<td>{{ $row->other_description_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total</td>
						<td>{{ $row->total }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  