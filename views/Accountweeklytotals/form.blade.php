
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
		<li><a href="{{ URL::to('Accountweeklytotals') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Accountweeklytotals/save/'.SiteHelpers::encryptID($row['week_no']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Account Weekly Totals</legend>
									
								  <div class="form-group  " >
									<label for="Week No" class=" control-label col-md-4 text-left"> Week No </label>
									<div class="col-md-8">
									  {{ Form::text('week_no', $row['week_no'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Date" class=" control-label col-md-4 text-left"> Date </label>
									<div class="col-md-8">
									  {{ Form::text('date', $row['date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Loans Week" class=" control-label col-md-4 text-left"> Total Loans Week </label>
									<div class="col-md-8">
									  {{ Form::text('total_loans_week', $row['total_loans_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Interest Week" class=" control-label col-md-4 text-left"> Total Interest Week </label>
									<div class="col-md-8">
									  {{ Form::text('total_interest_week', $row['total_interest_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Collect Week" class=" control-label col-md-4 text-left"> Total Collect Week </label>
									<div class="col-md-8">
									  {{ Form::text('total_collect_week', $row['total_collect_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Reloan Balance Week" class=" control-label col-md-4 text-left"> Reloan Balance Week </label>
									<div class="col-md-8">
									  {{ Form::text('reloan_balance_week', $row['reloan_balance_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total Rebate Week" class=" control-label col-md-4 text-left"> Total Rebate Week </label>
									<div class="col-md-8">
									  {{ Form::text('total_rebate_week', $row['total_rebate_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Book Debt Week" class=" control-label col-md-4 text-left"> Book Debt Week </label>
									<div class="col-md-8">
									  {{ Form::text('book_debt_week', $row['book_debt_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Income For Week" class=" control-label col-md-4 text-left"> Income For Week </label>
									<div class="col-md-8">
									  {{ Form::text('income_for_week', $row['income_for_week'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Accountweeklytotals') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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