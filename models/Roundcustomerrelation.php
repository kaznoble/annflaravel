<?php
class Roundcustomerrelation extends BaseModel  {
	
	protected $table = 'round_customer_relation';
	protected $primaryKey = 'relation_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT round_customer_relation.* FROM round_customer_relation  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE round_customer_relation.relation_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
