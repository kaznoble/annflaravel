<?php
class Searchcustomer extends BaseModel  {
	
	protected $table = 'customer_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_details.* FROM customer_details  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_details.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
