
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
		<li><a href="{{ URL::to('userauditlog') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'userauditlog/save/'.SiteHelpers::encryptID($row['audit_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> User audit log</legend>
									
								  <div class="form-group  " >
									<label for="Audit Id" class=" control-label col-md-4 text-left"> Audit Id </label>
									<div class="col-md-8">
									  {{ Form::text('audit_id', $row['audit_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									<label for="Action Date" class=" control-label col-md-4 text-left"> Action Date </label>
									<div class="col-md-8">
									  
				{{ Form::text('action_date', $row['action_date'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Action Performed" class=" control-label col-md-4 text-left"> Action Performed </label>
									<div class="col-md-8">
									  {{ Form::text('action_performed', $row['action_performed'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('userauditlog') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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