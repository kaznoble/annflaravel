<?php
use Illuminate\Support\Facades\Response;

class ContactOnlineController extends BaseController {

    public $module = 'Contact';

    public function __construct() {
        parent::__construct();
        $this->model = new ContactOnline();
        $this->info = $this->model->makeInfo($this->module);
        //$this->access = $this->model->validAccess($this->info['id']);
        $this->access = $this->model->validAccess(1);		
    }

    public function addContact(){
        $data = Input::all();

        //validation rules
        $rules = array();

        $msg = [];

        //server side validation
        $validator = Validator::make($data, $rules, $msg);

        if(!$validator->passes()){
            return Response::json(array('status' => 'ERROR', 'msg' => $validator->messages()->toArray()));
        }

        //final submited data
        $finaldata['contact_name'] = HTML::decode($data['name']);
        $finaldata['contact_address1'] = HTML::decode($data['address_1']);
        $finaldata['contact_address2'] = HTML::decode($data['address_2']);		
        $finaldata['contact_town'] = HTML::decode($data['town']);			
        $finaldata['contact_postcode'] = HTML::decode($data['postcode']);
		$finaldata['contact_method_contact'] = HTML::decode($data['method_contact']);				
		$finaldata['contact_like_contacted'] = HTML::decode($data['like_to_contacted']);						
        $finaldata['contact_telephone'] = HTML::decode($data['telephone']);				
        $finaldata['contact_message'] = HTML::decode($data['message']);
        $finaldata['contact_email'] = HTML::decode($data['email']);

		// Insert data to database
        $contact_id = $this->model->insertGetId($finaldata, NULL);

        if($contact_id && $contact_id > 0){
            return Response::json(array('status' => 'OK'));
        }else{
            return Response::json(array('status' => 'ERROR'));
        }
    }
}