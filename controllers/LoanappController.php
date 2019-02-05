<?php

use Illuminate\Support\Facades\Request;

class LoanappController extends BaseController {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'loanapp';
    static $per_page	= '30';

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Loanapp();
        $this->info = $this->model->makeInfo( $this->module);
        $this->access = $this->model->validAccess($this->info['id']);

        $this->data = array(
            'pageTitle'	=> 	$this->info['title'],
            'pageNote'	=>  $this->info['note'],
            'pageModule'	=> 'loanapp',
        );
    }


    public function getIndex()
    {
        if($this->access['is_view'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

        // Filter sort and order for query
        $sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'app_primary_id');
        $order = (!is_null(Input::get('order')) ? Input::get('order') : 'desc');
        // End Filter sort and order for query
        // Filter Search for query

        $filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
        // End Filter Search for query

        // Take param master detail if any
        $master  = $this->buildMasterDetail();

        // append to current $filter
        $filter .=  $master['masterFilter'];



        $page = Input::get('page', 1);
        $params = array(
            'page'		=> $page ,
            'limit'		=> (!is_null(Input::get('rows')) ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
            'sort'		=> $sort ,
            'order'		=> $order,
            'params'	=> $filter,
            'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query
        $results = $this->model->getRows( $params );

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);


        $this->data['rowData']		= $results['rows'];
        // Build Pagination
        $this->data['pagination']	= $pagination;
        // Build pager number and append current param GET
        $this->data['pager'] 		= $this->injectPaginate();
        // Row grid Number
        $this->data['i']			= ($page * $params['limit'])- $params['limit'];
        // Grid Configuration
        $this->data['tableGrid'] 	= $this->info['config']['grid'];
        $this->data['tableForm'] 	= $this->info['config']['forms'];
        $this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);
        // Group users permission
        $this->data['access']		= $this->access;
        // Detail from master if any
        $this->data['details']		= $master['masterView'];
        // Master detail link if any
        $this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        $this->data['title_array'] = ['0'=>'-', '1'=>'Mr','2'=>'Mrs','3'=>'Miss','4'=>'Ms','5'=>'Dr','6'=>'Professor'];
        $this->data['marita_status'] = ['1'=>'Married','2'=>'Single','3'=>'Separated','4'=>'Divorced','5'=>'partner','6'=>'Widowed','7'=>'Other'];
        $this->data['contribution_relationship'] = ['0' => '-', '1'=>'Father','2'=>'Mother', '3'=>'Brother','4'=>'Sister', '5'=> 'Other'];
        $this->data['ccj'] = ['0' => '-', '1'=>'No','2'=>'Yes'];
        $this->data['employment_status'] = ['0'=>'-','1'=>'Employed - Full-time','2'=>'Employed - Part-time','3'=>'Employed - Temporary','4'=>'Un-employed','5'=>'Self Employed','6'=>'Student','7'=>'Home maker','8'=>'Retired','9'=>'On Benefits','10'=>'Armed Forces'];
        $this->data['home_status'] = ['0'=>'-','O'=>'Owner occupier','L'=>'Living with Parents','T'=>'Tenant','C'=>'Council Tenant','J'=>'Joint Owner','X'=>'Other'];
        $this->layout->nest('content','loanapp.index',$this->data)
            ->with('menus', SiteHelpers::menus());
    }


    function getAdd( $id = null)
    {

        if($id =='')
        {
            if($this->access['is_add'] ==0 )
                return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        }

        if($id !='')
        {
            if($this->access['is_edit'] ==0 )
                return Redirect::to('')->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        }

        $id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;

        $row = $this->model->find($id);

        if($row)
        {
            $this->data['row'] =  $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('customer_loan_application_primary');
        }
        $this->data['id'] = $id;
        $this->layout->nest('content','loanapp.form',$this->data)->with('menus', $this->menus );
    }

    function getShow( $id = null)
    {

        if($this->access['is_detail'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

        $ids = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
        $row = $this->model->getRow($ids);
        if($row)
        {
            $this->data['row'] =  $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('customer_loan_application_primary');
        }
        $this->data['id'] = $id;
        $this->data['access']		= $this->access;
        $this->layout->nest('content','loanapp.view',$this->data)->with('menus', $this->menus );
    }

    function postSave( $id =0)
    {

        $rules = array(

        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('customer_loan_application_primary');
            $ID = $this->model->insertRow($data , Input::get('app_primary_id'));
            // Input logs
            if( Input::get('app_primary_id') =='')
            {
                $this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
            } else {
                $this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
            }
            // Redirect after save
            return Redirect::to('loanapp')->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return Redirect::to('loanapp/add/'.$id)->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
                ->withErrors($validator)->withInput();
        }

    }

    public function postDestroy()
    {

        if($this->access['is_remove'] ==0)
            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));
        // delete multipe rows
        $this->model->destroy(Input::get('id'));
        $this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
        // redirect
        Session::flash('message', SiteHelpers::alert('success',Lang::get('core.note_success_delete')));
        return Redirect::to('loanapp');
    }

    public function loanapp_update(){
        $app_primery_id = Input::get('app_primary_id');
        $admin_view = Input::get('admin_view');
        $successful_applicant = Input::get('successful_applicant');
        $processed = Input::get('processed');
        $reason = Input::get('reason');
        if(isset($admin_view)){
            return $this->model->update_loanapp($app_primery_id,'admin_view',$admin_view);
        }elseif(isset($successful_applicant)){
            return $this->model->update_loanapp($app_primery_id,'successful_applicant',$successful_applicant);
        }elseif(isset($processed)){
            return $this->model->update_loanapp($app_primery_id,'processed',$processed);
        }elseif(isset($reason)){
            return $this->model->update_loanapp($app_primery_id,'reason',$reason);
        }else{
            return false;
        }
    }

}