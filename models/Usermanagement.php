<?php
class Usermanagement extends BaseModel  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_users.*, user_profile.* FROM tb_users INNER JOIN user_profile on tb_users.staff_id = user_profile.staff_ID   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_users.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
