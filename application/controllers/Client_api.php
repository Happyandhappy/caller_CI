<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;

class Client_API extends CT_API_Controller
{
    protected $_userData;
    protected $_TWclient;

    function __construct()
    {
        parent::__construct();
         header('Access-Control-Allow-Origin: *');  
    
    }
    private function _response($data,$status = 'success',$mess = '') {
        header('Content-Type: application/json');
        /* should probably do a check if later extendable*/
        switch($status) {
            case '400';
                header( 'HTTP/1.1 400 BAD REQUEST' );
                $data['status'] = 'error';
            break;

            case '404';
                header( 'HTTP/1.1 404 Not Found' );
                $data['status'] = 'error';
            break;

            default: 
                header("HTTP/1.1 200 OK");
                $data['status'] = 'success';
        }
        $data['message'] = $mess;
        echo json_encode($data);
        die();
    }

    private function _login_check() {

    	$u_email = $this->input->post('u_email');
    	$u_pass = $this->input->post('u_pass');

        /* TODO: change to only post  */
        if(empty($u_email))
            $u_email = $this->input->get('u_email');
        if(empty($u_pass))
            $u_pass = $this->input->get('u_pass');

		$credential	= array(
			'email' => $u_email , 
			'password' => sha1($u_pass)
		);

        $query = $this->db->get_where('client' , $credential); 

        	if($query->num_rows() > 0) {
                $this->_userData = $query->row();
                return true;
            } else {
                return false;
            }
    }

    /* Public route handlers */

    public function index() {
        redirect(base_url());
    }

    /**
     * @api {post} /client_api/login_check Login Check
     * @apiName Login Check
     * @apiGroup Basic
     * @apiDescription Check if Login Credentials work.
     *
     * @apiParam {String} u_email Client Email
     * @apiParam {String} u_pass Client Password
     *
     * @apiSuccess {String} status Status of request. Will return 'success' in this case.
     * @apiSuccess {String} message Short description, might be empty on success.
     *
     * @apiSuccess {String} status Status of request. Will return 'error' in this case.
     * @apiError {String} message Short description, will describe possible issue.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "u_email": "chip1@aol.com",
     *       "u_pass": "1234"
     *     }
     *
     * @apiSampleRequest http://callertech.com/client_api/login_check
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *     "status": "success",
     *     "message": "A new phone added to listings!"
     * }
     *
     * @apiErrorExample {json} Error Response:
     * HTTP/1.1 400 BAD REQUEST
     * {
     *     "status": "error",
     *     "message": "You need to login!"
     * }
     *
     */

    public function login_check() {
        if($this->_login_check())
            $this->_response([],'success','You are logged in!');
        else
            $this->_response([],'400','You need to login!');
    }

