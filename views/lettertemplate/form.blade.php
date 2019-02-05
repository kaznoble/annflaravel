
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
		<li><a href="{{ URL::to('lettertemplate') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'lettertemplate/save/'.SiteHelpers::encryptID($row['temp_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Letter template</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Temp Id" class=" control-label col-md-4 text-left"> Temp Id </label>
									<div class="col-md-8">
									  {{ Form::text('temp_id', $row['temp_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Temp Title" class=" control-label col-md-4 text-left"> Letter Title </label>
									<div class="col-md-8">
									  {{ Form::text('temp_title', $row['temp_title'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Temp Title" class=" control-label col-md-4 text-left"> Field Data </label>
									<div class="col-md-8">
									  #fullname, #address_line_1, #address_line_2, #city, #post_code<br />
									  #customer_no, #account_no
									 </div> 
								  </div> 													  
								  <div class="form-group  " >
									<label for="Temp Html" class=" control-label col-md-4 text-left"> Letter Html </label>
									<div class="col-md-8">
									  <textarea name='temp_html' rows='100' id='editor' class='form-control editor '  
						 >{{ $row['temp_html'] }}</textarea> 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('lettertemplate') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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