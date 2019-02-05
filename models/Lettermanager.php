<?php
class Lettermanager extends BaseModel  {
	
	protected $table = 'customer_accounts';
	protected $primaryKey = 'account_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_accounts.account_id, customer_accounts.user_id, customer_accounts.account_no, customer_accounts.customer_no, customer_details.forename, customer_details.surname, customer_details.address_1, customer_details.address_2, customer_details.address_3, customer_details.address_4, customer_details.postcode, letter_manager.letter_sent "
                        . "FROM customer_accounts "
                        . "LEFT JOIN customer_details ON customer_accounts.customer_no = customer_details.customer_no "
                        . "LEFT JOIN letter_manager ON customer_accounts.account_no = letter_manager.account_no  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_accounts.arrears > 0 AND letter_manager.letter_step IS NULL AND customer_accounts.account_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

}
