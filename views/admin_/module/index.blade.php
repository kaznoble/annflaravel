
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
        <li class="active">{{ $pageTitle }}</li>
      </ul>
		<div class="visible-xs breadcrumb-toggle">
			<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
			<i class="icon-menu2"></i>
			</a>
		</div>
	  <ul class="breadcrumb-buttons collapse">  
	   <li><a href="{{ URL::to('module/add') }}" title=""><i class="icon-plus-circle2"></i> Create</a></li>
	  </ul>	  
	</div>
	
	<ul class="nav nav-tabs" style="margin-bottom:10px;">
	  <li @if($type =='addon') class="active" @endif><a href="{{ URL::to('module')}}"> Installed Module  </a></li>
	  <li @if($type =='core') class="active" @endif><a href="{{ URL::to('module?t=core')}}">Core Module</a></li>
	</ul>
		
@if(Session::has('message'))
       {{ Session::get('message') }}
@endif	
	
	<div class="table-responsive">
	@if(count($rowData) >=1) 
		<table class="table table-striped ">
			<thead>
			<tr>
				<th>Action</th>					
				<th>Module</th>
				<th>Controller</th>
				<th>Database</th>
				<th>PRI</th>
				<th>Created</th>
		
			</tr>
			</thead>
        <tbody>
		@foreach ($rowData as $row)
			<tr>		
				<td>
				<div class="btn-group">
				<button class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
				<I class="icon-cogs"></I> <span class="caret"></span>
				</button>
					<ul style="display: none;" class="dropdown-menu icons-right">
						<li><a href="{{ URL::to($row->module_name)}}"><i class="icon-grid"></i> View Module </a></li>
						<li><a href="{{ URL::to($module.'/config/'.$row->module_name)}}"><i class="icon-pencil3"></i> Edit</a></li>
						@if($type !='core')
						<li><a href="javascript://ajax" onclick="SximoConfirmDelete('{{ URL::to('module/destroy/'.$row->module_id)}}')"><i class="icon-bubble-trash"></i> Remove</a></li>
						<li class="divider"></li>
						<li><a href="{{ URL::to('module/rebuild/'.$row->module_id)}}"><i class="icon-spinner7"></i> Rebuild All Codes</a></li>
						@endif
					</ul>
				</div>					
				</td>
				<td>{{ $row->module_title }} </td>
				<td>{{ $row->module_name }} </td>
				<td>{{ $row->module_db }} </td>
				<td>{{ $row->module_db_key }} </td>
				<td>{{ $row->module_created }} </td>
			</tr>
		@endforeach	
	</tbody>		
	</table>
	
	@else
		<p class="text-center"> No Record Found !</p>
	
	@endif
	</div>	
			

</div>	  
	  
	  