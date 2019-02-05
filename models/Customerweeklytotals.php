<?php
class Customerweeklytotals extends BaseModel  {
	
	protected $table = 'customer_weekly_totals';
	protected $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_weekly_totals.* FROM customer_weekly_totals ORDER BY date DESC ";
	}
	public static function queryWhere(  ){
		
		return "   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
