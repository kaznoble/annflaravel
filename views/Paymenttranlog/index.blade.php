{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

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
			<!--@if($access['is_excel'] ==1)
			<li><a href="{{ URL::to('Paymenttranlog/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/Paymenttranlog') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Paymenttranlog/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif-->
	  </ul>
	</div>  	
	
	@if(!empty(Session::get('round_number')))
	<div >
		<a href="/ViewEdit/{{Session::get('round_number')}}" ><< RETURN TO ADMIN ROUND</a>
	</div>	
	<br />
	@endif			
	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'Paymenttranlog/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
        	<tr class="custom-datepicker">
        		<td colspan="3" style="border:none"> 
					<select name='date_type'  class='form-control' onchange="datechange(this)">
								<option value=''> -- All  -- </option>
								<option {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']==1) ? 'selected' : ''}} value='1'>Last 7 Days</option>
								<option {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']==2) ? 'selected' : ''}} value='2'>Last 30 Days</option>
								<option {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']==3) ? 'selected' : ''}} value='3'>This Month</option>
								<option {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']==4) ? 'selected' : ''}} value='4'>Last Month</option>
								<option {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']==5) ? 'selected' : ''}} value='5'>Custom Range</option>
							</select>
				</td> 	
				<td colspan="2" style="border:none; {{ (isset($queryStrings['date_type']) && $queryStrings['date_type']!=5) ? 'display:none' : ''}}" class="dateinput">
					<input class="form-control input-sm date" type="text" value="{{(isset($queryStrings['start_date'])) ? $queryStrings['start_date'] : ''}}" name="start_date" placeholder="Start Date" >
				</td> 
				<td colspan="2" style="border:none;{{ (isset($queryStrings['date_type']) && $queryStrings['date_type']!=5) ? 'display:none' : ''}}" class="dateinput">
					<input class="form-control input-sm date" type="text" value="{{(isset($queryStrings['end_date'])) ? $queryStrings['end_date'] : ''}}" name="end_date" placeholder="End Date" >

				</td>
				<td colspan="2" style="border:none">
					<button type="button"  class=" do-quick-search btn btn-sx btn-warning"> SUBMIT</button></td>

				</td>
			</tr>	
			<tr>
				@if($access['is_detail'] ==1)<td> </td>@endif
				<td></td>
				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1' && $t['field'] != 'user_id' && $t['field'] != 'tran_id')
					
					<td {{ ($t['field'] == 'customer_no' ? 'class="td_customer_no"' : '') }} >	
						@if( $t['field'] == 'forename' )
							<input class="form-control input-sm" type="text" value="{{(isset($queryStrings['forename'])) ? $queryStrings['forename'] : ''}}" name="forename" placeholder="first name" >
						@elseif( $t['field'] == 'surname' )
							<input class="form-control input-sm" type="text" value="{{(isset($queryStrings['surname'])) ? $queryStrings['surname'] : ''}}" name="surname" placeholder="last name" >
						@elseif( $t['field'] == 'customer_no' )
							<input class="form-control input-sm" type="text" value="{{(isset($queryStrings['customer_no'])) ? $queryStrings['customer_no'] : ''}}" name="customer_no" placeholder="C#########" >
						@elseif( $t['field'] == 'account_no' )
							<input class="form-control input-sm" type="text" value="{{(isset($queryStrings['account_no'])) ? $queryStrings['account_no'] : ''}}" name="account_no">
						@elseif( $t['field'] == 'type_of_payment' )
							<select name='type_of_payment'  class='form-control'>
								<option value=''> -- All  -- </option>
								<option value='1' {{ (isset($queryStrings['type_of_payment']) && $queryStrings['type_of_payment']==1) ? 'selected' : ''}} >Scheduled Payment</option>
								<option value='2' {{ (isset($queryStrings['type_of_payment']) && $queryStrings['type_of_payment']==2) ? 'selected' : ''}}>Card Payment</option>
								<option value='3' {{ (isset($queryStrings['type_of_payment']) && $queryStrings['type_of_payment']==3) ? 'selected' : ''}}>Cash Payment</option>
								<option value='4' {{ (isset($queryStrings['type_of_payment']) && $queryStrings['type_of_payment']==4) ? 'selected' : ''}}>Reduced Payment</option>
							</select>
							<!-- <input class="form-control input-sm" type="text" value="" name="type_of_payment" placeholder="type_of_payment " >	 -->
						@elseif( $t['field'] == 'pay_success' )
							<select name='pay_success'  class='form-control'>
								<option value=''> -- All  -- </option>
								<option value='1' {{ (isset($queryStrings['pay_success']) && $queryStrings['pay_success']==1) ? 'selected' : ''}}>Success</option>
								<option value='0' {{ (isset($queryStrings['pay_success']) && $queryStrings['pay_success']==0) ? 'selected' : ''}}>Fail</option>
							</select>
						@elseif( $t['field'] == 'date' )
							
						@else			
							<?php $queryVal = isset($queryStrings[$t['field']]) ? $queryStrings[$t['field']] : ''	?>
							{{ SiteHelpers::transForm($t['field'] , $tableForm,false,$queryVal) }}
						@endif
					</td>
					@endif
				@endforeach
				<td style="width:100px;">
				<input type="hidden"  value="Search">
				<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
			  </tr>
        </thead>

		<?php $prev_ptl_date = ''; ?>

        <tbody>
			<tr id="sximo-quick-search" >
				<!--<th> No </th>-->
				<th> <input type="checkbox" class="checkall" /></th>
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1' && $t['field'] != 'user_id' && $t['field'] != 'tran_id')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th>{{ Lang::get('core.btn_action') }}</th>
			  </tr>				
            @foreach ($rowData as $row)
            	<?php
            		$date_tab = false;
            		$ptl_date = date('Y-m-d',strtotime($row->date));
            		if( $prev_ptl_date != $ptl_date)
            			$date_tab = true; $prev_ptl_date = date('Y-m-d',strtotime($row->date));
            		//echo $ptl_date;
            		if( $date_tab ) {
            	?>
            	<tr style="height:10px;" >
            		<td colspan="15" ></td>
            	</tr>
            	<tr>
            		<td colspan="15" style="background-color: #bbcbf4;font-weight:bold;" >{{ date('D, d F Y', strtotime($ptl_date)) }}</td>
            	</tr>
            	<?php } ?>
                <tr>
					<!--<td width="50"> {{ ++$i }} </td>-->
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->tran_id }}" />  </td>	
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->tran_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif								
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1' && $field['field'] != 'user_id' && $field['field'] != 'tran_id' )
					 <td>					 
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							@if($field['field'] == 'pay_success')
								@if($row->$field['field'] == 1)
									<span style="font-weight:bold;color:#3fc04b;" >SUCCESS</span>
								@else
									<span style="font-weight:bold;color:red;" >FAIL</span>
								@endif
							@else
								{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
								{{  
									SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}	
							@endif
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
				 <td>
				 	<div class="btn-group">
					{{--*/ $id = SiteHelpers::encryptID($row->tran_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<!--<a href="{{ URL::to('Paymenttranlog/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>-->
					@endif
					@if($access['is_edit'] ==1)
					<!--<a  href="{{ URL::to('Paymenttranlog/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>-->
					@endif
					@foreach($subgrid as $md)
					<!--<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>-->
					@endforeach							
					</div>
				</td>				 
                </tr>
				@include('Paymenttranlog.inlineview')
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	@include('footer')
	
	</div>	  
	
<script>
function datechange(obj){
	var value= $(obj).val();
	if(value == 5){
		$('.custom-datepicker').find('.dateinput').show();
	}else{
		$('.custom-datepicker').find('.dateinput').hide();		
	}
	console.log(value);
}

$(document).ready(function(){
	datechange('');

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
  		$('#daterangepicker').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	});

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("Paymenttranlog/multisearch")}}');
		$('#SximoTable').submit();
	});

	$('#daterangepicker').daterangepicker({
	autoApply:true,
	autoUpdateInput: false,
	locale: {
            format: 'DD/MM/YYYY',

    },
    ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }

  });
});	
</script>