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
			<li><a href="{{ URL::to('loanapphistory/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/loanapphistory') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('loanapphistory/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>
	</div>
	  <ul class="nav nav-tabs">
		  <li><a href="{{ url('/loanapp') }}" style="background-color:#bad6c1;">Loan Application</a></li>
		  <li class="active"><a data-toggle="tab" href="{{ url('/loanapphistory') }}" style="background-color:#ddd4c1;">Loan Application History</a></li>
	  </ul>

  @if(Session::has('message'))
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'loanapphistory/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
			<tr>
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				<?php $colCount = 0; ?>				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<?php if($colCount <= '9') { ?>	
					<?php if($colCount == '3') { ?>	
						<th>Address</th>			
						<th>Email Address</th>									
					<?php } else { ?>
						<th>{{ $t['label'] }}</th>
					<?php } ?>		
					<?php } ?>							
					<?php $colCount++; ?>							
					@endif
				@endforeach
				<th>{{ Lang::get('core.btn_action') }}</th>
			  </tr>
        </thead>

        <tbody>
			<tr id="sximo-quick-search" >
				<td> </td>
				<?php $colCount = 0; ?>				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<?php if($colCount <= '9') { ?>			
					<?php if($colCount == '3') { ?>				
						<td></td>
						<td></td>						
					<?php } else { ?>
					<td>						
						{{ SiteHelpers::transForm($t['field'] , $tableForm) }}								
					</td>
					<?php } ?>
					<?php } ?>																
					<?php $colCount++; ?>						
					@endif
				@endforeach
				<td style="width:100px;">
				<input type="hidden"  value="Search">
				<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
			  </tr>				
            @foreach ($rowData as $row)
                <tr style="background-color:{{ ($row->admin_view == 0 ? '#d6eab4' : '') }};">
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->app_primary_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif	
				<?php $colCount = 0; ?>						
				 @foreach ($tableGrid as $field)
						@if($field['view'] =='1')
						<?php if($colCount <= '9') { ?>	
						<?php if($colCount == '3') { ?>
							<td><a href="http://www.google.com/maps/place/{{ SiteHelpers::gridDisplay($row->{'lat'},'lat',$conn) }},{{ SiteHelpers::gridDisplay($row->{'long'},'long',$conn) }}" target="_blank">{{ $row->first_line_address }}, {{ $row->town_city }}, {{ $row->postcode }}</a></td>
							<td>{{ $row->email_address }}</td>							
						<?php } else { ?>
							<td>
								@if($field['attribute']['image']['active'] =='1')
									<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
								@elseif($field['field'] == 'successful_applicant')
									{{ Form::select('successful_applicant', (['0'=>'No','1'=>'Yes']), SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn), ['class' => 'successful_applicant_change','data-csrf' => csrf_token(), 'data-item' => $row->app_primary_id]) }}
								@elseif($field['field'] == 'processed')
									{{ Form::select('processed', (['0'=>'No','1'=>'Yes']), SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn), ['class' => 'processed_change','data-csrf' => csrf_token(), 'data-item' => $row->app_primary_id]) }}
								@elseif($field['field'] == 'created_date')
									@if(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) == '0000-00-00')
										00/00/0000
									@else
										{{ date('d/m/Y', strtotime(str_replace('-', '/', SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn)))) }}
									@endif
								@elseif($field['field'] == 'timestamp')
									@if(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) == '0000-00-00 00:00:00')
										00:00:00
									@else
										{{ date('H:i:s', strtotime(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn))) }}
									@endif
                                @elseif($field['field'] == 'reason' && SiteHelpers::gridDisplay($row->successful_applicant, 'successful_applicant', $conn) == 0)
                                    {{ Form::text('reason', SiteHelpers::gridDisplay($row->{$field['field']}, $field['field'], $conn), array('class'=>'form-control reason_'.$row->app_primary_id, 'placeholder'=>'', 'style' => 'min-width:150px;'  )) }}
                                    <button type="button" class="save" onclick="update_reason('{{ $row->app_primary_id }}')">Save</button>
                                @else
									{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
									{{ SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) }}
								@endif
							</td>
						<?php } ?>
						<?php } ?>						
						<?php $colCount++; ?>								
						@endif
				 @endforeach
				 <td>
				 	<div class="btn-group">
						{{ Form::select('admin_view', (['0'=>'New','1'=>'Seen']), ($row->admin_view == 0)?0:1, ['class' => 'change_admin_view','data-csrf' => csrf_token(), 'data-item' => $row->app_primary_id]) }}
					{{--*/ $id = SiteHelpers::encryptID($row->app_primary_id) /*--}}
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('loanapphistory/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach							
					</div>
				</td>				 
                </tr>
				@include('loanapphistory.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	@include('footer')
	
	</div>	  
	
<script>
    var _token = "{{ csrf_token() }}";
    function update_reason(app_primary_id){
        var reason = $('.reason_'+app_primary_id).val();
        $.ajax({
            url: "{{ url('/loanapp_update') }}",
            data: {"app_primary_id": app_primary_id, "reason": reason, "_token": _token},
            type: "POST",
            success: function(result) {
                if(result){
                    window.location.href = "/loanapphistory";
                }
            }
        });
    }
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("loanapphistory/multisearch")}}');
        $("[name='successful_applicant']").removeAttr('name');
		$('#SximoTable').submit();
	});
    $('.change_admin_view').on('change', function() {
        var app_primary_id = $(this).attr('data-item');
        var admin_view = $(this).val();

        $.ajax({
            url: "{{ url('/loanapp_update') }}",
            data: {"app_primary_id": app_primary_id, "admin_view": admin_view, "_token": _token},
            type: "POST",
            success: function(result) {
                if(result)
                    window.location.href = "/loanapphistory";
            }
        });
    });

    $('.successful_applicant_change').on('change', function() {
        var app_primary_id = $(this).attr('data-item');
        var successful_applicant = $(this).val();
        $.ajax({
            url: "{{ url('/loanapp_update') }}",
            data: {"app_primary_id": app_primary_id, "successful_applicant": successful_applicant, "_token": _token},
            type: "POST",
            success: function(result) {
                if(result){
                    window.location.href = "/loanapphistory";
                }

            }
        });
    });

    $('.processed_change').on('change', function() {
        var app_primary_id = $(this).attr('data-item');
        var processed = $(this).val();
        $.ajax({
            url: "{{ url('/loanapp_update') }}",
            data: {"app_primary_id": app_primary_id, "processed": processed, "_token": _token},
            type: "POST",
            success: function(result) {
                if(result){
                    window.location.href = "/loanapphistory";
                }

            }
        });
    });
	
});	
</script>		