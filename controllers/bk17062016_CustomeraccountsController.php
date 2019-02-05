<?php
class CustomeraccountsController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Customeraccounts';
	static $per_page	= '10';
	
	public function __construct() {
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
		//Session::forget('session_id');
		//Session::forget('sCustDetailsID');		
		$account_no = Input::get('account_no');
		
		$this->data['firstname'] = '';
		$this->data['lastname'] = '';
		$this->data['firstline'] = '';
		$this->data['dob'] = '';
		$this->data['postcode'] = '';
		$this->data['email'] = '';		
		
		$this->data['payment_note'] = '';
		$payment_note = Input::get('payment_note');
		if( $payment_note == 'false' )
			$this->data['payment_note'] = 'FAILED - Card payment for account ' . $account_no . ' please check the card details are correct and that that card has not expired.';
		if( $payment_note == 'true' )
			$this->data['payment_note'] = 'PAYMENT WENT THROUGH SUCCESSFULLY!';			
		
		$searchAcc = Input::get('search_account');
		if( !empty($searchAcc) )
			return Redirect::to('Customeraccounts?search=account_no:' . Input::get('search_account'))->with('message', '');
		$searchAccount = Input::get('search');
		if( !empty($searchAccount) )
			$searchAccount = substr($searchAccount, -10);
		
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'account_id'); 
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
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		
		
		// Get boolean TEST/LIVE realex
		$sysConfig = DB::table('sys_string')->where('sys_id','603')->first();
		$this->data['useLiveTest'] = $sysConfig->value;
		
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
		} else {
			$this->data['row'] = $this->model->getColumnTable('customer_accounts'); 
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
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Customeraccounts.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{	
		$session_id = Session::get('session_id');
		$form = Input::get('form');

		$rules = array(
			't_and_c' => 'required',
			'loan_status' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_accounts');
			
			$customer_no = Input::get('customer_no');
			$account_no = Input::get('account_no');
			
			// correct fields format
			$data['arrears'] = Input::get('arrears');
			$data['user_id'] = Input::get('user_id');
			$data['payment'] = Input::get('payment');
			$amountpayment = Input::get('payment') * 100;
			$data['loan_period'] = Input::get('loan_period');
			$data['balance'] = Input::get('balance');
			$data['frequency_of_payment'] = Input::get('frequency_of_payment');
			//$data['frequency_of_payment'] = str_replace('</p>','',$data['frequency_of_payment']);	
			$data['loan_start_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('loan_start_date'))));
			$data['loan_end_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('loan_end_date'))));		
			$data['first_payment'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('first_payment'))));	
			$data['next_payment_due_date'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('next_payment_due_date'))));
			$data['last_payment_made'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('last_payment_made'))));			
			$data['percentage_apr'] = str_replace('%','',Input::get('percentage_apr'));		
			$data['period_no'] = Input::get('week_no');
			$data['total_payment_still_due'] = '0.00';		
			$data['reason_for_loan'] = Input::get('reason_for_loan');
			$data['loan_status_reduced_desc'] = Input::get('loan_status_reduced_desc');		
			//$data['payer_ref'] = $account_no;
			//$data['pmt_ref'] = $customer_no;
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
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");			
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");   
			}
			// Redirect after save	
			if( $form == 'new' )
			{
				if(empty($accNo)) $accNo = $account_no;
				return Redirect::to('Merchantpayment?amountpence='.$amountpayment.'&customer_no='.Input::get('customer_no').'&account_no='.$accNo)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));	
			}
			elseif( !empty($session_id) )
			{
				return Redirect::to('Customeraccounts?search=customer_no:'.$customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));	
			}
			else
			{
				return Redirect::to('Customeraccounts')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));	
			}
		} else {
			return Redirect::to('Customeraccounts/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
			->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postDestroy()
	{
		$session_id = Session::get('session_id');		
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));		
		// delete multipe rows 
		$this->model->destroy(Input::get('id'));
		$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successful");
		// redirect
		Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
		
		if( !empty($session_id) )
		{
			return Redirect::to('Customeraccounts?search=customer_no:'.Session::get('session_id'));	
		}
		else
		{
			return Redirect::to('Customeraccounts');
		}		
	}			
		
}