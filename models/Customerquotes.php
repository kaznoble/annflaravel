<?php
class Customerquotes extends BaseModel  {
	
	protected $table = 'quotes';
	protected $primaryKey = 'quote_no';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT quotes.* FROM quotes  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE quotes.quote_no IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
