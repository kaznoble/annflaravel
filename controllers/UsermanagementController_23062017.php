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
		$rules = array(
			'first_name'=>'required|alpha_num|min:2',
			'last_name'=>'required|alpha_num|min:2',
			'email'=>'required|email|unique:tb_users',
			'username'=>'required',
			'group_id'=>'required'
			);	
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
				
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$code = rand(10000,10000000);
			$passwordRandom = $this->randomString(8);
		
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

			return Redirect::to('Usermanagement')->with('message',SiteHelpers::alert('success',$message));
		} else {
			return Redirect::to('user/register')->with('message', SiteHelpers::alert('error', SiteHelpers::alert('error','The following errors occurred'))
			)->withErrors($validator)->withInput();
		}		
		
		
		
		
		/* temporary disabled */
		/*$rules = array(
			'first_name'=>'required|alpha_num|min:2',
			'last_name'=>'required|alpha_num|min:2',
			'email'=>'required|email|unique:tb_users',
			'username'=>'required',
			'group_id'=>'required'
			);	
		if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
		
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_users');
			$ID = $this->model->insertRow($data , Input::get('id'));
			// Input logs
			if( Input::get('id') =='')
			{	
				$newstaffid = 00000000;
				$newstaffid = $newstaffid + $ID;
				$newstaffid = str_pad($newstaffid, 8, '0', STR_PAD_LEFT);
				$newstaffid = 'SN' . $newstaffid;
				DB::table('tb_users')->where('id', $ID)->update(['staff_id' => $newstaffid]);
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			return Redirect::to('Usermanagement')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
		} else {
			return Redirect::to('Usermanagement/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
			->withErrors($validator)->withInput();
		}*/	
	
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
		
}