<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Twilio\Rest\Client;

class Clientuser extends CT_Base_Controller
{
    public $client;

    function __construct()
    { 
        parent::__construct();
        $this->AdminAccountSid = $this->TwilioSettings['AccountSID'];
        $this->AdminAuthToken  = $this->TwilioSettings['AccountAuthToken'];
        
    }
    public function index()
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('client_login') == 1)
            redirect(base_url() . 'clientuser/dashboard', 'refresh');
    }

    public function del_lookup($cid) {
        
        $this->db->select('*');
        $this->db->from('caller_look_up');
        $this->db->where(array(
            'client_id' => $this->current_client->client_id,
            'id' => $cid,
        ));
        $phoneNumber = $this->db->get()->row();

        $this->db->where('phonenumber',$phoneNumber->phonenumber);        
        $this->db->where('client_id',$phoneNumber->client_id);
        $this->db->delete('caller_look_up');

        $this->session->set_flashdata('flash_message', 'The Record Has Been Removed!');
        redirect(base_url() . 'clientuser/number_lookup', 'refresh');
    }


    ########### PRICING ##############
    public function address_printing(){
        $page_data['page_name'] = 'address_printing';
        $page_data['page_title'] = get_phrase('Address Printing');
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }
    
    private function get_balance($id = null)
    {
        if (!$id) {
            $id = $this->session->userdata('login_user_id');
        }
        
        $this->db->where('client_id', $id);
        $client = $this->db->get('client')->result_array();
        return (float) round($client[0]['available_fund'],4);
    }
    
    public function readd_all_client_manual($id = null)
    {
        if (!$id) {
            $id = $this->session->userdata('login_user_id');
        }
        
        $this->db->where('client_id', $id);
        $client = $this->db->get('client')->result_array();

            $this->db->select('*');
            $this->db->from('caller_look_up');
            $this->db->where(array(
                'client_id' => $id,
                'location' => 'manual',
            ));
            $phoneNumbers = $this->db->get()->result_array();

            $usr      = $this->db->get_where('client', array(
                'client_id' => $id
            ))->result_array();
            $user = $usr[0];

            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased');
            $this->db->where(array(
                'client_id' => $id,
                'status' => 'active',
            ));
            $phoneNumberes = $this->db->get()->result_array();

            foreach($phoneNumbers as $num) {

                foreach ($phoneNumberes as $ph) {  

                   $calls_reade = $this->db->get_where('advanced_caller_details', array(
                        'phoneNumber=' => $num['phonenumber']
                    ),30)->result_array();

                    $this->update_cust_audience($calls_reade,$user['accesstoken'], $ph['custom_audience_id']);
                }
            }
    }


    private function update_cust_audience($calls_read,$accesstoken,$custom_audience_id) {


         /*   $calls_read = $this->db->get_where('advanced_caller_details', array(
                'caller_id<' => 640,
                'caller_id>' => 400,
                'first_name!=' => '',
                'linked_emails!=' => ''
            ))->result_array();
            $calls_read = array_slice($calls_read,0,25);
            */

            $payload         = new stdClass;
            $payload->schema = array(
                'EMAIL',
                'FN',
                'LN',
                'GEN',
                'ST',
                'ZIP',
                'COUNTRY'
            );
            $payload->data   = array();
            foreach ($calls_read as $c) {
                #die(var_dump($c));
                $emails = explode('#', $c['linked_emails']);
                if ($emails[0]) {
                    $emails_exploded = explode('=', $emails[0]);
                    $email_send      = $emails_exploded[1];
                } else {
                    $email_send = '';
                }
                if ($c['gender']) {
                    if ($c['gender'] == 'Male') {
                        $gender_send = 'M';
                    } else {
                        $gender_send = 'F';
                    }
                } else {
                    $gender_send = '';
                }
                if ($c['first_name']) {
                    $first_character_send = $c['first_name'][0];
                } else {
                    $first_character_send = '';
                }
                if ($c['address_state']) {
                    $state_send = $c['address_state'];
                } else {
                    $state_send = '';
                }
                if ($c['address_zip_code']) {
                    $zip_send = $c['address_zip_code'];
                } else {
                    $zip_send = '';
                }
                if ($c['countryCode']) {
                    $country_send = $c['countryCode'];
                } else {
                    $country_send = '';
                }
                
                
                //$payload->data[] = array(hash('sha256', $c['first_name']), hash('sha256', $c['last_name']));
                $payload->data[] = array(
                    (/*hash('sha256',*/ $email_send),
                    (/*hash('sha256',*/ $c['first_name']),
                    (/*hash('sha256',*/ $c['last_name']),
                    (/*hash('sha256',*/ $gender_send),
                    (/*hash('sha256',*/ $state_send),
                    (/*hash('sha256',*/ $zip_send),
                    (/*hash('sha256',*/ $country_send),
                );
            }
            //var_dump($payload);

        $acc_tok = $accesstoken;
        $cst_id = $custom_audience_id;

        $url    = 'https://graph.facebook.com/v2.10/' . $cst_id . '/users';
        $fields = array(
            'payload' => json_encode($payload),
            'access_token' => $acc_tok
        );
        
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
            
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        
        //execute post
        $result = curl_exec($ch);
        return $result;
            
    }

    private function _tw_addons($tw_uname='', $tw_upass='', $act='',$addon='')
    {
        $addons_available = array(
            'nextcaller_advanced_caller_id' => 'XB73cdb5ac3395a439800f298fa8a43f02',
            'voicebase_transcription' => 'XB7afe11af3e292cadb03248e0066b8c1e'
        );        

        $this->load->library('restclient');

        $api = new Restclient([
            'base_url' => "https://preview.twilio.com/marketplace", 
            'username' => $tw_uname, 
            'password' => $tw_upass
        ]);

        $result = $api->get("InstalledAddOns");
        $resp = $result->decode_response();

        switch($act) {
            case 'uninstall':
                foreach($resp->installed_add_ons as $rs)
                    if($rs->unique_name == $addon) {
                        $result = $api->delete("InstalledAddOns/".$rs->sid);
                    }
            break;
            case 'install':

                foreach($resp->installed_add_ons as $rs)
                    if($rs->unique_name == $addon) {
                        return false;
                    }
                    $addon_config = '';
                    // special config for 'voicebase_transcription'
                    if($addon == 'voicebase_transcription') {
                        $addon_config = '{"callback_url":"https:\/\/callertech.com\/base\/save_transcript","callback_method":"POST","include-keywords":false,"include-topics":false}';

                    }

                $result = $api->post("InstalledAddOns",array(
                        'AvailableAddOnSid' => $addons_available[$addon],
                        'AcceptTermsOfService' => 'true',
                        'Configuration' => $addon_config
                    ));
                $resp = $result->decode_response();

                if(isset($resp->sid)) {
                    $ext_result = $api->get("InstalledAddOns/".$resp->sid."/Extensions");
                    $ext_resp = $ext_result->decode_response();

                    switch($addon) {
                        case 'nextcaller_advanced_caller_id':
                            foreach($ext_resp->extensions as $exz) {
                                if($exz->unique_name == 'lookup-api') {
                                    $ext_result = $api->post("InstalledAddOns/".$resp->sid."/Extensions/".$exz->sid,
                                        array('Enabled'=>'true'));
                                }
                            }

                        break;
                        case 'voicebase_transcription':
                            foreach($ext_resp->extensions as $exz) {
                                if($exz->unique_name == 'recording-dial') {
                                    $ext_result = $api->post("InstalledAddOns/".$resp->sid."/Extensions/".$exz->sid,
                                        array('Enabled'=>'true'));
                                }
                            }

                        break;
                        default:
                            return false;
                    }

                }
            break;
            default:
            if(! empty($resp->installed_add_ons) ) {
                foreach($resp->installed_add_ons as $rs)
                     return $rs;
            }
            else
                return 'No Add-on active!';

        }
    }
    // client dashboard
    public function dashboard()
    {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url() . 'login', 'refresh');
        }
        if ($this->session->userdata('admin_login') == 1) { 
            redirect(base_url() . 'logout', 'refresh');
        } 

        $client_Details = $this->db->where('client_id', $this->session->userdata('login_user_id'))->get('client')->result_array();
        $client_id = $client_Details[0]['client_id'];
        $charges = $this->crud_model->fetch_package_pricing($client_Details[0]['subscription_id']);
        if($charges['is_subscription'] == 1 && !$this->session->userdata('is_subscriber', $charges['is_subscription'])) {
            $this->session->set_userdata('is_subscriber', $charges['is_subscription']);
            redirect(base_url().'clientuser/dashboard', 'refresh');
        }
        if( !(empty($client_Details[0]['subaccount_sid'])) ) {

            if($charges['max_phone_numbers']<=0) {
                redirect(base_url('clientuser/number_lookup'), 'refresh');
            } else if($charges['max_phone_numbers']>0 && $this->crud_model->get_count_numbers($client_id)<1) {
                $this->session->set_userdata('last_page', current_url());
                redirect(base_url('clientuser/available_numbers'), 'refresh');
            }
        }

        $userdata                            = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['phone_number_purchased'] = '';
        $phoneNumber                         = $this->uri->segment(3);
        if (!empty($phoneNumber)) {
            $page_data['phone_number_purchased'] = $phoneNumber;
        }
        $graphs = array();

        $min_date = strtotime("-1 Months")-15;
        $max_date = strtotime(date("Y-m-d"));

        if(isset($_GET['filt_from']) && $_GET['filt_from']!='') {
            $min_date = strtotime($_GET['filt_from']);
        }
        if(isset($_GET['filt_to']) && $_GET['filt_to']!='') {
            $max_date = strtotime($_GET['filt_to']);
        }




        $page_data['lem_filt_from'] = date("Y-m-d",$min_date);
        $page_data['lem_filt_to'] = date("Y-m-d",$max_date);
        $page_data['lem_maxDana'] = $lmaxDana = (int) floor(($max_date - $min_date)/(3600*24));
        $page_data['lem_brDana'] = 30;
        $lem_brInk = 1;
        
        if($page_data['lem_maxDana']>30) {
            $page_data['lem_brDana'] = $page_data['lem_maxDana'];
            $lem_brInk = 1;
        } else if($page_data['lem_maxDana']>7) {
            $page_data['lem_brDana'] = $page_data['lem_maxDana'];
            $lem_brInk = 1;
        }else {
            $page_data['lem_brDana'] = $page_data['lem_maxDana'];
            $lem_brInk = 1;
        }
            $page_data['lem_brInk'] = $lem_brInk;



        // sms graph data
        { // start here...
            /* --- SMS GRAPH DATA */
            $this->db->select('date,COUNT(id) as count');
            $this->db->from('ct_messages ');
            if (empty($phoneNumber)) {
                $this->db->where(array(
                    'client_id' => (int) $this->session->userdata('login_user_id'),
                    'direction' => 'in'
                ),false);
            } else {
                $this->db->where(array(
                    'to' => $phoneNumber,
                    'direction' => 'in'
                ),false);
            }
            $this->db->where('(date LIKE "'.date("Y-m-",$max_date).'%" OR date LIKE "'.date("Y-m-",$min_date).'%")');
            /*$this->db->like('date', date("Y-m-"), 'after');
            $this->db->or_like('date', date("Y-m-",strtotime("-1 months")), 'after');*/
            $this->db->group_by('date');
            $query = $this->db->get();
            //var_dump($this->db->last_query());
            $rez = $query->result();
            /* fillout arrays*/
            foreach($rez as $rz) {
                $sd = strtotime($rz->date);
                if($sd>=$min_date && $sd<=$max_date) {
                    $graphs['sms_in'][$rz->date] = $rz->count;
                    $graphs['sms_in']['total'] += $rz->count;
                }
            }
            //var_dump($graphs);


            /* --- Check if has that phone number */
            $this->db->select('date,COUNT(id) as count');
            $this->db->from('ct_messages ');
            if (empty($phoneNumber)) {
                $this->db->where(array(
                    'client_id' => (int) $this->session->userdata('login_user_id'),
                    'direction' => 'out'
                ),false);
            } else {
                $this->db->where(array(
                    'from' => $phoneNumber,
                    'direction' => 'out'
                ),false);
            }
            $this->db->where('(date LIKE "'.date("Y-m-",$max_date).'%" OR date LIKE "'.date("Y-m-",$min_date).'%")');
            /*$this->db->like('date', date("Y-m-"), 'after');
            $this->db->or_like('date', date("Y-m-",strtotime("-1 months")), 'after');*/
            $this->db->group_by('date');
            $query = $this->db->get();
            //var_dump($this->db->last_query());
            $rez = $query->result();
            /* fillout arrays*/
            foreach($rez as $rz) {
                $sd = strtotime($rz->date);
                if($sd>=$min_date && $sd<=$max_date) {
                    $graphs['sms_out'][$rz->date] = $rz->count;
                    $graphs['sms_out']['total'] += $rz->count;
                }
            }

            /* TOTALS */
            /* --- Check if has that phone number - TOTAL */
            $this->db->select('COUNT(id) as total');
            $this->db->from('ct_messages ');
            if (empty($phoneNumber)) {
                $this->db->where(array(
                    'client_id' => (int) $this->session->userdata('login_user_id'),
                    'direction' => 'out'
                ),false);
            } else {
                $this->db->where(array(
                    'from' => $phoneNumber,
                    'direction' => 'out'
                ),false);
            }
            $rez = $this->db->get()->result();
            $total_sms_send = $rez[0]->total;

            /* --- Check if has that phone number - TOTAL */
            $this->db->select('COUNT(id) as total');
            $this->db->from('ct_messages ');
            if (empty($phoneNumber)) {
                $this->db->where(array(
                    'client_id' => (int) $this->session->userdata('login_user_id'),
                    'direction' => 'in'
                ),false);
            } else {
                $this->db->where(array(
                    'to' => $phoneNumber,
                    'direction' => 'in'
                ),false);
            }
            $rez = $this->db->get()->result();
            $total_sms_received = $rez[0]->total;
        }

        // call graph data
        { // start here..
             if ($client_Details[0]['subaccount_sid'] != '') {

                    $this->db->select('SUM(Duration) AS minutes, count(incoming_call_id) as total_call');
                    if( !empty($phoneNumber) ){
                        $this->db->where(array('AccountSid' => $client_Details[0]['subaccount_sid'], 'Direction' => 'inbound', 'forwardedFrom'=> $phoneNumber,'CallStatus' => 'completed'));
                    }
                    else{
                        $this->db->where(array('AccountSid' => $client_Details[0]['subaccount_sid'], 'Direction' => 'inbound','CallStatus' => 'completed'));
                    }
                    $income_calls = $this->db->get('incoming_call_details')->result_array();
                    $page_data['total_calls_in'] = $income_calls[0]['total_call'];
                    $page_data['total_calls_minutes'] = $income_calls[0]['minutes'];


                    $this->db->select('SUM(Duration) AS minutes, count(incoming_call_id) as total_call');
                    if( !empty($phoneNumber) ){
                        $this->db->where(array('AccountSid' => $client_Details[0]['subaccount_sid'], 'Direction' => 'outbound-dial', 'forwardedFrom'=> $phoneNumber,'CallStatus' => 'completed'));
                    }
                    else{
                        $this->db->where(array('AccountSid' => $client_Details[0]['subaccount_sid'], 'Direction' => 'outbound-dial','CallStatus' => 'completed'));
                    }
                    $OutboundCalls = $this->db->get('incoming_call_details')->result_array();
                    $page_data['total_calls_out'] = $OutboundCalls[0]['total_call'];
                    $page_data['total_calls_minutes'] = $OutboundCalls[0]['minutes'] + $page_data['total_calls_minutes'];

                    /* --- Check if has that phone number */
                    $this->db->select('Timestamp as date, COUNT(incoming_call_id) as count,SUM(Duration) as minutes');
                    $this->db->from('incoming_call_details');
                    if (empty($phoneNumber)) {
                        $this->db->where(array(
                            'AccountSid' => $client_Details[0]['subaccount_sid'],
                            'Direction' => 'inbound',
                            'CallStatus' => 'completed'
                        ),false);
                    } else {
                        $this->db->where(array(
                            'AccountSid' => $client_Details[0]['subaccount_sid'],
                            'forwardedFrom' => $phoneNumber,
                            'Direction' => 'inbound',
                            'CallStatus' => 'completed'
                        ),false);
                    }
                    $this->db->where('(Timestamp LIKE "'.date("Y-m-",$max_date).'%" OR Timestamp LIKE "'.date("Y-m-",$min_date).'%")');
                    //echo '(Timestamp LIKE "'.date("Y-m-",$max_date).'%" OR Timestamp LIKE "'.date("Y-m-",$min_date).'%")';
                    /*$this->db->like('Timestamp', date("Y-m-"), 'after');
                    $this->db->or_like('Timestamp', date("Y-m-",strtotime("-1 months")), 'after');*/
                    //$this->db->group_by('Timestamp');
                    $this->db->group_by('Timestamp');
                    $query = $this->db->get();
                    //var_dump($this->db->last_query());
                    $rez = $query->result();
                    /* fillout arrays*/
                    foreach($rez as $rz) {
                        $sd = strtotime($rz->date);
                        if($sd>=$min_date && $sd<=$max_date) {
                            $graphs['call_in'][$rz->date] = $rz->count;
                            $graphs['call_in']['total'] += $rz->count;

                            $graphs['call_minutes'][$rz->date] = $rz->minutes;
                            $graphs['call_minutes']['total'] += $rz->minutes;
                        }
                    }
                    $mints = $graphs['call_minutes']['total'];

                    /* Out */

                    $this->db->select('Timestamp as date, COUNT(incoming_call_id) as count,SUM(Duration) as minutes');
                    $this->db->from('incoming_call_details');
                    if (empty($phoneNumber)) {
                        $this->db->where(array(
                            'AccountSid' => $client_Details[0]['subaccount_sid'],
                            'Direction' => 'outbound-dial',
                            'CallStatus' => 'completed'
                        ),false);
                    } else {
                        $this->db->where(array(
                            'AccountSid' => $client_Details[0]['subaccount_sid'],
                            'forwardedFrom' => $phoneNumber,
                            'Direction' => 'outbound-dial',
                            'CallStatus' => 'completed'
                        ),false);
                    }
                    $this->db->where('(Timestamp LIKE "'.date("Y-m-",$max_date).'%" OR Timestamp LIKE "'.date("Y-m-",$min_date).'%")');
                    /*$this->db->like('Timestamp', date("Y-m-"), 'after');
                    $this->db->or_like('Timestamp', date("Y-m-",strtotime("-1 months")), 'after');*/
                    $this->db->group_by('Timestamp');
                    $query = $this->db->get();
                    //var_dump($this->db->last_query());
                    $rez = $query->result();
                    /* fillout arrays*/
                    $graphs['call_minutes']['total']= 0;
                    foreach($rez as $rz) {
                        $sd = strtotime($rz->date);
                        if($sd>=$min_date && $sd<=$max_date) {
                            $graphs['call_out'][$rz->date] = $rz->count;
                            $graphs['call_out']['total'] += $rz->count;
                            $prij = $graphs['call_minutes'][$rz->date];
                            $graphs['call_minutes'][$rz->date] = $rz->minutes + $prij;
                            $graphs['call_minutes']['total'] += $rz->minutes;
                        }
                    }
                   $graphs['call_minutes']['total'] += $mints; 

                //    $this->db->where('(Timestamp LIKE "'.date("Y-m-",$max_date).'%" OR Timestamp LIKE "'.date("Y-m-",$min_date).'%")');
                //    $this->db->group_by('Timestamp');
                //    $query = $this->db->get();
                //    $rez = $query->result();
                }


        }

        $page_data['page_name']  = 'dashboard';
        $page_data['graphs']  = $graphs;
        $page_data['charges']  = $charges; 
        $page_data['total_sms_send']  = $total_sms_send; 
        $page_data['total_sms_received']  = $total_sms_received; 
        $page_data['page_title'] = get_phrase('dashboard');
        $page_data['userdata']   = $userdata;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }

    public function resend_email_verify() {

        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url() . 'login', 'refresh');
        }

        $this->db->where('client_id', $this->session->userdata('login_user_id'));
        $rez = $this->db->get('client')->result_array();
        $client = $rez[0];

        $message = '<h3 style="text-align:center">Click The Button To Verify Your Email Address</h3>
            <div style="text-align:center;"><hr/>
            <a class="btn-orange btn-oring" href="'.base_url().'clientuser/email_verify/'.$client['subaccount_sid'].'">Verify Account</a>
            <hr/>
            <b>In case the button does not work, here is the link in plain format:</b><br/>
            '.base_url().'clientuser/email_verify/'.$client['subaccount_sid'].'</div>';

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
        
        $this->session->set_flashdata('flash_message', 'Verification Email Sent!');

        redirect(base_url() . 'clientuser/dashboard', 'refresh');

    }

    public function email_verify($koga) {

        $this->db->where(array(
            'subaccount_sid' => $koga,
        ));
        $rez = $this->db->get('client')->result_array();
        $client = $rez[0];

        if( !empty($client) ) {
            $cleint_Data['email_verified'] = '1';
            $this->db->where('subaccount_sid', $koga);
            $this->db->update('client', $cleint_Data);
        }

        if( !empty($client) && $client['subaccount_sid']!='' && $client['email_verified']!='1') {
        $pag_data['main_content'] ='<h3 style="text-align:center">Email address has been verified!</h3>
            <div style="text-align:center;"><hr/>
            <a class="btn-orange btn-oring" href="'.base_url().'clientuser/available_numbers">Continue to Dashboard</a></div>';

        /* 
            Send email for instruction after sign up
            2/12/2018 by Travis
        */
        $system_email   =   $this->system_noreplymail;
        $system_title   =   $this->system_title;
        $this->email->set_mailtype("html");
        $this->email->from( $system_email,$system_title);
        $this->email->to($client['email']);
        $this->email->subject('Instruction for Callertech');
        $message        =   
                '<h3 style="text-align:center;">Quick Start</h3><br/>
                <h3>Welcome to your Caller Technologies Membership</h3>
                <br/>
                <p style="font-size:16px; color:black;">
                    Welcome to Caller Technologies! Helping you find new and more effective marketing
                    opportunities is our main goal.
                </p>
                <br/><br/><br/>
                <p style="font-size:16px; color:black;"> Attached is our quick setup guide and it can also be found Here</p>
                <a href="'.base_url().'/download/Quick.Setup.Guide.v4.5.pdf">Quick.Setup.Guide.v4.5</a>
                <br/><br/>
                <p style="font-size:16px; color:black;">Cheers!</p>
                <br/>
                <p style="font-size:16px; color:black;">The Caller Technologies Team</p>
                <p style="font-size:16px; color:black;"><a href="mailto:Contact@CallerTech.com">Contact@CallerTech.com</a></p>
                <p style="font-size:16px; color:black;"><a href="https://callertech.com/">http://www.CallerTech.com</a></p>
                <p style="font-size:16px; color:black;"><a href="'. base_url().'">
                    <img src="'.site_url('uploads/logo.png').'" alt="" style="height:35px;"/></a></p>
                ';
        $pagedata['main_content'] = $message;
        $e_msg           =  $this->load->view('email/basic', $pagedata, true);
        $this->email->message ($e_msg);
        $this->email->send();
        $this->email->clear();
        } else if($client['email_verified']=='1'){
        $pag_data['main_content'] ='<h3 style="text-align:center">This account is already verified!</h3>
            <div style="text-align:center;"><hr/>
            <a class="btn-orange btn-oring" href="'.base_url().'login">Continue to Dashboard</a></div>';

        /* 
            Send email for instruction
            2/12/2018 by Travis
        */
        $system_email   =   $this->system_noreplymail;
        $system_title   =   $this->system_title;
        $this->email->set_mailtype("html");
        $this->email->from( $system_email,$system_title);
        $this->email->to($client['email']);
        $this->email->subject('Instruction for Callertech');
        $message        =   
                '<div style="margin-left:60px;">
                    <h3 style="text-align:center;font-weight: bold;">Quick Start</h3>
                    <h3 style="font-weight: bold;">Welcome to your Caller Technologies Membership</h3>
                    
                    <p style="font-size:16px; color:black;">
                        Welcome to Caller Technologies! Helping you find new and more effective marketing
                        opportunities is our main goal.
                    </p>
                    <p style="font-size:16px; color:black;"> Attached is our quick setup guide and it can also be found Here</p>
                    <a href="'.base_url().'/download/Quick.Setup.Guide.v4.5.pdf">Quick.Setup.Guide.v4.5</a>
                    <p style="font-size:16px; color:black;">Cheers!</p>
                    <p style="font-size:16px; color:black; margin:0px;">The Caller Technologies Team</p>
                    <p style="font-size:16px; color:black; margin:0px;"><a href="mailto:Contact@CallerTech.com">Contact@CallerTech.com</a></p>
                    <p style="font-size:16px; color:black; margin:0px;"><a href="https://callertech.com/">http://www.CallerTech.com</a></p>
                    <p style="font-size:16px;"><a href="'. base_url().'">
                        <img src="'.site_url('uploads/logo.png').'" alt="" style="height:45px;"/></a></p>
                </div>
                ';
        $pagedata['main_content'] = $message;
        $e_msg           =  $this->load->view('email/basic', $pagedata, true);
        $this->email->message ($e_msg);
        $this->email->send();
        $this->email->clear();

        } else {
        $pag_data['main_content'] ='<h3 style="text-align:center">Something went wrong!</h3>
            <div style="text-align:center;"><hr/>
            <a class="btn-orange btn-oring" href="'.base_url().'home/contact">Contact Us</a></div>';
        }
        $this->load->view('email/basic', $pag_data);
    }


    
    public function ajax_available_numbers_area_code()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }

        
        $areacode                   = $this->input->post('areacode');
        $countryData                = array();
        $page_data['friendlyName']  = '';
        $page_data['phoneNumber']   = '';
        $page_data['lata']          = '';
        $page_data['region']        = '';
        $page_data['country']       = '';
        $page_data['country_price'] = '';
        $price                      = array();
        $local                      = array();
        // $numberData = array();
        $country                    = 'US'; //$this->input->post('country');
        // Your Account Sid and Auth Token from twilio.com/user/account
        //if(isset($country) && $country !=''){
        $clientdetails              = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $subAccountSid              = $clientdetails->subaccount_sid; ///Account is suspended.Please contact administrator.
        if ($subAccountSid) {
            // check out the list resource examples on this page
            //$AccountSid = "AC4dcfbca69fbc07b4e2bf57c85cf18b80";//"AC4dcfbca69fbc07b4e2bf57c85cf18b80";
            //$AuthToken = "a5c539fa29e1a40b137d6535b768bcce";//"a5c539fa29e1a40b137d6535b768bcce";
            $AccountSid = $this->AdminAccountSid;
            $AuthToken  = $this->AdminAuthToken;
            $client     = new Client($AccountSid, $AuthToken);
            //print_r();
            try {
                $account = $client->accounts($subAccountSid)->fetch();
                if ($account->status == 'active') {
                    $subAccountauthToken = $account->authToken;
                    $client              = new Client($subAccountSid, $subAccountauthToken);
                    $filerw = array(
                        "excludeAllAddressRequired" => "true",
                        "voiceEnabled" => "true",
                        "MmsEnabled" => "true"
                    );
                    if($areacode!='') {
                        $filerw['areacode'] = $areacode;
                    }
                    $searf = $this->input->post('searchfor');
                    if($searf!='') {
                        $filerw['contains'] = $searf;
                        if(isset($filerw['areacode']) && strlen($filerw['contains'])==7)
                            $filerw['contains'] = $filerw['areacode'].$filerw['contains'];
                        else if(isset($filerw['areacode']))
                            $filerw['contains'] = $filerw['areacode'].'%'.$filerw['contains'].'%';
                        $numbers             = $client->availablePhoneNumbers('US')->local->read($filerw);
                    } else {

                    $numbers             = $client->availablePhoneNumbers('US')->local->read($filerw);
                    }
        
                    if (!$numbers) {
                        die(0);
                    }
                    
                    foreach ($numbers as $number) {
                        $local['friendlyName'][] = $number->friendlyName;
                        $local['phoneNumber'][]  = $number->phoneNumber;
                        $local['lata'][]         = $number->lata;
                        $local['region'][]       = $number->region;
                        $local['country1'][]     = $number->isoCountry;
                        //  ==================";
                    }
                    
                    $countryPrice = $client->pricing->phoneNumbers->countries($country)->fetch();
                    foreach ($countryPrice->phoneNumberPrices as $p) {
                        $type                          = $p['number_type'];
                        /// $price[$p->number_type]
                        //$price[$type]['ty']  = $p['current_price'];
                        $price['type'][]               = $type;
                        $price[$type]['current_price'] = $p['current_price'];
                        $price[$type]['base_price']    = $p['current_price'];
                    }
                    
                    $page_data['local']         = $local;
                    $page_data['country_price'] = $price;
                    ### if selected as country
                } else { //$this->session->set_flashdata('flash_message', get_phrase('Account is suspended.Please contact administrator.'));
                    $page_data['system_error'] = " Account is suspended.Please contact administrator.";
                }
            }
            catch (Exception $e) {
                //" System Error: " . $e->getMessage();
                $page_data['system_error'] = " System Error: " . $e->getMessage() . "<br><br>Account Credentials not Authenticate, Please contact administrator.";
            }
            // }
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('Services Confirmation Is Pending Please Check Dashboard To Proceed !'));
            redirect(base_url() . 'clientuser/dashboard', 'refresh');
        }
        
        
        $clientdetails             = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $charges                   = $this->crud_model->fetch_package_pricing($clientdetails->subscription_id);

        $page_data['charges'] = $charges;
        $page_data['page_name']  = 'availablenumbers';
        $page_data['page_title'] = get_phrase('available numbers list');
        echo $this->load->view('base/buy_numbers_area_code', $page_data);
    }

    
    public function available_numbers()
    {
        if (empty($this->session->userdata('login_user_id'))) {
            redirect(base_url('login'));
            
        }

        $countryData                = array();
        $page_data['friendlyName']  = '';
        $page_data['phoneNumber']   = '';
        $page_data['lata']          = '';
        $page_data['region']        = '';
        $page_data['country']       = '';
        $page_data['country_price'] = '';
        $price                      = array();
        $local                      = array();
        
        $country = 'US';
        
        $clientdetails             = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $charges                   = $this->crud_model->fetch_package_pricing($clientdetails->subscription_id);
        $page_data['charges'] = $charges;
        $page_data['number_price'] = $charges['buy_number_charge'];

        if($charges['is_subscription'] == 1 ) {
            
            /* --- Check if has that phone number */
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $clientdetails->client_id,
                'status' => 'active'
            ));
            $doez_have_ph = false;
            $phoneNumbers = $this->db->get()->result_array();
            $srvc_received = count( $phoneNumbers);

            $max_phone_numbers = $charges['max_phone_numbers'];

            $hasBalance = ($srvc_received < $max_phone_numbers);

            if (!$hasBalance) { 
                $this->session->set_flashdata('not_fund_purchase_number', 1);
                redirect(base_url() . 'clientuser/dashboard', 'refresh');
                die();
            }
        }
        
        $subAccountSid = $clientdetails->subaccount_sid;
        if ($subAccountSid) {
            
            $AccountSid = $this->AdminAccountSid;
            $AuthToken  = $this->AdminAuthToken;
            $client     = new Client($AccountSid, $AuthToken);
            $areacode_auto = '';
            if($clientdetails->contact!='') {
                $priv = explode(')',$clientdetails->contact);
                $areacode_auto = trim(str_replace('(','',$priv[0]));
            }
            try {
                $account = $client->accounts($subAccountSid)->fetch();
                if ($account->status == 'active') {
                    $subAccountauthToken = $account->authToken;
                    
                    $client = new Client($subAccountSid, $subAccountauthToken);
                    if($areacode_auto!='')
                        $numbers = $client->availablePhoneNumbers('US')->local->read(array(
                            "excludeAllAddressRequired" => "true",
                            "areacode" => $areacode_auto,
                            "voiceEnabled" => "true",
                            "MmsEnabled" => "true"
                        ));

                    if(!isset($numbers) || empty($numbers))
                        $numbers = $client->availablePhoneNumbers('US')->local->read(array(
                            "excludeAllAddressRequired" => "true",
                            "voiceEnabled" => "true",
                            "MmsEnabled" => "true"
                        ));

                    foreach ($numbers as $number) {
                        $local['friendlyName'][] = $number->friendlyName;
                        $local['phoneNumber'][]  = $number->phoneNumber;
                        $local['lata'][]         = $number->lata;
                        $local['region'][]       = $number->region;
                        $local['country1'][]     = $number->isoCountry;
                    }
                    
                    $countryPrice = $client->pricing->phoneNumbers->countries($country)->fetch();
                    foreach ($countryPrice->phoneNumberPrices as $p) {
                        $type = $p['number_type'];
                        
                        $price['type'][]               = $type;
                        $price[$type]['current_price'] = $p['current_price'];
                        $price[$type]['base_price']    = $p['current_price'];
                    }
                    
                    
                    $page_data['local']         = $local;
                    $page_data['country_price'] = $price;
                    
                } else {
                    $page_data['system_error'] = " Account is suspended.Please contact administrator.";
                }
            }
            catch (Exception $e) {
                
                $page_data['system_error'] = " System Error: " . $e->getMessage() . "<br><br>Account Credentials not Authenticate, Please contact administrator.";
            }
            
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('Services Confirmation Is Pending Please Check Dashboard To Proceed !'));
            redirect(base_url() . 'clientuser/dashboard', 'refresh');
        }
        
        $page_data['page_name']  = 'availablenumbers';
        $page_data['page_title'] = get_phrase('available numbers list');
        
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }

    public function buy_number($phonenumber = '')
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        
        $page_data['buyButton'] = '';
        $clientdetails          = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        
        $charges              = $this->crud_model->fetch_package_pricing($clientdetails->subscription_id);
        $page_data['charges'] = $charges;
        $number_price = $charges['buy_number_charge'];
        $totalPhoneSubscription = (float) round($number_price * 12,4); 
        
        $subAccountSid = $clientdetails->subaccount_sid;
        if (!empty($subAccountSid) || $subAccountSid != NULL) {
            
            $AccountSid = $this->AdminAccountSid;
            $AuthToken  = $this->AdminAuthToken;
            $client     = new Client($AccountSid, $AuthToken);
            
            try {
                $account = $client->accounts($subAccountSid)->fetch();
                $this->db->select('cl.*,pckg.*');
                $this->db->from('client cl');
                $this->db->join('packages pckg', 'pckg.package_id = cl.subscription_id ', 'left');
                $this->db->where(array(
                    'cl.client_id' => $this->session->userdata('login_user_id')
                ));
                $query                  = $this->db->get();
                $client_payment_details = $query->row();
                if ($account->status == 'active') {
                    $account_balance = $this->get_balance($client_payment_details->client_id);
                    
                    $subAccountauthToken = $account->authToken;
                    $subAccount          = new Client($subAccountSid, $subAccountauthToken);
                    if (!empty($subAccount)) {
                        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
                            'client_id' => $this->session->userdata('login_user_id'),
                            'status' => 'active'
                        ))->row();
                        if (isset($_REQUEST['country'])) {
                            $phone_country = $_REQUEST['country'];
                            $phonenumber   = $_REQUEST['phonenumber'];
                            
                            $client_id = $this->session->userdata('login_user_id');
                            
                            
                            if (!empty($phone_country) && !empty($phonenumber) && !empty($number_price)) {


                                if($charges['is_subscription'] == 1 ) {
                                    /* --- Check if has that phone number */
                                    $this->db->select('*');
                                    $this->db->from('client_phonenumber_purchased ');
                                    $this->db->where(array(
                                        'client_id' => $client_id,
                                        'status' => 'active'
                                    ));
                                    $phoneNumbers = $this->db->get()->result_array();
                                    $num_phones = count( $phoneNumbers);
                                    $srvc_received = $num_phones;
                                    $max_phone_numbers = $charges['max_phone_numbers'];
                                    $hasBalance = ($srvc_received < $max_phone_numbers);
                                }
                                else {
                                    $hasBalance = $totalPhoneSubscription <= $account_balance;
                                }

                                if ($hasBalance) {                                 
                                    
                                    $number = $subAccount->incomingPhoneNumbers->create(array(
                                        "voiceUrl" => base_url() . "base/incomingCallRequest",
                                        "phoneNumber" => $phonenumber,
                                        "smsUrl" => base_url() . "base/incomingSMSRequest",
                                        "phoneNumber" => $phonenumber,
                                        "StatusCallback" => base_url() . "base/callstatus"
                                    ));
                                    
                                    $insert_data['client_id']         = $client_id;
                                    $insert_data['phoneNumber']       = $number->phoneNumber;
                                    $insert_data['friendlyName']      = $number->friendlyName;
                                    $insert_data['phoneSid']          = $number->sid;
                                    $insert_data['campaign_name']     = $_REQUEST['campaign_name'];
                                    $insert_data['accountSid']        = $number->accountSid;
                                    $insert_data['phoneNumber_price'] = $number_price;
                                    $insert_data['phone_country']     = $phone_country;
                                    $insert_data['date']              = date("d-m-Y h:i:sa");
                                    $insert_data['call_forward_no']      = $this->input->post('call_forward_no');
                                    $insert_data['sms_forward_no']      = $this->input->post('sms_forward_no');

                                    $this->db->insert('client_phonenumber_purchased', $insert_data);
                                    
                                    if($charges['is_subscription'] == 1 ) {
                                        // Update +1 max_phone_numbers
                                      // $this->crud_model->update_subs_count($clientdetails->client_id,'max_phone_numbers');
                                    }
                                    else {
                                        /* UPDATE BALANCE */
                                        $account_balance = ($account_balance - (float)$totalPhoneSubscription);
                                        $cleint_Data['available_fund'] = $account_balance;
                                        $this->db->where('client_id', $client_id);
                                        $this->db->update('client', $cleint_Data);
                                        /* UPDATE BALANCE */
                                        #MAKE A NEGAVTIVE ENTRY
                                        $insert_data_pay = array();
                                        $insert_data_pay['client_id']            = $client_id;
                                        $insert_data_pay['payment_gross_amount'] = -$totalPhoneSubscription;
                                        $insert_data_pay['plan_name']            = 'payment_against_number_purchase';
                                        $insert_data_pay['pay_meta']            = 'phonenumber='. $number->phoneNumber . '|country=' . $phone_country;
                                        $insert_data_pay['payment_date']         = date("Y-m-d");
                                         $insert_data_pay['payment_time']         = date("H:i:s");
                                        $this->db->insert('client_payment_details', $insert_data_pay);
                                    }
                                    
                                    
                                    
                                    $page_data['clientPhoneDetails'] = $insert_data;
                                    redirect(base_url() . 'clientuser/buy_number/' . $number->phoneNumber);
                                    exit();
                                } else {
                                    
                                    
                                    $this->session->set_flashdata('not_fund_purchase_number', ($totalPhoneSubscription - $account_balance ));
                                    redirect(base_url() . 'clientuser/dashboard', 'refresh');
                                    
                                }
                                
                                
                            } else {
                                
                                $this->session->set_flashdata('flash_message', get_phrase('To Purchase Number-phone_country OR phonenumber OR number_price data missing'));
                                
                            }
                            redirect(base_url() . 'clientuser/buy_number/');
                        } else {
                            
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', get_phrase('crendetials are not proper'));
                        redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
                    }
                    
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('Account suspended,Please contact administrator.'));
                }
                
            }
            catch (Exception $e) {
                
                $page_data['system_error'] = " System Error: " . $e->getMessage() . "<br><br>Account Credentials not Authenticate, Please contact administrator.";
            }
            
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('Services Confirmation is pending please check dashboard to proceed !'));
            redirect(base_url() . 'clientuser/dashboard', 'refresh');
            
        }
        
        
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
            'status' => 'active'
        ));
        $phoneNumber = $this->uri->segment(3);
        if (!empty($phoneNumber)) {
            $this->db->where(array(
                'phoneNumber' => $phoneNumber
            ));
        }
        $query              = $this->db->get();
        $clientPhoneDetails = $query->row();
        
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
            'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();
        
        $page_data['phoneNumbers'] = $phoneNumbers;
        
        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }
        
        $page_data['page_name']          = 'buy_number';
        $page_data['charges']            = $charges;
        $page_data['page_title']         = get_phrase("Purchased phone Number's Details");
        $page_data['clientPhoneDetails'] = $clientPhoneDetails;
        $page_data['duration_id']        = $client_payment_details->duration_id;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }

    public function account_subscription()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $cl_id =  $this->session->userdata('login_user_id');

        $page_data['acc_balance'] = $client->available_fund;
        $page_data['page_name']  = 'account_subscription';
        $page_data['page_title'] = get_phrase('Subscription Details');

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

        $max_phone_numbers = $plan['max_phone_numbers'];
        
        $service_list1["Incoming Calls"] = 'max_call_in';
        $service_list1["Sent SMS"] = 'max_send_sms';
        $service_list1["Sent MMS"] = 'max_send_mms';
        $service_list1["Incoming SMS/MMS"] = 'max_received_sms';
        $service_list1["Lookup Calls"] = 'max_call_lookup';
        $service_list1["Transcripts"] = 'max_call_transcripts';
        $service_list1["Call Minutes"] = 'max_call_minutes';
        $service_list1["Social Ads"] = 'max_social_ad';

        $service_list = array();
        foreach($service_list1 as  $name => $srv) {
            $service_list[$name] = array(
                    'count' => $this->crud_model->get_subs_count($cl_id,$srv),
                    'max' => $plan[$srv]
                );
        }
        $service_list["Phone Numbers"] = array(
                    'count' => $num_phones,
                    'max' => $max_phone_numbers
            );
        $page_data['service_list'] = $service_list;


        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }

    public function account_balance()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();

        $page_data['acc_balance'] = $client->available_fund;
        $page_data['page_name']  = 'account_balance';
        $page_data['page_title'] = get_phrase('Account Balance');

        $plan = $this->crud_model->fetch_package_pricing($client->subscription_id);
        //$this->crud_model->getsubs_count($client->client_id,'max_call_in');
        $service_list1["Incoming Call"] = $this->crud_model->get_subs_count($client->client_id,'max_call_in');
        $service_list1["Number Lookup"] = $plan["lookup_call_charge"];
        $service_list1["Call Forwarding"] = $plan["call_forword_charges"];
        $service_list1["Call Recording"] = $plan["p_call_recording"];
        $service_list1["Incoming SMS"] = $plan["sms_charge"];
        $page_data['service_list1'] = $service_list1;
        //$this->crud_model->update_subs_count($client->client_id,'max_call_in'); 


        $service_list2["Buy Phone Number (Yearly)"] = $plan["buy_number_charge"] * 12;
        $service_list2["Transcription"] = $plan["p_transc_service"];
        $service_list2["Facebook Advertisement"] = $plan["p_social_med_adv"];
        $service_list2["Blocked Spam Call"] = $plan["p_blk_spam_calls"];
        $service_list2["Send / Forward SMS"] = $plan["sms_send_charge"];
        $page_data['service_list2'] = $service_list2;
        
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }

    public function services() {

        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $act = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
        $addon = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
       // get client deetails
        $client = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();

        $this->_tw_addons($client->subaccount_sid, $client->auth_token, 'install', 'nextcaller_advanced_caller_id');
        $rez = $this->_tw_addons($client->subaccount_sid, $client->auth_token, $act, $addon);
        if($rez == false || $rez == 'No Add-on active!') {
            var_dump($rez);
            die();
            $this->session->set_flashdata('flash_message', 'Error! Service not available!');
            redirect(site_url('clientuser/dashboard'), 'refresh');
        }
        else {
            $this->session->set_flashdata('flash_message', 'Action on Service finished successfully!');
            redirect(site_url('clientuser/dashboard'), 'refresh');
        }

    }

    /*public function transactions()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $page_data['page_name']  = 'view_sms';
        $page_data['page_title'] = get_phrase('Payment Transactions');
        
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }*/

    public function release_number($broj) {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        ## get user deetails  = SID
        $clientdetails = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        
        /* --- Check if has that phone number */
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased');
        $this->db->where(array(
            'client_id' => $clientdetails->client_id,
            'rec_id' => $broj,
            'status' => 'active'
        ));
        $doez_have_ph = false;
        $phoneNumbers = $this->db->get()->result_array();
        $page_data['timezone']            = $clientdetails->timezone;
        /* GET SMS info */
        if (empty($phoneNumbers)) { // the client does not own this phone number
            $this->session->set_flashdata('error', "You do not own this phone number."); 
            redirect(base_url() . 'clientuser/manage_numbers/', 'refresh');
        }
        else {
            $phNum = $phoneNumbers[0];

                $this->load->library('restclient');
                $api = new Restclient([
                    'base_url' => "https://api.twilio.com", 
                    'username' => $this->AdminAccountSid, //$client->subaccount_sid, 
                    'password' => $this->AdminAuthToken
                ]);
               $req =  $api->delete('/2010-04-01/Accounts/'.$clientdetails->subaccount_sid.'/IncomingPhoneNumbers/'.$phNum['phoneSid'].'.json');
               //$rez = $req->decode_response();

              /* Remove from database */
              $this->db->where('phoneSid',$phNum['phoneSid']);
              $this->db->update('client_phonenumber_purchased', array('status' =>'released'));

              $this->db->where('to',$phNum['phoneNumber']);
              $this->db->delete('ct_messages');

              $this->db->where('from',$phNum['phoneNumber']);
              $this->db->delete('ct_messages');

              $this->db->where('forwardedFrom',$phNum['phoneNumber']);
              $this->db->delete('incoming_call_details');

              $this->db->where('from',$phNum['phoneNumber']);
              $this->db->delete('caller_look_up');

            $this->session->set_flashdata('success', "Phone Number Released"); 

            redirect(base_url() . 'clientuser/manage_numbers/', 'refresh');

        }
            /* --- Check if has that phone number */
    }

    public function view_sms()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $picked_num = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
        $picked_dir = ($this->uri->segment(4) && $this->uri->segment(4) == 'out') ? $this->uri->segment(4) : 'in';

        if($picked_num == "Select%20a%20Number") {
            redirect(base_url() . 'clientuser/view_sms', 'refresh');
            die();
        }

        $page_data['pick_who'] = $picked_dir;
        
        /* Pagination Config */
        // Setup pagination config
        $panconfig                     = array();
        $panconfig["base_url"]         = base_url() . "clientuser/view_sms/" . $picked_num . '/' . $picked_dir;
        $panconfig["total_rows"]       = 0; // number of rows
        $panconfig["per_page"]         = 15;
        $panconfig['use_page_numbers'] = TRUE;
        $panconfig['next_link']        = '>';
        $panconfig['prev_link']        = '<';
        $panconfig['uri_segment']      = 5;
        /* ---/. Pagination Config END */
        
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
        
        
        
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        ## get user deetails  = SID
        $clientdetails = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        
        /* --- Check if has that phone number */
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $clientdetails->client_id,
                'status' => 'active'
        ));
        $doez_have_ph = false;
        $phoneNumbers = $this->db->get()->result_array();
        $page_data['timezone']            = $clientdetails->timezone;
        /* GET SMS info */
        if (!empty($picked_num)) {
            foreach ($phoneNumbers as $phn) {
                if ($phn['phoneNumber'] == $picked_num) {
                    $doez_have_ph = true;
                }
            }
            if ($doez_have_ph == false)
                die("You do not own this phone number"); // the client does not own this phone number
            /* --- Check if has that phone number */
            
            
            if ($picked_dir == 'out') {
                $page_data['pick_who']   = 'from';
                $page_data['picked_dir'] = 'out';
            } else {
                $page_data['pick_who']   = 'to';
                $page_data['picked_dir'] = 'in';
            }
            $qr                      = $this->db->get_where('ct_messages', array(
                $page_data['pick_who'] => $picked_num
            ));
            $panconfig["total_rows"] = $qr->num_rows();
            
            $this->db->limit($panconfig["per_page"], ($page - 1) * $panconfig["per_page"]);
            $qr       = $this->db->order_by("id", "desc")->get_where('ct_messages', array(
                $page_data['pick_who'] => $picked_num,
                'direction' => $page_data['picked_dir']
            ));
            $sms_list = $qr->result_object();
            
            /* Init Pagination */
            $this->pagination->initialize($panconfig);
            $page_data['content_pagination'] = $this->pagination->create_links();
            
            
        } else { // You need to pick the number
            $sms_list                        = array();
            $page_data['system_error']       = 'You need to pick a number!';
            $page_data['content_pagination'] = '';
        }
        
        /* phone numbers avilable */
        $page_data['phoneNumbers'] = $phoneNumbers;
        
        
        $page_data['picked_num'] = $picked_num;
        $this->load->helper('twilio_handlers');
        $page_data['picked_num_nice'] = ct_format_nice_number($picked_num);
        if(!empty($sms_list)) {

            foreach($sms_list as $sms) {
                $sms->to = ct_format_nice_number($sms->to);
                $sms->from_clean = $sms->from;
                $sms->from = ct_format_nice_number($sms->from);

            }
        }
        $page_data['sms_list']   = $sms_list;
        
        $page_data['page_name']  = 'view_sms';
        $page_data['page_title'] = get_phrase('SMS Listing');
        
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        
    }

    private function upload_voicemail_file() {

        $config = array(
        'upload_path' => 'uploads/voicemail/',
        'allowed_types' => 'mp3|wav',
        'overwrite' => TRUE,
        'max_size' => 0,
        'file_name' => date("Ymd").'_'.$_FILES["voicefile"]['name']
        );
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('voicefile') && isset($_FILES["voicefile"]['name']) && !empty($_FILES["voicefile"]['name']))
        { 
            $data['status'] =  'error';
            $data['message'] =  $this->upload->display_errors();
            $this->session->set_flashdata('error', "Erorr: ".$data['message']);
        }
        else
        {
            $data['status'] =  'success';
            $imageDetailArray = $this->upload->data();
            $data['fileUploaded']  =  $imageDetailArray;
        }
        if(isset($data['fileUploaded'])) {
            return base_url().'uploads/voicemail/'.$data['fileUploaded']['file_name'];
        }
        return '';
            
        //redirect(base_url() . 'clientuser/manage_profile', 'refresh');
    }
    private function upload_vcard_file() {

        $config = array(
        'upload_path' => 'uploads/vcard/',
        'allowed_types' => 'vcard|vcf',
        'overwrite' => TRUE,
        'max_size' => 5000,
        'file_name' => date("Ymd").'_'.$_FILES["vcardfile"]['name']
        );
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('vcardfile'))
        { 
            $data['status'] =  'error';
            $data['message'] =  $this->upload->display_errors();
            $this->session->set_flashdata('error', "Erorr: ".$data['message']);

        }
        else
        {
            $data['status'] =  'success';
            $imageDetailArray = $this->upload->data();
            $data['fileUploaded']  =  $imageDetailArray;
        }
        if(isset($data['fileUploaded'])) {
            $cid = $this->session->userdata('login_user_id');
            $this->db->where('client_id', $cid);
            $updatesID = $this->db->update('client', array(
                'vcard_url'  =>  base_url().'uploads/vcard/'.$data['fileUploaded']['file_name']
            )
            );
        }
            
        $this->session->set_flashdata("flash_message", "vCard Uploaded Successfully!");
    }

    public function upload_mms_file() {

        $config = array(
        'upload_path' => 'uploads/mms/',
        'allowed_types' => $this->getAllowedTypes(),
        'overwrite' => TRUE,
        'max_size' => 10000,
        'file_name' => date("Ymd").'_'.$_FILES["file"]['name']
        );
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('file'))
        { 
            $data['status'] =  'error';
            $data['message'] =  "SMS type wrong or file size is exceeded, the max size is 10MB.";

        }
        else
        {
            $data['status'] =  'success';
            $imageDetailArray = $this->upload->data();
            $data['fileUploaded']  =  $imageDetailArray;
        }

        header('Content-Type:application/json');
        echo json_encode( $data );
    }
    /* messages in a window */
    public function view_messages()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $picked_num = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
        $picked_who = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';

        if( !isset($_POST['ajax']) ) {
            $froms_call = str_replace('%20', ' ', $picked_who);
            $froms_call = str_replace('-', '', $froms_call);
            $froms_call = str_replace(' ', '', $froms_call);
            $froms_call = str_replace('(', '', $froms_call);
            $froms_call = str_replace(')', '', $froms_call);
            $picked_who = '+1' . $froms_call;
        }
        if($picked_num == "Select%20a%20Number") {
            redirect(base_url() . 'clientuser/view_sms', 'refresh');
            die();
        }

        $page_data['picked_who'] = $picked_who;       
        $page_data['picked_num'] = $picked_num;
        
        
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        ## get user deetails  = SID
        $clientdetails = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $page_data['timezone']            = $clientdetails->timezone;
        
        /* --- Check if has that phone number */
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $clientdetails->client_id,
                'status' => 'active'
        ));
        $client_id = $clientdetails->client_id;
        $doez_have_ph = false;
        $phoneNumbers = $this->db->get()->result_array();
        /* GET SMS info */
        if (!empty($picked_num) && !empty($picked_who)) {
            foreach ($phoneNumbers as $phn) {
                if ($phn['phoneNumber'] == $picked_num) {
                    $doez_have_ph = true;
                }
            }
            if ($doez_have_ph == false)
                die("You do not own this phone number"); // the client does not own this phone number
            /* --- Check if has that phone number */

            $this->db->select('from as phNumber');
            $this->db->where("( client_id='".$client_id."' AND direction='in' )");           
            $qr = $this->db->get('ct_messages');
            $who_list = $qr->result_array();

            $this->db->select('to as phNumber');
            $this->db->where("( client_id='".$client_id."' AND direction='out' )");        
            $qr = $this->db->get('ct_messages');
            $who_list2 = $qr->result_array();

            $page_data['who_list'] = array_unique(array_merge($who_list,$who_list2));


            $this->db->select('*');
            $this->db->where("( (`from`='".$picked_num."' AND to='".$picked_who."' AND direction='out') OR (to='".$picked_num."' AND from='".$picked_who."' AND direction='in') )");
            $this->db->order_by("id", "desc");
            $this->db->limit(50);
            $qr = $this->db->get('ct_messages');
            $sms_list = $qr->result_object();
            $sms_list  = array_reverse($sms_list );
            
            /* Init Pagination */
            $page_data['content_pagination'] = '';
            
            
        } else if( !empty($picked_num) ) { // You need to pick the number
            $this->db->select('from as phNumber');
            $this->db->where("( to='".$picked_num."' AND direction='in' )");
            $this->db->group_by('from');
            $qr = $this->db->get('ct_messages');
            $who_list = $qr->result_object();

            $this->db->select('to as phNumber');
            $this->db->where("( from='".$picked_num."' AND direction='out' )");
            $this->db->group_by('from');            
            $qr = $this->db->get('ct_messages');
            $who_list2 = $qr->result_object();

            $page_data['who_list'] = array_unique(array_merge($who_list,$who_list2));

        } else { // You need to pick the number
            $sms_list                        = array();
            $page_data['system_error']       = 'You need to pick a number!';
            $page_data['content_pagination'] = '';
        }
        
        /* phone numbers avilable */
        $page_data['phoneNumbers'] = $phoneNumbers;
        
        
        $page_data['picked_num'] = $picked_num;
        $this->load->helper('twilio_handlers');
        $page_data['picked_num_nice'] = ct_format_nice_number($picked_num);
        if(!empty($sms_list)) {

            foreach($sms_list as $k => $sms) {
                $sms->to_clean = $sms->to;
                $sms->to = ct_format_nice_number($sms->to);
                $sms->from_clean = $sms->from;
                $sms->from = ct_format_nice_number($sms->from);
                if(! empty($sms->media_urls) && $sms->mms_num_files>0 ) {
                   $sms->media_urls = unserialize($sms->media_urls);
                   foreach($sms->media_urls as $li => $media) {
                        $short_url = '';
                        //$short_url = file_get_contents('http://tinyurl.com/api-create.php?url=' . urlencode( $media['mediaUrl'] ) );
                        $sms->media_urls[$li]['mediaUrlShort'] = $media['mediaUrl'];//$short_url;
                        $priv = explode("/",$media['mediaType']);
                        $sms->media_urls[$li]['mediaTypeNice'] = $priv[1];
                        $sms->media_urls[$li]['mediaTypeGroup'] = $this->getTypeGroup($media['mediaType']);
                   }
                }

                $mejsg =explode(":",$sms->message);
                if($mejsg[0]=='FW') {
                    $mejsg =explode(" - ",$sms->message);
                    $mejsg[0] = '<small style="color:#999">'.str_replace("FW:","Forwarded from: ",$mejsg[0]).'</small><br/>';
                    $sms->message = implode(' ',$mejsg);
                }

            }
        }
        if($page_data['picked_num'] != '') { 
            $datsa['is_read'] = '1'; // set to read
            $this->db->where('from', $page_data['picked_who']);
            $this->db->where('direction', 'in');
            $this->db->where('client_id', $clientdetails->client_id);
            $updatesID = $this->db->update('ct_messages', $datsa);
        }
        if( isset($_POST['ajax']) ) {
            /* Ajax Response */
            header('Content-Type:application/json');
            echo json_encode($sms_list);
            die();
        }

        $page_data['sms_list']   = $sms_list;
        $page_data['page_name']  = 'view_messages';
        $page_data['page_title'] = get_phrase('Messaging');
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        
    }

    public function send_bulksms($num_id='') {
        if (!isset($this->current_client->client_id)) {
            redirect(base_url() . 'login', 'refresh');
        }

        $client_id = $this->current_client_id;
        $phoneNumbers = $this->current_client_numbers;

        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }

        foreach($phoneNumbers as $num) {
            if($num->rec_id==$num_id) {
                $listnumber = $num;
                $phoneNumber = $details->phoneNumber;
            }
        }
        if (empty($details)) {
            $listnumber = $phoneNumbers[0];
            $phoneNumber = $listnumber->phoneNumber;
        }

        $page_data['rec_id']       = $listnumber->rec_id;
        $page_data['list_info']      = $listnumber;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;

        $page_data['picked_who'] = $phoneNumber->phoneNumber;      
        $page_data['picked_num'] = $phoneNumber->phoneNumber;
        $page_data['sms_list']   = [];
        $page_data['bulk_count'] = count($this->bulktext->get_list_optinonly($listnumber->rec_id));

        $page_data['page_name']  = 'send_bulksms';
        $page_data['page_title'] = get_phrase('Messaging');
        $page_data['site_settings'] = $this->SiteSettings;

        $this->load->view('index', $page_data);
    }

    public function import_bulksms($grp_id,$updatelist='') {
        if (!isset($this->current_client->client_id)) {
            redirect(base_url() . 'login', 'refresh');
        }

        $groupinf = $this->bulktext->get_group($grp_id);
        $num_id = $groupinf->number_id;
        $new_client_id = $this->current_client_id;
        $new_number_id = $num_id;
        $nid = $num_id;


        $client_id = $this->current_client_id;
        $phoneNumbers = $this->current_client_numbers;

        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }

        foreach($phoneNumbers as $num) {
            if($num->rec_id==$nid) {
                $listnumber = $num;
                $phoneNumber = $details->phoneNumber;
            }
        }
        if (empty($listnumber)) {
            $listnumber = $phoneNumbers[0];
            $phoneNumber = $listnumber->phoneNumber;
        }

        $config = array(
        'upload_path' => 'uploads/bulksms/',
        'allowed_types' => 'csv',
        'overwrite' => TRUE,
        'max_size' => 5000,
        'file_name' => date("Ymd").'_'.$_FILES["imfile"]['name']
        );
        if(isset($_FILES["imfile"])) {

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('imfile'))
        { 
            $data['status'] =  'error';
            $data['message'] =  $this->upload->display_errors();
            $this->session->set_flashdata('error', "Erorr: ".$data['message']);

        }
        else
        {
            $data['status'] =  'success';
            $imageDetailArray = $this->upload->data();
            $data['fileUploaded']  =  $imageDetailArray;
        }
        }

        $filename = $this->input->post('filename');
        if($filename!='')
            $fileop = $filename;
        else
            $fileop = isset($data['fileUploaded']['file_name']) ? $data['fileUploaded']['file_name'] : '';

        $lista = array();
        if($fileop!='') {

            $grdata = $this->input->post('grdata');
            if (($handle = fopen('uploads/bulksms/'.$fileop, "r")) !== FALSE) {
                $all_data = array();

                $i = $dodato = 0;
                while (($data = fgetcsv($handle)) !== FALSE) {
                    if($i==0){ $i=1; continue;  }
                    // Remove the first iteration as it's not "real" datas
                    if(isset($data[0])) {
                            $lista[] = $data;
                        if($filename!='') {
                            $new_user_number='';
                            $new_user_fname='';
                            $new_user_lname='';
                            $new_user_moreinfo1 = '';
                            $new_user_moreinfo2 = '';
                            $new_user_moreinfo3 = '';
                            $new_user_moreinfo4 = '';
                            foreach($data as $k=>$dat) {
                                if(isset($grdata[$k]) && $grdata[$k]!='0') {
                                    switch($grdata[$k]) {
                                        case 'user_number':
                                            $new_user_number = $data[$k];
                                        break;
                                        case 'user_fname':
                                            $new_user_fname = $data[$k];
                                        break;
                                        case 'user_lname':
                                            $new_user_lname = $data[$k];
                                        break;
                                        case 'user_moreinfo1':
                                            $new_user_moreinfo1 = $data[$k];
                                        break;
                                        case 'user_moreinfo2':
                                            $new_user_moreinfo2 = $data[$k];
                                        break;
                                        case 'user_moreinfo3':
                                            $new_user_moreinfo3 = $data[$k];
                                        break;
                                        case 'user_moreinfo4':
                                            $new_user_moreinfo4 = $data[$k];
                                        break;
                                    }
                                }
                            }
                            if($new_user_number=='') {
                                continue; // skip if number not picked
                            }

                            $new_user_number = $this->format_international_number($new_user_number);

                            $new_optin = 0;
                            if(!$this->bulktext->is_in_list($groupinf->id,$nid,$new_user_number)) {
                                $moreinf = [];
                                if($new_user_moreinfo1!='')
                                $moreinf[] = $new_user_moreinfo1;
                                if($new_user_moreinfo2!='')
                                $moreinf[] = $new_user_moreinfo2;
                                if($new_user_moreinfo3!='')
                                $moreinf[] = $new_user_moreinfo3;
                                if($new_user_moreinfo4!='')
                                $moreinf[] = $new_user_moreinfo4;
                                $this->bulktext->add_item(
                                    $groupinf->id,
                                    $new_client_id,
                                    $new_number_id,
                                    $new_user_number,
                                    $new_user_fname,
                                    $new_user_lname,
                                    $new_optin,
                                    $moreinf
                                );
                                $dodato++;
                            }
                        }
                        $i++;
                    } else {
                        $this->session->set_flashdata("flash_message", "File not formated correctly!");
                        redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
                        break;
                    }
                }
                fclose($handle);
                if($filename!='') {
                    if($dodato>0)
                        $this->session->set_flashdata("flash_message", $dodato." numbers imported correctly!");
                    else
                        $this->session->set_flashdata("flash_message", "All numbers in file already in list!");
                    redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
                }
            }
        }
            
        $page_data['group_info']      = $groupinf;
        $page_data['list_info']      = $listnumber;
        $page_data['inprows']  = $lista;
        $page_data['filename']  = $fileop;
        $page_data['page_name']  = 'import_bulksms_picker';
        $page_data['page_title'] = get_phrase('Manage Bulk SMS List');
        $page_data['bulksms_list'] = $bulksms_list;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        //redirect(base_url() . 'clientuser/manage_bulksms/'.$new_number_id, 'refresh');
    }
    
    public function manage_bulkgroup($grp_id='', $action = '', $other = '') {
        if (!isset($this->current_client->client_id)) {
            redirect(base_url() . 'login', 'refresh');
        }

        $client_id = $this->current_client_id;
        $phoneNumbers = $this->current_client_numbers;

        $groupinf = $this->bulktext->get_group($grp_id);
        $num_id = $groupinf->number_id;

        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }

        foreach($phoneNumbers as $num) {
            if($num->rec_id==$num_id) {
                $listnumber = $num;
                $phoneNumber = $details->phoneNumber;
            }
        }
        if (empty($listnumber)) {
            $listnumber = $phoneNumbers[0];
            $phoneNumber = $listnumber->phoneNumber;
        }

        $page_data['rec_id']       = $listnumber->rec_id;
        $page_data['list_info']      = $listnumber;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;

        /* update number */

        if (!empty($_POST) && $action=='updatelist') {

            $new_number_id = $listnumber->rec_id;
            $new_client_id = $this->current_client_id;
            $toedit_id = $this->input->post('inlist_id');
            $new_groupname = $this->input->post('gname');

            if($toedit_id=='') {
                $this->bulktext->add_group(
                    $new_number_id,
                    $new_groupname,
                    $new_client_id
                );

                $this->session->set_flashdata('flash_message', get_phrase('Group Added!'));
                redirect(base_url() . 'clientuser/manage_bulkgroup/'.$new_number_id, 'refresh');
            
            } else {
                $this->bulktext->edit_group(
                    $toedit_id,
                    $new_groupname,
                    $new_client_id
                );

                $this->session->set_flashdata('flash_message', get_phrase('Group Edited!'));
                redirect(base_url() . 'clientuser/manage_bulkgroup/'.$new_number_id, 'refresh');
            }
        } else if($action=='edititem') {
            $inlist = $this->bulktext->get_group($other);
            if($inlist)
                $page_data['numedit'] = $inlist;
        } else if($action=='delete') {
            $this->bulktext->delete_group($other);
            $this->session->set_flashdata('flash_message', get_phrase('Group Deleted!'));
            redirect(base_url() . 'clientuser/manage_bulkgroup/'.$new_number_id, 'refresh');
        }

        $bulksms_list = $this->bulktext->get_group_list($listnumber->rec_id);

        $page_data['page_name']  = 'manage_bulkgroup';
        $page_data['page_title'] = get_phrase('Manage Bulk SMS Groups');
        $page_data['bulksms_list'] = $bulksms_list;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }

    public function manage_bulksms($grp_id='', $action = '', $other = '') {
        if (!isset($this->current_client->client_id)) {
            redirect(base_url() . 'login', 'refresh');
        }

        $client_id = $this->current_client_id;
        $phoneNumbers = $this->current_client_numbers;

        if (empty($grp_id)) {
            redirect(base_url() . 'clientuser/manage_bulkgroup/', 'refresh');
        }
        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }

        $groupinf = $this->bulktext->get_group($grp_id);
        $num_id = $groupinf->number_id;

        foreach($phoneNumbers as $num) {
            if($num->rec_id==$num_id) {
                $listnumber = $num;
                $phoneNumber = $details->phoneNumber;
            }
        }
        if (empty($listnumber)) {
            $listnumber = $phoneNumbers[0];
            $phoneNumber = $listnumber->phoneNumber;
        }

        $page_data['group_list'] = $this->bulktext->get_group_list($listnumber->rec_id);
        $page_data['group_info']       = $groupinf;
        $page_data['rec_id']       = $listnumber->rec_id;
        $page_data['list_info']      = $listnumber;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;

        $page_data['picked_who'] = $phoneNumber->phoneNumber;      
        $page_data['picked_num'] = $phoneNumber->phoneNumber;
        $page_data['sms_list']   = [];
        $page_data['bulk_count'] = count($this->bulktext->get_list_optinonly($groupinf->id,$listnumber->rec_id));

        /* update number */

        if (!empty($_POST) && $action=='updatelist') {
            $new_number_id = $listnumber->rec_id;
            $new_client_id = $this->current_client_id;
            $new_added = time();
            $toedit_id = $this->input->post('inlist_id');
            $new_user_fname = $this->input->post('user_fname');
            $new_user_lname = $this->input->post('user_lname');
            $new_user_moreinfo1 = $this->input->post('moreinfo1');
            $new_user_moreinfo2 = $this->input->post('moreinfo2');
            $new_optin = 0;
            $new_user_number = $this->format_international_number($this->input->post('user_number'));

            $moreinf = [];
            if($new_user_moreinfo1!='')
            $moreinf[] = $new_user_moreinfo1;
            if($new_user_moreinfo2!='')
            $moreinf[] = $new_user_moreinfo2;
            if($toedit_id=='') {
                if($this->bulktext->is_in_list($groupinf->id,$listnumber->rec_id,$new_user_number)) {
                    $this->session->set_flashdata('flash_message', get_phrase('Number Already in List!'));
                    redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
                }
                $this->bulktext->add_item(
                    $groupinf->id,
                    $new_client_id,
                    $new_number_id,
                    $new_user_number,
                    $new_user_fname,
                    $new_user_lname,
                    $new_optin,
                    $moreinf
                );

                $this->session->set_flashdata('flash_message', get_phrase('Number Added to List!'));
                redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
            
            } else {
                $this->bulktext->edit_item(
                    $groupinf->id,
                    $toedit_id,
                    $new_number_id,
                    $new_user_number,
                    $new_user_fname,
                    $new_user_lname,
                    $new_optin,
                    $moreinf
                );

                $this->session->set_flashdata('flash_message', get_phrase('Number Edited in List!'));
                redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
            }
        } else if($action=='edititem') {
            $inlist = $this->bulktext->get_item($other);
            if($inlist) {
                $page_data['numedit'] = $inlist;
                $page_data['umoreinfo'] = json_decode($inlist->user_moreinfo);
            }
        } else if($action=='delete') {
            $this->bulktext->delete_item($other);
            $this->session->set_flashdata('flash_message', get_phrase('Number Deleted in List!'));
            redirect(base_url() . 'clientuser/manage_bulksms/'.$groupinf->id, 'refresh');
        }

        $bulksms_list = $this->bulktext->get_list($grp_id,$listnumber->rec_id);

        $page_data['page_name']  = 'manage_bulklist';
        $page_data['page_title'] = get_phrase('Manage Bulk SMS List');
        $page_data['bulksms_list'] = $bulksms_list;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }

    function ajax_get_unread_text() {

        /* NEW CUSTOM AUDIENCE */
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $uid = (int) $this->session->userdata('login_user_id');
        $unreads = $this->db->query("SELECT COUNT(*) AS cnt, `from` as phoneNumber FROM `ct_messages` WHERE `direction`='in' AND `client_id`='".$uid."' AND `is_read`='0' GROUP BY `from`")->result_array();


        header('Content-Type:application/json');
        echo json_encode($unreads);
    }

    function ajax_get_custom_aud_id() {

        /* NEW CUSTOM AUDIENCE */
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }

        $data['number']      = $this->input->post('numbr');
        $naziv      = $this->input->post('name');

        header('Content-Type:application/json');

        if(empty($naziv))
            $naziv = 'CallerTech - '.date("Y-m-d H:i:s");

        $usr      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $user = $usr[0];
        if($user['adaccount'] != '') {
                $url = 'https://graph.facebook.com/v2.10/act_' . $user['adaccount'] . '/customaudiences?fields=description&access_token=' . $user['accesstoken'];
                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result  = curl_exec($ch);
                $decoded = json_decode($result)->data;


                if (1) {
                    //$custom_id = json_decode($result)->id;
                    $url       = 'https://graph.facebook.com/v2.10/act_' . $user['adaccount'] . '/customaudiences';
                    $fields    = array(
                        'name' => $naziv,
                        'subtype' => 'CUSTOM',
                        'description' => 'Generated on ' . date('Y-m-d H:i:s'),
                        'access_token' => $user['accesstoken']
                    );
                    $ch        = curl_init();
                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                    //execute post
                    $result    = curl_exec($ch);
                    $custom_id = json_decode($result)->id;
                    $client_id = $user['client_id'];
                   /* $updated   = $this->db->update('client_phonenumber_purchased', array(
                        'custom_audience_id' => $custom_id
                    ), array(
                        'rec_id' => $rec_id
                    ));*/

                    if( !empty($custom_id) ) {
                        $phoneNumber      = $this->input->post('numbr');
                        $datas['custom_audience_id'] = $custom_id; // 50.00
                        $this->db->where('phoneNumber', $phoneNumber);
                        $updated = $this->db->update('client_phonenumber_purchased', $datas);

                           $calls_reade = $this->db->get_where('advanced_caller_details', array(
                                'first_name!=' => '',
                                'linked_emails!=' => ''
                            ),30)->result_array();


                            $this->update_cust_audience($calls_reade,$user['accesstoken'],$custom_id);
                         
                        echo json_encode(array(
                            'status' => 'success',
                            'custom_id' => $custom_id
                        ));
                    }
                    else
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => 'Could not generate ID, check if you are logged in on Facebook and have your FB Ad ID added!',
                            'custom_id' => '',
                            'error_log' => json_decode($result)
                        ));


                }
                
                /* NEW CUSTOM AUDIENCE */ 
        } 

           
    }

    function ajax_save_access_token()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client_id = $this->session->userdata('login_user_id');
        
        /*$updated   = $this->db->update('client_phonenumber_purchased', array(
            'accesstoken' => $this->input->post('accesstoken')
        ) /*, 'expires' => $this->input->post('expires')) , array(
            'rec_id' => $rec_id
        ));*/

        $data['accesstoken'] = $this->input->post('accesstoken'); // 50.00
        $data['accessexpire'] = time(); // 50.00
        $this->db->where('client_id', $client_id);
        $updatesID = $this->db->update('client', $data);
        echo 1;
        return 1;
    }

    function fb_logout() {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client_id = $this->session->userdata('login_user_id');
        $user      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result();
        $data['accesstoken'] = '';
        $data['accessexpire'] = 0;

        $this->db->where('client_id', $client_id);
        $updated = $this->db->update('client', $data);

        $datas['custom_audience_id'] = '';
        $this->db->where('client_id', $client_id);
        $updated = $this->db->update('client_phonenumber_purchased', $datas);

        $this->session->set_flashdata('flash_message', get_phrase('Logged out of Facebook!'));
        redirect(base_url() . 'clientuser/manage_profile/', 'refresh');
    }

    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client_id = $this->session->userdata('login_user_id');
        $user      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $user = $user[0];
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();
        /*if (empty($phoneNumbers)) {
            //$this->session->set_flashdata('error', "Please purchase number first to see the account features.");
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }
        $phoneNumber = $this->uri->segment(3);
        if (empty($phoneNumber)) {
            $details = $phoneNumbers[0];
        } else {
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
            ));
            $this->db->where(array(
                'phoneNumber' => $phoneNumber
            ));
            $details = $this->db->get()->row_array();
        }

        <script type="text/javascript">
        _linkedin_data_partner_id = "275860";
        </script><script type="text/javascript">
        (function(){var s = document.getElementsByTagName("script")[0];
        var b = document.createElement("script");
        b.type = "text/javascript";b.async = true;
        b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
        s.parentNode.insertBefore(b, s);})();
        </script>
        <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=275860&fmt=gif" />
        </noscript>

        */
        $rec_id                    = $details['rec_id'];
        $page_data['rec_id']       = $rec_id;
        $page_data['details']      = $details;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;
        if ($param1 == 'update_profile_info') {
            $this->form_validation->set_rules('fname', 'first name', 'required');
            $this->form_validation->set_rules('lname', 'last name', 'required');
            $this->form_validation->set_rules('email', 'email adress ', 'required');
            $this->form_validation->set_rules('contact', 'Phone number', 'required');
            if ($this->form_validation->run() != FALSE) {
                $data['name']          = $this->input->post('fname');
                $data['lname']         = $this->input->post('lname');
                $data['email']         = $this->input->post('email');
                $data['second_email']         = $this->input->post('second_email');
                $data['contact']       = $this->input->post('contact');

                $data['adaccount']            = $this->input->post('adaccount');
                $data['adaccount_expire']     = $this->input->post('adaccount_expire');
/*                $data['custom_audience_id'] = $this->input->post('custom_audience_id');*/
                $data['send_custom_audience'] = $this->input->post('send_custom_audience');
         
                $data['address']       = $this->input->post('address');
                $data['timezone']      = intval( $this->input->post('timezone') );
                if($data['timezone']>12 || $data['timezone']<-12)
                    $data['timezone'] = 0;
                $data['company_name']  = $this->input->post('company_name');
                $client_id             = $this->session->userdata('login_user_id');
                $imagePrefix           = time();
                if(isset($_FILES["vcardfile"]['name']) && $_FILES["vcardfile"]['name']!='')
                    $this->upload_vcard_file();


                $data['flag_transcribe_call'] = $this->input->post('flag_transcribe_call');

                if($data['flag_transcribe_call']=='1') {
                    $rez = $this->_tw_addons($user['subaccount_sid'], $user['auth_token'], 'install', 'voicebase_transcription');
                } else {
                    $rez = $this->_tw_addons($user['subaccount_sid'], $user['auth_token'], 'uninstall', 'voicebase_transcription');
                }

                $data['profile_image'] = $this->input->post('profile_img');
                if (isset($_FILES["image"]) && $_FILES["image"]["name"] != '') {
                    $this->load->helper("url");
                    $result                = unlink("uploads/client_image/" . $data['profile_image']);
                    $data['profile_image'] = $imagePrefix . $_FILES["image"]["name"];
                    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/client_image/" . $imagePrefix . $_FILES["image"]["name"]);
                }
                $this->db->where('client_id', $client_id);
                $updated = $this->db->update('client', $data);
                //  move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/client_image/" . $client_id . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
                redirect(base_url() . 'clientuser/manage_profile/', 'refresh');
            }
        }

        $user      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();

        $page_data['usr']      = $user;

        if (!$user['accesstoken'] || $user['accesstoken'] != null) {
            $url    = 'https://graph.facebook.com/v2.10/device/login';
            $fields = array(
                'access_token' => '291700144652483|9071b67d65ff9ecb6018698127592d7b',
                'scope' => 'ads_management,ads_read,manage_pages'
            );
            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            //execute post
            $result                   = curl_exec($ch);
            $page_data['fbmarketing'] = json_decode($result);
        } else {
            $page_data['fbmarketing'] = json_decode($result);
        }

        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }

    function manage_blocked($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $client_id = $this->session->userdata('login_user_id');
        $user      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['usr'] = $user[0];
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
                'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
        ));
        $phoneNumber = $this->uri->segment(3);
        $phoneNumbers = $this->db->get()->result_array();
        if (empty($phoneNumbers)) {
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }
        if (empty($phoneNumber)) {
            $details = $phoneNumbers[0];
            $phoneNumber = $details['phoneNumber'];

        } else {
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
            ));
            $this->db->where(array(
                'phoneNumber' => $phoneNumber
            ));
            $details = $this->db->get()->row_array();
        }
        if($param2=='delete') {
              $this->db->where('id',$param3);
              $this->db->delete('ct_blocked_numbers');
                $this->session->set_flashdata('flash_message', get_phrase('Number Unblocked!'));
            redirect(base_url() . 'clientuser/manage_blocked/'.$phoneNumber, 'refresh');
        }

        $rec_id                    = $details['rec_id'];
        $page_data['rec_id']       = $rec_id;
        $page_data['details']      = $details;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;

        $phoneNumber_clean  = $phoneNumber;

        /* update number */

        if (!empty($_POST) && $phoneNumber!='') {
            $newinput['phoneNumber'] = $phoneNumber_clean;
            $newinput['client_id'] = $client_id;
            $newinput['times'] = 0;
            $newinput['created_at'] = time();
            $froms_call = str_replace('-', '', $this->input->post('blocked'));
            $froms_call = str_replace(' ', '', $froms_call);
            $froms_call = str_replace('(', '', $froms_call);
            $froms_call = str_replace(')', '', $froms_call);
            $newinput['blocked'] = '+1'.trim($froms_call); 
            $is_blocked = $this->db->get_where('ct_blocked_numbers', array(
                'client_id' => $client_id,
                'phoneNumber' => $phoneNumber_clean,
                'blocked' => $newinput['blocked']
            ))->row();
            if(empty($is_blocked) && $newinput['blocked']!='+1') {
                $this->db->insert('ct_blocked_numbers', $newinput);
                $this->session->set_flashdata('flash_message', get_phrase('Number Added to List!'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('Number Already Blocked!'));
            }
        }
        $this->db->select('*');
        $this->db->from('ct_blocked_numbers');
        $this->db->where(array(
            'client_id' => $client_id,
            'phoneNumber' => $phoneNumber_clean
        ));
        $listBlockedNum = $this->db->get()->result();

        $page_data['page_name']  = 'manage_blocked';
        $page_data['page_title'] = get_phrase('Manage Blocked Numbers');
        $page_data['blocked_listed'] = $listBlockedNum;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);

    }

    function manage_numbers($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }

        $page_data['zvuk_sek']       = 4;
        $client_id = $this->session->userdata('login_user_id');
        $user      = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['usr'] = $user[0];
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();
        if (empty($phoneNumbers)) {
            //$this->session->set_flashdata('error', "Please purchase number first to see the account features.");
            redirect(base_url() . 'clientuser/available_numbers/', 'refresh');
        }
        $phoneNumber = $this->uri->segment(3);
        if (empty($phoneNumber)) {
            $details = $phoneNumbers[0];
            $phoneNumber = $details['phoneNumber'];

        } else {
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active'
            ));
            $this->db->where(array(
                'phoneNumber' => $phoneNumber
            ));
            $details = $this->db->get()->row_array();
        }
        $rec_id                    = $details['rec_id'];
        $page_data['rec_id']       = $rec_id;
        $page_data['details']      = $details;
        $page_data['phoneNumber']  = $phoneNumber;
        $page_data['phoneNumbers'] = $phoneNumbers;
        if (!$details['accesstoken'] || $details['accesstoken'] != null) {
            $url    = 'https://graph.facebook.com/v2.10/device/login';
            $fields = array(
                'access_token' => '291700144652483|9071b67d65ff9ecb6018698127592d7b',
                'scope' => 'ads_management,ads_read,manage_pages'
            );
            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            //execute post
            $result                   = curl_exec($ch);
            $page_data['fbmarketing'] = json_decode($result);
        } else {
            $page_data['fbmarketing'] = json_decode($result);
        }
        if (!empty($_POST)) {
            // $this->form_validation->set_rules('call_forward_no_all', 'Phone number', 'required');
            $this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required');
            if ($this->form_validation->run() != FALSE) {
                $call_forward_no_all      = $this->input->post('call_forward_no_all');
                
                if($call_forward_no_all!='') {
                    $forwrds = explode(',',$call_forward_no_all);
                    if(count($forwrds)>1) {
                        $data['call_forward_no']      =  $forwrds[0];
                        foreach($forwrds as $k=>$fw) {
                            if($k!=0 && trim($fw)!='') {
                                $multi_forward[] = $fw;
                            }
                        }
                        $data['multi_forward']     = implode(',',$multi_forward);
    
                    } else {
                        $data['call_forward_no']   =  $forwrds[0];
                        $data['multi_forward']     = '';
    
                    }    
                } 
                    
                $data['sms_forward_no']      = $this->input->post('sms_forward_no');
                $data['send_custom_audience'] = $this->input->post('send_custom_audience');
                $data['flag_record_calls']    = $this->input->post('flag_record_calls');
                $data['flag_whisper_record']    = $this->input->post('flag_whisper_record');
                $data['whisper_message']    = $this->input->post('whisper_message');
                //$data['flag_transcribe_call'] = $this->input->post('flag_transcribe_call');
                $data['block_spam_calls']     = $this->input->post('block_spam_calls');

                $data['multi_timeout']     = $page_data['zvuk_sek'] * $this->input->post('multi_timeout');

                $data['voice_timeout']     = $page_data['zvuk_sek'] * $this->input->post('voice_timeout');
                
                $this->db->select('*');
                $this->db->from('client_phonenumber_purchased');
                $this->db->where(array(
                    'rec_id' => $rec_id
                ));

                $usrrow = $this->db->get()->row();

                $data['flag_auto_sms']     = intval($this->input->post('flag_auto_sms'));
                $data['flag_auto_sms_oncall']     = intval($this->input->post('flag_auto_sms_oncall'));
                $data['vcard_reply_text']        = ($this->input->post('vcard_reply_text'));
                $data['auto_sms_reply']    = $this->input->post('auto_sms_reply');
                if(isset($_FILES['auto_sms_file']['name']) && $_FILES['auto_sms_file']['name']!='')
                {

                    $config = array(
                    'upload_path' => 'uploads/',
                    'allowed_types' => 'png|jpg|jpeg|gif|zip|pdf',
                    'overwrite' => TRUE,
                    'max_size' => 5000,
                    'file_name' => date("Ymd").'_'.$_FILES["auto_sms_file"]['name']
                    );
                    $this->load->library('upload', $config);
                    if(!$this->upload->do_upload('auto_sms_file') && isset($_FILES["auto_sms_file"]['name']) && !empty($_FILES["auto_sms_file"]['name']))
                    { 
                        $datae['status'] =  'error';
                        $datae['message'] =  $this->upload->display_errors();
                        $this->session->set_flashdata('error', "Erorr: ".$datae['message']);
                    }
                    else
                    {
                        $datae['status'] =  'success';
                        $imageDetailArray = $this->upload->data();
                        $datae['fileUploaded']  =  $imageDetailArray;
                    }
                    if(isset($datae['fileUploaded'])) {
                        $data['auto_sms_file'] = base_url().'uploads/'.$datae['fileUploaded']['file_name'];
                        $data['auto_sms_type'] = $datae['fileUploaded']['file_type'];
                    }
                }
                $data['auto_vcard']        = intval($this->input->post('auto_vcard'));
                $data['voice_on']          = $this->input->post('voice_on');
                $privt = $this->input->post('voicetext');
                if(trim($privt) != '')
                    $data['voicetext'] = $privt;
                else 
                    $data['voicetext'] = $usrrow->voicetext;

                if(isset($_FILES['voicefile']['name']) && $_FILES['voicefile']['name']!='')
                    $data['voicename_url'] = $this->upload_voicemail_file();
                else if(trim($privt)!='' && $privt!=$usrrow->voicetext)
                    $data['voicename_url'] = '';

                $data['flag_mailnotif_sms']    = intval( $this->input->post('flag_mailnotif_sms') );
                $data['flag_mailnotif_call']   = intval( $this->input->post('flag_mailnotif_call') );

                //$data['flag_adv_lookup']      = $this->input->post('flag_adv_lookup');
                $data['adaccount']            = $this->input->post('adaccount');
                $data['adaccount_expire']     = $this->input->post('adaccount_expire');
                $data['custom_audience_id']     = $this->input->post('custom_audience_id');

                $data['campaign_name']        = $this->input->post('campaign_name');
                $client_id                    = $this->session->userdata('login_user_id');
                
                if($data['custom_audience_id']==''){
                /* DELETE CUSTOM AUDIENCE */
                $url                          = 'https://graph.facebook.com/v2.8/act_' . $this->input->post('adaccount') . '/customaudiences?fields=description&access_token=' . $details['accesstoken'];
                $ch                           = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result  = curl_exec($ch);
                $decoded = json_decode($result)->data;
                foreach ($decoded as $d) {
                    $time   = strtotime(str_replace('Generated on ', '', $d->description));
                    $expire = 0;
                    $expire = $details['adaccount_expire'] * 86400;
                    $time += $expire;
                    $time_compare = time();
                    if ($time < $time_compare) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v2.8/' . $d->id);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                            'access_token' => $details['accesstoken']
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($ch);
                    }
                }
            }
                /* NEW CUSTOM AUDIENCE */
                /*
                $url = 'https://graph.facebook.com/v2.8/act_' . $this->input->post('adaccount') . '/customaudiences?fields=description&access_token=' . $details['accesstoken'];
                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result  = curl_exec($ch);
                $decoded = json_decode($result)->data;
                if (empty($decoded)) {
                    $custom_id = json_decode($result)->id;
                    $url       = 'https://graph.facebook.com/v2.8/act_' . $this->input->post('adaccount') . '/customaudiences';
                    $fields    = array(
                        'name' => 'CallerTech',
                        'subtype' => 'CUSTOM',
                        'description' => 'Generated on ' . date('Y-m-d H:i:s'),
                        'access_token' => $details['accesstoken']
                    );
                    $ch        = curl_init();
                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                    //execute post
                    $result    = curl_exec($ch);
                    $custom_id = json_decode($result)->id;
                    $client_id = $details['client_id'];
                    $updated   = $this->db->update('client_phonenumber_purchased', array(
                        'custom_audience_id' => $custom_id
                    ), array(
                        'rec_id' => $rec_id
                    ));
                }
                */
                /* NEW CUSTOM AUDIENCE */

                $this->db->where('rec_id', $rec_id);
                $updated = $this->db->update('client_phonenumber_purchased', $data);
                // $this->db->_error_message();
                $this->session->set_flashdata('flash_message', get_phrase('Phone Number Details Updated'));
                redirect(base_url() . 'clientuser/manage_numbers/' . $phoneNumber, 'refresh');
            }
        }

        $page_data['page_name']  = 'manage_numbers';
        $page_data['page_title'] = get_phrase('Manage Number ' . $details['friendlyName']);
        $page_data['row']        = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row_array();
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }

    function change_password()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $this->form_validation->set_rules('password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_new_password', 'Confirmed Password', 'required');
        if ($this->form_validation->run() != FALSE) {
            $current_password_input = sha1($this->input->post('password'));
            $new_password           = sha1($this->input->post('new_password'));
            $confirm_new_password   = sha1($this->input->post('confirm_new_password'));
            $current_password_db    = $this->db->get_where('client', array(
                'client_id' => $this->session->userdata('login_user_id')
            ))->row()->password;
            if ($current_password_db != $current_password_input) {
                $this->session->set_flashdata('error', get_phrase('Current Password do not match.Re-enter old password'));
            }
            if ($new_password != $confirm_new_password) {
                $this->session->set_flashdata('error', get_phrase('Confirm Password do not match. Re-enter password'));
            }
            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('client_id', $this->session->userdata('login_user_id'));
                $this->db->update('client', array(
                    'password' => $new_password
                ));
                $this->session->set_flashdata('flash_message', get_phrase('Password updated successfully'));
            }
        }
        $page_data['page_name']  = 'change_password';
        $page_data['page_title'] = get_phrase('change_password');
        $page_data['edit_data']  = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }
    function profile_page()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $page_data['page_name']  = 'profile_page';
        $page_data['page_title'] = get_phrase('profile_page');
        $page_data['edit_data']  = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }
    function plan()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $page_data['page_name']  = 'plan_page';
        $page_data['page_title'] = get_phrase('plan_page');
        $plan                    = $this->db->get_where('client_payment_details', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $page_data['plan']       = $plan;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }
    public function report()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $this->db->where('client_payment_details.client_id', $this->session->userdata('login_user_id'));
        $this->db->join('packages', 'packages.package_id=client_payment_details.plan_id');
        $this->db->join('client', 'client.client_id=client_payment_details.client_id');
        $details                 = $this->db->get('client_payment_details')->result_array();
        $page_data['page_name']  = 'report_page';
        $page_data['page_title'] = get_phrase('Invoice');
        $page_data['details']    = $details;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        /*$this->load->helper(array('dompdf', 'file'));
        
        $html = $this->load->view('frontend/report_page' , array('member'=>$member) , true);
        
        $data = pdf_create($html, 'Statment_'.$member[0]['fname'].' '.$member[0]['lname'], true);
        
        
        
        write_file('./uploads/report/statment_'.$member[0]['fname'].' '.$member[0]['lname'].'.pdf', $data);*/
    }
    public function paymentinvoice()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $subscription_id = $this->uri->segment(3);
        $this->db->where('client_payment_details.subcription_id', $subscription_id);
        //$this->db->join('packages','packages.package_id=client_payment_details.plan_id');
        $this->db->join('client', 'client.client_id=client_payment_details.client_id');
        $details                 = $this->db->get('client_payment_details')->result_array();
        //print_r($details);exit;
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('Invoice');
        $page_data['details']    = $details;
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        /*$this->load->helper(array('dompdf', 'file'));
        
        $html = $this->load->view('frontend/report_page' , array('member'=>$member) , true);
        
        $data = pdf_create($html, 'Statment_'.$member[0]['fname'].' '.$member[0]['lname'], true);
        
        
        
        write_file('./uploads/report/statment_'.$member[0]['fname'].' '.$member[0]['lname'].'.pdf', $data);*/
    }
    public function export_excel()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        /** Error reporting */
        //error_reporting(E_ALL);
        /** Include PHPExcel */
        //require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
        require_once APPPATH . 'third_party/PHPExcel.php';
        require_once APPPATH . 'third_party/PHPExcel/Writer/Excel2007.php';
        // Create new PHPExcel object
        //echo date('H:i:s') . " Create new PHPExcel object\n";
        $objPHPExcel = new PHPExcel();
        // Set properties
        //echo date('H:i:s') . " Set properties\n";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $this->db->select('cl.*,cl_ph.*');
        $this->db->from('client cl');
        $this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
        $this->db->where(array(
            'cl.client_id' => $this->session->userdata('login_user_id'),
            'cl_ph.status' => 'active'
        ));
        $query         = $this->db->get();
        $clientdetails = $query->row(); // ->row()->num);
        $this->db->order_by("caller_id", "desc");
        $calls_read = $this->db->get_where('advanced_caller_details', array(
            'to_call' => $clientdetails->phoneNumber
        ))->result_array();
        //print_r($account);
        // Add some data
        //echo date('H:i:s') . " Add some data\n";
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Carrier');
        $q = 2;
        foreach ($calls_read as $cread) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $q . '', 'Name:' . $cread['first_name'] . ' ' . $cread['middle_name'] . ' ' . $cread['last_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $q . '', 'Carrier:' . $cread['carrier']);
            $q++;
        }
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->sethorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(150);
        //$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(60);
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //echo str_replace('.php', '.xlsx', __FILE__);
        $objWriter->save('./excel/advanced_lookup.csv');
        $url = base_url() . 'excel/advanced_lookup.csv';
        header('Location:' . $url . '');
    }
    
    public function purchase_usage_topup()
    {
        if( $this->session->userdata('login_user_id') != '' )
            $clint_id = $this->session->userdata('login_user_id');
        else
            $clint_id = $_POST['custom'];
            
        if (($_POST['payment_status'] == 'Completed') && ($clint_id != '')) {
            ####TRADES men signup entry in table ###
            $clientID = $clint_id;
            ############end signup insertion
            $signupData = $this->db->get_where('client', array('client_id' => $clientID))->row();
            //print_r($_POST);exit;
            $page_data['buyer_first_name']       = $_POST["first_name"]; // test
            $page_data['buyer_last_name']        = $_POST["last_name"]; // buyer
            $page_data['payer_address_country']  = $_POST["address_country"]; // United Kingdom
            $page_data['payment_payer_email']    = $_POST["payer_email"]; // alttestdemo-buyer@gmail.com
            $page_data['payment_status']         = $_POST['payment_status'];
            $page_data['payment_txn_id']         = $_POST["txn_id"]; // 93172640FX364415P //seller
            $page_data['payment_receiver_email'] = $_POST["receiver_email"]; // alttestdemo-facilitator@gmail.com
            $page_data['payment_fee']            = $_POST["payment_fee"]; // 1.75
            $page_data['payment_auth']           = $_POST["auth"]; //
            $page_data['payment_mc_currency']    = $_POST["mc_currency"]; // USD
            $page_data['plan_name']              = $_POST["item_name"]; // subscription Title  ///plan title.
            $page_data['payment_gross_amount']   = $_POST["payment_gross"]; // 50.00
            $page_data['payment_date']           = date('Y-m-d'); // 03:08:27 Jun 20, 2016 PDT
            $page_data['payment_time']         = date("H:i:s");
            $page_data['qty']                    = $_POST["quantity"]; // 1
            $page_data['plan_id']                = $signupData->subscription_id; // 1
            $page_data['client_id']              = $clientID; // 1
            //insert payment details in payment store_payment_details

            $this->db->insert('client_payment_details', $page_data);
            $payment_details_id     = $this->db->insert_id();
            $package_details        = $this->db->get_where('packages', array(
                'package_id' => $signupData->subscription_id
            ))->row();

            $account_balance = $this->get_balance($clientID);

            /* UPDATE BALANCE - ADD TO BALANCE */
            $data['available_fund'] = $account_balance + $_POST["payment_gross"]; // 50.00
            $this->db->where('client_id', $clientID);
            $updatesID = $this->db->update('client', $data);
            /* UPDATE BALANCE */
            
            ####Active if account suspended the useraccount while balance is below 0.5 $this->AdminAccountSid $this->AdminAuthToken
            //echo $AdminAccountSid  = //$this->db->get_where('settings', array('type' => 'account_sid'))->row()->description; echo "<br>";
            //echo $AdminAuthToken  = //$this->db->get_where('settings', array('type' => 'account_token'))->row()->description;
            $AdminAccountSid = $this->AdminAccountSid;
            $AdminAuthToken  = $this->AdminAuthToken;
            $datacleint      = new Client($AdminAccountSid, $AdminAuthToken);
            $datacleint->accounts($signupData->subaccount_sid)->update(array(
                'status' => 'active'
            )); //->fetch();
            ##############################################################################################
            //echo "<br><br>congrats ! you have success fully purchased number :-".$phonenumber;
            //echo '<br> number data - ';print_r($number); exit;
            ###### INSERT DATA INTO CLEINT PHONE NUMBERS PURCHASED......
            $system_email = $this->db->get_where('settings', array(
                'type' => 'system_email'
            ))->row()->description;
            $system_title = $this->db->get_where('settings', array(
                'type' => 'system_title'
            ))->row()->description;
            $system_name  = $this->db->get_where('settings', array(
                'type' => 'system_name'
            ))->row()->description;
            $message      = '<html>
            <body>
            <p>Dear <strong>' . $signupData->name . ' ' . $signupData->lname . '</strong>,</p>
            <p>We welcome you at ' . $system_title . '! </p>
            <p><b><strong>You have successfull made payment for :    Usage Top up to start ur lookup service.' . $_POST["payment_gross"] . '</strong></b> </p>
            <table border="1">
            <tr>
            <th> Active number </th>
            <th> Amount</th><th>Validity</th>
            </tr>
            <tr>
            <td>' . $_POST["item_name"] . '</td>
            <td>' . $_POST["payment_gross"] . '</td><td>' . $package_details->duration_id . ' month/s.</td>
            </tr>
            </table>
            <p><b><strong>Your Account Details are: </strong> </b><small><em>(Please do not disclose your account credentials to any one )</em></small></p>
            <p><strong>Login Email :  </strong> ' . $signupData->email . '</p>
            <p><strong>You can get account here  : </strong>' . base_url() . 'login </p>
            </body><br /><br /><br /><br /><br />
            <p>Regards , </p>
            <p>' . $system_name . '</p>
            </html>';
            $this->load->library('email'); // load email library

            
            /*$this->email->from($system_email, $system_title);
            
            $this->email->to($signupData->email);
            
            $this->email->subject('amount paid to your account for usage');
            
            $this->email->message($message);
            $this->email->send();*/
            $this->session->set_flashdata('flash_message', 'Usage top-up Done succesfully..!!');
            redirect(base_url() . 'clientuser/dashboard/', 'refresh');
            //*******************************//
        } ///end of if Paymen sucess............
        ################## ################## ##################
        //$page_data['page_name'] = 'buy_number';
        //$page_data['page_title'] = get_phrase("Purchased phone Number's Details");
        //$page_data['clientPhoneDetails']= $clientPhoneDetails;
        //$page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
        ################## ################## ##################
    }
    
    public function get_call_log()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        
        $countryData                = array();
        $page_data['friendlyName']  = '';
        $page_data['phoneNumber']   = '';
        $page_data['lata']          = '';
        $page_data['region']        = '';
        $page_data['country']       = '';
        $page_data['country_price'] = '';
        $price                      = array();
        $calls_read                 = array();
        
        $clInetId = $this->session->userdata('login_user_id');
        if (empty($this->session->userdata('login_user_id'))) {
            redirect(base_url('login'));
        }
        
        $this->db->select('cl.*,cl_ph.*');
        $this->db->from('client cl');
        $this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
        $this->db->where(array(
            'cl.client_id' => $this->session->userdata('login_user_id'),
            'cl_ph.status' => 'active'
        ));
        
        $phoneNumber = $this->uri->segment(3);
        if (!empty($phoneNumber)) {
            $this->db->where(array(
                'cl_ph.phoneNumber' => $phoneNumber
            ));
        }
        $query         = $this->db->get();
        $clientdetails = $query->row();
        
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
            'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();
        
        
        $subAccountSid       = $clientdetails->subaccount_sid;
        $subAccountAuthToken = $clientdetails->auth_token;
        
        $page_data['timezone']            = $clientdetails->timezone;
        $page_data['clientEmail']            = $clientdetails->email;
        $page_data['phoneNumbers']           = $phoneNumbers;
        $page_data['clientNamee']            = $clientdetails->name . ' ' . $clientdetails->lname;
        $page_data['phone_number_purchased'] = $clientdetails->phoneNumber;
        $page_data['phone_number_formatted'] = $clientdetails->friendlyName;
        $page_data['phoneSid']               = $clientdetails->phoneSid;
        $page_data['subaccount_sid']         = $clientdetails->subaccount_sid;
        $page_data['subaccount_name']        = $clientdetails->subaccount_name;
        
        $client = new Client($this->AdminAccountSid, $this->AdminAuthToken);
        
        
        try {
            $account           = $client->accounts($subAccountSid)->fetch();
            $recordings_result = $account->recordings->read();

            try {
                
                if ($account->status == 'active') {
                    $subAccountauthToken = $account->authToken;
                    
                $this->load->helper('twilio_handlers');
                    try {
                        $ij = 0;
                        if (!empty($phoneNumber)) {
                            $sets = array(
                                "to" => $phoneNumber
                            );
                            if(isset($_GET['filt_from']) && $_GET['filt_from']!='') {
                                $sets['startTimeAfter'] = date('Y-m-d',strtotime($_GET['filt_from']));
                                $page_data['lem_filt_from'] = date('Y-m-d',strtotime($_GET['filt_from']));
                            }

                            if(isset($_GET['filt_to']) && $_GET['filt_to']!='') {
                                $sets['endTimeBefore'] = date('Y-m-d',strtotime($_GET['filt_to']));
                                $page_data['lem_filt_to'] = date('Y-m-d',strtotime($_GET['filt_to']));
                            }

                            $call_log_arr = $account->calls->read($sets);
                            $page_data['phone_number_picked'] = $phoneNumber;
                            $page_data['phone_number_picked_nice'] = ct_format_nice_number($phoneNumber);
                        } else {
                            $sets = array();
                            if(isset($_GET['filt_from'])) {
                                $sets['startTimeAfter'] = date('Y-m-d',strtotime($_GET['filt_from']));
                                $page_data['lem_filt_from'] = date('Y-m-d',strtotime($_GET['filt_from']));
                            }

                            if(isset($_GET['filt_to'])) {
                                $sets['endTimeBefore'] = date('Y-m-d',strtotime($_GET['filt_to']));
                                $page_data['lem_filt_to'] = date('Y-m-d',strtotime($_GET['filt_to']));
                            }
                            $call_log_arr = $account->calls->read($sets);
                        }
                        //echo $clientdetails->phoneNumber;
                        foreach ($call_log_arr as $call) {
                            if($call->direction!='inbound')
                                continue;
                            $endtime                   = $call->endTime->format("m-d-Y H:i:s");
                            $startTime                 = $call->startTime->format("m-d-Y H:i:s");
                            $calls_read['direction'][$ij] = $call->direction;
                            $calls_read['duration'][$ij]  = $call->duration;
                            $calls_read['from'][$ij]      = $call->from;
                            $calls_read['sid'][$ij]       = $call->sid;
                            $calls_read['name'][$ij]      = $call->callerName;
                            
                            $calls_read['to'][$ij]        = $call->to;
                            $calls_read['startTime'][$ij] = $startTime;
                            $calls_read['endTime'][$ij]   = $endtime;
                            $calls_read['price'][$ij]     = $call->price;

                            $froms_call = $call->from;
                            $froms_call = str_replace('-', '', $froms_call);
                            $froms_call = str_replace(' ', '', $froms_call);
                            $froms_call = str_replace('(', '', $froms_call);
                            $froms_call = str_replace(')', '', $froms_call);
                            //$froms_call = '+1' . $froms_call;
                            $advncd = $this->db->get_where('advanced_caller_details', array(
                                'phoneNumber' => $froms_call
                            ))->row();
                            $calls_read['name'][$ij] = $advncd->first_name.' '.$advncd->last_name;
                            $calls_read['advanced_number'][$ij] = $froms_call;
                            
                            
                            $calls_read['priceUnit'][$ij] = $call->priceUnit;
                            
                            $calls_read['status'][$ij] = $call->status;

                            $calls_read['mp3_url'][$ij] = false;
                            $calls_read['has_transcriptions'][$ij] = false;
                            $calls_read['request_sid'][$ij]        = 0;

                            foreach ($recordings_result as $key => $r) {
                                if ($r->callSid == $call->sid) {

                                    $this->db->select('id,text');
                                    $this->db->where('re_sid', $r->sid);
                                    $rez_trans = $this->db->get('ct_transcripts')->result_array();

                                    if(!empty($rez_trans)) { // we have transcription
                                        $callTexttt = $rez_trans[0]['text'];
                                        $transcript_id = $rez_trans[0]['id'];
                                        $calls_read['tr_url'][$ij]             = site_url('base/download_transcription/'.$transcript_id);
                                        $calls_read['request_sid'][$ij]        = $transcript_id;
                                        $calls_read['has_transcriptions'][$ij] = true;
                                        $calls_read['textread'][$ij] = htmlspecialchars($callTexttt);
                                        
                                        
                                    } else {
                                        $calls_read['tr_url'][$ij]             = 'none';
                                        $calls_read['request_sid'][$ij]        = 'none';
                                        $calls_read['has_transcriptions'][$ij] = false;
                                    }
                                    
                                    
                                    $calls_read['mp3_url'][$ij] = str_replace('.json', '', 'https://api.twilio.com' . $r->uri . '.mp3');
                                }
                            }
                            $ij++;
                            
                            
                        }
                        
                        
                    }
                    catch (Exception $e) {
                        
                        
                        echo "Error: " . $e->getMessage();
                        
                    }
                    
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('Account suspended,Please contact administrator.'));
                }
                //print_r($calls_read);
                $page_data['calls_read'] = $calls_read;
            }
            catch (Exception $e) {
                $page_data['system_error'] = " System Error: " . $e->getMessage() . "<br><br>Account Credentials not Authenticate, Please contact administrator.";
            }
            
            ### if selected as country
        }
        catch (Exception $e) {
            $page_data['system_error'] = " System Error: " . $e->getMessage() . "<br><br>Account Credentials not Authenticate, Please contact administrator.";
        }
        
        $page_data['page_name']  = 'call_logs';
        $page_data['page_title'] = get_phrase('call logs list');
        $page_data['site_settings'] = $this->SiteSettings;
        $this->load->view('index', $page_data);
    }
    
    public function number_lookup()
    { 
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        
        if (!empty($phoneNumber))
            $this->db->select('cl.*,cl_ph.*');
        else
            $this->db->select('cl.*');
        $this->db->from('client cl');
        $phoneNumber = $this->uri->segment(3);
        $phoneall = $this->uri->segment(4);

        if($phoneNumber=='all') {
            redirect(base_url() . 'clientuser/number_lookup', 'refresh');
            die('');
        }

        if($phoneNumber=='manual') {
            $phoneNumber = '';
            $is_manual = true;
        } else {
            $is_manual = false;
       }

        if (!empty($phoneNumber)) {
            $this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
            $this->db->where(array(
                'cl_ph.phoneNumber' => $phoneNumber,
                'cl_ph.status' => 'active'
            ));
        }
        $this->db->where(array(
            'cl.client_id' => $this->session->userdata('login_user_id')
        ));
        $query         = $this->db->get();
        $clientdetails = $query->row();
        
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $this->session->userdata('login_user_id'),
            'status' => 'active'
        ));
        $phoneNumbers = $this->db->get()->result_array();
        
        $page_data['phoneNumbers'] = $phoneNumbers;
        $page_data['picked_prvi'] = $phoneNumbers[0]['phoneNumber'];

        
        $charges = $this->crud_model->fetch_package_pricing($clientdetails->subscription_id);
        
        $cost = $charges['lookup_call_charge'];
       $page_data['client_details'] =  $clientdetails;
        
        if ($clientdetails->send_custom_audience) {
            $costToSocialMedia = $charges['p_social_med_adv'];
        } else {
            $costToSocialMedia = 0;
        }
        
        $countryData = array();
        
        $page_data['friendlyName']  = '';
        $page_data['phoneNumber']   = '';
        $page_data['lata']          = '';
        $page_data['region']        = '';
        $page_data['country']       = '';
        $page_data['country_price'] = '';
        $price                      = array();
        $calls_read                 = array();
        
        
        $printsa = $alreadyPrinted = $this->db->get_where('ct_printed_numbers', array(
            'client_id' => $clientFUNFDetails->client_id
        ))->row();
        $list_pr = array();
        foreach($printsa as $pr) {
            $list_pr[$pr['phoneNumber']] = $pr;
        }
        $page_data['printed_numbers'] = $list_pr;

        $printsa = $alreadyPrinted = $this->db->get_where('ct_vcard_numbers', array(
            'client_id' => $clientFUNFDetails->client_id
        ))->row();
        $list_pr = array();
        foreach($printsa as $pr) {
            $list_pr[$pr['phoneNumber']] = $pr;
        }
        $page_data['vcard_numbers'] = $list_pr;
        
        $subAccountSid = $clientdetails->subaccount_sid;
        
        $page_data['send_custom_audience']   = $clientdetails->send_custom_audience;
        $page_data['phone_number_purchased'] = $phoneNumber;
        $page_data['phone_number_formatted'] = $clientdetails->friendlyName;
        $page_data['phoneSid']               = $clientdetails->phoneSid;
        $page_data['subaccount_sid']         = $clientdetails->subaccount_sid;
        $page_data['subaccount_name']        = $clientdetails->subaccount_name;
        
        ############################ FETCHED ADVANCE CALL DETAILS #######################################
        
        
        if (!empty($phoneNumber) && empty($phoneall)) {
            $calls_read = $this->db->query("select * from advanced_caller_details where phoneNumber=" . $phoneNumber . " LIMIT 1")->result_array();
            $page_data['view_one_number']  = $phoneNumber;
        } else {
            if(!empty($phoneNumber) && !empty($phoneall) ) {
                $calls_read = $this->db->query("select * from (select ac.*,cl.id,cl.location,cl.client_id,cl.date_added,cl.from, cl.from as odakle from  caller_look_up cl left join advanced_caller_details ac on ac.phoneNumber = cl.phonenumber where (client_id='" . $this->session->userdata('login_user_id') . "' and cl.from='".$phoneNumber."')  order by cl.id desc) AS tmp_table GROUP BY phoneNumber ORDER BY id DESC")->result_array();

                $page_data['picked_who'] = $phoneNumber;

            } else {
                if($is_manual)
                    $calls_read = $this->db->query("select * from (select ac.*,cl.id,cl.location,cl.client_id,cl.date_added,cl.from, cl.from as odakle from caller_look_up cl left join advanced_caller_details ac on ac.phoneNumber = cl.phonenumber where client_id=" . $this->session->userdata('login_user_id') . " AND location='manual' order by cl.id desc) AS tmp_table GROUP BY phoneNumber ORDER BY id DESC")->result_array();
                else 
                    $calls_read = $this->db->query("select * from (select ac.*,cl.id,cl.location,cl.client_id,cl.date_added,cl.from, cl.from as odakle from caller_look_up cl left join advanced_caller_details ac on ac.phoneNumber = cl.phonenumber where client_id=" . $this->session->userdata('login_user_id') . " order by cl.id desc) AS tmp_table GROUP BY phoneNumber ORDER BY id DESC")->result_array();

                $page_data['picked_who'] = '';

            }
        }
        
        $account_balance = $this->get_balance();

        if($charges['is_subscription'] == 1 ) {
            $srvc_received = $this->crud_model->get_subs_count($clientdetails->client_id,'max_call_lookup');
            $max_call_lookup = $charges['max_call_lookup'];
            $hasBalance = ($srvc_received < $max_call_lookup);
        }
        else {
            $hasBalance = (bool) ($account_balance > ((float) $cost + (float) $costToSocialMedia));
        }
    
        if (!$hasBalance) {
            $this->session->set_flashdata('not_fund', ((float) $cost + (float) $costToSocialMedia));
        }

            
            $page_data['usr_vCard']  = $clientdetails->vcard_url;
            $page_data['page_name']  = 'advanced_call_logs';
            $page_data['calls_read'] = $calls_read;
            $page_data['page_title'] = get_phrase('Caller details ');
            
            $page_data['site_settings'] = $this->SiteSettings;
            $this->load->view('index', $page_data);

    }
}