<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Parchmeet extends CI_Controller {

	function __construct(){
		parent::__construct();

	}
	
	function index()
	{
		$data = array('title' => "Parchmeet", 'main_content' => 'home_view');
		$this->load->view('template', $data);
	}
	

}
