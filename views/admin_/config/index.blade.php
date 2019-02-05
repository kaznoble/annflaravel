
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
	  <li class="active"><a href="{{ URL::to('config')}}"><i class="icon-cogs"></i> Site Info  </a></li>
	  <li ><a href="{{ URL::to('config/email') }}" ><i class="icon-envelop"></i> Email Setting  </a></li>
	  <li ><a href="{{ URL::to('config/security') }}" ><i class="icon-lock"></i> Login & Security  </a></li>
	</ul>	
<div class="tab-content">
  <div class="tab-pane active use-padding" id="info">	
 {{ Form::open(array('url'=>'config/save/', 'class'=>'form-horizontal row')) }}

<div class="col-sm-6">
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Application Name </label>
	<div class="col-md-8">
	<input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm" required  value="{{ CNF_APPNAME }}" />  
	 </div> 
  </div>  
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Application Desc </label>
	<div class="col-md-8">
	<input name="cnf_appdesc" type="text" id="cnf_appdesc" class="form-control input-sm" value="{{ CNF_APPDESC }}" /> 
	 </div> 
  </div>  
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Company Name </label>
	<div class="col-md-8">
	<input name="cnf_comname" type="text" id="cnf_comname" class="form-control input-sm" value="{{ CNF_COMNAME }}" />  
	 </div> 
  </div>    

  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Email System </label>
	<div class="col-md-8">
	<input name="cnf_email" type="text" id="cnf_email" class="form-control input-sm" value="{{ CNF_EMAIL }}" /> 
	 </div> 
  </div>   
     
  

  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
	<div class="col-md-8">
		<button class="btn btn-primary" type="submit"> Save All Changes</button>
	 </div> 
  </div> 
</div>

<div class="col-sm-6">

  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Metakey </label>
	<div class="col-md-8">
		<textarea class="form-control input-sm" name="cnf_metakey">{{ CNF_METAKEY }}</textarea>
	 </div> 
  </div> 

   <div class="form-group">
    <label  class=" control-label col-md-4">Meta Descriptiom</label>
	<div class="col-md-8">
		<textarea class="form-control input-sm"  name="cnf_metadesc">{{ CNF_METADESC }}</textarea>
	 </div> 
  </div>  

</div>  
 {{ Form::close() }}

</div>

</div>




