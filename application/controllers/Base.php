<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;

class Base extends CT_Base_Controller
{
    public $client;
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url'
        ));
        $clInetId = $this->session->userdata('login_user_id');
        
        $this->AdminAccountSid = $this->TwilioSettings['AccountSID'];
        $this->AdminAuthToken  = $this->TwilioSettings['AccountAuthToken'];
        
        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
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
    
    /* Private functions */
    
    private function _response_console($data, $status = 'success', $mess = '')
    {
        
        switch ($status) {
            case '400';
                header('Content-Type:application/json');
                header('HTTP/1.1 400 BAD REQUEST');
                $data['status'] = 'error';
                echo json_encode($data);
                break;
            
            case '404';
                header('Content-Type:application/json');
                header('HTTP/1.1 404 Not Found');
                $data['status'] = 'error';
                echo json_encode($data);
                break;
            
            default:
                header('Content-Type:application/xml');
                    die("<Response></Response>");
        }
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

    private function _send_sms($sms_data,$from_client=false) {
        if($from_client==false) {
            //get user deetails  = SID
            $clientdetails = $this->db->get_where('client', array(
                'client_id' => $this->session->userdata('login_user_id')
            ))->row();

        } else {
            $clientdetails = $from_client;
        }
        $subAccountSid = $clientdetails->subaccount_sid;
        $client        = new Client($this->AdminAccountSid, $this->AdminAuthToken);
        $account       = $client->accounts($subAccountSid)->fetch();
        
        /* --- Check if has that phone number */
        $this->db->select('*');
        $this->db->from('client_phonenumber_purchased ');
        $this->db->where(array(
            'client_id' => $clientdetails->client_id,
            'status' => 'active',
        ));
        $doez_have_ph = false;
        $phoneNumbers = $this->db->get()->result_array();
        foreach ($phoneNumbers as $phn) {
            if ($phn['phoneNumber'] == $sms_data['from']) {
                $doez_have_ph = true;
            }
        }

        if ($doez_have_ph == false)
            die("You do not own this phone number: ".$sms_data['from']); // the client does not own this phone number
        /* --- Check if has that phone number */
        
        $charges = $this->crud_model->fetch_package_pricing($clientdetails->subscription_id);
        $account_balance = $this->get_balance($clientdetails->client_id);

        if($charges['is_subscription'] == 1 ) {

            if($sms_data['media_urls'] != false) {
                $srvc_received = $this->crud_model->get_subs_count($clientdetails->client_id,'max_send_mms');
                $max_mms_received = $charges['max_send_mms'];
                $hasBalance = ($srvc_received < $max_mms_received);

            } else {
                $srvc_received = $this->crud_model->get_subs_count($clientdetails->client_id,'max_send_sms');
                $max_sms_received = $charges['max_send_sms'];
                $hasBalance = ($srvc_received < $max_sms_received);
            }
        }
        else {
            $hasBalance = ($account_balance > $charges['sms_send_charge']);
        }
        
        if($hasBalance) {
            $mesInfo =  array(
                // Step 6: Change the 'From' number below to be a valid Twilio number 
                // that you've purchased
                'from' => $sms_data['from'],
                // the sms body
                'body' => $sms_data['message']
            );


            if($sms_data['media_urls'] != false) {
                if(!is_array($sms_data['media_urls']))
                    $sms_data['media_urls'] = unserialize($sms_data['media_urls']);
                $mesInfo['mediaUrl'] = $sms_data['media_urls'][0]['mediaUrl'];
                $sms_data['mms_num_files'] = count ($sms_data['media_urls']);
                $sms_data['media_urls'] = serialize ($sms_data['media_urls']);
            }

            $sms = $account->messages->create(
            // the number we are sending to - Any phone number
                $sms_data['to'],$mesInfo);
            $sms_data['sms_sid'] = $sms->sid;
            $sms_data['client_id'] = $clientdetails->client_id;
            if( !empty($sms_data['message']) )
                $this->db->insert('ct_messages', $sms_data);
            $insert_id = $this->db->insert_id();

            if($charges['is_subscription'] == 1 ) {
                // Update +1 max_send_sms

            if($sms_data['media_urls'] != false) {
                 $this->crud_model->update_subs_count($clientdetails->client_id,'max_send_mms');
            } else {
                 $this->crud_model->update_subs_count($clientdetails->client_id,'max_send_sms');
            }
                // $max_sms_sent = $max_sms_sent+1;

            } else {
                //Adding the cost to the payment history
                $insert_data_pay = array();
                $insert_data_pay['client_id']            = $clientdetails->client_id;
                $insert_data_pay['payment_gross_amount'] = -(float) $charges['sms_send_charge'];
                $insert_data_pay['plan_name']            = 'payment_against_sms_send_charge';
                $insert_data_pay['payment_date']         = date("Y-m-d");
                $insert_data_pay['payment_time']         = date("H:i:s");
                $insert_data_pay['pay_meta']  = 'from='. $sms_data['from'] . '|to=' . $sms_data['to'].'|sms_id='.$sms_data['sms_sid'];
                $this->db->insert('client_payment_details', $insert_data_pay);

                /* UPDATE BALANCE */
                $account_balance = ($account_balance - (float)$charges['sms_send_charge']);
                $cleint_Data['available_fund'] = $account_balance;
                $this->db->where('client_id', $clientdetails->client_id);
                $this->db->update('client', $cleint_Data);
                /* UPDATE BALANCE */

            }
        } else {
            $this->session->set_flashdata('error_sms', get_phrase('You have used up your available SMS count!'));
        }

        return $insert_id;
    }
    
    /* Public handlers */
    
    public function index()
    {
        $AccountSid = $this->AdminAccountSid;
        $AuthToken  = $this->AdminAuthToken;
            redirect(base_url() . 'home', 'refresh');
    }
    
    public function createSubaccount()
    {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        $data          = array();
        $clientdetails = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        if (!empty($clientdetails) && $clientdetails->subaccount_created != 'y') {
            //  $AccountSid = "AC4dcfbca69fbc07b4e2bf57c85cf18b80";//"AC4dcfbca69fbc07b4e2bf57c85cf18b80";
            //  $AuthToken = "a5c539fa29e1a40b137d6535b768bcce";//"a5c539fa29e1a40b137d6535b768bcce";
            $AccountSid        = $this->AdminAccountSid;
            $AuthToken         = $this->AdminAuthToken;
            $client_id         = $this->session->userdata('login_user_id');
            $subaccountName    = $this->session->userdata('name') . '_' . $this->session->userdata('lname') . '_' . $client_id;

            $data              = new Client($AccountSid, $AuthToken);

            $account           = $data->accounts->create(array(
                "friendlyName" => $subaccountName
            ));

            $friendlyName      = $account->friendlyName;
            $sid               = $account->sid;
            $auth_token        = $account->authToken;
            $subaccount_status = $account->status;
            $ownerAccountSid   = $account->ownerAccountSid;
            $data              = array(
                'subaccount_created' => 'y',
                'subaccount_name' => $friendlyName,
                'subaccount_sid' => $sid,
                'auth_token' => $auth_token,
                'subaccount_status' => $subaccount_status,
                'owner_account_sid' => $ownerAccountSid
            );
            ###########################################
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
            ###########################################
            
            if ($updatesID) {
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
                redirect(base_url() . 'clientuser/dashboard/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('Error_in_account_not_updated'));
                redirect(base_url() . 'clientuser/dashboard/', 'refresh');
            }
        } else {
            $this->session->set_flashdata('flash_message', get_phrase('system_confirmation_already_done'));
            redirect(base_url() . 'clientuser/dashboard/', 'refresh');
        }
    }
    
    
    
    
    public function disable_user_sid($authSID,$tokem) {
        
            $datacleint      = new Client($authSID, $tokem);
            $datacleint->accounts($authSID)->update(array(
                'status' => 'closed'
            )); //->fetch();
    }
    public function disable_user($clientID) {

            $signupData = $this->db->get_where('client', array('client_id' => $clientID))->row();
            $AdminAccountSid = $this->AdminAccountSid;
            $AdminAuthToken  = $this->AdminAuthToken;
            $datacleint      = new Client($AdminAccountSid, $AdminAuthToken);
            $datacleint->accounts($signupData->subaccount_sid)->update(array(
                'status' => 'closed'
            )); //->fetch();
    }

    public function twilio_bridge_call() {
        $callwho = $_GET['callwho'];

        header("content-type: text/xml");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo '<Response><Dial><Number>'.$callwho.'</Number></Dial></Response>';

    }

    public function ajax_get_pricing() {
        $promoc = $this->input->post('promo'); // twilio number

        $this->db->select('*');
        $this->db->from('ct_promos');
        $this->db->where(array(
            'promo_code' => $promoc
        ));

        $promo_dat = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('packages');
        $this->db->where(array(
            'status' => '1'
        ));
        $subsrs = $this->db->get()->result_array();
        $numsubs = (int) count( $subs);

        header('Content-Type:application/json');
        $resp = array();
        if(count($promo_dat)>0) {
            $promo = $promo_dat[0];
            if($promo['used_count']>=$promo['used_max']) {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Promo Code Expired!'
                );
            } else {
                $subs = array();
                $is=0;
                foreach($subsrs as $sr) {
                    $cjen = $sr['package_amount'];
                    if($promo['affect']==0) {
                        if($promo['is_percent']) {
                            $cjen = round($cjen - ($cjen*($promo['discount']/100)),2);
                        } else {
                            $cjen = round($cjen- $promo['discount'],2);
                        }

                    } else {
                        if($promo['affect']==$sr['package_id']) {

                            if($promo['is_percent']) {
                                $cjen = round($cjen - ($cjen*($promo['discount']/100)),2);
                            } else {
                                $cjen =  round($cjen- $promo['discount'],2);
                            }
                        }
                    }
                    $subs[$is]['pid'] = $sr['package_id'];
                    $subs[$is]['price'] = $cjen;
                    $is++;
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'All good!',
                    'updated' => ($subs)
                );

            }

        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Promo Code Not Found!'
            );

        }
        echo json_encode($resp);
    }

    private function auto_sms_reply($uid,$from_call,$to_call,$aumsg,$aufile,$autype) {

        if (! empty($uid)) {
            $rec_clientID =  $uid;
            $clientInfo = $this->db->get_where('client', array(
                'client_id' => $rec_clientID
            ))->row();

            $smsa_data['to'] = $to_call;
            $smsa_data['message']   = $aumsg;
            $smsa_data['from']      = $from_call;
            $smsa_data['date']      = date("Y-m-d");
            $smsa_data['time']      = date("H:i:s");
            $smsa_data['direction'] = 'out';
                $tamo[0]['mediaUrl'] = $aufile;
                $tamo[0]['mediaType']= $autype;
                $smsa_data['media_urls']        = serialize($tamo);
                $smsa_data['mms_num_files'] = 1;
            $insert_id = $this->_send_sms($smsa_data,$clientInfo);
            $newprint = array(
                'client_id' => $clientInfo->client_id,
                'phoneNumber' => $to_call,
                'action_to' => $from_call,
                'time' => time(),
                'is_printed' => '1',
                'to_print' => ''
            );

            $alreadyvCardSet = $this->db->get_where('ct_vcard_numbers', array(
                'client_id' => $clientInfo->client_id,
                'phoneNumber' => $to_call,
                'action_to' => $from_call
            ))->row();

            if(empty($alreadyvCardSet))
                $this->db->insert('ct_vcard_numbers', $newprint);
        }
    }


    private function auto_send_vcard($uid,$from_call,$to_call,$specmsg='') {


        if (! empty($uid)) {
            $rec_clientID =  $uid;
            $clientInfo = $this->db->get_where('client', array(
                'client_id' => $rec_clientID
            ))->row();

            $smsa_data['to'] = $to_call;
            $defmsg = 'Thanks for the call, attached is my contact card, please add me to your contacts.';
            $smsa_data['message']   = ($specmsg!='' ? $specmsg: $defmsg);
            $smsa_data['from']      = $from_call;
            $smsa_data['date']      = date("Y-m-d");
            $smsa_data['time']      = date("H:i:s");
            $smsa_data['direction'] = 'out';
            if(isset($clientInfo->vcard_url) && $clientInfo->vcard_url!='') {

                $tamo[0]['mediaUrl'] = $clientInfo->vcard_url;
                $tamo[0]['mediaType']= 'text/vcf';
                $smsa_data['media_urls']        = serialize($tamo);
                $smsa_data['mms_num_files'] = 1;
                $insert_id = $this->_send_sms($smsa_data,$clientInfo);
                $newprint = array(
                    'client_id' => $clientInfo->client_id,
                    'phoneNumber' => $to_call,
                    'action_to' => $from_call,
                    'time' => time(),
                    'is_printed' => '1',
                    'to_print' => ''
                ); 

                $alreadyPrinted = $this->db->get_where('ct_vcard_numbers', array(
                    'client_id' => $clientInfo->client_id,
                    'phoneNumber' => $to_call,
                    'action_to' => $from_call
                ))->row();

                if(empty($alreadyPrinted))
                    $this->db->insert('ct_vcard_numbers', $newprint);
                return true;
            }
            return false;
        }

    }

    public function ajax_send_vcard() {

        header('Content-Type:application/json');

        if (! empty($this->session->userdata('login_user_id'))) {
            $rec_clientID =  $this->session->userdata('login_user_id');
            $to_call = $this->input->post('number'); // twilio number
            $from_call = $this->input->post('from'); // twilio number

            $from_call = str_replace('-', '', $from_call);
            $from_call = str_replace(' ', '', $from_call);
            $from_call = str_replace('(', '', $from_call);
            $from_call = str_replace(')', '', $from_call);
            $from_call = '+1' . $from_call;

        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => $from_call,
            'status' => 'active'
        ))->row();
            $stanje = $this->auto_send_vcard($rec_clientID,$from_call,$to_call,$clientPhoneDetails->vcard_reply_text);
        
            
            if($stanje) {
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'vCard Sent Successfully!'
                ));
            } else {

                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Something went wrong!'
                ));
            }
        }

    }

    public function ajax_print_num() {

        header('Content-Type:application/json');

        if (! empty($this->session->userdata('login_user_id'))) {
        

            $rec_clientID =  $this->session->userdata('login_user_id');

            $from_call = $this->input->post('number'); // twilio number

            $clientFUNFDetails = $this->db->get_where('client', array(
                'client_id' => $rec_clientID
            ))->row();

            $this->load->library('restclient');
            $kada_updc = $clientFUNFDetails->chook_when;
            
                $kada_updc = $clientFUNFDetails->chook_when;
                $alreadyPrinted = $this->db->get_where('ct_printed_numbers', array(
                    'client_id' => $clientFUNFDetails->client_id,
                    'phoneNumber' => $from_call
                ))->row();

           // if( ($kada_updc+1800)>time()) {

                    /*$this->load->library('restclient');
                    $posj = new Restclient([
                        'base_url' => $clientFUNFDetails->chook_where
                    ]);
                    $arr = array(
                          "action_type" => "new-lookup-manual",
                          "action_to" => '',
                          "action_from" => $from_call,
                          "status" => "success",
                          "message" => "A new print request!"
                    );
                    $arr = array_merge($this->crud_model->getNumberDetails( $from_call ),$arr);
                    $posj->post('/',$arr);*/


                    if(empty($alreadyPrinted)) {
                        $newprint = array(
                            'client_id' => $clientFUNFDetails->client_id,
                            'phoneNumber' => $from_call,
                            'action_to' => '',
                            'time' => time(),
                            'is_printed'=> '0',
                            'to_print' => json_encode($this->crud_model->getNumberDetails( $from_call ))
                        );
                        $this->db->insert('ct_printed_numbers', $newprint);
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => 'Label Print request send!'
                        ));

                    } else {
                        if( empty($alreadyPrinted->to_print) )
                            $topr = json_encode($this->crud_model->getNumberDetails( $from_call ));
                        else 
                            $topr = $alreadyPrinted->to_print;

                        $updated   = $this->db->update('ct_printed_numbers', array(
                            'time' => time(), 
                            'is_printed' => '0',
                            'to_print' => $topr
                        ), array(
                            'client_id' => $clientFUNFDetails->client_id,
                            'phoneNumber' => $from_call
                        ));

                        echo json_encode(array(
                            'status' => 'success',
                            'message' => 'Label Print request re-send!'
                        ));

                    }
                    /*
                } else {
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Desktop Client not connected!'
                    ));

                }*/

        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Login session timed out!'
            ));
        }
    }
