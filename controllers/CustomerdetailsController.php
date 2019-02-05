<?php
class CustomerdetailsController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Customerdetails';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Customerdetails();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Customerdetails',
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
		$this->layout->nest('content','Customerdetails.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	

	function getAdd( $id = null)
	{	
		$setSession = Input::get('customer');
		if( $setSession == 'new' )
		{
			Session::forget('session_id');
			Session::forget('sCustDetailsID');
			Session::forget('session_userid');			
			Session::forget('session_incomeexp_id');
			Session::forget('type');	
			Session::forget('round_number');			
		}
		else
		{
			//$id = SiteHelpers::encryptID(Session::get('sCustDetailsID'));		
			//echo Session::get('sCustDetailsID');	
		}
	
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
		
		if( Input::get('page') == 'edit' )
			$this->data['page'] = 'edit';
		else
			$this->data['page'] = '';
					
		$row = $this->model->find($id);

		$this->data['isNewCustomer'] = '';
		$isNewCustomer = Input::get('customer');
		if( $isNewCustomer == 'new' )
			$this->data['isNewCustomer'] = 'new';
		
		if( !empty($id) )
		{
			$userData = DB::table('users')->where('id',$row['user_id'])->first();
			$row['username'] = $userData->username;
			$row['email'] = $userData->email;
			$row['password'] = $userData->password;
		}
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('customer_details'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Customerdetails.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('customer_details'); 
		}
		
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Customerdetails.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		/* Session::forget('session_id');
		Session::forget('sCustDetailsID'); */
		DB::connection()->disableQueryLog();
		
		if( Input::get('employment_status') == 1 || Input::get('employment_status') == 2 || Input::get('employment_status') == 3 || Input::get('employment_status') == 5 )
		{
			$rules = array(
					'title' => 'required',
					'forename' => 'required',
					'surname' => 'required',
					'date_of_birth' => 'required',
					'marital_status' => 'required',
					'ni_number' => 'required',
					'cus_residential_status' => 'required',
					'employment_status' => 'required',
					'address_1' => 'required',
					'address_2' => 'required',
					'address_4' => 'required',
					'postcode' => 'required',
					'time_address' => 'required',
					'telephone_1' => 'required',
					'telephone_2' => 'required',
					'cus_residential_status' => 'required',
					'employment_status' => 'required',
					'employer_name' => 'required',
					'employer_telephone' => 'required',
					'work_address_1' => 'required',
					'work_address_2' => 'required',
					'work_address_4' => 'required',
					'work_postcode' => 'required',				
					'username' => 'required|email',
					'secondary_email' => 'required|email',						
								
			);
		}
		else
		{
			$rules = array(
					'title' => 'required',
					'forename' => 'required',
					'surname' => 'required',
					'date_of_birth' => 'required',
					'marital_status' => 'required',
					'ni_number' => 'required',
					'cus_residential_status' => 'required',
					'employment_status' => 'required',
					'address_1' => 'required',
					'address_2' => 'required',
					'address_4' => 'required',
					'postcode' => 'required',
					'time_address' => 'required',
					'telephone_1' => 'required',
					'telephone_2' => 'required',
					'cus_residential_status' => 'required',
					'employment_status' => 'required',
					'username' => 'required|email',
					'secondary_email' => 'required|email',							
															
			);			
		}
		if( Input::get('id') == '' )
		{
			if( Input::get('employment_status') == 1 || Input::get('employment_status') == 2 || Input::get('employment_status') == 3 || Input::get('employment_status') == 5 )
			{			
				$rules = array(
						'title' => 'required',
						'forename' => 'required',
						'surname' => 'required',
						'date_of_birth' => 'required',
						'marital_status' => 'required',
						'ni_number' => 'required',
						'cus_residential_status' => 'required',
						'employment_status' => 'required',
						'address_1' => 'required',
						'address_2' => 'required',
						'address_4' => 'required',
						'postcode' => 'required',
						'time_address' => 'required',
						'telephone_1' => 'required',
						'telephone_2' => 'required',
						'cus_residential_status' => 'required',
						'employment_status' => 'required',
						'employer_name' => 'required',
						'employer_telephone' => 'required',
						'work_address_1' => 'required',
						'work_address_2' => 'required',
						'work_address_4' => 'required',
						'work_postcode' => 'required',
						'username' => 'required|email|usernamecheck',
						'secondary_email' => 'required|email',								
                        	
				);			
			}
			else
			{
				$rules = array(
						'title' => 'required',
						'forename' => 'required',
						'surname' => 'required',
						'date_of_birth' => 'required',
						'marital_status' => 'required',
						'ni_number' => 'required',
						'cus_residential_status' => 'required',
						'employment_status' => 'required',
						'address_1' => 'required',
						'address_2' => 'required',
						'address_4' => 'required',
						'postcode' => 'required',
						'time_address' => 'required',
						'telephone_1' => 'required',
						'telephone_2' => 'required',
						'cus_residential_status' => 'required',
						'employment_status' => 'required',
						'username' => 'required|email|usernamecheck',
						'secondary_email' => 'required|email',						
												
				);							
			}
		}
		
		$messages = array(
			'usernamecheck' => 'I am afraid username (email) already in use!',
		);		
	    Validator::extend('usernamecheck', function($attribute, $value, $parameters)
	    {
			$userData = DB::table('users')->where('email',Input::get('username'))->first();
			if( !empty($userData) )
			{	
			    return false;
			}
			else
			{
			    return true;
			}
		});				
		
		
		$page = Input::get('page');
		$getID = Input::get('id');
		
		$validator = Validator::make(Input::all(), $rules, $messages);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_details');
			$data['employment_phone'] = Input::get('employer_telephone');
			$data['customer_id_check'] = Input::get('cust_check_id');
			$data['time_address'] = Input::get('time_address');
			$data['previous_time_address'] = Input::get('previous_time_address');
			$data['secondary_email'] = Input::get('secondary_email');
			$data['customer_recommended'] = Input::get('customer_recommended');
			$data['cust_staff_number'] = Input::get('cust_staff_number');
			$data['bank_account_no'] = Input::get('bank_account_no');
			$sessionID = Session::get('session_id');
			//$sessionUserID = Session::get('session_userid');
			$sessionUserID = Session::get('session_userid');
			if( !empty($sessionUserID) )
				$sessionID = $sessionUserID;
			if( empty($sessionID) )
			{
				if( !empty($getID) )
				{
					$userData = DB::table('customer_details')->where('id', Input::get('id'))->first();
					$sessionID = $userData->user_id;	
				}
			}
			
			$sCustDetailsID = Session::get('sCustDetailsID');			
			//echo 'Session ID:' . $sessionID;
			//exit();
			
			$customer_name = Input::get('forename') . ' ' . Input::get('surname');
			$createdDate = date("Y-m-d H:i:s");
			$username = Input::get('username');
			//$email = Input::get('email');
			//$tempPassword = Input::get('password');
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    		$generatePassword = substr(str_shuffle($chars),0,8);		
    		$confirmation_code = substr(str_shuffle($chars),0,15);
						
			Session::put('password',$generatePassword);
			$generatePasswordEncrypted = Hash::make($generatePassword);
			
			$isNewCustomer = Input::get('customer');
			if( $isNewCustomer == 'new' )
				$sessionID = '';
			
			if( Input::get('id') == '' )
				$password = $generatePasswordEncrypted;
			if( Input::get('id') == '' && empty($sessionID) )
			{
				//echo 'New Customer';
				//exit();
				//Insert the users table
				$urID = DB::table('users')->insertGetId(array('username' => $username, 'email' => $username, 'password' => $password, 'confirmation_code' => $confirmation_code, 'created_at' => $createdDate, 'updated_at' => $createdDate));
				Session::put('session_id',$urID);
				
	            $custDig = substr('00000000' . $urID, -9);
				$custNo = 'C' . $custDig;
	            //$custNo = substr($custNo,0,10);     			            
				
	            // insert for customer_main table
	            DB::table('customer_main')->insert(
	                array('customer_no' => $custNo, 'name' => $customer_name, 'user_id' => $urID, 'status' => '1', 'seen' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
	            );
	                      
	            // insert for customer_domestic_partnership
	            $domID = DB::table('customer_domestic_partnership')->insertGetId(
	                array('customer_no' => $custNo, 'user_id' => $urID)
	            );
	            $domID = SiteHelpers::encryptID($domID);	                      
	                      
	            // insert for customer_nearest_relative
	            DB::table('customer_nearest_relative')->insertGetId(
	                array('customer_no' => $custNo, 'user_id' => $urID, 'relationship' => '5')
	            );
	            
	            // insert for customer_outgoing
	            DB::table('customer_outgoing')->insert(
	                array('customer_no' => $custNo, 'user_id' => $urID)
	            );	            
	            
	            // insert for customer_income
	            DB::table('customer_income')->insert(
	                array('customer_no' => $custNo, 'user_id' => $urID)
	            );	            
	                      
	            // insert for customer_creditors
	            DB::table('customer_creditors')->insert(
	                array('customer_no' => $custNo, 'user_id' => $urID)
	            );
	            
	            // insert for customer_quote
	            DB::table('quotes')->insert(
	                array('customer_no' => $custNo, 'user_id' => $urID, 'loan_period' => 1)
	            );
			}
			else
			{
				// Update the users table
				if( !empty($email) )
				{
					DB::table('users')->where('id', Input::get('id'))->update(array('username' => $username, 'email' => $username, 'updated_at' => $createdDate));
					
				}
				
				//echo $sessionID;
				$domdata = DB::table('customer_domestic_partnership')->where('user_id', $sessionID)->first();
				if( empty($domdata) )
					$domdata = DB::table('customer_domestic_partnership')->where('customer_no', $sessionID)->first();
				//var_dump($domdata);
				//exit();
				if( !empty($domdata) )
					$domID = SiteHelpers::encryptID($domdata->id);
				else
					$domID = 0;
				$urID = $sessionID;
				$data['updated_at'] = $createdDate;
			}
			
			//exit();
			
			if( Input::get('id') == '' && empty($sessionID) )
			{
				$data['user_id'] = $urID;
				$data['customer_no'] = $custNo;		
				Session::put('session_id', $custNo);
				//echo $urID . ' / ' . $custNo;
				//exit();
			}		

			if( !empty($data['date_of_birth']) )
				$data['date_of_birth'] = date('Y-m-d', strtotime(str_replace('/','-',$data['date_of_birth'])));
			//$time_address = Input::get('time_address');
			//if( !empty($time_address) )
			//	$data['time_address'] = date('Y-m-d', strtotime(str_replace('/','-',$time_address)));
			//$prev_time_address = Input::get('previous_time_address');
			//if( !empty($prev_time_address) )
			//	$data['previous_time_address'] = date('Y-m-d', strtotime(str_replace('/','-',$prev_time_address)));
						
			if( !empty(Input::get('id')) )
				$vID = Input::get('id');
			else
				$vID = $sCustDetailsID;
						
			/* 
			old code before session error
			if( !empty($sCustDetailsID) )
				$vID = $sCustDetailsID;
			else
				$vID = Input::get('id'); 
			Eof Old session issue code
			*/
				/* print_r($data);
				print_r($vID);
				
				exit; */
			$ID = $this->model->insertRow($data , $vID);
			
			DB::table('customer_main')->where('user_id',$sessionID)->update(['seen' => date('Y-m-d H:i:s')]);
			Session::put('sCustDetailsID', $ID);
			// Input logs
			if( Input::get('id') =='' && empty($sessionID) )
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			
			// if its for admin round redirect
			if( !empty(Session::get('round_number')) )
			{
				return Redirect::to('Customerdetails?search=customer_no:' . Session::get('round_customer_no') . '&flag=adminround&round_number=' . Session::get('round_number'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
			}			
			
			// Redirect after save	
			if( Input::get('id') == '')
			{
				return Redirect::to('customerdomestic/add/' . $domID . '?u=' . $urID)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
				//return Redirect::to('Customerrelative/add/' . $domID . '?u=' . $urID)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
			}
			elseif( Input::get('page') == 'edit' )
			{
				return Redirect::to('Customerdetails?search=customer_no:' . Session::get('session_id'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
			}			
			elseif( !empty($vID) )
			{
				return Redirect::to('customerdomestic/add/' . $domID . '?u=' . $urID)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
				//return Redirect::to('Customerrelative/add/' . $domID . '?u=' . $urID)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));								
			}			
			else
			{
				return Redirect::to('Customerdetails')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
			}
		} else {
			return Redirect::to('Customerdetails/add/'.$id.'?page='.$page)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Customerdetails');
	}			
		
}