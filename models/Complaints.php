<?php
class Complaints extends BaseModel  {
	
	protected $table = 'complaints_online';
	protected $primaryKey = 'complaint_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT complaints_online.* FROM complaints_online  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE complaints_online.complaint_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
