<?php
class Accountannualtotals extends BaseModel  {
	
	protected $table = 'acc_annual_totals';
	protected $primaryKey = 'year_end_date';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT acc_annual_totals.* FROM acc_annual_totals  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE acc_annual_totals.year_end_date IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
