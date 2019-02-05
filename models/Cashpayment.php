<?php
class Cashpayment extends BaseModel  {
	
	protected $table = 'customer_accounts';
	protected $primaryKey = 'account_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_accounts.* FROM customer_accounts  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_accounts.account_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
