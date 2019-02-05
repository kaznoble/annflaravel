<?php
class Regulatoryreports extends BaseModel  {
	
	protected $table = 'regulatory_reports';
	protected $primaryKey = 'reg_report_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT regulatory_reports.* FROM regulatory_reports  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE regulatory_reports.reg_report_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
