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
		<li><a href="{{ URL::to('Customerincome') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customerincome') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customerincome/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customerincome/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
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
						<td width='30%' class='label-view text-right'>Income Frequency</td>
						<td>{{ SiteHelpers::gridDisplayView($row->income_frequency,'income_frequency','1:frequency:id:freq_desc') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Primary Income (after Tax)</td>
						<td>{{ $row->wage_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Secondary Income (after Tax)</td>
						<td>{{ $row->wage_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Child Benefit</td>
						<td>{{ $row->child_benefit }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Child Tax Credit</td>
						<td>{{ $row->child_tax_credit }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Maintenance Payments</td>
						<td>{{ $row->maintenance_payments }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other</td>
						<td>{{ $row->other }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other Description</td>
						<td>{{ $row->other_description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Income Total</td>
						<td>{{ $row->income_total }} </td>
						
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
	  