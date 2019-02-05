<?php
class UploadSubmissionController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'regulatoryreports';
	public $module2 = 'UploadSubmission';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Regulatoryreports();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		
        $this->model2 = new UploadSubmission();
        $this->info2 = $this->model2->makeInfo( $this->module2);
        $this->access2 = $this->model2->validAccess($this->info2['id']);			
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'customerdomestic',
		);		
		// old code
		/*$this->data = array(
			'pageTitle'	=> 	'Upload Submission',
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'UploadSubmission',
		);*/
        
	} 

	
	public function getIndex()
	{
        if($this->access2['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        
        $Report = DB::table('submission_report_names')->get();
        $this->data['ReportNames'] = $Report;
        if(!is_null(Input::get('SubmissionID')))
        {
            $sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'reg_report_id');
            $order = (!is_null(Input::get('order')) ? Input::get('order') : 'asc');

            $filter = " AND SubmissionReportID = '".Input::get('SubmissionID')."'";
            $master  = $this->buildMasterDetail();
            // append to current $filter
            $filter.=  $master['masterFilter'];

            $page = Input::get('page', 1);
            if($page < 1)
            {
                $page = 1;
            }
            $params = array(
                'page'		=> $page ,
                'limit'		=> ((!is_null(Input::get('rows')) && Input::get('rows') != '')  ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
                'sort'		=> $sort ,
                'order'		=> $order,
                'params'	=> $filter,
                'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
            );
            // Get Query
            $results = $this->model->getRows( $params );
            $pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);

            $this->data['TableFields']= array(
                'reg_report_id' => 'Submission ID',
                'tran_ref' => 'tran Ref',
                'firm_ref_number' => 'firm Ref Number',
                'reg_date' => 'Reg Date',
                'tran_date' => 'Tran Date',
                'loan_amount' => 'Loan Amount',
                'loan_type' => 'Loan Type',
                'apr' => 'Apr',
                'arrangement_fee' => 'Arrangement Fee',
                'total_amount_payable' => 'Total Amount Payable',
                'rollover' => 'Rollover',
                'order_rollover' => 'Order Rollover',
                'length_of_term' => 'length Of Term',
                'reason_for_loan' => 'Reason For Loan',
                'date_of_birth' => 'Date Of Birth',
                'postcode' => 'Postcode',
                'monthly_income' => 'Monthly Income',
                'marital_status' => 'Marital Status',
                'residential_status' => 'Residential Status',
                'employment_status' => 'Employment Status',
            );

            $this->data['rowData']		= $results['rows'];
            // Build Pagination
            $this->data['pagination']	= $pagination;
            // Build pager number and append current param GET
            $this->data['pager'] 		= $this->injectPaginate_submissionreport();
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
            $this->data['recordsperpage']	= $params['limit'];
            // Master detail link if any
            $this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
            // Render into template
        }else{
            // Take param master detail if any
            $master  = $this->buildMasterDetail();
            // Build pager number and append current param GET
            // Group users permission
            $this->data['access']		= $this->access;
            // Detail from master if any
            $this->data['details']		= $master['masterView'];
            // Master detail link if any
        }
            // Render into template
            $this->layout->nest('content','uploadsubmission.index',$this->data)
                ->with('menus', SiteHelpers::menus());
    }

    public function GenerateXML()
    {
        ob_clean(); // This function used to remove unwanted space from top of the XML document.
        $Data = Regulatoryreports::where('SubmissionReportID','=',Input::get('SubmissionID'))->get();
        $Dates= DB::table('submission_report_names')->where('ReportID','=',Input::get('SubmissionID'))->get();
        $FirmRefNumber = DB::table('sys_string')->where('sys_id','=','30')->get();
        $ReportIdentifier = 'XMLReport-'.time();  // ReportIdentifier String and file name.
        $xmlrequest = '';
        $xmlrequest.= '<PSD006-ShortTermLoans xmlns="urn:fsa-gov-uk:MER:PSD006:1"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="urn:fsa-gov-uk:MER:PSD006:1 http://www.fsa.gov.uk/MER/DRG/PSD006/v1/PSD006-Schema.xsd">
        <PSDFeedHeader>
        <Submitter>
            <SubmittingFirm>'.$FirmRefNumber[0]->value.'</SubmittingFirm>
        </Submitter>
        <ReportDetails>
            <ReportCreationDate>'.date('Y-m-d').'</ReportCreationDate>
            <ReportIdentifier>'.$ReportIdentifier.'</ReportIdentifier>
        </ReportDetails>
        </PSDFeedHeader>';
        foreach($Data as $key => $value)
        {
             $Rollover = 'N';
             $xmlrequest.= '<PSD006FeedMsg>
                            <CoreItems>
                            <FirmReferenceNumber>'.$FirmRefNumber[0]->value.'</FirmReferenceNumber>
                            <TransRef>'.$value['tran_ref'].'</TransRef>
                            <Cancellation>false</Cancellation>
                            </CoreItems>
                            <ShortTermLoans>
			                <TransactionDate>'.date('Y-m-d',strtotime($value['tran_date'])).'</TransactionDate>
			                <LoanAmount>'.round($value['loan_amount']).'</LoanAmount>
			                <LoanType>'.$value['loan_type'].'</LoanType>
			                <APR>'.number_format($value['apr'],2).'</APR>
			                <ArrangementFee>'.round($value['arrangement_fee']).'</ArrangementFee>
			                <TotalAmountPayable>'.round($value['total_amount_payable']).'</TotalAmountPayable>
			                <Rollover>'.$Rollover.'</Rollover>
			                <OrderOfRollover>'.round($value['order_rollover']).'</OrderOfRollover>
			                <LengthOfTerm>'.$value['length_of_term'].'</LengthOfTerm>
			                <ReasonForLoan>'.$value['reason_for_loan'].'</ReasonForLoan>
			                <DOBOfBorrower>'.date('Y-m-d',strtotime($value['date_of_birth'])).'</DOBOfBorrower>
			                <PostCode>'.$value['postcode'].'</PostCode>
			                <MonthlyIncomeOfBorrower>'.round($value['monthly_income']).'</MonthlyIncomeOfBorrower>
			                <MaritalStatusOfBorrower>'.$value['marital_status'].'</MaritalStatusOfBorrower>
			                <ResidentialStatusOfBorrower>'.$value['residential_status'].'</ResidentialStatusOfBorrower>
			                <EmploymentStatusOfBorrower>'.$value['employment_status'].'</EmploymentStatusOfBorrower>
			                </ShortTermLoans>
                            </PSD006FeedMsg>';
        }
             $xmlrequest.= '</PSD006-ShortTermLoans>';
        $xml = new SimpleXMLElement($xmlrequest); // Convert variable to XML object
        header('Content-type: "text/xml"; charset="utf8"');
        header('Content-disposition: attachment; filename="'.$ReportIdentifier.'.xml"');
        echo $xml->asXML(); // Download XML File
        exit;
    }

}
?>