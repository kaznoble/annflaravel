<?php
class Systemconfiguration extends BaseModel  {
	
	protected $table = 'sys_string';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT sys_string.* FROM sys_string  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE sys_string.id IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
