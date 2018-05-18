<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 *  PayPal IPN Listener
 *
 *  A class to listen for and handle Instant Payment Notifications (IPN) from 
 *  the PayPal server.
 *
 *  https://github.com/Quixotix/PHP-PayPal-IPN
 *
 *  @package    PHP-PayPal-IPN
 *  @author     Micah Carrick
 *  @copyright  (c) 2012 - Micah Carrick
 *  @version    2.1.0
 */

class IpnListener {
    
    /**
     *  If true, the recommended cURL PHP library is used to send the post back 
     *  to PayPal. If flase then fsockopen() is used. Default true.
     *
     *  @var boolean
     */
    public $use_curl = true;     
    
    /**
     *  If true, explicitly sets cURL to use SSL version 3. Use this if cURL
     *  is compiled with GnuTLS SSL.
     *
     *  @var boolean
     */
    public $force_ssl_v3 = true;     
   
    /**
     *  If true, cURL will use the CURLOPT_FOLLOWLOCATION to follow any 
     *  "Location: ..." headers in the response.
     *
     *  @var boolean
     */
    public $follow_location = false;     
    
    /**
     *  If true, an SSL secure connection (port 443) is used for the post back 
     *  as recommended by PayPal. If false, a standard HTTP (port 80) connection
     *  is used. Default true.
     *
     *  @var boolean
     */
    public $use_ssl = true;      
    
    /**
     *  If true, the paypal sandbox URI www.sandbox.paypal.com is used for the
     *  post back. If false, the live URI www.paypal.com is used. Default false.
     *
     *  @var boolean
     */
    public $use_sandbox = false; 
    
    /**
     *  The amount of time, in seconds, to wait for the PayPal server to respond
     *  before timing out. Default 30 seconds.
     *
     *  @var int
     */
    public $timeout = 30;       
    
    private $post_data = array();
    private $post_uri = '';     
    private $response_status = '';
    private $response = '';

    const PAYPAL_HOST = 'www.paypal.com';
    const SANDBOX_HOST = 'www.sandbox.paypal.com';
    
    /**
     *  Post Back Using cURL
     *
     *  Sends the post back to PayPal using the cURL library. Called by
     *  the processIpn() method if the use_curl property is true. Throws an
     *  exception if the post fails. Populates the response, response_status,
     *  and post_uri properties on success.
     *
     *  @param  string  The post data as a URL encoded string
     */
    protected function curlPost($encoded_data) {

        if ($this->use_ssl) {
            $uri = 'https://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        } else {
            $uri = 'http://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        }
        
        $ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, 
		            dirname(__FILE__)."/cert/api_cert_chain.crt");
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->follow_location);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        if ($this->force_ssl_v3) {
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        }
        
        $this->response = curl_exec($ch);
        $this->response_status = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        
        if ($this->response === false || $this->response_status == '0') {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
    }
    
    /**
     *  Post Back Using fsockopen()
     *
     *  Sends the post back to PayPal using the fsockopen() function. Called by
     *  the processIpn() method if the use_curl property is false. Throws an
     *  exception if the post fails. Populates the response, response_status,
     *  and post_uri properties on success.
     *
     *  @param  string  The post data as a URL encoded string
     */
    protected function fsockPost($encoded_data) {
    
        if ($this->use_ssl) {
            $uri = 'ssl://'.$this->getPaypalHost();
            $port = '443';
            $this->post_uri = $uri.'/cgi-bin/webscr';
        } else {
            $uri = $this->getPaypalHost(); // no "http://" in call to fsockopen()
            $port = '80';
            $this->post_uri = 'http://'.$uri.'/cgi-bin/webscr';
        }

        $fp = fsockopen($uri, $port, $errno, $errstr, $this->timeout);
        
        if (!$fp) { 
            // fsockopen error
            throw new Exception("fsockopen error: [$errno] $errstr");
        } 

        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Host: ".$this->getPaypalHost()."\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".strlen($encoded_data)."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        
        fputs($fp, $header.$encoded_data."\r\n\r\n");
        
        while(!feof($fp)) { 
            if (empty($this->response)) {
                // extract HTTP status from first line
                $this->response .= $status = fgets($fp, 1024); 
                $this->response_status = trim(substr($status, 9, 4));
            } else {
                $this->response .= fgets($fp, 1024); 
            }
        } 
        
        fclose($fp);
    }
    
    private function getPaypalHost() {
        if ($this->use_sandbox) return self::SANDBOX_HOST;
        else return self::PAYPAL_HOST;
    }
    
