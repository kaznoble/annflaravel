<?php
class Customerdetails extends BaseModel  {
	
	protected $table = 'customer_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT customer_details.*, users.email, users.password FROM customer_details INNER JOIN users ON customer_details.user_id = users.id ";
	}
	public static function queryWhere(  ){

		return " WHERE users.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
