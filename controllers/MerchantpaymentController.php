<?php
class MerchantpaymentController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Merchantpayment';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Merchantpayment();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Merchantpayment',
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
		
		// get baseurl
		$sysbaseurl = DB::table('sys_string')->where('sys_id', '604')->first();
		$base_url = $sysbaseurl->value;
		$this->data['baseurl'] = $base_url;		
		
		// Merchant details
		// Get merchant ID
		$sysConfig = DB::table('sys_string')->where('sys_id','510')->first();
		$this->data['merchantID'] = $sysConfig->value;
		
		// Get merchant secret word
		$sysConfig = DB::table('sys_string')->where('sys_id','512')->first();
		$this->data['merchantsecret'] = $sysConfig->value;		
				
		// Get sub account
		$sysConfig = DB::table('sys_string')->where('sys_id','511')->first();		
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
		
		//$this->data['amountpence'] = Input::get('amountpence');		
		$this->data['amountpence'] = 0;
		
		$this->data['customer_no'] = Input::get('customer_no');							
		
		$this->data['account_no'] = Input::get('account_no');											
		
		$customerDetails = DB::table('customer_details')->where('customer_no', Input::get('customer_no'))->first();
		$this->data['customer_firstname'] = $customerDetails->forename;
		$this->data['customer_lastname'] = $customerDetails->surname;
		// end merchant details							
		
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
		$this->layout->nest('content','Merchantpayment.index',$this->data)
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
		$this->data['id'] = $id;
		$this->layout->nest('content','Merchantpayment.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','Merchantpayment.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_accounts');
			$ID = $this->model->insertRow($data , Input::get('account_id'));
			// Input logs
			if( Input::get('account_id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('Merchantpayment')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Merchantpayment/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Merchantpayment');
	}			
		
}