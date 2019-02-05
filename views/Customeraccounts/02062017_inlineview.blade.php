@if($access['is_detail'] ==1)
<tr class="expand-open" id="exp-{{ SiteHelpers::encryptID($row->account_id) }}" style="display:none;">
	<td></td>
	<td></td>
	<td></td>
		<td colspan="{{ $colspan }}" id="expand-{{ SiteHelpers::encryptID($row->account_id) }}"> 
		<table class="table table-bordered table-striped " >
			<tbody>						
			@foreach ($tableGrid as $field)
										 
				 @if($field['detail'] =='1')
				 <tr >
				 <td width='25%' class='label-view text-right' >{{ $field['label'] }} </td>
				 <td width='45%' >								 				 
					@if($field['attribute']['image']['active'] =='1')
					<img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
					@else	
						{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
						@if( ($field['field'] == 'last_payment_made') || ($field['field'] == 'created_at') || ($field['field'] == 'updated_at') || ($field['field'] == 'next_payment_due_date') || ($field['field'] == 'loan_end_date') || ($field['field'] == 'loan_start_date') || ($field['field'] == 'first_payment') || ($field['field'] == 'updated_at') )
							@if( $row->$field['field'] != '0000-00-00' && $row->$field['field'] != '0000-00-00 00:00:00' )
								{{ SiteHelpers::gridDisplay(date('d/m/Y', strtotime($row->$field['field'])),$field['field'],$conn) }}	
							@else
								No Date
							@endif
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
	<td>
					{{--*/ $amountpence = SiteHelpers::poundpence($row->payment) /*--}}	
					<?php 
						// for initial payment setup
						$amountpence = 0;
					?>
					{{--*/ $sha1 = SiteHelpers::makesha1($merchantID,$orderid,$amountpence,$curr,$merchantsecret,$timestamp) /*--}}
									
					@if( $row->payer_ref == '' && $row->payment_type!="Cash")
					<div class="make_payment_button" >
						<form id="payment_form_{{ $i }}" method="POST" action="{{ $setupcardURL }}" >
						<input type="hidden" name="MERCHANT_ID" value="{{ $merchantID }}">
						<input type="hidden" name="ORDER_ID" value="{{ $orderid }}">
						<input type="hidden" name="PROD_ID" value="{{ $row->account_no }}">									
						<input type="hidden" name="AMOUNT" value="{{ $amountpence }}">
						<input type="hidden" name="CURRENCY" value="{{ $curr }}">
						<input type="hidden" name="CUST_NUM" value="{{ $row->customer_no }}">
						<input type="hidden" name="ACCOUNT" value="{{ $subaccount }}"> 
						<input type="hidden" name="TIMESTAMP" value="{{ $timestamp }}">
						<input type="hidden" name="SHA1HASH" value="{{ $sha1 }}">
						<input type="hidden" name="AUTO_SETTLE_FLAG" value="1">
						<input type="hidden" name="VAR_REF" value="{{ $row->account_no }}">
						<input type="hidden" name="COMMENT1" value="{{ $row->account_no }}">
						<input type="hidden" name="COMMENT2" value="{{ $baseurl }}/Customeraccounts">
						<input type="hidden" name="OFFER_SAVE_CARD" value="0">
						<input type="hidden" name="PAYER_REF" value="{{ $row->account_no }}">
						<input type="hidden" name="PMT_REF" value="{{ $row->customer_no }}" >
						<input type="hidden" name="PAYER_EXIST" value="0" >
						<input type="hidden" name="CARD_STORAGE_ENABLE" value="1">
						<input type="hidden" name="VALIDATE_CARD_ONLY" value="1">						
						Setup payment:
						<input type="text" id="1st_amount_{{ $i }}" name="1st_amount" style="width:40px;" value="{{ $row->payment }}">
							<input id="make_payment_submit" name="{{ $i }}" type="button" value="Set Up Payment" class="make_payment_submit btn btn-info" >
						</form>						
					</div>
					@else
					<div class="make_payment_button" >
						<form id="payment_form_{{ $i }}" method="POST" action="{{ $realexURL }}" >
						<input type="hidden" id="account_no_{{ $i }}" name="account_no_{{ $i }}" value="{{ $row->payer_ref }}">
						<input type="hidden" id="account_id_{{ $i }}" name="account_id" value="{{$id}}" />
						<input type="hidden" id="customer_no" name="customer_no" value="{{ $row->pmt_ref }}">
						<input id="add_cash_submit" name="{{ $i }}" type="button" value="Cash Payment" class="add_cash_submit btn btn-info" >
						</form>						
					</div><br/>
					@if($row->payment_type!="Cash")
					<div class="hide_card" id="hidecard">
					<div class="add_payment_with_schedule" style="margin-top: 15px;" >
						<form id="add_payment_form_{{ $i }}" method="POST" action="{{ $realexURL }}" >
						<input type="hidden" id="account_no_sche{{ $i }}" name="account_no_{{ $i }}" value="{{ $row->payer_ref }}">
						<input type="hidden" id="account_id_sche{{ $i }}" name="account_id" value="{{$id}}" />
						<input type="hidden" id="customer_no_sche" name="customer_no" value="{{ $row->pmt_ref }}">
						<input id="add_payment_schedule" name="{{ $i }}" type="button" value="Card Payment" class="add_payment_submit_sche btn btn-info" >
						</form>						
					</div>	
					<div style="height:1px;border-bottom:1px solid #ccc;padding-top:15px;" ></div>					
					<div class="update_card" style="margin-top: 15px;" >
						<form id="update_card_{{ $i }}" method="POST" action="{{ $realexURL }}" >
						<input type="text" id="card_name_{{ $i }}" name="card_name" placeholder="Card name" /><br />
						<input type="text" id="card_number_{{ $i }}" name="card_number" placeholder="Card number" /><br />
						<input type="text" id="card_expiry_{{ $i }}" name="card_expiry" placeholder="08" style="width:30px;" />/
						<input type="text" id="card_expiry_yr{{ $i }}" name="card_expiry_yr" placeholder="19" style="width:30px;" /><br />
						<select id="card_type_{{ $i }}" name="card_type" >
							<option value="VISA" >Visa</option>
							<option value="MC" >Mastercard</option>
						</select>
						<input type="hidden" id="account_no_update{{ $i }}" name="account_no_{{ $i }}" value="{{ $row->payer_ref }}">
						<input type="hidden" id="account_id_update{{ $i }}" name="account_id" value="{{$id}}" />
						<input type="hidden" id="customer_no_update{{ $i }}" name="customer_no" value="{{ $row->pmt_ref }}">
						<input id="update_card_submit" name="{{ $i }}" type="button" value="Update Card" class="update_card_submit btn btn-info" >
						</form>	<br/><br/>			
					</div>
					</div>	
					@endif
				@endif		
	</td>
	
</tr>	
@endif


