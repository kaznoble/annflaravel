{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
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
        <li class="active">{{ $pageTitle }}</li>
      </ul>
	   <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
	  <ul class="breadcrumb-buttons collapse">
			@if($access['is_excel'] ==1)
			<li><a href="{{ URL::to('Customeroutgoing/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/Customeroutgoing') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1 && FALSE)
	   		<li><a href="{{ URL::to('Customeroutgoing/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>
	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'Customeroutgoing/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
			<tr id="sximo-quick-search" >
				<td> # </td>
				@if($access['is_detail'] ==1)<td> </td>@endif
				<td> </td>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1' && $t['field'] != 'cust_outg_id' && $t['field'] != 'user_id' && $t['field'] != 'created_at' && $t['field'] != 'updated_at')
					<td {{ ($t['field'] == 'customer_no' ? 'class="td_customer_no"' : '') }} >						
						@if( $t['field'] == 'customer_no' )
							<input class="form-control input-sm" type="text" value="" name="customer_no" placeholder="C#########" >
						@else
							@if( $t['field'] != 'rent_mortgage' && $t['field'] != 'gas' && $t['field'] != 'electric' && $t['field'] != 'phone' && $t['field'] != 'transport' && $t['field'] != 'created_at' && $t['field'] != 'updated_at')
								{{ SiteHelpers::transForm($t['field'] , $tableForm) }}
							@endif
						@endif
					</td>
					@endif
				@endforeach
				<td style="width:100px;">
				<input type="hidden"  value="Search">
				<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
			  </tr>				
        </thead>

        <tbody>
			<tr>
				<th> No </th>
				<th> <input type="checkbox" class="checkall" /></th>
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1' && $t['field'] != 'cust_outg_id' && $t['field'] != 'user_id' && $t['field'] != 'created_at' && $t['field'] != 'updated_at')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th>{{ Lang::get('core.btn_action') }}</th>
			  </tr>
            @foreach ($rowData as $row)
                <tr>
					<td width="50"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->cust_outg_id }}" />  </td>	
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->cust_outg_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif								
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1' && $field['field'] != 'cust_outg_id' && $field['field'] != 'user_id' && $field['field'] != 'created_at' && $field['field'] != 'updated_at')
					 <td>					 
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
							@if( $field['field'] == 'created_at' || $field['field'] == 'updated_at')
								{{ SiteHelpers::gridDisplay(date('d/m/Y H:i:s', strtotime($row->$field['field'])),$field['field'],$conn) }}	
							@else
								{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}
							@endif
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
				 <td>
				 	<div class="btn-group">
					{{--*/ $id = SiteHelpers::encryptID($row->cust_outg_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<a href="{{ URL::to('Customeroutgoing/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>
					@endif
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('Customeroutgoing/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach							
					</div>
				</td>				 
                </tr>
				@include('Customeroutgoing.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	<!--@include('footer')-->
	
	</div>	  
	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("Customeroutgoing/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		