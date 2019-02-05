<?php
class Incomeexpenditure extends BaseModel  {
	
	protected $table = 'customer_outgoing';
	protected $primaryKey = 'cust_outg_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_outgoing.*, customer_income.* FROM customer_outgoing  ";
	}
	public static function queryWhere(  ){
		
		return "  INNER JOIN customer_income ON customer_outgoing.user_id=customer_income.user_id WHERE customer_outgoing.cust_outg_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