    /**
     * @api {post} C_HOOK On Action
     * @apiName Incoming Action (Call or SMS)
     * @apiGroup Action Hooks
     * @apiDescription Being send by the server to C_HOOK on incoming call to website handler.
     *
     * @apiSuccessExample {json} Request on Register
     * POST
     * {
     *     "status": "hook_registered",
     *     "message": "A hook was registered to http://77.68.65.2:7058!"
     * }
     *
     *
     * @apiSuccessExample {json} Lookup on SMS
     * POST
     * {
     *     "action_type": "new-lookup-sms",
     *     "action_to": "+12345678",
     *     "action_from": "+18581237",
     *
     *     "phoneNumber": "+13103391681",
     *     "first_name": "Melinda",
     *     "middle_name": "S",
     *     "last_name": "Moore",
     *     "phone_carrier": "Verizon Wireless",
     *     "phone_line_type": "mobile",
     *     "countryCode": "US",
     *     "nationalFormat": "(310) 339-1681",
     *     "address_city": "Los Angeles",
     *     "address_extended_zip": "5413",
     *     "address_country": "USA",
     *     "address_line1": "4131 Coolidge Ave",
     *     "address_line2": "",
     *     "address_state": "CA",
     *     "address_zip_code": "90066",
     *     "age": "46",
     *     "education": "",
     *     "gender": "Female",
     *     "high_net_worth": "",
     *     "home_owner_status": "",
     *     "household_income": "50k-75k",
     *     "length_of_residence": "Less than 1 year",
     *     "marital_status": "",
     *     "market_value": "300k-350k",
     *     "occupation": "",
     *     "presence_of_children": "",
     *     "code": "",
     *     "caller_name": "MELINDA MOORE",
     *     "caller_type": "CONSUMER",
     *     "linked_emails": null,
     *     "social_links": null,
     *     "flag_custom_audience": "1",
     *
     *     "status": "success",
     *     "message": "A new lookup has been processed!"
     * }
     *
     * @apiSuccessExample {json} Lookup on Call
     * POST
     * {
     *     "action_type": "new-lookup-call",
     *     "action_to": "+12345678",
     *     "action_from": "+18581237",
     *
     *     "phoneNumber": "+13103391681",
     *     "first_name": "Melinda",
     *     "middle_name": "S",
     *     "last_name": "Moore",
     *     "phone_carrier": "Verizon Wireless",
     *     "phone_line_type": "mobile",
     *     "countryCode": "US",
     *     "nationalFormat": "(310) 339-1681",
     *     "address_city": "Los Angeles",
     *     "address_extended_zip": "5413",
     *     "address_country": "USA",
     *     "address_line1": "4131 Coolidge Ave",
     *     "address_line2": "",
     *     "address_state": "CA",
     *     "address_zip_code": "90066",
     *     "age": "46",
     *     "education": "",
     *     "gender": "Female",
     *     "high_net_worth": "",
     *     "home_owner_status": "",
     *     "household_income": "50k-75k",
     *     "length_of_residence": "Less than 1 year",
     *     "marital_status": "",
     *     "market_value": "300k-350k",
     *     "occupation": "",
     *     "presence_of_children": "",
     *     "code": "",
     *     "caller_name": "MELINDA MOORE",
     *     "caller_type": "CONSUMER",
     *     "linked_emails": null,
     *     "social_links": null,
     *     "flag_custom_audience": "1",
     *
     *     "status": "success",
     *     "message": "A new lookup has been processed!"
     * }
     *
     * @apiSuccessExample {json} Lookup on Manual (Website Input)
     * POST
     * {
     *     "action_type": "new-lookup-manual",
     *     "action_to": "+12345678",
     *     "action_from": "+18581237",
     *
     *     "phoneNumber": "+13103391681",
     *     "first_name": "Melinda",
     *     "middle_name": "S",
     *     "last_name": "Moore",
     *     "phone_carrier": "Verizon Wireless",
     *     "phone_line_type": "mobile",
     *     "countryCode": "US",
     *     "nationalFormat": "(310) 339-1681",
     *     "address_city": "Los Angeles",
     *     "address_extended_zip": "5413",
     *     "address_country": "USA",
     *     "address_line1": "4131 Coolidge Ave",
     *     "address_line2": "",
     *     "address_state": "CA",
     *     "address_zip_code": "90066",
     *     "age": "46",
     *     "education": "",
     *     "gender": "Female",
     *     "high_net_worth": "",
     *     "home_owner_status": "",
     *     "household_income": "50k-75k",
     *     "length_of_residence": "Less than 1 year",
     *     "marital_status": "",
     *     "market_value": "300k-350k",
     *     "occupation": "",
     *     "presence_of_children": "",
     *     "code": "",
     *     "caller_name": "MELINDA MOORE",
     *     "caller_type": "CONSUMER",
     *     "linked_emails": null,
     *     "social_links": null,
     *     "flag_custom_audience": "1",
     *
     *     "status": "success",
     *     "message": "A new lookup has been processed!"
     * }
     *
     *
     * @apiSuccessExample {json} On Action (if c_lookup_only=false)
     * POST
     * {
     *     "action_type": "incoming-call",
     *     "action_to": "+18181391680",
     *     "action_from": "+13103391681",
     *     "phoneNumber": "+13103391681",
     *     "first_name": "Melinda",
     *     "middle_name": "S",
     *     "last_name": "Moore",
     *     "phone_carrier": "Verizon Wireless",
     *     "phone_line_type": "mobile",
     *     "countryCode": "US",
     *     "nationalFormat": "(310) 339-1681",
     *     "address_city": "Los Angeles",
     *     "address_extended_zip": "5413",
     *     "address_country": "USA",
     *     "address_line1": "4131 Coolidge Ave",
     *     "address_line2": "",
     *     "address_state": "CA",
     *     "address_zip_code": "90066",
     *     "age": "46",
     *     "education": "",
     *     "gender": "Female",
     *     "high_net_worth": "",
     *     "home_owner_status": "",
     *     "household_income": "50k-75k",
     *     "length_of_residence": "Less than 1 year",
     *     "marital_status": "",
     *     "market_value": "300k-350k",
     *     "occupation": "",
     *     "presence_of_children": "",
     *     "code": "",
     *     "caller_name": "MELINDA MOORE",
     *     "caller_type": "CONSUMER",
     *     "linked_emails": null,
     *     "social_links": null,
     *     "flag_custom_audience": "1",
     *     "status": "success",
     *     "message": "A new call has been made!"
     *     }
     *
     */

