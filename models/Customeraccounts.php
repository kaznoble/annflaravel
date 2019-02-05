<?php
class Customeraccounts extends BaseModel  {
	
	protected $table = 'customer_accounts';
	protected $primaryKey = 'account_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){

		return "  SELECT customer_accounts.* FROM customer_accounts  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_accounts.account_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	public static function user_audit_log($action = '', $desc = '', $customer_no = '', $account_no = '')
	{	
		if(empty($account_no))
		{
			$account_no = '';
			$account_no = Input::get('account_no');
		}
		$user_id = Auth::user()->id;
		$info =	User::find($user_id);
		if(!empty(Input::get('search')))
		{
			$search = explode(':', Input::get('search'));
			$customer_no = $search[1];
		}

		DB::table('user_audit_log')->insert(array(
										'customer_no' => $customer_no,
										'first_name' => $info->first_name,
										'last_name' => $info->last_name,
										'staff_number' => $info->staff_id,										
										'account_no' => $account_no,
										'action_date' => date("Y-m-d"),
										'action_time' => date("H:i:s"),										
										'action_performed' => $action,
										'action_description' => $desc										
										
									));
		return $user_id;
	}

    public static function GetSubmissionReport($filter)
    {
        return "SELECT customer_details.forename,customer_details.surname,customer_accounts.account_no as tran_ref, 720735 as firm_ref_number, NOW() as reg_date, customer_accounts.loan_start_date as tran_date, customer_accounts.amount_borrowed as loan_amount,'H' AS loan_type,
                                          customer_accounts.percentage_apr as apr, 0 AS arrangement_fee, customer_accounts.total_payable as total_amount_payable, 0 AS rollover,
                                          0 AS order_rollover, 7*loan_period AS length_of_term, CASE WHEN customer_accounts.reason_for_loan = '1' THEN 'O' WHEN customer_accounts.reason_for_loan = '2' THEN 'P' WHEN customer_accounts.reason_for_loan = '3' THEN 'S' ELSE 'O' END as reason_for_loan, customer_details.date_of_birth,
                                          customer_details.postcode, customer_income.income_total as monthly_income, CASE WHEN customer_details.marital_status = '1' THEN 'M' WHEN customer_details.marital_status = '2' THEN 'S' WHEN customer_details.marital_status = '3' THEN 'P' WHEN customer_details.marital_status = '4' THEN 'D' WHEN customer_details.marital_status = '5' THEN 'L' WHEN customer_details.marital_status = '6' THEN 'W' WHEN customer_details.marital_status = '7' THEN 'O' ELSE 'O' END as marital_status, CASE WHEN customer_details.cus_residential_status = '1' THEN 'O' WHEN customer_details.cus_residential_status = '2' THEN 'L' WHEN customer_details.cus_residential_status = '3' THEN 'T' WHEN customer_details.cus_residential_status = '4' THEN 'T' WHEN customer_details.cus_residential_status = '5' THEN 'C' WHEN customer_details.cus_residential_status = '6' THEN 'T' WHEN customer_details.cus_residential_status = '7' THEN 'J' END as residential_status,
                                          CASE WHEN customer_details.employment_status = '1' THEN 'EF' WHEN customer_details.employment_status = '2' THEN 'EP' WHEN customer_details.employment_status = '3' THEN 'ET' WHEN customer_details.employment_status = '4' THEN 'U' WHEN customer_details.employment_status = '5' THEN 'SE' WHEN customer_details.employment_status = '6' THEN 'S' WHEN customer_details.employment_status = '7' THEN 'HM' WHEN customer_details.employment_status = '8' THEN 'R' WHEN customer_details.employment_status = '9' THEN 'OB' WHEN customer_details.employment_status = '10' THEN 'AF' END as employment_status

                                   FROM customer_accounts
                                   LEFT JOIN customer_details ON (customer_accounts.customer_no = customer_details.customer_no)

                   LEFT JOIN customer_income ON (customer_accounts.customer_no = customer_income.customer_no) $filter";
    }
	
