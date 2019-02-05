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
		<li><a href="{{ URL::to('Customerrelative') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customerrelative') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customerrelative/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customerrelative/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<!--<tr>
						<td width='30%' class='label-view text-right'>Cust Rel Id</td>
						<td>{{ $row->cust_rel_id }} </td>
						
					</tr>-->
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer No</td>
						<td>{{ $row->customer_no }} </td>
						
					</tr>
				
					<!--<tr>
						<td width='30%' class='label-view text-right'>User Id</td>
						<td>{{ $row->user_id }} </td>
						
					</tr>-->
				
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ SiteHelpers::gridDisplayView($row->title,'title','1:customer_title:id:title') }} </td>
						
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
						<td width='30%' class='label-view text-right'>Middle Names</td>
						<td>{{ $row->middle_names }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Marital Status</td>
						<td>{{ SiteHelpers::gridDisplayView($row->marital_status,'marital_status','1:marital_status:id:description') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ni Number</td>
						<td>{{ $row->ni_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Children Under 18</td>
						<td>{{ $row->no_children_under_18 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>No Res Over 18</td>
						<td>{{ $row->no_res_over_18 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address 1</td>
						<td>{{ $row->address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address 2</td>
						<td>{{ $row->address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address 3</td>
						<td>{{ $row->address_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address 4</td>
						<td>{{ $row->address_4 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Postcode</td>
						<td>{{ $row->postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Telephone 1</td>
						<td>{{ $row->telephone_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Telephone 2</td>
						<td>{{ $row->telephone_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Telephone 3</td>
						<td>{{ $row->telephone_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Relationship</td>
						<td>{{ SiteHelpers::gridDisplayView($row->relationship,'relationship','1:relationship:id:description') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Specify</td>
						<td>{{ $row->specify }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($row->created_at)) }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ date("d/m/Y H:i:s", strtotime($row->updated_at)) }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  