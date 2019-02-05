<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dompdf/lib/html5lib/Parser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dompdf/lib/php-svg-lib/src/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
// reference the Dompdf namespace
use Dompdf\Dompdf;

class LettertemplateController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'lettertemplate';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Lettertemplate();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'lettertemplate',
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'temp_id'); 
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
		$this->layout->nest('content','lettertemplate.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('letter_template'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','lettertemplate.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('letter_template'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','lettertemplate.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			
		);
		
		$temp_html = htmlentities(Input::get('temp_html'));
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('letter_template');
			$data['temp_html'] = $temp_html;
			echo $data['temp_html'];
			$ID = $this->model->insertRow($data , Input::get('temp_id'));
			// Input logs
			if( Input::get('temp_id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('lettertemplate')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('lettertemplate/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('lettertemplate');
	}			

	public function getPdfpreview( $id = null)
	{
		if($this->access['is_remove'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));		
	
                $cid = Input::get('c');
                $aid = Input::get('a');
                $step = Input::get('s');
                
		// Testing customer details
		$customerDetails = DB::table('customer_details')->where('customer_no', (!empty($cid) ? $cid : 'C000000048'))->first();
		$customer_no = $customerDetails->customer_no;
		$title = $customerDetails->title;
		// Get customer title name
		$customer_title = DB::table('customer_title')->where('id', $title)->first();
		$title_name = $customer_title->title;
		
		$customerName = $customerDetails->forename . ' ' . $customerDetails->surname;
		$addressline1 = $customerDetails->address_1;
		$city = $customerDetails->address_2;
		$postcode = $customerDetails->postcode;
		
		// Header/Footer dynamic
		$header = DB::table('sys_string')->where('sys_id', '40')->first();
		$headerHtml = $header->value;
		$footer = DB::table('sys_string')->where('sys_id', '41')->first();		
		$footerHtml = $footer->value;
		
		// Address box measure
		$systop = DB::table('sys_string')->where('sys_id', '42')->first();		
		$addresstop = $systop->value;
		$sysleft = DB::table('sys_string')->where('sys_id', '43')->first();		
		$addressleft = $sysleft->value;		
	
		// pdf preview
		$getTemplate = DB::table('letter_template')->where('temp_id', SiteHelpers::encryptID($id,true))->first();
		$getTemplate = str_replace("#fullname", $customerName, $getTemplate->temp_html);
		$getTemplate = str_replace("#customer_no", $customer_no, $getTemplate);		
                $getTemplate = str_replace("#account_no", $aid, $getTemplate);		
		$getTemplate = str_replace("#address_line_1", $addressline1, $getTemplate);
		$getTemplate = str_replace("#city", $city, $getTemplate);		
		$getTemplate = str_replace("#post_code", $postcode, $getTemplate);				
		$temp_html = html_entity_decode($getTemplate);
                
                $this->model->update_letter_manager($cid, $aid, $step);
		
		ob_start();
		require_once $_SERVER['DOCUMENT_ROOT'] . '/emailtemplate/templatea.php';
		$html = ob_get_contents();
		ob_get_clean();
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);		

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream();	
			
		// redirect
		//Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
		return Redirect::to('lettertemplate');
	}		
}