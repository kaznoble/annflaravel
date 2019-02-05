
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
          <h3> Edit : {{ $row->module_name }} </h3>
      </div>
    </div>

 
    <div class="breadcrumb-line">
 <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>

		
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
        <li class="{{(Session::get('gid') != 1 ? 'display_none' : '')}}" ><a href="{{ URL::to( $module ) }}">{{ $pageTitle }}</a></li>
		<li class="active"> Permission </li>
      </ul>
	    
	</div>  
	
	<div><a href="/Grouplevel" >< Return to Group access page</a></div>	
	
	@include('admin.module.tab',array('active'=>'permission'))

@if(Session::has('message'))
       {{ Session::get('message') }}
@endif

 {{ Form::open(array('url'=>$module.'/savepermission/'.$module_name, 'class'=>'form-horizontal')) }}

 
<div class="table-responsive">
		<table class="table table-striped " id="table">
		<thead class="no-border">
  <tr>
	<th field="name1" width="20">No</th>
	<th field="name1" width="20">All</th>
	<th field="name2">Group </th>
	<?php foreach($tasks as $item=>$val) {?>	
	<th field="name3" data-hide="phone"><?php echo $val;?> </th>
	<?php }?>

  </tr>
</thead>  
<tbody class="no-border-x no-border-y">	
  <?php $i=0; foreach($access as $gp) {?>	
  	<tr>
		<td  width="20"><?php echo ++$i;?>
		<input type="hidden" name="group_id[]" value="<?php echo $gp['group_id'];?>" /></td>
		<td > <input type="checkbox" rel=".c<?php echo $gp['group_id'];?>" class="checkAll" /> </td>
		<td ><?php echo $gp['group_name'];?> </td>
		<?php foreach($tasks as $item=>$val) {?>	
		<td  class="">
		
		<label >
			<input name="<?php echo $item;?>[<?php echo $gp['group_id'];?>]" class="c<?php echo $gp['group_id'];?>" type="checkbox"  value="1"
			<?php if($gp[$item] ==1) echo ' checked="checked" ';?> />
		</label>	
		</td>

		<?php }?>
	</tr>  
	<?php }?>
  </tbody>
</table>	
</div>
<div class="infobox infobox-danger fade in {{(Session::get('gid') != 1 ? 'display_none' : '')}}">
  <button type="button" class="close" data-dismiss="alert"> x </button>
  <h5>Please Read !</h5>
  <ol> 
  	<li> If you want users <strong>only</strong> able to access they own records , then <strong>Global</strong> must be <code>uncheck</code> </li>
	<li> When you using this feature , Database table must have <strong><code>entry_by</code></strong> field </li>
	</ol>	
</div>	
<button type="submit" class="btn btn-success"> Save Changes </button>	
	
<input name="module_id" type="hidden" id="module_id" value="<?php echo $row->module_id;?>" />
 {{ Form::close() }}	
	
	
</div>	

<script>
	$(document).ready(function(){
	
		$(".checkAll").click(function() {
			var cblist = $(this).attr('rel');
			var cblist = $(cblist);
			if($(this).is(":checked"))
			{				
				cblist.prop("checked", !cblist.is(":checked"));
			} else {	
				cblist.removeAttr("checked");
			}	
			
		});  	
	});
</script>