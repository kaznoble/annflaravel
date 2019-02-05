<?php
class SearchcustomerController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'searchcustomer';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Searchcustomer();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'searchcustomer',
		);
			
				
	} 

	
	public function getIndex()
	{
		if(Input::get('type') == 'clearcustomer')
		{
			Session::forget('session_id');
			Session::forget('session_userid');			
			Session::forget('session_incomeexp_id');
			Session::forget('type');			
			Session::forget('round_number');
			return Redirect::to('Customerdetails')->with('message', SiteHelpers::alert('success','Customer number has been cleared.'));
		}		
		
		$custNo = Input::get('search_cust_no');
		$custData = DB::table('customer_details')->where('customer_no', Input::get('search_cust_no'))->first();
		
		
		$getCustOutExpID = DB::table('customer_outgoing')->where('customer_no', '=', $custNo)->first();
		if(!empty($getCustOutExpID)){		
			$getOutIDvalue = SiteHelpers::encryptID($getCustOutExpID->cust_outg_id); 
		}

		$getCustIncomeExpID = DB::table('customer_income')->where('customer_no', '=', $custNo)->first();
		if(!empty($getCustIncomeExpID)){		
			$getIDvalue = SiteHelpers::encryptID($getCustIncomeExpID->cust_income_id); 
		}		
		
		if( !empty($custData) )
		{
			
			$custUserID = $custData->user_id;			
			Session::put('session_id', $custNo);
			Session::put('session_userid', $custUserID);			
			Session::put('session_incomeexp_id', $getOutIDvalue);
			Session::forget('round_number');
			Session::forget('round_customer_no');			
			return Redirect::to('Customerdetails?search=customer_no:' . $custNo)->with('message', SiteHelpers::alert('success','Found!'));			
		}
		else
		{
			
			$custUserID = 0;	
			return Redirect::to('Customerdetails')->with('message', SiteHelpers::alert('success','Sorry customer no. not found or invalid format'));			
		}
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
			$this->data['row'] = $this->model->getColumnTable('customer_details'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','searchcustomer.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','searchcustomer.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_details');
			$ID = $this->model->insertRow($data , Input::get('id'));
			// Input logs
			if( Input::get('id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('searchcustomer')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('searchcustomer/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('searchcustomer');
	}			
		
}
