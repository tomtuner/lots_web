<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setup extends CI_Controller {

	function __construct(){
		parent::__construct();

	}
	
	function index()
	{
		$data = array('title' => "Setup", 'main_content' => 'setup_view');
		$this->load->view('template', $data);
	}
	

}