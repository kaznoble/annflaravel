
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
		<li><a href="{{ URL::to('loanappprimary') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'loanappprimary/save/'.SiteHelpers::encryptID($row['app_primary_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Loan app primary</legend>
									
								  <div class="form-group  " >
									<label for="App Primary Id" class=" control-label col-md-4 text-left"> App Primary Id </label>
									<div class="col-md-8">
									  {{ Form::text('app_primary_id', $row['app_primary_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Application Number" class=" control-label col-md-4 text-left"> Loan Application Number </label>
									<div class="col-md-8">
									  {{ Form::text('loan_application_number', $row['loan_application_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Amount" class=" control-label col-md-4 text-left"> Loan Amount </label>
									<div class="col-md-8">
									  {{ Form::text('loan_amount', $row['loan_amount'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Title" class=" control-label col-md-4 text-left"> Title </label>
									<div class="col-md-8">
									  {{ Form::text('title', $row['title'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Name" class=" control-label col-md-4 text-left"> First Name </label>
									<div class="col-md-8">
									  {{ Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Last Name" class=" control-label col-md-4 text-left"> Last Name </label>
									<div class="col-md-8">
									  {{ Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Dob" class=" control-label col-md-4 text-left"> Dob </label>
									<div class="col-md-8">
									  {{ Form::text('dob', $row['dob'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Email Address" class=" control-label col-md-4 text-left"> Email Address </label>
									<div class="col-md-8">
									  {{ Form::text('email_address', $row['email_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="First Line Address" class=" control-label col-md-4 text-left"> First Line Address </label>
									<div class="col-md-8">
									  {{ Form::text('first_line_address', $row['first_line_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Second Line Address" class=" control-label col-md-4 text-left"> Second Line Address </label>
									<div class="col-md-8">
									  {{ Form::text('second_line_address', $row['second_line_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Town City" class=" control-label col-md-4 text-left"> Town City </label>
									<div class="col-md-8">
									  {{ Form::text('town_city', $row['town_city'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode" class=" control-label col-md-4 text-left"> Postcode </label>
									<div class="col-md-8">
									  {{ Form::text('postcode', $row['postcode'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Years At Address" class=" control-label col-md-4 text-left"> Years At Address </label>
									<div class="col-md-8">
									  {{ Form::text('years_at_address', $row['years_at_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Phone Landline" class=" control-label col-md-4 text-left"> Phone Landline </label>
									<div class="col-md-8">
									  {{ Form::text('phone_landline', $row['phone_landline'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Phone Mobile" class=" control-label col-md-4 text-left"> Phone Mobile </label>
									<div class="col-md-8">
									  {{ Form::text('phone_mobile', $row['phone_mobile'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Home Status" class=" control-label col-md-4 text-left"> Home Status </label>
									<div class="col-md-8">
									  {{ Form::text('home_status', $row['home_status'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Marita Status" class=" control-label col-md-4 text-left"> Marita Status </label>
									<div class="col-md-8">
									  {{ Form::text('marita_status', $row['marita_status'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="No Child" class=" control-label col-md-4 text-left"> No Child </label>
									<div class="col-md-8">
									  {{ Form::text('no_child', $row['no_child'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Created Date" class=" control-label col-md-4 text-left"> Created Date </label>
									<div class="col-md-8">
									  {{ Form::text('created_date', $row['created_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Timestamp" class=" control-label col-md-4 text-left"> Timestamp </label>
									<div class="col-md-8">
									  
				{{ Form::text('timestamp', $row['timestamp'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Firstline Prev Address" class=" control-label col-md-4 text-left"> Firstline Prev Address </label>
									<div class="col-md-8">
									  {{ Form::text('firstline_prev_address', $row['firstline_prev_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Secondline Prev Address" class=" control-label col-md-4 text-left"> Secondline Prev Address </label>
									<div class="col-md-8">
									  {{ Form::text('secondline_prev_address', $row['secondline_prev_address'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Town City Prev" class=" control-label col-md-4 text-left"> Town City Prev </label>
									<div class="col-md-8">
									  {{ Form::text('town_city_prev', $row['town_city_prev'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Postcode Prev" class=" control-label col-md-4 text-left"> Postcode Prev </label>
									<div class="col-md-8">
									  {{ Form::text('postcode_prev', $row['postcode_prev'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Years At Addres Prev" class=" control-label col-md-4 text-left"> Years At Addres Prev </label>
									<div class="col-md-8">
									  {{ Form::text('years_at_addres_prev', $row['years_at_addres_prev'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Confirm Cust Can Afford Loan" class=" control-label col-md-4 text-left"> Confirm Cust Can Afford Loan </label>
									<div class="col-md-8">
									  {{ Form::text('confirm_cust_can_afford_loan', $row['confirm_cust_can_afford_loan'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Confirm Cust Gives Content" class=" control-label col-md-4 text-left"> Confirm Cust Gives Content </label>
									<div class="col-md-8">
									  {{ Form::text('confirm_cust_gives_content', $row['confirm_cust_gives_content'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Successful Applicant" class=" control-label col-md-4 text-left"> Successful Applicant </label>
									<div class="col-md-8">
									  {{ Form::text('successful_applicant', $row['successful_applicant'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reason" class=" control-label col-md-4 text-left"> Reason </label>
									<div class="col-md-8">
									  {{ Form::text('reason', $row['reason'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Processed" class=" control-label col-md-4 text-left"> Processed </label>
									<div class="col-md-8">
									  {{ Form::text('processed', $row['processed'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('loanappprimary') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 