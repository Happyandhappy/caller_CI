<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CT_Base_Controller{
    function __construct(){
        parent::__construct();
		$this->system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
		$this->system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
    }
	########### PRICING ##############
	public function page($title){
 		$cont = $this->crud_model->get_records('ct_pages','',array('page_title'=>$title),'');
 		if(count($cont)>0) {
		$page_data['page_name'] = 'page-basic';
		$page_data['cont'] = $cont[0];
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);

 		} else {
			redirect(base_url(). 'error_404?redir');
 		}
    }
	########### PRICING ##############
	public function pricing(){
		$page_data['page_name'] = 'priceplans';
        $page_data['page_title'] = get_phrase('price plans and subscription ');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function privacy_policy(){
			redirect(base_url(). 'p/privacy_policy');
    }
	public function termscondition(){
		$page_data['page_name'] = 'termscondition';
        $page_data['page_title'] = get_phrase('Terms & Condition Page ');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function careers(){
		$page_data['page_name'] = 'termscondition';
        $page_data['page_title'] = get_phrase('Careers');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function product_help(){
		$page_data['page_name'] = 'termscondition';
        $page_data['page_title'] = get_phrase('Product and Help');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function payment_method(){
		$page_data['page_name'] = 'termscondition';
        $page_data['page_title'] = get_phrase('Payment Method');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function sales_refund(){
		$page_data['page_name'] = 'termscondition';
        $page_data['page_title'] = get_phrase('Sales and Refund');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function faq(){
		$page_data['page_name'] = 'faq';
        $page_data['page_title'] = get_phrase('Frequently Asked Questions');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function services(){
		$page_data['page_name'] = 'services';
        $page_data['page_title'] = get_phrase('Our Services');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }

    //Default function, redirects to logged in user area
    public function index(){

		//redirect(base_url(). 'index.php?become_owner/' , 'refresh');
		$page_data['page_name'] = 'home';
		 $page_data['lookup_data'] = new stdClass();
        $home_lookup_ip  = $this->db->get_where('home_lookup_ip', array('ip' => $_SERVER['REMOTE_ADDR'] ))->row();
		
        if(empty( $home_lookup_ip)){
            $page_data['lookup_data']->used = 0;
			$page_data['lookup_data']->countLookUpRecord = 0; //= array('used' => 0);
			$page_data['lookup_data']->email = "";// = array('used' => 0);
        }
        else{ 
            if( $home_lookup_ip->advanced_caller_id){
                $page_data['lookup_data'] = $this->db->get_where('advanced_caller_details', array('phoneNumber' => $home_lookup_ip->from_call,'first_name !=' => ''))->row();
				$page_data['lookup_data']->email = $home_lookup_ip->emailaddress;
				if($home_lookup_ip->emailaddress != ""){
                	$page_data['lookup_data']->used = 1;
					$page_data['lookup_data']->countLookUpRecord = count($home_lookup_ip);
				}else{
					$page_data['lookup_data']->used = 0;
					$page_data['lookup_data']->countLookUpRecord = count($home_lookup_ip);
				}
            }
            else{
                $page_data['lookup_data'] = $home_lookup_ip;
				$page_data['lookup_data']->email = $home_lookup_ip->emailaddress;
                if($home_lookup_ip->emailaddress != ""){
                	$page_data['lookup_data']->used = 2;
					$page_data['lookup_data']->countLookUpRecord = count($home_lookup_ip);
				}else{
					$page_data['lookup_data']->used = 0;
					$page_data['lookup_data']->countLookUpRecord = count($home_lookup_ip);
				}
            }
        }
        //$page_data['lookup_data'] = array('used' => 0);
        $page_data['page_title'] = get_phrase('Home Page');
		$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
    }
	public function contact(){

        $this->load->helper('twilio_handlers');

		if(!isset($_POST['email'])) {
			$page_data['page_name'] = 'contactus';
	        $page_data['page_title'] = get_phrase('Contact Us');
			$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
		} else {
			$this->form_validation->set_rules('email', 'Email Is Required' ,'required');
			$this->form_validation->set_rules('name', 'Name Is Required' ,'required');
			$this->form_validation->set_rules('message', 'Message Is Required' ,'required');
			if($this->form_validation->run() == FALSE){
				$page_data['page_name'] = 'contactus';
				$page_data['page_title'] = get_phrase('Contact Us');
				$page_data['site_settings'] = $this->SiteSettings;
		$this->load->view('home', $page_data);
			} else {
				$date =  date("Y-m-d h:i:s");
				$data = array('name'=>$_POST['name'],
							  'email'=>$_POST['email'],
							  'subject'=>$_POST['message'],
							  'created'=>$date);
				$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
				$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
				//print_r($system_title);exit;
				$message='<html>
					<body>
						<table>
							<tr>
								<td>Name</td>
								<td> : </td>
								<td>'.$_POST['name'].'</td>
							</tr>
							<tr>
								<td>Message</td>
								<td> : </td>
								<td>'.$_POST['message'].'</td>
							</tr>
						</table>
					</body>
				</html>';
				$this->email->set_mailtype("html");	
				//$this->email->from($_POST['email']);
				$this->email->from($system_email,$system_title);
				$this->email->to("chip@callertech.com");
				$this->email->subject('Contact Mail');
				$this->email->message($message);
				$this->email->send();

				$inserted = $this->crud_model->add_records('tbl_contact',$data);
				$inserted = 1;
				if($inserted > 0){
					$this->session->set_flashdata('success',"Your Reqeust has been Sent Successfully!");
				}
				else{
					$this->session->set_flashdata('error',"Error! There was an issue with the sending!");
				}
				redirect(base_url('home/contact'));
			}	

		}
		
    }
}