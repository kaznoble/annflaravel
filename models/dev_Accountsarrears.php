<?php
class Accountsarrears extends BaseModel  {
	
	protected $table = 'customer_accounts';
	protected $primaryKey = 'account_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_accounts.*, round_config.* FROM customer_accounts INNER JOIN round_config ON customer_accounts.round_number = round_config.round_number  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_accounts.no_miss_payment > 0 AND customer_accounts.account_id IS NOT NULL    ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
