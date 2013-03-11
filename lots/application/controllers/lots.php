<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
class Lots extends REST_Controller {

	public function index_get()
    {
        // Display all lots
        error_log('GET');
        error_log($this->get('latitude'));
        error_log($this->get('longitude'));

    }

    public function index_post()
    {
        // Create a new lot post
        error_log('POST');
        error_log($this->post('lat'));
    }

}
?>