    /**
     *  Get POST URI
     *
     *  Returns the URI that was used to send the post back to PayPal. This can
     *  be useful for troubleshooting connection problems. The default URI
     *  would be "ssl://www.sandbox.paypal.com:443/cgi-bin/webscr"
     *
     *  @return string
     */
    public function getPostUri() {
        return $this->post_uri;
    }
    
    /**
     *  Get Response
     *
     *  Returns the entire response from PayPal as a string including all the
     *  HTTP headers.
     *
     *  @return string
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     *  Get Response Status
     *
     *  Returns the HTTP response status code from PayPal. This should be "200"
     *  if the post back was successful. 
     *
     *  @return string
     */
    public function getResponseStatus() {
        return $this->response_status;
    }
    
    /**
     *  Get Text Report
     *
     *  Returns a report of the IPN transaction in plain text format. This is
     *  useful in emails to order processors and system administrators. Override
     *  this method in your own class to customize the report.
     *
     *  @return string
     */
    public function getTextReport() {
        
        $r = '';
        
        // date and POST url
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n[".date('m/d/Y g:i A').'] - '.$this->getPostUri();
        if ($this->use_curl) $r .= " (curl)\n";
        else $r .= " (fsockopen)\n";
        
        // HTTP Response
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n{$this->getResponse()}\n";
        
        // POST vars
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n";
        
        foreach ($this->post_data as $key => $value) {
            $r .= str_pad($key, 25)."$value\n";
        }
        $r .= "\n\n";
        
        return $r;
    }
    
    /**
     *  Process IPN
     *
     *  Handles the IPN post back to PayPal and parsing the response. Call this
     *  method from your IPN listener script. Returns true if the response came
     *  back as "VERIFIED", false if the response came back "INVALID", and 
     *  throws an exception if there is an error.
     *
     *  @param array
     *
     *  @return boolean
     */    
    public function processIpn($post_data=null) {

        $encoded_data = 'cmd=_notify-validate';
        
        if ($post_data === null) { 
            // use raw POST data 
            if (!empty($_POST)) {
                $this->post_data = $_POST;
                $encoded_data .= '&'.file_get_contents('php://input');
            } else {
                throw new Exception("No POST data found.");
            }
        } else { 
            // use provided data array
            $this->post_data = $post_data;
            
            foreach ($this->post_data as $key => $value) {
                $encoded_data .= "&$key=".urlencode($value);
            }
        }

        if ($this->use_curl) $this->curlPost($encoded_data); 
        else $this->fsockPost($encoded_data);
        
        if (strpos($this->response_status, '200') === false) {
            throw new Exception("Invalid response status: ".$this->response_status);
        }
        
        if (strpos($this->response, "VERIFIED") !== false) {
            return true;
        } elseif (strpos($this->response, "INVALID") !== false) {
            return false;
        } else {
            throw new Exception("Unexpected response from PayPal.");
        }
    }
    
    /**
     *  Require Post Method
     *
     *  Throws an exception and sets a HTTP 405 response header if the request
     *  method was not POST. 
     */    
    public function requirePostMethod() {
        // require POST requests
        if ($_SERVER['REQUEST_METHOD'] && $_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Allow: POST', true, 405);
            throw new Exception("Invalid HTTP request method.");
        }
    }
}


class Paypalipn extends CT_Base_Controller {

function __construct() {
	parent::__construct();
	$this->load->database();
	/* cache control */
	$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
	$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	$this->output->set_header('Pragma: no-cache');
}

function ipn($im_debut_ipn,$req) {
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	//if (!preg_match('/paypal\.com$/', $hostname)) {
	    $this->email->from('noreply@callertech.com');
	    $this->email->to('golubicedis@gmail.com');
	    $this->email->subject('IPN Request');
	    $e_msg = 'Check Path '.dirname(__FILE__)."/cert/api_cert_chain.crt";
	    $this->email->message($e_msg);
	    $posl = $this->email->send();
		$ipn_status = 'Validation post isn\'t from PayPal';
		return false;
	 //}

	$listener = new IpnListener();
	$listener->use_sandbox = false;

	$verified = false;
	
	try {
	    $verified = $listener->processIpn();
	} catch (Exception $e) {
	    // fatal error trying to process IPN.
	    exit(0);
	}
	return $verified;

}

function ipn_response() {
 	$request =$_REQUEST;
	$timeRequest = time();
	 $im_debut_ipn=true;
	 if ($this->ipn($im_debut_ipn,false)) {
	 // if paypal sends a response code back let's handle it
		 if ($im_debut_ipn == true) {
			 $sub = 'PayPal IPN Debug Email Main';
			 $msg = print_r($request, true);
			 $aname = 'callertech';
		 	//mail send
		 }
	// process the membership since paypal gave us a valid +
		if($request['txn_type'] == 'subscr_cancel'){
			$this->deactiveAcOnSubsCancel($request['subscr_id']);
		} else if($request['txn_type'] == 'subscr_payment')
			$this->insert_data($request);
   }
}

function issetCheck($post,$key){
	if(isset($post[$key])){
		$return=$post[$key];
	}else{
		$return='';
	}
	return $return;
}
function insert_data($request){
	$post = $request;

	if(isset($request['subscr_id']))
 	$usr_pinf = $this->db->get_where('client_payment_details' , array('payment_txn_id' => $request['subscr_id']))->row();

	    $this->email->from('noreply@callertech.com');
	    $this->email->to('golubicedis@gmail.com');
	    $this->email->subject('IPN Insert - Inf');
	    $e_msg = 'Inserting data for request'.print_r($usr_pinf,true);
	    $this->email->message($e_msg);
	    $posl = $this->email->send();
	    

 	if(!empty($usr_pinf))
 	$usr_proc = $this->db->get_where('client_payment_details' , array('proc_txn_id' => $request['txn_id']))->row();

	if(!empty($usr_pinf) && empty($usr_proc)) {
            $clientID = $usr_pinf->client_id;
  			$page_data['proc_txn_id']       =  $request["txn_id"];// test
  			$page_data['buyer_first_name']       =  $request["first_name"];// test
            $page_data['buyer_last_name']        =  $request["last_name"];// buyer
            $page_data['payer_address_country']  =  $request["residence_country"];// United Kingdom
            $page_data['payment_payer_email']    =  $request["payer_email"];// alttestdemo-buyer@gmail.com
            $page_data['payment_status']         =  $request['payer_status'];
            $page_data['payment_txn_id']         =  $request["subscr_id"];// 93172640FX364415P //seller
            $page_data['payment_receiver_email'] =  $request["receiver_email"];// alttestdemo-facilitator@gmail.com
            $page_data['payment_fee']            =  '0';//$_POST["payment_fee"];// 1.75
            $page_data['payment_auth']           =  ($request["auth"] ? $request["auth"]: $usr_pinf->payment_auth); //
            $page_data['payment_mc_currency']    =  ($request["mc_currency"] ? $request["mc_currency"]: '-');
            $page_data['plan_name']              =  $usr_pinf->plan_name;
            $page_data['payment_gross_amount']   =  $usr_pinf->payment_gross_amount; //$request["amount3"];// 50.00
            $page_data['payment_date']           =  date('Y-m-d');// 03:08:27 Jun 20, 2016 PDT
            $page_data['qty']                    =  '1';//$_POST["quantity"];// 1
            $page_data['plan_id']                =  $usr_pinf->plan_id;// 1
            $page_data['client_id']              =  $usr_pinf->client_id;
            if($usr_pinf->payment_date != $page_data['payment_date'])
	            $this->db->insert('client_payment_details', $page_data);
	}
          
	//$this->email_model->notify_email('payment_completion_notification', $data2['project_code'] , $project_milestone_id , 'admin');
	/*$item_name= $this->issetCheck($post,'item_name');
	$amount= $this->issetCheck($post,'mc_gross');
	$currency= $this->issetCheck($post,'mc_currency');
	$payer_email= $this->issetCheck($post,'payer_email');
	$first_name=$this->issetCheck($post,'first_name');
	$last_name=$this->issetCheck($post,'last_name');
	$country=$this->issetCheck($post,'residence_country');
	$txn_id=$this->issetCheck($post,'txn_id');
	$txn_type=$this->issetCheck($post,'txn_type');
	$payment_status=$this->issetCheck($post,'payment_status');
	$payment_type=$this->issetCheck($post,'payment_type');
	$payer_id=$this->issetCheck($post,'payer_id');
	$create_date=date('Y-m-d H:i:s');
	$payment_date=date('Y-m-d H:i:s');
	
	mysqli_query($con,"INSERT INTO infotuts_transection_tbl (item_name,payer_email,first_name,last_name,amount,currency,country,txn_id,txn_type,payer_id,payment_status,payment_type,create_date,payment_date)
	VALUES ('$item_name','$payer_email','$first_name','$last_name','$amount','$currency','$country','$txn_id','$txn_type','$payer_id','$payment_status','$payment_type','$create_date','$payment_date')");
	mysqli_close($con);*/
	
 }
 
 public function deactiveAcOnSubsCancel($subscr_id){
 	$query = $this->db->get_where('client_payment_details' , array('payment_txn_id' => $subscr_id))->limit(1)->row();
	$updated = $this->db->update('client', array('status' => 2), array('client_id' => $query->client_id));
	return true;
 }
 
}
 //$obj = New PayPal_IPN();
 //$obj->ipn_response($_REQUEST);

 ?>