
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
				<div class="col-md-6">
						<fieldset><legend> Add/Edit Customer Outgoing</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Cust Outg Id" class=" control-label col-md-4 text-left"> Cust Outg Id </label>
									<div class="col-md-8">
									  {{ Form::text('cust_outg_id', $row['cust_outg_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="userid" class=" control-label col-md-4 text-left"> userid </label>
									<div class="col-md-8">
									  {{ Form::text('user_id', $row['user_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									<label for="Local Tax" class=" control-label col-md-4 text-left"> Local Tax </label>
									<div class="col-md-8">
									  {{ Form::text('local_tax', $row['local_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Water" class=" control-label col-md-4 text-left"> Water </label>
									<div class="col-md-8">
									  {{ Form::text('water', $row['water'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Mobile Phone" class=" control-label col-md-4 text-left"> Mobile Phone </label>
									<div class="col-md-8">
									  {{ Form::text('mobile_phone', $row['mobile_phone'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Tv License" class=" control-label col-md-4 text-left"> Tv License </label>
									<div class="col-md-8">
									  {{ Form::text('tv_license', $row['tv_license'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Road Tax" class=" control-label col-md-4 text-left"> Vehicle Road Tax </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle_road_tax', $row['vehicle_road_tax'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Vehicle Service" class=" control-label col-md-4 text-left"> Vehicle Service </label>
									<div class="col-md-8">
									  {{ Form::text('vehicle_service', $row['vehicle_service'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Fuel" class=" control-label col-md-4 text-left"> Fuel </label>
									<div class="col-md-8">
									  {{ Form::text('fuel', $row['fuel'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> </fieldset>
			</div>
			
			<div class="col-md-6">
						<fieldset><legend>  Customer Outgoing</legend>
									
								  <div class="form-group  " >
									<label for="Car Insurance" class=" control-label col-md-4 text-left"> Car Insurance </label>
									<div class="col-md-8">
									  {{ Form::text('car_insurance', $row['car_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Food" class=" control-label col-md-4 text-left"> Food </label>
									<div class="col-md-8">
									  {{ Form::text('food', $row['food'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Clothing" class=" control-label col-md-4 text-left"> Clothing </label>
									<div class="col-md-8">
									  {{ Form::text('clothing', $row['clothing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="School Meals" class=" control-label col-md-4 text-left"> School Meals </label>
									<div class="col-md-8">
									  {{ Form::text('school_meals', $row['school_meals'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Sports Hobbies" class=" control-label col-md-4 text-left"> Sports Hobbies </label>
									<div class="col-md-8">
									  {{ Form::text('sports_hobbies', $row['sports_hobbies'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Hairdressing" class=" control-label col-md-4 text-left"> Hairdressing </label>
									<div class="col-md-8">
									  {{ Form::text('hairdressing', $row['hairdressing'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Public Transport" class=" control-label col-md-4 text-left"> Public Transport </label>
									<div class="col-md-8">
									  {{ Form::text('public_transport', $row['public_transport'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contents Insurance" class=" control-label col-md-4 text-left"> Contents Insurance </label>
									<div class="col-md-8">
									  {{ Form::text('contents_insurance', $row['contents_insurance'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Contingency" class=" control-label col-md-4 text-left"> Contingency </label>
									<div class="col-md-8">
									  {{ Form::text('contingency', $row['contingency'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Other 1" class=" control-label col-md-4 text-left"> Other 1 </label>
									<div class="col-md-8">
									  {{ Form::text('other_1', $row['other_1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									  {{ Form::text('other_2', $row['other_2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									  {{ Form::text('other_3', $row['other_3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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
									<label for="Outgoing Total" class=" control-label col-md-4 text-left"> Outgoing Total </label>
									<div class="col-md-8">
									  {{ Form::text('outgoing_total', $row['outgoing_total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
								  </div> 					
								  <div class="form-group  " >
									<label for="Total" class=" control-label col-md-4 text-left"> Total </label>
									<div class="col-md-8">
									  {{ Form::text('total', $row['total'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
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