<?php
class Accountincome extends BaseModel  {
	
	protected $table = 'acc_income';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT acc_income.* FROM acc_income  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE acc_income.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