    /**
     * @api {post} /client_api/register_hook Register Hook
     * @apiName Register HTTP Hook
     * @apiGroup Basic
     * @apiDescription Register Where to reach you when a HTTP Hook needs to be sent. Will need * to be refreshed every 30 minutes as minimum or will be discarded.
     *
     * @apiParam {String} u_email Client Email
     * @apiParam {String} u_pass Client Password
     * @apiParam {String}  c_where C_HOOK - Address of HTTP Listener (and Port)
     * @apiParam {Bool}  c_lookup_only Default: true, if set to false sends lookups on in-call, in-sms, lookup-manual actions. Otherwise, if set to true, only send calls on first lookups.
     *
     * @apiSuccess {String} status Status of request. Will return 'success' in this case.
     * @apiSuccess {String} message Short description, might be empty on success.
     *
     * @apiSuccess {String} status Status of request. Will return 'error' in this case.
     * @apiError {String} message Short description, will describe possible issue.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "u_email": "chip1@aol.com",
     *       "u_pass": "1234",
     *       "c_where": "http://77.68.65.2:7058",
     *       "c_lookup_only": "true"
     *     }
     *
     * @apiSampleRequest http://callertech.com/client_api/register_hook
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *     "status": "success",
     *     "message": "Hook successfully added to 77.68.65.2:7058!"
     * }
     *
     * @apiErrorExample {json} Error Response:
     * HTTP/1.1 400 BAD REQUEST
     * {
     *     "status": "error",
     *     "message": "No C_HOOK set!"
     * }
     *
     */


    public function register_hook() {
        if($this->_login_check()){

            if(!isset($_REQUEST['c_where']))
                $this->_response([],'400','No C_HOOK set!');
            $old_c_where =  $this->_userData->chook_where;
            $old_c_when =  $this->_userData->chook_when;
            $cleint_Data['chook_where'] = trim($_REQUEST['c_where']);
            $cleint_Data['chook_when'] = time();
            if($_REQUEST['c_lookup_only'] == 'false')
                $cleint_Data['chook_lookup_only'] = '0';
            else
                $cleint_Data['chook_lookup_only'] = '1';
            $this->db->where('client_id', $this->_userData->client_id);
            $this->db->update('client', $cleint_Data);


                    $this->load->library('restclient');
                    $api_ht = new Restclient([
                        'base_url' => $cleint_Data['chook_where']
                    ]); 
                    $api_ht->post('/',array(
                          "status"=> "hook_registered",
                          "message"=> "A hook was registered to ".$cleint_Data['chook_where']
                    ));

            if($old_c_where == $cleint_Data['chook_where']  && ($old_c_when+1800)>$cleint_Data['chook_when'] ) {
                $this->_response([],'success','C_HOOK Updated!');
            } else {
                $this->_response([],'success','C_HOOK Registered!');
            }
        }
        else
            $this->_response([],'400','Wrong login data!');
    }

    public function test_webhook() {
        $where = $_REQUEST['c_where'];
        $poruk = $_REQUEST['poruk'];
            $this->load->library('restclient');

                $posj = new Restclient([
                    'base_url' => $where
                ]);
                $arr = array(
                      "action_type" => "test-webhook",
                      "status" => "success",
                      "message" => $poruk
                );;
                $posj->post('/',$arr);
                echo "Request Send with message: " . $poruk;
    }