/*
    public function test_callit() {

            $clientDetails     = $this->db->get_where('client', array(
                'client_id' => $this->session->userdata('login_user_id')
            ))->row();
            $subAccountSid = $clientDetails->subaccount_sid;

            $AccountSid = $this->AdminAccountSid;
            $AuthToken  = $this->AdminAuthToken;

            $client = new Client($AccountSid, $AuthToken);
            $account = $client->accounts($subAccountSid)->fetch();

            $call = $account->calls->create(
               '+38762491268','+13107766944'
            );
    }*/

    public function ajax_bridge_call() {
        $from = $this->input->post('from'); // twilio number
        $to = $this->input->post('to'); //callog number
        $caller = $this->input->post('caller'); // who to call

            $clientDetails     = $this->db->get_where('client', array(
                'client_id' => $this->session->userdata('login_user_id')
            ))->row();
            $subAccountSid = $clientDetails->subaccount_sid;

        try {
            $AccountSid = $this->AdminAccountSid;
            $AuthToken  = $this->AdminAuthToken;

            $client = new Client($AccountSid, $AuthToken);
            $account = $client->accounts($subAccountSid)->fetch();

            $call = $account->calls->create(
               $caller, $from, 
                array("url" => "https://callertech.com/base/twilio_bridge_call?callwho=".urlencode($to) )
            );


            header('Content-Type:application/json');
            if($call->sid) {
                echo json_encode(array(
                    'status' => 'success'
                ));
            } else {

                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Could not start call!'
                ));
            }
        }
        catch (Exception $e) {
            echo json_encode(array(
                    'status' => 'error',
                    'message' => 'System Says: '.$e->getMessage()
                ));
        }
    }
    
    
    public function lookup_number_calllog()
    {
        
        if (empty($this->session->userdata('login_user_id'))) {
            redirect(base_url('login'));
        }
        $clientDetails     = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();
        $clientFUNFDetails = $this->db->get_where('client', array(
            'client_id' => $clientDetails->client_id
        ))->row();
        
        $charges = $this->crud_model->fetch_package_pricing($clientDetails->subscription_id);
        
        $cost = $charges['lookup_call_charge'];
        $user = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        
        if ($user[0]['send_custom_audience'] == 1) {
            $costToSocialMedia = $charges['p_social_med_adv'];
        } else {
            $costToSocialMedia = 0;
        }

        $account_balance = $this->get_balance($clientFUNFDetails->client_id);
        
        if($charges['is_subscription'] == 1 ) {
            $srvc_received = $this->crud_model->get_subs_count($clientFUNFDetails->client_id,'max_call_lookup');
            $max_call_lookup = $charges['max_call_lookup'];
            $hasBalance = ($srvc_received < $max_call_lookup);
            if ( !$hasBalance ) {
                $this->session->set_flashdata('used_points', 'true');
                redirect(base_url() . 'clientuser/account_subscription', 'refresh');
                die();
            }
        
        }
        else {
            $hasBalance = (bool)  $account_balance > ((float) $cost + (float) $costToSocialMedia);
            if ( !$hasBalance ) {
                $this->session->set_flashdata('not_fund', 'true');
                redirect(base_url() . 'clientuser/number_lookup', 'refresh');
                die();
            }
        
        }

        $AccountSid = $this->AdminAccountSid;
        $AuthToken  = $this->AdminAuthToken;
        
        $testing = $this->input->post('pur_number');
        
        $this->db->select('cl.*,cl_ph.*');
        $this->db->from('client cl');
        $this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
        $this->db->where(array(
            'cl.client_id' => $this->session->userdata('login_user_id'),
            'cl_ph.status' => 'active'
        ));
        if (!empty($testing))
            $this->db->where(array(
                'cl_ph.phoneNumber' => $testing
            ));
        $query          = $this->db->get();
        $clientdetails2 = $query->row();
        
        $client = new Client($AccountSid, $AuthToken);
        if (isset($_GET['phonenumber']))
            $from_call = $_GET['phonenumber'];
        else
            $from_call = $this->input->post('phonenumber');
        
        $from_call = str_replace('-', '', $from_call);
        $from_call = str_replace(' ', '', $from_call);
        $from_call = str_replace('(', '', $from_call);
        $from_call = str_replace(')', '', $from_call);
        $from_call = '+1' . $from_call;
        
        
        $advanceCalFetched = $this->db->get_where('advanced_caller_details', array(
            'phoneNumber' => $from_call
        ))->row();
        
        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => $clientdetails2->phoneNumber,
            'status' => 'active'
        ))->row();
        $eg_uinfo_newinst   = false;
        $repeated           = false;
        
        if ($hasBalance) {
            if ((empty($advanceCalFetched))) { // new number
                
                $this->load->helper('twilio_handlers');
                /* get caller details from Twilio and add into DB */
                $caller_details = ct_get_phone_details($from_call, $client, $charges['lookup_call_charge'], $clientFUNFDetails);
                if ($caller_details['is_error'] !== false) {
                    $this->session->set_flashdata('flash_message', 'Error with lookup!');
                    redirect(base_url() . 'clientuser/number_lookup', 'refresh');
                    die();

                    //$this->_response_console(array(), '404', 'Twilio Message: ' . $caller_details['is_error']);
                } else {
                    $eg_newcaller = true;
                }
            } else { // old number
                if($charges['is_subscription'] == 1 ) {
                    $this->crud_model->update_subs_count($clientFUNFDetails->client_id,'max_call_lookup');
                }
            }
            $InsertData123 = array(
                'client_id' => $this->session->userdata('login_user_id'),
                'phonenumber' => $from_call,
                'date_added' => date('Y-m-d H:i:s'),
                'location' => 'manual'
            );
            $this->db->insert('caller_look_up', $InsertData123);

            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($clientFUNFDetails->client_id,'max_social_ad');
                $max_social_ad = $charges['max_social_ad'];
                $hasBalance = ($srvc_received < $max_social_ad);
            }
            else {
                $hasBalance = true; 
            }

            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased');
            $this->db->where(array(
                'client_id' => $this->session->userdata('login_user_id'),
                'status' => 'active',
            ));
            $phoneNumbers = $this->db->get()->result_array();

            /* DISABLE MESSAGES FOR ALL PHONE NUMBERS */
            if ($clientFUNFDetails->send_custom_audience && $hasBalance) {
              
                $user = $this->db->get_where('client', array(
                    'client_id' => $this->session->userdata('login_user_id')
                ))->result_array();
                $calls_read = $this->db->get_where('advanced_caller_details', array(
                    'phoneNumber' => $from_call
                ))->result_array();

                foreach ($phoneNumbers as $ph) {  
                    
                    if($ph['custom_audience_id']!='')
                    $rez = $this->update_cust_audience($calls_read,$user[0]['accesstoken'],$ph['custom_audience_id']);


                    //execute post
                    $result = $rez;
                    
                    $result_decoded = json_decode($result);
                    
                    //die(var_dump($result_decoded->error->code));
                    
                    if (!$user[0]['adaccount']) {
                        $this->session->set_flashdata('error', "Error while adding number to custom audience, there is no Ad Account set. Please make sure you have an Ad Account set.");
                    }
                    if ($result_decoded->error->code == 190) {
                        $this->session->set_flashdata('error', "Error while adding number to custom audience, invalid access token. Please make sure you're logged on facebook.");
                        $client_id = $this->session->userdata('login_user_id');
                        $updated   = $this->db->update('client', array(
                            'accesstoken' => NULL
                        ), array(
                            'client_id' => $this->session->userdata('login_user_id')
                        ));
                    }
                    
                    if ($result_decoded->num_received) {
                        //Updating client available Funds
                        $account_balance = $this->get_balance();
                        if($charges['is_subscription'] == 1 ) {
                            $srvc_received = $this->crud_model->update_subs_count($this->session->userdata('login_user_id'),'max_social_ad');
                        } else {
                            /* UPDATE BALANCE */
                        }
                        //$this->session->set_flashdata('flash_message', 'Number added successfully to lookup!');
                        
                    }
                }
            }
            

            /* contact client */ 

