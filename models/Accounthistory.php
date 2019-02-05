<?php
class Accounthistory extends BaseModel  {
	
	protected $table = 'account_history';
	protected $primaryKey = 'acc_history_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT account_history.* FROM account_history  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE account_history.acc_history_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
