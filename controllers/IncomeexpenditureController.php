<?php
class IncomeexpenditureController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'incomeexpenditure';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Incomeexpenditure();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'incomeexpenditure',
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'cust_outg_id'); 
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
		$this->layout->nest('content','incomeexpenditure.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	

	function getAdd( $id = null)
	{	
		if( !empty(Input::get('type')) )
		{
			Session::put('type', Input::get('type'));
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
		$this->data['page_type'] = Input::get('type');
		if( !empty(Session::get('type')) )
		{
			$this->data['page_type'] = Session::get('type');
		}
		
		// Get customer number
		$custOutData = DB::table('customer_outgoing')->where('cust_outg_id',$id)->first();
		if(!empty($custOutData))
		{
			//$customer = DB::table('customer_details')->where('customer_no', Session::get('session_id'))->first();
			$customer = DB::table('customer_details')->where('customer_no', $custOutData->customer_no)->first();		
			//$income = DB::table('customer_income')->where('cust_income_id', $id)->first();
			//$income = DB::table('customer_income')->where('customer_no', Session::get('session_id'))->first();	
			$income = DB::table('customer_income')->where('customer_no', $custOutData->customer_no)->first();	
		}
		else
		{
			$income = 0;
			$customer = 0;						
		}
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['row']['income'] = $income;			
			$this->data['row']['customer'] = $customer;
		} else {
			$this->data['row'] = $this->model->getColumnTable('customer_outgoing'); 
			$this->data['row']['income'] = $income;
			$this->data['row']['customer'] = $customer;			
		}
		//var_dump($this->data['row']['income']);
		
		if($id>0){
			$this->data['id'] = $id;
			$this->layout->nest('content','incomeexpenditure.form',$this->data)->with('menus', $this->menus );	
		}else{
			return Redirect::to('incomeexpenditure')->withInput()->with('success', 'Wrong or Invalid Customer Number.');
			
		}		
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
			$this->data['row'] = $this->model->getColumnTable('customer_outgoing'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','incomeexpenditure.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			'outgoing_frequency' => 'required',
			'income_frequency' => 'required',
			'ccj' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('customer_outgoing');			
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['outgoing_frequency'] = Input::get('outgoing_frequency');
			$data['outgoing_total'] = Input::get('total_expenditure');
			$data['total_difference'] = Input::get('total_difference');
			$data['customer_no'] = Input::get('customer_no');

			$ID = $this->model->insertRow($data , Input::get('cust_outg_id'));
			// Input logs
			if( Input::get('cust_outg_id') == '')
			{
				// save income
				DB::table('customer_income')->insert(
							array('customer_no'=>Input::get('customer_no'),
									'user_id'=>Input::get('user_id'),
									'income_frequency'=>Input::get('income_frequency'),
									'wage_1'=>Input::get('wage_1'),
									'wage_2'=>Input::get('sec_wage_2'),
									'child_benefit'=>Input::get('child_benefit'),
									'child_tax_credit'=>Input::get('child_tax_credit'),
									'maintenance_payments'=>Input::get('maintenance_payments'),
									'income_total'=>Input::get('income_total'),									
									'ccj'=>Input::get('ccj'),
									'ccj_details'=>Input::get('ccj_details'),
									'created_at'=>date('Y-m-d H:i:s'),
									'updated_at'=>date('Y-m-d H:i:s'))
				);
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				// update income
				DB::table('customer_income')
							->where('customer_no',Input::get('customer_no'))
							->update(
							array('customer_no'=>Input::get('customer_no'),
									'user_id'=>Input::get('user_id'),
									'income_frequency'=>Input::get('income_frequency'),									
									'wage_1'=>Input::get('wage_1'),
									'wage_2'=>Input::get('sec_wage_2'),
									'child_benefit'=>Input::get('child_benefit'),
									'child_tax_credit'=>Input::get('child_tax_credit'),
									'maintenance_payments'=>Input::get('maintenance_payments'),
									'income_total'=>Input::get('income_total'),		
									'ccj'=>Input::get('ccj'),
									'ccj_details'=>Input::get('ccj_details'),									
									'updated_at'=>date('Y-m-d H:i:s'))
				);				
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$urID = Input::get('user_id');
			$cc = DB::table('customer_creditors')->where('user_id', $urID)->first();
			$ccID = SiteHelpers::encryptID($cc->cust_cred_id);
			$type = Input::get('type');
			Session::put('session_incomeexp_id', SiteHelpers::encryptID($ID));
			if( !empty(Session::get('type')) )
			{
				$type = Session::get('type');					
			}

			if( $type == 'new' )
			{
				return Redirect::to('Customerdetails/?search=customer_no:'.Input::get('customer_no'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));				
			}
			else
			{	
				if(Input::get('flag') == 'adminround')
				{
					return Redirect::to('incomeexpenditure/add/' . $id . '?flag=adminround&round_number=' . Session::get('round_number'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));					
				}
				else
				{
					return Redirect::to('incomeexpenditure/add/' . $id)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));					
				}
			}						
		} else {
			return Redirect::to('incomeexpenditure/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('incomeexpenditure');
	}			
		
}