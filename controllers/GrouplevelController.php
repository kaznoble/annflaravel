<?php
class GrouplevelController extends BaseController {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'Grouplevel';
    static $per_page	= '10';

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Grouplevel();
        $this->info = $this->model->makeInfo( $this->module);
        $this->access = $this->model->validAccess($this->info['id']);

        /* $this->data = array(
            'pageTitle'	=> 	$this->info['title'],
            'pageNote'	=>  $this->info['note'],
            'pageModule'	=> 'Grouplevel',
        ); */

        //print_r($custDetails);die;

        $this->data = array('pageTitle'=>"Grouplevel",'pageNote'=>"Grouplevel");
    }

    public function getIndex()
    {
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

        // Get modules data
        $drop = DB::select("SELECT module_id,module_title FROM tb_module where module_name IN ('Customerdetails','CustomerComments','Complaints','Customerquotes','Systemconfiguration','regulatoryreports','Customermain','Customerdomestic','Customerrelative','Customeroutgoing','Customerincome','Paymenttranlog','Accounthistory','Customercreditors','customerweeklytotals','dailypayment','Cashonlypayments','accountonhold','adminround','adminroundedit','Grouplevel','Groupmanagement','Usermanagement','Customeraccounts','staffweeklytotals','RunSubmission','UploadSubmission','SubmissionHistory','accountsarrears','userauditlog')");
        $this->data['drop']= $drop;
        $row = DB::table('tb_module')->where('module_name',  'Customerdetails')->get();

        // Get page data
        $pagedropdownData = DB::table('tb_pages')
            ->select('*')
            ->whereIn('pageID', array(38,39,42,45))
            ->get();
        $this->data['pagedropdownData'] = $pagedropdownData;

        if(count($row) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }

        $row = $row[0];
        $this->data['row'] = $row;
        $this->data['module'] = $this->module;
        $this->data['module_name'] = $row->module_name;
        $config = SiteHelpers::CF_decode_json($row->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row)
            {
                $tasks[$row['item']] = $row['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row->module_id."' $group");
            if(count($GA) >=1){
                $GA = $GA[0];
            }

            $access_data = (isset($GA->access_data) ? json_decode($GA->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access[$r->name] = $rows;


        }
        $this->data['access'] = $access;
        $this->data['groups_access'] = DB::select("select * from tb_groups_access where module_id ='".$row->module_id."'");

        $row1 = DB::table('tb_module')->where('module_name',  'CustomerComments')->get();
        //print_r($row1);exit;

        if(count($row1) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row1 = $row1[0];
        $this->data['row1'] = $row1;
        $this->data['module1'] = $this->module;
        $this->data['module_name'] = $row1->module_name;
        $config = SiteHelpers::CF_decode_json($row1->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row1)
            {
                $tasks[$row1['item']] = $row1['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access1 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group1 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA1 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row1->module_id."' $group1");
            if(count($GA1) >=1){
                $GA1 = $GA1[0];
            }

            $access_data = (isset($GA1->access_data) ? json_decode($GA1->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access1[$r->name] = $rows;


        }
        $this->data['access1'] = $access1;
        $this->data['groups_access1'] = DB::select("select * from tb_groups_access where module_id ='".$row1->module_id."'");
        //echo "<pre>";
        //print_r($this->data);exit;
        //
        //
        $row2 = DB::table('tb_module')->where('module_name',  'Complaints')->get();
        //print_r($row2);exit;

        if(count($row2) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row2 = $row2[0];
        $this->data['row2'] = $row2;
        $this->data['module2'] = $this->module;
        $this->data['module_name'] = $row2->module_name;
        $config = SiteHelpers::CF_decode_json($row2->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row2)
            {
                $tasks[$row2['item']] = $row2['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access2 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group2 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA2 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row2->module_id."' $group2");
            if(count($GA2) >=1){
                $GA2 = $GA2[0];
            }

            $access_data = (isset($GA2->access_data) ? json_decode($GA2->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access2[$r->name] = $rows;


        }
        $this->data['access2'] = $access2;
        $this->data['groups_access2'] = DB::select("select * from tb_groups_access where module_id ='".$row2->module_id."'");

        //end of Customerquotes

        //complaints
        $row3 = DB::table('tb_module')->where('module_name',  'Customerquotes')->get();
        //print_r($row1);exit;

        if(count($row3) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row3 = $row3[0];
        $this->data['row3'] = $row3;
        $this->data['module3'] = $this->module;
        $this->data['module_name'] = $row3->module_name;
        $config = SiteHelpers::CF_decode_json($row3->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row3)
            {
                $tasks[$row3['item']] = $row3['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access3 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group3 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA3 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row3->module_id."' $group3");
            if(count($GA3) >=1){
                $GA3 = $GA3[0];
            }

            $access_data = (isset($GA3->access_data) ? json_decode($GA3->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access3[$r->name] = $rows;
        }
        $this->data['access3'] = $access3;
        $this->data['groups_access3'] = DB::select("select * from tb_groups_access where module_id ='".$row3->module_id."'");
        //end
        //systemconfiguration
        $row4 = DB::table('tb_module')->where('module_name',  'Systemconfiguration')->get();
        //print_r($row1);exit;

        if(count($row4) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row4 = $row4[0];
        $this->data['row4'] = $row4;
        $this->data['module4'] = $this->module;
        $this->data['module_name'] = $row4->module_name;
        $config = SiteHelpers::CF_decode_json($row4->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row4)
            {
                $tasks[$row4['item']] = $row4['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access4 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group4 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA4 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row4->module_id."' $group4");
            if(count($GA4) >=1){
                $GA4 = $GA4[0];
            }

            $access_data = (isset($GA4->access_data) ? json_decode($GA4->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access4[$r->name] = $rows;
        }
        $this->data['access4'] = $access4;
        $this->data['groups_access4'] = DB::select("select * from tb_groups_access where module_id ='".$row4->module_id."'");
        //end
        //Regulatoryreports
        $row5 = DB::table('tb_module')->where('module_name',  'regulatoryreports')->get();
        //print_r($row1);exit;

        if(count($row5) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row5 = $row5[0];
        $this->data['row5'] = $row5;
        $this->data['module5'] = $this->module;
        $this->data['module_name'] = $row5->module_name;
        $config = SiteHelpers::CF_decode_json($row5->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row5)
            {
                $tasks[$row5['item']] = $row5['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access5 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group5 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA5 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row5->module_id."' $group5");
            if(count($GA5) >=1){
                $GA5 = $GA5[0];
            }

            $access_data = (isset($GA5->access_data) ? json_decode($GA5->access_data,true) : array());

            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access5[$r->name] = $rows;
        }
        //print_r($access5); die("vfd");
        $this->data['access5'] = $access5;
        $this->data['groups_access5'] = DB::select("select * from tb_groups_access where module_id ='".$row5->module_id."'");
        //end
        //customermain
        $row6 = DB::table('tb_module')->where('module_name',  'Customermain')->get();


        if(count($row6) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }


        $row6 = $row6[0];
        $this->data['row6'] = $row6;
        $this->data['module6'] = $this->module;
        $this->data['module_name'] = $row6->module_name;
        $config = SiteHelpers::CF_decode_json($row6->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row6)
            {
                $tasks[$row6['item']] = $row6['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access6 = array();
        foreach($this->data['groups'] as $r)
        {
            //	$GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group6 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA6 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row6->module_id."' $group6");
            if(count($GA6) >=1){
                $GA6 = $GA6[0];
            }

            $access_data = (isset($GA6->access_data) ? json_decode($GA6->access_data,true) : array());

            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access6[$r->name] = $rows;
        }

        $this->data['access6'] = $access6;
        $this->data['groups_access6'] = DB::select("select * from tb_groups_access where module_id ='".$row6->module_id."'");

        //customerdomestic module
        $row7 = DB::table('tb_module')->where('module_name',  'Customerdomestic')->get();
        if(count($row7) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row);exit;

        $row7 = $row7[0];
        $this->data['row7'] = $row7;
        $this->data['module7'] = $this->module;
        $this->data['module_name'] = $row7->module_name;
        $config = SiteHelpers::CF_decode_json($row7->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row7)
            {
                $tasks[$row7['item']] = $row7['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access7 = array();
        foreach($this->data['groups'] as $r)
        {
            $group7 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA7 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row7->module_id."' $group7");
            if(count($GA7) >=1){
                $GA7 = $GA7[0];
            }

            $access_data = (isset($GA7->access_data) ? json_decode($GA7->access_data,true) : array());
            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access7[$r->name] = $rows;
        }
        $this->data['access7'] = $access7;
        $this->data['groups_access7'] = DB::select("select * from tb_groups_access where module_id ='".$row7->module_id."'");
        //end
        //Customerrelative
        $row8 = DB::table('tb_module')->where('module_name',  'Customerrelative')->get();
        if(count($row8) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        //print_r($row8);exit;

        $row8 = $row8[0];
        $this->data['row8'] = $row8;
        $this->data['module8'] = $this->module;
        $this->data['module_name'] = $row8->module_name;
        $config = SiteHelpers::CF_decode_json($row8->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row8)
            {
                $tasks[$row8['item']] = $row8['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access8 = array();
        foreach($this->data['groups'] as $r)
        {
            $group8 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA8 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row8->module_id."' $group8");
            if(count($GA8) >=1){
                $GA8 = $GA8[0];
            }

            $access_data = (isset($GA8->access_data) ? json_decode($GA8->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access8[$r->name] = $rows;
        }
        $this->data['access8'] = $access8;
        $this->data['groups_access8'] = DB::select("select * from tb_groups_access where module_id ='".$row8->module_id."'");
        //end customerrelative
        //Customeroutgoing
        $row9 = DB::table("tb_module")->where('module_name' ,"Customeroutgoing")->get();
        if(count($row9)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row9 = $row9[0];
        $this->data['row9'] = $row9;
        $this->data['module9'] = $this->module;
        $this->data['module_name'] = $row9->module_name;
        $config = SiteHelpers::CF_decode_json($row9->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row9)
            {
                $tasks[$row9['item']] = $row9['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access9 = array();
        foreach($this->data['groups'] as $r)
        {
            $group9 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA9 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row9->module_id."' $group9");
            if(count($GA9) >=1){
                $GA9 = $GA9[0];
            }

            $access_data = (isset($GA9->access_data) ? json_decode($GA9->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access9[$r->name] = $rows;
        }
        $this->data['access9'] = $access9;
        $this->data['groups_access9'] = DB::select("select * from tb_groups_access where module_id ='".$row9->module_id."'");
        //end
        //Customerincome
        $row10 = DB::table("tb_module")->where('module_name' ,"Customerincome")->get();
        if(count($row10)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row10 = $row10[0];
        $this->data['row10'] = $row10;
        $this->data['module10'] = $this->module;
        $this->data['module_name'] = $row10->module_name;
        $config = SiteHelpers::CF_decode_json($row10->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row10)
            {
                $tasks[$row10['item']] = $row10['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access10 = array();
        foreach($this->data['groups'] as $r)
        {
            $group10 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA10 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row10->module_id."' $group10");
            if(count($GA10) >=1){
                $GA10 = $GA10[0];
            }

            $access_data = (isset($GA10->access_data) ? json_decode($GA10->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access10[$r->name] = $rows;
        }
        $this->data['access10'] = $access10;
        $this->data['groups_access10'] = DB::select("select * from tb_groups_access where module_id ='".$row10->module_id."'");
        //end
        //paymenttranslog
        $row11 = DB::table('tb_module')->where('module_name','Paymenttranlog')->get();
        if(count($row11)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row11 = $row11[0];
        $this->data['row11'] = $row11;
        $this->data['module11'] = $this->module;
        $this->data['module_name'] = $row11->module_name;
        $config = SiteHelpers::CF_decode_json($row11->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row11)
            {
                $tasks[$row11['item']] = $row11['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access11 = array();
        foreach($this->data['groups'] as $r)
        {
            $group11 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA11 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row11->module_id."' $group11");
            if(count($GA11) >=1){
                $GA11 = $GA11[0];
            }

            $access_data = (isset($GA11->access_data) ? json_decode($GA11->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access11[$r->name] = $rows;
        }
        $this->data['access11'] = $access11;
        $this->data['groups_access11'] = DB::select("select * from tb_groups_access where module_id ='".$row11->module_id."'");
        //end
        //Accounthistory
        $row12 = DB::table('tb_module')->where('module_name','Accounthistory')->get();
        if(count($row12)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row12 = $row12[0];
        $this->data['row12'] = $row12;
        $this->data['module12'] = $this->module;
        $this->data['module_name'] = $row12->module_name;
        $config = SiteHelpers::CF_decode_json($row12->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row12)
            {
                $tasks[$row12['item']] = $row12['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access12 = array();


        foreach($this->data['groups'] as $r)
        {
            $group12 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA12 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row12->module_id."' $group12");
            if(count($GA12) >=1){
                $GA12 = $GA12[0];
            }

            $access_data = (isset($GA12->access_data) ? json_decode($GA12->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access12[$r->name] = $rows;
        }
        $this->data['access12'] = $access12;
        $this->data['groups_access12'] = DB::select("select * from tb_groups_access where module_id ='".$row12->module_id."'");
        //end
        //customercreditor
        $row13 = DB::table('tb_module')->where('module_name','Customercreditors')->get();
        if(count($row13)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row13 = $row13[0];
        $this->data['row13'] = $row13;
        $this->data['module13'] = $this->module;
        $this->data['module_name'] = $row13->module_name;
        $config = SiteHelpers::CF_decode_json($row13->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row13)
            {
                $tasks[$row13['item']] = $row13['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access13 = array();


        foreach($this->data['groups'] as $r)
        {
            $group13 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA13 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row13->module_id."' $group13");
            if(count($GA13) >=1){
                $GA13 = $GA13[0];
            }
            $access_data = (isset($GA13->access_data) ? json_decode($GA13->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access13[$r->name] = $rows;
        }
        $this->data['access13'] = $access13;
        $this->data['groups_access13'] = DB::select("select * from tb_groups_access where module_id ='".$row13->module_id."'");
        //end
        //users
        $row14 = DB::table('tb_module')->where('module_name','customerweeklytotals')->get();
        if(count($row14)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row14 = $row14[0];
        $this->data['row14'] = $row14;
        $this->data['module14'] = $this->module;
        $this->data['module_name'] = $row14->module_name;
        $config = SiteHelpers::CF_decode_json($row14->module_config);

        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row14)
            {
                $tasks[$row14['item']] = $row14['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access14 = array();


        foreach($this->data['groups'] as $r)
        {
            $group14 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA14 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row14->module_id."' $group14");
            if(count($GA14) >=1){
                $GA14 = $GA14[0];
            }
            $access_data = (isset($GA14->access_data) ? json_decode($GA14->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access14[$r->name] = $rows;
        }
        $this->data['access14'] = $access14;
        $this->data['groups_access14'] = DB::select("select * from tb_groups_access where module_id ='".$row14->module_id."'");
        //end
        //Dailypaymentlog
        $row15 = DB::table('tb_module')->where('module_name','dailypayment')->get();
        if(count($row15)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row15 = $row15[0];
        $this->data['row15'] = $row15;
        $this->data['module15'] = $this->module;
        $this->data['module_name'] = $row15->module_name;
        $config = SiteHelpers::CF_decode_json($row15->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row15)
            {
                $tasks[$row15['item']] = $row15['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access15 = array();


        foreach($this->data['groups'] as $r)
        {
            $group15 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA15 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row15->module_id."' $group15");
            if(count($GA15) >=1){
                $GA15 = $GA15[0];
            }
            $access_data = (isset($GA15->access_data) ? json_decode($GA15->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access15[$r->name] = $rows;
        }
        $this->data['access15'] = $access15;
        $this->data['groups_access15'] = DB::select("select * from tb_groups_access where module_id ='".$row15->module_id."'");
        //end
        //cashonlypayments
        $row16 = DB::table('tb_module')->where('module_name','Cashonlypayments')->get();
        if(count($row16)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row16 = $row16[0];
        $this->data['row16'] = $row16;
        $this->data['module16'] = $this->module;
        $this->data['module_name'] = $row16->module_name;
        $config = SiteHelpers::CF_decode_json($row16->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row16)
            {
                $tasks[$row16['item']] = $row16['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access16 = array();


        foreach($this->data['groups'] as $r)
        {
            $group16 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA16 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row16->module_id."' $group16");
            if(count($GA16) >=1){
                $GA16 = $GA16[0];
            }
            $access_data = (isset($GA16->access_data) ? json_decode($GA16->access_data,true) : array());
            $rows = array();

            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access16[$r->name] = $rows;
        }
        $this->data['access16'] = $access16;
        $this->data['groups_access16'] = DB::select("select * from tb_groups_access where module_id ='".$row16->module_id."'");
        //end

        //start
        $row17 = DB::table('tb_module')->where('module_name','accountonhold')->get();
        if(count($row17)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row17 = $row17[0];
        $this->data['row17'] = $row17;
        $this->data['module17'] = $this->module;
        $this->data['module_name'] = $row17->module_name;
        $config = SiteHelpers::CF_decode_json($row17->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row17)
            {
                $tasks[$row17['item']] = $row17['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access17 = array();


        foreach($this->data['groups'] as $r)
        {
            $group17 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA17 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row17->module_id."' $group17");
            if(count($GA17) >=1){
                $GA17 = $GA17[0];
            }
            $access_data = (isset($GA17->access_data) ? json_decode($GA17->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access17[$r->name] = $rows;
        }
        $this->data['access17'] = $access17;
        $this->data['groups_access17'] = DB::select("select * from tb_groups_access where module_id ='".$row17->module_id."'");
        //end of account hold module

        //start
        $row18 = DB::table('tb_module')->where('module_name','adminround')->get();
        if(count($row18)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row18 = $row18[0];
        $this->data['row18'] = $row18;
        $this->data['module18'] = $this->module;
        $this->data['module_name'] = $row18->module_name;
        $config = SiteHelpers::CF_decode_json($row18->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row18)
            {
                $tasks[$row18['item']] = $row18['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access18 = array();

        foreach($this->data['groups'] as $r)
        {
            $group18 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA18 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row18->module_id."' $group18");
            if(count($GA18) >=1){
                $GA18 = $GA18[0];
            }
            $access_data = (isset($GA18->access_data) ? json_decode($GA18->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access18[$r->name] = $rows;
        }
        $this->data['access18'] = $access18;
        $this->data['groups_access18'] = DB::select("select * from tb_groups_access where module_id ='".$row18->module_id."'");
        //end of account hold module

        //start
        $row19 = DB::table('tb_module')->where('module_name','adminroundedit')->get();
        if(count($row19)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row19 = $row19[0];
        $this->data['row19'] = $row19;
        $this->data['module19'] = $this->module;
        $this->data['module_name'] = $row19->module_name;
        $config = SiteHelpers::CF_decode_json($row19->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row19)
            {
                $tasks[$row19['item']] = $row19['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access19 = array();


        foreach($this->data['groups'] as $r)
        {
            $group19 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA19 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row19->module_id."' $group19");
            if(count($GA19) >=1){
                $GA19 = $GA19[0];
            }
            $access_data = (isset($GA19->access_data) ? json_decode($GA19->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access19[$r->name] = $rows;
        }
        $this->data['access19'] = $access19;
        $this->data['groups_access19'] = DB::select("select * from tb_groups_access where module_id ='".$row19->module_id."'");
        //end of account hold module

        //start
        $row20 = DB::table('tb_module')->where('module_name','Grouplevel')->get();
        if(count($row20)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row20 = $row20[0];
        $this->data['row20'] = $row20;
        $this->data['module20'] = $this->module;
        $this->data['module_name'] = $row20->module_name;
        $config = SiteHelpers::CF_decode_json($row20->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row20)
            {
                $tasks[$row20['item']] = $row20['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access20 = array();


        foreach($this->data['groups'] as $r)
        {
            $group20 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA20 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row20->module_id."' $group20");
            if(count($GA20) >=1){
                $GA20 = $GA20[0];
            }
            $access_data = (isset($GA20->access_data) ? json_decode($GA20->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access20[$r->name] = $rows;
        }
        $this->data['access20'] = $access20;
        $this->data['groups_access20'] = DB::select("select * from tb_groups_access where module_id ='".$row20->module_id."'");
        //end of account hold module

        //start
        $row21 = DB::table('tb_module')->where('module_name','Groupmanagement')->get();
        if(count($row21)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row21 = $row21[0];
        $this->data['row21'] = $row21;
        $this->data['module21'] = $this->module;
        $this->data['module_name'] = $row21->module_name;
        $config = SiteHelpers::CF_decode_json($row21->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row21)
            {
                $tasks[$row21['item']] = $row21['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access21 = array();


        foreach($this->data['groups'] as $r)
        {
            $group21 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA21 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row21->module_id."' $group21");
            if(count($GA21) >=1){
                $GA21 = $GA21[0];
            }
            $access_data = (isset($GA21->access_data) ? json_decode($GA21->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access21[$r->name] = $rows;
        }
        $this->data['access21'] = $access21;
        $this->data['groups_access21'] = DB::select("select * from tb_groups_access where module_id ='".$row21->module_id."'");
        //end of account hold module

        //start
        $row22 = DB::table('tb_module')->where('module_name','Usermanagement')->get();
        if(count($row22)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row22 = $row22[0];
        $this->data['row22'] = $row22;
        $this->data['module22'] = $this->module;
        $this->data['module_name'] = $row22->module_name;
        $config = SiteHelpers::CF_decode_json($row22->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row22)
            {
                $tasks[$row22['item']] = $row22['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access22 = array();


        foreach($this->data['groups'] as $r)
        {
            $group22 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA22 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row22->module_id."' $group22");
            if(count($GA22) >=1){
                $GA22 = $GA22[0];
            }
            $access_data = (isset($GA22->access_data) ? json_decode($GA22->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access22[$r->name] = $rows;
        }
        $this->data['access22'] = $access22;
        $this->data['groups_access22'] = DB::select("select * from tb_groups_access where module_id ='".$row22->module_id."'");
        //end of account hold module

        //start
        $row23 = DB::table('tb_module')->where('module_name','Customeraccounts')->get();
        if(count($row23)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row23 = $row23[0];
        $this->data['row23'] = $row23;
        $this->data['module23'] = $this->module;
        $this->data['module_name'] = $row23->module_name;
        $config = SiteHelpers::CF_decode_json($row23->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row23)
            {
                $tasks[$row23['item']] = $row23['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access23 = array();


        foreach($this->data['groups'] as $r)
        {
            $group23 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA23 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row23->module_id."' $group23");
            if(count($GA23) >=1){
                $GA23 = $GA23[0];
            }
            $access_data = (isset($GA23->access_data) ? json_decode($GA23->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access23[$r->name] = $rows;
        }
        $this->data['access23'] = $access23;
        $this->data['groups_access23'] = DB::select("select * from tb_groups_access where module_id ='".$row23->module_id."'");
        //end of account hold module
		
        //start
        $row24 = DB::table('tb_module')->where('module_name','staffweeklytotals')->get(); 
        if(count($row24)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row24 = $row24[0];
        $this->data['row24'] = $row24;
        $this->data['module24'] = $this->module;
        $this->data['module_name'] = $row24->module_name;
        $config = SiteHelpers::CF_decode_json($row24->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row24)
            {
                $tasks[$row24['item']] = $row24['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access24 = array();


        foreach($this->data['groups'] as $r)
        {
            $group24 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA24 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row24->module_id."' $group24");
            if(count($GA24) >=1){
                $GA24 = $GA24[0];
            }
            $access_data = (isset($GA24->access_data) ? json_decode($GA24->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access24[$r->name] = $rows;
        }
        $this->data['access24'] = $access24;
        $this->data['groups_access24'] = DB::select("select * from tb_groups_access where module_id ='".$row24->module_id."'");
        //end of account hold module		
        //start
        $row25 = DB::table('tb_module')->where('module_name','RunSubmission')->get(); 
        if(count($row25)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row25 = $row25[0];
        $this->data['row25'] = $row25;
        $this->data['module25'] = $this->module;
        $this->data['module_name'] = $row25->module_name;
        $config = SiteHelpers::CF_decode_json($row25->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row25)
            {
                $tasks[$row25['item']] = $row25['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access25 = array();


        foreach($this->data['groups'] as $r)
        {
            $group25 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA25 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row25->module_id."' $group25");
            if(count($GA25) >=1){
                $GA25 = $GA25[0];
            }
            $access_data = (isset($GA25->access_data) ? json_decode($GA25->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access25[$r->name] = $rows;
        }
        $this->data['access25'] = $access25;
        $this->data['groups_access25'] = DB::select("select * from tb_groups_access where module_id ='".$row25->module_id."'");
        //end of account hold module			
		//start
        $row26 = DB::table('tb_module')->where('module_name','UploadSubmission')->get(); 
        if(count($row26)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row26 = $row26[0];
        $this->data['row26'] = $row26;
        $this->data['module26'] = $this->module;
        $this->data['module_name'] = $row26->module_name;
        $config = SiteHelpers::CF_decode_json($row26->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row26)
            {
                $tasks[$row26['item']] = $row26['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access26 = array();


        foreach($this->data['groups'] as $r)
        {
            $group26 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA26 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row26->module_id."' $group26");
            if(count($GA26) >=1){
                $GA26 = $GA26[0];
            }
            $access_data = (isset($GA26->access_data) ? json_decode($GA26->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access26[$r->name] = $rows;
        }
        $this->data['access26'] = $access26;
        $this->data['groups_access26'] = DB::select("select * from tb_groups_access where module_id ='".$row26->module_id."'");
        //end of account hold module	
        //start
        $row27 = DB::table('tb_module')->where('module_name','SubmissionHistory')->get(); 
        if(count($row27)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row27 = $row27[0];
        $this->data['row27'] = $row27;
        $this->data['module27'] = $this->module;
        $this->data['module_name'] = $row27->module_name;
        $config = SiteHelpers::CF_decode_json($row27->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row27)
            {
                $tasks[$row27['item']] = $row27['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access27 = array();


        foreach($this->data['groups'] as $r)
        {
            $group27 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA27 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row27->module_id."' $group27");
            if(count($GA27) >=1){
                $GA27 = $GA27[0];
            }
            $access_data = (isset($GA27->access_data) ? json_decode($GA27->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access27[$r->name] = $rows;
        }
        $this->data['access27'] = $access27;
        $this->data['groups_access27'] = DB::select("select * from tb_groups_access where module_id ='".$row27->module_id."'");
        //end of account hold module			
		
        //start
        $row28 = DB::table('tb_module')->where('module_name','accountsarrears')->get(); 
        if(count($row28)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row28 = $row28[0];
        $this->data['row28'] = $row28;
        $this->data['module28'] = $this->module;
        $this->data['module_name'] = $row28->module_name;
        $config = SiteHelpers::CF_decode_json($row28->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row28)
            {
                $tasks[$row28['item']] = $row28['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access28 = array();


        foreach($this->data['groups'] as $r)
        {
            $group28 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA28 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row28->module_id."' $group28");
            if(count($GA28) >=1){
                $GA28 = $GA28[0];
            }
            $access_data = (isset($GA28->access_data) ? json_decode($GA28->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access28[$r->name] = $rows;
        }
        $this->data['access28'] = $access28;
        $this->data['groups_access28'] = DB::select("select * from tb_groups_access where module_id ='".$row28->module_id."'");
        //end of account hold module					
		
        //start
        $row29 = DB::table('tb_module')->where('module_name','userauditlog')->get(); 
        if(count($row29)<=0)
        {
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row29 = $row29[0];
        $this->data['row29'] = $row29;
        $this->data['module29'] = $this->module;
        $this->data['module_name'] = $row29->module_name;
        $config = SiteHelpers::CF_decode_json($row29->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row29)
            {
                $tasks[$row29['item']] = $row29['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['groups'] = DB::table('tb_groups')->get();

        $access29 = array();


        foreach($this->data['groups'] as $r)
        {
            $group29 = ($r->group_id !=null ? "and group_id ='".$r->group_id."'" : "" );
            $GA29 = DB::select("SELECT * FROM tb_groups_access where module_id ='".$row29->module_id."' $group29");
            if(count($GA29) >=1){
                $GA29 = $GA29[0];
            }
            $access_data = (isset($GA29->access_data) ? json_decode($GA29->access_data,true) : array());
            $rows = array();
            $rows['group_id'] = $r->group_id;
            $rows['group_name'] = $r->name;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access29[$r->name] = $rows;
        }
        $this->data['access29'] = $access29;
        $this->data['groups_access29'] = DB::select("select * from tb_groups_access where module_id ='".$row29->module_id."'");
        //end of account hold module					

        $this->layout->nest('content','Grouplevel.index',$this->data)
            ->with('menus', SiteHelpers::menus());

    }




    function postSave( $id = 0)
    {
        $i=0; $j=1;
        $id = Input::get('module_id');
        $row = DB::table('tb_module')->where('module_id', $id)
            ->get();
        $data_access = DB::select("select access_data from tb_groups_access where module_id ='$id'");
        foreach($data_access as $r)
        {
            $this->data['Detail_access'][$i] = json_decode($r->access_data);
            $i++;
        }

        if(count($row) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find module'));
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = SiteHelpers::CF_decode_json($row->module_config);
        $tasks = array(

            'is_view'		=> 'View ',
            'is_detail'		=> 'Detail',
            'is_add'		=> 'Add ',
            'is_edit'		=> 'Edit ',
            'is_remove'		=> 'Remove ',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row)
            {
                $tasks[$row['item']] = $row['title'];
            }
        }

        $permission = array();
        $groupID = Input::get('group_id');
        for($i=0;$i<count($groupID); $i++)
        {
            // remove current group_access
            $group_id = $groupID[$i];
            //DB::table('tb_groups_access')
            //				  ->where('module_id','=',Input::get('module_id'))
            //				  ->where('group_id','=',$group_id)
            //				  ->delete();

            $arr = array();
            $id = $groupID[$i];
            $arr['is_global']=1;
            foreach($tasks as $t=>$v)
            {
                $arr[$t] = (isset($_POST[$t][$id]) ? "1" : "0" );

            }
            if($arr['is_view'] == 1)
            {
                $arr['is_detail']=1;
                $arr['is_add']=1;
                $arr['is_edit']=1;
                $arr['is_remove']=1;
                $arr['is_excel']=1;
            }
            else
            {
                $arr['is_detail']=0;
                $arr['is_add']=0;
                $arr['is_edit']=0;
                $arr['is_remove']=0;
                $arr['is_excel']=0;
            }

            $permissions = json_encode($arr);

            $data = array
            (
                "access_data"	=> $permissions,
                "module_id"		=> Input::get('module_id'),
                "group_id"		=> $groupID[$i],
            );

            $rows = DB::table('tb_groups_access')->where('module_id', Input::get('module_id'))->where('group_id',$groupID[$i])->get();
            //print_r($rows); exit;
            if(count($rows)>0){
                DB::table('tb_groups_access')->where('module_id', Input::get('module_id'))->where('group_id',$groupID[$i])->update(['access_data'=>$permissions]);
            }else{
                DB::table('tb_groups_access')->insert($data);
            }


            $j++;
        }

        //exit;
        return Redirect::to('Grouplevel')->with('message', SiteHelpers::alert('success','Saved Successfully'));
    }

    function postPagesave($id = 0)
    {
        $i=0; $j=1;
        $pageId = Input::get('page_id');
        $row = DB::table('tb_pages')->where('pageID', $pageId)
            ->get();

        $data_access = (array)$row;

        foreach($data_access as $r)
        {
            $this->data['Detail_access'][$i] = json_decode($r->access);
            $i++;
        }

        if(count($row) <= 0){
            return Redirect::to('/Grouplevel')
                ->with('message', SiteHelpers::alert('error','Can not find page'));
        }
        $row = $row[0];

        $this->data['row'] = $row;

        $tasks = array(

            '1'		=> 'is_view',
            '2'		=> 'is_detail',
            '3'		=> 'is_add',
            '4'		=> 'is_edit',
            '5'		=> 'is_remove',

        );
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */

        $arr = array();

        $postValue = Input::all();

        $groupData = DB::table('tb_groups')->get(['group_id', 'name']);		

        $i = 1;
        foreach($groupData as $key=>$v)
        {
            //$arr[$i++] = (isset($postValue[$v->name]) ? "1" : "0" );
            $arr[$v->group_id] = (isset($postValue[$v->name]) ? "1" : "0" );			
        }


        /*foreach($groupData as $key => $group)
        {
            $arr[$key] = (isset($group['name']) ? "1" : "0" );

        }*/
        /*if(Input::get('check_all') == 1)
        {
            $arr['1']=1;
            $arr['2']=1;
            $arr['3']=1;
            $arr['4']=1;
            $arr['5']=1;
        }
        else
        {
            $arr['1']=0;
            $arr['2']=0;
            $arr['3']=0;
            $arr['4']=0;
            $arr['5']=0;
        }*/

        $permissions = json_encode($arr);

        $rows = DB::table('tb_pages')->where('pageID', $pageId)->get();

        if(count($rows)>0){
            DB::table('tb_pages')->where('pageID', $pageId)->update(['access'=>$permissions,'allow_guest' => 0]);
        }

        return Redirect::to('Grouplevel')->with('message', SiteHelpers::alert('success','Saved Successfully'));
    }

    public function postDestroy()
    {
        $session_id = Session::get('session_id');

        if($this->access['is_remove'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        // delete multipe rows
        $this->model->destroy(Input::get('id'));
        $this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successful");
        // redirect
        Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));

        if( !empty($session_id) )
        {
            return Redirect::to('Customeraccounts?search=customer_no:'.Session::get('session_id'));
        }
        else
        {
            return Redirect::to('Customeraccounts');
        }
    }

    // check account number
    public function searchacc($searchAcc)
    {
        $data = Input::all();
        $result = DB::table('customer_accounts')->where('account_no', 'like', '%'.$searchAcc.'%')->first();
        //print_r($result);die();
        if(count($result)>0)
        {
            return count($result);
        }
        else
        {
            return 0;
        }
    }

}
