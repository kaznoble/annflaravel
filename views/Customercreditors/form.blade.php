
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
		<li><a href="{{ URL::to('Customercreditors') }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	</div>  
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
		 {{ Form::open(array('url'=>'Customercreditors/save/'.SiteHelpers::encryptID($row['cust_cred_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Creditors</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Cred Id" class=" control-label col-md-4 text-left"> Cust Cred Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_cred_id', $row['cust_cred_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;" >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
										@if( !empty($row['customer_no']) )
											{{ $row['customer_no'] }}
										@else
									  		<select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' class='select2 '    ></select> 										
										@endif
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>--> 					
								  <div class="form-group  " >
									<label for="Credit Cards" class=" control-label col-md-4 text-left"> Credit Cards </label>
									<div class="col-md-8">
									  £ {{ Form::text('credit_cards', $row['credit_cards'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loans" class=" control-label col-md-4 text-left"> Loans </label>
									<div class="col-md-8">
									  £ {{ Form::text('loans', $row['loans'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other" class=" control-label col-md-4 text-left"> Other </label>
									<div class="col-md-8">
									  £ {{ Form::text('other', (!empty($row['other']) ? $row['other'] : '0.00'),array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Other" class=" control-label col-md-4 text-left"> Total </label>
									<div class="col-md-8">
									  £ {{ Form::text('creditors_total', '',array('class'=>'form-control', 'placeholder'=>'', 'readonly' => 'true',   )) }} 
									 </div> 
								  </div> 									  
								  <div class="form-group  " >
									<label for="Denied Credit" class=" control-label col-md-4 text-left"> Denied Credit </label>
									<div class="col-md-8">
									  <select name='denied_credit' rows='5' id='denied_credit' code='{$denied_credit}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="Ccj" class=" control-label col-md-4 text-left label_bold"> County Court Judgement <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='ccj' rows='5' id='ccj' code='{$ccj}' 
							class='select2 '    ></select> 
									 </div> 
								  </div>--> 					
								  <!--<div class="form-group  " >
									<label for="Ccj Details" class=" control-label col-md-4 text-left label_bold"> County Court Judgement Details </label>
									<div class="col-md-8">
									  {{ Form::text('ccj_details', $row['ccj_details'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>--> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customercreditors') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				<input type="hidden" name="userid" value="{{$row['user_id']}}" />
				<input type="hidden" name="customer_no" value="{{ $customer_no }}" />
				<input type="hidden" name="user_id" value="{{$row['user_id']}}" />				
				<input type="hidden" name="type" value="{{ $type }}" />				
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		creditors_total();
		
		$("#customer_no").jCombo("{{ URL::to('Customercreditors/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Customercreditors/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#denied_credit").jCombo("{{ URL::to('Customercreditors/comboselect?filter=ccj:id:ccj') }}",
		{  selected_value : '{{ $row["denied_credit"] }}' });
		
		/*$("#ccj").jCombo("{{ URL::to('Customercreditors/comboselect?filter=ccj:id:ccj') }}",
		{  selected_value : '{{ $row["ccj"] }}' });*/
		
		$('input[name="credit_cards"],input[name="loans"],input[name="other"]').keyup(function() {
			creditors_total();
		});			 
	});
	
	function creditors_total()
	{
		var total = 0;
		total = parseCurrency($('input[name="credit_cards"]').val()) + parseCurrency($('input[name="loans"]').val()) + parseCurrency($('input[name="other"]').val());
		$('input[name="creditors_total"]').val(total.toFixed(2));
	}		
	
	function parseCurrency( num ) {
	    return parseFloat( num.replace( /,/g, '') );
	}	
	
	</script>		 