<?php
class Customerrelative extends BaseModel  {
	
	protected $table = 'customer_nearest_relative';
	protected $primaryKey = 'cust_rel_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_nearest_relative.* FROM customer_nearest_relative  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_nearest_relative.cust_rel_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
