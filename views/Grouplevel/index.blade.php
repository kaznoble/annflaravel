
<div class="page-content">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3>{{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
			<li class="active">{{ $pageTitle }}</li>
		</ul>
		<div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
		<ul class="breadcrumb-buttons collapse">

		</ul>
	</div>


	@if(Session::has('message'))
		{{ Session::get('message') }}
	@endif
	<select id="module">
		<option>Select Module</option>
		@foreach($drop as $drops)
			<option value="{{ $drops->module_id }}">{{ $drops->module_title }}</option>
		@endforeach
	</select>

	<select id="pages">
		<option>Select Page</option>
		@foreach($pagedropdownData as $drops)
			<option value="{{ $drops->pageID }}">{{ $drops->title }}</option>
		@endforeach
	</select>

	<div class="module-access">
		<div class="table-responsive div_group_level" id="{{ $row->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php $i=0; foreach($access as $gp) { ?>
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
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row1->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row1->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				// print_r($access1);
				$i=0; foreach($access1 as $gp1) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp1['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".d<?php echo $gp1['group_id'];?>" class="checkAll1" /> </td>
					<td ><?php echo $gp1['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp1['group_id'];?>]" class="d<?php echo $gp1['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp1[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row1->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row2->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row2->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				// print_r($access1);
				$i=0; foreach($access2 as $gp2) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp2['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".e<?php echo $gp2['group_id'];?>" class="checkAll2" /> </td>
					<td ><?php echo $gp2['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp2['group_id'];?>]" class="e<?php echo $gp2['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp2[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row2->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row3->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row3->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				// print_r($access1);
				$i=0; foreach($access3 as $gp3) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp3['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".f<?php echo $gp3['group_id'];?>" class="checkAll3" /> </td>
					<td ><?php echo $gp3['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp3['group_id'];?>]" class="f<?php echo $gp3['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp3[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row3->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row4->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row4->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				// print_r($access1);
				$i=0; foreach($access4 as $gp4) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp4['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".g<?php echo $gp4['group_id'];?>" class="checkAll4" /> </td>
					<td ><?php echo $gp4['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp4['group_id'];?>]" class="g<?php echo $gp4['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp4[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row4->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row5->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row5->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				// print_r($access1);
				$i=0; foreach($access5 as $gp5) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp5['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".h<?php echo $gp5['group_id'];?>" class="checkAll5" /> </td>
					<td ><?php echo $gp5['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp5['group_id'];?>]" class="h<?php echo $gp5['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp5[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row5->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row6->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row6->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access6 as $gp6) { ?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp6['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".i<?php echo $gp6['group_id'];?>" class="checkAll6" /> </td>
					<td ><?php echo $gp6['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp6['group_id'];?>]" class="i<?php echo $gp6['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp6[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row6->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row7->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row7->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access7 as $gp7) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp7['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".j<?php echo $gp7['group_id'];?>" class="checkAll7" /> </td>
					<td ><?php echo $gp7['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp7['group_id'];?>]" class="j<?php echo $gp7['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp7[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row7->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row8->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row8->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access8 as $gp8) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp8['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".k<?php echo $gp8['group_id'];?>" class="checkAll8" /> </td>
					<td ><?php echo $gp8['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp8['group_id'];?>]" class="k<?php echo $gp8['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp8[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row8->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row9->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row9->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access9 as $gp9) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp9['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".l<?php echo $gp9['group_id'];?>" class="checkAll9" /> </td>
					<td ><?php echo $gp9['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp9['group_id'];?>]" class="l<?php echo $gp9['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp9[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row9->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row10->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row10->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access10 as $gp10) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp10['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".m<?php echo $gp10['group_id'];?>" class="checkAll10" /> </td>
					<td ><?php echo $gp10['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp10['group_id'];?>]" class="m<?php echo $gp10['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp10[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>

					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row10->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row11->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row11->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access11 as $gp11) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp11['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".n<?php echo $gp11['group_id'];?>" class="checkAll11" /> </td>
					<td ><?php echo $gp11['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp11['group_id'];?>]" class="n<?php echo $gp11['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp11[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row11->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row12->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row12->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access12 as $gp12) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp12['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".o<?php echo $gp12['group_id'];?>" class="checkAll12" /> </td>
					<td ><?php echo $gp12['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">

						<label >
							<input name="<?php echo $item;?>[<?php echo $gp12['group_id'];?>]" class="o<?php echo $gp12['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp12[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row12->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row13->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row13->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access13 as $gp13) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp13['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".p<?php echo $gp13['group_id'];?>" class="checkAll13" /> </td>
					<td ><?php echo $gp13['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp13['group_id'];?>]" class="p<?php echo $gp13['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp13[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row13->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row14->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row14->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access14 as $gp14) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp14['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".q<?php echo $gp14['group_id'];?>" class="checkAll14" /> </td>
					<td ><?php echo $gp14['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp14['group_id'];?>]" class="q<?php echo $gp14['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp14[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row14->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row15->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row15->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access15 as $gp15) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp15['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".r<?php echo $gp15['group_id'];?>" class="checkAll15" /> </td>
					<td ><?php echo $gp15['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp15['group_id'];?>]" class="r<?php echo $gp15['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp15[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row15->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row16->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row16->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>

				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access16 as $gp16) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp16['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".s<?php echo $gp16['group_id'];?>" class="checkAll16" /> </td>
					<td ><?php echo $gp16['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp16['group_id'];?>]" class="s<?php echo $gp16['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp16[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row16->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row17->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row17->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access17 as $gp17) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp17['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp17['group_id'];?>" class="checkAll17" /> </td>
					<td ><?php echo $gp17['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp17['group_id'];?>]" class="t<?php echo $gp17['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp17[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row17->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row18->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row18->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access18 as $gp18) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp18['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp18['group_id'];?>" class="checkAll18" /> </td>
					<td ><?php echo $gp18['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp18['group_id'];?>]" class="t<?php echo $gp18['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp18[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row18->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row19->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row19->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access19 as $gp19) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp19['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp19['group_id'];?>" class="checkAll19" /> </td>
					<td ><?php echo $gp19['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp19['group_id'];?>]" class="t<?php echo $gp19['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp19[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row19->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row20->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row20->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access20 as $gp20) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp20['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp20['group_id'];?>" class="checkAll20" /> </td>
					<td ><?php echo $gp20['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp20['group_id'];?>]" class="t<?php echo $gp20['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp20[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row20->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row21->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row21->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="21">No</th>
					<th field="name1" width="21">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access21 as $gp21) {?>
				<tr>
					<td  width="21"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp21['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp21['group_id'];?>" class="checkAll21" /> </td>
					<td ><?php echo $gp21['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp21['group_id'];?>]" class="t<?php echo $gp21['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp21[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row21->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row22->module_id }}">
			{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
			<table class="table table-striped " id="table">
				<thead class="no-border">
				<tr>
					<th colspan="8">{{ $row22->module_title }}</th>
				</tr>
				<tr>
					<th field="name1" width="20">No</th>
					<th field="name1" width="20">All</th>
					<th field="name2">Group </th>
					<?php foreach($tasks as $item=>$val) { ?>
					<th field="name3" data-hide="phone"><?php echo $val;?> </th>
					<?php }?>
				</tr>
				</thead>
				<tbody class="no-border-x no-border-y">
				<?php
				$i=0; foreach($access22 as $gp22) {?>
				<tr>
					<td  width="20"><?php echo ++$i;?>
						<input type="hidden" name="group_id[]" value="<?php echo $gp22['group_id'];?>" /></td>
					<td > <input type="checkbox" rel=".t<?php echo $gp22['group_id'];?>" class="checkAll22" /> </td>
					<td ><?php echo $gp22['group_name'];?> </td>
					<?php foreach($tasks as $item=>$val) {?>
					<td  class="">
						<label >
							<input name="<?php echo $item;?>[<?php echo $gp22['group_id'];?>]" class="t<?php echo $gp22['group_id'];?>" type="checkbox"  value="1"
							<?php if($gp22[$item] ==1) echo ' checked="checked" ';?> />
						</label>
					</td>
					<?php }?>
				</tr>
				<?php }?>
				</tbody>
			</table>
			<button type="submit" class="btn btn-success"> Save Changes </button>

			<input name="module_id" type="hidden" id="module_id" value="<?php echo $row22->module_id;?>" />
			{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row23->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row23->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access23 as $gp23) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp23['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp23['group_id'];?>" class="checkAll23" /> </td>
				<td ><?php echo $gp23['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp23['group_id'];?>]" class="t<?php echo $gp23['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp23[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row23->module_id;?>" />
		{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row24->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row24->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access24 as $gp24) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp24['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp24['group_id'];?>" class="checkAll24" /> </td>
				<td ><?php echo $gp24['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp24['group_id'];?>]" class="t<?php echo $gp24['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp24[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row24->module_id;?>" />
		{{ Form::close() }}
		</div>		
		<div class="table-responsive div_group_level" id="{{ $row25->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row25->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access25 as $gp25) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp25['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp25['group_id'];?>" class="checkAll25" /> </td>
				<td ><?php echo $gp25['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp25['group_id'];?>]" class="t<?php echo $gp25['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp25[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row25->module_id;?>" />
		{{ Form::close() }}
		</div>
		<div class="table-responsive div_group_level" id="{{ $row26->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row26->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access26 as $gp26) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp26['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp26['group_id'];?>" class="checkAll26" /> </td>
				<td ><?php echo $gp26['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp26['group_id'];?>]" class="t<?php echo $gp26['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp26[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row26->module_id;?>" />
		{{ Form::close() }}
		</div>			
		<div class="table-responsive div_group_level" id="{{ $row27->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row27->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access27 as $gp27) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp27['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp27['group_id'];?>" class="checkAll27" /> </td>
				<td ><?php echo $gp27['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp27['group_id'];?>]" class="t<?php echo $gp27['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp27[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row27->module_id;?>" />
		{{ Form::close() }}
		</div>
		
		<div class="table-responsive div_group_level" id="{{ $row28->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row28->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access28 as $gp28) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp28['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp28['group_id'];?>" class="checkAll28" /> </td>
				<td ><?php echo $gp28['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp28['group_id'];?>]" class="t<?php echo $gp28['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp28[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row28->module_id;?>" />
		{{ Form::close() }}		
		</div>					
		
		<div class="table-responsive div_group_level" id="{{ $row29->module_id }}">
		{{ Form::open(array('url'=>'/Grouplevel/save', 'class'=>'form-horizontal')) }}
		<table class="table table-striped " id="table">
			<thead class="no-border">
			<tr>
				<th colspan="8">{{ $row29->module_title }}</th>
			</tr>
			<tr>
				<th field="name1" width="20">No</th>
				<th field="name1" width="20">All</th>
				<th field="name2">Group </th>
                <?php foreach($tasks as $item=>$val) { ?>
				<th field="name3" data-hide="phone"><?php echo $val;?> </th>
                <?php }?>
			</tr>
			</thead>
			<tbody class="no-border-x no-border-y">
            <?php
            $i=0; foreach($access29 as $gp29) {?>
			<tr>
				<td  width="20"><?php echo ++$i;?>
					<input type="hidden" name="group_id[]" value="<?php echo $gp29['group_id'];?>" /></td>
				<td > <input type="checkbox" rel=".t<?php echo $gp29['group_id'];?>" class="checkAll29" /> </td>
				<td ><?php echo $gp29['group_name'];?> </td>
                <?php foreach($tasks as $item=>$val) {?>
				<td  class="">
					<label >
						<input name="<?php echo $item;?>[<?php echo $gp29['group_id'];?>]" class="t<?php echo $gp29['group_id'];?>" type="checkbox"  value="1"
                        <?php if($gp29[$item] ==1) echo ' checked="checked" ';?> />
					</label>
				</td>
                <?php }?>
			</tr>
            <?php }?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-success"> Save Changes </button>

		<input name="module_id" type="hidden" id="module_id" value="<?php echo $row29->module_id;?>" />
		{{ Form::close() }}		
		</div>				
		
	</div>

	<div class="page-access">
		@foreach($pagedropdownData as $page)
			<div class="table-responsive" id="page-{{ $page->pageID }}">
				{{ Form::open(array('url'=>'/Grouplevel/pagesave', 'class'=>'form-horizontal')) }}
				<table class="table table-striped " id="table">
					<thead class="no-border">
						<tr>
							<th colspan="8">{{ $page->title }}</th>
						</tr>
						<tr>
							<th field="name1" width="20">No</th>
							<th field="name2" width="20">All</th>
							<th field="name3">Page </th>
                            <th field="name3" data-hide="phone">View </th>
						</tr>
					</thead>
					<tbody class="no-border-x no-border-y">
                    <?php
					$page_access = json_decode($page->access,true);
                    $i=0; foreach($access as $gp) { ?>
					<tr>
						<td width="20"><?php echo ++$i;?> </td>
						<td> <input type="checkbox" rel=".c<?php echo $gp['group_id'];?>" class="checkAll" /> </td>
						<td><?php echo $gp['group_name'];?> </td>
                        <td class="">

							<label >
								<input name="<?php echo $gp['group_name'];?>" class="c<?php echo $gp['group_id'];?>" type="checkbox"  value="1"
                                <?php if((isset($page_access[$gp['group_id']]) ? $page_access[$gp['group_id']] : null) == 1) echo ' checked="checked" ';?> />
							</label>
						</td>
					</tr>
                    <?php }?>
					</tbody>
				</table>
				<button type="submit" class="btn btn-success"> Save Changes </button>

				<input name="page_id" type="hidden" id="page_id" value="<?php echo $page->pageID;?>" />
				{{ Form::close() }}
			</div>
		@endforeach
	</div>

</div>

<script>
    $(document).ready(function(){
        $(".table-responsive").hide();
        $("#module").change(function(){
            $(".page-access").hide();
            $(".module-access").show();
            $(".table-responsive").hide();
            var id=$(this).val();
            $("#"+id).show();
            //var module_id = $(this).val();

        });

        $("#pages").change(function(){
            $(".module-access").hide();
            $(".page-access").show();
            $(".table-responsive").hide();
            var id=$(this).val();
            $("#page-"+id).show();
        });

    });
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

    $(document).ready(function(){

        $(".checkAll1").click(function() {
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
    $(document).ready(function(){

        $(".checkAll2").click(function() {
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
    $(document).ready(function(){

        $(".checkAll3").click(function() {
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
    $(document).ready(function(){

        $(".checkAll4").click(function() {
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
    $(document).ready(function(){

        $(".checkAll5").click(function() {
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
    $(document).ready(function(){

        $(".checkAll6").click(function() {
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
    $(document).ready(function(){

        $(".checkAll7").click(function() {
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
    $(document).ready(function(){

        $(".checkAll8").click(function() {
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
    $(document).ready(function(){

        $(".checkAll9").click(function() {
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
    $(document).ready(function(){

        $(".checkAll10").click(function() {
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
    $(document).ready(function(){

        $(".checkAll11").click(function() {
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
    $(document).ready(function(){

        $(".checkAll12").click(function() {
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
    $(document).ready(function(){

        $(".checkAll13").click(function() {
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
    $(document).ready(function(){

        $(".checkAll14").click(function() {
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
    $(document).ready(function(){

        $(".checkAll15").click(function() {
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
    $(document).ready(function(){

        $(".checkAll16").click(function() {
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
    $(document).ready(function(){

        $(".checkAll17").click(function() {
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
    $(document).ready(function(){

        $(".checkAll18").click(function() {
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
    $(document).ready(function(){

        $(".checkAll19").click(function() {
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
    $(document).ready(function(){

        $(".checkAll20").click(function() {
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
    $(document).ready(function(){

        $(".checkAll21").click(function() {
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
    $(document).ready(function(){

        $(".checkAll22").click(function() {
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
    $(document).ready(function(){

        $(".checkAll23").click(function() {
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
    $(document).ready(function(){

        $(".checkAll24").click(function() {
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
    $(document).ready(function(){

        $(".checkAll25").click(function() {
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
	    $(document).ready(function(){

        $(".checkAll26").click(function() {
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
    $(document).ready(function(){

        $(".checkAll27").click(function() {
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
    $(document).ready(function(){

        $(".checkAll28").click(function() {
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
	    $(document).ready(function(){

        $(".checkAll29").click(function() {
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