    /**
     * @api {post}/client_api/lookup_number Lookup Number
     * @apiName Lookup Number
     * @apiGroup Basic
     * @apiDescription Get's caller data from listins, if they don't exist hooks up with Twilio and does a lookup to get caller info.
     *
     * @apiParam {String} u_email Client Email
     * @apiParam {String} u_pass Client Password
     * @apiParam {String} phonenumber Phonenumber to lookup.
     * @apiParam {String} is_international If Phone number is in international format.
     *
     * @apiSuccess {String} status Status of request. Will return 'success' in this case.
     * @apiSuccess {String} message Short description, might be empty on success.
     * @apiSuccess {Object} phone_details Will return Phone Details.
     *
     * @apiSuccess {String} status Status of request. Will return 'error' in this case.
     * @apiError {String} message Short description, will describe possible issue.
     *
     * @apiParamExample {json} Request Example:
     *     {
     *       "u_email": "chip1@aol.com",
     *       "u_pass": "1234",
     *       "phonenumber": "(310) 3391-681",
     *       "is_international": "false"
     *     }
     *
     * @apiSampleRequest http://callertech.com/client_api/lookup_number
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *     "phone_details": {
     *          "phoneNumber": "+13103391681",
     *          "first_name": "Melinda",
     *          "middle_name": "S",
     *          "last_name": "Moore",
     *          "phone_carrier": "Verizon Wireless",
     *          "phone_line_type": "mobile",
     *          "countryCode": "US",
     *          "nationalFormat": "(310) 339-1681",
     *          "address_city": "Los Angeles",
     *          "address_extended_zip": "5413",
     *          "address_country": "USA",
     *          "address_line1": "4131 Coolidge Ave",
     *          "address_line2": "",
     *          "address_state": "CA",
     *          "address_zip_code": "90066",
     *          "age": "46",
     *          "education": "",
     *          "gender": "Female",
     *          "high_net_worth": "",
     *          "home_owner_status": "",
     *          "household_income": "50k-75k",
     *          "length_of_residence": "Less than 1 year",
     *          "marital_status": "",
     *          "market_value": "300k-350k",
     *          "occupation": "",
     *          "presence_of_children": "",
     *          "code": "",
     *          "caller_name": "MELINDA MOORE",
     *          "caller_type": "CONSUMER",
     *          "linked_emails": null,
     *          "social_links": null,
     *          "flag_custom_audience": "1"
     *     },
     *     "status": "success",
     *     "message": "A new phone added to listings!"
     *     }
     *
     * @apiErrorExample {json} Error Response:
     * HTTP/1.1 400 BAD REQUEST
     * {
     *     "status": "error",
     *     "message": "You need to login!"
     * }
     *
     */
    
