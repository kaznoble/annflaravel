<?php
class AdminroundController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'adminroundedit';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Round();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
		);
			
				
	}

	public function getIndex()
	{
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));

        $page = 'round.index';
        $RoundData = Round::get();
        foreach ($RoundData as $round)
        {
            $days = array();
            $Data = DB::table('user_profile')->where('staff_ID','=',$round->staff_number)->get();
            foreach($Data as $v)
            {
                if($v->monday == 1)
                {
                    $days[] = 'Monday';
                }
                if($v->tuesday == 1)
                {
                    $days[] = 'Tuesday';
                }
                if($v->wednesday == 1)
                {
                    $days[] = 'Wednesday';
                }
                if($v->thursday == 1)
                {
                    $days[] = 'Thursday';
                }
                if($v->friday == 1)
                {
                    $days[] = 'Friday';
                }
                if($v->saturday == 1)
                {
                    $days[] = 'Saturday';
                }
                if($v->sunday == 1)
                {
                    $days[] = 'Sunday';
                }
            }
            $D = implode(', ',$days);
            $round->days_of_week = $D;
        }
		
		$this->data['gid'] = Auth::user()->id;
        $this->data['Round'] = $RoundData;
        $this->layout->nest('content',$page,$this->data);
	}

    public function add()
    {
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));

        $allocatedStaff = Round::lists('staff_number');
        if(empty($allocatedStaff))
        {
            $allocatedStaff = array('');
        }
        $Data = User::whereNotIn('staff_id', $allocatedStaff)->where('staff_id','!=','')->get();
        $this->data['staff'] = $Data;
        $page = 'round.form';
        $this->layout->nest('content',$page,$this->data);
    }

    public function GetWorkingDays()
    {
        $Data = DB::table('user_profile')->where('staff_ID','=',Input::get('staff_number'))->get();
        foreach($Data as $v)
        {
            if($v->monday == 1)
            {
                $days[] = 'Monday';
            }
            if($v->tuesday == 1)
            {
                $days[] = 'Tuesday';
            }
            if($v->wednesday == 1)
            {
                $days[] = 'Wednesday';
            }
            if($v->thursday == 1)
            {
                $days[] = 'Thursday';
            }
            if($v->friday == 1)
            {
                $days[] = 'Friday';
            }
            if($v->saturday == 1)
            {
                $days[] = 'Saturday';
            }
            if($v->sunday == 1)
            {
                $days[] = 'Sunday';
            }
        }
        $D = implode(', ',$days);
        return json_encode(array('html' => $D));
    }

    public function GetRoundDetails()
    {
        $Round = Round::where('round_number','=',Input::get('round_no'))->get();
        $html='';
        foreach ($Round as $r)
        {
            $html.='<tr><td>'.$r->round_number.'</td><td>'.$r->staff_name.'</td><td>'.$r->round_name.'</td><td><a class="btn btn-danger btn-sm" onclick="delete_round('.$r->round_number.')">Confirm Delete</a></td>';
        }
        return json_encode(array('html' =>$html));
    }

    public function DeleteRound()
    {
        $CustomerRound = Roundcustomerrelation::where('round_number','=',Input::get('id'))->count();
        if($CustomerRound > 0)
        {
            $Response = 0;
        }else{
            $Round = Round::destroy(Input::get('id'));
            $Response = 1;
        }
        return json_encode(array('ResponseCode' => $Response));
    }

    public function save_round()
    {
        $validator = Validator::make(Input::all(),
            array(
                'round_number' => 'required|unique:round_config,round_number',
                'round_name' => 'required|unique:round_config,round_name',
                'staff_number' => 'required|not_in:0'
            )
        );
        if ($validator->passes()) {
            $StaffData = User::where('staff_id','=',Input::get('staff_number'))->select('first_name','last_name')->get();
            $RoundData = array(
                'round_number' => Input::get('round_number'),
                'round_name' => Input::get('round_name'),
                'staff_number' => Input::get('staff_number'),
                'staff_name' => $StaffData[0]->first_name.' '.$StaffData[0]->last_name,
                'days_of_week' => '',
            );
            $this->SaveData('round_config',$RoundData);

            $user_profile = array(
                'round_number' => Input::get('round_number')
            );
            $this->UpdateData('user_profile','staff_ID', Input::get('staff_number'), $user_profile);
            return Redirect::to('add_delete_round/add')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        }else{
            return Redirect::to('add_delete_round/add')->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
                ->withErrors($validator)->withInput();
        }
    }

    public function ViewEditRound()
    {
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));

        $page = 'round.view';
		if( Session::get('gid') == 1 || Session::get('gid') == 2 )
		{
			$RoundData = Round::get();
		}
		else
		{
			$RoundData = DB::table('round_config')->where('staff_only','=','0')->get();
		}				
		
		Session::forget('session_id');		
        $this->data['Round'] = $RoundData;
        $this->data['days'] = DB::table('days')->get();
        $this->layout->nest('content',$page,$this->data);
    }

    public function GetDetailsRoundWise($id)
    {
		// Start - if any updated for customer report
		$formtype = Input::get('type');
		if($formtype == 'auth_payments')
		{
			$customer_no = Input::get('customer_no');
			$amount_paid = Input::get('amount_paid');
			$short_note = Input::get('short_note');
			$preferred_time = Input::get('preferred_time');
			
			// Updated preferred time
			DB::table('customer_main')->where('customer_no','=',$customer_no)->update(array('preferred_time_to_call' => $preferred_time));
			
			// Updated customer report
			$res = DB::table('customer_report')->where('customer_no','=',$customer_no)->get();
			if(!empty($res))
			{
				DB::table('customer_report')->where('customer_no', $customer_no)->update(array('amountPaid' => $amount_paid, 'shortNote' => $short_note));
			}
			else
			{
				DB::table('customer_report')->insert(array('customer_no' => $customer_no, 'amountPaid' => $amount_paid, 'shortNote' => $short_note));	
			}
		}		
		// End - if any updated for customer report
		
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));

        $page = 'round.view';
		if( Session::get('gid') == 1 || Session::get('gid') == 2 )
		{
			$RoundData = Round::get();
		}
		else
		{
			$RoundData = DB::table('round_config')->where('staff_only','=','0')->get();
		}			
        $this->data['Round'] = $RoundData;
        $this->data['RoundData'] = Round::where('round_number','=',$id)->get();
        $Data = Roundcustomerrelation::select('round_customer_relation.relation_id','round_customer_relation.round_number','round_customer_relation.customer_no','round_customer_relation.callback_time','round_customer_relation.callback_day','customer_details.address_1','customer_details.address_2','customer_details.address_3','customer_details.address_4','customer_details.postcode','customer_details.forename','customer_details.surname','customer_main.preferred_time_to_call','days.day_desc','amountPaid','shortNote','customer_main.preferred_frequency')
					->join('customer_details','customer_details.customer_no','=','round_customer_relation.customer_no')
					->join('customer_main','round_customer_relation.customer_no','=','customer_main.customer_no')
					->join('days','customer_main.preferred_payment_day','=','days.day_id')				
					->leftJoin('customer_report','round_customer_relation.customer_no','=','customer_report.customer_no')
					->where('round_customer_relation.round_number','=',$id. ' COLLATE utf8_unicode_ci')->groupBy('round_customer_relation.customer_no')->orderBy('customer_main.preferred_time_to_call','asc')->get();
			
        foreach ($Data as $d)
        {
            if($d->day_desc =='Monday')
            {
                $this->data['MondayCustomer'][] = $d;
				$monCust = $this->data['MondayCustomer'];
            }
            else if($d->day_desc =='Tuesday')
            {
                $this->data['TuesdayCustomer'][] = $d;
            }
            else if($d->day_desc =='Wednesday')
            {
                $this->data['WednesdayCustomer'][] = $d;
            }
            else if($d->day_desc =='Thursday')
            {
                $this->data['ThrusdayCustomer'][] = $d;
            }
            else if($d->day_desc =='Friday')
            {
                $this->data['FridayCustomer'][] = $d;
            }
            else if($d->day_desc =='Saturday')
            {
                $this->data['SaturdayCustomer'][] = $d;
            }
            else if($d->day_desc =='Sunday')
            {
                $this->data['SundayCustomer'][] = $d;
            }
            if($d->callback_day !='')
            {
                $this->data['CallBackCustomer'][] = $d;
            }
        }
		
		$days[] = '';
        $StaffNumber = DB::table('round_config')->where('round_number','=',$id)->lists('staff_number');
        $StaffDays = DB::table('user_profile')->where('staff_ID','=',$StaffNumber[0])->get();
        foreach($StaffDays as $v)
        {
            if($v->monday == 1)
            {
                $days[] = 'Monday';
            }
            if($v->tuesday == 1)
            {
                $days[] = 'Tuesday';
            }
            if($v->wednesday == 1)
            {
                $days[] = 'Wednesday';
            }
            if($v->thursday == 1)
            {
                $days[] = 'Thursday';
            }
            if($v->friday == 1)
            {
                $days[] = 'Friday';
            }
            if($v->saturday == 1)
            {
                $days[] = 'Saturday';
            }
            if($v->sunday == 1)
            {
                $days[] = 'Sunday';
            }
        }
		
		// Get auto payments details
		$this->data['frequency_order'] = Input::get('frequency_order');
		$autoPayData = DB::table('round_customer_relation')
							->join('customer_accounts', 'round_customer_relation.customer_no', '=', 'customer_accounts.customer_no')
							->join('customer_details', 'round_customer_relation.customer_no', '=', 'customer_details.customer_no')							
							->join('customer_main', 'round_customer_relation.customer_no', '=', 'customer_main.customer_no')	
							->join('customer_report', 'round_customer_relation.customer_no', '=', 'customer_report.customer_no')
							->where('round_customer_relation.round_number',$id)
							->where('customer_accounts.payment_type','Auto')	
							->where('customer_accounts.frequency_of_payment','LIKE','%' . $this->data['frequency_order'] . '%')
							->orderBy('customer_main.preferred_time_to_call','asc')
							->get();
		
		function unique_multidim_array($array, $key) {
			$temp_array = array();
			$i = 0;
			$key_array = array();
		   
			foreach($array as $val) {
				if (!in_array($val[$key], $key_array)) {
					$key_array[$i] = $val[$key];
					$temp_array[$i] = $val;
				}
				$i++;
			}
			return $temp_array;
		} 
		$autoPayDataArray = $autoPayData;
		$autoPayDataArray = json_decode(json_encode($autoPayDataArray), true);
		$autoPayDataArray = unique_multidim_array($autoPayDataArray,'customer_no');
		$autoPayDataStdClass = json_decode(json_encode($autoPayDataArray));
		//var_dump($autoPayDataArray);
		//exit();
							
		// Get Daily Payment Log
		$selectDateType = Input::get('daterange');
		$this->data['selectDateType'] = $selectDateType;
		$from = date('Y-m-d');
		$to = date('Y-m-d', strtotime('+1 days'));
		if($selectDateType == 1)
		{
			$from = date('Y-m-d', strtotime('-7 days'));
			$to = date('Y-m-d', strtotime('+1 days'));			
		}
		if($selectDateType == 2)
		{
			$from = date('Y-m-d', strtotime('-30 days'));
			$to = date('Y-m-d', strtotime('+1 days'));		
		}
		if($selectDateType == 3)
		{
			$from = date('Y-m-d', strtotime('first day of this month'));
			$to = date('Y-m-d', strtotime('last day of this month'));	
		}
		if($selectDateType == 4)
		{
			$from = date('Y-m-d', strtotime('first day of last month'));
			$to = date('Y-m-d', strtotime('last day of last month'));
		}	
		if($selectDateType == 5)
		{
			$get_start_date = Input::get('start_date');
			$get_end_date = Input::get('end_date');
			$from = $get_start_date;
			$to = $get_end_date;
		}			
		
		$this->data['start_date'] = $from;
		$this->data['end_date'] =	$to;
		$this->data['search_forename'] = Input::get('search_forename');
		$this->data['search_surname'] = Input::get('search_surname');
		$this->data['search_date'] = Input::get('search_date');
		$this->data['search_customer_no'] = Input::get('search_customer_no');
		$this->data['search_account_no'] = Input::get('search_account_no');
		$this->data['search_type_of_payment'] = Input::get('search_type_of_payment');
		$this->data['search_pay_success'] = Input::get('search_pay_success');

		if( !empty($this->data['search_forename']) || !empty($this->data['search_surname']) || !empty($this->data['search_customer_no']) || !empty($this->data['search_account_no']) || !empty($this->data['search_type_of_payment']) || !empty($this->data['search_pay_success']) )
		{
			$from = '1970-01-01';
			$to = date('Y-m-d', strtotime('+1 days'));		
		}
			
		/*
		$dailyPaymentLogData = DB::table('payment_tran_log')
							->select('*')
							->join('round_customer_relation','round_customer_relation.customer_no','=','payment_tran_log.customer_no')
							->join('customer_details','customer_details.customer_no','=','payment_tran_log.customer_no')
							->whereBetween('date', [$from, $to])
							->where('round_customer_relation.round_number',$id)
							->where('customer_details.forename', 'LIKE', '%' . $this->data['search_forename'] . '%')
							->where('customer_details.surname', 'LIKE', '%' . $this->data['search_surname'] . '%')													
							->where('payment_tran_log.customer_no', 'LIKE', '%' . $this->data['search_customer_no'] . '%')								
							->where('payment_tran_log.account_no', 'LIKE', '%' . $this->data['search_account_no'] . '%')									
							->where('payment_tran_log.type_of_payment', 'LIKE', '%' . $this->data['search_type_of_payment'] . '%')		
							->where('payment_tran_log.pay_success', 'LIKE', '%' . $this->data['search_pay_success'] . '%')									
							->where('payment_tran_log.week_no', '<>', '0')								
							->orderby('date','desc')
							->limit(1000)
							->get(); */
		$dailyPaymentLogData = DB::table('payment_tran_log')
							->select('*')
							->join('round_customer_relation','round_customer_relation.customer_no','=','payment_tran_log.customer_no')
							->join('customer_details','customer_details.customer_no','=','payment_tran_log.customer_no')
							->whereBetween('date', [$from, $to])
							->where('round_customer_relation.round_number',$id)
							->where('customer_details.forename', 'LIKE', '%' . $this->data['search_forename'] . '%')
							->where('customer_details.surname', 'LIKE', '%' . $this->data['search_surname'] . '%')													
							->where('payment_tran_log.customer_no', 'LIKE', '%' . $this->data['search_customer_no'] . '%')								
							->where('payment_tran_log.account_no', 'LIKE', '%' . $this->data['search_account_no'] . '%')									
							->where('payment_tran_log.type_of_payment', 'LIKE', '%' . $this->data['search_type_of_payment'] . '%')		
							->where('payment_tran_log.pay_success', 'LIKE', '%' . $this->data['search_pay_success'] . '%')									
							->where('payment_tran_log.pay_amount', '<>', '0')								
							->orderby('date','desc')
							->groupby('payment_tran_log.tran_id')
							->limit(1000)
							->get();							
							
		// Delete week end record
		$delete_table = 'staff_weekly_totals';
		$week_id = Input::get('week_id');
		$data_delete = Input::get('data_delete');
		if($data_delete == 'delete_daily')
			$delete_table = 'staff_daily_totals';
		if(!empty($week_id))
		{
			DB::table($delete_table)
										->where('weeklyTotal_id','=',$week_id)
										->limit(1)										
										->delete();
			return Redirect::to('/ViewEdit/' . $id . '?type=search_history')->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')));
		}			
							
		// Get week end details
		$startEndWeek = Input::get('weekend_start_date');
		$endEndWeek = Input::get('weekend_end_date');
		$this->data['startEndWeek'] = $startEndWeek;
		$this->data['endEndWeek'] = $endEndWeek;		
		$this->data['startDailyEndWeek'] = '';
		if(Input::get('formtype') == 'daily_totals')
		{
			$startEndWeek = Input::get('weekend_start_date') . ' 00:00:00';
			$endEndWeek = Input::get('weekend_start_date') . ' 23:59:00';
			$this->data['startDailyEndWeek'] = $startEndWeek;
			$this->data['startEndWeek'] = '';			
			$this->data['endEndWeek'] = '';
		}
		$loanPeriodData = DB::table('loan_period')->get();
		foreach($loanPeriodData as $loanperiod)
		{											
			/* Totals for auto payment */
			$totalLoanInterest = 0; $totalLoanNoInterest = 0; $totalRebate = 0; $totalPaid = 0; $totalArrears = 0; $accLoanPeriod = 0;
			$accLoanPeriod = $loanperiod->number_of_weeks;
			$accLoanMonthlyPeriod = 0;		

			$getCustomerAccount = DB::table('customer_accounts')
										->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
										->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
										->where('round_customer_relation.round_number','=',$id)
										->where('customer_accounts.loan_period','=',$accLoanPeriod)
										->where('customer_accounts.payment_type','=','Auto')
										->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
										->get();
										
			foreach($getCustomerAccount As $getCustAcc)						
			{											
				$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
				$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
				$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
			}
			
			if($accLoanPeriod == '20')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','4')
											->where('customer_accounts.payment_type','=','Auto')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}
			
			if($accLoanPeriod == '30')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','5')
											->where('customer_accounts.payment_type','=','Auto')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}

			if($accLoanPeriod == '52')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','12')
											->where('customer_accounts.payment_type','=','Auto')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}			
				
			// get success total paid from payment trans log
			$getSuccessPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
										->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','1')
										->where('payment_tran_log.week_no','>','0')
										->where('round_number','=',$id)
										->where('customer_accounts.payment_type','=','Auto')
										->get();
											
			// get fail total paid from payment trans log
			$getFailPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
										->whereBetween('date',[$startEndWeek,$endEndWeek])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','0')
										->where('customer_accounts.week_no','>','0')											
										->where('customer_accounts.round_number','=',$id)
										->where('customer_accounts.payment_type','=','Auto')
										->get();		
			
			// get success pay tran log
			foreach($getSuccessPaymentTrans As $getSucPayTrans)
			{
				$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
			}
				
			// get fail pay tran log
			foreach($getFailPaymentTrans As $getFailPayTrans)
			{
				//echo $getFailPayTrans->account_no;
				$totalArrears = $totalArrears + $getFailPayTrans->payment;				
			}			
			
			// 4 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 20)
			{
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','4')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','4')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}
			}
			// End - 4 months
			
			// 5 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 30)
			{			
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','5')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','5')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}		
			}
			// End - 5 months			
			
			// 12 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 52)
			{			
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','12')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','12')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Auto')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}		
			}
			// End - 12 months						
				
			$weekendData[$loanperiod->number_of_weeks]['withinterest'] = $totalLoanInterest;			
			$weekendData[$loanperiod->number_of_weeks]['withnointerest'] = $totalLoanNoInterest;	
			$weekendData[$loanperiod->number_of_weeks]['totalrebate'] = $totalRebate;	
			$weekendData[$loanperiod->number_of_weeks]['totalpaid'] = $totalPaid;	
			$weekendData[$loanperiod->number_of_weeks]['totalarrears'] = $totalArrears;				
			/* End - Totals for auto payment */

			/* Totals for cash payment */			
			$totalLoanInterest = 0; $totalLoanNoInterest = 0; $totalRebate = 0; $totalPaid = 0; $totalArrears = 0; $accLoanPeriod = 0;
			$accLoanPeriod = $loanperiod->number_of_weeks;			
			$accLoanMonthlyPeriod = 0;		

			$getCustomerAccount = DB::table('customer_accounts')
										->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
										->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
										->where('round_customer_relation.round_number','=',$id)
										->where('customer_accounts.loan_period','=',$accLoanPeriod)
										->where('customer_accounts.payment_type','=','Cash')
										->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
										->get();							
										
			foreach($getCustomerAccount As $getCustAcc)						
			{											
				$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
				$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
				$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
			}
			
			if($accLoanPeriod == '20')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','4')
											->where('customer_accounts.payment_type','=','Cash')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}
			
			if($accLoanPeriod == '30')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','5')
											->where('customer_accounts.payment_type','=','Cash')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}

			if($accLoanPeriod == '52')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$id)
											->where('customer_accounts.loan_period','=','12')
											->where('customer_accounts.payment_type','=','Cash')
											->whereBetween('customer_accounts.loan_start_date',[$startEndWeek,$endEndWeek])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}					
			
			// get success total paid from payment trans log
			$getSuccessPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
										->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','1')
										->where('payment_tran_log.week_no','>','0')
										->where('round_number','=',$id)
										->where('customer_accounts.payment_type','=','Cash')
										->get();
											
			// get fail total paid from payment trans log
			$getFailPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
										->whereBetween('date',[$startEndWeek,$endEndWeek])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','0')
										->where('customer_accounts.week_no','>','0')											
										->where('customer_accounts.round_number','=',$id)
										->where('customer_accounts.payment_type','=','Cash')
										->get();		
			
			// get success pay tran log
			foreach($getSuccessPaymentTrans As $getSucPayTrans)
			{
				$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
			}
				
			// get fail pay tran log
			foreach($getFailPaymentTrans As $getFailPayTrans)
			{
				//echo $getFailPayTrans->account_no;
				$totalArrears = $totalArrears + $getFailPayTrans->payment;				
			}			
			
			// 4 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 20)
			{						
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','4')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','4')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}			
			}
			// End - 4 months
			
			// 5 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 30)
			{						
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','5')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','5')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}			
			}
			// End - 5 months			
			
			// 12 months
			// get success total paid from payment trans log
			if($loanperiod->number_of_weeks == 52)
			{						
				$getSuccessPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('payment_tran_log.date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','12')
											->where('payment_tran_log.pay_success','=','1')
											->where('payment_tran_log.week_no','>','0')
											->where('round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();
												
				// get fail total paid from payment trans log
				$getFailPaymentTrans = DB::table('payment_tran_log')
											->select('*')
											->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
											->whereBetween('date',[$startEndWeek,$endEndWeek])
											->where('customer_accounts.loan_period','=','12')
											->where('payment_tran_log.pay_success','=','0')
											->where('customer_accounts.week_no','>','0')											
											->where('customer_accounts.round_number','=',$id)
											->where('customer_accounts.payment_type','=','Cash')
											->get();		
				
				// get success pay tran log
				foreach($getSuccessPaymentTrans As $getSucPayTrans)
				{
					$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
				}
					
				// get fail pay tran log
				foreach($getFailPaymentTrans As $getFailPayTrans)
				{
					//echo $getFailPayTrans->account_no;
					$totalArrears = $totalArrears + $getFailPayTrans->payment;				
				}			
			}
			// End - 12 months			
				
			$weekendDataCash[$loanperiod->number_of_weeks]['withinterest'] = $totalLoanInterest;			
			$weekendDataCash[$loanperiod->number_of_weeks]['withnointerest'] = $totalLoanNoInterest;	
			$weekendDataCash[$loanperiod->number_of_weeks]['totalrebate'] = $totalRebate;	
			$weekendDataCash[$loanperiod->number_of_weeks]['totalpaid'] = $totalPaid;	
			$weekendDataCash[$loanperiod->number_of_weeks]['totalarrears'] = $totalArrears;							
			/* End - Totals for cash payment */
		}
		
		$this->data['searchHistory'] = false;
		if(Input::get('type') == 'search_history')
			$this->data['searchHistory'] = true;
		
		$this->data['searchView'] = false;
		if(Input::get('type') == 'search_view')
			$this->data['searchView'] = true;		
		
		$getWeekEndHistory = DB::table('staff_weekly_totals')
									->select('*')
									->where('round_number','=',$id)
									->orderBy('week_end_date', 'desc')
									->get();
									
		$getDailyHistory = DB::table('staff_daily_totals')
									->select('*')
									->where('round_number','=',$id)
									->orderBy('week_end_date', 'desc')									
									->get();									
		
        $this->data['selectround'] = $id;
		$this->data['staff_days'] = $days;
        $this->data['days'] = DB::table('days')->get();
        $this->data['authpaydata'] = $autoPayDataStdClass;
		$this->data['dailypaymentlogdata'] = $dailyPaymentLogData;
		$this->data['weekenddata'] = $weekendData;
		$this->data['weekenddatacash'] = $weekendDataCash;		
		$this->data['getweekendhistory'] = $getWeekEndHistory;
		$this->data['getdailyhistory'] = $getDailyHistory;		
		$this->data['daily_save'] = true;
		$this->layout->nest('content',$page,$this->data);
    }

    public function GetSearchedCustomers()
    {
        // Get all customers who are already allocated to any round.
        $allocatedcust = Roundcustomerrelation::lists('customer_no');
        if(empty($allocatedcust))
        {
            $allocatedcust = array('');
        }
        $cust_details = Customerdetails::select('customer_details.customer_no','customer_details.forename','customer_details.surname','customer_main.preferred_payment_day','customer_main.preferred_time_to_call')->join('customer_main','customer_details.customer_no','=','customer_main.customer_no');
        if(Input::get('customer_no'))
        {
            $cust_details = $cust_details->where('customer_details.customer_no', '=', Input::get('customer_no'));
        }
        if(Input::get('forename'))
        {
            $cust_details = $cust_details->where('customer_details.forename', 'like', Input::get('forename').'%');
        }
        if(Input::get('surname'))
        {
            $cust_details = $cust_details->where('customer_details.surname', 'like', Input::get('surname').'%');
        }
        $cust_details = $cust_details->get();
        $html='';
        // Check whether the data exist in array
        if(count($cust_details) > 0)
        {
            foreach($cust_details as $cust)
            {
                // Check the customer_no in already assigned to any round or not.
                if(!in_array($cust->customer_no,$allocatedcust))
                {
                    $ResponseCode = 1;
                    // Check whether payment_day and prefer_time is allocated to particular customer or not?
                    if(($cust->preferred_payment_day == 0 || $cust->preferred_payment_day == NULL) && ($cust->preferred_time_to_call == '00:00:00' || $cust->preferred_time_to_call == NULL))
                    {
                        $html.='<tr><td><input type="checkbox" id="'.$cust->customer_no.'_select_checkbox" name="search_customers" value="'.$cust->customer_no.'" disabled></td><td>'.$cust->customer_no.'</td><td>'.$cust->forename.'</td><td>'.$cust->surname.'</td><td id="'.$cust->customer_no.'_time"><center><a onclick="add_details_open_popup(\''.$cust->customer_no.'\')" class="btn btn-xs btn-success">Add Time</a></center></td>';
                    }else{
                        $html.='<tr><td><input type="checkbox" name="search_customers" value="'.$cust->customer_no.'"></td><td>'.$cust->customer_no.'</td><td>'.$cust->forename.'</td><td>'.$cust->surname.'</td><td>'.$cust->preferred_time_to_call.'</td>';
                    }

                }else{
                    $ResponseCode = 0;
                }
            }
        }else{
            $ResponseCode = 2;
        }

        return json_encode(array('html' =>$html,'ResponseCode' => $ResponseCode));
    }

    public function AddCustomersToRound()
    {
        $customers = explode(',', Input::get('customer_no'));
        // Get the staff_name of the selected round.
        $staff_name = DB::table('round_config')->where('round_number','=',Input::get('round_number'))->lists('staff_name');
        for ($i=0; $i<sizeof($customers); $i++)
        {
            $customer_round = array(
                'round_number' => Input::get('round_number'),
                'customer_no' => $customers[$i],
                'callback_time' => '00:00:00',
                'callback_day' => ''
            );
            $this->SaveData('round_customer_relation',$customer_round);
            $customer_main = array(
                'round_number' => Input::get('round_number'),
                'staff_name' => $staff_name[0]
            );
            $customer_accounts = array(
                'round_number' => Input::get('round_number')
            );
            // Update round_number, staff_name in customer_main table.
            $this->UpdateData('customer_main','customer_no', $customers[$i], $customer_main);
            // Update round_number in customer_accounts table
            $this->UpdateData('customer_accounts','customer_no', $customers[$i], $customer_accounts);
        }
        return json_encode(array('url' =>'/ViewEdit/'.Input::get('round_number')));
    }

    public function RemoveCustomersToRound()
    {
        $relation_id = explode(',', Input::get('relation_id'));
        for ($i=0; $i<sizeof($relation_id); $i++)
        {
            // Get the customer_no based on relation if from round_customer_relation table.
            $customer_no = Roundcustomerrelation::where('relation_id','=',$relation_id[$i])->lists('customer_no');
            $user_profile = array(
                'round_number' => NULL
            );
            $this->UpdateData('customer_main','customer_no', $customer_no[0], $user_profile);
            $this->UpdateData('customer_accounts','customer_no', $customer_no[0], $user_profile);
            $Round = Roundcustomerrelation::destroy($relation_id[$i]);
        }
        return json_encode(array('url' =>'/ViewEdit/'.Input::get('round_number')));
    }

    public function AssignCallbackList()
    {
        $customers = explode(',', Input::get('customer_no'));
        for ($i=0; $i<sizeof($customers); $i++)
        {
            $customer_callback = array(
                'callback_day' => Input::get('callback_day'),
                'callback_time' => Input::get('callback_time'),
            );
            $this->UpdateData('round_customer_relation','relation_id',$customers[$i], $customer_callback);
        }
        return json_encode(array('url' =>'/ViewEdit/'.Input::get('round_number')));
    }

    public function RemoveFromCallbackList()
    {
        $customers = explode(',', Input::get('customer_no'));
        for ($i=0; $i<sizeof($customers); $i++)
        {
            $customer_callback = array(
                'callback_day' => '',
                'callback_time' => '00:00:00',
            );
            $this->UpdateData('round_customer_relation','relation_id',$customers[$i], $customer_callback);
        }
        return json_encode(array('url' =>'/ViewEdit/'.Input::get('round_number')));
    }

    public function GetCustomerNumber()
    {
        $Data = Roundcustomerrelation::where('relation_id','=',Input::get('relation_id'))->lists('customer_no');
        return json_encode(array('cust_no' => $Data[0]));
    }

    public function SaveCustomerMainDetails()
    {
        $customer_main = array(
            'preferred_payment_day' => Input::get('prefer_day'),
            'preferred_time_to_call' => Input::get('prefer_time'),
        );
        $this->UpdateData('customer_main','customer_no',Input::get('customer_no'), $customer_main);
        return json_encode($customer_main);
    }
	
    public function SaveWeekEndData()
    {
		$startWeekEnd = Input::get('weekend_start_date');
		$endWeekEnd = Input::get('weekend_end_date');
		if(Input::get('formtype') == 'daily_totals')
		{
			$startWeekEnd = Input::get('weekend_start_date') . ' 00:00:00';
			$endWeekEnd = Input::get('weekend_start_date') . ' 23:59:00';
			$endDailyWeekEnd = Input::get('weekend_start_date');			
		}		
		$round_no = Input::get('round_no');
		$loanPeriodData = DB::table('loan_period')->get();
		$totalLoanInterest = 0; $totalLoanNoInterest = 0; $totalRebate = 0; $customer_count = 0; $totalBalance = 0; $totalPaidToDate = 0;$totalArrearWeek = 0; $totalPaid = 0; $totalArrears = 0;	
		
		// Get total customer for this round
		$totalCust = DB::table('round_customer_relation')
						->select('*')
						->where('round_number','=',$round_no)
						->count();
		
		foreach($loanPeriodData as $loanperiod)
		{								
			$accLoanPeriod = $loanperiod->number_of_weeks;		
			$getCustomerAccount = DB::table('customer_accounts')
										->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','balance','payment')
										->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
										->where('round_customer_relation.round_number','=',$round_no)
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->whereBetween('customer_accounts.loan_start_date',[$startWeekEnd,$endWeekEnd])
										->get();
														
			$roundConfigData = DB::table('round_config')
								->select('*')
								->where('round_number','=',$round_no)
								->first();
														
			foreach($getCustomerAccount As $getCustAcc)						
			{																		
				$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
				$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;									
				$totalBalance = $totalBalance + $getCustAcc->balance;		
			}
			
			if($accLoanPeriod == '20')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$round_no)
											->where('customer_accounts.loan_period','=','4')
											->whereBetween('customer_accounts.loan_start_date',[$startWeekEnd,$endWeekEnd])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}
			
			if($accLoanPeriod == '30')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$round_no)
											->where('customer_accounts.loan_period','=','5')
											->whereBetween('customer_accounts.loan_start_date',[$startWeekEnd,$endWeekEnd])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}

			if($accLoanPeriod == '52')
			{
				$getCustomerAccount = DB::table('customer_accounts')
											->select('customer_accounts.customer_no','customer_accounts.account_no','amount_borrowed','total_payable','early_settlement_balance','interest_payable','total_paid_to_date','arrears','payment')
											->join('round_customer_relation','round_customer_relation.customer_no','=','customer_accounts.customer_no')
											->where('round_customer_relation.round_number','=',$round_no)
											->where('customer_accounts.loan_period','=','12')
											->whereBetween('customer_accounts.loan_start_date',[$startWeekEnd,$endWeekEnd])
											->get();
											
				foreach($getCustomerAccount As $getCustAcc)						
				{											
					$totalLoanInterest = $totalLoanInterest + $getCustAcc->amount_borrowed;
					$totalLoanNoInterest = $totalLoanNoInterest + $getCustAcc->interest_payable;
					$totalRebate = $totalRebate + $getCustAcc->early_settlement_balance;
				}		
			}			
			
			// get success total paid from payment trans log
			$getSuccessPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')
										->whereBetween('payment_tran_log.date',[$startWeekEnd,$endWeekEnd])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','1')
										->where('payment_tran_log.week_no','>','0')
										->where('round_number','=',$round_no)
										->get();
											
			// get fail total paid from payment trans log
			$getFailPaymentTrans = DB::table('payment_tran_log')
										->select('*')
										->join('customer_accounts','customer_accounts.account_no','=','payment_tran_log.account_no')	->whereBetween('date',[$startWeekEnd,$endWeekEnd])
										->where('customer_accounts.loan_period','=',$loanperiod->number_of_weeks)
										->where('payment_tran_log.pay_success','=','0')
										->where('payment_tran_log.week_no','>','0')											
										->where('round_number','=',$round_no)
										->get();		
			
			// get success pay tran log
			foreach($getSuccessPaymentTrans As $getSucPayTrans)
			{
				$totalPaid = $totalPaid + $getSucPayTrans->pay_amount;
			}
				
			// get fail pay tran log
			foreach($getFailPaymentTrans As $getFailPayTrans)
			{
				//echo $getFailPayTrans->account_no;
				$totalArrears = $totalArrears + $getFailPayTrans->payment;				
			}					
		}		

		// insert totals
		$insert_table = 'staff_weekly_totals';
		if(Input::get('daily_save') == 'daily_save')
		{
			$insert_table = 'staff_daily_totals';
			$endWeekEnd = $endDailyWeekEnd;
		}
			
		DB::table($insert_table)
					->insert(array('round_number' => $round_no,
										'customer_total' => $totalLoanInterest,
										'staff_name' => $roundConfigData->staff_name,
										'staff_number' => $roundConfigData->staff_number,
										'round_name' => $roundConfigData->round_name,
										'customer_total' => $totalCust,
										'week_end_date' => $endWeekEnd,
										'total_balance' => $totalBalance,
										'total_collect_week' => $totalPaid,
										'total_arrears_week' => $totalArrears,
										'total_loans_for_week' => $totalLoanNoInterest
										));							

		return Redirect::to('ViewEdit/' . $round_no)->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
    }	

}