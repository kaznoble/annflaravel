<?php
class Loanapphistory extends BaseModel  {
	
	protected $table = 'customer_loan_application_primary';
	protected $primaryKey = 'app_primary_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT customer_loan_application_primary.*,customer_loan_application_secondary.*, customer_loan_application_tertiary.* from customer_loan_application_primary 
                  INNER JOIN customer_loan_application_secondary ON (customer_loan_application_primary.loan_application_number = customer_loan_application_secondary.loan_application_number)
                  INNER JOIN customer_loan_application_tertiary ON (customer_loan_application_primary.loan_application_number = customer_loan_application_tertiary.loan_application_number)  ";
	}
	public static function queryWhere(  ){
		
		return "where customer_loan_application_primary.app_primary_id IS NOT NULL AND customer_loan_application_primary.processed = '1' AND customer_loan_application_primary.admin_view = '1'  ";
	}
	
	public static function queryGroup(){
		return "  GROUP BY customer_loan_application_primary.app_primary_id  ";
	}
	

}
