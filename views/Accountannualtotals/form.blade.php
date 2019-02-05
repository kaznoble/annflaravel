
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
		<li><a href="{{ URL::to('Accountannualtotals') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Accountannualtotals/save/'.SiteHelpers::encryptID($row['year_end_date']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Account Annual Totals</legend>
									
								  <div class="form-group  " >
									<label for="Year End Date" class=" control-label col-md-4 text-left"> Year End Date </label>
									<div class="col-md-8">
									  {{ Form::text('year_end_date', $row['year_end_date'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Loans Total" class=" control-label col-md-4 text-left"> Year Loans Total </label>
									<div class="col-md-8">
									  {{ Form::text('year_loans_total', $row['year_loans_total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Interest Total" class=" control-label col-md-4 text-left"> Year Interest Total </label>
									<div class="col-md-8">
									  {{ Form::text('year_interest_total', $row['year_interest_total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Collect" class=" control-label col-md-4 text-left"> Year Total Collect </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_collect', $row['year_total_collect'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Reloan Balance" class=" control-label col-md-4 text-left"> Year Total Reloan Balance </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_reloan_balance', $row['year_total_reloan_balance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Rebate" class=" control-label col-md-4 text-left"> Year Total Rebate </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_rebate', $row['year_total_rebate'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Book Debt" class=" control-label col-md-4 text-left"> Year Total Book Debt </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_book_debt', $row['year_total_book_debt'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Write Off" class=" control-label col-md-4 text-left"> Year Total Write Off </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_write_off', $row['year_total_write_off'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Year Total Income" class=" control-label col-md-4 text-left"> Year Total Income </label>
									<div class="col-md-8">
									  {{ Form::text('year_total_income', $row['year_total_income'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Accountannualtotals') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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