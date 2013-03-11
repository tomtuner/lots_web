<?php
class Email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	function send_confirm_email($email, $meeting_password) {
		// email confirmation
		$this->email->from('help@parchmeet.com');
		$this->email->to($email);
		$this->email->subject('Meeting Confirmation');
		$this->email->message('Your meeting password is ' . $meeting_password . ' provide this to your attendees to access your documents.');		
		$this->email->send();	
	}

}