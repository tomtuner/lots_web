<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Lots extends REST_Controller {
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Lots_model');
	}


	function index_get()
    {
        // Display all lots
        error_log('GET');
        error_log($this->get('latitude'));
        error_log($this->get('longitude'));
		$ret_lots = $this->get('max_lots');
		if($ret_lots == ""){
			$ret_lots =5;
		}
		$this->response($this->Lots_model->closest_lots($this->get('latitude'),$this->get('longitude'), $ret_lots));
		
    }

    function index_post()
    {
        // Create a new lot post (check-in)
        error_log('POST');
        error_log($this->post('lot_id'));
		error_log($this->post('fill'));
		$sender = $this->post('name');
		if($sender == ""){
			$sender ="anonymous";
		}
		if ($this->post('lot_id') && $this->post('fill'))
		{
			if ($this->Lots_model->lot_update($this->post('lot_id'), $this->post('fill'), $sender))
			{
				// Success!
				//$this->response(200);
			}
		}
    }
	
	function create_post()
	{
		error_log('CREATE POST');
		if ($this->post('latitude') && $this->post('longitude') && $this->post('name'))
		{
			error_log('Valid Parameters');
			$this->Lots_model->create_lot($this->post('latitude'), $this->post('longitude'), $this->post('name'));
		}
	}
}
?>