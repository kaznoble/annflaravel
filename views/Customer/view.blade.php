<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
		<li><a href="{{ URL::to('Customer') }}">{{ $pageTitle }}</a></li>
        <li class="active"> view </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customer') }}" class="tips" title="Back"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customer/add/'.$id) }}" class="tips" title="Edit"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips"  title="remove"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customer/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
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
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->title }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Forename</td>
						<td>{{ $row->forename }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Surname</td>
						<td>{{ $row->surname }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Middle Name(s)</td>
						<td>{{ $row->middle_names }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Date Of Birth</td>
						<td>{{ $row->date_of_birth }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Marital Status</td>
						<td>{{ $row->marital_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NI Number</td>
						<td>{{ $row->ni_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Children Under 18</td>
						<td>{{ $row->no_children_under_18 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Resident Over 18</td>
						<td>{{ $row->no_res_over_18 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>House Number & Street</td>
						<td>{{ $row->address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Town</td>
						<td>{{ $row->address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>City</td>
						<td>{{ $row->address_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>County</td>
						<td>{{ $row->address_4 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Postcode</td>
						<td>{{ $row->postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>House Telephone</td>
						<td>{{ $row->telephone_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Mobile</td>
						<td>{{ $row->telephone_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Telephone</td>
						<td>{{ $row->telephone_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Previous Address (House Number & Street)</td>
						<td>{{ $row->previous_address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Previous Address (Town)</td>
						<td>{{ $row->previous_address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Previous Address (City)</td>
						<td>{{ $row->previous_address_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Previous Address (County)</td>
						<td>{{ $row->previous_address_4 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Previous Postcode</td>
						<td>{{ $row->previous_postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Employment Status</td>
						<td>{{ $row->employment_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Occupation</td>
						<td>{{ $row->occupation }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Employer Name</td>
						<td>{{ $row->employer_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address (Number & Street)</td>
						<td>{{ $row->work_address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address (Town)</td>
						<td>{{ $row->work_address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address (City)</td>
						<td>{{ $row->work_address_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address (County)</td>
						<td>{{ $row->work_address_4 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Postcode</td>
						<td>{{ $row->work_postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Residential Status</td>
						<td>{{ $row->cus_residential_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>T And C</td>
						<td>{{ $row->t_and_c }} </td>
						
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
						<td width='30%' class='label-view text-right'>Deleted At</td>
						<td>{{ $row->deleted_at }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  