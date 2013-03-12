<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Lots extends REST_Controller {
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Lots_model');
	}


	public function index_get()
    {
        // Display all lots
        error_log('GET');
        error_log($this->get('latitude'));
        error_log($this->get('longitude'));
		$ret_lots = $this->get('max_lots');
		if($ret_lots == ""){
			$ret_lots =5;
		}
		/**
		error_log('ret_lots val: '.$ret_lots);
		if(!isset($ret_lots) || is_null($ret_lots)){
			error_log('Made it to IF: '.$ret_lots);
			$ret_lots = 5;
		}
		**/
		$this->response($this->Lots_model->closest_lots($this->get('latitude'),$this->get('longitude'), $ret_lots));
		
    }

    public function index_post()
    {
        // Create a new lot post
        error_log('POST');
        error_log($this->post('name'));
		error_log($this->post('fill'));
		
		$this->Lots_model->lot_update($this->post('name'), $this->post('fill'));
    }
	
	

}
?>