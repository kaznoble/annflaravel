
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
		<li><a href="{{ URL::to('complaints') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'complaints/save/'.SiteHelpers::encryptID($row['complaint_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Complaints</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Complaint Id" class=" control-label col-md-4 text-left"> Complaint Id </label>
									<div class="col-md-8">
									  {{ Form::text('complaint_id', $row['complaint_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Complaint No" class=" control-label col-md-4 text-left"> Complaint No </label>
									<div class="col-md-8">
									  {{ Form::text('complaint_no', $row['complaint_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer Name" class=" control-label col-md-4 text-left"> Customer Name </label>
									<div class="col-md-8">
									  {{ Form::text('customer_name', $row['customer_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address line one" class=" control-label col-md-4 text-left"> Address line one </label>
									<div class="col-md-8">
									  {{ Form::text('address_1', $row['address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address line two" class=" control-label col-md-4 text-left"> Address line two </label>
									<div class="col-md-8">
									  {{ Form::text('address_2', $row['address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode" class=" control-label col-md-4 text-left"> Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('postcode', $row['postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone" class=" control-label col-md-4 text-left"> Telephone </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_1', $row['telephone_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Email Address" class=" control-label col-md-4 text-left"> Email Address </label>
									<div class="col-md-8">
									  {{ Form::text('email_address', $row['email_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Pref Contact Method" class=" control-label col-md-4 text-left"> Pref Contact Method </label>
									<div class="col-md-8">
									  <select name='pref_contact_method' rows='5' id='pref_contact_method' code='{$pref_contact_method}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Like To Contacted" class=" control-label col-md-4 text-left"> Like To Contacted </label>
									<div class="col-md-8">
									  {{ Form::text('like_to_contacted', $row['like_to_contacted'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Complaint" class=" control-label col-md-4 text-left"> Complaint </label>
									<div class="col-md-8">
									  <textarea name='complaint' rows='2' id='complaint' class='form-control '  
				           >{{ $row['complaint'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Complaint Status" class=" control-label col-md-4 text-left"> Complaint Status </label>
									<div class="col-md-8">
									  <select name='complaint_status' rows='5' id='complaint_status' code='{$complaint_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Received Date" class=" control-label col-md-4 text-left"> Received Date </label>
									<div class="col-md-8">
									  
				{{ Form::text('created_at', $row['created_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('complaints') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#pref_contact_method").jCombo("{{ URL::to('complaints/comboselect?filter=method_of_contact:id:description') }}",
		{  selected_value : '{{ $row["pref_contact_method"] }}' });
		
		$("#complaint_status").jCombo("{{ URL::to('complaints/comboselect?filter=complaint_status:id:description') }}",
		{  selected_value : '{{ $row["complaint_status"] }}' });
		 
	});
	</script>		 