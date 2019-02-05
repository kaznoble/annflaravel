<?php
class UsermanagementController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Usermanagement';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Usermanagement();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'Usermanagement',
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'id'); 
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
		/* echo "<pre>";
		print_r($this->data['tableGrid']);exit; */
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		$this->data['details']		= $master['masterView'];
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		
		$this->layout->nest('content','Usermanagement.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	
	
	function getEdit($id = null){
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
		$row = DB::table('tb_users') //join table users and table user_details base from matched id;
			->join('user_profile', 'tb_users.staff_id', '=', 'user_profile.staff_ID')
			->where('tb_users.id',$id) //find the record matched to the current authenticated user's id from the joint table records
			->get(); //get the record
	
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		
		// Get staff commission percentages
		$staffComm = DB::table('sys_string')
							->whereBetween('sys_id', [101, 110])
							->get();
		
		$this->data['id'] = $id;
		$this->data['staffComm'] = $staffComm;
		$this->layout->nest('content','Usermanagement.editform',$this->data)->with('menus', $this->menus );
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
		
		$this->data['pagestatus'] = '';
		if(!empty(Input::get('pagestatus')))
		{
			$this->data['pagestatus'] = 'new';
		}
			
		$id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		$this->data['id'] = $id;
		$this->layout->nest('content','Usermanagement.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','Usermanagement.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$pagestatus = Input::get('pagestatus');
		if($pagestatus == 'new')
			$id = '';
		
		$rules = array(
			'first_name'=>'required|alpha_num|min:2',
			'last_name'=>'required|alpha_num|min:2',

			'username'=>'required',
			'group_id'=>'required'
		);	
		
		if($id == ""){
			if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
			$rules['email'] = 'required|email|unique:tb_users';
		}
				
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$code = rand(10000,10000000);
			$passwordRandom = $this->randomString(8);
			
			if($id == ""){
				$authen = new User;
				$authen->group_id = Input::get('group_id');
				$authen->username = Input::get('username');			
				$authen->first_name = Input::get('first_name');
				$authen->last_name = Input::get('last_name');
				$authen->email = Input::get('email');
				$authen->activation = $code;
				$authen->password = Hash::make($passwordRandom);
				if(CNF_ACTIVATION == 'auto') { $authen->active = '1'; } else { $authen->active = '0'; }
				$authen->save();
				$userId = $authen->id;
				
				if( $userId > 0 )
				{	
					$newstaffid = 00000000;
					$newstaffid = $newstaffid + $userId;
					$newstaffid = str_pad($newstaffid, 8, '0', STR_PAD_LEFT);
					$newstaffid = 'SN' . $newstaffid;
					DB::table('tb_users')->where('id', $userId)->update(['staff_id' => $newstaffid]);
				}
				
				$data = array(
					'firstname'	=> Input::get('first_name') ,
					'lastname'	=> Input::get('last_name') ,
					'email'		=> Input::get('email') ,
					'password'	=> $passwordRandom ,
					'code'		=> $code
					
				);
				if(CNF_ACTIVATION == 'confirmation')
				{
					DB::table('user_profile')->insert(['staff_ID' => $newstaffid]);
					require_once(dirname(__FILE__) . "/../../../Classes/models/sendgrid.class.php");
					$sendgrid = new sendgrid();
					$email = Input::get('email');
					$firstname = Input::get('first_name');
					$password = $passwordRandom;
					$Templete = Systemconfiguration::where('sys_id','804')->get();
					$LINK = '<a href="'.URL::to('user/activation?code='.$code).'"> Active my account now</a>';
					$LINK1 = URL::to('user/activation?code='.$code);
					$Data  = array('$CNF_APPNAME' => array(CNF_APPNAME), '$LINK' => array($LINK), '$LINK_NEW' => array($LINK1), '$firstname' => array($firstname), '$email' => array($email), '$password' => array($password));
					$sendgrid->sendgrid_mail($Templete[0]->value,$Data,$email,'');
					$message = "Thanks for registering! . Please check your inbox and follow activation link";

				} elseif(CNF_ACTIVATION=='manual') {
					$message = "Thanks for registering! . We will validate you account before your account active";
				} else {
					
				}
			}else{
				$data_user_profile = array();
				$data = $this->validatePost('tb_users');
							
				if(Input::file('avatar') != ""){
					$image = Input::file('avatar');
					$savepath = './uploads/users/';
					$filename = time().$image->getClientOriginalName();
					Input::file('avatar')->move($savepath, $filename);
					$data['avatar'] = $filename;
				}else{
					$data['avatar'] = Input::get('avatar1');
				}
				
				//$data_user_profile['staff_ID'] = Input::get('staff_id');
				$data_user_profile['round_number'] = Input::get('round_number');
				$data_user_profile['account_status'] = Input::get('account_status');
				$data_user_profile['commission_payed'] = Input::get('commission_payed');			
				$data_user_profile['percentage_commission_payed'] = Input::get('percentage_commission_payed');
				if(empty($data_user_profile['percentage_commission_payed']))
					$data_user_profile['percentage_commission_payed'] = 0;
				$data_user_profile['home_number'] = Input::get('home_number');
				$data_user_profile['mobile_number'] = Input::get('mobile_number');
				$data_user_profile['mobile_device_number'] = Input::get('mobile_device_number');
				$data_user_profile['upcoming_holidays'] = date('Y-m-d', strtotime(str_replace('/','-',Input::get('upcoming_holidays'))));
				$data_user_profile['emergency_contact_name'] = Input::get('emergency_contact_name');
				$data_user_profile['emergency_contact_home'] = Input::get('emergency_contact_home');
				$data_user_profile['emergency_contact_mobile'] = Input::get('emergency_contact_mobile');
				$data_user_profile['monday'] = (Input::get('monday')==1) ? '1' : '0' ;
				$data_user_profile['tuesday'] = (Input::get('tuesday')==1) ? '1' : '0';
				$data_user_profile['wednesday'] = (Input::get('wednesday')==1) ? '1' : '0';
				$data_user_profile['thursday'] = (Input::get('thursday')==1) ? '1' : '0';
				$data_user_profile['friday']= (Input::get('friday')==1) ? '1' : '0';
				$data_user_profile['saturday'] = (Input::get('saturday')==1) ? '1' : '0';
				$data_user_profile['sunday'] = (Input::get('sunday')==1) ? '1' : '0';
				
				$update = DB::table('tb_users')
				->where('id', SiteHelpers::encryptID($id,true))
				->update(['group_id'=>$data['group_id'],'username'=>$data['username'],'first_name'=>$data['first_name'],'last_name'=>$data['last_name'],'avatar'=>$data['avatar'],'updated_at'=>date('Y-m-d H:i:s')]);
				
				// tb_user update
				DB::table('tb_users')->where('staff_id', $data['staff_id'])->update(['active'=>$data_user_profile['account_status']]);
				
				$userRoundNo = $data_user_profile['round_number'];
				if(empty($userRoundNo))
					$userRoundNo = 0;
				$update_profile = DB::table('user_profile')->where('staff_ID', $data['staff_id'])->update(['staff_id'=>$data['staff_id'],'round_number'=>$userRoundNo,'account_status'=>$data_user_profile['account_status'],'commission_payed'=>$data_user_profile['commission_payed'],'percentage_commission_payed'=>$data_user_profile['percentage_commission_payed'],'home_number'=>$data_user_profile['home_number'],'mobile_number'=>$data_user_profile['mobile_number'],'mobile_device_number'=>$data_user_profile['mobile_device_number'],'upcoming_holidays'=>$data_user_profile['upcoming_holidays'],'emergency_contact_name'=>$data_user_profile['emergency_contact_name'],'emergency_contact_home'=>$data_user_profile['emergency_contact_home'],'emergency_contact_mobile'=>$data_user_profile['emergency_contact_mobile'],'monday'=>$data_user_profile['monday'],'tuesday'=>$data_user_profile['tuesday'],'wednesday'=>$data_user_profile['wednesday'],'thursday'=>$data_user_profile['thursday'],'friday'=>$data_user_profile['friday'],'saturday'=>$data_user_profile['saturday'],'sunday'=>$data_user_profile['sunday']]);
				
				$message = "Record Edited Successfully";
			}
		
				

			return Redirect::to('Usermanagement')->with('message',SiteHelpers::alert('success',$message));
		} else {
			return Redirect::to('Usermanagement/edit/'.$id)->with('message', SiteHelpers::alert('error','The following errors occurred'))
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
		return Redirect::to('Usermanagement');
	}			
	
	function randomString($length = 6) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}	
	
	public function postRequest()
	{		
		$rules = array(
			'credit_email'=>'required|email'
		);	
		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {

			$user =  User::where('email','=',Input::get('credit_email'));
			if($user->count() >=1)
			{
				// reset random password
				$TEMPORARY_PASSWORD = $this->randomString(8);
                require_once(dirname(__FILE__) . "/../../../Classes/models/sendgrid.class.php");
                $sendgrid = new sendgrid();
				$user = $user->get();
				$user = $user[0];
				$userFind = User::find($user->id);
				$userFind->password = Hash::make($TEMPORARY_PASSWORD);
				$userFind->save();				
				//echo $TEMPORARY_PASSWORD;
				//exit();
                $token = Input::get('_token');
                $to = Input::get('credit_email');
                $Templete = Systemconfiguration::where('sys_id','803')->get();
                $LINK = '<a href="'.URL::to('user/reset', array($token)).'">Click Here</a>';
                $Data  = array('$CNF_APPNAME' => array(CNF_APPNAME), '$TEMPORARY_PASSWORD' => array($TEMPORARY_PASSWORD), '$LINK' => array($LINK));
                $sendgrid->sendgrid_mail($Templete[0]->value,$Data,$to,'');
				$affectedRows = User::where('email', '=',$user->email)
								->update(array('reminder' => Input::get('_token')));
				return Redirect::to('Usermanagement/edit/'.Input::get('reset_id'))->with('message', SiteHelpers::alert('success','A reset email has been sent to staff'));
				
			} else {
				return Redirect::to('Usermanagement/edit/'.Input::get('reset_id'))->with('message', SiteHelpers::alert('error','Cant find email address'));
			}

		}  else {
			return Redirect::to('Usermanagement/edit/'.Input::get('reset_id'))->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}	 
	}		
		
}