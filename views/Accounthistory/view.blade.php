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
		<li><a href="{{ URL::to('Accounthistory') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Accounthistory') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Accounthistory/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Accounthistory/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Acc History Id</td>
						<td>{{ $row->acc_history_id }} </td>
						
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
						<td width='30%' class='label-view text-right'>Date Time</td>
						<td>{{ $row->date_time }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Period No</td>
						<td>{{ $row->period_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Week No</td>
						<td>{{ $row->week_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Transaction Type</td>
						<td>{{ $row->transaction_type }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  