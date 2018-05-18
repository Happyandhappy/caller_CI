<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Helper: Twilio Handlers
 *
 * Note: Loads the crud model if it is not loaded yet.
 *
 */

if ( ! function_exists('ct_format_nice_number'))
{

    function ct_format_nice_number($num)  {
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $num,  $matches ) )
        {
            $result = '('.$matches[1] . ')'.' ' .$matches[2] . '-' . $matches[3];
            return $result;
        }else {
            return $num;
        }
    }
}

if ( ! function_exists('ct_get_email_details'))
{

    function ct_get_email_details($page_data,$tz=0)  {

        if ($page_data['lookup_data']->first_name == "" && $page_data['lookup_data']->last_name == "") {
            $callerName = ' N / A';
        } else {
            $callerName = $page_data['lookup_data']->first_name . ' ' . $page_data['lookup_data']->middle_name . ' ' . $page_data['lookup_data']->last_name;
        }
        $poslat_vr =  ct_format_nice_time(time(),$tz);
        $ph_dis = ($page_data['lookup_data']->nationalFormat) ? $page_data['lookup_data']->nationalFormat : ' N / A';
        $message = '<div class="row">
        <h3 style="font-size: 19px!important;" align="center"> Your Caller Technologies Report for ' . $page_data['lookup_data']->nationalFormat.'</h3>
                <div class="col-md-6"><div class="primary-table">
                    <label class="full-label-one overlabel"><b>User Details</b></label>
                      <table>
                            <tr>
                                <td><label>Name:</label>&nbsp;&nbsp;<a href="http://google.com/search?q=' . $callerName . '">' . $callerName . '</a></td>
                            </tr>
                            <tr>
                                <td><label>Number:</label>&nbsp;&nbsp;<a href="http://google.com/search?q=' . $ph_dis . '">';
                                
        $message .= $ph_dis.'</a></td>
                            </tr>
                            <tr>
                                <td><label>Date:</label>&nbsp;&nbsp;';
        $message .= $poslat_vr;
        $message .= '</td>';
        $message .= '
                            </tr>
                            <tr>
                                <td><label>Caller Type:</label>&nbsp;&nbsp;';
        $message .= ($page_data['lookup_data']->caller_type) ? $page_data['lookup_data']->caller_type : ' N / A';
        $message .= '</td>
                            </tr>
                            <tr>
                                <td><label>Age:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->age) ? $page_data['lookup_data']->age : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Education:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->education) ? $page_data['lookup_data']->education : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Gender:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->gender) ? $page_data['lookup_data']->gender : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>High Net Worth:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->high_net_worth) ? $page_data['lookup_data']->high_net_worth : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Home Owner Status:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->home_owner_status) ? $page_data['lookup_data']->home_owner_status : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Residence Length:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->length_of_residence) ? $page_data['lookup_data']->length_of_residence : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Market Value:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->market_value) ? $page_data['lookup_data']->market_value : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Household Income:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->household_income) ? $page_data['lookup_data']->household_income : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                <td><label>Marital Status:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->marital_status) ? $page_data['lookup_data']->marital_status : ' N / A';
        $message .= '</span></td>
                            </tr>
                             <tr>
                                 <td><label>Number of Children:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->presence_of_children) ? $page_data['lookup_data']->presence_of_children : ' N / A';
        $message .= '</span></td>
                            </tr>
                            <tr>
                                 <td><label>Occupation:</label>&nbsp;&nbsp;<span style="display: inline-block;">';
        $message .= ($page_data['lookup_data']->occupation) ? $page_data['lookup_data']->occupation : ' N / A';
        $message .= '</span></td>
                            </tr>';
        
        $data = explode('#', $page_data['lookup_data']->linked_emails);
        if ($data[0]) {
            
            $message .= '<tr class="hide-click" data-click="' . $j . '">
                                    <td>
                                        <label>Email:</label>';
            for ($i = 0; $i <= count($data); $i++) {
                $mail = explode('=', $data[$i]);
                $mail[1] = trim($mail[1]);
                if( !empty($mail[1]) )
                $message .= '<a class="mail-link" href="mailto:' . $mail[1] . '">' . $mail[1] . '</a> ,';
            }
                $message .= '</td></tr>';
        }
        $data = explode('#', $page_data['lookup_data']->social_links);
        
        if ($data[0]) {
            $message .= '<tr class="hide-click" data-click="' . $j . '">
                                    <td>
                                        <label>Social Media Links:</label> ';
            for ($i = 0; $i <= count($data); $i++) {
                
                $link = explode('url=', $data[$i]);
                if (trim($link[0]) != '') {
                    continue;
                }
                if (trim($link[1]) != '') {
                    $message .= '<label><a  target="_blank" href="' . $link[1] . '">' . $link[1] . '</a> </label>';
                }
            }
        }
        $message .= '</td> </tr></table>
                    </div>
                </div><div class="col-md-6">';
        $data = explode('#', $page_data['lookup_data']->address);
        if ($data[0]) {
            $message .= '
                <div class="secondary-table">
                    <label class="full-label-two overlabel"><b>Address</b></label>';
            $message .= '<table>
                            <tr>
                                <td colspan="2">';
            $address = array();
            $i       = 0;
            foreach ($data as $res) {
                $data2 = explode('=', $res);
                if (!$data2[0])
                    continue;
                
                if ($data2[0] == 'city') {
                    $i++;
                    $address[$i] = array(
                        'city' => $data2[1]
                    );
                } else {
                    $address[$i][$data2[0]] = $data2[1];
                }
            }
            foreach ($address as $addr) {
                $address_string = '';
                $address_string .= (ucwords($addr['line1'])) ? ucwords($addr['line1']) . ',  ' : '';
                $address_string .= (ucwords($addr['line2'])) ? ucwords($addr['line2']) . ',  ' : '';
                $address_string .= (ucwords($addr['city'])) ? ucwords($addr['city']) . '  ' : '';
                $address_string .= (ucwords($addr['state'])) ? ucwords($addr['state']) . '  ' : '';
                $address_string .= (ucwords($addr['zip_code'])) ? ucwords($addr['zip_code']) . '-' : '0000';
                $address_string .= (ucwords($addr['extended_zip'])) ? ucwords($addr['extended_zip']) . '  ' : '';
                $address_string .= (ucwords($addr['country'])) ? ucwords($addr['country']) . ' ' : '';
                if (!empty($address_string)) {
                    $message .= '<a href="https://www.google.com/maps/place/' . urlencode($address_string) . '" target="_blank" style="display:block;color:#337ab7;">' . $address_string . '
                                    </a>';
                }
            }
            
            $message .= '</td>
                            </tr>';
            $data = explode('#', $cread['address']);
            foreach ($data as $res) {
                $data2 = explode('=', $res);
                if (!$data2[0])
                    continue;
                $message .= '<tr>
                                        <td>
                                            <label for="">' . ucwords(get_phrase($data2[0])) . ':</label>' . $data2[1] . '
                                        </td>
                                    </tr>';
            }
            $message .= '</table></div>';
        }
        $message .= '
                    <label class="full-label overlabel"><b>Phone Carrier Details</b></label>
                     <div class="sec-tab">
                        <table>
                            <tr>
                                <td><label>Phone Carrier:</label>';
        $message .= ($page_data['lookup_data']->phone_carrier) ? $page_data['lookup_data']->phone_carrier : ' N / A';
        $message .= '</td>
                            </tr>
                            <tr>
                                <td><label>Phone Line Type:</label>';
        $message .= ($page_data['lookup_data']->phone_line_type) ? $page_data['lookup_data']->phone_line_type : ' N / A';
        $message .= '</td>
                            </tr>
                            <tr>
                                <td><label>National Format:</label>';
        $message .= ($page_data['lookup_data']->nationalFormat) ? $page_data['lookup_data']->nationalFormat : ' N / A';
        $message .= '</td>
                            </tr>                                
                        </table>

                        </div>';
         $adv_caller_name  = ucwords($page_data['lookup_data']->first_name . ' ' . $page_data['lookup_data']->middle_name . ' ' . $page_data['lookup_data']->last_name);

        $message .= '
                    <label class="full-label overlabel"><b>Search User</b></label>
                     <div class="sec-tab">
                        <table>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px; font-size: 13px;"><img src="'.base_url('images/facebook-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" href="https://www.facebook.com/search/top/?q='.urlencode($adv_caller_name).'&init=public">Search on FB by Name</a><br/><a target="_blank" href="https://www.facebook.com/search/top/?q='.urlencode($page_data['lookup_data']->nationalFormat).'&init=public">Search on FB by Number</a></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px;"><img src="'.base_url('images/linkedin-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" style="margin-top:15px; display: inline-block;" href="https://www.linkedin.com/search/results/index/?keywords='.urlencode($adv_caller_name).'&origin=GLOBAL_SEARCH_HEADER">Search on Linkedin</a><br/></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px;"><img src="'.base_url('images/twitter-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" style="margin-top:15px; display: inline-block;" href="https://twitter.com/search?q='.urlencode($adv_caller_name).'&src=typd">Search on Twitter</a><br/></td>
                                    </tr>                                
                        </table>

                        </div>
                    </div>  
                 </div> ';

        return $message;
    }
}

