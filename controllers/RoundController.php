<?php
class RoundController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'adminround';
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
		
		// Get round without admin
		$roundNoAdmin = DB::table('round_config')
							->where('staff_only','=','0')
							->get();

		// Get round with admin
		$roundAdmin = DB::table('round_config')
							->where('staff_only','=','1')
							->get();
							
		$this->data['roundNoAdmin'] = $roundNoAdmin;					
		$this->data['roundAdmin'] = $roundAdmin;		
		$this->data['gid'] = Session::get('gid');
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
		if(Session::get('gid') == 1 || Session::get('gid') == 2)
		{
			$Round = Round::where('round_number','=',Input::get('round_no'))->get();		
		}
		else
		{
			$Round = Round::where('round_number','=',Input::get('round_no'))->where('staff_only','=','0')->get();
		}
        $html='';
        foreach ($Round as $r)
        {
            $html.='<tr><td>'.$r->round_number.'</td><td>'.$r->staff_name.'</td><td>'.$r->round_name.'</td><td><a class="btn btn-danger btn-sm" onclick="delete_round('.$r->round_number.')">Confirm Delete</a></td><td><a href="/EditRound/'.$r->round_number.'" class="btn btn-success btn-sm">Change Staff</a></td>';
        }
        return json_encode(array('html' =>$html));
    }

    public function EditRound($id)
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

        $round = Round::where('round_number','=', $id)->get();
        $this->data['round'] = $round;
        $page = 'round.edit';
        $this->layout->nest('content',$page,$this->data);
    }

    public function UpdateRound($id)
    {
        $validator = Validator::make(Input::all(),
            array(
                'staff_number' => 'required|not_in:0'
            )
        );
        if ($validator->passes()) {
            $round_config = Round::where('round_number','=',$id)->get();
            $user_profile_old = array(
                'round_number' => 0
            );
            $this->UpdateData('user_profile','staff_ID', $round_config[0]->staff_number, $user_profile_old);

            $StaffData = User::where('staff_id','=',Input::get('staff_number'))->select('first_name','last_name')->get();
            $RoundData = array(
                'staff_number' => Input::get('staff_number'),
                'staff_name' => $StaffData[0]->first_name.' '.$StaffData[0]->last_name,
                'days_of_week' => '',
            );
            $this->UpdateData('round_config','round_number',$id,$RoundData);

            $user_profile = array(
                'round_number' => $id
            );
            $this->UpdateData('user_profile','staff_ID', Input::get('staff_number'), $user_profile);

            return Redirect::to('add_delete_round/add')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        }else{
            return Redirect::to('add_delete_round/add')->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
                ->withErrors($validator)->withInput();
        }
    }

    public function ClearAllStaff()
	{
		// To clear all staff only
		$staffOnlyRes = DB::table('round_config')
									->update(array('staff_only' => '0'));	
		return json_encode(array('ResponseCode' => 0));		
	}
	
    public function StaffOnly()
    {
		// Update staff only round
		$id = Input::get('id');
		$val = Input::get('val');
		echo 'testing' . $id;
		$staffOnlyRes = DB::table('round_config')
									->where('round_number', $id)
									->update(array('staff_only' => $val));
		return json_encode(array('ResponseCode' => 0));											
    }	

    public function DeleteRound()
    {
        $CustomerRound = Roundcustomerrelation::where('round_number','=',Input::get('id'))->count();
        if($CustomerRound > 0)
        {
            $Response = 0;
        }else{
            $round_config = Round::where('round_number','=',Input::get('id'))->get();
            $user_profile_old = array(
                'round_number' => 0
            );
            $this->UpdateData('user_profile','staff_ID', $round_config[0]->staff_number, $user_profile_old);
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
        $this->data['Round'] = Round::get();
        $this->data['days'] = DB::table('days')->get();
        $this->layout->nest('content',$page,$this->data);
    }

    public function GetDetailsRoundWise($id)
    {
        $page = 'round.view';
        $this->data['Round'] = Round::get();
        $this->data['RoundData'] = Round::where('round_number','=',$id)->get();
        $Data = Roundcustomerrelation::select('round_customer_relation.relation_id','round_customer_relation.round_number','round_customer_relation.customer_no','round_customer_relation.callback_time','round_customer_relation.callback_day','customer_details.address_1','customer_details.address_2','customer_details.address_3','customer_details.address_4','customer_details.postcode','customer_details.forename','customer_details.surname','customer_main.preferred_time_to_call','days.day_desc')->join('customer_details','customer_details.customer_no','=','round_customer_relation.customer_no')->join('customer_main','round_customer_relation.customer_no','=','customer_main.customer_no')->join('days','customer_main.preferred_payment_day','=','days.day_id')->where('round_customer_relation.round_number','=',$id. ' COLLATE utf8_unicode_ci')->orderBy('customer_main.preferred_time_to_call','asc')->get();
        foreach ($Data as $d)
        {
            if($d->day_desc =='Monday')
            {
                $this->data['MondayCustomer'][] = $d;
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
        $this->data['staff_days'] = $days;
        $this->data['days'] = DB::table('days')->get();
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
            $user_profile_main = array(
				'group_id' => '4',
                'round_number' => NULL
            );			
            $this->UpdateData('customer_main','customer_no', $customer_no[0], $user_profile_main);
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

    public function ReassignCallbackList()
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
		$table = '';
		$formID = '';
		$formtype = Input::get('formtype');
		if($formtype == 'Customermain')
			$table = 'customer_main';
		if($formtype == 'incomeexpenditure')
			$table = 'customer_income';		
		if($formtype == 'Customerdetails')
			$table = 'customer_details';
		if($formtype == 'Customerrelative')
			$table = 'customer_nearest_relative';	
		if($formtype == 'Customercomments')
			$table = 'customer_comments';
		if($formtype == 'Accounthistory')
			$table = 'account_history';		
		if($formtype == 'Customeraccounts')
			$table = 'customer_accounts';	
		if($formtype == 'Paymenttranlog')
			$table = 'payment_tran_log';			
		$Data = Roundcustomerrelation::where('relation_id','=',Input::get('relation_id'))->lists('customer_no');
		Session::put('round_customer_no', $Data[0]);
		// get data
		$tableData = DB::table($table)->where('customer_no','=',$Data[0])->first();
		$tdata = json_decode(json_encode($tableData), true);	
		if(!empty($tdata))
			$formID = reset($tdata);

        return json_encode(array('cust_no' => $Data[0], 'formID' => SiteHelpers::encryptID($formID)));
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

}