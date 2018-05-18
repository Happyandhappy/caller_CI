<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Twilio\Rest\Client;

class Signup extends CT_Base_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->library('pagination');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->AdminAccountSid = $this->db->get_where('settings', array('type' => 'account_sid'))->row()->description;
        $this->AdminAuthToken = $this->db->get_where('settings', array('type' => 'account_token'))->row()->description;
    }
    private function withPromo($cjena,$promocod,$pid) {

        $this->db->select('*');
        $this->db->from('ct_promos');
        $this->db->where(array(
            'promo_code' => $promocod
        ));

        $promo_dat = $this->db->get()->result_array();

        if(count($promo_dat)>0) {
            $promo = $promo_dat[0];

            if($promo['used_count']>=$promo['used_max']) {
                return $cjena; // code expired
            }

            /*$prom_Data['used_count'] = $promo['used_count']+1;
            $this->db->where('promo_id', $promo['promo_id'] );
            $this->db->update('ct_promos', $prom_Data);*/
            $cjen = $cjena;
            //var_dump($promo);
            if($promo['affect']==0) {
                if($promo['is_percent']) {
                    $cjen = round($cjen - ($cjen*($promo['discount']/100)),2);
                } else {
                    $cjen = round($cjen- $promo['discount'],2);
                }

            } else {
                if($promo['affect']==$pid) {

                    if($promo['is_percent']) {
                        $cjen = round($cjen - ($cjen*($promo['discount']/100)),2);
                    } else {
                        $cjen =  round($cjen- $promo['discount'],2);
                    }
                }
            }
            $cjena = $cjen;
        }
        //var_dump($cjena);
        return $cjena;

    }
    //Default function, redirects to logged in user area
    public function index() {
        $data['plan_id']      = intval($this->input->post('plan_id'));
        $data['promocode']      = $this->input->post('promocode');
        if( empty($data['plan_id']) || $data['plan_id'] == 0 )
            redirect(base_url('home/pricing'));
        
        $charges = $this->crud_model->fetch_package_pricing($data['plan_id']);
        $data['plan_amount']  = $charges['package_amount'];
        $data['plan_amount_new']      = $this->withPromo($data['plan_amount'],$data['promocode'],$data['plan_id']);

        if ($this->session->userdata('login_user_id')!='')
        {
            $session_Data['plan_id']            =    $this->input->post('plan_id');
            $session_Data['plan_amount']        =    $charges['package_amount'];
            $session_Data['promocode']          =    $data['promocode'];

            $this->session->set_userdata('signupData',$session_Data);
            redirect(base_url('payment/paypal_payment'));
        }

        $data['pixel_plname']  = $charges['package_name'];
        $data['pixel_plid']  = $data['plan_id'];
        $data['pixel_amount']  = $data['plan_amount_new'];

        $this->load->view('include/clientuser/head');
        $this->load->view('front/signup_tradesmen',$data);
        $this->load->view('include/clientuser/footer');
    }
    public function tradesmen() {
        $page_data['page_name'] = 'signup_tradesmen';
        $page_data['page_title'] = get_phrase('Trades-Men  signup');
        $this->load->view('/index', $page_data);
    }
    public function tradesmen_payment() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        //$this->form_validation->set_rules('contact', 'Contact No', 'required|callback_contact|is_unique[client.contact]');
        //$this->form_validation->set_rules('call_forward_no', 'Number', 'required');
        $this->form_validation->set_rules('email', 'User Email', 'required|valid_email|is_unique[client.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmed_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('terms', 'Check on Terms And Conditions', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['plan_id']     =   $this->input->post('plan_id');
            $data['plan_amount']  = $this->input->post('plan_amount');
            $data['promocode']  = $this->input->post('promocode');
            $this->load->view('include/clientuser/head');
            $this->load->view('front/signup_tradesmen',$data);
            $this->load->view('include/clientuser/footer');
        }
        else {
            $session_Data['plan_id']            =    $this->input->post('plan_id');
            $session_Data['plan_amount']        =    $this->input->post('plan_amount');
            $session_Data['first_name']         =    $this->input->post('first_name');
            $session_Data['last_name']          =    $this->input->post('last_name');
            $session_Data['contact']            =    $this->input->post('contact');
            $session_Data['call_forward_no']    =    $this->input->post('call_forward_no');
            $session_Data['email']              =    $this->input->post('email');
            $session_Data['password']           =    $this->input->post('password');
            $session_Data['company_name']       =    $this->input->post('company_name');
            $session_Data['promocode']          =    $this->input->post('promocode');

            $this->session->set_userdata('signupData',$session_Data);
            redirect('payment/paypal_payment', 'refresh');
        }
    }
    public function contact($call_forward_no)
    {
        $country_code       =   $this->input->post('pcountry_code');
        $state_code         =   $this->input->post('pstate_code');
        if ($call_forward_no !='' && $country_code!='' && $state_code!='')
        {
            $input_no = $country_code.$state_code.$call_forward_no;
            $this->db->select('contact');
            $this->db->from('client');
            $query  = $this->db->get();
            $results = $query->result();
            foreach($results as $data)
            {
                $call_fwd_no    = str_replace(array( '(', ')' ), ' ',$data->contact);
                $call_fwd_no    = explode('-',$call_fwd_no);
                $real_phone_no  = str_replace(' ','',$call_fwd_no[0].$call_fwd_no[1].$call_fwd_no[2]);
                if ($real_phone_no == $input_no)
                {
                    $this->form_validation->set_message('contact', 'The {field} field already exists.Re-enter country code ,state code and number');
                    return FALSE;
                }
            }
        }
        else
        {
            return TRUE;
        }
    }
    public function call_forward_no($call_forward_no)
    {
        $country_code       =   $this->input->post('country_code');
        $state_code     =   $this->input->post('state_code');
        if ($call_forward_no !='' && $country_code!='' && $state_code!='')
        {
            $input_no = $country_code.$state_code.$call_forward_no;
            $this->db->select('call_forward_no');
            $this->db->from('client');
            $query  = $this->db->get();
            $results = $query->result();
            foreach($results as $data)
            {
                $call_fwd_no    = str_replace(array( '(', ')' ), ' ',$data->call_forward_no);
                $call_fwd_no    = explode('-',$call_fwd_no);
                $real_phone_no  = str_replace(' ','',$call_fwd_no[0].$call_fwd_no[1].$call_fwd_no[2]);
                if ($real_phone_no == $input_no)
                {
                    $this->form_validation->set_message('call_forward_no', 'The {field} field already exists.Re-enter country code ,state code and number');
                    return FALSE;
                }
            }
        }
        else
        {
            return TRUE;
        }
    }
    public function call_forward_no_old($call_forward_no)
    {
        $country_code       =   $this->input->post('country_code');
        $state_code     =   $this->input->post('state_code');
        if ($call_forward_no !='' && $country_code!='' && $state_code!='')
        {
            $this->db->select('call_forward_no');
            $this->db->where('call_forward_no="'.'('.$country_code.') - '.$state_code.'-'.$call_forward_no.'"');
            $query = $this->db->get('client');
            $rowcount = $query->num_rows();
            if ($rowcount>0)
            {
                $this->form_validation->set_message('call_forward_no', 'The {field} field already exists.Re-enter country code ,state code and number');
                return FALSE;
            }
        }
        else
        {
            return TRUE;
        }
    }
    public function owner_subscription_payment() {
        //echo '<pre>';print_r($_REQUEST);exit;
        //if (($_REQUEST['payment_status']=='Completed' || $_REQUEST['st']=='Completed') && ($this->session->userdata('login_user_id')!='')) { 
        if ( ($this->session->userdata('login_user_id')!='') &&  $this->session->userdata('login_user_id') && isset($_POST["first_name"])) {
            $clientID = $this->session->userdata('login_user_id');
            $page_data['buyer_first_name']       =  $_POST["first_name"];// test
            $page_data['buyer_last_name']        =  $_POST["last_name"];// buyer
            $page_data['payer_address_country']  =  $_POST["residence_country"];// United Kingdom
            $page_data['payment_payer_email']    =  $_POST["payer_email"];// alttestdemo-buyer@gmail.com
            $page_data['payment_status']         =  $_POST['payer_status'];
            $page_data['payment_txn_id']         =  $_POST["subscr_id"];// 93172640FX364415P //seller
            $page_data['payment_receiver_email'] =  $_POST["receiver_email"];// alttestdemo-facilitator@gmail.com
            $page_data['payment_fee']            =  '0';//$_POST["payment_fee"];// 1.75
            $page_data['payment_auth']           =  $_POST["auth"];//
            $page_data['payment_mc_currency']    =  $_POST["mc_currency"];// USD
            $page_data['plan_name']              =  $_POST["item_name"];// subscription Title  ///plan title.
            $page_data['payment_gross_amount']   =  $_POST["amount3"];// 50.00
            $page_data['payment_date']           =  date('Y-m-d');// 03:08:27 Jun 20, 2016 PDT
            $page_data['qty']                    =  '1';//$_POST["quantity"];// 1
            $page_data['plan_id']                =  $_POST["custom"];// 1
            $page_data['client_id']              =  $clientID;// 1
            $this->db->insert('client_payment_details', $page_data);
            $payment_details_id = $this->db->insert_id();
            $USerDetails  = $this->db->get_where('client', array('client_id' => $clientID))->row();
            $package_details = $this->crud_model->get_records('packages','',array('package_id'=>$_POST["custom"]),'');
            $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array('client_id' => $clientID))->row();
            $phoneAmount = $package_details[0]['duration_id'] * $clientPhoneDetails->phoneNumber_price;
            if ($phoneAmount >0) { 
                $availFundAmount = $phoneAmount - $_POST["payment_gross"];            
            }else {                
                $availFundAmount = $_POST["payment_gross"];            
            }
            /* UPDATE BALANCE */
            $cleint_Data['available_fund']      = $USerDetails->available_fund + $availFundAmount;// 50.00
            $this->db->where('client_id', $clientID);
            $client_id =$this->db->update('client', $cleint_Data);

            $totalPhoneSubscription =   $clientPhoneDetails->phoneNumber_price * $package_details[0]['duration_id'];
            if ($totalPhoneSubscription !=0) {
                $insert_data_pay['client_id']               =   $clientID;
                $insert_data_pay['payment_gross_amount']    =   -$totalPhoneSubscription;
                $insert_data_pay['plan_name']               =   'payment_against_number_purchase-'.$clientPhoneDetails->phoneNumber.'-'.$clientPhoneDetails->phone_country;
                $insert_data_pay['payment_date']            =    date("Y-m-d");
                $insert_data_pay['payment_mc_currency'] =   $_POST["mc_currency"];// USD
                $this->db->insert('client_payment_details', $insert_data_pay);

                $page_data['pixel_purchage_amount']    =   $$package_details[0]['package_amount'];;
                $page_data['pixel_purchage_plid']    =   $package_details[0]['package_id'];
                $page_data['pixel_purchage_plname']    =   $package_details[0]['package_name'];
            }
            $system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
            $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
            $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
            $message='<html>
                     <body>
                     <p>Dear <strong>'.$data['name'].' '.$data['lname'].'</strong>,</p>
                     <p>First of all we want to thank you for you\'re interest in our services!</p>
                     <p>We welcome you at '.$system_title.'! </p>
                     <p><b><strong>You have successfully renewed your package, to following Packages :</strong></b> </p>
                     <table border="1">
                     <tr>
                     <th>Package Name</th>
                     <th>Package Amount</th><th>Validity</th>
                     <th>Description</th>
                     </tr>
                     <tr>
                     <td>'.$package_details[0]['package_name'].'</td>
                     <td>'.$package_details[0]['package_amount'].'</td><td>'.$package_details[0]['duration_id'].' months.</td>
                     <td>'.$package_details[0]['description'].'</td>
                     </tr>
                     </table>
                     <p><b><strong>Your Account Details are: </strong> </b><small><em>(Please do not disclose your account credentials to any one )</em></small></p>
                     <p><strong>Login Email :  </strong> '.$signupData["email"].'</p>
                     <p><strong>Login password : </strong>'.$signupData["password"].'  </p>
                     <p><strong>You can get account here  : </strong>'.base_url().'login </p>
                     </body><br /><br /><br /><br /><br />
                     <p>Regards , </p>
                     <p>'.$system_name.'</p>
                     </html>';
                    $this->load->library('email'); 
                    $this->email->from($system_email, $system_title);
                    $this->email->to($signupData["email"]);
                    $this->email->subject('Successfully Renewed Package');
                    $this->email->message($message);
                    $this->email->send();
            $page_data['page_name']  = 'signupSucess';
            $page_data['page_title'] = get_phrase('Signed up Successfully!');
            $this->load->view('index', $page_data);
        }
        $signupData                 = array();
        $signupData                 = $this->session->userdata('signupData');
        $kolkoUpl = $signupData['plan_amount'];
        if ($this->session->userdata('login_user_id')=='' && $this->session->userdata('signupData')) {
        //if (($_REQUEST['payment_status']=='Completed' || $_REQUEST['st']=='Completed') && ($this->session->userdata('login_user_id')=='')) {
            $data['name']               = $signupData["first_name"];
            $data['lname']              = $signupData["last_name"];
            $data['email']              = strtolower($signupData["email"]);
            $data['contact']            = $signupData["contact"];
            $data['password']           = sha1($signupData["password"]);
            $data['company_name']       = $signupData["company_name"];
            $data['call_forward_no']    = $signupData["call_forward_no"];
            $data['subscription_amt']   = $signupData['plan_amount'];
            
            $data['subscription_amt']      = $kolkoUpl;

            $data['available_fund']     = $signupData['plan_amount'];
            $data['subscription_id']    = $signupData['plan_id'];
            $data['status']             = 1;
            $this->db->insert('client', $data);
            $clientID = $this->db->insert_id();
            $clientdetails = $this->db->get_where('client', array('client_id' => $clientID ))->row();
            $AccountSid = $this->AdminAccountSid;
            $AuthToken = $this->AdminAuthToken;
            $client_id = $clientID;
            $subaccountName = $signupData["first_name"] . '_' . $signupData["last_name"] . '_' . $client_id;
            $data = new Client($AccountSid, $AuthToken);
            $account = $data->accounts->create(array("friendlyName" => $subaccountName));
            $friendlyName = $account->friendlyName;
            $sid = $account->sid;
            $auth_token = $account->authToken;
            $subaccount_status = $account->status;
            $ownerAccountSid = $account->ownerAccountSid;
            $data = array('subaccount_created' => 'y', 'subaccount_name' => $friendlyName, 'subaccount_sid' => $sid, 'auth_token' => $auth_token, 'subaccount_status' => $subaccount_status, 'owner_account_sid' => $ownerAccountSid);
            $this->db->where('client_id', $client_id);
            $updatesID = $this->db->update('client', $data);

            /*  Email verification email*/ 

                $this->db->where('client_id', $client_id);
                $rez = $this->db->get('client')->result_array();
                $client = $rez[0];

                $message = '<h3 style="text-align:center">Click The Button To Verify Your Email Address</h3>
                    <div style="text-align:center;"><hr/>
                    <a class="btn-orange btn-oring" href="'.base_url().'clientuser/email_verify/'.$account->sid.'">Verify Account</a>
                    <hr/>
                    <b>In case the button does not work, here is the link in plain format:</b><br/>
                    '.base_url().'clientuser/email_verify/'.$account->sid.'</div>';

                $system_email = $this->system_noreplymail;
                $system_title = $this->system_title;
                $this->email->set_mailtype("html");
                $this->email->from($system_email, $system_title);
                $this->email->to($client['email']);
                $this->email->subject('Verify Account');
                $pag_data['main_content'] = $message;
                $e_msg = $this->load->view('email/basic', $pag_data, true);
                $this->email->message($e_msg);
                $this->email->send();
                

            /*  Email verification email*/ 
            $page_data['buyer_first_name']       =  $_POST["first_name"];
            $page_data['buyer_last_name']        =  $_POST["last_name"];
            $page_data['payer_address_country']  =  $_POST["residence_country"];
            $page_data['payment_payer_email']    =  $_POST["payer_email"];
            $page_data['payment_status']         =  $_POST['payer_status'];
            $page_data['payment_txn_id']         =  $_POST["subscr_id"];
            $page_data['payment_receiver_email'] =  $_POST["receiver_email"];
            $page_data['payment_fee']            =  '0';//$_POST["payment_fee"];
            $page_data['payment_auth']           =  $_POST["auth"];
            $page_data['payment_mc_currency']    =  $_POST["mc_currency"];
            $page_data['plan_name']              =  $_POST["item_name"];
            $page_data['payment_gross_amount']   =  $_POST["amount3"];
            $page_data['payment_date']           =  date('Y-m-d');
            $page_data['qty']                    =  '1';//$_POST["quantity"];
            $page_data['plan_id']                =  $_POST["custom"];
            $page_data['client_id']              =  $clientID;

            $has_paid = false;
            if($page_data['buyer_first_name']!='') {

                $this->db->insert('client_payment_details', $page_data);
                $payment_details_id = $this->db->insert_id();
                $has_paid = true;
            }
            $package_details = $this->crud_model->get_records('packages','',array('package_id' => $signupData['plan_id']),'');
            $system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
            $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
            $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
            $message='<html>
                     <body>
                     <p>Dear <strong>'.$data['name'].' '.$data['lname'].'</strong>,</p>
                     <p>First of all we want to thank you for you\'re interest in our services!</p>
                     <p>We welcome you at '.$system_title.'! </p>
                     <p><b><strong>You have subscribed to following Packages.You have successfull made payment for :</strong></b> </p>
                     <table border="1">
                     <tr>
                     <th>Package Name</th>
                     <th>Package Amount</th><th>Validity</th>
                     <th>Description</th>
                     </tr>
                     <tr>
                     <td>'.$package_details[0]['package_name'].'</td>
                     <td>'.$package_details[0]['package_amount'].'</td><td>'.$package_details[0]['package_id'].' months.</td>
                     <td>'.$package_details[0]['description'].'</td>
                     </tr>
                     </table>
                     <p><b><strong>Your Account Details are: </strong> </b><small><em>(Please do not disclose your account credentials to any one )</em></small></p>
                     <p><strong>Login Email :  </strong> '.$signupData["email"].'</p>
                     <p><strong>Login password : </strong>'.$signupData["password"].'  </p>
                     <p><strong>You can get account here  : </strong>'.base_url().'login </p>
                     </body><br /><br /><br /><br /><br />
                     <p>Regards , </p>
                     <p>'.$system_name.'</p>
                     </html>';
            $this->load->library('email'); 
            if(!isset( $page_data['pixel_purchage_amount'] )) {
                $page_data['pixel_purchage_amount']    =   $kolkoUpl;
                $page_data['pixel_purchage_plid']    =   $package_details[0]['package_id'];
                $page_data['pixel_purchage_plname']    =   $package_details[0]['package_name'];
            }

            $signupData                 = $this->session->unset_userdata('signupData');
        }
        var_dump($page_data);
            if($kolkoUpl<=0)
                $page_data['page_name']     = 'signupSucess_basic';
            else
                $page_data['page_name']     = 'signupSucess';
            $page_data['page_title']    = get_phrase('Signed up Successfully!');            
            $this->load->view('home', $page_data);
    }
    function ajax_become_owner() {
        $resp                     = array();
        $data['name']             = $_POST["name"];
        $data['lname']            = $_POST["lname"];
        $data['email']            = $_POST["email"];
        $data['subscription_id']  = $_POST["subscription_id"];
        $data['subscription_amt'] = $_POST["subscription_amt"];
        $data['name']             = $_POST["name"];
        $data['lname']            = $_POST["lname"];
        $data['store_name']       = $_POST["store_name"];
        $data['email']            = $_POST["email"];
        $data['address']          = $_POST["address"];
        $data['city']             = $_POST["city"];
        $data['state']            = $_POST["state"];
        $data['country']          = $_POST["country"];
        $data['phone']            = $_POST["phone"];
        $data['zip_code']         = $_POST["zip_code"];
        $data['account_role_id']  = 1;
        $this->db->insert('staff', $data);
        $reset_account_type = $this->db->insert_id();
        $this->email_model->notify_email('new_staff_account_opening' , $reset_account_type , $email , $new_password);
        $resp['submitted_data'] = $_POST;
        echo json_encode($resp);
    }
    function isEmailExist($str) {
        $record_id = $this->input->post('record_id');
        $condition = array('user_id !='=>$record_id,'username'=>$str);
        $value =GetAllRecord('user_master',$condition,$is_single=true);
        if (count($value) == 0) {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('exists_username', 'username already exists!');
            return FALSE;
        }
    }
    function email_check()
    {
        $email=$_POST['email'];
        $this->db->where('email',$email);
        $test = $this->db->get('staff')->result_array();
        if (count($test) > 0) {
            echo 'false';
        }
        else {
            echo 'true';
        }
    }
    function email_user()
    {
        $email=$_POST['email'];
        $this->db->where('email',$email);
        $test = $this->db->get('client')->result_array();
        if (count($test) > 0) {
            echo 'false';
        }
        else {
            echo 'true';
        }
    }
    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(). 'index.php?tutor_signup/' , 'refresh');
    }
}