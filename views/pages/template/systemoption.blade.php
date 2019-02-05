@if(Auth::check())
<div class="wrapper-header ">
    <div class="page-header container">
		<div class="col-sm-6 col-xs-6">
		  <div class="page-title">
			<h3> Home <small> Start Here</small></h3>
		  </div>
		</div>
		<div class="col-sm-6 col-xs-6 ">
		  <ul class="breadcrumb pull-right">
			<li><a href="{{ URL::to('') }}">Home</a></li>

		  </ul>		
		</div>
		  
    </div>
</div>
@endif
  
<div class="wrapper-container container" style="margin-top:20px;">
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif

<div class="line-divider"></div>

@if(!Auth::check())
<div class="row">
<p>Welcome to admin 'AnnFinance'.</p>

<p>Click here to <a href="{{ URL::to('user/login') }}">login</a></p>
</div>
@else
<div class="row">

<p><a href="{{ URL::to('Systemconfiguration') }}">1. System Configuration</a></p>
<p><a href="{{ URL::to('Staffuser') }}">2. Staff</a></p>

<div style="clear:both"></div>		
</div>
@endif

</div>