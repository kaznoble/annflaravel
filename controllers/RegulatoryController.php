<?php
class RegulatoryController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'regulatoryreports';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Regulatoryreports();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'regulatoryreports',
		);
        
	} 

	public function getIndex()
	{
        // Take param master detail if any
        $master  = $this->buildMasterDetail();
        // Build pager number and append current param GET

        // Group users permission
        $this->data['access']		= $this->access;
        // Detail from master if any
        $this->data['details']		= $master['masterView'];
        // Master detail link if any
        // Render into template
        $this->layout->nest('content','regulatory.index',$this->data)
            ->with('menus', SiteHelpers::menus());
    }

}