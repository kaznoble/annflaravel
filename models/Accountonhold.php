<?php
class Accountonhold extends BaseModel  {
	
	protected $table = 'customer_accounts';
	protected $primaryKey = 'account_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT customer_accounts.*,customer_details.forename,customer_details.surname FROM customer_accounts INNER JOIN customer_details ON customer_accounts.customer_no=customer_details.customer_no ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_accounts.loan_status = 8 AND customer_accounts.account_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
