<?php
class Customermain extends BaseModel  {
	
	protected $table = 'customer_main';
	protected $primaryKey = 'cust_main_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_main.* FROM customer_main  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_main.cust_main_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
