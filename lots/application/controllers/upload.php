<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Document_model');
		$this->load->model('Email_model');

	}

	function index()
	{
		$data = array('title' => "Setup", 'main_content' => 'setup_view', 'error' => ' ');
		$this->load->view('template', $data);
	}

	function do_upload()
	{	
		$this->form_validation->set_rules('meeting_password', 'Meeting Password', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			// Hasn't been run or validation errors
			$data = array('title' => "Sign Up", 'main_content' => 'setup_view', 'error' => validation_errors());
			$this->load->view('template', $data);
		}
		else
		{
			$meeting_password = $this->input->post('meeting_password');	
			$path = "./uploads/$meeting_password/";
			
			if(!file_exists($path)) {
			   mkdir($path);
			}			
			
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'pdf|docx|doc';
			$config['max_size']	= '1024';

			$this->upload->initialize($config);
			
			$error = true;
			
		     foreach($_FILES['uploaded_files']['name'] as $key=>$value)
		     {
		          if(is_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key]) && $_FILES['uploaded_files']['error'][$key] == 0)
		          {
		                $filename = $_FILES['uploaded_files']['name'][$key];
		                             
		                if(move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], $path . $filename))
		                {
		                      echo 'The file '. $_FILES['uploaded_files']['name'][$key].' was uploaded successful';
		                      $upload_data = pathinfo($path . $filename);
				
								$doc_name = $upload_data['filename'];
								$doc_uri = base_url('uploads/' . $meeting_password . '/' . $upload_data['basename']);
								
								$data = array(
									'meeting_code'	=>	$meeting_password,
									'doc_name'		=>	$doc_name,
									'doc_uri'		=>	$doc_uri
								);
								
								$this->Document_model->upload_document($data);
		                      $error = false;
		                }
		                else
		                {
	                      	echo 'There was a problem uploading the file.';
		                    $error = true;
		                } 
		          }
		          else
		          {
		            echo 'There is a problem with the uploading system.';
                    $error = true;
		          }
		     }
		     
		     if ($error) {
		     	$data = array('title' => "Setup", 'main_content' => 'setup_view', 'error' => $this->upload->display_errors());
				$this->load->view('template', $data);
		     }else {
		    	
				
				$email = $this->input->post('email');
				if (!empty($email)) {
					$this->Email_model->send_confirm_email($email, $meeting_password);
				}
				
				$error = 'An E-mail has been sent including your meeting password to ' . $email . '.';
				
				// Upload Successful
				$data = array('title' => 'Create Meeting', 'upload_data' => $upload_data, 'main_content' => 'setup_view', 'error' => $error);
				$this->load->view('template', $data);

		     }
		     /*
			if ( ! $this->upload->do_upload())
			{
				$data = array('title' => "Setup", 'main_content' => 'setup_view', 'error' => $this->upload->display_errors());
				$this->load->view('template', $data);
			}
			else
			{
				$upload_data = $this->upload->data();
				
				$doc_name = $upload_data['raw_name'];
				$doc_uri = base_url('uploads/' . $meeting_password . '/' . $upload_data['orig_name']);
				
				$data = array(
					'meeting_code'	=>	$meeting_password,
					'doc_name'		=>	$doc_name,
					'doc_uri'		=>	$doc_uri
				);
				
				$this->Document_model->upload_document($data);
				
				$email = $this->input->post('email');
				if (!empty($email)) {
					$this->Email_model->send_confirm_email($email, $meeting_password);
				}
				
				$error = 'An E-mail has been sent including your meeting password to ' . $email . '.';
				
				// Upload Successful
				$data = array('title' => 'Create Meeting', 'upload_data' => $upload_data, 'main_content' => 'setup_view', 'error' => $error);
				$this->load->view('template', $data);
			}*/
		}
	}
}
?>