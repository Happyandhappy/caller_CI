<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_handler extends CT_Base_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    }
	
	public function index()
	{	
        redirect(base_url(), 'refresh');
	}
	
	public function miss()
	{
        $page_data['page_name']  = 'error';
        $page_data['error_code']  = '404';
        $page_data['page_title'] = get_phrase('page_not_found');
        $this->load->view('home', $page_data);
	}
}
