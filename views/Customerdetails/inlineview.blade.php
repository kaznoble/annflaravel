@if($access['is_detail'] ==1)
<tr class="expand-open" id="exp-{{ SiteHelpers::encryptID($row->id) }}" style="display:none;">
	<td></td>
	<td></td>
	<td></td>
		<td colspan="{{ $colspan }}" id="expand-{{ SiteHelpers::encryptID($row->id) }}"> 
		<table class="table table-bordered table-striped " >
			<tbody>						
			@foreach ($tableGrid as $field)
										 
				 @if($field['detail'] =='1' && $field['field'] != 'user_id' && $field['field'] != 'id' && $field['field'] != 'password' && $field['field'] != 'deleted_at')
				 <tr>
				 <td width='25%' class='label-view text-right'>
				 	@if( $field['field'] == 'address_1' )
				 		First line of Address
				 	@elseif( $field['field'] == 'address_2' )
				 		Town
				 	@elseif( $field['field'] == 'address_3' )
				 		City	 		
				 	@elseif( $field['field'] == 'address_4' )
				 		County		
				 	@elseif( $field['field'] == 'telephone_1' )
				 		Home Telephone	
				 	@elseif( $field['field'] == 'telephone_2' )
				 		Mobile Telephone					 		
				 	@elseif( $field['field'] == 'telephone_3' )
				 		Work Telephone
				 	@elseif( $field['field'] == 'previous_address_1' )
				 		First line of Previous Addres
				 	@elseif( $field['field'] == 'previous_address_2' )
				 		Previous Town
				 	@elseif( $field['field'] == 'previous_address_3' )
				 		Previous City
				 	@elseif( $field['field'] == 'previous_address_4' )
				 		Previous County
				 	@elseif( $field['field'] == 'work_address_1' )
				 		First line of Company Address
				 	@elseif( $field['field'] == 'work_address_2' )
				 		Company Town	
				 	@elseif( $field['field'] == 'work_address_3' )
				 		Company City
				 	@elseif( $field['field'] == 'work_address_4' )
				 		Company County		
				 	@elseif( $field['field'] == 'work_postcode' )
				 		Company Postcode
				 	@elseif( $field['field'] == 'cus_residential_status' )
				 		Customer Residential Status
				 	@elseif( $field['field'] == 't_and_c' )
				 		Terms & Conditions 			
				 	@elseif( $field['field'] == 'no_children_under_18' )
				 		Number of Children under 18
				 	@elseif( $field['field'] == 'no_res_over_18' )
				 		Number of Residential over 18	
				 	@else
				 		{{ $field['label'] }}
				 	@endif
				 </td>
				 <td width='45%'>								 				 
					@if($field['attribute']['image']['active'] =='1')
					<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
					@else	
						{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
						@if( $field['field'] == 'date_of_birth' )
							{{ SiteHelpers::gridDisplay(date('d/m/Y', strtotime($row->$field['field'])),$field['field'],$conn) }}
						@elseif( $field['field'] == 't_and_c' )
							{{ SiteHelpers::gridDisplay( ($row->$field['field'] == 0 ? 'No' : 'Yes' ) ,$field['field'],$conn) }}							
						@else
							{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}
						@endif
					@endif												 
				 </td>
			</tr>
				 @endif					 
			 @endforeach

			</tbody>
		</table>					
	</td>
	<td></td>
	
</tr>	
@endif