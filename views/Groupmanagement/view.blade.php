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
		<li><a href="{{ URL::to('Groupmanagement') }}">{{ $pageTitle }}</a></li>
        <li class="active"> {{ Lang::get('core.detail') }} </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Groupmanagement') }}" class="tips" title="{{ Lang::get('core.btn_back') }}"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Groupmanagement/add/'.$id) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"class="tips" title="{{ Lang::get('core.btn_remove') }}"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Groupmanagement/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Group Id</td>
						<td>{{ $row->group_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Name</td>
						<td>{{ $row->name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Description</td>
						<td>{{ $row->description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Level</td>
						<td>{{ $row->level }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  