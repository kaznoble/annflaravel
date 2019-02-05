<?php
class Customerincome extends BaseModel  {
	
	protected $table = 'customer_income';
	protected $primaryKey = 'cust_income_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_income.* FROM customer_income  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_income.cust_income_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
