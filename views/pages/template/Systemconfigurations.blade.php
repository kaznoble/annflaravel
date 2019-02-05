<style>
.line-divider 
{
  float: left;
  width: 100%;
}
.col-sm-6.col-xs-6.right_content 
{
  text-align: right;
  width: 47%;
}

</style>

<div class="wrapper-container container" style="margin-top:20px;">

<div class="page-header container">
		<div class="col-sm-6 col-xs-6">
		  <div class="page-title">
			<h2> System Configuration </h2>
		  </div>
		</div>
		<div class="col-sm-6 col-xs-6 right_content">
			<h2><a href="{{ URL::to('') }}">Home</a></h2>
		  
    </div>

<div class="line-divider"></div>

<div class="row">

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-user"></i>

				<div class="service-content">

					<h3><a href="Usermanagement">User Management</a></h3>

				</div>	

			</div>	

		</div>

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-users"></i>

				<div class="service-content">

					<h3><a href="Groupmanagement">Group Management</a></h3>

					</div>	

			</div>	

		</div>

                
		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-cogs "></i>

				<div class="service-content">

					<h3><a href="Systemconfiguration">System Options</a></h3>

				</div>	

			</div>	

		</div>	
               

  </div>      
  
<div style="clear:both;height:20px;"></div>
  
  <div class="row">

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-checkbox-checked"></i>

				<div class="service-content">

					<h3><a href="Grouplevel">Group Access</a></h3>

				</div>	

			</div>	

		</div>

	  <div class="col-md-4">

		  <div class="boxed">

			  <i class="icon-cogs "></i>

			  <div class="service-content">

				  <h3>
					  	@if($MaintenanceMode == 0)
					  		<a href="site-up">Site Up</a>
						@else
						  	<a href="site-down">Site Down</a>
						@endif
				  </h3>

			  </div>

		  </div>

	  </div>
      
        <div class="col-md-4">

		<div class="boxed">

			<i class="icon-popout"></i>

			<div class="service-content">

				<h3><a href="/lettertemplate">Letter</a></h3>

				</div>	

		</div>	

	</div>      


  </div>        

</div>

<div style="clear:both;height:100px;"></div>

</div>

