<?php
class Customerquarterlytotals extends BaseModel  {
	
	protected $table = 'customer_quarterly_totals';
	protected $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_quarterly_totals.* FROM customer_quarterly_totals ORDER BY date DESC ";
	}
	public static function queryWhere(  ){
		
		return "   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
