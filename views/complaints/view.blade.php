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
		<li><a href="{{ URL::to('complaints') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('complaints') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('complaints/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'complaints/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Complaint Id</td>
						<td>{{ $row->complaint_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Complaint No</td>
						<td>{{ $row->complaint_no }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Customer Name</td>
						<td>{{ $row->customer_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>User Id</td>
						<td>{{ $row->user_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address line one</td>
						<td>{{ $row->address_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address line two</td>
						<td>{{ $row->address_2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Postcode</td>
						<td>{{ $row->postcode }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Telephone</td>
						<td>{{ $row->telephone_1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email Address</td>
						<td>{{ $row->email_address }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Pref Contact Method</td>
						<td>{{ SiteHelpers::gridDisplayView($row->pref_contact_method,'pref_contact_method','1:method_of_contact:id:description') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Like To Contacted</td>
						<td>{{ $row->like_to_contacted }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Complaint</td>
						<td>{{ $row->complaint }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Complaint Status</td>
						<td>{{ SiteHelpers::gridDisplayView($row->complaint_status,'complaint_status','1:complaint_status:id:description') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Received Date</td>
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
	  