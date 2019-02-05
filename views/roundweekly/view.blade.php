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
		<li><a href="{{ URL::to('roundweekly') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('roundweekly') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('roundweekly/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'roundweekly/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Round Id</td>
						<td>{{ $row->round_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Round Number</td>
						<td>{{ $row->round_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Round Name</td>
						<td>{{ $row->round_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Staff Name</td>
						<td>{{ $row->staff_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Staff Number</td>
						<td>{{ $row->staff_number }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Days Of Week</td>
						<td>{{ $row->days_of_week }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  