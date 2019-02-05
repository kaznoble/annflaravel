
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
		<li><a href="{{ URL::to('customerdomestic') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'customerdomestic/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Customer Domestic Partner</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  {{ Form::text('customer_no', $row['customer_no'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  {{ Form::text('user_id', $row['user_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Employment Status" class=" control-label col-md-4 text-left"> Employment Status <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  <select name='employment_status' rows='5' id='employment_status' code='{$employment_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Occupation" class=" control-label col-md-4 text-left"> Occupation <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('occupation', $row['occupation'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Employee Name" class=" control-label col-md-4 text-left"> Employee Name <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('employee_name', $row['employee_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 1" class=" control-label col-md-4 text-left"> Work Address 1 <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_1', $row['work_address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 2" class=" control-label col-md-4 text-left"> Work Address 2 <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_2', $row['work_address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 3" class=" control-label col-md-4 text-left"> Work Address 3 <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_3', $row['work_address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Address 4" class=" control-label col-md-4 text-left"> Work Address 4 <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_address_4', $row['work_address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Work Postcode" class=" control-label col-md-4 text-left"> Work Postcode <span class="require_style">*</span> </label>
									<div class="col-md-8">
									  {{ Form::text('work_postcode', $row['work_postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('customerdomestic') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#employment_status").jCombo("{{ URL::to('customerdomestic/comboselect?filter=employment_status:id:description') }}",
		{  selected_value : '{{ $row["employment_status"] }}' });
		
		$('#employment_status').change(function(){
			var empOption = $('#employment_status option:selected').val();
			if(empOption == '4' || empOption == '6' || empOption == '7' || empOption == '8' || empOption == '9')
			{
				$('.require_style').hide();
			}
			else
			{
				$('.require_style').show();
			}
		});		
		 
	});
	</script>		 