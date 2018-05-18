<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Payment extends CT_Base_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    public function index() {
    }
    function pay_invoice() {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        $method = $this->input->post('method');
        if ($method == 'paypal')
            $this->paypal_payment();
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

            $prom_Data['used_count'] = $promo['used_count']+1;
            $this->db->where('promo_id', $promo['promo_id'] );
            $this->db->update('ct_promos', $prom_Data);

            $cjen = $cjena;
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
        return $cjena;

    }
    // param1 = project_milestone_id
    function paypal_payment($plan_id = '',$amount=0) {
		if(isset($_REQUEST['buyNumberAmountPay'])){
			$signupSession 			= $this->session->userdata('signupData');
			$invoice_title          =  'payment_against_number_purchase-'.$_REQUEST['phonenumber'].'-'.$_REQUEST['country'] ;
			$total_amount           =   $_REQUEST['number_price'];
			$project_code           =   0; 
			$paypal_email           =   $this->db->get_where('settings', array('type' => 'paypal_email'))->row()->description;
			$currency_code          =   'USD';
		}else{
			$signupSession 			= $this->session->userdata('signupData');
			$invoice_title          =  'Subscriptions';
			$total_amount           =   $signupSession['plan_amount'];
             
            if(isset($signupSession['promocode']) && $signupSession['promocode']!='') {
                $total_amount           =   $this->withPromo($signupSession['plan_amount'],$signupSession['promocode'],$signupSession['plan_id']);
                $signupSession['plan_amount'] = $total_amount;
            }
            $this->session->set_userdata('signupData',$signupSession);
            if($total_amount<=0) {
                redirect(base_url() . 'signup/owner_subscription_payment', 'refresh');
                die();
            }

			$project_code           =   $signupSession['plan_id'];
			$paypal_email           =   $this->db->get_where('settings', array('type' => 'paypal_email'))->row()->description;
			$system_currency_id     =   $this->db->get_where('settings' , array('type'=>'system_currency_id'))->row()->description;
			$currency_code          =   $this->db->get_where('currency' , array('currency_id'=>$system_currency_id))->row()->currency_code;
		}
        $this->paypal->add_field('plan_id', $project_code);
		$this->paypal->add_field('plan_title', $invoice_title);
        $this->paypal->add_field('item_name','Subscriptions');//$invoice_title
        $this->paypal->add_field('amount', $total_amount);
        $this->paypal->add_field('currency_code', $currency_code);
        $this->paypal->add_field('custom', $project_code);
        $this->paypal->add_field('business', $paypal_email);
        $this->paypal->add_field('cancel_return',base_url() . 'index.php/home');
		
		$this->paypal->add_field('a3',$total_amount); // trail Period Amount
		$this->paypal->add_field('p3',1); // Second Period M=montrh,Y=year ,D=Days, W='week'
		$this->paypal->add_field('t3','M'); // Second Cycle
		$this->paypal->add_field('cmd','_xclick-subscriptions'); // Second Cycle
		$this->paypal->add_field('src',1); // Second Period M=montrh,Y=year ,D=Days, W='week'
		$this->paypal->add_field('sra',1); // Second Cycle
        $this->paypal->add_field('reattempt',1); // reattempt
		$this->paypal->add_field('no_shipping',1); // Second Cycle
		$this->paypal->add_field('no_note',1); // Second Cycle
		$this->paypal->add_field('upload',1);
		$this->paypal->add_field('address_override',1);
		$this->paypal->add_field('rm',2);
		$this->paypal->add_field('notify_url', base_url() . 'paypalipn/ipn_response');
		
		/*if(isset($_REQUEST['buyNumberAmountPay'])){
			$this->paypal->add_field('return', base_url() . 'base/purchase_phonenumber_excess_payment');
		}else*/{
			$this->paypal->add_field('return', base_url() . 'signup/owner_subscription_payment');
		}
        $this->paypal->submit_paypal_post();
    }
    function topup_payment($plan_id = '',$amount=0) {
		$signupSession = $this->session->userdata('login_user_id');
        $invoice_title          =  'usage_topup_payment';
		$total_amount           = $this->input->post('topup_amount');
        $project_code           =   $this->session->userdata('login_user_id');
        $paypal_email           =   $this->db->get_where('settings', array('type' => 'paypal_email'))->row()->description;
        $system_currency_id     =   $this->db->get_where('settings' , array('type'=>'system_currency_id'))->row()->description;
        $currency_code          =   $this->db->get_where('currency' , array('currency_id'=>$system_currency_id))->row()->currency_code;
		//print_r($this->session->userdata('signupdata'));exit;
        /** **TRANSFERRING USER TO PAYPAL TERMINAL*** */
        $this->paypal->add_field('plan_id', $project_code);
		$this->paypal->add_field('plan_title', $invoice_title);
        $this->paypal->add_field('item_name', $invoice_title);
        $this->paypal->add_field('amount', $total_amount);
        $this->paypal->add_field('currency_code', $currency_code);

        $this->paypal->add_field('reattempt',1); // reattempt

        $this->paypal->add_field('custom', $project_code);
        $this->paypal->add_field('business', $paypal_email);
        $this->paypal->add_field('notify_url', base_url() . 'clientuser/purchase_usage_topup');
        $this->paypal->add_field('cancel_return',base_url() . 'index.php/home');
	    $this->paypal->add_field('return', base_url() . 'clientuser/dashboard');
        $this->paypal->submit_paypal_post();
    }
    function paypal_ipn() {
        if ($this->paypal->validate_ipn() == true) {
            $ipn_response = '';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $ipn_response .= "\n$key=$value";
            }
            $project_milestone_id    =  $_POST['custom'];			
            $data2['type']           =   'income';
            $data2['amount']         =   '15';
            $data2['title']          =   'Test Here';
            $data2['payment_method'] =   'paypal';
            $data2['description']    =   $ipn_response;
            $data2['project_code']   =   '15 Test';
            $data2['timestamp']      =   strtotime(date("m/d/Y"));
            $data2['milestone_id']   =   $project_milestone_id;
            $data2['client_id']      =   '';
           // $this->db->insert('payment', $data2);			
           // $this->email_model->notify_email('payment_completion_notification', $data2['project_code'] , $project_milestone_id , 'admin');
        }
    }
}