<?php
class Userauditlog extends BaseModel  {
	
	protected $table = 'user_audit_log';
	protected $primaryKey = 'audit_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT user_audit_log.* FROM user_audit_log  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE user_audit_log.audit_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
