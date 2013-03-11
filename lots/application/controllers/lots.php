<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Lots extends REST_Controller {

	public function index_get()
    {
        // Display all lots
    }

    public function index_post()
    {
        // Create a new lot post
        error_log($this->post('lat'));
    }

}
?>