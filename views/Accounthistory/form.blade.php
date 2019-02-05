
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
		<li><a href="{{ URL::to('Accounthistory') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Accounthistory/save/'.SiteHelpers::encryptID($row['acc_history_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Account History</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Acc History Id" class=" control-label col-md-4 text-left"> Acc History Id </label>
									<div class="col-md-8">
									  {{ Form::text('acc_history_id', $row['acc_history_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									  {{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Date Time" class=" control-label col-md-4 text-left"> Date Time </label>
									<div class="col-md-8">
									  
				{{ Form::text('date_time', $row['date_time'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Period No" class=" control-label col-md-4 text-left"> Period No </label>
									<div class="col-md-8">
									  {{ Form::text('period_no', $row['period_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Week No" class=" control-label col-md-4 text-left"> Week No </label>
									<div class="col-md-8">
									  {{ Form::text('week_no', $row['week_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Payment Due" class=" control-label col-md-4 text-left"> Payment Due </label>
									<div class="col-md-8">
									  {{ Form::text('payment_due', $row['payment_due'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 	
								  <div class="form-group  " >
									<label for="Debits" class=" control-label col-md-4 text-left"> Debits </label>
									<div class="col-md-8">
									  {{ Form::text('debits', $row['debits'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 	
								  <div class="form-group  " >
									<label for="Credits" class=" control-label col-md-4 text-left"> Credits </label>
									<div class="col-md-8">
									  {{ Form::text('credits', $row['credits'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 	
								  <div class="form-group  " >
									<label for="Balance" class=" control-label col-md-4 text-left"> Balance </label>
									<div class="col-md-8">
									  {{ Form::text('balance', $row['balance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div>
								  <div class="form-group  " >
									<label for="Transaction Type" class=" control-label col-md-4 text-left"> Transaction Type </label>
									<div class="col-md-8">
									  <select name='transaction_type' rows='5' id='transaction_type' code='{$transaction_type}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Accounthistory') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
	
		$("#transaction_type").jCombo("{{ URL::to('Accounthistory/comboselect?filter=transaction_type:id:description') }}",
		{  selected_value : '{{ $row["transaction_type"] }}' });	
		 
	});
	</script>		 