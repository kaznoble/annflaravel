<?php
class Loanappprimary extends BaseModel  {
	
	protected $table = 'customer_loan_application_primary';
	protected $primaryKey = 'app_primary_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_loan_application_primary.* FROM customer_loan_application_primary  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_loan_application_primary.app_primary_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
