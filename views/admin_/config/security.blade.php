
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
	  <li ><a href="{{ URL::to('config/email') }}" ><i class="icon-envelop"></i> Email Setting  </a></li>
	  <li class="active"><a href="{{ URL::to('config/security') }}" ><i class="icon-lock"></i> Login & Security  </a></li>
	</ul>	
<div class="tab-content">
	  <div class="tab-pane active use-padding row" id="info">	
	 {{ Form::open(array('url'=>'config/social/', 'class'=>'form-horizontal')) }}
	
	<div class="col-sm-6">
	<div class="well">
		<fieldset > <legend> Social Media Login 
			<span class="btn btn-primary"><i class="fa fa-facebook"></i></span>
			<span class="btn btn-danger"><i class="fa fa-google-plus"></i></span>
			<span class="btn btn-info"><i class="fa fa-twitter"></i></span>
		</legend>
		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"><i class="fa fa-facebook"></i> Login Facebook </label>	
			<div class="col-sm-8">
					<div >
						<label class="checkbox-inline">
						<input type="checkbox" name="FB_ENABLE"  value="true"
						@if($hybrid['providers']['Facebook']['enabled'] =='true') checked @endif
						 /> Enable
						</label>
					</div>				
				
				 	<label for="ipt" class=" control-label "> APP ID </label>
				 	
					<input type="text" class="form-control" value="{{ $hybrid['providers']['Facebook']['keys']['id']}}" name="FB_ID"  />
					
					<label for="ipt" class=" control-label "> Secret Number </label>
					<input type="text" class="form-control" value="{{ $hybrid['providers']['Facebook']['keys']['secret']}}"  name="FB_SECRET"  /> 
				
							
			</div>	
					
		  </div>  
		
		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"><i class="fa fa-google-plus"></i> Login Google </label>	
			<div class="col-sm-8">
					<div >
						<label class="checkbox-inline">
						<input type="checkbox"  value="true" name="GOOGLE_ENABLE" @if($hybrid['providers']['Google']['enabled'] =='true') checked @endif/> Enable
						</label>
					</div>				
				
				 	<label for="ipt" class=" control-label "> APP ID </label>
				 	
					<input type="text" class="form-control" name="GOOGLE_ID"  value="{{ $hybrid['providers']['Google']['keys']['id']}}" />
					
					<label for="ipt" class=" control-label "> Secret Number </label>
					<input type="text" class="form-control" name="GOOGLE_SECRET"  value="{{ $hybrid['providers']['Google']['keys']['secret']}}" /> 
				
							
			</div>	
					
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"><i class="fa fa-twitter"></i> Login Twitter </label>	
			<div class="col-sm-8">
					<div >
						<label class="checkbox-inline">
						<input type="checkbox" value="true" name="TWIT_ENABLE" @if($hybrid['providers']['Twitter']['enabled'] =='true') checked @endif /> Enable
						</label>
					</div>				
				
				 	<label for="ipt" class=" control-label " > APP ID </label>
				 	
					<input type="text" class="form-control" name="TWIT_ID" value="{{ $hybrid['providers']['Twitter']['keys']['key']}}"/>
					
					<label for="ipt" class=" control-label "> Secret Number </label>
					<input type="text" class="form-control" name="TWIT_SECRET" value="{{ $hybrid['providers']['Twitter']['keys']['secret']}}"/> 
				
							
			</div>	
					
		  </div>  
		  
		  		  
		<div class="form-group">   
			<label for="ipt" class=" control-label col-sm-4"> &nbsp;</label>	
			<div class="col-sm-8">
				<button class="btn btn-primary" type="submit"> Save All Changes</button>	 
			</div>	
		</div>
	</div>
  </fieldset>


</div> 

{{ Form::close() }}

 {{ Form::open(array('url'=>'config/login/', 'class'=>'form-horizontal')) }}
	<div class="col-sm-6">
	<div class="well">
	 <fieldset> <legend> Login Setting </legend>
  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> Default Group Registration </label>	
			<div class="col-sm-8">
					<div >
						<label class="checkbox-inline">
						<select class="form-control" name="CNF_GROUP">
							@foreach($groups as $group)
							<option value="{{ $group->group_id }}"
							 @if(CNF_GROUP == $group->group_id ) selected @endif
							>{{ $group->name }}</option>
							@endforeach
						</select>
						</label>
					</div>				
			</div>	
					
		  </div> 

		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"> Activation registration </label>	
			<div class="col-sm-8">
					
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="auto" @if(CNF_ACTIVATION =='auto') checked @endif /> Automatic activation
					</label>
					
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="manual" @if(CNF_ACTIVATION =='manual') checked @endif /> Manual activation
					</label>								
					<label class="radio">
					<input type="radio" name="CNF_ACTIVATION" value="confirmation" @if(CNF_ACTIVATION =='confirmation') checked @endif/> Email with activation link
					</label>	
				
							
			</div>	
					
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





