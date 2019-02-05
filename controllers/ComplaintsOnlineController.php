<?php
use Illuminate\Support\Facades\Response;

class ComplaintsOnlineController extends BaseController {

    public $module = 'Complaints';

    public function __construct() {
        parent::__construct();
        $this->model = new ComplaintsOnline();
        $this->info = $this->model->makeInfo($this->module);
        $this->access = $this->model->validAccess($this->info['id']);
    }

    public function addComplaint(){
        $data = Input::all();

        //validation rules
        $rules = array(
            'name'=>'required|min:3',
            'address_1' => 'required|min:3',
            'pref_contact_method' => 'required|not_in:0',
            'like_to_contacted' => 'required|not_in:0'
        );

        $msg = [
            'name.required'=>'The name field is required.',
            'name.min'=>'The name field has min 3 character.',
            'address_1.required' => 'The address 1 field is required.',
            'address_1.min' => 'The address 1 field has min 3 character.',
            'pref_contact_method.required' => 'The Preferred contact method field is required.',
            'pref_contact_method.not_in' => 'The Preferred contact method field is required.',
            'like_to_contacted.not_in' => 'The like to be contacted field is required.',
            'like_to_contacted.required' => 'The like to be contacted field is required.'
        ];

        if($data['method'] == 'phone'){
            $rules['telephone_1'] = 'required|min:6';
            $msg['telephone_1.required'] = 'The telephone field is required.';
            $msg['telephone_1.min'] = 'The telephone field has min 6 number.';
        }else if($data['method'] == 'email'){
            $rules['email_address'] = 'required|email';
            $msg['email_address.required'] = 'The email field is required.';
            $msg['email_address.email'] = 'The email field is not valid format.';
        }

        //server side validation
        $validator = Validator::make($data, $rules, $msg);

        if(!$validator->passes()){
            return Response::json(array('status' => 'ERROR', 'msg' => $validator->messages()->toArray()));
        }

        //final submited data
        $finaldata['complaint_no'] = mt_rand(100000, 999999);
        $finaldata['customer_name'] = $data['name'];
        $finaldata['user_id'] = $data['user_id'];
        $finaldata['address_1'] = $data['address_1'];
        $finaldata['address_2'] = $data['address_2'];
        $finaldata['town'] = $data['town'];		
        $finaldata['postcode'] = $data['postcode'];
        $finaldata['telephone_1'] = $data['telephone_1'];
        $finaldata['email_address'] = $data['email_address'];
        $finaldata['pref_contact_method'] = $data['pref_contact_method'];
        $finaldata['complaint'] = $data['complaint'];
        $finaldata['complaint_status'] = '1';
        $finaldata['like_to_contacted'] = $data['like_to_contacted'];
        $finaldata['created_at'] = date('Y-m-d H:i:s');
        $finaldata['updated_at'] = date('Y-m-d H:i:s');

        //included serdgrid class for mail
        require_once(dirname(__FILE__) . "/../../../Classes/models/sendgrid.class.php");
        $sendgrid = new sendgrid();

        // Send Email To Customer about the new account creation using SendGrid Account.
        $Templete = Systemconfiguration::where('sys_id','811')->get();

        $Data = array('$firstname' => array($data['name']), '$surname' => array(), '$complaintNo' => array($finaldata['complaint_no']));
        $sendgrid->sendgrid_mail($Templete[0]->value,$Data,$data['email_address'],$data['name']);

        $complaint_id = $this->model->insertGetId($finaldata, NULL);

        if($complaint_id && $complaint_id > 0){
            return Response::json(array('status' => 'OK', 'complaint_no' => $finaldata['complaint_no']));
        }else{
            return Response::json(array('status' => 'ERROR'));
        }
    }
}