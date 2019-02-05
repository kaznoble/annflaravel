<?php
class CustomeraccountsController extends BaseController {
    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'Customeraccounts';
    static $per_page	= '10';

    public function __construct() {
		// include settlement function
		include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/settlementdate.php';
		
		parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Customeraccounts();
        $this->info = $this->model->makeInfo( $this->module);
        $this->access = $this->model->validAccess($this->info['id']);

        $this->data = array(
            'pageTitle'	=> 	$this->info['title'],
            'pageNote'	=>  $this->info['note'],
            'pageModule'	=> 'Customeraccounts',
        );


    }


    public function getIndex()
    {
		// audit log
		// $this->model->user_audit_log('Read', 'Staff member viewed account list');
		
        $account_no = Input::get('account_no');

        $this->data['firstname'] = '';
        $this->data['lastname'] = '';
        $this->data['firstline'] = '';
        $this->data['dob'] = '';
        $this->data['postcode'] = '';
        $this->data['email'] = '';
        $this->data['payment_type'] = '';
		
		if(!empty(Input::get('round_number')))
		{
			Session::put('round_number', Input::get('round_number'));
			$this->data['round_number'] = Input::get('round_number');
		}
		elseif(!empty(Session::get('round_number')))
		{
			$this->data['round_number'] = Session::get('round_number');			
		}

		// clear round session from round admin section.
		if(Input::get('type') == 'menu')
		{
			Session::forget('round_number');
			$this->data['round_number'] = '';					
		}
		
        $this->data['payment_note'] = '';
        $payment_note = Input::get('payment_note');
        if( $payment_note == 'false' )
            $this->data['payment_note'] = 'FAILED - Card payment for account ' . $account_no . ' please check the card details are correct and that that card has not expired.';
        if( $payment_note == 'true' )
            $this->data['payment_note'] = 'PAYMENT WENT THROUGH SUCCESSFULLY!';
        $searchAcc = Input::get('search_account');

        $searchAcc = Input::get('search_account');
        if(!empty($searchAcc)){
            if( $this->searchacc($searchAcc)>0)
            {
                return Redirect::to('Customeraccounts?search=account_no:' . Input::get('search_account'))->with('message', '');
            }else{
                return Redirect::to('Customeraccounts')->withInput()->with('success', 'Incorrect format or record not found.');
            }
        }

        $searchAccount = Input::get('search');
        if( !empty($searchAccount) )
            $searchAccount = substr($searchAccount, -10);

        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

        // Filter sort and order for query
        $sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'loan_status, account_id');
        $order = (!is_null(Input::get('order')) ? Input::get('order') : 'desc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
        // End Filter Search for query

        // Take param master detail if any
        $master  = $this->buildMasterDetail();
        // append to current $filter
        $get_search = Input::get('search');
        if( empty($get_search) )
            $filter .= ' AND customer_accounts.account_id IS NULL';
        else
            $filter .=  $master['masterFilter'];

        $page = Input::get('page', 1);
        $params = array(
            'page'		=> $page ,
            'limit'		=> (!is_null(Input::get('rows')) ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
            'sort'		=> $sort ,
            'order'		=> $order,
            'params'	=> $filter,
            'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query
        $results = $this->model->getRows( $params );

        // Edited by bluebird
        // get baseurl
        $sysbaseurl = DB::table('sys_string')->where('sys_id', '604')->first();
        $base_url = $sysbaseurl->value;
        $this->data['baseurl'] = $base_url;

        if( !empty($_GET['search']) )
        {
            // Init values
            $this->data['maxloansallowed'] = false;

            // get customer no from account record
            $accData = DB::table('customer_accounts')->where('account_no', $searchAccount)->first();
            if( !empty($accData) )
                $customerNo = $accData->customer_no;
            else
                $customerNo = Session::get('session_id');
			
			// if there is customer no on parameter string
			$customerNoPara = Input::get('search');
			$customerNoPara = explode(':',$customerNoPara);
			if( !empty($customerNoPara[1]) )
			{
				if( $customerNoPara[0] != 'account_no' )
				{
					$customerNo = $customerNoPara[1];
					$this->data['customer_no'] = $customerNo;
				}
				else
				{
					$this->data['customer_no'] = $customerNo;					
				}
			}

            if( !empty($customerNo) )
            {
                // get system option max loans account
                $maxnumloans = DB::table('sys_string')->where('sys_id', '10')->first();
                $maxloans = $maxnumloans->value;
                $loanStatusActive = 1;

                //$custAccountCount = DB::table('customer_accounts')->where('customer_no', Session::get('session_id'))->count();
                $custAccountCount = DB::table('customer_accounts')->where('customer_no', $customerNo)->where('loan_status',$loanStatusActive)->count();
                //$custDetails = DB::table('customer_details')->where('customer_no', Session::get('session_id'))->first();
                $custDetails = DB::table('customer_details')->where('customer_no', $customerNo)->first();
                $custDetailsID = SiteHelpers::encryptID($custDetails->id);
                $custUserID = $custDetails->user_id;
                $this->data['custID'] = $custDetailsID;
                $this->data['userID'] = $custUserID;
                $this->data['custAccountCount'] = $custAccountCount;

                // pull user
                $userData = DB::table('users')->where('id', $custUserID)->first();
                $this->data['email'] = $userData->email;

                // get customer details
                $this->data['firstname'] = $custDetails->forename;
                $this->data['lastname'] = $custDetails->surname;
                $this->data['firstline'] = $custDetails->address_1;
                $this->data['dob'] = $custDetails->date_of_birth;
                $this->data['postcode'] = $custDetails->postcode;
                $this->data['mobile'] = $custDetails->telephone_3;

                if($custAccountCount < $maxloans)
                    $this->data['maxloansallowed'] = true;
            }
        }
		
		// if customer no is empty then null value
		if( empty($this->data['customer_no']) )
		{
			$this->data['customer_no'] = null;
		}		

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);

        // Get boolean TEST/LIVE realex
        $sysConfig = DB::table('sys_string')->where('sys_id','603')->first();
        $this->data['useLiveTest'] = $sysConfig->value;

        // Get SETUP card realex url
        $sysConfig = DB::table('sys_string')->where('sys_id','605')->first();
        $this->data['setupcardURL'] = $sysConfig->value;

        // Get TEST realex url
        $sysConfig = DB::table('sys_string')->where('sys_id','602')->first();
        $this->data['testURL'] = $sysConfig->value;

        // Get LIVE realex url
        $sysConfig = DB::table('sys_string')->where('sys_id','601')->first();
        $this->data['liveURL'] = $sysConfig->value;

        if($this->data['useLiveTest'] == 0)
            $this->data['realexURL'] = $this->data['testURL'];
        if($this->data['useLiveTest'] == 1)
            $this->data['realexURL'] = $this->data['liveURL'];

        // Get merchant ID
        $sysConfig = DB::table('sys_string')->where('sys_id','510')->first();
        $this->data['merchantID'] = $sysConfig->value;

        // Get merchant secret word
        $sysConfig = DB::table('sys_string')->where('sys_id','512')->first();
        $this->data['merchantsecret'] = $sysConfig->value;

        // Get sub account
        $sysConfig = DB::table('sys_string')->where('sys_id','511')->first();
        //$sysConfig = DB::table('sys_string')->where('sys_id','514')->first();
        $this->data['subaccount'] = $sysConfig->value;

        // Get currency
        $sysConfig = DB::table('sys_string')->where('sys_id','520')->first();
        $this->data['curr'] = $sysConfig->value;

        // Get Secret
        $sysConfig = DB::table('sys_string')->where('sys_id','555')->first();
        $this->data['secret'] = $sysConfig->value;

        // Replace these with the values you receive from Realex Payments
        $merchantid = $this->data['merchantID'];
        $secret = $this->data['merchantsecret'];
        // The code below is used to create the timestamp format required by Realex Payments
        $timestamp = strftime("%Y%m%d%H%M%S");
        $this->data['timestamp'] = $timestamp;

        mt_srand((double)microtime()*1000000);
        // orderid:Replace this with the order id you want to use.The order id must be unique.
        // In the example below a combination of the timestamp and a random number is used.
        $orderid = $timestamp."-".mt_rand(1, 999);
        $this->data['orderid'] = $orderid;

        $this->data['rowData']		= $results['rows'];
        // Build Pagination
        $this->data['pagination']	= $pagination;
        // Build pager number and append current param GET
        $this->data['pager'] 		= $this->injectPaginate();
        // Row grid Number
        $this->data['i']			= ($page * $params['limit'])- $params['limit'];
        // Grid Configuration
        $this->data['tableGrid'] 	= $this->info['config']['grid'];
        $this->data['tableForm'] 	= $this->info['config']['forms'];
        $this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);
        // Group users permission
        $this->data['access']		= $this->access;
        // Detail from master if any
        $this->data['details']		= $master['masterView'];
        // Master detail link if any
        $this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        $this->layout->nest('content','Customeraccounts.index',$this->data)
            ->with('menus', SiteHelpers::menus());
    }


