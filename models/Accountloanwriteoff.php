<?php
class Accountloanwriteoff extends BaseModel  {
	
	protected $table = 'acc_loan_write_off';
	protected $primaryKey = 'account_no';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT acc_loan_write_off.* FROM acc_loan_write_off  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE acc_loan_write_off.account_no IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
