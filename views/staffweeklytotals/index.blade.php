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
			<li><a href="{{ URL::to('staffweeklytotals/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/staffweeklytotals') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('staffweeklytotals/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
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
	
	<div class="div_report_search_weekly_totals" >
		{{ Form::open(array('url'=>'/staffweeklytotals?search=', 'class'=>'form-horizontal' ,'id' =>'SximoTable', 'method' => 'get' )) }}
			<select name='select_staff' rows='5' id='select_staff' code='{$search_staff_name}' class='select2' >
					<option value="" >-- Please Select --</option>			
				@foreach($staffData As $staff){{$staff->first_name}} {{$staff->last_name}}
					<option value="{{$staff->first_name}} {{$staff->last_name}}" {{($staff->first_name . ' ' . $staff->last_name == $staff_name ? 'selected="selected"' : '')}}  >{{$staff->first_name}} {{$staff->last_name}}</option>
				@endforeach
			</select>
			<select name='select_round' rows='5' id='select_round' code='{$search_round_name}' class='select2' ></select>	
			{{ Form::button(' GO ', ['class' => 'btn btn-primary search_go']) }}
		{{ Form::close() }}
	</div>
	
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'staffweeklytotals/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped " >
        <thead>
			<tr>
				<!--<th> No </th>-->
				<!--<th> <input type="checkbox" class="checkall" /></th>-->
				<!--@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif-->
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<!--<th>{{ Lang::get('core.btn_action') }}</th>-->
			  </tr>
        </thead>

        <tbody>
			<!--<tr id="sximo-quick-search" >
				<td> # </td>
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
			  </tr>-->
            @foreach ($rowData as $row)
                <tr>
					<!--<td width="50"> {{ ++$i }} </td>-->
					<!--<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->weeklyTotal_id }}" />  </td>-->
					<!--@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->weeklyTotal_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif-->								
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 <td>					 
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
							{{(($field['field'] == 'total_balance' || $field['field'] == 'total_collect_week' || $field['field'] == 'total_arrears_week') ? '£' : '')}}{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}	
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
				 <!--<td>
				 	<div class="btn-group">
					{{--*/ $id = SiteHelpers::encryptID($row->weeklyTotal_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<a href="{{ URL::to('staffweeklytotals/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>
					@endif
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('staffweeklytotals/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach							
					</div>
				</td>-->			 
                </tr>
				@include('staffweeklytotals.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	@include('footer')
	
	</div>	  
	
<script>
$(document).ready(function(){
			
    $("#select_round").jCombo("{{ URL::to('staffweeklytotals/comboselect?filter=round_config:round_name:round_name') }}",
            {  selected_value : '{{ $round_name }}' });			

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("staffweeklytotals/multisearch")}}');
		$('#SximoTable').submit();
	});
	
	$('#select_staff').change(function() {
		$('#select_staff option[value=""]').attr('selected', false);
		var selectStaff = $('#select_staff :selected').val();
		if(selectStaff !== '')
		{
			$('#select_round option[value=""]').attr('selected', true);
		}
	});
	$('#select_round').change(function() {
		$('#select_round option[value=""]').attr('selected', false);		
		var selectRound = $('#select_round :selected').val();
		if(selectRound !== '')
		{
			$('#select_staff option[value=""]').attr('selected', true);
		}
	});	
	
	$('.search_go').click(function() {
		$('.table-striped').show();
		
		var selectStaff = $('#select_staff :selected').val();
		var selectRound = $('#select_round :selected').val();	
		var searchUrl = '?search=';
		if(selectStaff !== '')
		{
			searchUrl = searchUrl + 'staff_name:' + selectStaff + '|';
		}
		if(selectRound !== '')
		{
			searchUrl = searchUrl + 'round_name:' + selectRound;		
		}
		window.location.href = searchUrl;
	});
	
});	
</script>		