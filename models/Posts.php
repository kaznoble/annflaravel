<?php
class Posts extends BaseModel  {
	
	protected $table = 'posts';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT posts.* FROM posts  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE posts.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
