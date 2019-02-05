
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
		<li><a href="{{ URL::to('roundweekly') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'roundweekly/save/'.SiteHelpers::encryptID($row['round_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Round weekly report</legend>
									
								  <div class="form-group  " >
									<label for="Round Id" class=" control-label col-md-4 text-left"> Round Id </label>
									<div class="col-md-8">
									  {{ Form::text('round_id', $row['round_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Round Number" class=" control-label col-md-4 text-left"> Round Number </label>
									<div class="col-md-8">
									  {{ Form::text('round_number', $row['round_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Round Name" class=" control-label col-md-4 text-left"> Round Name </label>
									<div class="col-md-8">
									  {{ Form::text('round_name', $row['round_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Name" class=" control-label col-md-4 text-left"> Staff Name </label>
									<div class="col-md-8">
									  {{ Form::text('staff_name', $row['staff_name'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Staff Number" class=" control-label col-md-4 text-left"> Staff Number </label>
									<div class="col-md-8">
									  {{ Form::text('staff_number', $row['staff_number'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Days Of Week" class=" control-label col-md-4 text-left"> Days Of Week </label>
									<div class="col-md-8">
									  <textarea name='days_of_week' rows='2' id='days_of_week' class='form-control '  
				           >{{ $row['days_of_week'] }}</textarea> 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('roundweekly') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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