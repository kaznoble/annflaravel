<div class="wrapper-container container" style="margin-top:20px;">


	@if(Session::has('message'))	  

		   {{ Session::get('message') }}

	@endif



<div>

<h2>Welcome to ANNFinance Admin</h2>

</div>



<div class="line-divider"></div>

<div class="row">

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-pencil2"></i>

				<div class="service-content">

					<h3><a href="Customerdetails">Manage Customers</a></h3>

				</div>	

			</div>	

		</div>

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-popout"></i>

				<div class="service-content">

					<h3><a href="Systemreports">Reports</a></h3>

					</div>	

			</div>	

		</div>

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-shield2  "></i>

				<div class="service-content">

					<h3><a href="Systemconfigurations">System Configuration</a></h3>

				</div>	

			</div>	

		</div>	

            </div>

            <div style="height:20px;"></div>

            <div class="row">

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-bubble-dots2"></i>

				<div class="service-content">

					<h3><a href="Customercomments">Customer Comments</a></h3>

				</div>	

			</div>	

		</div>

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-checkmark-circle"></i>

				<div class="service-content">

					<h3><a href="loanapp">Loan Application {{ ($LoanApplicationViewCount > 0 ? '<span style="color:red;font-weight:bold;" >(' . $LoanApplicationViewCount . ' NEW)</span>' : '' ) }}</a></h3>

					</div>	

			</div>	

		</div>

		<div class="col-md-4">

			<div class="boxed">

				<i class="icon-wondering2"></i>

				<div class="service-content">

					<h3><a href="complaints">Complaints {{ ($complaintCount > 0 ? '<span style="color:red;font-weight:bold;" >(' . $complaintCount . ' NEW)</span>' : '' ) }}</a></h3>

				</div>	

			</div>	

		</div>
			</div>
		<div class="row">
				<div style="height:20px;"></div>
				<div class="col-md-4">

					<div class="boxed">

						<i class="icon-address-book"></i>

						<div class="service-content">

							<h3><a href="adminround">Round Admin</a></h3>

						</div>

					</div>

				</div>
				
				<div class="col-md-4">

					<div class="boxed">

						<i class="icon-checkbox-partial"></i>

						<div class="service-content">

							<h3><a href="Contacts">Contacts {{ ($contactCount > 0 ? '<span style="color:red;font-weight:bold;" >(' . $contactCount . ' NEW)</span>' : '' ) }}</a></h3>

						</div>

					</div>

				</div>				
		</div>


</div>



<div style="clear:both;height:100px;"></div>



  



 

 
