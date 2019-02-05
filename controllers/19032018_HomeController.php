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