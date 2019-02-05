
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
		<li><a href="{{ URL::to('Systemconfiguration') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Systemconfiguration/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit System Configuration</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group " >
									<label for="Id" class=" control-label col-md-4 text-left"> Sys Id </label>
									<div class="col-md-8">
									  {{ Form::text('sys_id', $row['sys_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 													  
								  <div class="form-group  " >
									<label for="Description" class=" control-label col-md-4 text-left"> Description </label>
									<div class="col-md-8">
										@if( !empty($row['id']) )
									  		{{ Form::text('description', $row['description'],array('class'=>'form-control', 'placeholder'=>'', 'readonly'=>'true'  )) }}
									  	@else
									  		{{ Form::text('description', $row['description'],array('class'=>'form-control', 'placeholder'=>'',  )) }}
									  	@endif
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Value" class=" control-label col-md-4 text-left"> Value </label>
									<div class="col-md-8">
										@if( $row['sys_id'] != '31' )
									  		{{ Form::text('value', $row['value'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									  	@else
									  		{{ Form::textarea('value', $row['value'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									  	@endif
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Systemconfiguration') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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