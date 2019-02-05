<?php
class CustomercreditorsController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Customercreditors';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Customercreditors();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Customercreditors',
		);
			
				
	} 

	
	public function getIndex()
	{
		//Session::forget('session_id');
		//Session::forget('sCustDetailsID');		
		
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'cust_cred_id'); 
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
			$filter .= ' AND customer_creditors.cust_cred_id IS NULL';
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
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		
		
		$customer_no = Input::get('customer_no');
		$this->data['customer_no'] = Input::get('customer_no');
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
		$this->layout->nest('content','Customercreditors.index',$this->data)
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
		$this->data['customer_no'] = Input::get('customer_no');
		$this->data['user_id'] = Input::get('u');
		$this->data['type'] = Input::get('type');
		if(empty($this->data['customer_no']))
			$this->data['customer_no'] = Session::get('session_id');	
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('customer_creditors'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Customercreditors.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('customer_creditors'); 
		}
		$this->data['id'] = $id;
		$this->data['customer_no'] = Session::get($id);
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Customercreditors.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$userID = Session::get('session_id');		

		$rules = array();
				
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_creditors');
			$data['creditor_total'] = Input::get('creditors_total');
			$data['customer_no'] = Input::get('customer_no');
			$data['user_id'] = Input::get('user_id');
			$ID = $this->model->insertRow($data , Input::get('cust_cred_id'));
			
			$user_id = Session::get('session_id');
			if( !empty($user_id) && empty($id) )
			{
				// get info@annfinance.co.uk from sys_string table
				$sysInfoData = DB::table('sys_string')->where('id','23')->first();
				$dataInfo = $sysInfoData->value;
				$sysReplyData = DB::table('sys_string')->where('id','20')->first();
				$dataReply = $sysReplyData->value;
				
				// sent email to Customer
				$user = DB::table('users')->where('id', $user_id)->first();
				$data['customer_email'] = $user->email;
				$data['confirmation_code'] = $user->confirmation_code;
				$customer = DB::table('customer_details')->where('user_id', Session::get('session_id'))->first();
				$data['forename'] = $customer->forename;
				$data['surname'] = $customer->surname;
				$data['customer_no'] = $customer->customer_no;
				$data['password'] = Session::get('password');
				$data['created_at'] = $customer->created_at;
				$data['home_telephone'] = $customer->telephone_1;
				$data['mobile_number'] = $customer->telephone_2;
				Mail::send('emails.contact', $data, function($message) use ($dataInfo, $dataReply)
				{
					$message->from($dataReply, 'ANNFinance');
				    //$message->to($dataInfo, 'Info Email')->cc('kaz@spikydesign.com')->subject('New Customer');
				    $message->to('kaz@spikydesign.com', 'Info Email')->cc('kaz@spikydesign.com')->subject('New Customer');
				});
							
				Mail::send('emails.welcomecustomer', $data, function($message) use ($user, $customer, $dataInfo)
				{
					$message->from($dataInfo, 'ANNFinance');
				    $message->to($user->email, $customer->forename . ' ' . $customer->surname)->subject('Welcome to ANNFinance!');
				});
				
				// remove user id session
				Session::forget('session_id');
			}

			// Input logs
			if( Input::get('cust_cred_id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$urID = Input::get('user_id');
			$type = Input::get('type');
			$customer_no = Input::get('customer_no');
			
			$getCustIncomeExpID = DB::table('customer_outgoing')->where('customer_no', '=', $customer_no)->first();
			$getIDvalue = SiteHelpers::encryptID($getCustIncomeExpID->cust_outg_id); 	
			Session::put('session_incomeexp_id', $getIDvalue);					
			
			if( $type == 'new' )
			{
				return Redirect::to('Customerdetails?search=customer_no:'.$customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
			}

			if( !empty($urID) && !empty($userID) )
			{
				if( !empty($id) )
				{
					return Redirect::to('Customerdetails?search=customer_no:'.$customer_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
				}
				else
				{
					return Redirect::to('Customerdetails')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
				}
			}
			else
			{
				return Redirect::to('Customercreditors')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
			}

		} else {
			return Redirect::to('Customercreditors/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Customercreditors');
	}			
		
}