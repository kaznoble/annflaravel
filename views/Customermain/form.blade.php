
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
		<li><a href="{{ URL::to('Customermain') }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
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
	<div class="panel-default panel">
		<div class="panel-body">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'Customermain/save/'.SiteHelpers::encryptID($row['cust_main_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
                            <div class="col-md-12" >
                                <fieldset><legend> Add/Edit Customer Main</legend>
                            </div>	
                            <div class="col-xs-6">								
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Main Id" class=" control-label col-md-4 text-left"> Cust Main Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_main_id', $row['cust_main_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  {{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>true   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Name" class=" control-label col-md-4 text-left"> Name </label>
									<div class="col-md-8">
									  {{ Form::text('name', $row['name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Account" class=" control-label col-md-4 text-left"> Account </label>
									<div class="col-md-8">
									  {{ Form::text('account', $row['account'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
									<div class="col-md-8">
									  <select name='status' rows='5' id='status' code='{$status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Seen" class=" control-label col-md-4 text-left"> Last Seen Date </label>
									<div class="col-md-8">
									  
				{{ Form::text('seen', date('d/m/Y',strtotime($row['seen'])),array('class'=>'form-control datetime',  'readonly'=>true, 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Visits" class=" control-label col-md-4 text-left"> Visits </label>
									<div class="col-md-8">
									  {{ Form::text('visits', $row['visits'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>true   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Round Number" class=" control-label col-md-4 text-left"> Round Number </label>
									<div class="col-md-8">
										{{ Form::text('round_number', (!empty($row['round_number']) ? $row['round_number'] : 0),array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>true   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Name" class=" control-label col-md-4 text-left"> Staff Name </label>
									<div class="col-md-8">
									  {{ Form::text('staff_name', $row['staff_name'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>true   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Preferred Frequency" class=" control-label col-md-4 text-left"> Preferred Frequency </label>
									<div class="col-md-8">
									  <select name='preferred_frequency' rows='5' id='preferred_frequency' code='{$preferred_frequency}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Preferred Payment Day" class=" control-label col-md-4 text-left"> Preferred Payment Day </label>
									<div class="col-md-8">
									  <select name='preferred_payment_day' rows='5' id='preferred_payment_day' code='{$preferred_payment_day}' 
							class='select2 '    >
										</select> 
									 </div> 
								  </div> 
								  <div class="form-group  " >
									<label for="Preferred Pay Method" class=" control-label col-md-4 text-left"> Preferred Payment Method </label>
									<div class="col-md-8">
									  <select name='preferred_payment_method' rows='5' id='preferred_payment_method' code='{$preferred_payment_method}' 
							class='select2 '    >
											<option value="" >-- Please Select --</option>							
											<option value="Auto" {{ ($row['preferred_payment_method'] == 'Auto' ? 'selected=selected' : '') }} >Auto</option>
											<option value="Cash" {{ ($row['preferred_payment_method'] == 'Cash' ? 'selected=selected' : '') }}>Cash</option>											
										</select> 
									 </div> 
								  </div> 								  
								  <div class="form-group  " >
									<label for="Preferred Time To Call" class=" control-label col-md-4 text-left"> Preferred Time To Call </label>
									<div class="col-md-8">
									  {{ Form::text('preferred_time_to_call', $row['preferred_time_to_call'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
                 
                        <div class="col-xs-6">
                            <div class="form-group  " >
				<label for="Group Id" class=" control-label col-md-4 text-left"> GROUP ID </label>
				<div class="col-md-8">
				  {{ Form::text('group_id', $row['group_id'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>true   )) }} 
				</div> 
                            </div>
                            
                            <div class="form-group panel panel-default pt-3" style="margin-top:100px;" >
                                <div class="col-md-8 panel-body">
                                    <h4 >List Current Active Accounts</h4>
                                    <div >
                                        <table class="table table-striped">
                                            <thead>
                                            <tr><th >Account No</th><th >Letter Sent</th></tr>
                                            </thead>
                                        @foreach($accountsLetter as $accountslet)
                                              <tr>
                                                <td>
                                                  {{ $accountslet->account_no }}
                                                </td>
                                                <td>                                                   
                                                    {{--*/ $stepyesno = SiteHelpers::lettersent($accountslet->account_no, $accountslet->arrears_letter) /*--}}
                                                    @if( $stepyesno == 'yes' )
                                                        {{ 'Letter ' . ($accountslet->arrears_letter - 1) . ' has been sent' }}
                                                    @else
                                                        {{--*/ $letterdesc = SiteHelpers::getletterdesc($accountslet->arrears_letter) /*--}}
                                                        {{ $letterdesc }}
                                                    @endif
                                                </td>
                                              </tr>
                                        @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customermain') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
                 
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#status").jCombo("{{ URL::to('Customermain/comboselect?filter=customer_status:id:description') }}",
		{  selected_value : '{{ $row["status"] }}' });
		
		$("#preferred_frequency").jCombo("{{ URL::to('Customermain/comboselect?filter=frequency:id:freq_desc&order=freq_order') }}",
		{  selected_value : '{{ $row["preferred_frequency"] }}' });
		
		$("#preferred_payment_day").jCombo("{{ URL::to('Customermain/comboselect?filter=days:day_id:day_desc') }}",
		{  selected_value : '{{ $row["preferred_payment_day"] }}' });

		$("#round_number").jCombo("{{ URL::to('Customermain/comboselect?filter=round_config:round_number:round_number') }}",
		{  selected_value : '{{ $row["round_number"] }}' });		

		$('#round_number').change(function() {
			if(this.value !== '') {
				$.ajax({url: "/../../ajax/round_config.php?round_number=" + this.value, success: function(result){
					$('input[name=staff_name]').val(result);
				}});
			}
		});
		 
	});
	</script>		 