/*
                    $alreadyPrintedSet = $this->db->get_where('ct_printed_numbers', array(
                        'client_id' => $clientFUNFDetails->client_id,
                        'phoneNumber' => $from_call,
                    ))->row();
                    if(empty($alreadyPrintedSet)) {
                        $newprint = array(
                        'client_id' => $clientFUNFDetails->client_id,
                        'phoneNumber' => $from_call,
                            'time' => time(),
                            'is_printed' => '0',
                            'to_print' => json_encode($this->crud_model->getNumberDetails( $from_call ))
                        );
                        $this->db->insert('ct_printed_numbers', $newprint);

                     }
*/
        }


        
        $this->session->set_flashdata('flash_message', 'Number looked up successfully!');

        redirect(base_url() . 'clientuser/number_lookup', 'refresh');
    }
    
    public function lookup_number_calllog_home()
    {
        
        $AccountSid = $this->AdminAccountSid;
        $AuthToken  = $this->AdminAuthToken;
        
        $client = new Client($AccountSid, $AuthToken);
        
        $from_call = $this->input->post('phonenumber');
        $from_call = str_replace('-', '', $from_call);
        $from_call = str_replace(' ', '', $from_call);
        $from_call = str_replace('(', '', $from_call);
        $from_call = str_replace(')', '', $from_call);
        $from_call = '+1' . $from_call;
        
        
        $advanceCalFetched = $this->db->get_where('advanced_caller_details', array(
            'phoneNumber' => $from_call
        ))->row();
        
        if (empty($advanceCalFetched)) {
            
            $this->load->helper('twilio_handlers');
            /* get caller details from Twilio and add into DB */
            /* lookup home */
            $lookup_data = ct_get_phone_details($from_call, $client);
            if ($lookup_data['is_error'] !== false) {
                $home_lookup_ip = array(
                    'from_call' => $from_call,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'message' => $lookup_data['is_error'],
                    'advanced_caller_id' => 0
                );
                $this->db->insert('home_lookup_ip', $home_lookup_ip);
                
                echo '<div class="row home_page_lookup">     <div class="main-table-div"><div class="full-set">Your Caller Technologies Report for ' . $from_call . '</div><div class="primary-table-warning" ><label class="full-label-warning">' . $caller_details['is_error'] . '</label></div></div></div>';
                
                die();
            }
            
            $home_lookup_ip = array(
                'from_call' => $from_call,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'message' => 'Number looked up successfully!',
                'advanced_caller_id' => 1
            );
            $this->db->insert('home_lookup_ip', $home_lookup_ip);
            /*$lookup_data = $this->db->get_where('advanced_caller_details', array('phoneNumber' => $phoneNumber,'first_name !=' => ''))->row();*/
        } else {
            $home_lookup_ip = array(
                'from_call' => $advanceCalFetched->phoneNumber,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'message' => 'Number looked up successfully!',
                'advanced_caller_id' => 1
            );
            $this->db->insert('home_lookup_ip', $home_lookup_ip);
            $lookup_data = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $advanceCalFetched->phoneNumber,
                'first_name !=' => ''
            ))->row();
        }
        $clID = $this->session->userdata('login_user_id');
        if (empty($clID))
            $clID = 0;
        $InsertData123 = array(
            'client_id' => $clID,
            'phonenumber' => $from_call,
            'date_added' => date('Y-m-d H:i:s'),
            'location' => 'home'
        );
        $this->db->insert('caller_look_up', $InsertData123);
        
        echo '1';
        die();
    }

    public function testapi_cust_audience() {
           $calls_reade = $this->db->get_where('advanced_caller_details', array(
                'caller_id<' => 710,
                'caller_id>' => 10,
                'first_name!=' => '',
                'linked_emails!=' => ''
            ))->result_array();
/*            $calls_read2 = array_slice($calls_read,150,300);
            $calls_read3 = array_slice($calls_read,300,450);*/


        $user   = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();

        for($i=0;$i<300;$i=$i++) {
            $calls_read = array_slice($calls_reade,$i,$i+1);
            $this->update_cust_audience($calls_read,$user[0]['accesstoken'],'23842656795910378');
        }
           /* $this->update_cust_audience($calls_read,$user[0]['accesstoken'],'23842657448600378');
            $this->update_cust_audience($calls_read,$user[0]['accesstoken'],'23842656795910378');

            $this->update_cust_audience($calls_read2,$user[0]['accesstoken'],'23842656796450378');
            $this->update_cust_audience($calls_read2,$user[0]['accesstoken'],'23842657448600378');
            $this->update_cust_audience($calls_read2,$user[0]['accesstoken'],'23842656795910378');

            $this->update_cust_audience($calls_read3,$user[0]['accesstoken'],'23842656796450378');
            $this->update_cust_audience($calls_read3,$user[0]['accesstoken'],'23842657448600378');
            $this->update_cust_audience($calls_read3,$user[0]['accesstoken'],'23842656795910378');*/

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
  
    public function lookup_incoming_calls()
    {
        $calls_read = $this->db->get_where('advanced_caller_details', array(
            'flag_custom_audience' => null
        ))->result_array();
        $schema     = '';
        
        
        $user   = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->result_array();

        $rez = $this->update_cust_audience($calls_read,$user[0]['accesstoken'],$user[0]['custom_audience_id']);

        $result = $rez;
        if (json_decode($result)->num_received) {
            $this->db->update('advanced_caller_details', array(
                'flag_custom_audience' => true
            ), array(
                'caller_id' => $c['caller_id']
            ));
            
        }
    }

    
    /* ------------------------
    SMS Handling 
    */
    public function send_sms()
    {
        
        $send_bulk              = $_REQUEST['bulk'] ? $_REQUEST['bulk'] : false;
        $send_bulk_group              = $_REQUEST['groupid'] ? $_REQUEST['groupid'] : false;

        $sms_data['message']   = $_REQUEST['msg'] ? $_REQUEST['msg'] : '';
        $sms_data['from']      = $_REQUEST['from'] ? $_REQUEST['from'] : '';
        $sms_data['to']        = $_REQUEST['to'] ? $_REQUEST['to'] : '';
        $sms_data['date']      = date("Y-m-d");
        $sms_data['time']      = date("H:i:s");
        $sms_data['direction'] = 'out';
        if(isset($_REQUEST['fileNewName'])) {
            $media_urls[0]['mediaUrl'] = base_url().'uploads/mms/'.$_REQUEST['fileNewName'];
            $media_urls[0]['mediaType'] = $_REQUEST['fileType'];
            $sms_data['media_urls'] = $media_urls;
        } else {
            $sms_data['media_urls'] = false;
        }

        if(isset($_POST['americanize'])) {
            
          /*  $from_call = str_replace('-', '', $sms_data['from']);
            $from_call = str_replace(' ', '', $from_call);
            $from_call = str_replace('(', '', $from_call);
            $from_call = str_replace(')', '', $from_call);
            $sms_data['from'] = '+1' . $from_call;*/


            $from_call = str_replace('-', '', $sms_data['to']);
            $from_call = str_replace(' ', '', $from_call);
            $from_call = str_replace('(', '', $from_call);
            $from_call = str_replace(')', '', $from_call);
            $sms_data['to'] = '+1' . $from_call;
        }
        
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        if($send_bulk) {
            $bulksms_list = $this->bulktext->get_list_optinonly($send_bulk_group);
            foreach($bulksms_list as $tosms) {
                $this->bulktext->update_count($tosms->id,$tosms->sent_count);
                $sms_data['to'] = $tosms->user_number;
                $insert_id = $this->_send_sms($sms_data);
            }
        } else
            $insert_id = $this->_send_sms($sms_data);
        
        if(isset($_POST['ajax'])) {
            header('Content-Type:application/json');
            if (isset($insert_id) && $insert_id)
                $response['status'] = 'success';
            else
                $response['status'] = 'error';
            echo json_encode($response);
            die();
        }
        if (isset($insert_id) && $insert_id)
            redirect(base_url() . 'clientuser/view_sms/' . $sms_data['from'] . '/out?latest', 'refresh');
        else
            redirect(base_url() . 'clientuser/view_sms', 'refresh');
    }
    public function incomingSMSRequest()
    {
        
        $sms_data['sms_sid']   = $_REQUEST['MessageSid'] ? $_REQUEST['MessageSid'] : '';
        $sms_data['message']   = $_REQUEST['Body'] ? $_REQUEST['Body'] : '';
        $sms_data['from']      = $_REQUEST['From'] ? $_REQUEST['From'] : '';
        $sms_data['to']        = $_REQUEST['To'] ? $_REQUEST['To'] : '';
        $sms_data['mms_num_files']   = (int) $_REQUEST['NumMedia'] ? $_REQUEST['NumMedia'] : '';
        if($sms_data['mms_num_files']>0) {
            for($i=0;$i<$sms_data['mms_num_files'];$i++) {
                $tamo[$i]['mediaUrl'] = $_REQUEST['MediaUrl'.$i];
                $tamo[$i]['mediaType']= $_REQUEST['MediaContentType'.$i];
            }
            $sms_data['media_urls']        = serialize($tamo);
        } else {
            $sms_data['mms_num_files'] = 0;
        }

        $sms_data['date']      = date("Y-m-d");
        $sms_data['time']      = date("H:i:s");
        $sms_data['direction'] = 'in';
        
        $sms_numMedia = $_REQUEST['NumMedia'] ? $_REQUEST['NumMedia'] : '';
        if ($sms_numMedia > 0) {
            // It is an MMS  
            // add for loop to implement this 
        }
        
        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => $sms_data['to'],
            'status' => 'active',
        ))->row_array();
        $rec_clientID       = (int) $clientPhoneDetails['client_id'];
        if (empty($rec_clientID)) // No user in the DB found
            $this->_response_console(array(), '404', 'No user with that Phone Number in the Database ');
        
        
        $this->load->helper('twilio_handlers');
        $advanceCalFetched = $this->db->get_where('advanced_caller_details', array(
            'phoneNumber' => $sms_data['from']
        ))->row();
        
        $clientFUNFDetails = $this->db->get_where('client', array(
            'client_id' => $rec_clientID
        ))->row();
        
        $charges = $this->crud_model->fetch_package_pricing($clientFUNFDetails->subscription_id);
        
        $sms_data['client_id'] = $rec_clientID;
        if( !empty($sms_data['message']) )
            $this->db->insert('ct_messages', $sms_data);
        @$insert_id = $this->db->insert_id();
        
        $subAccountSid = $clientFUNFDetails->subaccount_sid;
        $client        = new Client($clientFUNFDetails->subaccount_sid, $clientFUNFDetails->auth_token);
        // Use SubAccount Lookup

        $smsa_data = [];
        if( !empty($clientPhoneDetails['sms_forward_no']) ) {
            $from_call = $clientPhoneDetails['sms_forward_no'];
            $from_call = str_replace('-', '', $from_call);
            $from_call = str_replace(' ', '', $from_call);
            $from_call = str_replace('(', '', $from_call);
            $from_call = str_replace(')', '', $from_call);
            $from_call = '+1' . $from_call;

            $smsa_data['to'] = $from_call;
            $smsa_data['message']   = 'FW: '.ct_format_nice_number($sms_data['from']) .' - '.$sms_data['message'];
            $smsa_data['from']      = $sms_data['to'];
            $smsa_data['date']      = date("Y-m-d");
            $smsa_data['time']      = date("H:i:s");
            $smsa_data['direction'] = 'out';
            $smsa_data['mms_num_files'] = $sms_data['mms_num_files'];
            if($smsa_data['mms_num_files']>0) {
                for($i=0;$i<$smsa_data['mms_num_files'];$i++) {
                    $tamo[$i]['mediaUrl'] = $_REQUEST['MediaUrl'.$i];
                    $tamo[$i]['mediaType']= $_REQUEST['MediaContentType'.$i];
                }
                $smsa_data['media_urls']        = serialize($tamo);
            } else {
                $smsa_data['mms_num_files'] = 0;
            }
            $this->_send_sms($smsa_data,$clientFUNFDetails);
        }
        $account_balance = $this->get_balance($clientFUNFDetails->client_id);


        if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($clientFUNFDetails->client_id,'max_received_sms');
                $max_sms_received = $charges['max_received_sms'];
                $hasBalance = ($srvc_received < $max_sms_received);
        }
        else {
            $hasBalance = ($account_balance > $charges['sms_charge']);
        }

        if (($hasBalance)) {

            if(empty($advanceCalFetched)) {
                
                /* get caller details from Twilio and add into DB */
                $caller_details = ct_get_phone_details($sms_data['from'], $client, $charges['lookup_call_charge'], $clientFUNFDetails);

                if ($caller_details['is_error'] !== false) {
                    $this->_response_console(array(), '404', 'Twilio Message: ' . $caller_details['is_error']);
                } else {

                    $this->_response_console($sms_data, 'success', "Number Looked Up and MSG saved with ID: " . $insert_id);
                }
            }

                $newlookup = array(
                    'client_id' => $clientFUNFDetails->client_id,
                    'phonenumber' => $sms_data['from'],
                    'from' => $sms_data['to'],
                    'date_added' => date('Y-m-d H:i:s'),
                    'location' => 'incoming-sms'
                );
                $this->db->insert('caller_look_up', $newlookup);

                $page_data['lookup_data'] = $this->db->get_where('advanced_caller_details', array(
                    'phoneNumber' => $sms_data['from']
                ))->row(); 
                $this->load->helper('twilio_handlers');

                /* SEND EMAIL ON LOOKUP */
                $system_email = $this->system_noreplymail;
                $system_title = $this->system_title;
                $emsg = ct_get_email_details($page_data,$clientFUNFDetails->timezone);

                $this->email->set_mailtype("html");
                $prev_msg = '<div class="row" align="center">
                <h3 style="font-size: 19px!important;" align="center"> You have a new Text from ' . ct_format_nice_number( $sms_data['from']).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']).'' .'</h3>
                <hr style="margin:5px;">
                <p style="font-size: 19px!important;" align="center">
                    Text message : '.$sms_data['message'].'
                </p>
                </div>';
                $this->email->from($system_email, $system_title);
                $this->email->to($clientFUNFDetails->email);
                $this->email->subject('New Text from '.ct_format_nice_number($sms_data['from']).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']).'' );
                $page_data['main_content'] = $prev_msg.$emsg;
                $e_msg = $this->load->view('email/details', $page_data, true);
                $this->email->message($e_msg);
                if($clientPhoneDetails['flag_mailnotif_sms'] && $clientFUNFDetails->email_verified=='1')
                    {
                        $this->email->send();
                        $this->email->clear();

                        /*Send mail to alternative email*/
                        if($clientFUNFDetails->second_email){
                            $this->email->set_mailtype("html");
                            $this->email->from($system_email, $system_title);
                            $this->email->to($clientFUNFDetails->second_email);
                            $this->email->subject('New Text from '.ct_format_nice_number($sms_data['from']).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']).'' );
                            $this->email->message($e_msg);
                            $this->email->send();
                            $this->email->clear();
                        }
                    }
               

             if($charges['is_subscription'] == 1 ) {
                 // Update +1 max_received_sms

                if($sms_data['media_urls'] != false) {
                     $this->crud_model->update_subs_count($clientFUNFDetails->client_id,'max_received_mms');
                     $max_mms_received = $max_mms_received+1;
                 } else {
                     $this->crud_model->update_subs_count($clientFUNFDetails->client_id,'max_received_sms');
                     $max_sms_received = $max_sms_received+1;
                 }
             } else {
                $insert_data_pay = array();
                //Adding the cost to the payment history
               /* $insert_data_pay['client_id']            = $rec_clientID;
                $insert_data_pay['payment_gross_amount'] = -(float) $charges['sms_charge'];
                $insert_data_pay['plan_name']            = 'payment_against_sms_charge';
                $insert_data_pay['payment_date']         = date("Y-m-d");
                $insert_data_pay['payment_time']         = date("H:i:s");
                $insert_data_pay['pay_meta']  = 'from='. $sms_data['from'] . '|to=' . $sms_data['to'].'|sms_id='.$sms_data['sms_sid'];
                $this->db->insert('client_payment_details', $insert_data_pay);
                */

                /* UPDATE BALANCE */
               /* $account_balance = ($account_balance - (float)$charges['sms_charge']);
                $cleint_Data['available_fund'] = $account_balance;
                $this->db->where('client_id', $rec_clientID);
                $this->db->update('client', $cleint_Data);*/
                /* UPDATE BALANCE */
            }

                $alreadyvCardSet = $this->db->get_where('ct_vcard_numbers', array(
                    'client_id' => $clientFUNFDetails->client_id,
                    'phoneNumber' => $sms_data['from'],
                    'action_to' => $sms_data['to'],
                ))->row();
                    if($clientPhoneDetails['flag_auto_sms'])
                        $this->auto_sms_reply($clientFUNFDetails->client_id,$sms_data['to'],$sms_data['from'],$clientPhoneDetails['auto_sms_reply'],$clientPhoneDetails['auto_sms_file'],$clientPhoneDetails['auto_sms_type']);
                
                if(empty($alreadyvCardSet)) {
                    if($clientPhoneDetails['auto_vcard'])
                    $this->auto_send_vcard($clientFUNFDetails->client_id,$sms_data['to'],$sms_data['from'],$clientPhoneDetails['vcard_reply_text']);
                    }


                    $alreadyPrintedSet = $this->db->get_where('ct_printed_numbers', array(
                        'client_id' => $clientFUNFDetails->client_id,
                        'phoneNumber' => $sms_data['from'],
                    ))->row();
                    if(empty($alreadyPrintedSet)) {
                        $newprint = array(
                            'client_id' => $clientFUNFDetails->client_id,
                            'phoneNumber' => $sms_data['from'],
                            'action_to' => $sms_data['to'],
                            'time' => time(),
                            'is_printed' => '0',
                            'to_print' => json_encode($this->crud_model->getNumberDetails( $sms_data['from'] ))
                        );
                        $this->db->insert('ct_printed_numbers', $newprint);
                    }
    
                /* Disable SMS/MMS Receival if full */
                $srvc_mess_received = 0;
                if($sms_data['media_urls'] != false) {
                    $srvc_mess_received = $this->crud_model->get_subs_count($rec_clientID,'max_received_mms');
                } else {
                    $srvc_mess_received = $this->crud_model->get_subs_count($rec_clientID,'max_received_sms');
                }
                if ($srvc_mess_received>=$charges['max_received_sms']) {
                    // TODO: disable Messages for this client      
                    $clientdetails = $this->db->get_where('client', array(
                        'client_id' => $rec_clientID
                    ))->row();  


                    $api = new Restclient([
                        'base_url' => "https://api.twilio.com", 
                        'username' => $this->AdminAccountSid, //$client->subaccount_sid, 
                        'password' => $this->AdminAuthToken
                    ]);

                    $this->db->select('*');
                    $this->db->from('client_phonenumber_purchased ');
                    $this->db->where(array(
                        'client_id' => $clientdetails->client_id,
                        'status' => 'active',
                    ));
                    $phoneNumbers = $this->db->get()->result_array();


                    /* DISABLE MESSAGES FOR ALL PHONE NUMBERS */
                    foreach ($phoneNumbers as $ph) {
                        $api->post('/2010-04-01/Accounts/'.$clientdetails->subaccount_sid.'/IncomingPhoneNumbers/'.$ph['phoneSid'].'.json',array('SmsUrl'=>''));
                    }
                    $cleint_Data['messages_disabled'] = '1';
                    $this->db->where('client_id', $rec_clientID);
                    $this->db->update('client', $cleint_Data);
                }

            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($clientFUNFDetails->client_id,'max_social_ad');
                $max_social_ad = $charges['max_social_ad'];
                $hasBalance = ($srvc_received < $max_social_ad);
            }
            else {
                $hasBalance = true; 
            }
            
            if ($clientDetails->send_custom_audience && $hasBalance) {
                
                # code...
                $calls_read = $this->db->get_where('advanced_caller_details', array(
                    'phoneNumber' => $sms_data['from']
                ))->result_array();
                
                $user = $this->db->get_where('client', array(
                    'client_id' => $clientFUNFDetails->client_id
                ))->result_array();
                
                $rez = $this->update_cust_audience($calls_read,$user[0]['accesstoken'],$clientPhoneDetails['custom_audience_id']);


                //execute post
                $result = $rez;
                
                $result_decoded = json_decode($result);
                
                if ($result_decoded->num_received) {
                    //Updating client available Funds
                    $account_balance = $this->get_balance();
                    if($charges['is_subscription'] == 1 ) {
                        $srvc_received = $this->crud_model->update_subs_count($clientFUNFDetails->client_id,'max_social_ad');
                    } else {

                    }
                    
                }
            }

        } else { 
            if(!$hasBalance) {
                $this->_response_console($sms_data, 'success', "Messaged saved with ID: " . $insert_id);
            } else $this->_response_console($sms_data, 'success', "Messaged saved with ID: " . $insert_id);
        }
        
    }
    /* ------------------------
    // -- SMS Handling - END
    */

    public function call_voicemail($cphoner) {

            $cphone = urldecode($cphoner);
            $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
                'phoneNumber' => trim($cphone),
                'status' => 'active'
            ))->row();
            if(!empty($clientPhoneDetails)) {
                $voicemailtext = $clientPhoneDetails->voicetext;
                $voicemailurl = $clientPhoneDetails->voicename_url!='' ? $clientPhoneDetails->voicename_url : false;
                /*if(!$voicemailurl)
                    $this->load->view('base/call_hangup', array(
                        'request' => $_REQUEST
                    ));*/

                $this->load->view('base/call_voicemail', array(
                    'request' => $_REQUEST,
                    'voicemailtext' => $voicemailtext,
                    'voicemailurl' => $voicemailurl,
                    'clid' => $clientPhoneDetails->client_id,
                    'cphone' => $cphone
                ));    
            } else {
                $this->load->view('base/call_hangup', array(
                    'request' => $_REQUEST
                ));
            }
    }
    
    public function call_roundrobin($cidr,$cphoner,$phoneRobr,$robW) {
        $_REQUEST['DialCallStatus'] = 'no-answer';
        if($_REQUEST['DialCallStatus']=='busy' || $_REQUEST['DialCallStatus']=='no-answer') {

            $cid = urldecode($cidr);
            $cphone = urldecode($cphoner);
            $phoneRob = urldecode($phoneRobr);
            
            $clientDetails  = $this->db->get_where('client', array(
                'client_id' => $cid
            ))->row();

            $charges = $this->crud_model->fetch_package_pricing($clientDetails->subscription_id);
            $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
                'phoneNumber' => trim($cphone),
                'status' => 'active'
            ))->row_array();

            if($charges['is_subscription'] == 1 ) { // count record == count transcribe
                $srvc_received = $this->crud_model->get_subs_count($clientDetails->client_id,'max_call_transcripts');
                $max_call_transcripts = $charges['max_call_transcripts'];
                $hasBalance = ($srvc_received < $max_call_transcripts);
            } else {
                $hasBalance = (bool) $account_balance > (float) ($cost + $costToTranscr);
            }

            $flag_record_calls     = $hasBalance ? $clientDetails->flag_transcribe_call : '';
            $flag_transcribe_call  = $clientDetails->flag_transcribe_call;
            $multi_timeout          = intval($clientPhoneDetails['multi_timeout']);
            $voice_timeout          = intval($clientPhoneDetails['voice_timeout']);

            $multi_forw = $clientPhoneDetails['multi_forward'];

            if($multi_timeout>0) {
                $pozv_list = explode("," , $multi_forw);
                $koji = 0;
                $i=0;
                foreach($pozv_list as $k=>$poz) {
                    if($i==$robW)
                        $koji = $i+1;
                    $i++;
                }
                if(count($pozv_list)>=$koji) {
	                $next_robin = $pozv_list[$koji];

		            $call_forward_no_clean = str_replace(array(
		                '(',
		                ')',
		                '-',
		                ' '
		            ), '', $phoneRob);

                    $hasVoicemail = $clientPhoneDetails['voice_on'] == 0 ? false : true;

                    $this->load->view('base/call_request_round_robin', array(
                        'request' => $_REQUEST,
                        'call_forward_no_clean' => $call_forward_no_clean,
                        'call_forward_no' => $phoneRob,
                        'hasVoicemail' => $hasVoicemail,
                        'called_who' => $clientPhoneDetails['phoneNumber'],
                        'flag_record_calls' => $flag_record_calls,
                        'flag_transcribe_call' => $flag_transcribe_call,
                        'multi_forw' => $multi_forw,
                        'voice_timeout' => $voice_timeout,
                        'multi_timeout' => $multi_timeout,
                        'whichRobin' => $koji,
                        'next_robin' => $next_robin,
                        'clid' => $cid,
                        'cnum' => $cphone
                    ));

                } else {
                    $this->load->view('base/call_hangup', array(
                        'request' => $_REQUEST
                    ));
                }

            } else {

                    $this->load->view('base/call_hangup', array(
                        'request' => $_REQUEST
                    ));
            }
        } else {

            $this->load->view('base/call_hangup', array(
                'request' => $_REQUEST
            ));
        }
    }

    public function incomingCallRequest()
    {
        $insert_data = array(); 
        $insert_data['Called']         = $_REQUEST['Called'] ? $_REQUEST['Called'] : '';
        $insert_data['ToState']        = $_REQUEST['ToState'] ? $_REQUEST['ToState'] : '';
        $insert_data['CallerCountry']  = $_REQUEST['CallerCountry'] ? $_REQUEST['CallerCountry'] : '';
        $insert_data['Direction']      = $_REQUEST['Direction'] ? $_REQUEST['Direction'] : '';
        $insert_data['CallerState']    = $_REQUEST['CallerState'] ? $_REQUEST['CallerState'] : '';
        $insert_data['ToZip']          = $_REQUEST['ToZip'] ? $_REQUEST['ToZip'] : '';
        $insert_data['CallSid']        = $_REQUEST['CallSid'] ? $_REQUEST['CallSid'] : '';
        $to_call_num = $insert_data['To_call']        = $_REQUEST['To'] ? $_REQUEST['To'] : '';
        $insert_data['CallerZip']      = $_REQUEST['CallerZip'] ? $_REQUEST['CallerZip'] : '';
        $insert_data['ToCountry']      = $_REQUEST['ToCountry'] ? $_REQUEST['ToCountry'] : '';
        $insert_data['ApiVersion']     = $_REQUEST['ApiVersion'] ? $_REQUEST['ApiVersion'] : '';
        $insert_data['CalledZip']      = $_REQUEST['CalledZip'] ? $_REQUEST['CalledZip'] : '';
        $insert_data['CalledCity']     = $_REQUEST['CalledCity'] ? $_REQUEST['CalledCity'] : '';
        $insert_data['CallStatus']     = $_REQUEST['CallStatus'] ? $_REQUEST['CallStatus'] : '';
        $insert_data['From_call']      = $_REQUEST['From'] ? $_REQUEST['From'] : '';
        $insert_data['AccountSid']     = $_REQUEST['AccountSid'] ? $_REQUEST['AccountSid'] : '';
        $insert_data['CalledCountry']  = $_REQUEST['CalledCountry'] ? $_REQUEST['CalledCountry'] : '';
        $insert_data['CallerCity']     = $_REQUEST['CallerCity'] ? $_REQUEST['CallerCity'] : '';
        $insert_data['ApplicationSid'] = $_REQUEST['ApplicationSid'] ? $_REQUEST['ApplicationSid'] : '';
        $insert_data['Caller']         = $_REQUEST['Caller'] ? $_REQUEST['Caller'] : '';
        $insert_data['FromCountry']    = $_REQUEST['FromCountry'] ? $_REQUEST['FromCountry'] : '';
        $insert_data['ToCity']         = $_REQUEST['ToCity'] ? $_REQUEST['ToCity'] : '';
        $insert_data['FromCity']       = $_REQUEST['FromCity'] ? $_REQUEST['FromCity'] : '';
        $insert_data['CalledState']    = $_REQUEST['CalledState'] ? $_REQUEST['CalledState'] : '';
        $insert_data['FromZip']        = $_REQUEST['FromZip'] ? $_REQUEST['FromZip'] : '';
        $insert_data['FromState']      = $_REQUEST['FromState'] ? $_REQUEST['FromState'] : '';
        $insert_data['call_time']      = date("d-m-Y h:i:sa");
        
        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => trim($insert_data['To_call']),
            'status' => 'active'
        ))->row_array();
        $mainClientDetails  = $clientPhoneDetails['client_id'];
        
        $client_Details = $this->db->where('client_id', $mainClientDetails)->get('client')->result_array();
        $clientDetails  = $this->db->get_where('client', array(
            'client_id' => $mainClientDetails
        ))->row();
        /* UPDATE BALANCE */
        $account_balance = $this->get_balance($mainClientDetails);
        $call_charge = 0;
        $charges     = $this->crud_model->fetch_package_pricing($client_Details[0]['subscription_id']);
        $call_charge = $charges['call_charge'];

        if($charges['is_subscription'] == 1 ) {
            $srvc_received = $this->crud_model->get_subs_count($mainClientDetails,'max_call_in');
            $max_call_in = $charges['max_call_in'];
            $hasBalance = ($srvc_received < $max_call_in);
        }
        else {
            $hasBalance = (bool) $account_balance > $call_charge; 
        }
        
        $clientPhoneDetails25 = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => trim($insert_data['Called']),
            'status' => 'active'
        ))->row_array();
        @ $mainClientDetails25  = $clientPhoneDetails25['client_id'];


        if($hasBalance && intval($mainClientDetails)>0) { //check call minutes  balance 
            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($mainClientDetails,'max_call_minutes');
                $mainClientDetails = $charges['max_call_minutes'];
                $hasBalance = ($srvc_received < $max_call_minutes);
            }
            else {
                $hasBalance = (bool) $account_balance > $charges['call_forword_charges']; 
            }
        } else {
            $hasBalance = true;
        }
        $is_phone_blocked = false;
        $is_busy = false;

        $alreadyBlockedNum = $this->db->get_where('ct_blocked_numbers', array(
            'client_id' => $mainClientDetails,
            'phoneNumber' => $clientPhoneDetails['phoneNumber'],
            'blocked' => $insert_data['From_call']
        ))->row();

        if(!empty($alreadyBlockedNum)) {
            //$is_phone_blocked = true;

            $this->db->where('id', $alreadyBlockedNum->id);
            $this->db->update('ct_blocked_numbers', array('times'=>intval($alreadyBlockedNum->times) + 1));

        }

        if($is_phone_blocked) { // do not process call 
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo '<Response><Reject reason="'.($is_busy ? 'busy' : 'rejected' ).'"></Reject></Response>';
            /*$this->load->view('base/response_reject', array(
                'is_busy' => false,
            ));*/
            die();
        } else {
            if($charges['is_subscription'] == 1  && intval($mainClientDetails)>0) {
                 $this->crud_model->update_subs_count($mainClientDetails,'max_call_minutes',intval($insert_data['Duration']));
            }
                //********************************************
                $insert_data['call_amount'] = $call_charge;
                $insert_data['client_id']            = $mainClientDetails;
                $insert_data['Timestamp']            = date("Y-m-d");
                $this->db->insert('incoming_call_details', $insert_data);

            // charge the user
            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->update_subs_count($mainClientDetails,'max_call_in');
            }
            else {
                /* UPDATE BALANCE */
                $account_balance = $cleint_Data['available_fund'] = $account_balance - $call_charge;
                $this->db->where('client_id', $mainClientDetails);
                $this->db->update('client', $cleint_Data);

                
                $insert_data_pay            = array();
                $insert_data_pay['client_id']            = $mainClientDetails;
                $insert_data_pay['payment_gross_amount'] = -(float) $call_charge;
                $insert_data_pay['pay_meta']            = 'receiver='. $insert_data['To_call'] . '|caller=' . $insert_data['From_call'];
                $insert_data_pay['plan_name']            = 'payment_against_incoming_call_request';
                $insert_data_pay['payment_date']         = date("Y-m-d");
                $insert_data_pay['payment_time']         = date("H:i:s");
                $this->db->insert('client_payment_details', $insert_data_pay);
            }


        }
        
        
        
        
        
        
        $insert_data['To_call'] = str_replace('+', '', $insert_data['To_call']);
        if (strpos('+', $insert_data['To_call']) == false) {
            $insert_data['To_call'] = '+' . trim($insert_data['To_call']);
        }
        
        
        //GET THE per_call_charge  ................
        $per_call_charge = $charges['call_charge'];
        
        //********************************************//
        //$insert_data['From_call']= '+18183121969';
        if ($insert_data['From_call'] != 'client:Anonymous' || $insert_data['From_call'] != '') {
            
            $advanceCalFetched = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $insert_data['From_call']
            ))->row();
            $clientFUNFDetails = $this->db->get_where('client', array(
                'client_id' => $clientPhoneDetails['client_id']
            ))->row();
            
            $phoneNumber        = $insert_data['From_call'];
            $lookup_call_charge = $charges['lookup_call_charge'];
            
            /* LOOOKUP */
            if ((empty($advanceCalFetched))) { // if not already looked up
                
                $client = new Client($this->AdminAccountSid, $this->AdminAuthToken);
                
                if($charges['is_subscription'] == 1 ) {
                    $srvc_received = $this->crud_model->get_subs_count($clientFUNFDetails->client_id,'max_call_lookup');
                    $max_call_lookup = $charges['max_call_lookup'];
                    $hasBalance = ($srvc_received < $max_call_lookup);
                }
                else {
                    $hasBalance = (bool) $account_balance > (float) $lookup_call_charge;
                }

                if ($hasBalance) {
                    $this->load->helper('twilio_handlers');
                    /* get caller details from Twilio and add into DB */
                    $caller_details = ct_get_phone_details($insert_data['From_call'], $client, $lookup_call_charge,$clientFUNFDetails);
                }
            } //if ended..........


            
            $InsertData123 = array(
                'client_id' => $clientPhoneDetails['client_id'],
                'phonenumber' => $phoneNumber,
                'from' => $to_call_num,
                'date_added' => date('Y-m-d H:i:s'),
                'location' => 'incoming-call'
            );
            $this->db->insert('caller_look_up', $InsertData123);
            
            $calls_read = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $phoneNumber
            ))->result_array();
            $schema     = '';

            $page_data['lookup_data'] = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $phoneNumber
            ))->row(); 

        $uclient = $this->db->get_where('client', array(
            'client_id' => $clientPhoneDetails['client_id']
        ))->row();
            $this->load->helper('twilio_handlers');
            /* SEND EMAIL ON LOOKUP */
            $system_email = $this->system_noreplymail;
            $system_title = $this->system_title;
            $emsg = ct_get_email_details($page_data,$uclient->timezone);

            $em_btns = '<a class="btn-orange btn-oring" href="'.site_url('base/download_recording/'.$insert_data['CallSid']).'">Play Recording</a>';

            $prev_msg = '<div class="row" style="text-align:center;">
            <h3 style="font-size:19px!important;" align="center"> You have a new Call from ' .ct_format_nice_number($phoneNumber).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']).'</h3>
            <hr style="margin:5px;">
            <p class="call-btn">
                '.$em_btns.'
            </p>
            </div>';

            $system_email = $this->system_noreplymail;
            $system_title = $this->system_title;
            $this->email->set_mailtype("html");
            $this->email->from($system_email, $system_title);
            $this->email->to($clientDetails->email);
            $this->email->subject('New Call from '.ct_format_nice_number($phoneNumber).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']) );
            $page_data['main_content'] = $prev_msg.$emsg;
            $e_msg = $this->load->view('email/details', $page_data, true);
            $this->email->message($e_msg);

            if($clientPhoneDetails['flag_mailnotif_call'] && $clientDetails->email_verified=='1')
                {
                    $this->email->send();
                    $this->email->clear();
                    if($clientDetails->second_email){
                        $this->email->set_mailtype("html");
                        $this->email->from($system_email, $system_title);
                        $this->email->to($clientDetails->second_email);
                        $this->email->subject('New Call from '.ct_format_nice_number($phoneNumber).' to '.$clientPhoneDetails['campaign_name'].' '.ct_format_nice_number($clientPhoneDetails['phoneNumber']) );
                        $this->email->message($e_msg);
                        $this->email->send();
                        $this->email->clear();    
                    }
                }

            
            
            $user = $this->db->get_where('client', array(
                'client_id' => $clientPhoneDetails['client_id']
            ))->result_array();

            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($mainClientDetails,'max_social_ad');
                $max_social_ad = $charges['max_social_ad'];
                $hasBalance = ($srvc_received < $max_social_ad);
            }
            else {
                $hasBalance = true; 
            }

            if ($clientPhoneDetails['send_custom_audience'] == 1 && $hasBalance) {
                //die(var_dump($user[0]['accesstoken']));
                $costToSocialMedia = $charges['p_social_med_adv'];


                $rez = $this->update_cust_audience($calls_read,$user[0]['accesstoken'],$clientPhoneDetails['custom_audience_id']);


                //execute post
                $result = $rez;

                $data   = array(
                    'date' => date('Y-m-d H:i:s'),
                    'cost' => (float) $costToSocialMedia,
                    'client_id' => $clientPhoneDetails['client_id']
                );
                $this->db->insert('incoming_transcriptions', $data);
                
                $client_Details                = $this->db->where('client_id', $mainClientDetails)->get('client')->result_array();
                $account_balance = $this->get_balance($mainClientDetails);

                if($charges['is_subscription'] == 1 ) {
                    $srvc_received = $this->crud_model->update_subs_count($mainClientDetails,'max_social_ad');
                } else {
                    /* UPDATE BALANCE */
                    $account_balance = $cleint_Data['available_fund'] = $account_balance - $costToSocialMedia;
                    $this->db->where('client_id', $mainClientDetails);
                    $this->db->update('client', $cleint_Data);
                    $insert_data_pay = array();
                    $insert_data_pay['client_id']            = $mainClientDetails;
                    $insert_data_pay['payment_gross_amount'] = -(float) $costToSocialMedia;
                    $insert_data_pay['plan_name']            = 'payment_against_social_media_audience';
                    $insert_data_pay['payment_date']         = date("Y-m-d");
                    $this->db->insert('client_payment_details', $insert_data_pay);
                }
                    
            }
            
        
            $ext_forward_number = $clientPhoneDetails['call_forward_no'] ? $clientPhoneDetails['call_forward_no'] : '';
            
            $call_forward_no = str_replace(array(
                '(',
                ')',
                '-',
                ' '
            ), '', $ext_forward_number);
            
        }
        
        
        $kada_updc = $clientFUNFDetails->chook_when;
        //if( ($kada_updc+1800)>time() && !$clientFUNFDetails->chook_lookup_only=='1') 
        {

            $alreadyPrintedSet = $this->db->get_where('ct_printed_numbers', array(
                'client_id' => $clientFUNFDetails->client_id,
                'phoneNumber' => $insert_data['From_call']
            ))->row();
                if(empty($alreadyPrintedSet)) {
                    $newprint = array(
                        'client_id' => $clientFUNFDetails->client_id,
                        'phoneNumber' => $insert_data['From_call'],
                        'action_to' => $insert_data['To_call'],
                        'time' => time(),
                        'is_printed' => '0',
                        'to_print' => json_encode($this->crud_model->getNumberDetails($insert_data['From_call'] ))
                    );
                    $this->db->insert('ct_printed_numbers', $newprint);
                }
        }


        if($charges['is_subscription'] == 1 ) { // count record == count transcribe
            $srvc_received = $this->crud_model->get_subs_count($clientDetails->client_id,'max_call_transcripts');
            $max_call_transcripts = $charges['max_call_transcripts'];
            $hasBalance = ($srvc_received < $max_call_transcripts);
        } else {
            $hasBalance = (bool) $account_balance > (float) ($cost + $costToTranscr);
        }
        $call_transript_balance = $hasBalance;

        $company_name          = $clientDetails->company_name ? $clientDetails->company_name : '';
        $flag_record_calls     = $clientPhoneDetails['flag_record_calls'] ? true : false;
        
        $flag_transcribe_call  = $clientDetails->flag_transcribe_call;
        $multi_timeout          = intval($clientPhoneDetails['multi_timeout']);
        $voice_timeout          = intval($clientPhoneDetails['voice_timeout']);

        
        $multi_forw = $clientPhoneDetails['multi_forward'];
        $txt_whisper_calls = $clientPhoneDetails['whisper_message'];

        $hasVoicemail = $clientPhoneDetails['voice_on'] == 0 ? false : true;
        $flag_whisper_record = $clientPhoneDetails['flag_whisper_record'] == 0 ? false : true;

        if($multi_timeout>0) {
            $pozv_list = explode("," , $multi_forw);
            $next_robin = $pozv_list[0];

            $call_forward_no_clean = str_replace(array(
                '(',
                ')',
                '-',
                ' '
            ), '', $call_forward_no);

            $this->load->view('base/call_request_round_robin', array(
                'request' => $_REQUEST,
                'txt_whisper_calls' => $txt_whisper_calls,
                'flag_whisper_calls' => $flag_whisper_record,
                'call_forward_no' => $call_forward_no,
                'call_forward_no_clean' => $call_forward_no_clean,
                'flag_record_calls' => $flag_record_calls,
                'hasVoicemail' => $hasVoicemail,
                'called_who' => $clientPhoneDetails['phoneNumber'],
                'flag_transcribe_call' => $flag_transcribe_call,
                'multi_forw' => $multi_forw,
                'multi_timeout' => $multi_timeout,
                'voice_timeout' => $voice_timeout,
                'next_robin' => $next_robin,
                'whichRobin' => '0',
                'clid' => $clientDetails->client_id,
                'cnum' => trim($insert_data['To_call'])
            ));

        } else {

            $this->load->view('base/incoming_call_request', array(
                'request' => $_REQUEST,
                'hasVoicemail' => $hasVoicemail,
                'txt_whisper_calls' => $txt_whisper_calls,
                'flag_whisper_calls' => $flag_whisper_record,
                'called_who' => $clientPhoneDetails['phoneNumber'],
                'voice_timeout' => $voice_timeout,
                'clid' => $clientDetails->client_id,
                'call_forward_no' => $call_forward_no,
                'flag_record_calls' => $flag_record_calls,
                'flag_transcribe_call' => $flag_transcribe_call,
                'multi_forw' => $multi_forw,
                'company_name' => $company_name
            ));
        }
    }
    
    public function callstatus()
    {
        
        $_REQUEST['To_call'] = $_REQUEST['To'] ? $_REQUEST['To'] : '';
        
        $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
            'phoneNumber' => $_REQUEST['To_call'],
            'status' => 'active'
        ))->row();
        
        $clientDetails = $this->db->get_where('client', array(
            'client_id' => $clientPhoneDetails->client_id
        ))->row();
        
        $charges = $this->crud_model->fetch_package_pricing($clientDetails->subscription_id);
        
        $subAccountSid = $clientDetails->subaccount_sid;
        $subAuthToken  = $clientDetails->auth_token;

        $account_balance = $this->get_balance($clientPhoneDetails->client_id);
        
        $_REQUEST['CallSid'] = $_REQUEST['CallSid'] ? $_REQUEST['CallSid'] : '';

        $data = new Client($subAccountSid, $subAuthToken);
        try {
            $mainCallData = $data->calls($_REQUEST['CallSid'])->fetch();
            $insertdata['CallStatus']    = $mainCallData->status ? $mainCallData->status : '';
            $insertdata['forwardedFrom'] = $mainCallData->forwardedFrom ? $mainCallData->forwardedFrom : '';
            if ($mainCallData->duration > 60)
                $duration = $mainCallData->duration / 60;
            else
                $duration = 1;
            $insertdata['Duration']      = ceil($duration);
            $insertdata['CallDuration']  = $mainCallData->duration;
            $insertdata['call_end_time'] = $mainCallData->endTime->format("d-m-Y h:i:sa");
            $insertdata['call_time']     = $mainCallData->startTime->format("d-m-Y h:i:sa");
            //GET THE per_call_charge  ................
            $per_call_charge             = $charges['call_charge'];
            $IncomingTotalCharges        = $insertdata['Duration'] * $per_call_charge;
            $insertdata['call_amount']   = $IncomingTotalCharges;
            $this->db->where('CallSid', $_REQUEST['CallSid']);
            $insertdata['client_id'] = $clientPhoneDetails->client_id;
                $insert_data['Timestamp']            = date("Y-m-d");
            $this->db->update('incoming_call_details', $insertdata);
            
            $calls = $data->calls->read(array(
                "parentCallSid" => $_REQUEST['CallSid']
            ));
            
            if(! empty($calls) ) {
            
                $insert_data['Called']       = $calls[0]->to ? $calls[0]->to : '';
                $insert_data['Direction']    = $calls[0]->direction ? $calls[0]->direction : '';
                $insert_data['CallSid']      = $calls[0]->sid ? $calls[0]->sid : '';
                $insert_data['To_call']      = $calls[0]->to ? $calls[0]->to : '';
                $insert_data['From_call']    = $calls[0]->from ? $calls[0]->from : '';
                $insert_data['AccountSid']   = $_REQUEST['AccountSid'] ? $_REQUEST['AccountSid'] : '';
                $insert_data['Caller']       = $calls[0]->from ? $calls[0]->from : '';
                $insert_data['call_time']    = $calls[0]->startTime->format("d-m-Y h:i:sa");
                $insert_data['CallStatus']   = $calls[0]->status ? $calls[0]->status : '';
                $insert_data['CallDuration'] = $calls[0]->duration ? $calls[0]->duration : 0;
                $insert_data['forwardedFrom'] =  $calls[0]->forwardedFrom ?  $calls[0]->forwardedFrom : '';
                $insert_data['Timestamp'] = 'ovai';
                
                $clientPhoneDetails5 = $this->db->get_where('client_phonenumber_purchased', array(
                    'phoneNumber' => $insert_data['forwardedFrom'],
                    'status' => 'active'
                ))->row();

                $insert_data['client_id'] = $clientPhoneDetails5->client_id;

                if ($insert_data['CallDuration'] > 0)
                    $duration = $insert_data['CallDuration'] / 60;
                else
                    $duration = 0;
                $insert_data['Duration']      = ceil($duration);
                $insert_data['call_end_time'] = $calls[0]->endTime->format("d-m-Y h:i:sa");
                $insert_data['forwardedFrom'] = $calls[0]->forwardedFrom ? $calls[0]->forwardedFrom : '';
                
                $call_forword_charges       = $charges['call_forword_charges'];
                $TotalCharge                = $insert_data['Duration'] * $call_forword_charges;
                $insert_data['call_amount'] = $TotalCharge;
                
                $insert_data['Timestamp']            = date("Y-m-d");

                /*if($insert_data['CallStatus'] == 'busy' || $insert_data['CallStatus'] == 'no-answer') {
                    if($clientPhoneDetails->multi_forward!='') {
                        $flag_transcribe_call  = $clientDetails->flag_transcribe_call;
                        $call_forward_no = $clientPhoneDetails->multi_forward;
                        if($call_forward_no!=$insert_data['To_call'])
                            $this->load->view('base/incoming_call_request', array(
                                'request' => $_REQUEST,
                                'call_forward_no' => $call_forward_no,
                                'flag_record_calls' => $flag_record_calls,
                                //'flag_transcribe_call' => $flag_transcribe_call,
                                //'company_name' => $company_name
                            ));
                    }
                }*/

                $insertID = $this->db->insert('incoming_call_details', $insert_data);


            }
            
                $clientPhoneDetailsold = $this->db->get_where('client_phonenumber_purchased', array(
                    'phoneNumber' => $_REQUEST['To'],
                    'status' => 'active'
                ))->row();
                if(!empty($clientPhoneDetailsold)) {

                $clientPhoneDetailsarr = $this->db->get_where('client_phonenumber_purchased', array(
                    'phoneNumber' => $_REQUEST['To'],
                    'status' => 'active'
                ))->row_array();
                    $alreadyvCardSet = $this->db->get_where('ct_vcard_numbers', array(
                        'client_id' => $clientPhoneDetailsold->client_id,
                        'phoneNumber' => $_REQUEST['From'],
                        'action_to' => $_REQUEST['To'],
                    ))->row();

                    if($clientPhoneDetailsarr['flag_auto_sms_oncall'])
                        $this->auto_sms_reply($clientPhoneDetailsold->client_id,$_REQUEST['To'],$_REQUEST['From'],$clientPhoneDetailsarr['auto_sms_reply'],$clientPhoneDetailsarr['auto_sms_file'],$clientPhoneDetailsarr['auto_sms_type']);
                    if(empty($alreadyvCardSet)) {
                    if($clientPhoneDetailsold->auto_vcard)
                        $this->auto_send_vcard($clientPhoneDetailsold->client_id,$_REQUEST['To'],$_REQUEST['From'],$clientPhoneDetailsarr['vcard_reply_text']);
                    }
                }
            $clientDetails = $this->db->get_where('client', array(
                'client_id' => $clientPhoneDetails->client_id
            ))->row();

            if ($insertID && ($TotalCharge > 0)) {


                    if ($clientDetails->flag_transcribe_call == 1) {

                        // Call Record if transcribe active
                        $account_balance = $this->get_balance($clientPhoneDetails->client_id);
                        $cost                  = $charges['p_call_recording'];
                        $costToTranscr = $charges['p_transc_service'];

                        if($charges['is_subscription'] == 1 ) { // count record == count transcribe
                            $srvc_received = $this->crud_model->get_subs_count($clientPhoneDetails->client_id,'max_call_transcripts');
                            $max_call_transcripts = $charges['max_call_transcripts'];
                            $hasBalance = ($srvc_received < $max_call_transcripts);
                        } else {
                            $hasBalance = (bool) $account_balance > (float) ($cost + $costToTranscr);
                        }
                        $call_transript_balance = $hasBalance;

                        $company_name          = $clientDetails->company_name ? $clientDetails->company_name : '';
                        $flag_record_calls     = $hasBalance ? $clientDetails->flag_record_calls : '';
                        $flag_transcribe_call  = $clientDetails->flag_transcribe_call;

                        if ($hasBalance) {

                            if($charges['is_subscription'] == 1 ) { // count record == count transcribe

                                $srvc_received = $this->crud_model->update_subs_count($clientPhoneDetails->client_id,'max_call_transcripts',$insert_data['Duration']);
                            } else {
                        
                                /* UPDATE BALANCE */                
                                /*$client_Details                = $this->db->where('client_id', $mainClientDetails)->get('client')->result_array();
                                $cleint_Data['available_fund'] = ($account_balance - (float) ($costToTranscr + $cost));
                                 $account_balance = $cleint_Data['available_fund'];
                                $this->db->where('client_id', $mainClientDetails);
                                $this->db->update('client', $cleint_Data);
                                
                                $insert_data_pay = array();
                                $insert_data_pay['client_id']            = $mainClientDetails;
                                $insert_data_pay['payment_gross_amount'] = -(float) $costToTranscr;
                                $insert_data_pay['plan_name']            = 'payment_against_transcribe_services';
                                $insert_data_pay['payment_date']         = date("Y-m-d");
                                $insert_data_pay['payment_time']         = date("H:i:s");
                                $this->db->insert('client_payment_details', $insert_data_pay);
                                $insert_data_pay = array();
                                
                                $insert_data_pay['client_id']            = $mainClientDetails;
                                $insert_data_pay['payment_gross_amount'] = -(float) $cost;
                                $insert_data_pay['plan_name']            = 'payment_against_call_recording';
                                $insert_data_pay['payment_date']         = date("Y-m-d");
                                $insert_data_pay['payment_time']         = date("H:i:s");
                                $this->db->insert('client_payment_details', $insert_data_pay);*/
                            }
                            
                        } else {
                                $user      = $this->db->get_where('client', array(
                                    'client_id' => $clientPhoneDetails->client_id
                                ))->result_array();
                                $user = $user[0];
                             $rez = $this->_tw_addons($user['subaccount_sid'], $user['auth_token'], 'uninstall', 'voicebase_transcription');
                            $cleint_Data['transcribe_disabled'] = '1';
                            $this->db->where('client_id', $clientPhoneDetails->client_id);
                            $this->db->update('client', $cleint_Data);
                         }
                    }

                if($charges['is_subscription'] == 1 ) {
                 //$this->crud_model->update_subs_count($clientPhoneDetails->client_id,'max_call_minutes',$insert_data['Duration']);
                } else {
                    /* UPDATE BALANCE */
                    $account_balance = $cleint_Data['available_fund'] = $account_balance - $TotalCharge;
                    $this->db->where('client_id', $clientDetails->client_id);
                    $client_id = $this->db->update('client', $cleint_Data);
                    $insert_data_pay = array();
                    $insert_data_pay['client_id']            = $clientDetails->client_id;
                    $insert_data_pay['payment_gross_amount'] = -(float) $TotalCharge;
                    $insert_data_pay['plan_name']            = 'payment_against_call_forward_charge';
                    $insert_data_pay['payment_date']         = date("Y-m-d");
                    $insert_data_pay['payment_time']         = date("H:i:s");
                    $this->db->insert('client_payment_details', $insert_data_pay);
                }
                
            }
        }
        catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    /* Email Handling - Transcriptions */
    public function sent_transcript() {
        $pag_data['main_content'] = '<h3 style="text-align:center">Your call is being transcribed and will be emailed to you shortly.</h3>';
        $this->load->view('email/basic', $pag_data);
    }


    public function get_transcript($trans_id='') {

        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
        if($trans_id == '') {
            $trans_id = (int) $_POST['transid'];
        }
            $num_caller = $_REQUEST['caller'];
            $num_receiver =  $_REQUEST['receiver'];

                $this->load->helper('twilio_handlers');
        //get user details  = SID
        $client = $this->db->get_where('client', array(
            'client_id' => $this->session->userdata('login_user_id')
        ))->row();

        //get transcript details
        $transcript = $this->db->get_where('ct_transcripts', array(
            'id' => $trans_id 
        ))->row();

        $userRecordTextt = str_replace('Speaker 1', ' <br/><b style="color:orange">Caller</b> ', $transcript->text);
        $finalRecord     = str_replace('Speaker 2', ' <br/><b style="color:grey">Reciever</b> ', $userRecordTextt);
        $system_email    = $this->db->get_where('settings', array(
            'type' => 'system_email'
        ))->row()->description;
        
        $system_title = $this->db->get_where('settings', array(
            'type' => 'system_title'
        ))->row()->description;
        $system_name  = $this->db->get_where('settings', array(
            'type' => 'system_name'
        ))->row()->description;
        
        $sendMailTo         = $client->email;
        $transcriptionsText = "<h3>Transcription <span class='pull-right small'>" . ct_format_nice_time(time(),$client->timezone) . "</span> </h3>
                              <h4><span style='color:orange'>Caller:</span> ".ct_format_nice_number($num_caller)." <span style=color:grey' class='pull-right'>Receiver:  ".ct_format_nice_number($num_receiver)."</span> </h4>
                            <hr/> <p>" . $finalRecord . "</p>";
        
        
        $message = $transcriptionsText . '                         
                            <hr />
                                <p>Best Regards, </p>
                                <p>' . $system_name . '</p>';

        $system_email = $this->system_noreplymail;
        $system_title = $this->system_title;
        $this->email->set_mailtype("html");
        $this->email->from($system_email, $system_title);
        $this->email->to($sendMailTo);
        $this->email->subject('Transcription - ' .ct_format_nice_number($num_caller) );
        $page_data['main_content'] = $message;
        $e_msg = $this->load->view('email/basic', $page_data, true);
        $this->email->message($e_msg);
        $this->email->send();
        if( isset($_POST['ajax_req']) )
            echo '1';
        else
            redirect(base_url() . 'base/sent_transcript', 'refresh');
    }

    public function save_voicemail($cid,$cphone) {

            $cid = urldecode($cidr);
            $cphone = urldecode($cphoner);
            $voice_data['client_id'] = $cid;
            $voice_data['phoneNumber'] = $cphone;
            $voice_data['caller'] = $_POST['Caller'];  
            $voice_data['recording_url'] = $_POST['RecordingUrl'];
            $this->db->insert('ct_voicemail', $voice_data);
            $insert_id = $this->db->insert_id();
            $this->load->view('base/call_hangup', array(
                'request' => $_REQUEST
            ));
    }
    

    public function download_recording($callsid) {
            $usr = $this->db->get_where('client', array(
                'client_id' => $this->session->userdata('login_user_id')
            ))->row(); 

                $this->load->library('restclient');
                $api = new Restclient([
                    'base_url' => "https://api.twilio.com", 
                    'username' => $this->AdminAccountSid, //$client->subaccount_sid, 
                    'password' => $this->AdminAuthToken
                ]);
               $req =  $api->get('/2010-04-01/Accounts/'.$usr->subaccount_sid.'/Calls/'.$callsid.'/Recordings.json');
                $rez = $req->decode_response();
 
        // Get an object from its sid. If you do not have a sid,
        // check out the list resource examples on this page
        //$call = $account->calls->read();
                if(!empty($rez->recordings)) {
                   //var_dump($rez->recordings[0]->sid);

                $req =  $api->get($rez->recordings[0]->uri);
                $reco = $req->decode_response();
                $reco = str_replace('.json', '', 'https://api.twilio.com' . $rez->recordings[0]->uri. '.mp3');
                    //var_dump($reco);
                    $pag_data['main_content'] ='<h3 style="text-align:center">You can listen to the recording below!</h3>
                    <div style="text-align:center;"><audio controls>
                      <source src="'.$reco.'" type="audio/mp3">
                            Your browser does not support the audio element.
                    </audio><hr/>
                    <a class="btn-orange btn-oring" download href="'.$reco.'">Download .mp3</a></div>';
                    
                    $this->load->view('email/basic', $pag_data);

                } else {
                    $pag_data['main_content'] ='<h3 style="text-align:center">This call was not recorded!</h3>
                    <div style="text-align:center;"><hr/>
                    <a class="btn-orange btn-oring" href="'.base_url().'">Back to Home</a></div>';
                    
                    $this->load->view('email/basic', $pag_data);
                }
    }


    public function save_transcript() {
        if(isset($_POST['AddOns'])) {
            $req_dump = var_export( $_POST['AddOns'], true );
            $trans_res = json_decode($_POST['AddOns']);

            if($trans_res->status == 'successful') {
                $payload = $trans_res->results->voicebase_transcription->payload[0];
                $rec_link_arr = explode("/",$trans_res->results->voicebase_transcription->links->recording);
                $rec_id = array_slice($rec_link_arr, -1)[0];
                $acc_sid = array_slice($rec_link_arr, -3)[0];
                $amz_url = $payload->url;

                $client = $this->db->get_where('client', array(
                    'subaccount_sid' => $acc_sid
                ))->row();

                // get client deetails
                /*$client = $this->db->get_where('client', array(
                    'client_id' => $this->session->userdata('login_user_id')
                ))->row();*/ 

                $this->load->library('restclient');
                $api = new Restclient([
                    'base_url' => "", 
                    'username' => $client->subaccount_sid, 
                    'password' => $client->auth_token
                ]);

                $result = $api->get($amz_url.'.json');
                $rsD = $result->decode_response();
                $odgv = json_decode(file_get_contents($rsD->redirect_to));
                $trans_data['srt'] = $odgv->media->transcripts->srt;
                $trans_data['text'] = $odgv->media->transcripts->text;
                $trans_data['re_sid'] = $rec_id;
                $this->db->insert('ct_transcripts', $trans_data);
                $insert_id = $this->db->insert_id();
            }

       } else {

        }
    }

    public function ajax_send_demographics() {

        $reqcid =  $this->session->userdata('login_user_id');
        $clientInfo = $this->db->get_where('client', array(
            'client_id' => $reqcid
        ))->row();

        $tomails = $this->input->post('tomail').','; // twilio number
        $phonenum = $this->input->post('number'); // twilio number
        $tomailarr = explode(",",$tomails);
        $tomail = $tomailarr[0];

        header('Content-Type:application/json');
        if ($phonenum) {
            $page_data['lookup_data'] = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $phonenum
            ))->row(); 
        }

        $this->load->helper('twilio_handlers');

        /* SEND EMAIL ON REQUEST */
        $system_email = $this->system_noreplymail;
        $system_title = $this->system_title;
        $emsg = ct_get_email_details($page_data);
        $this->email->set_mailtype("html");
        $this->email->from($system_email, $system_title);
        if(!empty($tomail)) {
            $this->email->to($tomail);
            foreach($tomailarr as $bcto) {
                if(trim($bcto) !='' && $bcto!=$tomail)
                    $this->email->bcc(trim($bcto));
            }
        }
        else
            $this->email->to($clientInfo->email);
        
        $this->email->subject('Demographic Report for '.ct_format_nice_number($phonenum));
        $page_data['main_content'] = $emsg;
        $e_msg = $this->load->view('email/details', $page_data, true);
        $this->email->message($e_msg);
        if($this->email->send()) {
            $resp = array(
                'status' => 'success',
                'message' => 'Demographics Report for '+ct_format_nice_number($phonenum)+' sent!'
            );

        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Something went wrong! Report could not be sent!'
            );

        }
        echo json_encode($resp);
        /* SEND EMAIL ON REQUEST */
    }

    
    public function update_email_send_data()
    {

        $data = array('firstname' => $this->input->post('firstname'), 'lastname' => $this->input->post('lastname'), 'emailaddress' => $this->input->post('emailaddress'));
         $home_lookup_ip  = $this->db->get_where('home_lookup_ip', array('ip' => $_SERVER['REMOTE_ADDR'] ))->row();
         
        $this->db->where('ip', $_SERVER['REMOTE_ADDR']);
        $this->db->update('home_lookup_ip', $data);
        
        $home_lookup_ip = $this->db->get_where('home_lookup_ip', array(
            'ip' => $_SERVER['REMOTE_ADDR']
        ))->row();

        if ($home_lookup_ip->advanced_caller_id) {
            $page_data['lookup_data'] = $this->db->get_where('advanced_caller_details', array(
                'phoneNumber' => $home_lookup_ip->from_call
            ))->row(); 
        }

        $this->load->helper('twilio_handlers');

        /* SEND EMAIL ON LOOKUP */
        $system_email = $this->system_noreplymail;
        $system_title = $this->system_title;
        $emsg = ct_get_email_details($page_data);
        $this->email->set_mailtype("html");
        $this->email->from($system_email, $system_title);
        $this->email->to($this->input->post('emailaddress'));
        $this->email->subject('Advanced Demographic Reports');
        $page_data['main_content'] = $emsg;
        $e_msg = $this->load->view('email/details', $page_data, true);
        $this->email->message($e_msg);
        $this->email->send();
        /* SEND EMAIL ON LOOKUP */
        
        /* SEND EMAIL */
        echo "1";
    }
    
}