    function getAdd( $id = null)
    {	
        if($id =='')
        {
            if($this->access['is_add'] ==0 )
                return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        }

        if($id !='')
        {
            if($this->access['is_edit'] ==0 )
                return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        }

        $id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;

        $userID = '';
        if( !empty($_GET['ur']) )
        {
            $userID = SiteHelpers::encryptID($_GET['ur'],true);
        }
        $this->data['userID'] = $userID;

        $row = $this->model->find($id);
        if($row)
        {	
            $this->data['row'] =  $row;			
			// User audit log
			$this->model->user_audit_log('Read', 'Staff member viewed account', $this->data['row']['customer_no'], $this->data['row']['account_no']);					
        } else {
            $this->data['row'] = $this->model->getColumnTable('customer_accounts');
        }
		
		$customer_no = $this->data['row']['customer_no'];
		if(empty($customer_no))
			$customer_no = Input::get('cu');
		$this->data['rd_number'] = '';
		$round_customer = DB::table('round_customer_relation')->where('customer_no', $customer_no)->first();
		if(!empty($round_customer))
		{
			$this->data['rd_number'] = $round_customer->round_number;
		}		
		
		// set the aprCalc
		$defer = DB::table('sys_string')->where('sys_id', '200')->first();
		if($this->data['row']['frequency_of_payment'] == 2)
			$this->data['aprcalc'] = monthlySett($this->data['row']['amount_borrowed'], $this->data['row']['payment'], $this->data['row']['payment'], $this->data['row']['loan_period'], $this->data['row']['payment'], '', '', 0, $this->data['row']['first_payment'], $this->data['row']['total_payable'], $this->data['row']['total_paid_to_date'], $defer->value);
		if($this->data['row']['frequency_of_payment'] == 1)
			$this->data['aprcalc'] = weeklySett($this->data['row']['amount_borrowed'], $this->data['row']['payment'], $this->data['row']['payment'], $this->data['row']['loan_period'], $this->data['row']['payment'], '', '', 0, $this->data['row']['first_payment'], $this->data['row']['total_payable'], $this->data['row']['total_paid_to_date'], $defer->value);
		if($this->data['row']['frequency_of_payment'] == 3)
		{
			$twoWeekLoanPeriod = $this->data['row']['loan_period'] / 2;
			$this->data['aprcalc'] = twoweekSett($this->data['row']['amount_borrowed'], $this->data['row']['payment'], $this->data['row']['payment'], $twoWeekLoanPeriod, $this->data['row']['payment'], '', '', 0, $this->data['row']['first_payment'], $this->data['row']['total_payable'], $this->data['row']['total_paid_to_date'], $defer->value);
		}
		if($this->data['row']['frequency_of_payment'] == 4)
		{
			$fourWeekLoanPeriod = $this->data['row']['loan_period'] / 4;
			$this->data['aprcalc'] = fourweekSett($this->data['row']['amount_borrowed'], $this->data['row']['payment'], $this->data['row']['payment'], $fourWeekLoanPeriod, $this->data['row']['payment'], '', '', 0, $this->data['row']['first_payment'], $this->data['row']['total_payable'], $this->data['row']['total_paid_to_date'], $defer->value);
		}
		
		if(!empty($this->data['aprcalc']))
		{
			// detect weeks run
			$loanPeriod = $this->data['row']['loan_period'];
			if($this->data['row']['frequency_of_payment'] == 3)
				$loanPeriod = $this->data['row']['loan_period'] / 2;	
			if($this->data['row']['frequency_of_payment'] == 4)
				$loanPeriod = $this->data['row']['loan_period'] / 4;				
			
			$rebateSettlement = explode('|', $this->data['aprcalc']);
			$this->data['row']['early_payment_rebate'] = number_format($rebateSettlement[0] - $this->data['row']['arrears'], 2, '.', '');	
			if($this->data['row']['week_no'] >= $loanPeriod)
			{
				//$this->data['row']['early_settlement_balance'] = $this->data['row']['balance'] - $rebateSettlement[0];
				$this->data['row']['early_payment_rebate'] = 0;	
				//$this->data['row']['early_settlement_balance'] = number_format($this->data['row']['balance'], 2, '.', '');
				$this->data['row']['early_settlement_balance'] = 0;				
			}
			else
			{
				$this->data['row']['early_settlement_balance'] = number_format($rebateSettlement[1], 2, '.', '');
			}
			
			// detect if rebate/settlement minus figure
			if($this->data['row']['early_payment_rebate'] < 0)
				$this->data['row']['early_payment_rebate'] = 0;
		}
		
		// detect if all paid then no rebate/settlement
		if($this->data['row']['total_paid_to_date'] >= $this->data['row']['total_payable'])
		{
			$this->data['row']['early_payment_rebate'] = 0;
			$this->data['row']['early_settlement_balance'] = 0;				
		}
		
		// detect if balance less than 0.50p
		if($this->data['row']['balance'] <= 0.50)
		{
			$this->data['row']['balance'] = 0;
		}

		// loan period array for non four week
		$nonfourweekloanperiod = DB::table('loan_period')->where('number_of_weeks','<>','32')->orderByRaw('number_of_weeks ASC')->get();
		$nonfourweekloanperiod = json_encode((array)$nonfourweekloanperiod);
		$this->data['nonfourweekloanperiod'] = $nonfourweekloanperiod;
		
		// loan period array for four week
		$fourweekloanperiod = DB::table('loan_period')->where('number_of_weeks','<>','30')->orderByRaw('number_of_weeks ASC')->get();
		$fourweekloanperiod = json_encode((array)$fourweekloanperiod);
		$this->data['fourweekloanperiod'] = $fourweekloanperiod;
		
        // get letter sent for account
        if(empty($id))
        {
            $this->data['arrears_letter'] = 0;
        }
                
        $this->data['id'] = $id;
        $this->data['cu'] = Input::get('cu');
        $this->layout->nest('content','Customeraccounts.form',$this->data)->with('menus', $this->menus );
    }

