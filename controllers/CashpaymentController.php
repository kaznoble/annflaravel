<?php
require_once(dirname(__FILE__) . "/../../../Classes/db/Db.class.php");
require_once(dirname(__FILE__) . "/../../../Classes/models/annfinance.class.php");

class CashpaymentController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Cashpayment';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Cashpayment();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Cashpayment',
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'account_id'); 
		$order = (!is_null(Input::get('order')) ? Input::get('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		// End Filter Search for query 
		
		// Take param master detail if any
		$master  = $this->buildMasterDetail(); 
		// append to current $filter
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
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		
		
		
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
		$this->layout->nest('content','Cashpayment.index',$this->data)
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
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('customer_accounts'); 
		}
		
		// get today date
		$this->data['todayDate'] =  date('d/m/Y', strtotime('-1 day', strtotime(date('Y-m-d'))));
		
		$this->data['id'] = $id;
		$this->layout->nest('content','Cashpayment.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','Cashpayment.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
			
	    // Include sendgrid class
        require_once(dirname(__FILE__) . "/../../../Classes/models/sendgrid.class.php");
        // Creates the sendgrid class instance
        $sendgrid = new sendgrid();
		// Creates the annfinance class instance
		$ann_class = new Annfinance();

		// Templete ID for Cash Only Missed Payment
        $sys_email = DB::table('sys_string')->where('sys_id','810')->first();
        $Cash_Only_Missed_Payment_templete = $sys_email->value;
		
		// set input values		
		$account_no = Input::get('account_no');
		$customer_no = Input::get('customer_no');		
		$payment = Input::get('payment');
		$total = Input::get('miss_payment_pay_total');
		$no_miss_payment = Input::get('miss_payment_pay');
		$total_paid_payment = Input::get('total_paid_payment');
		if($total_paid_payment == '0')
		{
			$total_paid_payment = $payment;
		}
		$change_next_payment_due_date = Input::get('change_next_payment_due_date');
		$today_date = Input::get('today_date');		
		$hid_keep_payment_date = Input::get('hid_keep_payment_date');		
		$miss_next_payment_due_date = Input::get('change_next_payment_due_date');
		$keep_next_payment_date = date('Y-m-d',strtotime($miss_next_payment_due_date));
		// customer accounts details from table
		$customerAcc = DB::table('customer_accounts')->where('account_no',$account_no)->first();
		$user_id = $customerAcc->user_id;
		$week_no = $customerAcc->week_no;
		
		// get user details
		$user_details = DB::table('customer_details')->where('user_id',$user_id)->first();
		$user_email = $user_details->secondary_email;
        $firstname = $user_details->forename;
        $surname = $user_details->surname;

		// Set for miss payment option
		$submitOption = Input::get('miss_payment');
		if(isset($submitOption))
		{
			//Set correct week no
			$week_no = $week_no + 1;
			
            // Send Email To customer about the Cash Only Missed payment using Sendgrid START---
            $Data  = array('<Account Number>' => array($account_no),'$firstname' => array($firstname), '$surname' => array($surname));
            $CustomerName = $firstname.' '.$surname;
            $sendgrid->sendgrid_mail($Cash_Only_Missed_Payment_templete,$Data,$user_email,$CustomerName);
            // END
			$arrears = $ann_class->failed_transaction($customer_no, $account_no, $total_paid_payment);
			
			$failed_trans = explode('/', $arrears);
			$arrears = $failed_trans[0];
			$newNextPaymentDate = $failed_trans[1];			
			
					// set the transaction Log
					$lastInsertId = DB::table('payment_tran_log')->insertGetId([
						'customer_no' => $customer_no,
						'user_id' => $user_id,
						'account_no' => $account_no,
						'week_no' => $week_no,
						'pay_success' => '0',
						'pay_amount' => '0.00',
						'next_payment_due_date' => $newNextPaymentDate,
						'type_of_payment' => '3']);
					$trans_log_id = $lastInsertId;
					$transid = "0000000000" . $trans_log_id;
					$transid = substr($transid, -8);
					$transid = "TR" . $transid;
					$trans_log_result = DB::table('payment_tran_log')->where('tran_id', $lastInsertId)
																	->update(['tran_no' => $transid]);							
			
			return Redirect::to('Customeraccounts?search=customer_no:' . $customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		}

        $rules = array(
            '',
        );
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_accounts');
			//$ID = $this->model->insertRow($data , Input::get('account_id'));		

			// Redirect after save	
			return Redirect::to('realpayment/realauth_cashpayment.php?account_no='.$account_no.'&payment='.$payment.'&id='.$id.'&payoff_arrears='.$total.'&payoff_no_arrears='.$no_miss_payment.'&keep_next_payment_date='.$keep_next_payment_date.'&total_paid_payment='.$total_paid_payment.'&change_next_payment_due_date='.$change_next_payment_due_date.'&hid_keep_payment_date='.$hid_keep_payment_date)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Cashpayment/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
			->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postDestroy()
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));		
		// delete multipe rows 
		$this->model->destroy(Input::get('id'));
		$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
		// redirect
		Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
		return Redirect::to('Cashpayment');
	}			
		
}