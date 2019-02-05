<div class="sidebar-content">
<div class="user-menu"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
	{{ SiteHelpers::avatar()}}
        <div class="user-info"><b>{{ Session::get('fid') }}</b> <br />
		{{ Lang::get('core.lastlogin'); }} : <br />
		<small>{{ date("H:i F j, Y", strtotime(Session::get('ll'))) }}</small></div>
        </a>
        
</div>

      <!-- Main navigation -->
	  {{--*/ $sidebar = SiteHelpers::menus('sidebar') /*--}}
      <ul class="navigation">
	  	<li><a href="{{ URL::to('Customerdetails/add?customer=new')}}"><span>Add New Customer</span> </a></li>
		<li>
			<a class="expand level-closed" href="http://localhost/annadmin/Customeruser">
				<span>View/Edit Account</span> 
				<i class=""></i>
			 	<br>Account No:
			 </a> 
			<ul style="display: none;">
				<li>
					<form class="search_custno_form" type="post" action="{{ URL::to('Customeraccounts') }}">
						<input type="text" class="search_custno" value="" name="search_account"><input type="submit" value="Search" id="search_cust" name="search_acc">
					</form>
				</li>
			</ul>
		</li>	  	
		@foreach ($sidebar as $menu)
			 <li @if(Request::is($menu['module'])) class="active" @endif>
			 	<a 
					@if($menu['menu_type'] =='external')
						href="{{ URL::to($menu['url'])}}" 
					@else
						href="{{ URL::to($menu['module'])}}" 
					@endif				
			 	
				 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
			 		<span>{{$menu['menu_name']}}</span>  <i class="{{$menu['menu_icons']}}"></i>
			 		@if( $menu['menu_name'] == 'View/Edit Customer' )
			 			<br />Cust No: {{ Session::get('session_id') }}
			 		@endif
				</a> 
				@if(count($menu['childs']) > 0)
					<ul>
						@if( $menu['menu_name'] == 'View/Edit Customer' )
							<li>
								<form action="{{ URL::to('searchcustomer') }}" type="post" class="search_custno_form" >
									<input type="text" name="search_cust_no" value="" class="search_custno" /><input type="submit" name="search_cust" id="search_cust" value="Search" />
								</form>
							</li>
						@endif
						@foreach ($menu['childs'] as $menu2)
						 <li @if(Request::is($menu2['module'])) class="active" @endif>
						 	<a 
								@if($menu2['menu_type'] =='external')
									href="{{ URL::to($menu2['url'])}}" 
								@else
									@if( $menu['menu_name'] == 'View/Edit Customer' )
										@if( Session::get('session_id') != '' )
											href="{{ URL::to($menu2['module']) }}?search=customer_no:{{ Session::get('session_id') }}"
										@else
											href="{{ URL::to($menu2['module']) }}"
										@endif
									@else
										href="{{ URL::to($menu2['module']) }}"  
									@endif
								@endif									
							>
								<span>{{$menu2['menu_name']}}</span>  
							</a> 
						</li>							
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
      </ul>
      <!-- /main navigation -->
 </div>