<?php
class Customerdomestic extends BaseModel  {
	
	protected $table = 'customer_domestic_partnership';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_domestic_partnership.* FROM customer_domestic_partnership  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_domestic_partnership.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
