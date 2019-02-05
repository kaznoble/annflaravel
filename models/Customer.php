<?php
class Customer extends BaseModel  {
	
	protected $table = 'customer_details';
	protected $primaryKey = 'customer_no';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_details.* FROM customer_details  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_details.customer_no IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
