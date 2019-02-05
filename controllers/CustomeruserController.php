<?php
class CustomeruserController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Customeruser';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Customeruser();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Customeruser',
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
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'id'); 
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
			$filter .= ' AND users.id IS NULL';
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
		$this->layout->nest('content','Customeruser.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('users'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Customeruser.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('users'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Customeruser.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			'username'=>'required',
				'email'=>'required'
		);
		
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('users');
			//var_dump($data);
			//$this->model->insertRow($data , Input::get('id'));
			
			// coded by bluebird
			if( empty($data['id']) )
			{
				$data['created_at'] = date('Y-m-d H:i:s');
	            $data['updated_at'] = date('Y-m-d H:i:s');
	            
	            // Encrypt the password
				$data['password'] = Hash::make(Input::get('password'));
	            
	            // insert for users table
	            $userID = DB::table('users')->insertGetId(
	            			$data
	            		);
	            		
	            $custDig = substr('00000000' . $userID, -9);
				$custNo = 'C' . $custDig;
	            //$custNo = substr($custNo,0,10);     			            
				
	            // insert for customer_main table
	            DB::table('customer_main')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'status' => '2', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
	            );
	            
	            // insert for customer_details table
	            DB::table('customer_details')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'title' => '1', 'marital_status' => '1', 'employment_status' => '1', 'Cus_residential_status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
	            );            
	            
	            // insert for customer_nearest_relative
	            DB::table('customer_nearest_relative')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'relationship' => '5')
	            );
	            
	            // insert for customer_outgoing
	            DB::table('customer_outgoing')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID)
	            );	            
	            
	            // insert for customer_income
	            DB::table('customer_income')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID)
	            );	            
	                      
	            // insert for customer_creditors
	            DB::table('customer_creditors')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID)
	            );
	            
	            // insert for customer_accounts
	            $accountID = DB::table('customer_accounts')->insertGetId(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'loan_period' => '1', 'loan_status' => '5')
	            );	   
	            $accDig = substr('000000000' . $accountID, -8);
				$accNo = 'AC' . $accDig;
	            DB::table('customer_accounts')->where('account_id', $accountID)->update(array('account_no' => $accNo));
	            
	            // insert for customer_quote
	            DB::table('quotes')->insert(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'loan_period' => 1)
	            );
	            
	            // insert for payment_tran_log
	            $ptl_id = DB::table('payment_tran_log')->insertGetId(
	                array('customer_no' => $custNo, 'user_id' => $userID, 'pay_success' => 1, 'account_no' => $accNo)
	            );
	            $ptlDig = substr('00000000' . $ptl_id, -7);
				$ptlDig = 'TRN' . $ptlDig;
	            DB::table('payment_tran_log')->where('tran_id',$ptl_id)->update(array('tran_no' => $ptlDig));
	              
	            
			}
			else
			{
				$data['password'] = Hash::make(Input::get('password'));
				
				$this->model->insertRow($data , Input::get('id'));
				//DB::table('users')->where('id', $id)->update($data);
			}
            // end bluebird									

			return Redirect::to('Customeruser')->with('message', SiteHelpers::alert('success','Data Has Been Save Successfull'));
		} else {
			return Redirect::to('Customeruser/add/'.$id)->with('message', SiteHelpers::alert('error','The following errors occurred'))
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
		return Redirect::to('Customeruser');
	}			
		
}