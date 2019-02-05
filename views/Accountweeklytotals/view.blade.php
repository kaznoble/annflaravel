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
		<li><a href="{{ URL::to('Accountweeklytotals') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Accountweeklytotals') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Accountweeklytotals/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Accountweeklytotals/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Week No</td>
						<td>{{ $row->week_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Date</td>
						<td>{{ $row->date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Loans Week</td>
						<td>{{ $row->total_loans_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Interest Week</td>
						<td>{{ $row->total_interest_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Collect Week</td>
						<td>{{ $row->total_collect_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reloan Balance Week</td>
						<td>{{ $row->reloan_balance_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Rebate Week</td>
						<td>{{ $row->total_rebate_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Book Debt Week</td>
						<td>{{ $row->book_debt_week }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Income For Week</td>
						<td>{{ $row->income_for_week }} </td>
						
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
	  