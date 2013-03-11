<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Join extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Document_model');
	}

	function index()
	{
		$data = array('title' => "Join Meeting", 'main_content' => 'join_code_view');
		$this->load->view('template', $data);
	}
	
	function form_meeting_code_submitted() {
		$this->load->library('form_validation');
				
		$this->form_validation->set_rules('meeting_password', 'Meeting Password', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) {
		
			// Hasn't been run or validation errors
			$data = array('title' => 'Join Meeting', 'main_content' => 'join_code_view', 'error' => validation_errors());
			$this->load->view('template', $data);
		}
		else
		{
			$meeting_code_entered = $this->input->post('meeting_password');
			$this->join_meeting($meeting_code_entered);
		}
	}
	
	function join_meeting($meeting_code) {
		$document_data = $this->Document_model->join_meeting_with_code($meeting_code);
		
		// If the meeting code is invalid
		if (empty($document_data)) {
			$error = 'Invalid meeting code, please try again.';
			$data = array('title' => "Join Meeting", 'main_content' => 'join_code_view', 'error' => $error);
			$this->load->view('template', $data);
			return;
		}
		
		$data = array('title' => "Documents", 'main_content' => 'document_view', 'document_data' => $document_data);
		$this->load->view('template', $data);	
	}
	
}
?>