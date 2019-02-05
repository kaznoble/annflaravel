
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
		<li><a href="{{ URL::to('regulatoryreports') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'regulatoryreports/save/'.SiteHelpers::encryptID($row['reg_report_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Regulatory Reports</legend>
									
								  <div class="form-group  " >
									<label for="Reg Report Id" class=" control-label col-md-4 text-left"> Reg Report Id </label>
									<div class="col-md-8">
									  {{ Form::text('reg_report_id', $row['reg_report_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reg Date" class=" control-label col-md-4 text-left"> Reg Date </label>
									<div class="col-md-8">
									  {{ Form::text('reg_date', $row['reg_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Firm Ref Number" class=" control-label col-md-4 text-left"> Firm Ref Number </label>
									<div class="col-md-8">
									  {{ Form::text('firm_ref_number', $row['firm_ref_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tran Ref" class=" control-label col-md-4 text-left"> Tran Ref </label>
									<div class="col-md-8">
									  {{ Form::text('tran_ref', $row['tran_ref'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tran Date" class=" control-label col-md-4 text-left"> Tran Date </label>
									<div class="col-md-8">
									  {{ Form::text('tran_date', $row['tran_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Amount" class=" control-label col-md-4 text-left"> Loan Amount </label>
									<div class="col-md-8">
									  {{ Form::text('loan_amount', $row['loan_amount'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Loan Type" class=" control-label col-md-4 text-left"> Loan Type </label>
									<div class="col-md-8">
									  {{ Form::text('loan_type', $row['loan_type'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Apr" class=" control-label col-md-4 text-left"> Apr </label>
									<div class="col-md-8">
									  {{ Form::text('apr', $row['apr'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('regulatoryreports') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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