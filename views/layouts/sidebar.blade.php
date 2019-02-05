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
			<a class="expand level-closed" href="/Customeruser">
				<span>View/Edit Account</span> 
				<i class=""></i>
			 	<br><span>Account No:</span>
			 </a> 
			<ul style="display: none;">
				<li>
					<form class="search_custno_form" type="post" action="{{ URL::to('Customeraccounts') }}">
						<input type="text" class="search_custno" value=""  id="search_account" name="search_account"><input type="submit" value="Search" id="search_cust" name="search_acc">
					</form>
				</li>
			</ul>
		</li>	  	
		@foreach ($sidebar as $menu)
			 <li @if(Request::is($menu['module'])) class="active" @endif>
				@if(!empty(Session::get('session_id'))) {{ Form::button('Reset customer no?', ['class' => 'clear_customer_session', 'style' => 'width:100%;']) }} @endif					 
			 	<a 
					@if($menu['menu_type'] =='external')
						href="{{ URL::to($menu['url'])}}" 
					@else
						href="{{ URL::to($menu['module'])}}" 
					@endif				
			 	
				 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
			 		<span>{{$menu['menu_name']}}</span>  <i class="{{$menu['menu_icons']}}"></i>
			 		@if( $menu['menu_name'] == 'View/Edit Customer' )
			 			<br /><span>Cust No: {{ Session::get('session_id') }}</span>
			 		@endif
				</a>
				@if(count($menu['childs']) > 0)
					<ul>
						@if( $menu['menu_name'] == 'View/Edit Customer' )
							<li>
								<form action="{{ URL::to('searchcustomer') }}" type="post" class="search_custno_form" >
									<input type="text" name="search_cust_no" value="" class="search_custno" id= "serach_customer" /><input type="submit" name="search_cust" id="search_cust" value="Search" />
								</form>
							</li>
						@endif
						@foreach ($menu['childs'] as $menu2)
						@if($menu2['menu_id'] != '38')
						 <li @if(Request::is($menu2['module'])) class="active" @endif>
						 	<a 
								@if($menu2['menu_type'] =='external')
									href="{{ URL::to($menu2['url'])}}" 
								@else
									@if( $menu['menu_name'] == 'View/Edit Customer' )
										@if( Session::get('session_id') != '' )
											href="{{ URL::to($menu2['module']) }}?search=customer_no:{{ Session::get('session_id') }}&type=menu"
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
						@else
						 <li @if(Request::is($menu2['module'])) class="active" @endif>
						 	<a href="{{ URL::to($menu2['url'])}}/incomeexpenditure/add/{{ Session::get('session_incomeexp_id') }}" >
								<span>{{$menu2['menu_name']}}</span>  
							</a> 
						</li>												
						@endif	
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
      </ul>
      <!-- /main navigation -->
 </div>
 
 @if(!empty(Session::get('round_number')))
	<script>
		$('body').attr('class','sidebar-narrow');
	</script>
 @endif
 
 <script>
	$(document).ready(function() {
		$('.clear_customer_session').click(function() {
			if(confirm('Are you sure you want to clear customer number?'))
			{
				window.location.href = "{{ URL::to('searchcustomer') }}" + "?type=clearcustomer";
			}
		});
	});
 </script>