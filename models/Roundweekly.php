<?php
class Roundweekly extends BaseModel  {
	
	protected $table = 'round_config';
	protected $primaryKey = 'round_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT round_config.* FROM round_config  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE round_config.round_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
