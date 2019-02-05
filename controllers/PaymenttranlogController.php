<?php
class PaymenttranlogController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Paymenttranlog';
	static $per_page	= '25';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Paymenttranlog();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Paymenttranlog',
		);
			
				
	} 

	public function getIndex()
	{
		// Session::forget('session_id');
		// Session::forget('sCustDetailsID');		
		
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'tran_id'); 
		$order = (!is_null(Input::get('order')) ? Input::get('order') : 'desc');
		// End Filter sort and order for query 
		// Filter Search for query		
		//echo Input::get('search');
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		

		//print_r($filter);
		// End Filter Search for query 
		
		// Take param master detail if any
		$master  = $this->buildMasterDetail(); 
 

		// append to current $filter
		$get_search = Input::get('search');
		if($get_search ==NULL):
			$get_search='payment_date:'.date('Y-m-d')." - ".date('Y-m-d',strtotime("+1 DAY"));
		endif;
		$arr['forename']['alias']='customer_details';
		$arr['surname']['alias']='customer_details';
		$arr['payment_date']['alias']='payment_tran_log';
		$arr['date_type']['alias']='payment_tran_log';
		$date_type = false;
		$startDate= '';
		$endDate= '';
		if(strpos($get_search, 'forename') !==false || strpos($get_search, 'surname') !==false || strpos($get_search, 'payment_date') !==false || strpos($get_search, 'date_type') !==false){
			$type = explode("|",$get_search);
			if(count($type) >= 1)
			{
				foreach($type as $t)
				{
					$keys = explode(":",$t);
					if($keys[0] == 'payment_date'):

							$payment_date = explode(" - ", $keys[1]);
							$date_start = explode('/', trim($payment_date[0]));
							$date_end = explode('/', trim($payment_date[1]));

							$startDate = implode('-', array_reverse($date_start));
							$endDate = implode('-', array_reverse($date_end));

							if($startDate =='' || $endDate =='')
								continue;

							$filter .= " AND date(".$arr[$keys[0]]['alias'].".`date`) BETWEEN '".$startDate."'  AND  '".$endDate."'";
					elseif($keys[0] == 'start_date'):
						$startDate = $keys[1];
					elseif($keys[0] == 'end_date'):
						$endDate = $keys[1];
					elseif($keys[0] == 'date_type'):
						$date_type = $keys[1];
						switch ($keys[1]) {
							case 1:
								$startDate = date('Y-m-d', strtotime('-7 days'));
								$endDate = date('Y-m-d', strtotime('+1 days'));
								break;
							case 2:
								$startDate = date('Y-m-d', strtotime('-30 days'));
								$endDate = date('Y-m-d', strtotime('+1 days'));
								break;
							case 3:
								$startDate = date('Y-m-d', strtotime('first day of this month'));
								$endDate = date('Y-m-d', strtotime('last day of this month'));
								break;
							case 4:
								$startDate = date('Y-m-d', strtotime('first day of last month'));
								$endDate = date('Y-m-d', strtotime('last day of last month'));
								break;
							default:
								# code...
								break;
						}


					elseif(isset($arr[$keys[0]])):
							$filter .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." REGEXP '".$keys[1]."' ";
					endif;	
				}

				if($date_type){

					if($startDate !='' && $endDate !='')
					$filter .= " AND date(".$arr['date_type']['alias'].".`date`) BETWEEN '".$startDate."'  AND  '".$endDate."'";

				}
			} 
		}

		//if( empty($get_search) )
			//$filter .= ' AND payment_tran_log.tran_id IS NULL';
		//else
		$filter .=  $master['masterFilter'];	
		

		// FILLED INPUT WITH SEARCHED VALUES
		$search = Input::get('search');
		$queryFilterArr = [];
		if(strlen($search) > 0):
			$filterArr = explode("|", $search);
			if(is_array($filterArr) && count($filterArr) > 0):
				foreach ($filterArr as $key => $value):
					$inputExplode = explode(":",$value);
					$queryFilterArr[$inputExplode[0]] = $inputExplode[1];
				endforeach;
			endif;
		endif;
		//echo '<pre>';print_r($search);exit;
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
				 // $queries = DB::getQueryLog();
				 // $last_query = end($queries);
				 // dd($last_query);

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
		$this->data['queryStrings']= $queryFilterArr;

		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		$this->layout->nest('content','Paymenttranlog.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('payment_tran_log'); 
		}

		$this->data['id'] = $id;

		$this->layout->nest('content','Paymenttranlog.form',$this->data)->with('menus', $this->menus );	

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
			$this->data['row'] = $this->model->getColumnTable('payment_tran_log'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Paymenttranlog.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('payment_tran_log');
			$ID = $this->model->insertRow($data , Input::get('tran_id'));
			// Input logs
			if( Input::get('tran_id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('Paymenttranlog')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Paymenttranlog/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Paymenttranlog');
	}			
		
}
