<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;

class Cron extends CT_Base_Controller
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

         if(!$this->input->is_cli_request())
         { 
           echo 'Not allowed';
           exit();
         }

    }

    public function monthly_reactivate() {

    }


    public function send_weekly_report() {

        $prviD = $danas = time();
        $sedmicaPrije = $danas - (3600*24*7);
        $i=0;
        $sedmicaDan = $sedmicaSati = array();
        while($prviD>=$sedmicaPrije) {
            $sedmicaDan[$i] = date('Y-m-d',$prviD);
            $sedmicaSati[$i] = $prviD;
            $prviD = $prviD - (3600*24);
            $i++;
        }
        //var_dump($sedmicaDan); 

        $this->db->select('*');
        $this->db->from('client');
        $this->db->where(array(
            'email_verified' => '1'
        ));
        $list_clients = $this->db->get()->result_array();
        $brojacMejlova = 0;
        foreach ($list_clients as $cl) {
            $prije = $poruka = '';
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased');
            $this->db->where(array(
                'client_id' => $cl['client_id']
            ));
            $phnums = $this->db->get()->result_array();
            $prije = '<div class="row">
                <h2 style="text-align:center;margin-bottom:25px;"> Your <b>Weekly Report</b> for '.ct_format_get_date($sedmicaPrije).' '.ct_format_get_date($danas).'</h2>
                </div>';

            /* loop client numbers to make email info*/
           // echo '<b>Report for: '.  $cl['client_id'].' - '.  $cl['email'].'</b> '.ct_format_get_date($sedmicaPrije).' - '.ct_format_get_date($danas).', thanks for using our services!'.'<br/>';
            foreach ($phnums as $numbr) {
                 //echo '<b>Broj:'.$numbr['phoneNumber'].'</b><br/>';

                $this->db->select('COUNT(*) as broj'); 
                $this->db->from('ct_messages');   
                $this->db->where('direction', 'out');
                $this->db->where('from', $numbr['phoneNumber']);

                $datum_wh = array();
                foreach($sedmicaDan as $dan)
                    $datum_wh[] = "`date` = '".$dan."'";
                if( ! empty($datum_wh) )
                    $this->db->where('('.(implode(" OR ",$datum_wh)).')');

                $rez = $this->db->get()->result_array();
                $brojPoslanih = $rez[0]['broj'];


                $this->db->select('COUNT(*) as broj'); 
                $this->db->from('ct_messages');   
                $this->db->where('direction', 'in');
                $this->db->where('to', $numbr['phoneNumber']);
                $datum_wh = array();
                foreach($sedmicaDan as $dan)
                    $datum_wh[] = "`date` = '".$dan."'";
                if( ! empty($datum_wh) )
                    $this->db->where('('.(implode(" OR ",$datum_wh)).')');

                $rez = $this->db->get()->result_array();
                $brojPrimljenih = $rez[0]['broj'];

                $this->db->select('COUNT(*) as broj, SUM(Duration) as dur'); 
                $this->db->from('incoming_call_details');   
                $this->db->where('Called', $numbr['phoneNumber']);
                $this->db->where('client_id', $cl['client_id']);
                $this->db->where('Direction', 'inbound');
                $this->db->where('CallStatus', 'completed');

                $datum_wh = array();
                foreach($sedmicaDan as $dan)
                    $datum_wh[] = "`Timestamp` = '".$dan."'";
                if( ! empty($datum_wh) )
                    $this->db->where('('.(implode(" OR ",$datum_wh)).')');

                $rez = $this->db->get()->result_array();
                $brojPoziva = $rez[0]['broj'];
                $brojMinuta = $rez[0]['dur'];

                $this->db->select('COUNT(*) as broj, SUM(Duration) as dur'); 
                $this->db->from('incoming_call_details');   
                $this->db->where('Called', $numbr['phoneNumber']);
                $this->db->where('client_id', $cl['client_id']);
                $this->db->where('Direction', 'outbound-dial');
                $this->db->where('CallStatus', 'completed');

                $datum_wh = array();
                foreach($sedmicaDan as $dan)
                    $datum_wh[] = "`Timestamp` = '".$dan."'";
                if( ! empty($datum_wh) )
                    $this->db->where('('.(implode(" OR ",$datum_wh)).')');

                $rez = $this->db->get()->result_array();
                $brojMinuta = $brojMinuta +intval($rez[0]['dur']);

                 //var_dump($this->db->last_query());
               /* echo 'Broj Poslanih Poruka: '.$brojPoslanih.'<br/>';
                echo 'Broj Primljenih Poruka: '.$brojPrimljenih.'<br/>';
                echo 'Broj Dolaznih Poziva: '.$brojPoziva.'<br/>';
                echo 'Broj Minuta: '.$brojMinuta.'<br/>';*/

                $poruka .= '<div class="row">
                <h4>  ' . ct_format_nice_number( $numbr['phoneNumber'] ) .' '.$numbr['campaign_name'].'</h4>

                    <div class="col-md-6">
                        <h5 class="box-inline">Incoming Calls:</h5> <span style="float:right"> '.$brojPoslanih.'</span>
                    </div>
                    <div class="col-md-6">
                        <h5 class="box-inline">Call Minutes:</h5> <span style="float:right"> '.$brojMinuta.'</span>
                    </div>

                    <div class="col-md-6">
                        <h5 class="box-inline">Incoming Texts:</h5> <span style="float:right"> '.$brojPrimljenih.'</span>
                    </div>
                    <div class="col-md-6">
                        <h5 class="box-inline">Outgoing Texts:</h5> <span style="float:right"> '.$brojPoslanih.'</span>
                    </div>

                </div>
                <hr style="margin:5px; margin-bottom:15px;"/>';

            }

            /* Send Email */
                $system_email = $this->system_noreplymail;
                $system_title = $this->system_title;
                $this->email->set_mailtype("html");
                $this->email->from($system_email, $system_title);
                $this->email->to(strtolower($cl['email']));
    
                if(isset($cl['second_email']) && $cl['second_email']!='')
                    $this->email->bcc(strtolower($cl['email']));
    
                $this->email->subject('Weekly Report on '.ct_format_get_weekly_date($danas,$sedmicaPrije) );
                $page_data['main_content'] = $prije.$poruka;
                $e_msg = $this->load->view('email/details', $page_data, true);
                $this->email->message($e_msg);
                //echo $e_msg;
               if( !empty($poruka) ) {
                $brojacMejlova++;
                if( $brojacMejlova > 12 )  {
                     sleep(1);
                     $brojacMejlova = 0;
                }

                    $this->email->send();
               }

            /* /--- Send Email */
        }
    }



}