    public function lookup_number() {
        /* will have to send login data whenever you do the lookup to make sure you are logged in */
        if(!$this->_login_check())
            $this->_response([],'400','You need to login!');

        $this->load->helper('twilio_handlers');

        // load models
        $this->load->model(
          array(
            'crud_model'
          )
        );

        $charges = $this->crud_model->fetch_package_pricing( $this->_userData->subscription_id );

        $cost = $charges['lookup_call_charge'];
        $costToSocialMedia = ($this->_userData->send_custom_audience == 1) ? $charges['p_social_med_adv'] : 0;
        $total_cost = (float)($cost + $costToSocialMedia);


        $this->db->select('cl.*,cl_ph.*');
        $this->db->from('client cl');
        $this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
        $this->db->where(array('cl.client_id' => $this->_userData->client_id));
        $query = $this->db->get();
        $clientdetails2 = $query->row();

        $this->_TWclient = new Client(
            $this->TwilioSettings['AccountSID'], 
            $this->TwilioSettings['AccountAuthToken']
        );

        /* TODO: change to only post  */
        if(isset($_GET['phonenumber']))
           $from_call = ($_GET['phonenumber']);
        else
           $from_call = ($this->input->post('phonenumber'));

        if($_GET['is_international'] != "true") {
            /* cleanup format */
            $from_call = str_replace('-', '', $from_call);
            $from_call = str_replace(' ', '', $from_call);
            $from_call = str_replace('(', '', $from_call);
            $from_call = (int) str_replace(')', '', $from_call);

            $from_call = '+1' . $from_call;
        }

        $numberChecked  = $this->crud_model->isNumberChecked( utf8_encode($from_call) );

        $eg_newcaller = false;
        $caller_details = array();

        if($charges['is_subscription'] == 1 ) {
            $srvc_received = $this->crud_model->get_subs_count($this->_userData->client_id,'max_call_lookup');
            $max_call_lookup = $charges['max_call_lookup'];
            $hasBalance = ($srvc_received < $max_call_lookup);
        }
        else {
            $hasBalance = (bool) ($this->_userData->available_fund > 0);
        }

        if(!$hasBalance  && !$numberChecked) {
            $this->_response([],'404','Not enough funds!');
        }

        if ($hasBalance  && !$numberChecked) {
            /* get caller details from Twilio and add into DB */
            $caller_details = ct_get_phone_details(
                $from_call,
                $this->_TWclient,
                $cost,
                $this->_userData
            );
            if($caller_details['is_error'] !== false) {
                $this->_response([],'404','Twilio Message: '. $caller_details['is_error']);
            } else {
                $eg_newcaller = true;
            }
        }

        /* add call to database */
        $InsertData123 = array(
            'client_id' => $this->_userData->client_id,
            'phonenumber' => $from_call,
            'date_added' => date('Y-m-d H:i:s'),
            'location' => 'manual'
        );
        $this->db->insert('caller_look_up', $InsertData123);

          if( !$eg_newcaller ) {
             $caller_data = $this->crud_model->getNumberDetails( $from_call );
             $messg = 'Phone Details Requested!';
         } else {
             $caller_data = $caller_details;
             $messg = 'A new phone added to listings!';
         }

         if( $caller_data['status'] != "successful")
            $this->_response([],'400','There was an Error with Twilio, ErrCode: '. $caller_data['error_code']);

	$prvi = explode("home_data=",$caller_data['address']);	
        $drugi = $prvi[1];
	$sad = explode("#",$drugi);
	$pod = array();
        if(is_array($sad))
	foreach($sad as $in) {
		$infs = explode("=",$in);
		if(is_array($infs) && $infs[1]!=='' && trim($infs[0])!=='') {
			$pod[0][$infs[0]] = $infs[1];
		}
	}     
    if(isset($prvi[2]) && is_array(explode("#",$prvi[2])))
    foreach(explode("#",$prvi[2]) as $in) {
		$infs = explode("=",$in);
		if(is_array($infs) && $infs[1]!=='' && trim($infs[0])!=='') {
			$pod[1][$infs[0]] = $infs[1];
		}
	}   
    if(isset($prvi[0]) && is_array(explode("#",$prvi[0])))
    foreach(explode("#",$prvi[0]) as $in) {
        $infs = explode("=",$in);
        if(is_array($infs) && $infs[1]!=='' && trim($infs[0])!=='') {
            $pod[2][$infs[0]] = $infs[1];
        }
    }
if(empty($pod)) {
	$sad = explode("#",$caller_data['address']);
	$pod = array();
        if(is_array($sad))
	foreach($sad as $in) {
		$infs = explode("=",$in);
		if(is_array($infs) && $infs[1]!=='' && trim($infs[0])!=='') {
			$pod[0][$infs[0]] = $infs[1];
		}
	}   
}
$pod = array(
    'list_of_addr' => array_values($pod) 
);


         $tohide = array(
            'to_call',
            'caller_id',
            'call_date',
            'recordingUrl',
            'status',
	    'address',
             'carrier',
             'phone_details',
            'error_code',
            'call_amount',
            'is_error'
            );
         foreach ($tohide as $toh) {
            unset($caller_data[$toh]);
         }
         
	$caller_data = array_merge($pod, $caller_data);
         


        if($charges['is_subscription'] == 1 ) {
            $srvc_received = $this->crud_model->update_subs_count($this->_userData->client_id,'max_call_lookup');
        }
        else {
            // upd.
        }

        /* push ads new user */

            if($charges['is_subscription'] == 1 ) {
                $srvc_received = $this->crud_model->get_subs_count($this->_userData->client_id,'max_social_ad');
                $max_social_ad = $charges['max_social_ad'];
                $hasBalance = ($srvc_received < $max_social_ad);
            }
            else {
                $hasBalance = true; 
            }
            /*
            if ($clientDetails->send_custom_audience && $hasBalance) {
                
                # code...
                $calls_read = $this->db->get_where('advanced_caller_details', array(
                    'phoneNumber' => $from_call
                ))->result_array();
                
                $clientPhoneDetails = $this->db->get_where('client_phonenumber_purchased', array(
                    'phoneNumber' => trim($insert_data['To_call']),
                    'status' => 'active'
                ))->row_array();

                $rez = $this->update_cust_audience($calls_read,$this->_userData->accesstoken,$clientPhoneDetails['custom_audience_id']);


                //execute post
                $result = $rez;
                
                $result_decoded = json_decode($result);
                
                if ($result_decoded->num_received) {
                    //Updating client available Funds
                    $account_balance = $this->get_balance();
                    if($charges['is_subscription'] == 1 ) {
                        $srvc_received = $this->crud_model->update_subs_count($this->_userData->client_id,'max_social_ad');
                    } else {

                    }
                    
                }
            }*/


            $alreadyPrintedSet = $this->db->get_where('ct_printed_numbers', array(
                'client_id' => $this->_userData->client_id,
                'phoneNumber' => $from_call
            ))->row();
        if(empty($alreadyPrintedSet)) {
          
                    $newprint = array(
                        'client_id' => $this->_userData->client_id,
                        'phoneNumber' => $from_call,
                        'action_to' => '',
                        'time' => time(),
                        'is_printed' => '1',
                        'to_print' => json_encode($caller_data)
                    );
                    $this->db->insert('ct_printed_numbers', $newprint);
            $this->_response(['phone_details'=> $caller_data],'success',$messg);
        } else {
            $this->_response([],'404','Already printed!');
        }

    }

}