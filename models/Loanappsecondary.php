<?php
class Loanappsecondary extends BaseModel  {
	
	protected $table = 'customer_loan_application_secondary';
	protected $primaryKey = 'loan_secondary_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_loan_application_secondary.* FROM customer_loan_application_secondary  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_loan_application_secondary.loan_secondary_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
