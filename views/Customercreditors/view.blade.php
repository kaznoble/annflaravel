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
		<li><a href="{{ URL::to('Customercreditors') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Customercreditors') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customercreditors/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Customercreditors/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<!--<tr>
						<td width='30%' class='label-view text-right'>Cust Cred Id</td>
						<td>{{ $row->cust_cred_id }} </td>
						
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
						<td width='30%' class='label-view text-right'>Credit Cards</td>
						<td>{{ $row->credit_cards }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loans</td>
						<td>{{ $row->loans }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Other</td>
						<td>{{ $row->other }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Denied Credit</td>
						<td>{{ SiteHelpers::gridDisplayView($row->denied_credit,'denied_credit','1:ccj:id:ccj') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ccj</td>
						<td>{{ SiteHelpers::gridDisplayView($row->ccj,'ccj','1:ccj:id:ccj') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ccj Details</td>
						<td>{{ $row->ccj_details }} </td>
						
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
	  