
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
		<li><a href="{{ URL::to('Customeroutgoing') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Customeroutgoing/save/'.SiteHelpers::encryptID($row['cust_outg_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
				<div class="col-md-12">
						<fieldset><legend> Add/Edit Customer Outgoing</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Outg Id" class=" control-label col-md-4 text-left"> Cust Outg Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_outg_id', $row['cust_outg_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Rent Mortgage" class=" control-label col-md-4 text-left"> Rent Mortgage </label>
									<div class="col-md-8">
									  {{ Form::text('rent_mortgage', $row['rent_mortgage'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Gas" class=" control-label col-md-4 text-left"> Gas </label>
									<div class="col-md-8">
									  {{ Form::text('gas', $row['gas'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Electric" class=" control-label col-md-4 text-left"> Electric </label>
									<div class="col-md-8">
									  {{ Form::text('electric', $row['electric'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Phone" class=" control-label col-md-4 text-left"> Phone </label>
									<div class="col-md-8">
									  {{ Form::text('phone', $row['phone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Transport" class=" control-label col-md-4 text-left"> Transport </label>
									<div class="col-md-8">
									  {{ Form::text('transport', $row['transport'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Outgoing Total" class=" control-label col-md-4 text-left"> Outgoing Total </label>
									<div class="col-md-8">
									  <textarea name='outgoing_total' rows='2' id='outgoing_total' class='form-control '  
				           >{{ $row['outgoing_total'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Local Tax" class=" control-label col-md-4 text-left"> Local Tax </label>
									<div class="col-md-8">
									  <textarea name='local_tax' rows='2' id='local_tax' class='form-control '  
				           >{{ $row['local_tax'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Water" class=" control-label col-md-4 text-left"> Water </label>
									<div class="col-md-8">
									  <textarea name='water' rows='2' id='water' class='form-control '  
				           >{{ $row['water'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Mobile Phone" class=" control-label col-md-4 text-left"> Mobile Phone </label>
									<div class="col-md-8">
									  <textarea name='mobile_phone' rows='2' id='mobile_phone' class='form-control '  
				           >{{ $row['mobile_phone'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tv License" class=" control-label col-md-4 text-left"> Tv License </label>
									<div class="col-md-8">
									  <textarea name='tv_license' rows='2' id='tv_license' class='form-control '  
				           >{{ $row['tv_license'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Road Tax" class=" control-label col-md-4 text-left"> Vehicle Road Tax </label>
									<div class="col-md-8">
									  <textarea name='vehicle_road_tax' rows='2' id='vehicle_road_tax' class='form-control '  
				           >{{ $row['vehicle_road_tax'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Service" class=" control-label col-md-4 text-left"> Vehicle Service </label>
									<div class="col-md-8">
									  <textarea name='vehicle_service' rows='2' id='vehicle_service' class='form-control '  
				           >{{ $row['vehicle_service'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Fuel" class=" control-label col-md-4 text-left"> Fuel </label>
									<div class="col-md-8">
									  <textarea name='fuel' rows='2' id='fuel' class='form-control '  
				           >{{ $row['fuel'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Car Insurance" class=" control-label col-md-4 text-left"> Car Insurance </label>
									<div class="col-md-8">
									  <textarea name='car_insurance' rows='2' id='car_insurance' class='form-control '  
				           >{{ $row['car_insurance'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Public Transport" class=" control-label col-md-4 text-left"> Public Transport </label>
									<div class="col-md-8">
									  <textarea name='public_transport' rows='2' id='public_transport' class='form-control '  
				           >{{ $row['public_transport'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Food" class=" control-label col-md-4 text-left"> Food </label>
									<div class="col-md-8">
									  <textarea name='food' rows='2' id='food' class='form-control '  
				           >{{ $row['food'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Clothing" class=" control-label col-md-4 text-left"> Clothing </label>
									<div class="col-md-8">
									  <textarea name='clothing' rows='2' id='clothing' class='form-control '  
				           >{{ $row['clothing'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="School Meals" class=" control-label col-md-4 text-left"> School Meals </label>
									<div class="col-md-8">
									  <textarea name='school_meals' rows='2' id='school_meals' class='form-control '  
				           >{{ $row['school_meals'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Sports Hobbies" class=" control-label col-md-4 text-left"> Sports Hobbies </label>
									<div class="col-md-8">
									  <textarea name='sports_hobbies' rows='2' id='sports_hobbies' class='form-control '  
				           >{{ $row['sports_hobbies'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contents Insurance" class=" control-label col-md-4 text-left"> Contents Insurance </label>
									<div class="col-md-8">
									  <textarea name='contents_insurance' rows='2' id='contents_insurance' class='form-control '  
				           >{{ $row['contents_insurance'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Hairdressing" class=" control-label col-md-4 text-left"> Hairdressing </label>
									<div class="col-md-8">
									  <textarea name='hairdressing' rows='2' id='hairdressing' class='form-control '  
				           >{{ $row['hairdressing'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contingency" class=" control-label col-md-4 text-left"> Contingency </label>
									<div class="col-md-8">
									  <textarea name='contingency' rows='2' id='contingency' class='form-control '  
				           >{{ $row['contingency'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 1" class=" control-label col-md-4 text-left"> Other 1 </label>
									<div class="col-md-8">
									  <textarea name='other_1' rows='2' id='other_1' class='form-control '  
				           >{{ $row['other_1'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 1" class=" control-label col-md-4 text-left"> Other Description 1 </label>
									<div class="col-md-8">
									  <textarea name='other_description_1' rows='2' id='other_description_1' class='form-control '  
				           >{{ $row['other_description_1'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 2" class=" control-label col-md-4 text-left"> Other 2 </label>
									<div class="col-md-8">
									  <textarea name='other_2' rows='2' id='other_2' class='form-control '  
				           >{{ $row['other_2'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 2" class=" control-label col-md-4 text-left"> Other Description 2 </label>
									<div class="col-md-8">
									  <textarea name='other_description_2' rows='2' id='other_description_2' class='form-control '  
				           >{{ $row['other_description_2'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 3" class=" control-label col-md-4 text-left"> Other 3 </label>
									<div class="col-md-8">
									  <textarea name='other_3' rows='2' id='other_3' class='form-control '  
				           >{{ $row['other_3'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other Description 3" class=" control-label col-md-4 text-left"> Other Description 3 </label>
									<div class="col-md-8">
									  <textarea name='other_description_3' rows='2' id='other_description_3' class='form-control '  
				           >{{ $row['other_description_3'] }}</textarea> 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total" class=" control-label col-md-4 text-left"> Total </label>
									<div class="col-md-8">
									  <textarea name='total' rows='2' id='total' class='form-control '  
				           >{{ $row['total'] }}</textarea> 
									 </div> 
								  </div> </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
				<button type="button" onclick="location.href='{{ URL::to('Customeroutgoing') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
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