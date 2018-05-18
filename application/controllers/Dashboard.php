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
 
 
class Dashboard extends CT_Base_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('crud_model');
		$this->load->library('pagination');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		
		
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
		if($this->session->userdata('user_id')=="")
		{
			redirect(base_url('index.php?login'));
		}
    }
	
    //Default function, redirects to logged in user area
    public function index(){
		$page_data['page_name'] = 'user_dashboard';
        $page_data['page_title'] = get_phrase('Dashboard');
		$this->load->view('index', $page_data);
	}
	function update()
    {
		$id = base64_decode($this->uri->segment(3));
		$date =  date("Y-m-d h:i:s");
		//print_r($_POST);exit;
		$where_array = array('trades_id'=>$id);
		$job_data = array('cat_id'=>$_POST['category_id'],
						  'subcat_id'=>$_POST['subcategory_id'],
						  'job_name'=>$_POST['job_name'],
						  'job_desc'=>$_POST['job_desc'],
					      'job_title'=>$_POST['ready_hire'],
					      'job_start'=>$_POST['job_start'],
					      'job_budget'=>$_POST['job_budget'],
					      'phoneno'=>$_POST['phoneno'],
					      'updated'=>$date);
		//print_r($job_data);exit;
					  
		$updated = $this->crud_model->update_records('tbl_trades',$job_data,$where_array);
		if($updated > 0)
		{
			$this->session->set_flashdata('success',"Job Updated Successfull");
			redirect(base_url('index.php?dashboard'));
		}
		else
		{
			$this->session->set_flashdata('error',"Job Not Updated Successfull");
			redirect(base_url('index.php?dashboard'));
		}
    }
	    function delete_job()
    {
		$id = base64_decode($this->uri->segment(3));
		$where_array = array('trades_id'=>$id);
					  
		$deleted = $this->crud_model->delete_records('tbl_trades',$where_array);
		if($deleted > 0)
		{
			$this->session->set_flashdata('success',"Job Deleted Successfull");
			redirect(base_url('index.php?dashboard'));
		}
		else
		{
			$this->session->set_flashdata('error',"Job Not Deleted Successfull");
			redirect(base_url('index.php?dashboard'));
		}
    }
	    function review_rating()
    {
		$id = base64_decode($this->uri->segment(3));
		$job_id = $_POST['job_id'];
		$purchased_id = $_POST['purchased_id'];
		//print_r($job_id);exit;
		$where_array = array('trades_id'=>$job_id);
		$status_data = array('status'=>'3');
		$date =  date("Y-m-d h:i:s");
		$rating_data = array('staff_id'=>$id,
							 'user_id'=>$this->session->userdata('user_id'),
							 'job_id'=>$job_id,
							 'purchased_id'=>$purchased_id,
							 'review_title'=>$_POST['review_title'],
							 'review_desc'=>$_POST['review_desc'],
						     'rating'=>$_POST['rating'],
							 'created'=>$date);
		//print_r($job_data);exit;
					  
		$updated = $this->crud_model->update_records('tbl_trades',$status_data,$where_array);
		$inserted = $this->crud_model->add_records('tbl_ratingreview',$rating_data);
		if($inserted > 0)
		{
			$this->session->set_flashdata('success',"Rating Set Successfull");
			redirect(base_url('index.php?dashboard'));
		}
		else
		{
			$this->session->set_flashdata('error',"Rating Not set Successfull");
			redirect(base_url('index.php?dashboard'));
		}
    }
    function user_profile(){
		
		if(isset($_POST['btn_submit']))
		{
				$date =  date("Y-m-d h:i:s");

			$newFileName = $_FILES['userfile']['name'];
			//print_r($newFileName);exit;
 			if($newFileName!= "")
			{
				$newFileName = $_FILES['userfile']['name'];
				$fileExt     = array_pop(explode(".", $newFileName));
				$filename    = str_replace(' ', '_', $_POST['fname']) . "_" . time() . "." . $fileExt;
				 
				//set filename in config for upload
				$config['file_name']     = uniqid();
				$config['upload_path']   = "./uploads/homeowner_profile/";
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				
				
				 $this->upload->initialize($config);
				$this->upload->do_upload('userfile');
			
                $data = $this->upload->data();	
			//print_r($data);
				
			$where_array = array('user_id'=>$this->session->userdata('user_id'));
			$user_data = array('fname'=>$_POST['fname'],
							  'lname'=>$_POST['lname'],
							  'phone_no'=>$_POST['phone_no'],
							  'profile_image'=>$data['file_name'],
							  'updated'=>$date);
			}
			else{
			$where_array = array('user_id'=>$this->session->userdata('user_id'));
			$user_data = array('fname'=>$_POST['fname'],
							  'lname'=>$_POST['lname'],
							  'phone_no'=>$_POST['phone_no'],
							  'updated'=>$date);
			}
			$updated = $this->crud_model->update_records('tbl_user',$user_data,$where_array);
			if($updated > 0)
			{
				$this->session->set_flashdata('success',"Homeowner Profile Updated Successfull");
				redirect(base_url('index.php?dashboard/user_profile'));
			}
			else
			{
				$this->session->set_flashdata('error',"Homeowner Profile Not Updated Successfull");
				redirect(base_url('index.php?dashboard/user_profile'));
			}
		}
		$page_data['page_name'] = 'homeowner_profile';
        $page_data['page_title'] = get_phrase('Homeowner');
		$this->load->view('index', $page_data);
	}
    public function get_quotation(){
		$tradsman_id = base64_decode($this->uri->segment(3));
		//print_r($tradsman_id);
		$this->db->where('jobuser_id',$this->session->userdata('user_id'));
		$this->db->where('tradesmen_id',$tradsman_id);
		$this->db->join('tbl_trades','tbl_trades.trades_id=trades_quotation.job_id');
		$quotation = $this->db->get('trades_quotation')->result_array();
		//print_r($quotation);exit;

		$page_data['page_name'] = 'quotation_list';
        $page_data['page_title'] = get_phrase('Quotations');
        $page_data['quotation'] = $quotation;
		$this->load->view('index', $page_data);

    }
    public function accept_quote(){
		$job_id = $_POST['job_id'];
		$tradesmen_id = $_POST['tradesmen_id'];		$purchased_id = $_POST['purchased_id'];

		$where_array = array('trades_id'=>$job_id);
		$status_data = array('status'=>'3');
					  
		$updated = $this->crud_model->update_records('tbl_trades',$status_data,$where_array);

		$where_arry1 = array('job_id'=>$job_id,'tradesmen_id'=>$tradesmen_id);
		$update_arry1 = array('quote_status'=>'2');
		$update1 = $this->crud_model->update_records('trades_quotation',$update_arry1,$where_arry1);

		$where_arry = array('job_id'=>$job_id,'tradesmen_id'=>$tradesmen_id,'jobuser_id'=>$this->session->userdata('user_id'));
		$update_arry = array('quote_status'=>'1');
		$update = $this->crud_model->update_records('trades_quotation',$update_arry,$where_arry);

		if(count($update) > 0 )
		{
			echo 'true';
		}
    }
	public function tradesback()
	{
		$payment_gross_amount = $_POST['payment_gross_amount'];
		$tradesmen_id = $_POST['tradesmen_id'];
		$purchased_id = $_POST['purchased_id'];
		$comment = $_POST['comment'];
		$status = $_POST['status'];
		//print_r($payment_gross_amount);
		//print_r($tradesmen_id);
		//print_r($purchased_id);
		//print_r($comment);
		//print_r($status);exit;
		if($status=='1')
		{
			$payment = $this->crud_model->get_records('staff','',array('staff_id'=>$tradesmen_id),'');
			$cng_credit = $payment[0]['credit'] + $payment_gross_amount;

			$where_arr = array('staff_id'=>$tradesmen_id);
			$update_arr = array('credit'=>$cng_credit);
			$updated_arry = $this->crud_model->update_records('staff',$update_arr,$where_arr);
			
			$where_array = array('purchased_id'=>$purchased_id);
			$update_array = array('lead_status'=>'2');
			$updated = $this->crud_model->update_records('tbl_purchased',$update_array,$where_array);
			
			$this->session->set_flashdata('success',"Status Updated Successfully");
			redirect(base_url() . 'index.php?dashboard');

		}
		if($status=='2')
		{
			$where_array = array('purchased_id'=>$purchased_id);
			$update_array = array('lead_comment'=>$comment);
			$updated = $this->crud_model->update_records('tbl_purchased',$update_array,$where_array);
			
			$this->session->set_flashdata('success',"Status Updated Successfully");
			redirect(base_url() . 'index.php?dashboard');
		}
		
	}
	
}