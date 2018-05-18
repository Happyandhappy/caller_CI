<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*  
 *  @author : Edis Golubich
 *  date  : 2 sep, 2017
 */

class Apanel extends CT_Base_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('upload');
    }

    public function login_as($uid) {

        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }

        $credential =  array('client_id' => $uid );       
         // Checking login credential for client
        $query = $this->db->get_where('client' , $credential); //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $row = $query->row();
          $this->session->set_userdata('admin_login', '0');
          $this->session->set_userdata('client_login', '1');
          $this->session->set_userdata('login_user_id', $row->client_id);
          $this->session->set_userdata('name', $row->name);
          $this->session->set_userdata('lname', $row->lname);
          $this->session->set_userdata('lname', $row->lname);
          $this->session->set_userdata('login_type', 'clientuser');
          $this->session->set_userdata('syncronisation_time', time());
        }
        redirect('clientuser/dashboard','refresh');
    }
    
    // default function, redirects to login page if no admin logged in yet
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        } else
        redirect('apanel/dashboard', 'refresh');
    }

    public function login(){
        $response = array();
        $this->form_validation->set_rules('email', 'User email', 'required');           
        $this->form_validation->set_rules('password', 'Enter user password', 'required');
        if ($this->form_validation->run() == FALSE){
            $page_data['page_name'] = '';
            $this->load->view('apanel/login', $page_data);
        }
        else{
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $credential         =   array('email' => $email , 'password' => sha1($password));
            // Checking login credential for admin
            $query = $this->db->get_where('admin' , $credential);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                  $this->session->set_userdata('admin_login', '1');
                  $this->session->set_userdata('admin_user_id', $row->admin_id); // need to check some stuff
                  $this->session->set_userdata('name', $row->name);
                  $this->session->set_userdata('login_type', 'admin');
                  $this->session->set_userdata('syncronisation_time', time());
                  redirect('apanel/dashboard','refresh');
            } else {
                  $this->session->set_flashdata('error' , get_phrase('Please check Your Email And Password'));
                  redirect(base_url().'apanel/login','refresh');
            }
        }
    }
    
    // admin dashboard
    public function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }

        $service_list1["Incoming Calls"] = 'max_call_in';
        $service_list1["Sent SMS"] = 'max_send_sms';
        $service_list1["Sent MMS"] = 'max_send_mms';
        $service_list1["Incoming SMS/MMS"] = 'max_received_sms';
        $service_list1["Lookup Calls"] = 'max_call_lookup';
        $service_list1["Transcripts (min)"] = 'max_call_transcripts';
        $service_list1["Call Minutes"] = 'max_call_minutes';
        $service_list1["Social Ads"] = 'max_social_ad';


        $tamo['settings']   = $this->db->get('settings')->result_array();
        $noviset = new stdClass();
        foreach($tamo['settings']  as $sets) {
            $noviset->{$sets['type']} = $sets['description'];
        }

        $service_list = array();
        $max_plan_cost = 0;
        foreach($service_list1 as  $name => $srv) {
            $service_list[$name] = array(
                    'count' => $this->crud_model->get_subs_count_alls($srv),
                    'count_total' => $this->crud_model->get_subs_count_total_alls($srv)
                );
            $price_key = str_replace("max_","price_",$srv);
            $service_list[$name]['cost'] = ($noviset->{$price_key} * $service_list[$name]['count']);
            $service_list[$name]['cost_total'] = ($noviset->{$price_key} * $service_list[$name]['count_total']);
            $page_data['serv_cost_sum'] += $service_list[$name]['cost'];
            $page_data['serv_cost_total_sum'] += $service_list[$name]['cost_total'];
            
        }


            /* --- Check if has that phone number */
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'status' => 'active'
            ));
            $phoneNumbers = $this->db->get()->result_array();
            $num_phones = count( $phoneNumbers);

            $numpayments = 0;
            /* --- Check if has that phone number */
            $this->db->select('*,COUNT(*) as contl,SUM(payment_gross_amount) as totl');
            $this->db->from('client_payment_details');
            $this->db->where(array(
                'payment_status' => 'verified'
            ));
            $payments = $this->db->get()->result_array();
            $numpayments = (int) count( $payments);


        /* DISABLE MESSAGES FOR ALL PHONE NUMBERS */
        $total_ph_cost = 0;
        $danas = time();
        foreach ($phoneNumbers as $ph) {
            $datesi = $danas - strtotime($ph['date']);
            $dana = ceil( $datesi/(3600*24) );
            $mjeseci = ceil( $datesi/(3600*24*30) );
            $total_ph_cost += $mjeseci*$noviset->price_phone_numbers;

        }

        $service_list["Phone Numbers"] = array(
                    'count' => 'N/A',
                    'cost' => $num_phones*$noviset->price_phone_numbers,
                    'count_total' => $num_phones,
                    'cost_total' => $total_ph_cost,

            );
        $page_data['cost_sum']  = $page_data['serv_cost_sum'] + $num_phones*$noviset->price_phone_numbers;
        $page_data['cost_total_sum']  = $page_data['serv_cost_total_sum'] + $total_ph_cost;

        $page_data['serv_cost_total_sum'] +=$service_list["Phone Numbers"]['cost_total'];
        $page_data['service_list'] = $service_list;


        $max_phone_numbers = $plan['max_phone_numbers'];
        $page_data['total_paid'] = $payments[0]['totl'];

            /* --- Check if has that phone number */
            $this->db->select('*,COUNT(*) as contl,SUM(payment_gross_amount) as totl');
            $this->db->from('client_payment_details');
            $this->db->where(array(
                'payment_status' => 'verified'
            ));
            $this->db->where('(payment_date LIKE "'.date("Y-m-").'%")');
            $paymentsa = $this->db->get()->result_array();
            $min_date = strtotime("-1 months");
            $min_date = time();
            $page_data['month_paypal'] = 0;
        foreach($paymentsa as $pays){
                    $page_data['month_paid'] =  $pays['payment_gross_amount'];
                    $page_data['month_paypal'] += ($page_data['month_paid']*$noviset->paypal_cost_per_payment);
        }
        $page_data['month_paypal'] = $page_data['month_paypal'] + ($noviset->paypal_cost_per_payment_more*$numpayments);

        $page_data['month_paid'] = 0;
        $page_data['numpayments'] =  $numpayments;
        $page_data['total_paypal'] = ($page_data['total_paid']*$noviset->paypal_cost_per_payment) + ($noviset->paypal_cost_per_payment_more*$numpayments);

        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('/apanel', $page_data);
    }

    // profile settings
    public function admins($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if($this->session->userdata('admin_user_id') != 1)
            redirect('apanel', 'refresh');


        if ($param1 == 'delete') {
            $this->crud_model->delete_admin($param2);
            redirect('apanel/admins/', 'refresh');
        } else if ($param1 == 'add') {
            $page_data['page_name']  = 'admins_add';
            $page_data['page_title'] = get_phrase('Add Admin');
           /* $page_data['edit_data']  = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_user_id')
            ))->result_array();*/
            $this->load->view('apanel', $page_data);
        } else if ($param1 == 'newadd') {
            //print_r($_POST);exit;
            $data['name']          = $this->input->post('name');
            $data['email']         = $this->input->post('email');
            $data['phone']         = $this->input->post('phone');
            $data['address']       = $this->input->post('address');

            $new_password           = sha1($this->input->post('new_password'));
            $data['password']       = $new_password;
            $imagePrefix           = time();
            $data['address']       = $this->input->post('address');

            if (isset($_FILES["image"]) && $_FILES["image"]["name"] != '') {
                $this->load->helper("url");
                $result                = unlink("uploads/admin_image/" . $data['profile_image']);
                $data['profile_image'] = $imagePrefix . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $imagePrefix . $_FILES["image"]["name"]);
            }
            $this->db->insert('admin', $data);
            //move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $admin_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect('apanel/admins/', 'refresh');
        } else {

            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where(array(
                'admin_id !=' => '1'
            ));
            $admin_list = $this->db->get()->result_array();

            $page_data['list_admins']  = $admin_list;
            $page_data['page_name']  = 'admins_list';
            $page_data['page_title'] = get_phrase('List Admin');
            $this->load->view('apanel', $page_data);

        }
    }
    // language settings
    function manage_language($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        if ($param1 == 'update_phrase') {
            $language = $param2;
            $total_phrase = $this->input->post('total_phrase');
            for ($i = 1; $i < $total_phrase; $i++) {
                //$data[$language]  =   $this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array($language => $this->input->post('phrase' . $i)));
            }
            redirect('apanel/manage_language/edit_phrase/' . $language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect('apanel/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect('apanel/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT',
                    'null' => FALSE
                )
            );
            $this->dbforge->add_column('language', $fields);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect('apanel/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect('apanel/manage_language/', 'refresh');
        }
        $page_data['page_name'] = 'settings/manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('apanel', $page_data);
    }
    // profile settings
    public function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'update_profile_info') {
            //print_r($_POST);exit;
            $data['name']          = $this->input->post('name');
            $data['email']         = $this->input->post('email');
            $data['phone']         = $this->input->post('phone');
            $data['address']       = $this->input->post('address');
            $admin_id              = $this->session->userdata('admin_user_id');
            $imagePrefix           = time();
            $data['profile_image'] = $this->input->post('profile_img');
            if (isset($_FILES["image"]) && $_FILES["image"]["name"] != '') {
                $this->load->helper("url");
                $result                = unlink("uploads/admin_image/" . $data['profile_image']);
                $data['profile_image'] = $imagePrefix . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $imagePrefix . $_FILES["image"]["name"]);
            }
            $this->db->where('admin_id', $admin_id);
            $this->db->update('admin', $data);
            //move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $admin_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect('apanel/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password           = sha1($this->input->post('new_password'));
            $confirm_new_password   = sha1($this->input->post('confirm_new_password'));
            $current_password_db    = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_user_id')
            ))->row()->password;
            if ($current_password_db != $current_password_input) {
                $this->session->set_flashdata('flash_message', get_phrase('Current Password do not match.Re-enter old password'));
            }
            if ($new_password != $confirm_new_password) {
                $this->session->set_flashdata('flash_message', get_phrase('Confirm Password do not match. Re-enter password'));
            }
            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('admin_user_id'));
                $this->db->update('admin', array(
                    'password' => $new_password
                ));
                $this->session->set_flashdata('flash_message', get_phrase('Password updated successfully'));
            }
            redirect('apanel/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $this->session->userdata('admin_user_id')
        ))->result_array();
        $this->load->view('apanel', $page_data);
    }

    /* JSON HANDLERS */

    public function graph(){
        $this->db->select('client_payment_details.payment_date,client_payment_details.payment_gross_amount');
        //$this->db->where('month(payment_date)', date('m'));            
        $test =  $this->db->get('client_payment_details')->result_array();
        //print_r($test);exit;
        echo json_encode($test);
    }
    public function client_count(){
        $test =  $this->db->get('client')->result_array();
        //print_r($test);exit;
        $usecnt = count($test);
        echo json_encode($usecnt);
    }
    
    /* USER HANDLERS */
    
    public function user_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'deactive') {
            
            $result = $this->crud_model->deactivate_user($param2);
            if ($result != FALSE) {
                /* TODO: CLEANUP - EMAIL SENDING  */
                $clientDetails = $this->db->get_where('client', array(
                    'client_id' => $row->client_id
                ))->row();
                $system_email  = $this->db->get_where('settings', array(
                    'type' => 'system_email'
                ))->row()->description;
                $system_title  = $this->db->get_where('settings', array(
                    'type' => 'system_title'
                ))->row()->description;
                $subject       = 'Intimation Rreguarding your ' . $system_title . ' Account has deactived.';
                $message       = '<html>
                                    <body>
                                    <p>Dear <strong>' . $clientDetails->name . ' ' . $clientDetails->lname . '</strong>,</p>
                                    <p>This is the email from  ' . $system_title . '! </p>
                                    <p>Reguarding Deactivation of your existing account.</p>
                                    <p>Admin has deactived your account.</p>
                                    <p>For Any further any query , contact us. </p>
                                    <p></p>
                                    <p></p>
                                    <p><strong>You will be Unable to get log-in into the your account with ' . $system_title . ' Onwords.</strong> </p>
                                    <p></p>
                                    <p></p>
                                    </body><br /><br /><br /><br /><br />
                                    <p>Regards , </p>
                                    <p>' . $system_name . '</p>
                                    </html>';
                $this->load->library('email'); // load email library
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = 'ssl://smtp.gmail.com';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = 'smtpmpa@gmail.com';
                $config['smtp_pass']    = 'smtpmpa@12345';
                $config['charset']      = 'utf-8';
                $config['newline']      = "\r\n";
                $config['mailtype']     = 'html'; // or html
                $config['validation']   = TRUE; // bool whether to validate email or not  
                $this->email->initialize($config);
                $this->email->from($system_email, $system_title);
                $this->email->to($clientDetails->email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
        }
        if ($param1 == 'active') {
            $result = $this->crud_model->activate_user($param2);
            
            if ($result != FALSE) {
                /* TODO: CLEANUP - EMAIL SENDING  */
                $clientDetails = $this->db->get_where('client', array(
                    'client_id' => $row->client_id
                ))->row();
                $system_email  = $this->db->get_where('settings', array(
                    'type' => 'system_email'
                ))->row()->description;
                $system_title  = $this->db->get_where('settings', array(
                    'type' => 'system_title'
                ))->row()->description;
                $subject       = 'Reguarding Re-activation of your account with  ' . $system_title;
                $message       = '<html>
                                    <body>
                                    <p>Dear <strong>' . $clientDetails->name . ' ' . $clientDetails->lname . '</strong>,</p>
                                    <p>This is the email from  ' . $system_title . '! </p>
                                    <p>Reguarding Re-activation of your account by admin.</p>
                                    <p><b><strong>Your Account Details are: </strong> </b>
                                    <small><em>(Please do not disclose your account credentials to any one )</em></small></p>
                                    <p><strong>Login Email :  </strong> ' . $clientDetails->email . '</p>
                                    <p><strong>Password :  </strong> ' . sha1($clientDetails->password) . '</p>
                                    <p><strong>You can get account here  : </strong>' . base_url() . 'login </p>
                                    <p><strong>You will be able to get log-in into the your account with ' . $system_title . ' Onwords with above details.</strong> </p>
                                    <p></p>
                                    <p></p>
                                    <p>For Any further any query , contact us. </p>
                                    </body><br /><br /><br /><br /><br />
                                    <p>Regards , </p>
                                    <p>' . $system_name . '</p>
                                    </html>';
                $this->load->library('email'); // load email library
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = 'ssl://smtp.gmail.com';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = 'smtpmpa@gmail.com';
                $config['smtp_pass']    = 'smtpmpa@12345';
                $config['charset']      = 'utf-8';
                $config['newline']      = "\r\n";
                $config['mailtype']     = 'html'; // or html
                $config['validation']   = TRUE; // bool whether to validate email or not  
                $this->email->initialize($config);
                $this->email->from($system_email, $system_title);
                $this->email->to($clientDetails->email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
            }
        }
        $page_data['page_name']  = 'userinfo/user_list';
        $page_data['page_title'] = get_phrase('User Details');
        $this->load->view('apanel', $page_data);
    }
    public function user_view_profits($usr_id)
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $client = $this->db->get_where('client', array(
            'client_id' => $usr_id
        ))->row();
        $cl_id = $usr_id;

        $tamo['settings']   = $this->db->get('settings')->result_array();
        $noviset = new stdClass();
        foreach($tamo['settings']  as $sets) {
            $noviset->{$sets['type']} = $sets['description'];
        }

        $page_data['usrinf'] = $client;
        $page_data['acc_balance'] = $client->available_fund;
        $page_data['page_name']  = 'userinfo/profits';
        $page_data['page_title'] = get_phrase('Subscription Details for ').$client->email;

        $plan = $this->crud_model->fetch_package_pricing($client->subscription_id);

            /* --- Check if has that phone number */
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $client->client_id,
                'status' => 'active'
            ));
            $phoneNumbers = $this->db->get()->result_array();
            $num_phones = count( $phoneNumbers);

            $numpayments = 0;
            /* --- Check if has that phone number */
            $this->db->select('*');
            $this->db->from('client_payment_details');
            $this->db->where(array(
                'client_id' => $client->client_id,
                'payment_status' => 'verified',
                'plan_id' => $plan['package_id']
            ));
            $payments = $this->db->get()->result_array();
            $numpayments = (int) count( $payments);


        $max_phone_numbers = $plan['max_phone_numbers'];
        $page_data['month_paid'] = $client->subscription_amt;
        $page_data['numpayments'] =  $numpayments;
        $page_data['month_paypal'] = ($page_data['month_paid']*$noviset->paypal_cost_per_payment)+($noviset->paypal_cost_per_payment_more*$numpayments);
        $page_data['total_paid'] =  $this->crud_model->get_sum_paid($client->client_id);

        $page_data['total_paypal'] = ($page_data['total_paid']*$noviset->paypal_cost_per_payment) + ($noviset->paypal_cost_per_payment_more*$numpayments); 
        $page_data['month_paid_paypal'] = $page_data['month_paid'] - $page_data['total_paypal'];
        $page_data['total_paid_paypal'] = $page_data['total_paid'] - $page_data['total_paypal'];
        
        $service_list1["Incoming Calls"] = 'max_call_in';
        $service_list1["Sent SMS"] = 'max_send_sms';
        $service_list1["Sent MMS"] = 'max_send_mms';
        $service_list1["Incoming SMS/MMS"] = 'max_received_sms';
        $service_list1["Lookup Calls"] = 'max_call_lookup';
        $service_list1["Transcripts (min)"] = 'max_call_transcripts';
        $service_list1["Call Minutes"] = 'max_call_minutes';
        $service_list1["Social Ads"] = 'max_social_ad';

        $service_list = array();
        $max_plan_cost = 0;
        foreach($service_list1 as  $name => $srv) {
            $service_list[$name] = array(
                    'count' => $this->crud_model->get_subs_count($cl_id,$srv),
                    'count_total' => $this->crud_model->get_subs_count_total($cl_id,$srv),
                    'max' => $plan[$srv]
                );
            $price_key = str_replace("max_","price_",$srv);
            $service_list[$name]['cost'] = ($noviset->{$price_key} * $service_list[$name]['count']);
            $service_list[$name]['cost_total'] = ($noviset->{$price_key} * $service_list[$name]['count_total']);
            $service_list[$name]['max_cost'] = ($noviset->{$price_key} * $plan[$srv]);
            $max_plan_cost +=$service_list[$name]['max_cost']; 
            $page_data['serv_cost_sum'] += $service_list[$name]['cost'];
            $page_data['serv_cost_total_sum'] += $service_list[$name]['cost_total'];
            
        }

                    
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $client->client_id,
            'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();


        /* DISABLE MESSAGES FOR ALL PHONE NUMBERS */
        $total_ph_cost = 0;
        $danas = time();
        foreach ($phoneNumbers as $ph) {
            $datesi = $danas - strtotime($ph['date']);
            $dana = ceil( $datesi/(3600*24) );
            $mjeseci = ceil( $datesi/(3600*24*30) );
            $total_ph_cost += $mjeseci*$noviset->price_phone_numbers;

        }

        $service_list["Phone Numbers"] = array(
                    'count' => 'N/A',
                    'cost' => $num_phones*$noviset->price_phone_numbers,
                    'count_total' => $num_phones,
                    'cost_total' => $total_ph_cost,
                    'max' => $max_phone_numbers,
                    'max_cost' =>  $max_phone_numbers*$noviset->price_phone_numbers,

            );
        $page_data['cost_sum']  = $page_data['serv_cost_sum'] + $num_phones*$noviset->price_phone_numbers;
        $page_data['cost_total_sum']  = $page_data['serv_cost_total_sum'] + $total_ph_cost;

        $page_data['serv_cost_total_sum'] +=$service_list["Phone Numbers"]['cost_total'];
        $page_data['service_list'] = $service_list;



        $page_data['site_settings']   =$noviset;
        $page_data['plan_details']   = $plan;
        $page_data['max_plan_cost']   = $max_plan_cost;
        $this->load->view('apanel', $page_data);

    }
    
    /* PACKAGE & SUBSCRIPTION HANDLERS */
    
    public function subscription_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('package_name', 'Subscription Name', 'required');
        $this->form_validation->set_rules('package_amount', 'Subscription Cost', 'required|numeric');
        //$this->form_validation->set_rules('package_credit', 'Packages Credit', 'required|numeric');
        $this->form_validation->set_rules('features[]', 'Features', 'required');
        $this->form_validation->set_rules('duration_id', 'Duration', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

            $page_data['page_name']      = 'packages/subscription_add';
        
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Create Subscription');
            $page_data['page_form_line'] = get_phrase('Create Subscription');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_package();
            $page_data['page_title']     = get_phrase('Create  Page');
            $page_data['page_form_line'] = get_phrase('Create Subscription');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('Subscription added successfully'));
            } else {
                $this->session->set_flashdata('error', get_phrase(''));
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function subscription_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $package_id = $this->uri->segment(3);
        $this->form_validation->set_rules('package_name', 'Subscription Name', 'required');
        $this->form_validation->set_rules('package_amount', 'Subscription Cost', 'required|numeric');
        //$this->form_validation->set_rules('package_credit', 'Packages Credit', 'required|numeric');
        $this->form_validation->set_rules('features[]', 'Features', 'required');
        $this->form_validation->set_rules('duration_id', 'Duration', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'packages/subscription_edit';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Update Subscription Information ');
            $page_data['page_form_line'] = get_phrase('Update Subscription');
            $page_data['package_id']     = $package_id;
            $this->load->view('apanel', $page_data);
        } else {
            $updated                     = $this->crud_model->edit_packages($package_id);
            $page_data['package_id']     = $package_id;
            $page_data['page_title']     = get_phrase('Update Subscription Information');
            $page_data['page_form_line'] = get_phrase('Update Subscription');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('Subscription Update successfully'));
                redirect('apanel/subscription_edit/' . $package_id, 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    //packages
    public function packages($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'delete')
            $this->crud_model->delete_caliber($param2);
        
        $page_data['page_name']  = 'packages/package_list';
        $page_data['page_title'] = get_phrase('packages Information');
        $this->load->view('apanel', $page_data);
    }
    
    public function package_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('package_name', 'Package Name', 'required');
        $this->form_validation->set_rules('package_amount', 'Packages Cost', 'required|numeric');
        //$this->form_validation->set_rules('package_credit', 'Packages Credit', 'required|numeric');
        $this->form_validation->set_rules('features[]', 'Features', 'required');
        $this->form_validation->set_rules('duration_id', 'Duration', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        //print_r($_POST);exit;
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_name']      = 'packages/package_add';
            $page_data['page_title']     = get_phrase('Create Package Page');
            $page_data['page_form_line'] = get_phrase('Create Package');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_package();
            $page_data['page_name']      = 'packages/package_add';
            $page_data['page_title']     = get_phrase('Create Package Page');
            $page_data['page_form_line'] = get_phrase('Create Package');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('Package added successfully'));
            } else {
                $this->session->set_flashdata('error', get_phrase(''));
            }
            $this->load->view('apanel', $page_data);
        }
    }
    function package_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $package_id =$this->uri->segment(3);
        $this->form_validation->set_rules('package_name', 'Package Name', 'required');
        $this->form_validation->set_rules('package_amount', 'Packages Cost', 'required|numeric');
        //$this->form_validation->set_rules('package_credit', 'Packages Credit', 'required|numeric');
        $this->form_validation->set_rules('features[]', 'Features', 'required');
        $this->form_validation->set_rules('duration_id', 'Duration', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $page_data['page_name']  = 'packages/package_edit';
        if ($this->form_validation->run() == FALSE){
            $page_data['page_title'] = get_phrase('Update Package Information ');
            $page_data['page_form_line'] = get_phrase('Update Package');
            $page_data['package_id'] = $package_id;   
            $this->load->view('apanel', $page_data);
        }
        else{
            $updated = $this->crud_model->edit_packages($package_id);
            $page_data['package_id'] = $package_id;   
            $page_data['page_title'] = get_phrase('Update Package Information');
            $page_data['page_form_line'] = get_phrase('Update Package');
            if(!empty($updated)){
              $this->session->set_flashdata('success' , get_phrase('Package Update successfully'));
              redirect('apanel/package_edit/'.$package_id, 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    
    /* ADVANCED CALLER DETAILS HANDLERS */
    
    public function calls_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $page_data['page_name']  = 'userinfo/incoming_list';
        $page_data['page_title'] = get_phrase('Calls Details');
        $this->load->view('apanel', $page_data);
    }
    
    public function incoming_details()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $client_id = $this->uri->segment(3);
        /*$this->db->where('AccountSid',$owner_account_sid);
        $income_calls = $this->db->get('incoming_call_details')->result_array();*/
        //print_r($income_calls);
        $this->db->where('client.client_id', $client_id);
        $client = $this->db->get('client')->result_array();
        $this->db->where('Direction', 'inbound');
        $this->db->where('AccountSid', $client[0]['subaccount_sid']);
        $income_calls              = $this->db->get('incoming_call_details')->result_array();
        //print_r($income_calls);exit;
        $page_data['page_name']    = 'userinfo/incoming_details';
        $page_data['page_title']   = get_phrase('incoming_details');
        $page_data['income_calls'] = $income_calls;
        $this->load->view('apanel', $page_data);
        /*$this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('frontend/report_page' , array('member'=>$member) , true);
        $data = pdf_create($html, 'Statment_'.$member[0]['fname'].' '.$member[0]['lname'], true);
        write_file('./uploads/report/statment_'.$member[0]['fname'].' '.$member[0]['lname'].'.pdf', $data);*/
    }

    public function advanced_details(){

        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $client_id = $this->uri->segment(3);
        if($client_id!='')
            $advance_calls = $this->db->query("select * from latest_callups cl left join advanced_caller_details ac on ac.phoneNumber = cl.phonenumber where client_id=".$client_id." group by ac.phoneNumber order by date_added desc")->result_array();
        else  $advance_calls = $this->db->query("select * from latest_callups cl left join advanced_caller_details ac on ac.phoneNumber = cl.phonenumber group by ac.phoneNumber order by date_added desc")->result_array();

        $page_data['page_name'] = 'userinfo/advanced_details';
        $page_data['page_title'] = get_phrase('advanced_details');
        $page_data['advance_calls'] = $advance_calls;
        $this->load->view('apanel', $page_data);
    } 
    
    /* CMS HANDLERS */
    
    public function faq($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'delete')
            $this->crud_model->delete_faq($param2);
        
        $page_data['page_name']  = 'faq/faq_list';
        $page_data['page_title'] = get_phrase('Frequently asked questions');
        $this->load->view('apanel', $page_data);
    }
    
    public function faq_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'faq/faq_add';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Create Faq Page');
            $page_data['page_form_line'] = get_phrase('Create Faq');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_faq();
            $page_data['page_title']     = get_phrase('Create Faq Page');
            $page_data['page_form_line'] = get_phrase('Create Faq');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('Faq added successfully'));
                redirect('apanel/faq/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Faq Not added successfully'));
                redirect('apanel/faq/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function faq_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $faq_id = $this->uri->segment(3);
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'faq/faq_edit';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Update Faq Information ');
            $page_data['page_form_line'] = get_phrase('Update Faq');
            $page_data['faq_id']         = $faq_id;
            $this->load->view('apanel', $page_data);
        } else {
            $updated                     = $this->crud_model->edit_faq($faq_id);
            $page_data['faq_id']         = $faq_id;
            $page_data['page_title']     = get_phrase('Update Faq Information ');
            $page_data['page_form_line'] = get_phrase('Update Faq');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('Faq update successfully'));
                redirect('apanel/faq/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Faq Not update successfully'));
                redirect('apanel/faq/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    
    public function works($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'delete')
            $this->crud_model->delete_works($param2);
        $page_data['page_name']  = 'works/works_list';
        $page_data['page_title'] = get_phrase('How It Works?');
        $this->load->view('apanel', $page_data);
    }
    
    public function works_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('title', 'Enter Description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'works/works_add';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Create How It Works Page');
            $page_data['page_form_line'] = get_phrase('Create How It Works?');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_works();
            $page_data['page_title']     = get_phrase('Create How It Works Page');
            $page_data['page_form_line'] = get_phrase('Create How It Works?');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('How It Works added successfully'));
                redirect('apanel/works/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('How It Works Not added successfully'));
                redirect('apanel/works/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function works_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $works_id = $this->uri->segment(3);
        $this->form_validation->set_rules('title', 'Enter Description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'works/works_edit';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Update How It Works Information ');
            $page_data['page_form_line'] = get_phrase('Update How It Works?');
            $page_data['works_id']       = $works_id;
            $this->load->view('apanel', $page_data);
        } else {
            $updated                     = $this->crud_model->edit_works($works_id);
            $page_data['works_id']       = $works_id;
            $page_data['page_title']     = get_phrase('Update How It Works Information ');
            $page_data['page_form_line'] = get_phrase('Update How It Works?');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('How It Works update successfully'));
                redirect('apanel/works/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('How It Works Not update successfully'));
                redirect('apanel/works/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function team($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'delete')
            $this->crud_model->delete_team($param2);
        $page_data['page_name']  = 'team/team_list';
        $page_data['page_title'] = get_phrase('Team Member');
        $this->load->view('apanel', $page_data);
    }
    
    public function team_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('title', 'Enter Description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'team/team_add';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Team Page');
            $page_data['page_form_line'] = get_phrase('Create Team');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_team();
            $page_data['page_title']     = get_phrase('Create Team Page');
            $page_data['page_form_line'] = get_phrase('Create Team');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('Team added successfully'));
                redirect('apanel/team/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Team Not added successfully'));
                redirect('apanel/team/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function team_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $team_id = $this->uri->segment(3);
        $this->form_validation->set_rules('title', 'Enter Description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'team/team_edit';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Update Team Information ');
            $page_data['page_form_line'] = get_phrase('Update Team');
            $page_data['team_id']        = $team_id;
            $this->load->view('apanel', $page_data);
        } else {
            $updated                     = $this->crud_model->edit_team($team_id);
            $page_data['team_id']        = $team_id;
            $page_data['page_title']     = get_phrase('Update Team Information ');
            $page_data['page_form_line'] = get_phrase('Update Team?');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('Team update successfully'));
                redirect('apanel/team/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Team Not update successfully'));
                redirect('apanel/team/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function services($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param1 == 'delete')
            $this->crud_model->delete_services($param2);
        $page_data['page_name']  = 'services/our_services';
        $page_data['page_title'] = get_phrase('Our Services');
        $this->load->view('apanel', $page_data);
    }
    
    public function services_add()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $this->session->set_flashdata('sucess', get_phrase(''));
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'services/add_services';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Create Services Page');
            $page_data['page_form_line'] = get_phrase('Create Services');
            $this->load->view('apanel', $page_data);
        } else {
            $inserted_id                 = $this->crud_model->create_services();
            $page_data['page_title']     = get_phrase('Create Services Page');
            $page_data['page_form_line'] = get_phrase('Create Services');
            if (!empty($inserted_id)) {
                $this->session->set_flashdata('success', get_phrase('Services added successfully'));
                redirect('apanel/services/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Services Not added successfully'));
                redirect('apanel/services/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    
    public function services_edit($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $services_id = $this->uri->segment(3);
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
            $page_data['page_name']      = 'services/edit_services';
        if ($this->form_validation->run() == FALSE) {
            $page_data['page_title']     = get_phrase('Update Services Information ');
            $page_data['page_form_line'] = get_phrase('Update Services');
            $page_data['services_id']    = $services_id;
            $this->load->view('apanel', $page_data);
        } else {
            $updated                     = $this->crud_model->edit_services($services_id);
            $page_data['services_id']    = $services_id;
            $page_data['page_title']     = get_phrase('Update Services Information ');
            $page_data['page_form_line'] = get_phrase('Update Services');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('Services update successfully'));
                redirect('apanel/services/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('Services Not update successfully'));
                redirect('apanel/services/', 'refresh');
            }
            $this->load->view('apanel', $page_data);
        }
    }
    public function twilio_prices()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ( isset($_POST['price_call_in']) ) {
            $this->crud_model->update_setting_with('price_call_in',$this->input->post('price_call_in') );
            $this->crud_model->update_setting_with('price_call_lookup',$this->input->post('price_call_lookup') );
            $this->crud_model->update_setting_with('price_call_transcripts',$this->input->post('price_call_transcripts') );
            $this->crud_model->update_setting_with('price_call_minutes',$this->input->post('price_call_minutes') );
            $this->crud_model->update_setting_with('price_phone_numbers',$this->input->post('price_phone_numbers') );
            $this->crud_model->update_setting_with('price_send_sms',$this->input->post('price_send_sms') );
            $this->crud_model->update_setting_with('price_received_sms',$this->input->post('price_received_sms') );
            $this->crud_model->update_setting_with('price_send_mms',$this->input->post('price_send_mms') );
            $this->crud_model->update_setting_with('price_received_mms',$this->input->post('price_received_mms') );
            $this->crud_model->update_setting_with('price_social_ad',$this->input->post('price_social_ad' ) );
                $this->session->set_flashdata('success', get_phrase('Twilio Prices Updated'));
                redirect('apanel/twilio_prices/', 'refresh');
        }
        $page_data['page_name']  = 'settings/twilio_prices';
        $page_data['page_title'] = get_phrase('Cost Settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $noviset = new stdClass();
        foreach($page_data['settings']  as $sets) {
            $noviset->{$sets['type']} = $sets['description'];
        }
            $page_data['data'] = $noviset;
        $this->load->view('apanel', $page_data);
    }
    
    public function banner($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        $page_data['page_name']  = 'banners/banner_list';
        $page_data['page_title'] = get_phrase('banner_list');
        $page_data['settings']   = $this->db->get('tbl_banner')->result_array();
        $this->load->view('apanel', $page_data);
    }
    
    public function banner_edit($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        if ($param2 == 'do_update') {
            $newFileName                  = $_FILES['userfile']['name'];
            $configVideo['upload_path']   = './uploads/banner_video'; # check path is correct
            $configVideo['max_size']      = '2024000';
            $configVideo['allowed_types'] = 'mp4|3gp|flv|mp3'; # add video extenstion on here
            $configVideo['overwrite']     = TRUE;
            $configVideo['remove_spaces'] = TRUE;
            //$video_name = 'video_banner';
            $video_name                   = random_string('numeric', 5);
            $configVideo['file_name']     = $video_name;
            $this->load->library('upload', $configVideo);
            $this->upload->initialize($configVideo);
            if (!$this->upload->do_upload('userfile')) # form input field attribute
                {
                # Upload Failed
                $this->session->set_flashdata('error1', $this->upload->display_errors());
                redirect('apanel/banner/', 'refresh');
            } else {
                # Upload Successfull
                $url         = $video_name;
                $description = $this->input->post('content');
                $data        = array(
                    'video' => $url,
                    'description' => $description
                );
                //print_r($data);exit;
                $this->db->where('banner_id', $param1);
                $updated = $this->db->update('tbl_banner', $data);
                if (!empty($updated)) {
                    $this->session->set_flashdata('success', get_phrase('Banner update successfully'));
                    redirect('apanel/banner/', 'refresh');
                } else {
                    $this->session->set_flashdata('error', get_phrase('Banner Not update successfully'));
                    redirect('apanel/banner/', 'refresh');
                }
            }
        }
        $page_data['page_name']  = 'banners/banner_edit';
        $page_data['page_title'] = get_phrase('banner_edit');
        $page_data['banner_id']  = $param1;
        $this->load->view('apanel', $page_data);
    }

    public function promos($action = '', $p_id = 0)
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }

        $this->db->select('*');
        $this->db->from('packages');
        $this->db->where(array(
            'status' => '1'
        ));
        $subsrs = $this->db->get()->result_array();
        $numsubs = (int) count( $subs);
        $subs = array();
        foreach($subsrs as $sr) {
            $subs[$sr['package_id']] = $sr;
        }
        $page_data['subs'] = $subs;

        switch($action) {
            case 'delete':
                $page_data['promo_id'] = (int) $p_id;
                $this->crud_model->delete_promo($p_id);
                $this->session->set_flashdata('success', get_phrase('Promo deleted!'));
                redirect('apanel/promos/', 'refresh');

            break;
            case 'add':
                if (isset($_POST['promo_code'])) {
                    $data['promo_code']     = strtoupper($this->input->post('promo_code'));
                    $data['promo_code'] = str_replace(" ","_",$data['promo_code']);
                    $data['is_percent']     = $this->input->post('is_percent');
                    $data['discount']     = $this->input->post('discount');
                    $data['affect']     = $this->input->post('affect');
                    $data['used_max']     = $this->input->post('used_max');
                    $data['created'] = date("d-m-Y H:i:s");
                    $inserted             = $this->db->insert('ct_promos', $data);
                    if (!empty($inserted)) {
                        $this->session->set_flashdata('success', get_phrase('Content insert successfully'));
                        redirect('apanel/promos/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', get_phrase('Content Not insert successfully'));
                        redirect('apanel/promos/', 'refresh');
                    }
                }
                $page_data['page_name']  = 'promos/add';
                $page_data['page_title'] = get_phrase('Add Promo');

            break;
            case 'edit':
                     $page_data['promo_id'] = (int) $p_id;

                    $this->db->select('*');
                    $this->db->from('ct_promos');
                    $this->db->where(array(
                        'promo_id' => $p_id
                    ));

                    $promo_dat = $this->db->get()->result_array();
                    $page_data['pdat'] = $promo_dat[0];

                if (isset($_POST['promo_code'])) {
                    $data['promo_code']     = strtoupper($this->input->post('promo_code'));
                    $data['promo_code'] = str_replace(" ","_",$data['promo_code']);
                    $data['is_percent']     = $this->input->post('is_percent');
                    $data['discount']     = $this->input->post('discount');
                    $data['affect']     = $this->input->post('affect');
                    $data['used_max']     = $this->input->post('used_max');
                    $param1    = (int) $p_id;
                    $this->db->where('promo_id', $param1);
                    $updated = $this->db->update('ct_promos', $data);
                    if (!empty($updated)) {
                        $this->session->set_flashdata('success', get_phrase('Promo updated!'));
                        redirect('apanel/promos/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', get_phrase('Promo not updated!'));
                        redirect('apanel/promos/', 'refresh');
                    }
                }
                $page_data['page_name']  = 'promos/edit';
                $page_data['page_title'] = get_phrase('Edit Promo');

            break;
            default:
                $this->db->order_by('promo_id', 'asc');
                $page_data['list_promos']  = $this->db->get('ct_promos')->result_array();
                $page_data['page_name']  = 'promos/list';
                $page_data['page_title'] = get_phrase('Promos');
        }

        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('apanel', $page_data);
    }
    
    public function pages($action = '', $p_id = 0)
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url('apanel/login'), 'refresh');
        }
        switch($action) {
            case 'delete':
                $page_data['page_id'] = (int) $p_id;
                $this->crud_model->delete_page($p_id);
                $this->session->set_flashdata('success', get_phrase('Page deleted!'));
                redirect('apanel/pages/', 'refresh');

            break;
            case 'add':
                if (isset($_POST['content'])) {
                    $data['page_title']   = $this->input->post('page_title');
                    $data['page_heading'] = $this->input->post('page_heading');
                    $data['page_content'] = $this->input->post('content');
                    $inserted             = $this->db->insert('ct_pages', $data);
                    if (!empty($inserted)) {
                        $this->session->set_flashdata('success', get_phrase('Content insert successfully'));
                        redirect('apanel/pages/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', get_phrase('Content Not insert successfully'));
                        redirect('apanel/pages/', 'refresh');
                    }
                }
                $page_data['page_name']  = 'cms/add';
                $page_data['page_title'] = get_phrase('Add Page');

            break;
            case 'edit':
                     $page_data['page_id'] = (int) $p_id;
                if (isset($_POST['content'])) {
                    $data['page_title']       = $this->input->post('page_title');
                    $data['page_heading']     = $this->input->post('page_heading');
                    $data['page_content']     = $this->input->post('content');
                    $param1    = $this->input->post('page_id');
                    $data['timestamp_create'] = strtotime(date("d-m-Y H:i:s"));
                    $this->db->where('page_id', $param1);
                    $updated = $this->db->update('ct_pages', $data);
                    if (!empty($updated)) {
                        $this->session->set_flashdata('success', get_phrase('Page updated!'));
                        redirect('apanel/pages/', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', get_phrase('Page not updated!'));
                        redirect('apanel/pages/', 'refresh');
                    }
                }
                $page_data['page_name']  = 'cms/edit';
                $page_data['page_title'] = get_phrase('Edit Page');

            break;
            default:
                $this->db->order_by('page_id', 'asc');
                $page_data['list_pages']  = $this->db->get('ct_pages')->result_array();
                $page_data['page_name']  = 'cms/list';
                $page_data['page_title'] = get_phrase('CMS - Pages');
        }

        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('apanel', $page_data);
    }
    
    /* SETTINGS HANDLERS */
    
    // system settings
    public function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'do_update') {
            $updated = $this->crud_model->update_system_settings();
            if (!empty($updated)) {
                $this->session->set_flashdata('error', get_phrase('settings_notupdated'));
                redirect('apanel/system_settings/', 'refresh');
            } else {
                $this->session->set_flashdata('success', get_phrase('settings_updated'));
                redirect('apanel/system_settings/', 'refresh');
            }
        }
        if ($param1 == 'upload_logo') {
            //move_uploaded_file($_FILES['userfile']['tmp_name'], '/uploads/logo.png');
            $updated = move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            if (!empty($updated)) {
                $this->session->set_flashdata('success', get_phrase('settings_updated'));
                redirect('apanel/system_settings/', 'refresh');
            } else {
                $this->session->set_flashdata('error', get_phrase('settings_notupdated'));
                redirect('apanel/system_settings/', 'refresh');
            }
        }
        $page_data['page_name']  = 'settings/system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('apanel', $page_data);
    }
    
    // payment settings
    public function payment_settings($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($param1 == 'update_payment_settings') {
            $data['description'] = $this->input->post('stripe_api_key');
            $this->db->where('type', 'stripe_api_key');
            $this->db->update('settings', $data);
            $data['description'] = $this->input->post('stripe_publishable_key');
            $this->db->where('type', 'stripe_publishable_key');
            $this->db->update('settings', $data);
            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type', 'paypal_email');
            $this->db->update('settings', $data);
            $data['description'] = $this->input->post('system_currency_id');
            $this->db->where('type', 'system_currency_id');
            $this->db->update('settings', $data);


            $data['description'] = $this->input->post('paypal_cost_per_payment');
            $this->db->where('type', 'paypal_cost_per_payment');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('paypal_cost_per_payment_more');
            $this->db->where('type', 'paypal_cost_per_payment_more');
            $this->db->update('settings', $data);

            $this->session->set_flashdata('success', get_phrase('payment_settings_updated'));
            redirect('apanel/payment_settings', 'refresh');
        }
        $page_data['page_name']  = 'settings/payment_settings';
        $page_data['page_title'] = get_phrase('payment_settings');
        $this->load->view('apanel', $page_data);
    }
    
    
    
}