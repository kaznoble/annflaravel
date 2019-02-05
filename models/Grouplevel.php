<?php
class Grouplevel extends BaseModel  {
	
	protected $table = 'tb_module';
	protected $primaryKey = 'module_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_module.* FROM tb_module  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_module.module_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	public static function GetGroupAccess($m_id){
		return "select tb_groups.name, tb_groups_access.* from tb_groups left join tb_groups_access on tb_groups.group_id = tb_groups_access.group_id where tb_groups_access.module_id = '$m_id'";
	}

}
