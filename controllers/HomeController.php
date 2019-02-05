<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	protected $layout = "layouts.index";
	
	public function __construct() {
		
		parent::__construct();
		
	} 	
	

	public function index()
	{
		if(CNF_FRONT =='false' && Session::get('uid') !=1) :
			if(!Auth::check())  return Redirect::to('user/login');
		endif;

        $MaintenanceMode = '';
		
		if(is_null(Input::get('p')))
		{
			$page = Request::segment(1); 	
		} else {
			$page = Input::get('p'); 	
		}

		if($page !='') :
			$content = Pages::where('alias','=',$page)->where('status','=','enable');
			if($content->count() >=1)
			{
				$content = $content->get();
				$row = $content[0];
				
				if($row->access !='')
				{
					$access = json_decode($row->access,true)	;	
				} else {
					$access = array();
				}	

				//echo Session::get('gid');	
				//echo Auth::user()->id;
				//exit();
				// If guest not allowed 
				if($row->allow_guest !=1)
				{	
					$getUserDetails = DB::table('tb_users')
											->select('id','group_id')
											->where('id','=',Auth::user()->id)
											->first();
					
					$group_id = $getUserDetails->group_id;
					$isValid =  (isset($access[$group_id]) && $access[$group_id] == 1 ? 1 : 0 );	
					if($isValid ==0)
					{
						return Redirect::to('')
							->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric') . ' failed!'));				
					}
				}				

				$filename = public_path() ."protected/app/views/pages/template/".$row->filename.".blade.php";
				if(file_exists($filename))
				{
                    if($row->filename == 'Systemconfigurations')
                    {
                        $SiteHandle = DB::table('sys_string')->where('sys_id', 901)->first();
                        $MaintenanceMode = $SiteHandle->value;
                    }
					$page = 'pages.template.'.$row->filename;
				} else {
					return Redirect::to('')
						->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));					
				}
				
			} else {
				return Redirect::to('')
					->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));	
			}
		else :
			$page = 'pages.template.home';
		endif;
		if($MaintenanceMode != '')
        {
            $this->layout->nest('content',$page, array('MaintenanceMode' =>$MaintenanceMode))->with('menus', $this->menus );
        }else{
			// Get complaint new messages
			$complaintCount = DB::table('complaints_online')->where('complaint_status','1')->count();
			$this->data['complaintCount'] = $complaintCount;
			$LoanApplicationViewCount = DB::table('customer_loan_application_primary')
                ->select('customer_loan_application_primary.app_primary_id')
                ->join('customer_loan_application_secondary','customer_loan_application_primary.loan_application_number','=','customer_loan_application_secondary.loan_application_number')
                ->join('customer_loan_application_tertiary','customer_loan_application_primary.loan_application_number','=','customer_loan_application_tertiary.loan_application_number')
                ->where('customer_loan_application_primary.admin_view','0')->orWhere('customer_loan_application_primary.processed','0')->groupBy('customer_loan_application_primary.app_primary_id')->get();

            $LoanApplicationViewCount = count($LoanApplicationViewCount);
            $this->data['LoanApplicationViewCount'] = $LoanApplicationViewCount;
			// Get contact new messages
			$contactCount = DB::table('contact_online')->where('staff_read','0')->count();
			$this->data['contactCount'] = $contactCount;				
            $this->layout->nest('content',$page,$this->data)->with('menus', $this->menus );
        }
			
	}

	public function SiteUp()
    {
       $site_up = $this->UpdateData('sys_string','sys_id',901,array('value' => 1));
       $data = array("default" => 1);
       $dat = $this->curl_request($data);
       return  Redirect::back();
    }

    public function SiteDown()
    {
        $site_down = $this->UpdateData('sys_string','sys_id',901,array('value' => 0));
        $data = array("default" => 0);
        $dat = $this->curl_request($data);
        return  Redirect::back();
    }

    public function curl_request($data)
    {
        if(count($data) > 0)
        {
            $data_string = json_encode($data);
            $url = "https://dev-wwwserver.annfinance.co.uk/site-maintenance";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Ocp-Apim-Subscription-Key: beb6b980707b45538f9c7f837b28b191'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }

	public function Admin_link()
    {
		if(CNF_FRONT =='false' && Session::get('uid') !=1) :
			if(!Auth::check())  return Redirect::to('user/login');
		endif; 
		
		if(is_null(Input::get('p')))
		{
			$page = Request::segment(1); 	
		} else {
			$page = Input::get('p'); 	
		}
		if($page !='') :
			$content = Pages::where('alias','=',$page)->where('status','=','enable');
			if($content->count() >=1)
			{
				$content = $content->get();
				$row = $content[0];
				
				if($row->access !='')
				{
					$access = json_decode($row->access,true)	;	
				} else {
					$access = array();
				}	

				//echo Session::get('gid');	
				//exit();
				//echo Auth::user()->id;
				//exit();
				// If guest not allowed 
				if($row->allow_guest !=1)
				{	
					$getUserDetails = DB::table('tb_users')
											->select('id','group_id')
											->where('id','=',Auth::user()->id)
											->first();
					
					$group_id = $getUserDetails->group_id;
					$isValid =  (isset($access[$group_id]) && $access[$group_id] == 1 ? 1 : 0 );	
					if($isValid ==0)
					{
						return Redirect::to('')
							->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));				
					}
				}				
				
				
				$filename = public_path() ."protected/app/views/pages/template/".$row->filename.".blade.php";
				if(file_exists($filename))
				{
					$page = 'pages.template.'.$row->filename;
				} else {
					return Redirect::to('')
						->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));					
				}
				
			} else {
				return Redirect::to('')
					->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));	
			}
		else :
			$page = 'pages.template.home';
		endif;	

		$this->layout->nest('content',$page)->with('menus', $this->menus );		
        //$page = 'pages.template.admin_round';
        //$this->layout->nest('content',$page);
    }
	
	public function  postContactform()
	{
	
		$this->beforeFilter('csrf', array('on'=>'post'));
		$rules = array(
				'name'		=>'required',
				'subject'	=>'required',
				'message'	=>'required|min:20',
				'sender'	=>'required|email'			
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) 
		{
			
			$data = array('name'=>Input::get('name'),'sender'=>Input::get('sender'),'subject'=>Input::get('subject'),'notes'=>Input::get('message')); 
			$message = View::make('emails.contact', $data); 		
			
			$to 		= 	CNF_EMAIL;
			$subject 	= Input::get('subject');
			$headers  	= 'MIME-Version: 1.0' . "\r\n";
			$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers 	.= 'From: '.Input::get('name').' <'.Input::get('sender').'>' . "\r\n";
				//mail($to, $subject, $message, $headers);			

			return Redirect::to('?p='.Input::get('redirect'))->with('message', SiteHelpers::alert('success','Thank You , Your message has been sent !'));	
				
		} else {
			return Redirect::to('?p='.Input::get('redirect'))->with('message', SiteHelpers::alert('error','The following errors occurred'))
			->withErrors($validator)->withInput();
		}		
	}
	public function  getLang($lang='en')
	{
		Session::put('lang', $lang);
		return  Redirect::back();
	}	
}