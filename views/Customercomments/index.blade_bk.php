{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
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
	   <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
	  <ul class="breadcrumb-buttons collapse">
        <li class="dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search3"></i> <span>Search</span> <b class="caret"></b></a>
          <div class="popup dropdown-menu dropdown-menu-right">
            <form action="#" class="breadcrumb-search">
              <input type="text" placeholder="Type and hit enter..." name="search" class="form-control">              
              <input type="hidden"  value="Search">
            </form>
          </div>
        </li>
			@if($access['is_excel'] ==1)
			<li><a href="{{ URL::to('Customercomments/download') }}" class="tips" title="Download"><i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/Customercomments') }}" class="tips"  title="Configuration"><i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Customercomments/add') }}" class="tips"  title="Create"><i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="Remove"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>
	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}
	<div class="table-responsive">
	 {{ Form::open(array('url'=>'Customercomments/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
    <table class="table table-striped ">
        <thead>
		<tr>
			<th> No </th>
			<th> <input type="checkbox" class="checkall" /></th>
			<th>Action</th>
		 @foreach ($tableGrid as $t)
		 	@if($t['view'] =='1')
			 <th>{{ $t['label'] }}</th>
			 @endif
		  @endforeach
           </tr>
        </thead>

        <tbody>
            @foreach ($rowData as $row)
                <tr>
					<td width="50"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->cust_comments_id }}" />  </td>				
                    <td width="75">
				<div class="btn-group">
                  <button class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
				  	<i class="icon-cogs"></i> <span class="caret"></span>
				</button>
				{{--*/ $id = SiteHelpers::encryptID($row->cust_comments_id) /*--}}
				<ul style="display: none;" class="dropdown-menu icons-right">
					@if($access['is_detail'] ==1)
					<li><a href="{{ URL::to('Customercomments/show/'.$id)}}"><i class="icon-cogs"></i> View Detail </a></li>
					@endif
					@if($access['is_edit'] ==1)
					<li><a href="{{ URL::to('Customercomments/add/'.$id)}}"><i class="icon-grid3"></i> Edit</a></li>
					@endif
					@foreach($subgrid as $md)
					<li><a href="{{ URL::to($md['module'].'?md='.$md['master'].'+'.$md['master_key'].'+'.$md['module'].'+'.$md['key'].'+'.$id) }}">
						<i class="icon-eye2"></i>  {{ $md['title'] }}</a></li>
					@endforeach					
				</ul>			
				  </div>
					</td>
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 <td>					 
					 	@if($field['attribute']['image']['active'] =='1')
							<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
						@else	
							{{ $row->$field['field'] }}	
						@endif						 
					 </td>
					 @endif					 
				 @endforeach
                </tr>
            @endforeach
              
        </tbody>
      
    </table>
	{{ Form::close() }}
	</div>
	<div class="table-footer">
	<div class="row">
	 <div class="col-sm-5">
	  <div class="table-actions">
	 
	   {{ Form::open(array('url'=>'Customercomments/filter/')) }}
		   {{--*/ $pages = array(5,10,20,30,50) /*--}}
		   {{--*/ $orders = array('asc','desc') /*--}}
		<select name="rows" data-placeholder="Display.." class="select-liquid">
		  <option value=""></option>
		  @foreach($pages as $p)
		  <option value="{{ $p }}" 
			@if(isset($pager['rows']) && $pager['rows'] == $p) 
				selected="selected"
			@endif	
		  >{{ $p }}</option>
		  @endforeach
		</select>
		<select name="sort" data-placeholder="Sort.." class="select-liquid" >
		  <option value=""></option>	 
		  @foreach($tableGrid as $field)
		   @if($field['view'] =='1' && $field['sortable'] =='1') 
			  <option value="{{ $field['field'] }}" 
				@if(isset($pager['sort']) && $pager['sort'] == $field['field']) 
					selected="selected"
				@endif	
			  >{{ $field['field'] }}</option>
			@endif	  
		  @endforeach
		 
		</select>	
		<select name="order" data-placeholder="Order.." class="select-liquid">
		  <option value=""></option>
		   @foreach($orders as $o)
		  <option value="{{ $o }}"
			@if(isset($pager['order']) && $pager['order'] == $o)
				selected="selected"
			@endif	
		  >{{$o}}</option>
		 @endforeach
		</select>	
		<button type="submit" class="btn btn-warning">GO</button>	
	  {{ Form::close() }}
	  </div>					
	  </div>
	   <div class="col-sm-3">
		<p class="text-center" style="line-height:30px;">
		Displaying :  <b>{{ $pagination->getFrom() }}</b> To <b>{{ $pagination->getTo() }}</b> Of <b>{{ $pagination->getTotal() }}</b>
		</p>
	   </div>
		<div class="col-sm-4">			 
	  {{ $pagination->appends($pager)->links() }}
	  </div>
	  </div>
	</div>	
	
	</div>	  