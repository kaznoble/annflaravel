<?php
class Loanapptertiary extends BaseModel  {
	
	protected $table = 'customer_loan_application_tertiary';
	protected $primaryKey = 'loan_tert_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_loan_application_tertiary.* FROM customer_loan_application_tertiary  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_loan_application_tertiary.loan_tert_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
