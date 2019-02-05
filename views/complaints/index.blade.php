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
	  <!--<ul class="breadcrumb-buttons collapse">
			@if($access['is_excel'] ==1)
			<li><a href="{{ URL::to('complaints/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/complaints') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('complaints/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>-->
	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'complaints/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
			<tr>
				<!--<th> No </th>-->
				<th>
					<input type="checkbox" class="checkall" />
					<a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">[DELETE]</a>
				</th>
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th>{{ Lang::get('core.btn_action') }}</th>
			  </tr>
        </thead>

        <tbody>
			<tr id="sximo-quick-search" >
				<!--<td> # </td>-->
				@if($access['is_detail'] ==1)<td> </td>@endif
				<td> </td>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<td>						
						{{ SiteHelpers::transForm($t['field'] , $tableForm) }}								
					</td>
					@endif
				@endforeach
				<td style="width:100px;">
				<input type="hidden"  value="Search">
				<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
			  </tr>				
            @foreach ($rowData as $row)
                <tr  {{ ($row->complaint_status == 1 ? 'style="background-color:#ffdbdb";' : '') }}>
					<!--<td width="50"> {{ ++$i }} </td>-->
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->complaint_id }}" />  </td>
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->complaint_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif								
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 <td>					 
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
							{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}	
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
				 <td>
				 	<div class="btn-group">
						<select name='complaint_status_option' rows='5' id='complaint_status_option' class='select2 complaint_status_option' data-item="{{ $row->complaint_id }}" data-csrf="{{ csrf_token() }}" >
							@foreach($complaint_status As $status)
								<option value="{{ $status->id; }}" {{ ($row->complaint_status == $status->id ? 'selected' : '') }} >{{ $status->description; }}</option>
								{{ $status->description; }}
							@endforeach
						</select> 							
					<!--{{--*/ $id = SiteHelpers::encryptID($row->complaint_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<a href="{{ URL::to('complaints/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>
					@endif
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('complaints/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach-->
					</div>
				</td>				 
                </tr>
				@include('complaints.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	@include('footer')
	
	</div>	  
	
<script>
$(document).ready(function(){	

	$('.complaint_status_option').on('change', function() {
		var complaint_id = $(this).attr('data-item');
		var complaint_status = $(this).val();
		var csrf = $(this).attr('data-csrf');		
		$.ajax({
			url: "/ajax/ajax_complaint_status.php",
			data: {"complaint_id": complaint_id, "complaint_status": complaint_status, "csrf": csrf},
			type: "POST",
			success: function(result) {
				if(result == 1)
					window.location.href = "/complaints";
			}
		});
	});

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("complaints/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		