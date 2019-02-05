
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
		<li><a href="{{ URL::to('dailypayment') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'dailypayment/save/'.SiteHelpers::encryptID($row['account_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Daily Payment</legend>
									
								  <div class="form-group  " >
									<label for="Account Id" class=" control-label col-md-4 text-left"> Account Id </label>
									<div class="col-md-8">
									  <textarea name='account_id' rows='2' id='account_id' class='form-control '  
				           >{{ $row['account_id'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left"> Account No </label>
									<div class="col-md-8">
									  {{ Form::text('account_no', $row['account_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  <select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Payment" class=" control-label col-md-4 text-left"> Payment </label>
									<div class="col-md-8">
									  {{ Form::text('payment', $row['payment'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Next Payment Due Date" class=" control-label col-md-4 text-left"> Next Payment Due Date </label>
									<div class="col-md-8">
									  {{ Form::text('next_payment_due_date', $row['next_payment_due_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('dailypayment') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#customer_no").jCombo("{{ URL::to('dailypayment/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		 
	});
	</script>		 