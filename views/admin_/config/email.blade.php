
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
		<li><a href="{{ URL::to('config') }}">{{ $pageTitle }}</a></li>
        <li class="active"> View </li>
      </ul>
	</div>  
	@if(Session::has('message'))
	  
		   {{ Session::get('message') }}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		

	<ul class="nav nav-tabs" >
	  <li ><a href="{{ URL::to('config')}}"><i class="icon-cogs"></i> Site Info  </a></li>
	  <li class="active"><a href="{{ URL::to('config/email') }}" ><i class="icon-envelop"></i> Email Setting  </a></li>
	  <li ><a href="{{ URL::to('config/security') }}" ><i class="icon-lock"></i> Login & Security  </a></li>
	</ul>	
<div class="tab-content">
	  <div class="tab-pane active use-padding" id="info">	
	 {{ Form::open(array('url'=>'config/email/', 'class'=>'form-vertical row')) }}
	
	<div class="col-sm-6">
	<div class="well">
		<fieldset > <legend> New Account Registered Info </legend>
		  <div class="form-group">
			<label for="ipt" class=" control-label"> Message </label>		
			<textarea rows="10" name="regEmail" class="form-control input-sm ">{{ $regEmail }}</textarea>		
		  </div>  
		

		<div class="form-group">   
			<button class="btn btn-primary" type="submit"> Save All Changes</button>	 
		</div>
	</div>
  </fieldset>


</div> 


	<div class="col-sm-6">
	<div class="well">
	 <fieldset> <legend> Reset Password </legend>
  
		
		  <div class="form-group">
			<label for="ipt" class=" control-label ">Message </label>
			
			<textarea rows="10" name="resetEmail" class="form-control input-sm ">{{ $resetEmail }}</textarea>
			 
		  </div> 
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
		<div class="col-md-8">
			<button class="btn btn-primary" type="submit"> Save All Changes</button>
		 </div> 
	 
	  </div>	  
	 </fieldset>    
 	</div>
 </div>
 {{ Form::close() }}
</div>

</div>





