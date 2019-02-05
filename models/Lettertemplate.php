<?php
class Lettertemplate extends BaseModel  {
	
	protected $table = 'letter_template';
	protected $primaryKey = 'temp_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT letter_template.* FROM letter_template  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE letter_template.temp_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
        
        function update_letter_manager($customer_no, $account_no, $step)
        {
            $letterstep = $step;
            $insLetterManager = DB::table('letter_manager')->insert(
                        array('customer_no' => $customer_no,
                                'account_no' => $account_no,
                                'letter_step' => $letterstep,
                                'letter_sent' => date('Y-m-d'))
                        );	
        }

}
