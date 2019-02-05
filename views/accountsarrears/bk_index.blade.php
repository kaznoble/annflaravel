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
			<li><a href="{{ URL::to('accountsarrears/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/accountsarrears') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('accountsarrears/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
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
	
	<div class="div_report_search_account_arrears" >
		{{ Form::open(array('url'=>'/staffweeklytotals?search=', 'class'=>'form-horizontal' ,'id' =>'SximoTable', 'method' => 'get' )) }}
			<select name='select_staff' rows='5' id='select_staff' code='{$search_staff_name}' class='select2' >
					<option value="" >-- Please Select --</option>			
				@foreach($staffData As $staff){{$staff->staff_name}}
					<option value="{{$staff->round_number}}" {{($staff->round_number == $staff_name ? 'selected="selected"' : '')}}  >{{$staff->staff_name}}</option>
				@endforeach
			</select>
			<select name='select_round' rows='5' id='select_round' code='{$search_round_name}' class='select2' ></select>	
			{{ Form::button(' GO ', ['class' => 'btn btn-primary search_go']) }}
		{{ Form::close() }}
	</div>	
	
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'accountsarrears/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
			<tr>
				<!--<th> No </th>-->
				<!--<th> <input type="checkbox" class="checkall" /></th>-->
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th></th>
			  </tr>
        </thead>

        <tbody class="account_list" >
            @foreach ($rowData as $row)
                <tr class="row_{{ $row->account_no }}">
					<!--<td width="50"> {{ ++$i }} </td>-->
					<!--<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->account_id }}" />  </td>-->
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->account_id) }}">
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
					<button type="button" id="but_view" data-target="{{ $row->account_no }}" class="but_view btn btn-info btn-acc-view" >VIEW</button>
					{{--*/ $id = SiteHelpers::encryptID($row->account_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<a href="{{ URL::to('accountsarrears/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>
					@endif
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('accountsarrears/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach							
					</div>
				</td>				 
                </tr>
				@include('accountsarrears.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	
	<div id="div_acc_details" class="div_acc_details" style="display:none;" ></div>
	@include('footer')
	
	</div>	  
	
<script>
$(document).ready(function(){
	
    $("#select_round").jCombo("{{ URL::to('staffweeklytotals/comboselect?filter=round_config:round_number:round_name') }}",
            {  selected_value : '{{ $round_number }}' });		

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("accountsarrears/multisearch")}}');
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
			searchUrl = searchUrl + 'staff_name:' + selectStaff + '';
		}
		if(selectRound !== '')
		{
			searchUrl = searchUrl + 'round_number:' + selectRound;		
		}
		window.location.href = searchUrl;
	});	
	
	$('.btn-acc-view').on('click', function() {
		var acc_no;
		acc_no = $(this).attr('data-target');
		$('.account_list > tr > td').css('background-color','');
		$('.row_' + acc_no + ' > td').css('background-color','#ccc');
		$('.div_acc_details').show();
		$.ajax({
			url: '/ajax/accounts_arrears.php',
			data: {acc_no: acc_no},
			type: 'POST',
			success: function(data) {
				$('.div_acc_details').html(data);
			}
		});
	});
	
});	
</script>		