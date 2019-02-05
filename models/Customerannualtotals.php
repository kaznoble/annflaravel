<?php
class Customerannualtotals extends BaseModel  {
	
	protected $table = 'customer_annual_totals';
	protected $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_annual_totals.* FROM customer_annual_totals ORDER BY date DESC ";
	}
	public static function queryWhere(  ){
		
		return "   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
