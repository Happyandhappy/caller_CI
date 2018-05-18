<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /*	_____________________________________________________________________________
 	@author : 			|	Date		|	Action 								
	=============================================================================
 *	Rohini More			|	17-12-2015	|	Create Header,Footer seperation, home page created
 										|	interated as per requirement, index created
	----------------------------------------------------------------------------- 
 */
 
 
class Asks extends CT_Base_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('crud_model');
		$this->load->library('pagination');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		
        $this->load->database();
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
	
    //Default function, redirects to logged in user area
    public function index(){
		
		$page_data['page_name'] = 'home_asks';
        $page_data['page_title'] = get_phrase('Home Page');
		$this->load->view('index', $page_data);

    }
	    function advice()
    {
		//print_r($_POST);exit;
		$date =  date("Y-m-d h:i:s");
		$job_data = array('title'=>$_POST['title'],
						  'review'=>$_POST['review'],
						  'first_name'=>$_POST['first_name'],
						  'email'=>$_POST['email'],
						  'last_name'=>$_POST['last_name'],
						  'category_id'=>$_POST['category_id'],
					      'created'=>$date);
					  
		$inserted = $this->crud_model->add_records('tbl_expertreview',$job_data);
		if($inserted > 0)
		{
			$this->session->set_flashdata('success',"Expert Review Posted Successfull");
			redirect(base_url('index.php?asks'));
		}
		else
		{
			$this->session->set_flashdata('error',"Expert Review Posted Not Successfull");
			redirect(base_url('index.php?asks'));
		}
    }
	    function get_expert()
    {
		$cat_id = $_POST['cat_id'];
		$review = $this->crud_model->get_records('tbl_expertreview','',array('category_id'=>$cat_id),'');
		if(count($review) > 0)
		{
		foreach($review as $res) { 
		echo '<div class="col-sm-6 col-md-4">
                <article class="box">
					<div class="details">
                        <h4 class="box-title">'.$res['title'].'</h4>
                        <p class="description">'.substr($res['review'], 0, 100).'</p>
                        <div class="action">
                            <a class="button btn-small" href="#">View Answer</a>
                            <a href="#" class=""></a>
                        </div>
                    </div> 
				</article>
            </div>';
			 } 
		}
		else{
			echo '<a class="uppercase full-width button btn-large">No Available</a>';
		}		
    }

		function view_asks()
    {
		$expert_id = $this->uri->segment(3);
		$expert = $this->crud_model->get_records('tbl_expertreview','',array('expert_id'=>$expert_id),'');
    }
}