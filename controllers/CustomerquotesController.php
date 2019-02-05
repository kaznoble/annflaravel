<?php
class CustomerquotesController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Customerquotes';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Customerquotes();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Customerquotes',
		);
			
				
	} 

	
	public function getIndex()
	{
		Session::forget('session_id');
		Session::forget('sCustDetailsID');
		
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'quote_no'); 
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
			$filter .= ' AND quotes.quote_no IS NULL';
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
		$this->layout->nest('content','Customerquotes.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('quotes'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Customerquotes.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('quotes'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Customerquotes.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		require_once './Classes/models/annfinance.class.php'; 
		$c_ann = new Annfinance();
		
		$rules = array(
			'customer_no' => 'required',
			'amount_borrowed' => 'required',
			'monthly_payment' => 'required',
			'interest_payable' => 'required',
			'total_payable' => 'required',
			'loan_period' => 'required',
			'percentage_apr' => 'required',
			'home_visit' => 'required',
			't_and_c' => 'required',
			'existing_customer' => 'required',
			'email' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('quotes');
			$data['frequency_of_payment'] = input::get('frequency_of_payment');
			$ID = $this->model->insertRow($data , Input::get('quote_no'));
			
	        $quoteDig = substr('00000000' . $ID, -8);
			$quoteNo = 'QU' . $quoteDig;
			DB::table('quotes')->where('quote_no',$ID)->update(array('quotenumber' => $quoteNo));
			
			// get customer details
			$customer_details = DB::table('customer_details')->where('customer_no', '=', $data['customer_no'])->first();
			$firstname = $customer_details->forename;
			$surname = $customer_details->surname;
			$address1 = $customer_details->address_1;
			$town = $customer_details->address_4;
			$postcode = $customer_details->postcode;
			
			$loan_period = DB::table('loan_period')->where('id', '=', $data['loan_period'])->first();
			$loan_period_status = $loan_period->number_of_weeks;		
			
			// sent email the quote		
			if( $data['frequency_of_payment'] == '1' )
				$frequency = 'Weekly';
			if( $data['frequency_of_payment'] == '2' )
				$frequency = 'Monthly';
							
			// Always set content-type when sending HTML email
			// get enquire email
			$sys_config_B = DB::table('sys_string')->where('sys_id', '=', '21')->first();
			$enquiry_email = $sys_config_B->value;
			// get noreply email
			$sys_config_C = DB::table('sys_string')->where('sys_id', '=', '20')->first();
			$noreply_email = $sys_config_C->value;

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers
			$headers .= 'From: ' . $noreply_email . "\r\n";
			$headers .= 'Cc: ' . $enquiry_email . ', kaz@spikydesign.com, darren.muizelaar@annfinance.co.uk' . "\r\n";
			$subject = "ANN Finance Ltd - Quote " . $quoteNo;
			$message = "Dear Customer<br /><br />" . 
				"Your quote details are shown below along with the credit agreement associated with this loan.<br /><br />" .
				$firstname . ' ' . $surname . "<br/>" .
				$address1 . "<br />" .
				$town . "<br />" .
				$postcode . "<br /><br />" .
				"Quote Number: " . $quoteNo . "<br />" .
				"Customer Number: " . $data['customer_no'] . "<br />" .
				"Amount Borrowed: &pound;" . $data['amount_borrowed'] . "<br />" .
				"Frequency: " . $frequency . "<br />" .
				"Monthly Payment: &pound;" . $data['monthly_payment'] . "<br />" .
				"Interest Payable: &pound;" . $data['interest_payable'] . "<br />" .
				"Total Payable: &pound;" . $data['total_payable'] . "<br />" .
				"Loan Period: " . $loan_period_status . "<br />" .				
				"Date of Quote: " . $data['loan_start_date'] . "<br />" .
				"Percentage Apr: " . $data['percentage_apr'] . "<br />" .
				"Home visit: " . ($data['home_visit'] == '0' ? 'No' : 'Yes') . "<br />" .
				"T and C: " . ($data['t_and_c'] == '0' ? 'No' : 'Yes') . "<br />" .
				"Existing Customer: " . ($data['existing_customer'] == '0' ? 'No' : 'Yes') . "<br />" .
				"Email: " . $data['email'] . "<br /><br />" .																		
				"Please do not hesitate to contact us if you have any queries or problems with the above account.<br /><br />" .
				"By Telephone: 0191 4167827<br /><br />" .
				"By E-mail: enquiries@annfinance.co.uk<br /><br />" .
				"In Writing: 13, Belsay<br />" .
				"Oxclose<br />" .
				"Washington<br />" .
				"Tyne & Wear<br />" .
				"NE38 0NE<br /><br />" .
				"Sincerely<br /><br />" .
				"ANN Finance Ltd Service Team<br /><br />" .
				"Terms and conditions of the agreement – Important Please read them carefully.<br /><br />" .
				"Entering this agreement:<br />" .
				"•	If you change your name, address or telephone number, tell us within 14 days.<br />" .
				"•	Make sure that the payment is sent or delivered, if we have agreed to collect and the representative does not call.<br />" .
				"As a Result:<br />" .
				"•	All notices and statements given to you in person or left at, or sent to your address or your present or last known address shall be considered validly given. If sent by prepaid first class post they shall be considered received by you within 2 working days after posting.<br />" .
				"•	If two or more people are named as the customer, the liability or each shall be joint and several. This means that each person can be fully responsible for all responsibilities set out in this agreement.<br />" .
				"•	Signature to this agreement acknowledges.<br />" .
				"a.	That you received prior to signing this agreement the pre-contract information.<br />" .
				"b.	Receipt of a true copy of the agreement.<br />" .
				"c.	That the money received is for the personal use of the customer.<br />" .
				"You May:<br />" .
				"•	Be entitled to a rebate in accordance with regulation 95 or the act if you repay early in part or full<br />" .
				"•	If you wish, tell us that any or all of your payments under this agreement are to be collected by us or someone acting on our behalf from your home or the home of a person making payment on your behalf.<br />" .
				"You have a right:<br />" .
				"•	To a statement of the account showing details of each instalment owing under the agreement, the date on which instalment is due, the amount and any conditions relating to the repayment of the instalment showing how much comprises<br />" .
				"1.	Capital repayment<br />" .
				"2.	Interest payment<br />" .
				"3.	Any other charges if applicable<br />" .
				"You Agree:<br />" .
				"•	To pay the lender the instalments set out.<br />" .
				"•	If you’re ‘Type of credit’ is described as ‘home collected’ to representative calling on you in your home to collect repayments.<br />" .
				"•	That lender making a credit reference and fraud prevention agency search may be recorded by the agency concerned and shared with other lenders.<br />" .
				"•	That we will provide positive, delinquent and default data to credit reference agencies on a regular bases (minimum monthly)<br />" .
				"•	If you default or are suspected of fraud, that other lenders may use this information about you and others with whom you are financially linked for credit assessment, debt tracing, fraud and money laundering prevention.<br />" .
				"Your Data:<br />" .
				"•	For other purposes for which you are given your specific permission.<br />" .
				"•	In very limited circumstances, when required by law or where permitted by the Data Protection Act 1998<br />" .
				"•	To manage your account<br />" .
				"•	To make collections<br />" .
				"•	For statistical purposes, surveys and research<br />" .
				"•	If we transfer, charge or assign this agreement to a third party or if we use a third party to manage any aspect of this agreement we will pass your information to them<br />" .
				"•	By our appointed Credit Reference Agency, whom you have a right to be told which agencies we are using, and may remain on file for 6 years after they are closed, whether settled by you or defaulted.<br />" .
				"•	By the FCA when we report your personal data to them.<br />" .
				"We May:<br />" .
				"•	Contact you by mail, e-mail, telephone or via the internet<br />" .
				"•	if we temporarily relax the terms of the agreement at any time, decide to enforce the terms strictly again<br />" .
				"•	Allow another person to take over all rights and responsibilities under the agreement. That person will then take over all rights and responsibilities under this agreement.<br />" .
				"•	Acting reasonably end the agreement, after giving any written notice required by law, IF:<br />" .
				"a.	You fail to keep any part of the agreement<br />" .
				"b.	You commit an act of bankruptcy (such as failing to pay a debt as ordered by a court)<br />" .
				"c.	You have given false information in connection with this agreement.<br /><br />" .
				"English / Scottish Law:<br />" .
				"In the event that the address specified as part of this agreement is within Scotland, the Credit Agreement shall be subject to Scottish law and the courts of Scotland shall have jurisdiction to deal with any proceedings relating to this Credit Agreement. Otherwise the Credit Agreement shall be deemed to be made in England and shall be subject to English law and the parties agree to submit to the non-exclusive jurisdiction of the English Courts.<br /><br />" .
				"Consumer Credit Association (CCA):<br />" .
				"The Consumer Credit Association, Queens House, Queens Road, Chester CH1 3BQ<br />" .
				"Telephone: 01244 312004 FAX: 01244 318035 Email: cca@ccauk.org Website: www.ccauk.org";
				

			$c_ann->ann_mail($data['email'],$subject,$message,$headers);		
			$c_ann->customer_last_seen(Input::get('customer_no'));	
			
			
			// Input logs
			if( Input::get('quote_no') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('Customerquotes?search=customer_no:' . $data['customer_no'])->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Customerquotes/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
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
		return Redirect::to('Customerquotes');
	}			
		
}