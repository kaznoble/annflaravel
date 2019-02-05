<?php
class Customercomments extends BaseModel  {
	
	protected $table = 'customer_comments';
	protected $primaryKey = 'cust_comments_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_comments.* FROM customer_comments  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_comments.cust_comments_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
