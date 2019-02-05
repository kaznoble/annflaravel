<?php
class Staffweeklytotals extends BaseModel  {
	
	protected $table = 'staff_weekly_totals';
	protected $primaryKey = 'weeklyTotal_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT staff_weekly_totals.* FROM staff_weekly_totals  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE staff_weekly_totals.weeklyTotal_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
