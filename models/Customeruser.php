<?php
class Customeruser extends BaseModel  {
	
	protected $table = 'users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT users.*, customer_main.customer_no FROM users INNER JOIN customer_main ON users.id = customer_main.user_id ";
	}
	public static function queryWhere(  ){
		
		return " WHERE users.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