	public static function setPaymentTranEmail($account_no, $customer_no, $data, $payment_type, $datauser)
	{
		// Detect LIVE or DEV
		$sys_site = DB::table('sys_string')->where('sys_id','510')->first();
		$sys_merchantid = $sys_site->value;
		// get enquire email
		$sys_config_B = DB::table('sys_string')->where('sys_id','21')->first();
		$enquiry_email = $sys_config_B->value;
		// get system email 1
		$sysEmailNewAccount = DB::table('sys_emails')->where('email_sys_id', '3')->first();
		$sys_email_1 = $sysEmailNewAccount->email_desc;
		// get sendgrid smtp
		$sys_email = DB::table('sys_string')->where('sys_id','700')->first();
		$sendgrid_smtp = $sys_email->value;
		// get sendgrid from
		$sys_email = DB::table('sys_string')->where('sys_id','701')->first();
		$sendgrid_from = $sys_email->value;
		// get sendgrid user
		$sys_email = DB::table('sys_string')->where('sys_id','702')->first();
		$sendgrid_user = $sys_email->value;
		// get sendgrid password
		$sys_email = DB::table('sys_string')->where('sys_id','703')->first();
		$sendgrid_password = $sys_email->value;
		// get sendgrid key
		$sys_email = DB::table('sys_string')->where('sys_id','704')->first();
		$sendgrid_key = $sys_email->value;				
		
		$subject = "ANN Finance Ltd - Account " . $account_no;
					
		$sys_email_1 = str_replace('$firstname',$datauser['firstname'],$sys_email_1);			
		$sys_email_1 = str_replace('$surname',$datauser['lastname'],$sys_email_1);
		$sys_email_1 = str_replace('$address1',$datauser['address1'],$sys_email_1);
		$sys_email_1 = str_replace('$town',$datauser['town'],$sys_email_1);
		$sys_email_1 = str_replace('$postcode',$datauser['postcode'],$sys_email_1);			
		$sys_email_1 = str_replace('$account_no',$account_no,$sys_email_1);
		$sys_email_1 = str_replace('$customer_no',$customer_no,$sys_email_1);
		$sys_email_1 = str_replace('$amount_borrowed',$data['amount_borrowed'],$sys_email_1);
		$sys_email_1 = str_replace('$loan_period',$data['loan_period'],$sys_email_1);			
		$sys_email_1 = str_replace('$first_amount',$data['payment'],$sys_email_1);			
		$sys_email_1 = str_replace('$frequency_of_payment',$data['frequency_of_payment'],$sys_email_1);
		$sys_email_1 = str_replace('$payment',$data['payment'],$sys_email_1);			
		$sys_email_1 = str_replace('$interest_payable',$data['interest_payable'],$sys_email_1);			
		$sys_email_1 = str_replace('$totalpaidtodate',$data['total_paid_to_date'],$sys_email_1);
		$sys_email_1 = str_replace('date("d/m/Y")',date("d/m/Y"),$sys_email_1);			
		$sys_email_1 = str_replace('$next_payment_due',date('d/m/Y',strtotime($data['next_payment_due_date'])),$sys_email_1);			
		$sys_email_1 = str_replace('$balance',$data['balance'],$sys_email_1);			
		$sys_email_1 = str_replace('$apr',$data['percentage_apr'],$sys_email_1);			
		$sys_email_1 = str_replace('$period_no',$data['period_no'],$sys_email_1);
		$sys_email_1 = str_replace('$no_miss_payment',$data['no_miss_payment'],$sys_email_1);			
		$sys_email_1 = str_replace('$arrears',$data['arrears'],$sys_email_1);
		$sys_email_1 = str_replace('$enquiry_email',$enquiry_email,$sys_email_1);
		$message = $sys_email_1;
							
		$url = 'https://api.sendgrid.com/';
		$user = $sendgrid_user;
		$pass = $sendgrid_password;

		if($sys_merchantid == 'annfinance')
		{
			$emailto_array = array($datauser['user_email']);
		}
		else
		{
			$emailto_array = array($datauser['user_email']);			
		}
		
		$json_string = array(
		  'to' => $emailto_array,
			'category' => 'test_category'
		);

		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'x-smtpapi' => json_encode($json_string),
			'to'        => $datauser['user_email'],
			'cc'		=> 'kaz@spikydesign.com',
			'subject'   => $subject,
			'html'      => $message,
			'text'      => $message,
			'from'      => $sendgrid_from,
		);
					  
		$request =  $url.'api/mail.send.json';

		// Generate curl request
		//$session = curl_init($request);
		// Tell curl to use HTTP POST
		//curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		//curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		//curl_setopt($session, CURLOPT_HEADER, false);
		// Tell PHP not to use SSLv3 (instead opting for TLS)
		//curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
		//curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		//$response = curl_exec($session);
		//curl_close($session);
					
		// set the transaction Log
		$lastInsertId = DB::table('payment_tran_log')->insertGetId([
			'customer_no' => $customer_no,
			'user_id' => $data['user_id'],
			'account_no' => $account_no,
			'week_no' => $data['period_no'],
			'pay_success' => '1',
			'pay_amount' => $data['payment'],
			'next_payment_due_date' => $data['next_payment_due_date'],
			'type_of_payment' => $payment_type,
                        'round_no' => $datauser['round_no']]);
		$trans_log_id = $lastInsertId;
		$transid = "0000000000" . $trans_log_id;
		$transid = substr($transid, -8);
		$transid = "TR" . $transid;
		$trans_log_result = DB::table('payment_tran_log')->where('tran_id', $lastInsertId)
														->update(['tran_no' => $transid]);
	}
	
}