if ( ! function_exists('ct_get_phone_details'))
{


    function ct_get_phone_details($from_call, &$tw_client, $cost = 0, &$userData = false)
    {
        $CI =& get_instance(); 
            try{
                $number = $tw_client->lookups
                    ->phoneNumbers($from_call)
                    ->fetch(
                        array(
                            "type" => array("carrier", "caller-name"),
                            "addOns" => "nextcaller_advanced_caller_id"
                        )
                    );
            }
            catch(\Twilio\Exceptions\RestException $e){
            	return array('is_error' => $e->getMessage());
            }
            $caller_details = $number->addOns['results']['nextcaller_advanced_caller_id']['result']['records'][0];

            $phone = $caller_details['phone'];
            if (!empty($phone)) {
                $phn = '';
                for ($h = 0; $h < count($phone); $h++) {
                    foreach ($phone[$h] as $key => $value) {
                        $phn .= "$key=$value#";
                    }
                    $phn_details = $phn;
                }
            }

            $address = $caller_details['address'];
            if (!empty($address)) {
                $add = '';
                for ($i = 0; $i < count($address); $i++) {
                    foreach ($address[$i] as $key => $value) {
                        $add .= "$key=$value#";
                    }
                    $address_det = $add;
                }
                //echo '<br>add_details='.$add_details;
            }
            $carrier = $number->carrier;
            if (!empty($carrier)) {
                $carrierde = '';
                foreach ($carrier as $key => $value) {
                    $carrierde .= "$key=$value#";
                }
                $carrierdetails = $carrierde;
            }
            $linked_emails = $caller_details['linked_emails'];
            //print_r($linked_emails);
            if (!empty($linked_emails)) {
                $emails = '';
                foreach ($linked_emails as $key => $value) {
                    $emails .= "$key=$value#";
                }
                $linkedemails = $emails;
                //echo $linkedemails;
            }
            $social_links = $caller_details['social_links'];
            if (!empty($social_links)) {
                $links = '';
                for ($l = 0; $l < count($social_links); $l++) {
                    foreach ($social_links[$l] as $key => $value) {
                        $links .= "$key=$value#";
                    }
                    $sociallinks = $links;
                }
            }
            $InsertData = array();
            $request_sid = $number->addOns['results']['nextcaller_advanced_caller_id']['request_sid'];
            $phone_carrier = $number->carrier["name"] ? $number->carrier["name"] : '';
            $phone_line_type = $number->carrier["type"] ? $number->carrier["type"] : '';
            $countryCode = $number->countryCode ? $number->countryCode : '';
            $nationalFormat = $number->nationalFormat ? $number->nationalFormat : '';
            $phoneNumber = $number->phoneNumber;
            $status = $number->addOns['results']['nextcaller_advanced_caller_id']['status']; //$number->addOns['status']? $number->addOns['status'] : '';
            $code = $number->addOns['code'] ? $number->addOns['code'] : '';
            $carrier = $number->carrier['mobile_country_code'] ? $number->carrier['mobile_country_code'] : '';
            $caller_name = $number->callerName['caller_name'] ? $number->callerName['caller_name'] : '';
            $caller_type = $number->callerName['caller_type'] ? $number->callerName['caller_type'] : '';
            $error_code = $number->addOns['error_code'] ? $number->addOns['error_code'] : '';
            $drow = ($caller_details);
            $to_call = $clientdetails2->phoneNumber;
            $first_name = $drow['first_name'] ? $drow['first_name'] : '';
            $middle_name = $drow['middle_name'] ? $drow['middle_name'] : '';
            $last_name = $drow['last_name'] ? $drow['last_name'] : '';
            $phone_carrier = $number->carrier["name"] ? $number->carrier["name"] : '';
            $phone_line_type = $number->carrier["type"] ? $number->carrier["type"] : '';
            $countryCode = $number->countryCode ? $number->countryCode : '';
            $nationalFormat = $number->nationalFormat ? $number->nationalFormat : '';
            $address_city = $drow['address'][0]['city'] ? $drow['address'][0]['city'] : '';  //implode("#",$drow['address']) ;
            $address_extended_zip = $drow['address'][0]['extended_zip'] ? $drow['address'][0]['extended_zip'] : '';
            $address_country = $drow['address'][0]['country'] ? $drow['address'][0]['country'] : '';
            $address_line1 = $drow['address'][0]['line1'] ? $drow['address'][0]['line1'] : '';
            $address_line2 = $drow['address'][0]['line2'] ? $drow['address'][0]['line2'] : '';
            $address_state = $drow['address'][0]['state'] ? $drow['address'][0]['state'] : '';
            $address_zip_code = $drow['address'][0]['zip_code'] ? $drow['address'][0]['zip_code'] : '';
            $call_date = date('Y-m-d H:i:s');
            $status = $number->addOns['results']['nextcaller_advanced_caller_id']['status']; //$number->addOns['status']? $number->addOns['status'] : '';
            $code = $number->addOns['code'] ? $number->addOns['code'] : '';
            $carrier = $number->carrier['mobile_country_code'] ? $number->carrier['mobile_country_code'] : '';
            $caller_name = $number->callerName['caller_name'] ? $number->callerName['caller_name'] : '';
            $caller_type = $number->callerName['caller_type'] ? $number->callerName['caller_type'] : '';
            $error_code = $number->addOns['error_code'] ? $number->addOns['error_code'] : '';
            //echo '<br> id = '.$drow['id'];
            ## extra lookup feilds
            $age = $drow['age'] ? $drow['age'] : '';
            $education = $drow['education'] ? $drow['education'] : '';
            $gender = $drow['gender'] ? $drow['gender'] : '';
            $high_net_worth = $drow['high_net_worth'] ? $drow['high_net_worth'] : '';
            $home_owner_status = $drow['home_owner_status'] ? $drow['home_owner_status'] : '';
            $household_income = $drow['household_income'] ? $drow['household_income'] : '';
            $length_of_residence = $drow['length_of_residence'] ? $drow['length_of_residence'] : '';
            $marital_status = $drow['marital_status'] ? $drow['marital_status'] : '';
            $market_value = $drow['market_value'] ? $drow['market_value'] : '';
            $occupation = $drow['occupation'] ? $drow['occupation'] : '';
            $error_code = $drow['error_code'] ? $drow['error_code'] : '';
            $presence_of_children = $drow['presence_of_children'] ? $drow['presence_of_children'] : '';
            $cost = (float) $cost;

            $InsertData123 = array(
                'request_sid' => $request_sid,
                'phoneNumber' => $phoneNumber,
                'to_call' => $to_call,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'phone_carrier' => $phone_carrier,
                'phone_line_type' => $phone_line_type,
                'countryCode' => $countryCode,
                'nationalFormat' => $nationalFormat,
                'phone_details' => $phn_details,
                'address_city' => $address_city,
                'address' => $address_det,
                'address_extended_zip' => $address_extended_zip,
                'address_country' => $address_country,
                'address_country' => $address_country,
                'address_line1' => $address_line1,
                'address_line2' => $address_line2,
                'address_state' => $address_state,
                'address_zip_code' => $address_zip_code,
                'call_date' => $call_date,
                'status' => $status,
                'code' => $code,
                'caller_name' => $caller_name,
                'caller_type' => $caller_type,
                'carrier' => $carrierdetails,
                'linked_emails' => $linkedemails,
                'social_links' => $sociallinks,
                'error_code' => $error_code,
                'age' => $age,
                'education' => $education,
                'gender' => $gender,
                'high_net_worth' => $high_net_worth,
                'home_owner_status' => $home_owner_status,
                'household_income' => $household_income,
                'length_of_residence' => $length_of_residence,
                'marital_status' => $marital_status,
                'market_value' => $market_value,
                'occupation' => $occupation,
                'presence_of_children' => $presence_of_children
            ); 

            if($userData!=false) {

                $charges = $CI->crud_model->fetch_package_pricing($userData->subscription_id);
                if($charges['is_subscription'] == 1 ) {
                    // Update +1 max_call_lookup
                    $CI->crud_model->update_subs_count($userData->client_id,'max_call_lookup');
                } else {
                    /* UPDATE BALANCE */
                    $cleint_Data['available_fund'] =  (float) round((float)$userData->available_fund,4) - $cost;
                    $CI->db->where('client_id',  $userData->client_id);
                    $CI->db->update('client', $cleint_Data);

                    $insert_data_pay['client_id'] =  $userData->client_id;
                    $insert_data_pay['payment_gross_amount'] =  -$cost;
                    $insert_data_pay['plan_name'] = 'payment_against_lookup_call';
                    $insert_data_pay['pay_meta']  = 'phonenumber='. $from_call;
                    $insert_data_pay['payment_date'] = date("Y-m-d");
                    $insert_data_pay['payment_time'] = date("H:i:s");
                    $CI->db->insert('client_payment_details', $insert_data_pay);
                }
                    $system_email = 'noreply@callertech.com';
                    $system_title = 'CallerTech';
                    /* SEND EMAIL ON LOOKUP */
                    /*$page_data['lookup_data'] = json_decode(json_encode($InsertData123), FALSE);
                    $emsg = ct_get_email_details($page_data);
                    $CI->email->set_mailtype("html");
                    $CI->email->from($system_email, $system_title);
                    $CI->email->to($userData->email);
                    $CI->email->subject('Advanced Demographic Reports');
                    $page_data['main_content'] = $emsg;
                    $e_msg = $CI->load->view('email/details', $page_data, true);
                    $CI->email->message($e_msg);
                    $CI->email->send();*/
            }

           $CI->db->insert('advanced_caller_details', $InsertData123);

            $InsertData123['is_error'] = false;
            return $InsertData123;
       
    }   
}