    function getShow( $id = null)
    {

        if($this->access['is_detail'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

        $ids = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
        $row = $this->model->getRow($ids);
        if($row)
        {
            $this->data['row'] =  $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('customer_accounts');
        }
		
		// User audit log
		$this->model->user_audit_log('Read', 'Staff member viewed details account', $this->data['row']->customer_no, $this->data['row']->account_no);			
		
        $this->data['id'] = $id;
        $this->data['access']		= $this->access;
        $this->layout->nest('content','Customeraccounts.view',$this->data)->with('menus', $this->menus );
    }

    function postSave( $id =0)
    {
        require_once(dirname(__FILE__) . "/../../../Classes/models/sendgrid.class.php");
        $sendgrid = new sendgrid();
        $session_id = Session::get('session_id');
        $form = Input::get('form');

        $data['user_id'] = Input::get('user_id');
        $user_id = Input::get('user_id');
        $this->data['userID'] = Input::get('user_id');
        $customer_no = Input::get('customer_no');

        $rules = array(
            'frequency_of_payment' => 'required',
            'loan_period' => 'required|not_in:0',
            't_and_c' => 'required',
            'loan_status' => 'required',
            'reason_for_loan' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('customer_accounts');

            // get user details
            $user_details = DB::table('customer_details')->where('user_id',$user_id)->first();
            $datauser['user_email'] = $user_details->secondary_email;
            $datauser['firstname'] = $user_details->forename;
            $datauser['lastname'] = $user_details->surname;
            $datauser['address1'] = $user_details->address_1;
            $datauser['town'] = $user_details->address_4;
            $datauser['postcode'] = $user_details->postcode;

            $customer_no = Input::get('customer_no');
            $account_no = Input::get('account_no');
            $user_id = Input::get('user_id');
            $data['user_id'] = $user_id;

            // correct fields format
            $data['arrears'] = Input::get('arrears');
            $data['payment'] = Input::get('payment');
            $amountpayment = Input::get('payment') * 100;
            $data['loan_period'] = Input::get('loan_period');
            $data['payment_type'] = Input::get('payment_type');
            $data['balance'] = Input::get('balance');
            $data['frequency_of_payment'] = Input::get('frequency_of_payment');
            //$data['loan_start_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('loan_start_date'))));
			if( $form == 'new' )
            {
				$data['loan_start_date'] = date('Y-m-d');				
			}
			else
			{
				$data['loan_start_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('loan_start_date'))));
			}		
            $data['loan_end_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('loan_end_date'))));
            $data['first_payment'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('first_payment'))));
            $data['next_payment_due_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('next_payment_due_date'))));
            $data['last_payment_made'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('last_payment_made'))));
            $data['percentage_apr'] = str_replace('%','',Input::get('percentage_apr'));
            $data['period_no'] = Input::get('week_no');
            $data['total_payment_still_due'] = '0.00';
            $data['reason_for_loan'] = Input::get('reason_for_loan');
            $data['loan_status_reduced_desc'] = Input::get('loan_status_reduced_desc');
            $data['round_number'] = Input::get('round_number');
            $datauser['round_no'] = Input::get('round_number');
            $data['arrears_letter'] = ( !empty(Input::get('arrears_letter')) ? Input::get('arrears_letter') : '0');
            $customerAccDetails = DB::table('customer_accounts')->where('account_id',SiteHelpers::encryptID($id,true))->first();
            if( !empty($customerAccDetails->payer_ref) )
                $data['payer_ref'] = $customerAccDetails->payer_ref;
            if( !empty($customerAccDetails->pmt_ref) )
                $data['pmt_ref'] = $customerAccDetails->pmt_ref;

            $accountID = Input::get('account_id');
            $ID = $this->model->insertRow($data , Input::get('account_id'));
            DB::table('customer_main')->where('customer_no',Input::get('customer_no'))->update(['seen' => date('Y-m-d H:i:s')]);
            // Input logs
            if( empty($accountID) )
            {

                $accDig = substr('000000000' . $ID, -8);
                $accNo = 'AC' . $accDig;
                $account_no = $accNo;

                if($data['payment_type'] == 'Cash')
                {
                    $data['payment'] = 0;
                    $this->model->setPaymentTranEmail($account_no, $customer_no, $data, '3', $datauser);
                }

                DB::table('customer_accounts')->where('account_id',$ID)->update(array('account_no' => $accNo));
                DB::table('account_history')->insert(
                    array('account_no' => $accNo,
                        'customer_no' => Input::get('customer_no'),
                        'transaction_type' => '1',
                        'debits' => Input::get('amount_borrowed'),
                        'balance' => Input::get('amount_borrowed')
                    ));
                DB::table('account_history')->insert(
                    array('account_no' => $accNo,
                        'customer_no' => Input::get('customer_no'),
                        'transaction_type' => '2',
                        'debits' => Input::get('interest_payable'),
                        'balance' => Input::get('balance')
                    ));
                $sys_config_B = DB::Select("SELECT `value` FROM `sys_string` WHERE `sys_id` = '21' limit 1 ");
                foreach($sys_config_B As $sys_B)
                {
                    $enquiry_email = $sys_B->value;
                }
                // Send Email To Customer about the new account creation using SendGrid Account.
                $Templete = Systemconfiguration::where('sys_id','807')->get();
                $cur_date = date("d/m/Y");
                $first_amount = 0; // First Amount Will always be 0
                $Data  = array('<Account Number>' => array($accNo), '$firstname' => array($datauser['firstname']), '$surname' => array($datauser['lastname']), '$address1' => array($datauser['address1']), '$town' => array($datauser['town']), '$postcode' => array($datauser['postcode']), '$account_no' => array($accNo), '$customer_no' => array($customer_no), '$amount_borrowed' => array(Input::get('amount_borrowed')), '$loan_period' => array(Input::get('loan_period')), '$first_amount' => array($first_amount), '$payment' => array(Input::get('payment')), '$interest_payable' => array(Input::get('interest_payable')), '$totalpaidtodate' => array(Input::get('total_paid_to_date')), '$current_date' => array($cur_date), '$next_payment_due' => array(Input::get('next_payment_due_date')), '$balance' => array($data['balance']), '$apr' => array($data['percentage_apr']), '$period_no' => array($data['period_no']), '$no_miss_payment' => array(Input::get('no_miss_payment')), '$arrears' => array($data['arrears']), '$enquiry_email' => array($enquiry_email));
                $CustomerName = $datauser['firstname'].' '.$datauser['lastname'];
                $sendgrid->sendgrid_mail($Templete[0]->value,$Data,$datauser['user_email'],$CustomerName);
                $this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
				$this->model->user_audit_log('Create', 'Staff member created a new account', $customer_no, $accNo);				
            } else {
				$this->model->user_audit_log('Updated', 'Staff member updated the account', $customer_no, $account_no);
                $this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
            }
			
            // Redirect after save
            if( $form == 'new' )
            {
				// User audit log
                if(empty($accNo)) $accNo = $account_no;
                return Redirect::to('Merchantpayment?amountpence='.$amountpayment.'&customer_no='.Input::get('customer_no').'&account_no='.$accNo)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
            }
            elseif( !empty($session_id) )
            {
				// User audit log
                return Redirect::to('Customeraccounts?search=customer_no:'.$customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
            }
            else
            {
                return Redirect::to('Customeraccounts?search=customer_no:' . $customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
            }
        } else {
            return Redirect::to('Customeraccounts/add/'.$id.'?cu='.$customer_no.'&form=new&ur='.SiteHelpers::encryptID($user_id))->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
                ->withErrors($validator)->withInput();
        }

    }

    public function postDestroy()
    {
		$accId = Input::get('id');
		$acc_id = explode(",",Input::get('checkedAccId'));

		//Get account number
		$accountData = DB::table('customer_accounts')->whereIn('account_id', $acc_id)->get();
		$accountno = '';
		foreach($accountData As $accData)
		{
			$accountno = $accData->account_no . ',' . $accountno;
		}
		
        $session_id = Session::get('session_id');
		$customer_no = Input::get('customer_no');
		if(empty($customer_no))
			$customer_no = $session_id;
		else
			$customer_no = Input::get('customer_no');

        if($this->access['is_remove'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        // delete multipe rows

        $this->model->destroy($acc_id);
        $this->inputLogs("ID : ".$accountno."  , Has Been Removed Successful");
        // redirect
        Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
		
		// User audit log
		$this->model->user_audit_log('Delete', 'Staff member deleted the account', $customer_no, $accountno);		

        if( !empty($session_id) )
        {
            return Redirect::to('Customeraccounts?search=customer_no:'.$session_id);
        }
        else
        {
            return Redirect::to('Customeraccounts?search=customer_no:'.$customer_no);
        }
    }
    // check account number
    public function searchacc($searchAcc)
    {
        $data = Input::all();
        $result = DB::table('customer_accounts')->where('account_no', 'like', '%'.$searchAcc.'%')->first();
        //print_r($result);die();
        if(count($result)>0)
        {
            return count($result);
        }
        else
        {
            return 0;
        }




    }

}
