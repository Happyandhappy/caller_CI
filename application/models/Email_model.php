<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function notify_email($task = '' , $param2 = '' , $param3 = '' , $param4 = '' , $param5 = '')
    {
    	$email_sub		=	$this->db->get_where('email_template' , array('task' => $task))->row()->subject;
    	$email_msg		=	$this->db->get_where('email_template' , array('task' => $task))->row()->body;

    	// email notification for new project opening
    	if ($task == 'new_project_opening')
    	{
    		$client_id		=	$this->db->get_where('project' , array('project_code' => $param2))->row()->client_id;
    		$CLIENT_NAME	=	$this->db->get_where('client' , array('client_id' => $client_id))->row()->name;
    		$PROJECT_NAME	=	$this->db->get_where('project' , array('project_code' => $param2))->row()->title;
    		$PROJECT_LINK	=	base_url().'index.php?client/projectroom/wall/'.$param2;

    		$email_msg		=	str_replace('[CLIENT_NAME]' , $CLIENT_NAME , $email_msg);
    		$email_msg		=	str_replace('[PROJECT_NAME]' , $PROJECT_NAME , $email_msg);
    		$email_msg		=	str_replace('[PROJECT_LINK]' , $PROJECT_LINK , $email_msg);

    		$email_to		=	$this->db->get_where('client' , array('client_id' => $client_id))->row()->email;
            $this->do_email($email_msg , $email_sub , $email_to);
    	}

        // email notification for client account opening by admin
        if ($task == 'new_client_account_opening')
        {
            $client_id      =   $param2;
            $CLIENT_PASSWORD=   $param3;
            $CLIENT_NAME    =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->name;
            $CLIENT_EMAIL   =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->email;
            $SYSTEM_URL     =   base_url();

            $email_msg      =   str_replace('[CLIENT_NAME]' , $CLIENT_NAME , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);
            $email_msg      =   str_replace('[CLIENT_EMAIL]' , $CLIENT_EMAIL , $email_msg);
            $email_msg      =   str_replace('[CLIENT_PASSWORD]' , $CLIENT_PASSWORD , $email_msg);
            
            $email_to       =   $CLIENT_EMAIL;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

        // email notification for admin account opening by admin
        if ($task == 'new_admin_account_creation'){
            $admin_id       =   $param2;
            $ADMIN_PASSWORD =   $param3;
            $ADMIN_NAME     =   $this->db->get_where('admin' , array('admin_id' => $admin_id))->row()->name;
            $ADMIN_EMAIL    =   $this->db->get_where('admin' , array('admin_id' => $admin_id))->row()->email;
            $SYSTEM_URL     =   base_url();

            $email_msg      =   str_replace('[ADMIN_NAME]' , $ADMIN_NAME , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);
            $email_msg      =   str_replace('[ADMIN_EMAIL]' , $ADMIN_EMAIL , $email_msg);
            $email_msg      =   str_replace('[ADMIN_PASSWORD]' , $ADMIN_PASSWORD , $email_msg);
            
            $email_to       =   $ADMIN_EMAIL;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

        // email notification for confirmation of client account signup outside adminpanel 
        if ($task == 'new_client_account_confirm'){
            $client_id      =   $param2;
            $CLIENT_NAME    =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->name;
            $CLIENT_EMAIL   =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->email;
            $SYSTEM_URL     =   base_url();

            $email_msg      =   str_replace('[CLIENT_NAME]' , $CLIENT_NAME , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);
            
            $email_to       =   $CLIENT_EMAIL;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

    	// email notification for staff account opening by admin
    	if ($task == 'new_staff_account_opening')
    	{
    		$staff_id		=	$param2;
    		$STAFF_PASSWORD	=	$param3;
    		$STAFF_NAME		=	$this->db->get_where('staff' , array('staff_id' => $staff_id))->row()->name;
    		$STAFF_EMAIL	=	$this->db->get_where('staff' , array('staff_id' => $staff_id))->row()->email;
    		$SYSTEM_URL		=	base_url();

    		$email_msg		=	str_replace('[STAFF_NAME]' , $STAFF_NAME , $email_msg);
    		$email_msg		=	str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);
    		$email_msg		=	str_replace('[STAFF_EMAIL]' , $STAFF_EMAIL , $email_msg);
    		$email_msg		=	str_replace('[STAFF_PASSWORD]' , $STAFF_PASSWORD , $email_msg);
    		
    		$email_to		=	$STAFF_EMAIL;
            $this->do_email($email_msg , $email_sub , $email_to);
    	}

        // email notification for payment completion
        if ($task == 'payment_completion_notification')
        {

            $project_code         =    $param2;
            $project_milestone_id =    $param3;
            $email_receiver_type  =    $param4;
            $AMOUNT               =    $this->db->get_where('project_milestone' , array('project_milestone_id' => $project_milestone_id))->row()->amount;
            $PROJECT_NAME         =    $this->db->get_where('project' , array('project_code' => $project_code))->row()->title;
            $SYSTEM_PAYMENT_URL   =    base_url().'index.php?client/projectroom/payment/' . $param2;

            $email_msg      =   str_replace('[PROJECT_NAME]' , $PROJECT_NAME , $email_msg);
            $email_msg      =   str_replace('[AMOUNT]' , $AMOUNT , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_PAYMENT_URL]' , $SYSTEM_PAYMENT_URL , $email_msg);

            if ($email_receiver_type != 'admin') {
                $client_id      =   $this->db->get_where('project' , array('project_code' => $project_code))->row()->client_id;
                $email_to       =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->email;
                $this->do_email($email_msg , $email_sub , $email_to);
            }

            if ($email_receiver_type == 'admin') {
                $admins = $this->db->get('admin')->result_array();
                foreach($admins as $row) {
                    $email_to = $row['email'];
                    $this->do_email($email_msg , $email_sub , $email_to);
                }
            }
        }

        // email notification for new support ticket submission to admin
        if ($task == 'new_support_ticket_notify_admin')
        {

            $TICKET_CODE    =   $param2;
            $ADMIN_NAME     =   $this->db->get_where('admin' , array('admin_id' => 1))->row()->name;
            $SYSTEM_OPENED_TICKET_URL=    base_url().'index.php?admin/support_ticket/';

            $email_msg      =   str_replace('[TICKET_CODE]' , $TICKET_CODE , $email_msg);
            $email_msg      =   str_replace('[ADMIN_NAME]' , $ADMIN_NAME , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_OPENED_TICKET_URL]' , $SYSTEM_OPENED_TICKET_URL , $email_msg);

            $admins = $this->db->get('admin')->result_array();
            foreach($admins as $row) {
                $email_to = $row['email'];
                $this->do_email($email_msg , $email_sub , $email_to);
            }
        }

        // email notification for support ticket assign to staff
        if ($task == 'support_ticket_assign_staff')
        {

            $TICKET_CODE    =   $param2;
            $staff_id       =   $param3;
            $STAFF_NAME     =   $this->db->get_where('staff' , array('staff_id' => $staff_id))->row()->name;
            $SYSTEM_OPENED_TICKET_URL=    base_url().'index.php?staff/support_ticket/';

            $email_msg      =   str_replace('[TICKET_CODE]' , $TICKET_CODE , $email_msg);
            $email_msg      =   str_replace('[STAFF_NAME]' , $STAFF_NAME , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_OPENED_TICKET_URL]' , $SYSTEM_OPENED_TICKET_URL , $email_msg);

            $email_to       =   $this->db->get_where('staff' , array('staff_id' => $staff_id))->row()->email;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

        // email notification for new message notification
        if ($task == 'new_message_notification')
        {

            $message_id     =   $param2;
            $message_thread_code    =   $this->db->get_where('message' , array('message_id' => $message_id))->row()->message_thread_code;
            $message_thread_detail  =   $this->db->get_where('message_thread' , array('message_thread_code' => $message_thread_code))->row();

            $sender         =   $this->db->get_where('message' , array('message_id' => $message_id))->row()->sender;

            if ($message_thread_detail->sender == $sender)
                $reciever   =   $message_thread_detail->reciever;
            else if ($message_thread_detail->reciever == $sender)
                $reciever   =   $message_thread_detail->sender;

            $sender         =   explode('-' , $sender);
            $sender_type    =   $sender[0];
            $sender_id      =   $sender[1];
            $SENDER_NAME    =   $this->db->get_where($sender_type , array($sender_type.'_id' => $sender_id))->row()->name;
            $MESSAGE        =   $this->db->get_where('message' , array('message_id' => $message_id))->row()->message;
            $SYSTEM_URL     =   base_url();

            $email_msg      =   str_replace('[SENDER_NAME]' , $SENDER_NAME , $email_msg);
            $email_msg      =   str_replace('[MESSAGE]' , $MESSAGE , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);

            $reciever       =   explode('-' , $reciever);
            $reciever_type  =   $reciever[0];
            $reciever_id    =   $reciever[1];
            $email_to       =   $this->db->get_where($reciever_type , array($reciever_type.'_id' => $reciever_id))->row()->email;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

        // email notification for rest password
        if ($task == 'password_reset_confirmation')
        {

            $account_type   =   $param2;
            $email          =   $param3;
            $NEW_PASSWORD   =   $param4;
            $NAME           =   $this->db->get_where($account_type , array('email' => $email))->row()->name;
            $SYSTEM_URL     =    base_url();

            $email_msg      =   str_replace('[NAME]' , $NAME , $email_msg);
            $email_msg      =   str_replace('[NEW_PASSWORD]' , $NEW_PASSWORD , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);

            $email_to       =   $email;
            $this->do_email($email_msg , $email_sub , $email_to);
        }

}

    
	
	/***custom email sender****/
	function do_email($msg=NULL, $sub=NULL, $to=NULL, $from=NULL, $attachment_url=NULL)
	{
		
		$config = array();
        $config['useragent']		= "CodeIgniter";
        $config['mailpath']		= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']		= "smtp";
        $config['smtp_host']		= "localhost";
        $config['smtp_port']		= "25";
        $config['mailtype']		= 'html';
        $config['charset']		= 'utf-8';
        $config['newline']		= "\r\n";
        $config['wordwrap']		= TRUE;

        $this->load->library('email');

        $this->email->initialize($config);

		$system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
		if ($from == NULL)
			$from		=	$this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;
		
		// attachment
		if ($attachment_url != NULL)
			$this->email->attach( $attachment_url );
			
		$this->email->from($from, $system_name);
		$this->email->from($from, $system_name);
		$this->email->to($to);
		$this->email->subject($sub);
		
		$this->email->message($msg);
		
		return $this->email->send();
		
		//echo $this->email->print_debugger();
	}
}

