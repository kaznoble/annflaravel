<?php
class Systememails extends BaseModel  {
	
	protected $table = 'sys_emails';
	protected $primaryKey = 'email_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT sys_emails.* FROM sys_emails  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE sys_emails.email_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
