<?php
class Customercreditors extends BaseModel  {
	
	protected $table = 'customer_creditors';
	protected $primaryKey = 'cust_cred_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_creditors.* FROM customer_creditors  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_creditors.cust_cred_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
