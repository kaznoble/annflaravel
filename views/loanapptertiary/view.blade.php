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
		<li><a href="{{ URL::to('loanapptertiary') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('loanapptertiary') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('loanapptertiary/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'loanapptertiary/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Loan Tert Id</td>
						<td>{{ $row->loan_tert_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Loan Application Number</td>
						<td>{{ $row->loan_application_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Employment Status</td>
						<td>{{ $row->employment_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name Of Employer</td>
						<td>{{ $row->name_of_employer }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Time In Job</td>
						<td>{{ $row->time_in_job }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agree To Privacy Notice</td>
						<td>{{ $row->agree_to_privacy_notice }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Policy Notice Name</td>
						<td>{{ $row->policy_notice_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Policy Notice Date</td>
						<td>{{ $row->policy_notice_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Agree To Credit Check</td>
						<td>{{ $row->agree_to_credit_check }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Confirm No Debt Problems</td>
						<td>{{ $row->confirm_no_debt_problems }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dept Problem Name</td>
						<td>{{ $row->dept_problem_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Debt Problem Date</td>
						<td>{{ $row->debt_problem_date }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  