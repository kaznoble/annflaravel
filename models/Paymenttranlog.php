<?php
class Paymenttranlog extends BaseModel  {
	
	protected $table = 'payment_tran_log';
	protected $primaryKey = 'tran_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT payment_tran_log.*, customer_details.* FROM payment_tran_log INNER JOIN customer_details ON payment_tran_log.customer_no = customer_details.customer_no  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE payment_tran_log.tran_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
