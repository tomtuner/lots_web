<?php
class Document_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function upload_document($doc_array)
	{
		$this->db->insert('meetings', $doc_array);
	}
	
	function join_meeting_with_code($meeting_code){
		
		$this -> db -> select('id, doc_name, doc_uri');
		$this -> db -> from ('meetings');
		$this -> db -> where ('meeting_code = ' . "'" . $meeting_code . "'");
		
		$query = $this -> db -> get();
		
		if($query -> num_rows() > 0) {
		
			foreach ($query->result_array() as $row) {
	            $data[] = $row;
            }
        }
        
		$query->free_result();
		return $data;
	}

}
?>