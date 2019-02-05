<?php
class Accountweeklytotals extends BaseModel  {
	
	protected $table = 'acc_weekly_totals';
	protected $primaryKey = 'week_no';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT acc_weekly_totals.* FROM acc_weekly_totals  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE acc_weekly_totals.week_no IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
