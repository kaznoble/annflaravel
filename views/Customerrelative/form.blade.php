
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
		<li><a href="{{ URL::to('Customerrelative') }}">{{ $pageTitle }}</a></li>
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
	
	@if( !empty($id) && empty(Session::get('round_number')) )
	<div class="back_next_button" >
		<a href="../../Customerdetails/add" ><< Back</a>
	</div>
	@endif
	
	<div class="panel-default panel">
		<div class="panel-body">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'Customerrelative/save/'.SiteHelpers::encryptID($row['cust_rel_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Relative</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Rel Id" class=" control-label col-md-4 text-left"> Cust Rel Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_rel_id', $row['cust_rel_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Customer No" class=" control-label col-md-4 text-left"> Customer No </label>
									<div class="col-md-8">
									  @if( !empty($row['cust_rel_id']) )
									  	{{ $row['customer_no'] }}
									  @else
									  	<select name='customer_no' rows='5' id='customer_no' code='{$customer_no}' class='select2 ' ></select> 
									  @endif
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="User Id" class=" control-label col-md-4 text-left"> User Id </label>
									<div class="col-md-8">
									  {{ Form::text('user_id', $row['user_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Title" class=" control-label col-md-4 text-left"> Title </label>
									<div class="col-md-8">
									  <select name='title' rows='5' id='title' code='{$title}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Forename" class=" control-label col-md-4 text-left"> Forename </label>
									<div class="col-md-8">
									  {{ Form::text('forename', $row['forename'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Surname" class=" control-label col-md-4 text-left"> Surname </label>
									<div class="col-md-8">
									  {{ Form::text('surname', $row['surname'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Middle Names" class=" control-label col-md-4 text-left"> Middle Names </label>
									<div class="col-md-8">
									  {{ Form::text('middle_names', $row['middle_names'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " style="display:none;" >
									<label for="Marital Status" class=" control-label col-md-4 text-left"> Marital Status </label>
									<div class="col-md-8">
									  <select name='marital_status' rows='5' id='marital_status' code='{$marital_status}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " style="display:none;" >
									<label for="Ni Number" class=" control-label col-md-4 text-left"> Ni Number </label>
									<div class="col-md-8">
									  {{ Form::text('ni_number', $row['ni_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " style="display:none;" >
									<label for="No Children Under 18" class=" control-label col-md-4 text-left"> No Children Under 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_children_under_18', $row['no_children_under_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " style="display:none;" >
									<label for="No Res Over 18" class=" control-label col-md-4 text-left"> No Res Over 18 </label>
									<div class="col-md-8">
									  {{ Form::text('no_res_over_18', $row['no_res_over_18'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 1" class=" control-label col-md-4 text-left"> Address 1 </label>
									<div class="col-md-8">
									  {{ Form::text('address_1', $row['address_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 2" class=" control-label col-md-4 text-left"> Address 2 </label>
									<div class="col-md-8">
									  {{ Form::text('address_2', $row['address_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 3" class=" control-label col-md-4 text-left"> Address 3 </label>
									<div class="col-md-8">
									  {{ Form::text('address_3', $row['address_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Address 4" class=" control-label col-md-4 text-left"> Address 4 </label>
									<div class="col-md-8">
									  {{ Form::text('address_4', $row['address_4'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode" class=" control-label col-md-4 text-left"> Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('postcode', $row['postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 1" class=" control-label col-md-4 text-left"> Telephone 1 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_1', $row['telephone_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 2" class=" control-label col-md-4 text-left"> Telephone 2 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_2', $row['telephone_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Telephone 3" class=" control-label col-md-4 text-left"> Telephone 3 </label>
									<div class="col-md-8">
									  {{ Form::text('telephone_3', $row['telephone_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Relationship" class=" control-label col-md-4 text-left"> Relationship </label>
									<div class="col-md-8">
									  <select name='relationship' rows='5' id='relationship' code='{$relationship}' 
							class='select2 '    ></select> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Specify" class=" control-label col-md-4 text-left"> Specify </label>
									<div class="col-md-8">
									  {{ Form::text('specify', $row['specify'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <!--<div class="form-group  " >
									<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
									<div class="col-md-8">
									  
				{{ Form::text('created_at', $row['created_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
									<div class="col-md-8">
									  
				{{ Form::text('updated_at', $row['updated_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div>-->		  
						</fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customerrelative') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				<input type="hidden" name="userid" value="{{ $row['user_id'] }}" />
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#customer_no").jCombo("{{ URL::to('Customerrelative/comboselect?filter=customer_main:customer_no:customer_no') }}",
		{  selected_value : '{{ $row["customer_no"] }}' });
		
		$("#title").jCombo("{{ URL::to('Customerrelative/comboselect?filter=customer_title:id:title') }}",
		{  selected_value : '{{ $row["title"] }}' });
		
		$("#marital_status").jCombo("{{ URL::to('Customerrelative/comboselect?filter=marital_status:id:description') }}",
		{  selected_value : '{{ $row["marital_status"] }}' });
		
		$("#relationship").jCombo("{{ URL::to('Customerrelative/comboselect?filter=relationship:id:description') }}",
		{  selected_value : '{{ $row["relationship"] }}' });
		 
	});
	</script>		 