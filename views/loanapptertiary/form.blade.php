
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
		<li><a href="{{ URL::to('loanapptertiary') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'loanapptertiary/save/'.SiteHelpers::encryptID($row['loan_tert_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Loan app tertiary</legend>
									
								  <div class="form-group  " >
									<label for="Loan Tert Id" class=" control-label col-md-4 text-left"> Loan Tert Id </label>
									<div class="col-md-8">
									  {{ Form::text('loan_tert_id', $row['loan_tert_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Application Number" class=" control-label col-md-4 text-left"> Loan Application Number </label>
									<div class="col-md-8">
									  {{ Form::text('loan_application_number', $row['loan_application_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Employment Status" class=" control-label col-md-4 text-left"> Employment Status </label>
									<div class="col-md-8">
									  {{ Form::text('employment_status', $row['employment_status'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Name Of Employer" class=" control-label col-md-4 text-left"> Name Of Employer </label>
									<div class="col-md-8">
									  {{ Form::text('name_of_employer', $row['name_of_employer'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Time In Job" class=" control-label col-md-4 text-left"> Time In Job </label>
									<div class="col-md-8">
									  {{ Form::text('time_in_job', $row['time_in_job'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Agree To Privacy Notice" class=" control-label col-md-4 text-left"> Agree To Privacy Notice </label>
									<div class="col-md-8">
									  {{ Form::text('agree_to_privacy_notice', $row['agree_to_privacy_notice'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Policy Notice Name" class=" control-label col-md-4 text-left"> Policy Notice Name </label>
									<div class="col-md-8">
									  {{ Form::text('policy_notice_name', $row['policy_notice_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Policy Notice Date" class=" control-label col-md-4 text-left"> Policy Notice Date </label>
									<div class="col-md-8">
									  {{ Form::text('policy_notice_date', $row['policy_notice_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Agree To Credit Check" class=" control-label col-md-4 text-left"> Agree To Credit Check </label>
									<div class="col-md-8">
									  {{ Form::text('agree_to_credit_check', $row['agree_to_credit_check'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Confirm No Debt Problems" class=" control-label col-md-4 text-left"> Confirm No Debt Problems </label>
									<div class="col-md-8">
									  {{ Form::text('confirm_no_debt_problems', $row['confirm_no_debt_problems'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Dept Problem Name" class=" control-label col-md-4 text-left"> Dept Problem Name </label>
									<div class="col-md-8">
									  {{ Form::text('dept_problem_name', $row['dept_problem_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Debt Problem Date" class=" control-label col-md-4 text-left"> Debt Problem Date </label>
									<div class="col-md-8">
									  {{ Form::text('debt_problem_date', $row['debt_problem_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('loanapptertiary') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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