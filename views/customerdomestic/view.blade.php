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
		<li><a href="{{ URL::to('customerdomestic') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('customerdomestic') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('customerdomestic/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'customerdomestic/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
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
						<td width='30%' class='label-view text-right'>Employment Status</td>
						<td>{{ SiteHelpers::gridDisplayView($row->employment_status,'employment_status','1:employment_status:id:description') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Occupation</td>
						<td>{{ $row->occupation }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Employee Name</td>
						<td>{{ $row->employee_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address 1</td>
						<td>{{ $row->work_address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address 2</td>
						<td>{{ $row->work_address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address 3</td>
						<td>{{ $row->work_address_3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Address 4</td>
						<td>{{ $row->work_address_4 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Work Postcode</td>
						<td>{{ $row->work_postcode }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  