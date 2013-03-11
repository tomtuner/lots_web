<?php
class SignUp_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function register_user($user_array)
	{
		$this->db->insert('users', $user_array);
	}
	
	function confirm_registration($activation_code)
	{
		$this->db->select('id', 'email');
		$result = $this->db->get_where('users', array('activation_code' => $activation_code));
		if ($result->num_rows() == 1)
		{
			$row = $result->row_array(); 
			$data = array(
							'activated' => 1
							);
			$this->db->where('id', $row['id']);
			$this->db->update('users', $data);
			return true;
		}
		else
		{
			return false;
		}
	}

}