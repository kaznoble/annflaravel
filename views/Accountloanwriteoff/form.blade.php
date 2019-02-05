
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
		<li><a href="{{ URL::to('Accountloanwriteoff') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Accountloanwriteoff/save/'.SiteHelpers::encryptID($row['account_no']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Account Loan Write Off</legend>
									
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  {{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left"> Account No </label>
									<div class="col-md-8">
									  {{ Form::text('account_no', $row['account_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Date Of Write Off" class=" control-label col-md-4 text-left"> Date Of Write Off </label>
									<div class="col-md-8">
									  {{ Form::text('date_of_write_off', $row['date_of_write_off'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Amount" class=" control-label col-md-4 text-left"> Amount </label>
									<div class="col-md-8">
									  {{ Form::text('amount', $row['amount'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reason" class=" control-label col-md-4 text-left"> Reason </label>
									<div class="col-md-8">
									  {{ Form::text('reason', $row['reason'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Number Entered" class=" control-label col-md-4 text-left"> Staff Number Entered </label>
									<div class="col-md-8">
									  <select name='staff_number_entered' rows='5' id='staff_number_entered' code='{$staff_number_entered}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Number Approved" class=" control-label col-md-4 text-left"> Staff Number Approved </label>
									<div class="col-md-8">
									  <select name='staff_number_approved' rows='5' id='staff_number_approved' code='{$staff_number_approved}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Accountloanwriteoff') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#staff_number_entered").jCombo("{{ URL::to('Accountloanwriteoff/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["staff_number_entered"] }}' });
		
		$("#staff_number_approved").jCombo("{{ URL::to('Accountloanwriteoff/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["staff_number_approved"] }}' });
		 
	});
	</script>		 