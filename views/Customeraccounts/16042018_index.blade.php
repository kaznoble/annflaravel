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
			<li><a href="{{ URL::to('Customeraccounts/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/Customeraccounts') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1 && FALSE)
	   		<li><a href="{{ URL::to('Customeraccounts/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1 && FALSE)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>
	</div> 
	
	@if(Session::has('success'))
    <div class="alert alert-success fade in block-inner">
		<button data-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-checkmark-circle"></i> {{ Session::get('success') }} </div>
        
    </div>
    @endif
	
	@if(!empty($round_number))
	<div >
		<a href="/ViewEdit/{{$round_number}}" ><< RETURN TO ADMIN ROUND</a>
	</div>	
	<br />
	@endif
	
	@if(Session::has('message') && empty($payment_note))	  
		   {{ Session::get('message') }}
	@endif	
	@if( !empty($payment_note) )
		<div class="div_message_note" >
			{{ $payment_note }}
		</div>
	@endif
	{{ $details }}
	<div class="table-responsive">
    <table class="table table-striped ">
        <thead>
	 		{{ Form::open(array('url'=>'', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
			<tr id="sximo-quick-search" >
				<td> # </td>
				@if($access['is_detail'] ==1)<td> </td>@endif
				<td> </td>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<td {{ ($t['field'] == 'customer_no' ? 'class="td_customer_no"' : '') }} >			
						@if( $t['field'] == 'customer_no' )
							<input class="form-control input-sm" type="text" value="" name="customer_no" placeholder="C#########" >
						@else			
							@if( $t['field'] == 'account_no' )
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
			{{ Form::close() }}		
        </thead>

        <tbody>
			<tr>
				<th> No </th>
				<th> <input type="checkbox" class="checkall" /></th>
				@if($access['is_detail'] ==1) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
						<th>{{ $t['label'] }}</th>
					@endif
				@endforeach
				<th>{{ Lang::get('core.btn_action') }}</th>
			  </tr>
            @foreach ($rowData as $row)
                <tr>
					<td width="50"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->account_id }}" data-account_no="{{ $row->account_no }}" data-customer_no="{{ $row->customer_no }}" data-payment-type="{{ $row->payment_type }}" />  </td>	
					@if($access['is_detail'] ==1) <td >
						<a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->account_id) }}">
						<i class="icon-plus"></i></a>
					</td>	 
					@endif								
				 @foreach ($tableGrid as $field)
				 <!-- check load status -->
					 @if($field['view'] =='1')
					 <td @if($row->loan_status == '8' && ($row->payment_type == "Cash" || $row->payment_type == "Auto" || $row->payment_type == "")) style="background-color:#d67b7b;"
                          @elseif($row->loan_status == '1' && $row->payment_type == "Cash"  ) style="background-color:#97E2F7;"
                          @elseif($row->loan_status == '1' || $row->loan_status == '7') style="background-color:#CAEDBE;"
                          @else style="background-color:#EDCABE;" @endif >
						
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
							@if( $field['field'] == 'loan_start_date' || $field['field'] == 'loan_end_date' || $field['field'] == 'last_payment_made' )
								{{ SiteHelpers::gridDisplay(date("d/m/Y", strtotime($row->$field['field'])),$field['field'],$conn) }}
							@elseif( $field['field'] == 'next_payment_due_date' )
								@if( $row->loan_status == '2' )
									{{ 'Ended' }}
								@else
									{{ SiteHelpers::gridDisplay(date("d/m/Y", strtotime($row->$field['field'])),$field['field'],$conn) }}
								@endif						
							@else
								@if($field['field'] == 'balance' || $field['field'] == 'arrears')£@endif{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}	
								@if($field['field'] == 'customer_no')
								
								@endif
							@endif
							
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
				 <td>
				 	<div class="btn-group">
					{{--*/ $id = SiteHelpers::encryptID($row->account_id) /*--}}
				 	@if($access['is_detail'] ==1)
					<a href="{{ URL::to('Customeraccounts/show/'.$id)}}"  class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_view') }}"><i class="icon-paragraph-justify"></i> </a>
					@endif
					@if($access['is_edit'] ==1)
					<a  href="{{ URL::to('Customeraccounts/add/'.$id)}}"  class="tips btn btn-xs btn-success"  title="{{ Lang::get('core.btn_edit') }}"> <i class="icon-pencil4"></i></a>
					@endif
					@foreach($subgrid as $md)
					<a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}"  class="tips btn btn-xs btn-info"  title=" {{ $md['title'] }}">
						<i class="icon-eye2"></i></a>
					@endforeach							
					</div>
					{{--*/ $amountpence = SiteHelpers::poundpence($row->payment) /*--}}	
					<?php 
						// for initial payment setup
						$amountpence = 0;
					?>
					{{--*/ $sha1 = SiteHelpers::makesha1($merchantID,$orderid,$amountpence,$curr,$merchantsecret,$timestamp) /*--}}
										
					<div class="make_payment_button" >
						{{ Form::open(array('url'=>'Customeraccounts/destroy/', 'class'=>'form-horizontal' ,'id' =>'delete_form_' . $row->account_id )) }}
							<input type="hidden" name="id[]" value="{{ $row->account_id }}">
							<input type="hidden" name="customer_no" value="{{ $row->customer_no }}">							
							<a href="javascript://ajax" id="{{ $row->account_id }}"  onclick="SximoDelete({{ $row->account_id }});" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a>
						{{ Form::close() }}
					</div>					
					
				</td>				 
                </tr>
				
				@include('Customeraccounts.inlineview')
				
            @endforeach
              
        </tbody>
      
    </table>
	<!--{{ Form::close() }}-->
		
	</div>
	@include('footer')
	
	@if( !empty($_GET['search']) && $maxloansallowed )
		<div >
			<h3>Customer Info -</h3>
			<strong>Name:</strong> {{ $firstname }} {{ $lastname }}<br />
			<strong>First line of address:</strong> {{ $firstline }} <br />
			<strong>Date of Birth:</strong> {{ date('d/m/Y', strtotime($dob)); }} <br />
			<strong>Postcode:</strong> {{ $postcode }} <br />
			<strong>Email:</strong> {{ $email }}
		</div>
		<br /><br />	
	
		<a href="{{ URL::to( 'Customeraccounts/add/?cu='.$customer_no.'&ur='.SiteHelpers::encryptID($userID).'&form=new' )}}" class="btn btn-info" >ADD Account</a>	
	@endif
	
	</div>	  
	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("Customeraccounts/multisearch")}}');
		$('#SximoTable').submit();
	});

	$('.make_payment_submit').click(function() {
		var payment_id = $(this).attr('name');
		var firstPayment = $('#1st_amount_' + payment_id).val();
		firstPayment = firstPayment * 100;
		/* submit form */
		$('#payment_form_' + payment_id).submit();
	});
	$('.add_payment_schedule').click(function() {
		var payment_id = $(this).attr('name');
		var firstPayment = $('#1st_amount_' + payment_id).val();
		firstPayment = firstPayment * 100;
		/* submit form */
		/*$('#add_payment_form_' + payment_id).submit();*/
		location.href = "{{ $baseurl }}/cardpayment/add/" + account_id;
	});	
	
	$('.add_cash_submit').click(function(e) {
		e.preventDefault();

        	var payment_id = $(this).attr('name');
        	var account_id = $('#account_id_' + payment_id).val();        	
			var addpayment = $('#add_amount_' + payment_id).val();
			var accountno = $('#account_no_' + payment_id).val();
			var payoff_arrears = $('#payoff_arrears_' + payment_id).val();
			var payoff_no_arrears = $('#payoff_no_arrears_' + payment_id).val();
			var keep_next_payment_date = $('#keep_next_payment_date_' + payment_id).val();
			addpayment = addpayment * 100;
            location.href = "/Cashpayment/add/" + account_id;

	});		
	$('.add_payment_submit').click(function(e) {
		e.preventDefault();
        if (window.confirm("Are you sure?")) {
        	var payment_id = $(this).attr('name');
        	var account_id = $('#account_id_' + payment_id).val();        	
			var addpayment = $('#add_amount_' + payment_id).val();
			var accountno = $('#account_no_' + payment_id).val();
			addpayment = addpayment * 100;
            location.href = "{{ $baseurl }}/realpayment/realauth_addpayment.php?account_no="+accountno+"&payment="+addpayment+"&id="+account_id;
        }
	});	
	$('.add_payment_submit_sche').click(function(e) {
		e.preventDefault();
        var payment_id = $(this).attr('name');
        var account_id = $('#account_id_sche' + payment_id).val();        	
		var addpayment = $('#add_amount_sche' + payment_id).val();
		var accountno = $('#account_no_sche' + payment_id).val();
		addpayment = addpayment * 100;
		location.href = "{{ $baseurl }}/cardpayment/add/" + account_id;
        /*location.href = "{{ $baseurl }}/realpayment/realauth_addpayment.php?account_no="+accountno+"&payment="+addpayment+"&id="+account_id+"&schedule=TRUE";*/
	});		
	$('.update_card_submit').click(function(e) {
		e.preventDefault();
        if (window.confirm("Are you sure?")) {
        	var payment_id = $(this).attr('name');
        	var account_id = $('#account_id_update' + payment_id).val();        	
			var accountno = $('#account_no_update' + payment_id).val();
			var customerno = $('#customer_no_update' + payment_id).val();
			var card_name = $('#card_name_' + payment_id).val();
			var card_number = $('#card_number_' + payment_id).val();
			var card_expiry = $('#card_expiry_' + payment_id).val() + $('#card_expiry_yr' + payment_id).val();
			var card_type = $('#card_type_' + payment_id + ' option:selected').val();
            location.href = "{{ $baseurl }}/realpayment/realauth_cardupdate.php?account_no="+accountno+"&customer_no="+customerno+"&id="+account_id+"&card_name="+card_name+"&card_number="+card_number+"&card_expiry="+card_expiry+"&card_type="+card_type;
        }
	});			
	$('.payoff_arrears').click(function(e) {
		//e.preventDefault();
		var rowID = $(this).attr('name');
		if( $('#payoff_arrears_' + rowID).is(':checked') )
		{
			$('#payoff_arrears_' + rowID).val('1');
		}
		else
		{
			$('#payoff_arrears_' + rowID).val('0');	
			$('#payoff_no_arrears_' + rowID).val('');			
		}				
		$('.div_payoff_no_arrears_' + rowID).toggle();
	});
	$('.keep_next_payment_date').click(function(e) {
		var rowID = $(this).attr('name');	
		if( $('#keep_next_payment_date_' + rowID).is(':checked') )
		{
			$('#keep_next_payment_date_' + rowID).val('1');
		}
		else
		{
			$('#keep_next_payment_date_' + rowID).val('0');					
		}
	});
	
   $(".ids").click(function(){
        if($('.ids').is(':checked'))
        {
	
         var getval = $(this).data('account_no');
        // alert(getval);
        $("#search_account").val(getval)
        }
    });
	
	
});	
</script>		
