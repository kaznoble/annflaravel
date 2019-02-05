<?php
class BaseModel extends Eloquent  {
	
	public function __construct() {
		parent::__construct();

	}
	
	public static function getRows( $args )
	{

        extract( array_merge( array(
			'page' 		=> '0' ,
			'limit'  	=> '0' ,
			'sort' 		=> '' ,
			'order' 	=> '' ,
			'params' 	=> '' ,
			'global'	=> '1'	  
        ), $args ));
		
		$offset = ($page-1) * $limit ;	
		$limitConditional = ($page !=0 && $limit !=0) ? "LIMIT  $offset , $limit" : '';	
		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 )
				$params .= " AND {$table}.entry_by ='".Session::get('uid')."'"; 	
		// End Update permission global / own access new ver 1.1			
        
		$rows = array();
	    $result = DB::select( self::querySelect() . self::queryWhere(). "
				{$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");
				
		$total = DB::select( self::querySelect() . self::queryWhere()." {$params} ". self::queryGroup());


		return $results = array('rows'=> $result , 'total' => count($total));	

	
	}

    public static function getRows_SubmissionReport( $args )
    {

        extract( array_merge( array(
            'page' 		=> '0' ,
            'limit'  	=> '0' ,
            'sort' 		=> '' ,
            'order' 	=> '' ,
            'params' 	=> '' ,
            'global'	=> '1'
        ), $args ));

        $offset = ($page-1) * $limit ;
        $limitConditional = ($page !=0 && $limit !=0) ? "LIMIT  $offset , $limit" : '';
        $orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

        // Update permission global / own access new ver 1.1
        $table = with(new static)->table;
        if($global == 0 )
            $params .= " AND {$table}.entry_by ='".Session::get('uid')."'";
        // End Update permission global / own access new ver 1.1

        $rows = array();
        $FirmRefNumber = DB::table('sys_string')->where('sys_id','=','30')->get();
        $query = " SELECT customer_details.forename,customer_details.surname,customer_accounts.account_no as tran_ref, ".$FirmRefNumber[0]->value." as firm_ref_number, NOW() as reg_date, customer_accounts.loan_start_date as tran_date, customer_accounts.amount_borrowed as loan_amount,'H' AS loan_type,
                                          customer_accounts.percentage_apr as apr, 0 AS arrangement_fee, customer_accounts.total_payable as total_amount_payable, 0 AS rollover,
                                          0 AS order_rollover, 7*loan_period AS length_of_term, CASE WHEN customer_accounts.reason_for_loan = '1' THEN 'O' WHEN customer_accounts.reason_for_loan = '2' THEN 'P' WHEN customer_accounts.reason_for_loan = '3' THEN 'S' ELSE 'O' END as reason_for_loan, customer_details.date_of_birth,
                                          customer_details.postcode, customer_income.income_total as monthly_income, CASE WHEN customer_details.marital_status = '1' THEN 'M' WHEN customer_details.marital_status = '2' THEN 'S' WHEN customer_details.marital_status = '3' THEN 'P' WHEN customer_details.marital_status = '4' THEN 'D' WHEN customer_details.marital_status = '5' THEN 'L' WHEN customer_details.marital_status = '6' THEN 'W' WHEN customer_details.marital_status = '7' THEN 'O' ELSE 'O' END as marital_status, CASE WHEN customer_details.cus_residential_status = '1' THEN 'O' WHEN customer_details.cus_residential_status = '2' THEN 'L' WHEN customer_details.cus_residential_status = '3' THEN 'T' WHEN customer_details.cus_residential_status = '4' THEN 'T' WHEN customer_details.cus_residential_status = '5' THEN 'C' WHEN customer_details.cus_residential_status = '6' THEN 'T' WHEN customer_details.cus_residential_status = '7' THEN 'J' END as residential_status,
                                          CASE WHEN customer_details.employment_status = '1' THEN 'EF' WHEN customer_details.employment_status = '2' THEN 'EP' WHEN customer_details.employment_status = '3' THEN 'ET' WHEN customer_details.employment_status = '4' THEN 'U' WHEN customer_details.employment_status = '5' THEN 'SE' WHEN customer_details.employment_status = '6' THEN 'S' WHEN customer_details.employment_status = '7' THEN 'HM' WHEN customer_details.employment_status = '8' THEN 'R' WHEN customer_details.employment_status = '9' THEN 'OB' WHEN customer_details.employment_status = '10' THEN 'AF' END as employment_status

                                   FROM customer_accounts
                                   LEFT JOIN customer_details ON (customer_accounts.customer_no = customer_details.customer_no)

                   LEFT JOIN customer_income ON (customer_accounts.customer_no = customer_income.customer_no)";
        $result = DB::select( $query ."
				{$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");

        $total = DB::select( $query ." {$params} ". self::queryGroup());

        return $results = array('rows'=> $result , 'total' => count($total));

    }
	
	public static function getRow( $id )
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

		$result = DB::select( 
				self::querySelect() . 
				self::queryWhere().
				" AND ".$table.".".$key." = '{$id}' ". 
				self::queryGroup()
			);	
		if(count($result) <= 0){
			$result = array();		
		} else {

			$result = $result[0];
		}
		return $result;		
	}	 
	
	public static function insertRow( $data , $id)
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	    if($id == NULL )
        {
            // Insert Here 
			 $id = DB::table( $table)->insertGetId($data);				
            
        } else {
            // Update here 
			 DB::table($table)->where($key,$id)->update($data);    
        }    
        return $id;    
	}	

	static function getComboselect( $params , $nested = array())
	{	
	   	if(isset($params[3]) AND !empty($params[4]) ){
			$table = $params[0]; 
			$row =  DB::table($table)->where($params[3],$params[4])->get();
		}
		elseif($params[3][0] == 'freq_order')
		{
			$table = $params[0]; 
			$row =  DB::table($table)->orderBy($params[3][0],'asc')->get();			
		}
		else
		{
			$table = $params[0]; 
			$row =  DB::table($table)->get();
		}
		return $row;

	} 	
		
	
	static function getColumnTable( $table )
	{	  
        $columns = array();
	    foreach(DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[$column->Field] = '';
        }

        return $columns;
	}	
	
	static function makeInfo( $id )
	{	
		$row =  DB::table('tb_module')->where('module_name', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$data['id']		= $r->module_id; 
			$data['title'] 	= $r->module_title; 
			$data['note'] 	= $r->module_note; 
			$data['table'] 	= $r->module_db; 
			$data['key'] 	= $r->module_db_key;
			$data['config'] = SiteHelpers::CF_decode_json($r->module_config);
			$field = array();	
			foreach($data['config']['grid'] as $fs)
			{
				foreach($fs as $f)
					$field[] = $fs['field']; 	
									
			}
			$data['field'] = $field;			
		}
		return $data;
			
	
	} 
	
	static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'Tables_in_'.$db ; 
		foreach(DB::select("SHOW TABLES FROM {$db}") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}	
	
	static function getTableField( $table ) 
	{
        $columns = array();
	    foreach(DB::select("SHOW COLUMNS FROM $table") as $column)
		    $columns[$column->Field] = $column->Field;
        return $columns;
	}
	
	function getColoumnInfo( $result )
	{
		$pdo = DB::getPdo();
		$res = $pdo->query($result);
		$i =0;	$coll=array();	
		while ($i < $res->columnCount()) 
		{
			$info = $res->getColumnMeta($i);			
			$coll[] = $info;
			$i++;
		}
		return $coll;	
	
	}
	
	function builColumnInfo( $statement )
	{
		$driver 		= Config::get('database.default');
		$database 		= Config::get('database.connections');
		$db 		= $database[$driver]['database'];
		$dbuser 	= $database[$driver]['username'];
		$dbpass 	= $database[$driver]['password'];
		$dbhost 	= $database[$driver]['host'];
		
		$data = array();				
		$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$db);
		if ($result = $mysqli->query($statement)) {
		
			/* Get field information for all columns */
			while ($finfo = $result->fetch_field()) {
				$data[] = (object) array(
							'Field'	=> $finfo->name,
							'Table'	=> $finfo->table,
							'Type'	=> $finfo->type
							);
			}
			$result->close();
		}
		
		$mysqli->close();
		return $data;
	
	}	
	
	function validAccess( $id)
	{

		$row = DB::table('tb_groups_access')->where('module_id','=', $id)
				->where('group_id','=', Session::get('gid'))
				->get();
		
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
			} else {
				$data = array();
			}	
			return $data;		
			
		} else {
			return false;
		}			
	
	}	

}