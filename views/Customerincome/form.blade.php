
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
		<li><a href="{{ URL::to('Customerincome') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Customerincome/save/'.SiteHelpers::encryptID($row['cust_income_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Income</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Income Id" class=" control-label col-md-4 text-left"> Cust Income Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_income_id', $row['cust_income_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  <select name='user_id' rows='5' id='user_id' code='{$user_id}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Income Frequency" class=" control-label col-md-4 text-left"> Income Frequency </label>
									<div class="col-md-8">
									  {{ Form::text('income_frequency', $row['income_frequency'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Wage 1" class=" control-label col-md-4 text-left"> Wage 1 </label>
									<div class="col-md-8">
									  {{ Form::text('wage_1', $row['wage_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Wage 2" class=" control-label col-md-4 text-left"> Wage 2 </label>
									<div class="col-md-8">
									  {{ Form::text('wage_2', $row['wage_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Benefit" class=" control-label col-md-4 text-left"> Child Benefit </label>
									<div class="col-md-8">
									  {{ Form::text('child_benefit', $row['child_benefit'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Child Tax Credit" class=" control-label col-md-4 text-left"> Child Tax Credit </label>
									<div class="col-md-8">
									  {{ Form::text('child_tax_credit', $row['child_tax_credit'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Maintenance Payments" class=" control-label col-md-4 text-left"> Maintenance Payments </label>
									<div class="col-md-8">
									  {{ Form::text('maintenance_payments', $row['maintenance_payments'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other" class=" control-label col-md-4 text-left"> Other </label>
									<div class="col-md-8">
									  {{ Form::text('other', $row['other'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description" class=" control-label col-md-4 text-left"> Other Description </label>
									<div class="col-md-8">
									  {{ Form::text('other_description', $row['other_description'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Income Total" class=" control-label col-md-4 text-left"> Income Total </label>
									<div class="col-md-8">
									  {{ Form::text('income_total', $row['income_total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customerincome') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#customer_no").jCombo("{{ URL::to('Customerincome/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#user_id").jCombo("{{ URL::to('Customerincome/comboselect?filter=users:id:id') }}",
		{  selected_value : '{{ $row["user_id"] }}' });
		 
	});
	</script>		 