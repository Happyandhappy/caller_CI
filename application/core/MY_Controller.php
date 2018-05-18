<?php
/*
 * MY_Controller.php - All custom base controllers are here, from which the rest are extended.
 * -------------------------------------------------------------------------------------------
 *
 */


/*
 * Custom Controller Base - CT_Base_Controller
 * 
 * Loads all libraries, helpers and modals that are in use by the app.
 * I recommend you do not use this Controller as a base since it is rather.. slow.
 *
**/

class CT_Base_Controller extends CI_Controller
{

    protected $TwilioSettings;
    protected $SiteSettings;
    protected $messagingTypes;
    protected $system_title;
    protected $system_noreplymail;

    public $current_client_id;
    public $current_client;
    public $current_client_numbers;
    
    function __construct()
    {
        parent::__construct();
        
        // load libraries
        $this->load->library(
          array(
            'session',
            'pagination',
            'xmlrpc',
            'form_validation',
            'email',
            'paypal'
          )
        );

        // load helpers
        $this->load->helper(
          array(
            'url',
            'file',
            'form',
            'security',
            'string',
            'inflector',
            'directory',
            'download',
            'date_format',
            'twilio_handlers',
            'multi_language'
          )
        );


        // load models
        $this->load->model(
          array(
            'bulktext',
            'crud_model',
            'email_model'
          )
        );
         /* FIlE TYPE FOR MESSAGINS */
         $this->messagingTypes['image'] = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png',
                'image/bmp'
            );
         $this->messagingTypes['audio'] = array(
                'audio/basic',
                'audio/L24',
                'audio/mp4',
                'audio/mpeg',
                'audio/ogg',
                'audio/vorbis',
                'audio/vnd.rn-realaudio',
                'audio/vnd.wave',
                'audio/3gpp',
                'audio/3gpp2',
                'audio/ac3',
                'audio/vnd.wave',
                'audio/webm',
                'audio/amr-nb',
                'audio/amr',
            );
         $this->messagingTypes['movie'] = array(
                'video/mpeg',
                'video/mp4',
                'video/quicktime',
                'video/webm',
                'video/3gpp',
                'video/3gpp2',
                'video/3gpp-tt',
                'video/H261',
                'video/H263',
                'video/H263-1998',
                'video/H263-2000',
                'video/H264',
            );
         $this->messagingTypes['text'] = array(
                'text/vcard',
                'text/csv',
                'text/rtf',
                'text/richtext',
                'text/calendar'
            );
         $this->messagingTypes['pdf'] = array(
                'application/pdf'
            );


        /*cache control*/
        /*
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
        */


        $this->load->database(); // load database

        $this->current_client_id = intval($this->session->userdata('login_user_id'));
        if($this->current_client_id>0) {
            $this->current_client = $this->db->where('client_id', $this->current_client_id)->get('client')->row();  
            $this->current_client_numbers = $this->db->where('status','active')->where('client_id', $this->current_client_id)->get('client_phonenumber_purchased')->result();   
        }

        $tamo['settings']   = $this->db->get('settings')->result_array();
        $noviset = new stdClass();
        foreach($tamo['settings']  as $sets) {
            $noviset->{$sets['type']} = $sets['description'];
        }

        $this->TwilioSettings['AccountSID'] = $noviset->account_sid;
        $this->TwilioSettings['AccountAuthToken'] = $noviset->account_token;
        $this->SiteSettings['system_name'] = $noviset->system_name;
        $this->SiteSettings['system_title'] =$noviset->system_title;
        $this->system_title = $noviset->system_title;
        $this->system_noreplymail = 'noreply@callertech.com';
      
    }

    protected function isAllowedType($tip) {
        foreach($this->messagingTypes as $tp => $vrijed) {
            foreach ($vrijed as $vr) {
                if($vr==$tip)
                    return true;
            }
        }
        return false;
    }
    protected function getAllowedTypes() {
        $lista = array();
        foreach($this->messagingTypes as $tp => $vrijed) {
            foreach ($vrijed as $vr) {
                $sam = explode("/",$vr);
                $lista[] = $sam[1];
            }
        }
        return implode("|",$lista);
    }
    protected function getAllowedTypesGroup($group) {
        $lista = array();
        foreach($this->messagingTypes[$group] as $tp => $vrijed) {
            foreach ($vrijed as $vr) {
                $sam = explode("/",$vr);
                $lista[] = $sam[1];
            }
        }
        return implode("|",$lista);
    }
    protected function getTypeGroup($tip) {
        foreach($this->messagingTypes as $tp => $vrijed) {
            foreach ($vrijed as $vr) {
                if($vr==$tip)
                    return $tp;
            }
        }
        return false;
    }
    protected function format_international_number($num) {
        $brojtel = trim($num);
        
        if(substr($brojtel,0,1)=='1' && strlen($brojtel)==11) {
            $brojtel = '+'.$brojtel;
        }
        if(substr($brojtel[0],0,1)!='+') {

            $froms_call = str_replace('-', '', $brojtel);
            $froms_call = str_replace(' ', '', $froms_call);
            $froms_call = str_replace('(', '', $froms_call);
            $froms_call = str_replace(')', '', $froms_call);
            $brojtel = '+1'.trim($froms_call); 
        }
        return $brojtel;
    }
    protected function format_local_number($num) {
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $num,  $matches ) )
        {
            $result = '('.$matches[1] . ')'.' ' .$matches[2] . '-' . $matches[3];
            return $result;
        }else {
            return $num;
        }
    }
}


/*
 * Custom Controller Base - CT_API_Controller
 * 
 * Used in the client-api.
 *
**/



class CT_API_Controller extends CI_Controller
{

    protected $TwilioSettings;


    function __construct()
    {
        parent::__construct();
        
        // load libraries
        $this->load->library(
          array(/*
            'session',
            'xmlrpc',
            */
          )
        );

        // load helpers
        $this->load->helper(
          array(/*
            'url'
            */
          )
        );



        $this->load->database(); // load database
        $this->TwilioSettings['AccountSID'] = $this->db->get_where('settings', array('type' => 'account_sid'))->row()->description;
        $this->TwilioSettings['AccountAuthToken'] = $this->db->get_where('settings', array('type' => 'account_token'))->row()->description;
    }
}