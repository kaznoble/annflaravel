@if($access['is_detail'] ==1)
<tr class="expand-open" id="exp-{{ SiteHelpers::encryptID($row->app_primary_id) }}" style="display:none;">
	<td></td>
		<td colspan="{{ $colspan+2 }}" id="expand-{{ SiteHelpers::encryptID($row->app_primary_id) }}">
		<table class="table table-bordered table-striped " >
			<tbody>						
			@foreach ($tableGrid as $field)
										 
				 @if($field['detail'] =='1' && $field['field'] != 'weekly_monthly')
				 <tr>
				 <td width='25%' class='label-view text-right'>
					@if($field['field'] == 'time_in_job')
						Number Years in Job
					@elseif($field['field'] == 'dept_problem_name')
						Confirm no dept problem name	
					@elseif($field['field'] == 'debt_problem_date')
						Confirm no dept problem date						
					@else
						{{ $field['label'] }}						
					@endif
				 </td>
				 <td width='45%'>
					 {{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
					 @if($field['attribute']['image']['active'] =='1')
						 <img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
					 @elseif($field['field'] == 'created_date' || $field['field'] == 'dob' || $field['field'] == 'policy_notice_date' || $field['field'] == 'debt_problem_date')
						 @if(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) == '0000-00-00')
							 00/00/0000
						 @else
							 {{ date('d/m/Y', strtotime(str_replace('-', '/', SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn)))) }}
						 @endif
					 @elseif($field['field'] == 'timestamp')
						 @if(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) == '0000-00-00 00:00:00')
							 00:00:00
						 @else
							 {{ date('H:i:s', strtotime(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn))) }}
						 @endif
					 @elseif($field['field'] == 'title' && isset($title_array[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($title_array[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'marita_status' && isset($marita_status[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($marita_status[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'contribution_relationship' && isset($contribution_relationship[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($contribution_relationship[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'ccj' && isset($ccj[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($ccj[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'employment_status' && isset($employment_status[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($employment_status[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'home_status' && isset($home_status[$row->{$field['field']}]))
						 {{ SiteHelpers::gridDisplay($home_status[$row->{$field['field']}],$field['field'],$conn) }}
					 @elseif($field['field'] == 'confirm_cust_can_afford_loan'
					 || $field['field'] == 'confirm_cust_gives_content'
					 || $field['field'] == 'admin_view'
					 || $field['field'] == 'declare_other_person_income'
					 || $field['field'] == 'agree_to_privacy_notice'
					 || $field['field'] == 'agree_to_credit_check'
					 || $field['field'] == 'successful_applicant'
					 || $field['field'] == 'processed'
					 || $field['field'] == 'confirm_no_debt_problems')
						 @if(SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) == '1') Yes @else No @endif
					 @else
						 {{ SiteHelpers::gridDisplay($row->{$field['field']},$field['field'],$conn) }}
					 @endif
				 </td>
			</tr>
				 @endif					 
			 @endforeach

			</tbody>
		</table>					
	</td>
	
</tr>	
@endif