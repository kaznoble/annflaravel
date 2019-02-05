<?php
class Customeroutgoing extends BaseModel  {
	
	protected $table = 'customer_outgoing';
	protected $primaryKey = 'cust_outg_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_outgoing.* FROM customer_outgoing  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_outgoing.cust_outg_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
