<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*	
 */
class Login extends CT_Base_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
    }

    /* Private Functions */

    //Default function, redirects to logged in user area
    public function index(){
		$response = array();
			$this->form_validation->set_rules('email', 'User email', 'required');			
			$this->form_validation->set_rules('password', 'Enter password label', 'required');
			if ($this->form_validation->run() == FALSE){
				$page_data['page_name'] = 'login';
				$page_data['page_title'] = 'Log In Here';
				$this->load->view('home', $page_data);
			}
			else{
				$email=$this->input->post('email');
				$password=$this->input->post('password');
				$credential			=	array('email' => $email , 'password' => sha1($password));

				 // Checking login credential for client
		        $query = $this->db->get_where('client' , $credential); //echo $this->db->last_query();die;
		        if ($query->num_rows() > 0) {
		            $row = $query->row();
					//check if client status is deactivated and show deactivation reason
					 if($row->status =='2')
					 {
						 if($row->deactivation_reason=='deactivated_by_admin')
							  $this->session->set_flashdata('error' , get_phrase('Your are deactivated by admin..!!!'));
						 else
							  $this->session->set_flashdata('error' , get_phrase('There is a problem with your billing plan!'));	
						 redirect(base_url().'login','refresh');
					 }
					 $plan_id = (int) $row->client_id;
					 if($plan_id != 0) {
        				$charges = $this->crud_model->fetch_package_pricing($client_Details[0]['subscription_id']);
        				if($charges['is_subscription'] == 1 )
					    	$this->session->set_userdata('is_subscriber', $charges['is_subscription']);
					 }

					  $this->session->set_userdata('client_login', '1');
					  $this->session->set_userdata('login_user_id', $row->client_id);
					  $this->session->set_userdata('name', $row->name);
					  $this->session->set_userdata('lname', $row->lname);
					  $this->session->set_userdata('lname', $row->lname);
					  $this->session->set_userdata('login_type', 'clientuser');
					  $this->session->set_userdata('syncronisation_time', time());
					  
					  if ($row->adaccount != null && 1==0) {
							$url = 'https://graph.facebook.com/v2.8/act_'.$row->adaccount.'/customaudiences?fields=description&access_token='.$row->accesstoken;
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL,$url);
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
							$result = curl_exec($ch);
							$decoded = json_decode($result)->data;
							foreach($decoded as $d){
								$time = strtotime(str_replace('Generated on ', '', $d->description));
								$expire = 0;
								$expire = $row->adaccount_expire * 86400;
								$time += $expire;
								/*echo $expire;
								echo "<br>";
								echo $time_compare;*/
								$time_compare = time();
								if ($time > $time_compare) {
									$ch = curl_init();
									curl_setopt($ch,CURLOPT_URL,'https://graph.facebook.com/v2.8/'.$d->id);
									curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
								    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
								    		'access_token' => $row->accesstoken
								    	));
									curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
									$result = curl_exec($ch);
								}
							}
							$url = 'https://graph.facebook.com/v2.8/act_'.$row->adaccount.'/customaudiences?fields=description&access_token='.$row->accesstoken;
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL,$url);
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
							$result = curl_exec($ch);
							$decoded = json_decode($result)->data;
							if (empty($decoded)) {
								$custom_id = json_decode($result)->id;
								$url = 'https://graph.facebook.com/v2.8/act_'.$row->adaccount.'/customaudiences';
								$fields = array(
								'name' => 'CallerTech',
								'subtype' => 'CUSTOM',
								'description' => 'Generated on '.date('Y-m-d H:i:s'),
								'access_token' => $row->accesstoken,
								);
								$ch = curl_init();
								//set the url, number of POST vars, POST data
								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch,CURLOPT_POST,count($fields));
								curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
								curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
								//execute post
								$result = curl_exec($ch);
								$custom_id = json_decode($result)->id;
								$client_id 	 = $row->client_id;
			        			$updated = $this->db->update('client', array('custom_audience_id' => $custom_id)/*, 'expires' => $this->input->post('expires'))*/, array('client_id' => $client_id));
							}
								// code...
					  	// code...
					  }
					 redirect('clientuser/dashboard','refresh');
				}
				if($query->num_rows()==0){
				      $this->session->set_flashdata('error' , get_phrase('Please check Your Email And Password'));
					redirect(base_url().'login','refresh');
				}
			}
    }
    public function forgot_password(){
		if(isset($_POST['btn_forgot']))
		{
			$this->form_validation->set_rules('email', 'User email', 'required');			
			if ($this->form_validation->run() == FALSE){
				$page_data['page_name'] = 'forgot_password';
				$page_data['page_title'] = 'Forgot Password';
				$this->load->view('home', $page_data);
			}
			else{
				$email = $_POST['email'];
				$this->db->where('email', $email);
				$data = $this->db->get('client')->result_array();
				if(!empty($data))
				{
					$message='<html>
								<body>
									<p>Follow link to change password:!</p>
									<p>Link :'.base_url().'login/change_password/'.(base64_encode($data[0]['client_id'])).'</p>
								</body>
							</html>';
				$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
					$this->load->library('email'); // load email library

					$this->email->from('noreply@callertech.com');
					$this->email->to($email);
					$this->email->subject('Forgot Password');
					$this->email->message($message);
			 		$this->email->send();
					$this->session->set_flashdata('success', 'Link to change your password was sent to your Email!');
					redirect(base_url().'login','refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Enter Correct Email');
					redirect(base_url().'login/forgot_password','refresh');
				}
			}
		}
				$page_data['page_name'] = 'forgot_password';
				$page_data['page_title'] = 'Forgot Password';
				$this->load->view('home', $page_data);
    }
    public function change_password($id){
		if(isset($_POST['btn_change']))
		{
			$user_id = base64_decode($this->uri->segment(3));
			$where_arr = array('client_id'=>$user_id);
			$data = array('password'=>sha1($_POST['password']));
			$update = $this->crud_model->update_records('client',$data,$where_arr);
			redirect(base_url().'login','refresh');
		}
		$page_data['page_name'] = 'change_password';
        $page_data['page_title'] = get_phrase('Change Password');
        $page_data['user_id'] = $id;
		$this->load->view('home', $page_data);
    }
    public function ajax_forgot_password(){
    	$resp 					= array();
        $resp['status']         = 'false';
		$email 					= $_POST["email"];
		$reset_account_type		= '';
		//resetting user password here
		$new_password			=	substr( md5( rand(100000000,20000000000) ) , 0,7);
		$new_hashed_password	=	sha1($new_password);
		// Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0) {
        	$reset_account_type		=	'admin';
        	$this->db->where('email' , $email);
        	$this->db->update('admin' , array('password' => $new_hashed_password));
            $resp['status']         = 'true';
            // send new password to user email  
            $this->email_model->notify_email('password_reset_confirmation' , $reset_account_type , $email , $new_password);
        }
		// Checking credential for staff
        $query = $this->db->get_where('staff' , array('email' => $email));
        if ($query->num_rows() > 0) {
        	$reset_account_type		=	'staff';
        	$this->db->where('email' , $email);
        	$this->db->update('staff' , array('password' => $new_hashed_password));
            $resp['status']         = 'true';
            // send new password to user email  
            $this->email_model->notify_email('password_reset_confirmation' , $reset_account_type , $email , $new_password);
        }
		// Checking credential for client
        $query = $this->db->get_where('client' , array('email' => $email));
        if ($query->num_rows() > 0) {
        	$reset_account_type		=	'client';
        	$this->db->where('email' , $email);
        	$this->db->update('client' , array('password' => $new_hashed_password));
            $resp['status']         = 'true';
            // send new password to user email  
            $this->email_model->notify_email('password_reset_confirmation' , $reset_account_type , $email , $new_password);
        }
		$resp['submitted_data'] = $_POST;
		echo json_encode($resp);
    }
	/***RESET AND SEND PASSWORD TO REQUESTED EMAIL****/
	public function reset_password(){
		$account_type = $this->input->post('account_type');
		if ($account_type == "") {
			redirect(base_url(), 'refresh');
		}
		$email  = $this->input->post('email');
		$result = $this->email_model->password_reset_email($account_type, $email); //SEND EMAIL ACCOUNT OPENING EMAIL
		if ($result == true) {
			$this->session->set_flashdata('flash_message', get_phrase('password_sent'));
		} else if ($result == false) {
			$this->session->set_flashdata('flash_message', get_phrase('account_not_found'));
		}
		redirect(base_url(), 'refresh');		
	}
    /*******LOGOUT FUNCTION *******/
    public function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect('home' , 'refresh');
    }
}