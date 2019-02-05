<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface; 

class User extends Eloquent implements UserInterface, RemindableInterface   {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';
	protected $hidden = array('password');

	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}	

	public function getRememberToken()
	{
		return $this->remember_token;
	}
	
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}
	
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	
	public function historyPassword($email, $password)
	{
		$makehistpassword = true;
		$arrayPwd = array();
		// detect exist password
		$existPassword = DB::table('history_password')->select('hist_password')->where('hist_email', HTML::entities($email))->get();
		foreach ($existPassword As $existPass)
		{
			array_push($arrayPwd, Crypt::decrypt($existPass->hist_password));
		}
		if(!in_array($password, $arrayPwd))
		{
			// get history password
			$enPassword = Crypt::encrypt(HTML::entities($password));
			$countHistPassword = DB::table('history_password')->where('hist_email', HTML::entities($email))->count();
			if($countHistPassword < 3)
			{
				DB::table('history_password')->insert(array('hist_email' => HTML::entities($email), 'hist_password' => $enPassword));
			}
			else
			{
				DB::statement("DELETE from history_password WHERE `hist_email` = '" . $email . "' LIMIT 1");
				DB::table('history_password')->insert(array('hist_email' => HTML::entities($email), 'hist_password' => $enPassword));			
			}
			return true;
		}
		else
		{
			return false;
		}
	}

}
