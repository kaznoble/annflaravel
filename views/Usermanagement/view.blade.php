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
		<li><a href="{{ URL::to('Usermanagement') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Usermanagement') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Usermanagement/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Usermanagement/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
			<tr>
				<td width='30%' class='label-view text-right'>Id</td>
				<td>{{ $row->id }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Staff Id</td>
				<td>{{ $row->staff_id }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Group Id</td>
				<td>{{ SiteHelpers::gridDisplayView($row->group_id,'group_id','1:tb_groups:group_id:name') }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Username</td>
				<td>{{ $row->username }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Password</td>
				<td>{{ $row->password }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Email</td>
				<td>{{ $row->email }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>First Name</td>
				<td>{{ $row->first_name }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Last Name</td>
				<td>{{ $row->last_name }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Avatar</td>
				<td>{{ $row->avatar }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Active</td>
				<td>{{ $row->active }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Login Attempt</td>
				<td>{{ $row->login_attempt }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Last Login</td>
				<td>{{ $row->last_login }} </td>
				
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
				<td width='30%' class='label-view text-right'>Reminder</td>
				<td>{{ $row->reminder }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Activation</td>
				<td>{{ $row->activation }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Remember Token</td>
				<td>{{ $row->remember_token }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Staff ID</td>
				<td>{{ $row->staff_ID }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Round Number</td>
				<td>{{ $row->round_number }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Account Status</td>
				<td>{{ $row->account_status }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Home Number</td>
				<td>{{ $row->home_number }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Mobile Number</td>
				<td>{{ $row->mobile_number }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Mobile Device Number</td>
				<td>{{ $row->mobile_device_number }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Upcoming Holidays</td>
				<td>{{ $row->upcoming_holidays }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Emergency Contact Name</td>
				<td>{{ $row->emergency_contact_name }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Emergency Contact Home</td>
				<td>{{ $row->emergency_contact_home }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Emergency Contact Mobile</td>
				<td>{{ $row->emergency_contact_mobile }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Monday</td>
				<td>{{ $row->monday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Tuesday</td>
				<td>{{ $row->tuesday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Wednesday</td>
				<td>{{ $row->wednesday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Thursday</td>
				<td>{{ $row->thursday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Friday</td>
				<td>{{ $row->friday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Saturday</td>
				<td>{{ $row->saturday }} </td>
				
			</tr>
		
			<tr>
				<td width='30%' class='label-view text-right'>Sunday</td>
				<td>{{ $row->sunday }} </td>
				
			</tr>
		</tbody>	
	</table>    
	</div>
</div>