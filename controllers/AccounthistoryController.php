<?php
class AccounthistoryController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Accounthistory';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Accounthistory();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Accounthistory',
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'acc_history_id'); 
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
			$filter .= ' AND account_history.customer_no IS NULL';
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
		$this->layout->nest('content','Accounthistory.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('account_history'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Accounthistory.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('account_history'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Accounthistory.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{

		$rules = array(
			
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('account_history');
			// correction data fields
			$data['payment_due'] = Input::get('payment_due');
			$data['credits'] = Input::get('credits');
			$data['debits'] = Input::get('debits');
			$data['balance'] = Input::get('balance');			
			$ID = $this->model->insertRow($data , Input::get('acc_history_id'));
			
			// Update Customer Account figures
			if( Input::get('transaction_type') == 4 )
			{
				// pull account history data
				$accHistoryData = DB::table('account_history')->where('account_no', Input::get('account_no'))->get();				
				// pull customer account data
				$custAccData = DB::table('customer_accounts')->where('account_no', Input::get('account_no'))->first();				
				// pull account history transaction type count
				$accHistoryCount = DB::table('account_history')->where('account_no', Input::get('account_no'))->where('transaction_type', 4)->count();			
			
				
				// Rebate formulua
				$rebatePercent = $this->rebateCalculate($custAccData->percentage_apr, $custAccData->loan_period);			
				// Step 1
				$rebatePercent = number_format($rebatePercent,4,'.','');
				echo $rebatePercent;
				// Step 2
				$totalPaidPeriod = $accHistoryCount;
				$totalPayments = $custAccData->payment * $totalPaidPeriod;
				$remainPeriod = $custAccData->loan_period - $totalPaidPeriod;
				$remainTotalPayments = $custAccData->payment * $remainPeriod;
				echo '<br />' . $totalPayments;
				// Step 3
				$stepThree = $this->rebateStep3($custAccData->amount_borrowed, $rebatePercent/100, $totalPaidPeriod);
				echo '<br />' . $stepThree;
				// Step 4
				$earlySettlement = $stepThree - $totalPayments;
				echo '<br />' . $earlySettlement;
				// Step 5
				$earlyRebate = $remainTotalPayments - $earlySettlement;
				echo '<br />' . $earlyRebate;
				
				// Total paid to date
				$totalpaidtodate = 0;
				foreach($accHistoryData As $accData)
				{
					$totalpaidtodate = $totalpaidtodate + $accData->credits;
				}
				
				$addPeriod = $accHistoryCount;
				$newNextPaymentDate = date('Y-m-d');
				if( $custAccData->frequency_of_payment == 'month' )
					$newNextPaymentDate = date('Y-m-d', strtotime("+" . $addPeriod . ' months', strtotime($custAccData->first_payment)));
				if( $custAccData->frequency_of_payment == 'week' )
					$newNextPaymentDate = date('Y-m-d', strtotime("+" . $addPeriod . ' weeks', strtotime($custAccData->first_payment)));					
				DB::table('customer_accounts')->where('account_no',Input::get('account_no'))->update(
													array('balance' => Input::get('balance'),
														'week_no' => Input::get('period_no'),
														'period_no' => Input::get('period_no'),
														'total_paid_to_date' => $totalpaidtodate,
														'last_payment_made' => date('Y-m-d', strtotime(Input::get('date_time'))),
														'next_payment_due_date' => $newNextPaymentDate,
														'early_payment_rebate' => $earlyRebate,
														'early_settlement_balance' => $earlySettlement
													));
			}			
			// Input logs
			if( Input::get('acc_history_id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('Accounthistory')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Accounthistory/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Accounthistory');
	}			
	
	public function rebateCalculate($apr,$loanperiod)
	{
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Europe/London');

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		/** Include PHPExcel */
		require_once 'Classes/PHPExcel.php';
		
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader = PHPExcel_IOFactory::createReaderForFile('files/rebateformulas.xlsx');
		$objReader->setLoadSheetsOnly('Worksheet');
		$objReader = $objReader->load('files/rebateformulas.xlsx');
		//exit();		
		$objReader->setActiveSheetIndex(0);
		$apr = $apr / 100;
		$objReader->getActiveSheet()->setCellValue('A1', number_format($apr,2,'.','') );
		$objReader->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		$objReader->getActiveSheet()->setCellValue('A2', "=((1+B1)^(1/".$loanperiod.")-1)" );		
		//$rebateperc = $objReader->getActiveSheet()->getCell('A2')->getCalculatedValue();		
		PHPExcel_Calculation::getInstance()->writeDebugLog = true;
	
		$objWriter = PHPExcel_IOFactory::createWriter($objReader, 'Excel2007');
		//$objReader->disconnectWorksheets();
		$objWriter->save('files/rebateformulas.xlsx');		

		$objReader->disconnectWorksheets();		
		
		$objReaderB = PHPExcel_IOFactory::createReader('Excel2007');		
		$objReaderB = $objReaderB->load('rebateformulas.xlsx');
		$objReaderB->setActiveSheetIndex(0);
		$rebateperc = $objReaderB->getActiveSheet()->getCell('A2')->getCalculatedValue();
		$rebateperc = $rebateperc * 100;		
		echo $rebateperc;
		//$objWriter->disconnectWorksheets();
		$objReaderB->disconnectWorksheets();		
				
		return $rebateperc;
	}
	
	public function rebateStep3($loanAmount, $rebateperc, $totalPaidPeriod)
	{
		/** Error reporting */
		//error_reporting(E_ALL);
		//ini_set('display_errors', TRUE);
		//ini_set('display_startup_errors', TRUE);
		//date_default_timezone_set('Europe/London');

		/** Include PHPExcel */
		//require_once 'Classes/PHPExcel.php';

		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader = $objReader->load('files/rebatestep3.xlsx');
		$objReader->setActiveSheetIndex(0);
		$objReader->getActiveSheet()->setCellValue('A1', $loanAmount );
		$objReader->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		$objReader->getActiveSheet()->setCellValue('B1', $rebateperc );		
		$objReader->getActiveSheet()->setCellValue('C1', $totalPaidPeriod );				
	
		$objWriter = PHPExcel_IOFactory::createWriter($objReader, 'Excel2007');
		$objWriter->save('files/rebatestep3.xlsx');		
		
		$objReader->disconnectWorksheets();
		
		$objReaderB = PHPExcel_IOFactory::createReader('Excel2007');		
		$objReaderB = $objReaderB->load('files/rebatestep3.xlsx');
		$objReaderB->setActiveSheetIndex(0);
		$step3 = $objReaderB->getActiveSheet()->getCell('A4')->getCalculatedValue();
		$step3 = number_format($step3,2,'.','');
		
		$objReaderB->disconnectWorksheets();
		
		echo $step3;
				
		return $step3;
	}	
		
}