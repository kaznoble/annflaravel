
<div class="page-content">
	<div class="page-header">
	  <div class="page-title">
		<h3> Dashboard <small> Summary info site </small></h3>
	  </div>
	</div>

	@if(Session::get('gid') ==1)
    <!-- Default info blocks -->
	<div class="col-sm-12 col-md-12">
		<div class="panel panel-default ">
			<div class="panel-heading"><i class="icon-pencil"></i> Quick Access </div>
			<div class="panel-body">	
			<ul class="info-blocks">
			  <li class="">
				<div class="top-info"><a href="{{ URL::to('module/add') }}">New Module</a><small>Create new module</small></div>
				<a href="{{ URL::to('module/add') }}"><i class="icon-plus-circle2"></i></a></li>
			  <li class="">
				<div class="top-info"><a href="{{ URL::to('config') }}">Setting</a><small>Site Info</small></div>
				<a href="{{ URL::to('config') }}"><i class="icon-cogs"></i></a></li>
			  <li class="">
				<div class="top-info"><a href="{{ URL::to('menu') }}">Menu</a><small>Menu Management</small></div>
				<a href="{{ URL::to('menu') }}"><i class="icon-stats2"></i></a></li>
			  <li class="">
				<div class="top-info"><a href="{{ URL::to('users') }}">Users </a><small>Users Management</small></div>
				<a href="{{ URL::to('users') }}"><i class="icon-user"></i></a></li>
			  <li class="">
				<div class="top-info"><a href="{{ URL::to('groups') }}">Groups</a><small>Groups Management</small></div>
				<a href="{{ URL::to('groups') }}"><i class="icon-users"></i></a></li>
			</ul>
			</div>
		</div>	
	</div>	
			<!-- /default info blocks -->	
	
	
	
	<div class="col-sm-6 col-md-6">
		<div class="panel panel-primary ">
			<div class="panel-heading"><i class="icon-users"></i> Group & Users Status </div>
			<div class="panel-body">
			<div class="table-responsive">
			<table class="table table-striped">
				<thead class="">
				  <tr>
					<th scope="col" class="footable-first-column"> Group</th>
					<th data-hide="phone" scope="col"> #users</th>
					<th scope="col"> Active </th>
					<th scope="col"> Suspend</th>
					<th scope="col" class="footable-last-column"> Inactive</th>
				  </tr>
				</thead>
				<tbody>
				@foreach($user_groups as $row)
					<tr>
						<td>{{ $row->name }}</td>
						<td>{{ $row->users }}</td>
						<td>{{ $row->user_active }}</td>
						<td>{{ $row->user_suspend }}</td>
						<td>{{ $row->user_inactive }}</td>
					</tr>
				@endforeach	
				</tbody>
				</table>
				</div>
			</div>				
		</div>			
		
	</div>
	<div class="col-sm-6 col-md-6">
		<div class="panel panel-default ">
			<div class="panel-heading"> Last Users Registered </div>
			<div class="panel-body">
			<div class="table-responsive">
			<table class="table table-striped">
				<thead class="">
				  <tr>
					<th scope="col" class="footable-first-column"> Users</th>
					<th data-hide="phone" scope="col"> Email</th>
					<th scope="col"> Username </th>
					<th scope="col"> Join Date</th>
					<th scope="col" class="footable-last-column"> Status</th>
				  </tr>
				</thead>
				<tbody>
				@foreach($lastest_users as $row)
					<tr>
						<td>{{ $row->first_name }} {{ $row->last_name }}</td>
						<td>{{ $row->email }}</td>
						<td>{{ $row->username }}</td>
						<td>{{ $row->created_at }}</td>
						<td>{{ $row->active }}</td>
					</tr>
				@endforeach	
				</tbody>
				</table>
				</div>
			</div>				
		</div>			
		
	</div>	
	
	@endif
	
</div>