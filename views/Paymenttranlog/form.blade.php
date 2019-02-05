
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
		<li><a href="{{ URL::to('Paymenttranlog') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Paymenttranlog/save/'.SiteHelpers::encryptID($row['tran_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Payment Log</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Tran Id" class=" control-label col-md-4 text-left label_bold"> Tran Id </label>
									<div class="col-md-8">
									  {{ Form::text('tran_id', $row['tran_id'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tran No" class=" control-label col-md-4 text-left label_bold"> Tran No </label>
									<div class="col-md-8">
									  {{ Form::text('tran_no', $row['tran_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left label_bold"> Customer No </label>
									<div class="col-md-8">
									  <select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' disabled="disabled" 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="User Id" class=" control-label col-md-4 text-left label_bold" > User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' disabled="disabled" 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Account No" class=" control-label col-md-4 text-left label_bold"> Account No </label>
									<div class="col-md-8">
									  <select name='account_no' rows='5' id='account_no' code='{$account_no}' disabled="disabled"
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Date" class=" control-label col-md-4 text-left label_bold"> Date </label>
									<div class="col-md-8">
									  
				{{ Form::text('date', $row['date'],array('class'=>'form-control', 'style'=>'width:150px !important;', 'readonly'=>'true' )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Week No" class=" control-label col-md-4 text-left label_bold"> Week No </label>
									<div class="col-md-8">
									  {{ Form::text('week_no', $row['week_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Pay Success" class=" control-label col-md-4 text-left label_bold"> Pay Success </label>
									<div class="col-md-8">
									  
					<select name='pay_success' rows='5' id='pay_success' disabled="disabled"   
					class='select2 form-control '   >
						
							<option  value ='0' 
							@if($row['pay_success'] =='0')
								selected="selected"
							@endif
							>N</option>
							<option  value ='1' 
							@if($row['pay_success'] =='1')
								selected="selected"
							@endif
							>Y</option>
					</select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Created At" class=" control-label col-md-4 text-left label_bold"> Created At </label>
									<div class="col-md-8">
									  
				{{ Form::text('created_at', $row['created_at'],array('class'=>'form-control', 'style'=>'width:150px !important;', 'readonly'=>'true')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Updated At" class=" control-label col-md-4 text-left label_bold"> Updated At </label>
									<div class="col-md-8">
									  
				{{ Form::text('updated_at', $row['updated_at'],array('class'=>'form-control', 'style'=>'width:150px !important;', 'readonly'=>'true')) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<!--<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Paymenttranlog') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>-->
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#customer_no").jCombo("{{ URL::to('Paymenttranlog/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Paymenttranlog/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		
		$("#account_no").jCombo("{{ URL::to('Paymenttranlog/comboselect?filter=customer_accounts:account_no:account_no') }}",
		{  selected_value : '{{ $row["account_no"] }}' });
		 
	});
	</script>		 