<?php
class ContactOnline extends BaseModel  {

    protected $table = 'contact_online';
    protected $primaryKey = 'contact_id';

    public function __construct() {
        parent::__construct();

    }

    public static function querySelect(  ){


        return "  SELECT contact_online.* FROM coontact_online  ";
    }
    public static function queryWhere(  ){

        return " WHERE contact_online.contact_id IS NOT NULL   ";
    }

    public static function queryGroup(){
        return "  ";
    }


}
