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
        <li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
        <li class="active">{{ $pageTitle }}</li>
      </ul>
	   <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	<div class="table-responsive">
	
		<p>Would you like to make payment now?</p>

		{{--*/ $sha1 = SiteHelpers::makesha1($merchantID,$orderid,$amountpence,$curr,$merchantsecret,$timestamp) /*--}}

		<div class="make_payment_button" >
			<!--<form id="payment_form" method="POST" action="https://hpp.sandbox.realexpayments.com/pay" >-->
			<form id="payment_form" method="POST" action="{{ $realexURL }}" >
			<!--<form id="payment_form_{{ $i }}" method="POST" action="https://hpp.realexpayments.com/pay" >-->
			<!--<form id="payment_form_{{ $i }}"  method="POST" action="https://epage.payandshop.com/epage.cgi">-->
			<input type="hidden" name="MERCHANT_ID" value="{{ $merchantID }}">
			<input type="hidden" name="ORDER_ID" value="{{ $orderid }}">
			<input type="hidden" name="PROD_ID" value="{{ $account_no }}">			
			<input type="hidden" name="AMOUNT" value="{{ $amountpence }}">
			<input type="hidden" name="CURRENCY" value="{{ $curr }}">
			<input type="hidden" name="CUST_NUM" value="{{ $customer_no }}">
			<input type="hidden" name="ACCOUNT" value="{{ $subaccount }}"> 
			<input type="hidden" name="TIMESTAMP" value="{{ $timestamp }}">
			<input type="hidden" name="SHA1HASH" value="{{ $sha1 }}">
			<input type="hidden" name="AUTO_SETTLE_FLAG" value="1">
			<input type="hidden" name="VAR_REF" value="{{ $account_no }}">
			<input type="hidden" name="COMMENT1" value="{{ $account_no }}">
			<input type="hidden" name="COMMENT2" value="{{ $baseurl }}/Customeraccounts">
			<!--<input type="hidden" name="FREQUENCY" value="" >-->
			<input type="hidden" name="OFFER_SAVE_CARD" value="0">
			<input type="hidden" name="PAYER_REF" value="{{ $account_no }}">
			<input type="hidden" name="PMT_REF" value="{{ $customer_no }}" >
			<input type="hidden" name="PAYER_EXIST" value="0" >
			<input type="hidden" name="CARD_STORAGE_ENABLE" value="1">
			<input type="hidden" name="VALIDATE_CARD_ONLY" value="1">
			<!--<input type="hidden" name="RECURRING_TYPE" value="fixed">
			<input type="hidden" name="RECURRING_SEQUENCE" value="first">-->
			<input id="make_payment_submit" name="make_payment_submit" type="submit" value="Insert card details" class="make_payment_submit btn btn-info" >
			<!--<input type="submit" value="Make Payment" />-->
			</form>						
		</div>		
		<br /><br />
		<p><a href="{{ URL::to('Customeraccounts?search=customer_no:'.$customer_no)}}" >No thanks click here to return</a></p>

	</div>
	<!-- @include('footer') -->
	
	</div>	  
	
<script>
$(document).ready(function(){

	/*$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("Merchantpayment/multisearch")}}');
		$('#SximoTable').submit();
	});*/
	
});	
</script>		