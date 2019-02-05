<?php
class Accountbusinessexpense extends BaseModel  {
	
	protected $table = 'acc_business_expense';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT acc_business_expense.* FROM acc_business_expense  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE acc_business_expense.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
