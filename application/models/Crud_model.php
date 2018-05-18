<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Crud_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function fetch_package_pricing($packageID,$type=''){
        $charges = $this->db->get_where('packages', array('package_id' => $packageID ))->row_array();
        return $charges;
    }
    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return    $this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;    
    }
    ////////private message//////
    function send_new_private_message() {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $reciever = $this->input->post('reciever');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;
        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);
        // notify email to email reciever
        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
        return $message_thread_code;
    }
    function send_reply_message($message_thread_code) {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);
        // notify email to email reciever
        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }
    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }
    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }
    ////////support ticket/////
    function create_support_ticket() {
        $data['title']          = $this->input->post('title');
        $data['ticket_code']    = substr(md5(rand(100000000, 20000000000)), 0, 15);
        $data['status']         = 'opened';
        $data['priority']       = $this->input->post('priority');
        $data['project_id']     = $this->input->post('project_id');
        $login_type             = $this->session->userdata('login_type');
        if($login_type == 'client')
            $data['client_id']  = $this->session->userdata('login_user_id');
        else 
            $data['client_id']  = $this->input->post('client_id');
        $data['timestamp']      = date("d M,Y");
        $this->db->insert('ticket', $data);
        // email notification check
        $this->email_model->notify_email('new_support_ticket_notify_admin', $data['ticket_code']);
        //creating ticket message
        $data2['ticket_code']   = $data['ticket_code'];
        $data2['message']       = $this->input->post('description');
        $data2['timestamp']     = date("d M,Y");
        $data2['sender_type']   = $this->session->userdata('login_type');
        $data2['sender_id']     = $this->session->userdata('login_user_id');
        if($_FILES['file']['name'] != '')
            $data2['file']          = $_FILES['file']['name'];
        $this->db->insert('ticket_message', $data2);
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
    }
    function insert_quotation($data){
        //echo "insert_quotation= ";print_r($data);
        $this->db->insert('trades_quotation', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
        }
    function delete_support_ticket($ticket_code) {
        $this->db->where('ticket_code', $ticket_code);
        $this->db->delete('ticket');
    }
    function post_ticket_reply($ticket_code) {
        $data['ticket_code']    = $ticket_code;
        $data['message']        = $this->input->post('message');
        $data['timestamp']      = date("d M,Y");
        $data['sender_type']    = $this->session->userdata('login_type');
        $data['sender_id']      = $this->session->userdata('login_user_id');
        if(isset($_FILES['file']['name']))
            $data['file']          = $_FILES['file']['name'];
        $this->db->insert('ticket_message', $data);
        if(isset($_FILES['file']['name']))
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
    }
    function support_ticket_assign_staff($ticket_code) {
        $data['assigned_staff_id'] = $this->input->post('staff_id');
        $this->db->where('ticket_code', $ticket_code);
        $this->db->update('ticket', $data);
        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('support_ticket_assign_staff', $ticket_code, $data['assigned_staff_id']);
    }
    function support_ticket_update_status($ticket_code) {
        $data['status'] = $this->input->post('status');
        $this->db->where('ticket_code', $ticket_code);
        $this->db->update('ticket', $data);
    }
    ////////note/////////
    function create_note() {
        $data['user_type']          =  $this->session->userdata('login_type');
        $data['user_id']            =  $this->session->userdata('login_user_id'); 
        $data['timestamp_create']   =  strtotime(date("d-m-Y H:i:s"));
        $this->db->insert('note' , $data);
        echo $this->db->insert_id();
    }
    function save_note($note_id = '') {
        $data['title']                 =   $this->input->post('title');
        $data['note']                  =   $this->input->post('note');
        $data['user_type']             =   $this->session->userdata('login_type');
        $data['user_id']               =   $this->session->userdata('login_user_id');
        $data['timestamp_last_update'] =  strtotime(date("d-m-Y H:i:s"));
        $this->db->where('note_id' , $note_id);
        $this->db->update('note' , $data); 
    }
    ////////note/////////
    function delete_note($note_id = '') {
        $this->db->where('note_id' , $note_id);
        $this->db->delete('note');
        // if note table becmoe blank, create a new note
        $this->db->where('user_type' , $this->session->userdata('login_type'));
        $this->db->where('user_id' , $this->session->userdata('login_user_id'));
        $this->db->from('note');
        $total_notes_of_current_user    =   $this->db->count_all_results();
        if ($total_notes_of_current_user == 0) {
            $this->create_note();
        }
    }
    ////////invoices/////////////
    function create_invoice() {
        $data['title'] = $this->input->post('title');
        $data['invoice_number'] = $this->input->post('invoice_number');
        $data['client_id'] = $this->input->post('client_id');
        $data['project_id'] = $this->input->post('project_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp'] = $this->input->post('due_timestamp');
        $data['vat_percentage'] = $this->input->post('vat_percentage');
        $data['discount_amount'] = $this->input->post('discount_amount');
        $data['status'] = $this->input->post('status');
        $invoice_entries = array();
        $descriptions = $this->input->post('entry_description');
        $amounts = $this->input->post('entry_amount');
        $number_of_entries = sizeof($descriptions);
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($descriptions[$i] != "" && $amounts[$i] != "") {
                $new_entry = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries'] = json_encode($invoice_entries);
        $this->db->insert('invoice', $data);
    }
    function update_invoice($invoice_id) {
        $data['title'] = $this->input->post('title');
        $data['invoice_number'] = $this->input->post('invoice_number');
        $data['client_id'] = $this->input->post('client_id');
        $data['project_id'] = $this->input->post('project_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp'] = $this->input->post('due_timestamp');
        $data['vat_percentage'] = $this->input->post('vat_percentage');
        $data['discount_amount'] = $this->input->post('discount_amount');
        $data['status'] = $this->input->post('status');
        $invoice_entries = array();
        $descriptions = $this->input->post('entry_description');
        $amounts = $this->input->post('entry_amount');
        $number_of_entries = sizeof($descriptions);
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($descriptions[$i] != "" && $amounts[$i] != "") {
                $new_entry = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries'] = json_encode($invoice_entries);
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $data);
    }
    function delete_promo($p_id) {
        $this->db->where('promo_id', $p_id);
        $this->db->delete('ct_promos');
    }
    function delete_page($page_id) {
        $this->db->where('page_id', $page_id);
        $this->db->delete('ct_pages');
    }
    function delete_invoice($invoice_id) {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice');
    }
    function calculate_invoice_total_amount($invoice_number) {
        $total_amount = 0;
        $invoice = $this->db->get_where('invoice', array('invoice_number' => $invoice_number))->result_array();
        foreach ($invoice as $row) {
            $invoice_entries = json_decode($row['invoice_entries']);
            foreach ($invoice_entries as $invoice_entry)
                $total_amount += $invoice_entry->amount;
            $vat_amount = $total_amount * $row['vat_percentage'] / 100;
            $grand_total = $total_amount + $vat_amount - $row['discount_amount'];
        }
        return $grand_total;
    }
    ///// ACCOUNTING EXPENSE MANAGEMENT /////
    function expense_add() {
        $data['title']               =   $this->input->post('title');
        $data['description']         =   $this->input->post('description');
        $data['expense_category_id'] =   $this->input->post('expense_category_id');
        $data['amount']              =   $this->input->post('amount');
        $data['timestamp']           =   strtotime($this->input->post('timestamp'));
        $data['type']                =   'expense';
        $this->db->insert('payment' , $data);
    }
    function expense_edit($payment_id = '') {
        $data['title']               =   $this->input->post('title');
        $data['description']         =   $this->input->post('description');
        $data['expense_category_id'] =   $this->input->post('expense_category_id');
        $data['amount']              =   $this->input->post('amount');
        $data['timestamp']           =   strtotime($this->input->post('timestamp'));
        $this->db->where('payment_id' , $payment_id);
        $this->db->update('payment' , $data);
    }
    function expense_delete($payment_id = '') {
        $this->db->where('payment_id' , $payment_id);
        $this->db->delete('payment');
    }
    function expense_category_add() {
        $data['title']       =   $this->input->post('title');
        $data['description'] =   $this->input->post('description');
        $this->db->insert('expense_category' , $data);
    }
    function expense_category_edit($expense_category_id = '') {
        $data['title']       =   $this->input->post('title');
        $data['description'] =   $this->input->post('description');
        $this->db->where('expense_category_id' , $expense_category_id);
        $this->db->update('expense_category' , $data);
    }
    function expense_category_delete($expense_category_id = '') {
        $this->db->where('expense_category_id' , $expense_category_id);
        $this->db->delete('expense_category');
    }
    ////////CLIENTS/////////////
    function create_client() {
        $data['name']           = $this->input->post('name');
        $data['email']          = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address']        = $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        $data['city']           = $this->input->post("city");
        $data['state']          = $this->input->post("state");
        $data['country']        = $this->input->post("country");
        $data['zip_code']       = $this->input->post("zip_code");
        $data['owner_status']   = $this->input->post("status");
        $data['staff_id']       = $this->session->userdata('login_user_id');
        $this->db->insert('client', $data);
        $client_id = $this->db->insert_id();
        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_client_account_opening', $client_id, $this->input->post('password'));
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/client_image/' . $client_id . '.jpg');
        return $client_id;
    }
    function update_client($client_id) {
        $data['name']                  = $this->input->post('name');
        $data['email']                 = $this->input->post('email');
        $data['address']               = $this->input->post('address');
        $data['phone']                 = $this->input->post('phone');
         $data['email']                 = $this->input->post('email');
        $data['password']              = sha1($this->input->post('password'));
        $data['city']           = $this->input->post("city");
        $data['state']          = $this->input->post("state");
        $data['country']        = $this->input->post("country");
        $data['zip_code']       = $this->input->post("zip_code");
        $data['owner_status']   = $this->input->post("status");
        $data['staff_id']       = $this->session->userdata('login_user_id');
        $this->db->where('client_id', $client_id);
        return $client_id =$this->db->update('client', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/client_image/' . $client_id . '.jpg');
    }
    function delete_client($client_id) {
        $this->db->where('client_id', $client_id);
        $this->db->delete('client');
    }
    ////////staffS/////////////
    function create_staff() {
        $data['name']           = $this->input->post('name');
        $data['lname']          = $this->input->post('lname');
        $data['email']          = $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['store_name']     = $this->input->post("store_name");
        $data['email']          = $this->input->post("email");
        $data['address']        = $this->input->post("address");
        $data['city']           = $this->input->post("city");
        $data['state']          = $this->input->post("state");
        $data['country']        = $this->input->post("country");
        $data['phone']          = $this->input->post("phone");
        $data['zip_code']       = $this->input->post("zip_code");
        $data['status']         = $this->input->post("status");
        $data['password']       = $this->input->post('password');
        $data['account_role_id']= 1;
        $this->db->insert('staff', $data);
        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_staff_account_opening', $staff_id, $this->input->post('password'));
        return  $staff_id = $this->db->insert_id();
       // move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $staff_id . '.jpg');
    }
    function update_staff($staff_id) {
        $data['name']           = $this->input->post('name'); 
        $data['lname']          = $this->input->post('lname');
        $data['email']          = $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['store_name']     = $this->input->post("store_name");
        $data['email']          = $this->input->post("email");
        $data['address']        = $this->input->post("address");
        $data['city']           = $this->input->post("city");
        $data['state']          = $this->input->post("state");
        $data['country']        = $this->input->post("country");
        $data['phone']          = $this->input->post("phone");
        $data['status']         = $this->input->post("status");
        $data['zip_code']       = $this->input->post("zip_code");
        $this->db->where('staff_id', $staff_id);
         return $this->db->update('staff', $data);
       // move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $staff_id . '.jpg');
    }
    function update_staff_profile($profileData){
        $staff_id = $this->session->userdata('login_user_id');
        #GET STAFF DATA : IF EXISTS  =  update data else insert data;
         $staff_exists = $this->db->get_where('staff_profile', array('tradesmen_id' => $staff_id))->row();
         if(!empty($staff_exists)){
            $this->db->where('tradesmen_id', $staff_id);
            $this->db->update('staff_profile', $profileData);
         }else{
             $profileData['tradesmen_id'] = $staff_id;
             $this->db->insert('staff_profile', $profileData);
             }
    }
    function add_certificates($certData){
        //$staff_id = $this->session->userdata('login_user_id');
        if($certData['cert_id']==''){
            $this->db->insert('certifications_details', $certData);
            return $ID     =   $this->db->insert_id();
        }else{
            $this->db->where('cert_id', $certData['cert_id']);
            $upsated =  $this->db->update('certifications_details', $certData);
            if($upsated==1) $cert_id = $certData['cert_id']; 
            return $cert_id;
            }
        }
    function add_tradesmen_gallery($galleryData){
        $tradesmen_id = $this->session->userdata('login_user_id');
        $insertData['tradesmen_id'] = $tradesmen_id;
        $insertData['image_name'] = $galleryData['image_name'];
        $this->db->insert('tradesmen_image_gallery', $insertData);
        }
    function delete_staff($staff_id) {
        $this->db->where('staff_id', $staff_id);
        return $this->db->delete('staff');
    }
    function staff_permission($account_permission_id = '') {
        $current_staff_account_role_id = $this->db->get_where('staff', array('staff_id' => $this->session->userdata('login_user_id')))
                        ->row()->account_role_id;
        $current_staff_account_permissions = $this->db->get_where('account_role', array('account_role_id' => $current_staff_account_role_id))
                        ->row()->account_permissions;
        if (in_array($account_permission_id, explode(',', $current_staff_account_permissions))) {
            return true;
        } else {
            return false;
        }
    }
    // admins ///
    function create_admin() {
        $data['name']         =   $this->input->post('name');
        $data['email']        =   $this->input->post('email');
        $data['password']     =   sha1($this->input->post('password'));
        $data['phone']        =   $this->input->post('phone');
        $data['address']      =   $this->input->post('address');
        $data['owner_status'] =   $this->input->post('owner_status');
        $this->db->insert('admin' , $data);
        $new_admin_id     =   $this->db->insert_id();
        $this->email_model->notify_email('new_admin_account_creation', $new_admin_id, $this->input->post('password'));
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $new_admin_id . '.jpg');
    }
    function edit_admin($admin_id) {
        $data['name']         =   $this->input->post('name');
        $data['email']        =   $this->input->post('email');
        $data['phone']        =   $this->input->post('phone');
        $data['address']      =   $this->input->post('address');
        $data['owner_status'] =   $this->input->post('owner_status');
        $this->db->where('admin_id' , $admin_id);
        $this->db->update('admin' , $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $admin_id . '.jpg');
    }
    function delete_admin($admin_id) {
        $this->db->where('admin_id', $admin_id);
        $this->db->delete('admin');
    }
    ////////account_roles/////////////
    function create_account_role() {
        $checked_permissions = $this->input->post('permission');
        $total_checked_values = count($checked_permissions);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) {
            $permissions .= $checked_permissions[$i] . ",";
        }
        $data['account_permissions'] = $permissions;
        $data['name'] = $this->input->post('name');
        $this->db->insert('account_role', $data);
    }
    function update_account_role($account_role_id) {
        $checked_permissions = $this->input->post('permission');
        $total_checked_values = count($checked_permissions);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) {
            $permissions .= $checked_permissions[$i] . ",";
        }
        $data['account_permissions'] = $permissions;
        $data['name'] = $this->input->post('name');
        $this->db->where('account_role_id', $account_role_id);
        $this->db->update('account_role', $data);
    }
    function delete_account_role($account_role_id) {
        $this->db->where('account_role_id', $account_role_id);
        $this->db->delete('account_role');
    }
    //////system settings//////
    function update_setting_with($tip,$vrijed) {
        $data['description'] = $vrijed;
        $this->db->where('type', $tip);
        $this->db->update('settings', $data);
    }
    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('dropbox_data_app_key');
        $this->db->where('type', 'dropbox_data_app_key');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);
        $this->session->set_userdata('current_language', $this->input->post('language'));
        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('theme');
        $this->db->where('type', 'theme');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('call_charge');
        $this->db->where('type', 'call_charge');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('lookup_call_charge');
        $this->db->where('type', 'lookup_call_charge');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('call_forword_charges');
        $this->db->where('type', 'call_forword_charges');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('account_sid');
        $this->db->where('type', 'account_sid');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('account_token');
        $this->db->where('type', 'account_token');
        $this->db->update('settings', $data);
        // campos novos
        $data['description'] = $this->input->post('p_call_recording');
        $this->db->where('type', 'p_call_recording');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('p_transc_service');
        $this->db->where('type', 'p_transc_service');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('p_social_med_adv');
        $this->db->where('type', 'p_social_med_adv');
        $this->db->update('settings', $data);
        $data['description'] = $this->input->post('p_blk_spam_calls');
        $this->db->where('type', 'p_blk_spam_calls');
        $this->db->update('settings', $data);
        // fim campos novos
    }
    /////email template settings////
    function save_email_template($email_template_id) {
        $data['subject'] = $this->input->post('subject');
        $data['body'] = $this->input->post('body');
        $this->db->where('email_template_id', $email_template_id);
        $this->db->update('email_template', $data);
    }
    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }
    #########################3 packages Module #######
    function create_package(){
            $data = array(
                'package_name'          =>   $this->input->post('package_name'),
                'package_amount'        =>   $this->input->post('package_amount'),
                'description'           =>   $this->input->post('description'),
                'duration_id'           =>   $this->input->post('duration_id'),
                'call_charge'           =>   $this->input->post('call_charge'),
                'sms_charge'            =>   $this->input->post('sms_charge'),
                'sms_send_charge'       =>   $this->input->post('sms_send_charge'),
                'lookup_call_charge'    =>   $this->input->post('lookup_call_charge'),
                'call_forword_charges'  =>   $this->input->post('call_forword_charges'),
                'p_call_recording'      =>   $this->input->post('p_call_recording'),
                'p_transc_service'      =>   $this->input->post('p_transc_service'),
                'p_social_med_adv'      =>   $this->input->post('p_social_med_adv'),
                'p_blk_spam_calls'      =>   $this->input->post('p_blk_spam_calls'),
                'buy_number_charge'     =>   $this->input->post('buy_number_charge'),
                'features'              =>   implode('#$#',$this->input->post('features')),
                'status'                =>   $this->input->post('status'),
                'is_subscription'       =>   $this->input->post('is_subscription')
            );
            if( $this->input->post('is_subscription')==1) {
                $data['max_call_in'] =  $this->input->post('max_call_in');
                $data['max_call_lookup'] =  $this->input->post('max_call_lookup');
                $data['max_call_transcripts'] =  $this->input->post('max_call_transcripts');
                $data['max_call_minutes'] =  $this->input->post('max_call_minutes');

                $data['max_phone_numbers'] =  $this->input->post('max_phone_numbers');
                $data['max_send_sms'] =  $this->input->post('max_send_sms');
                $data['max_received_sms'] =  $this->input->post('max_received_sms');
                $data['max_send_mms'] =  $this->input->post('max_send_mms');
                $data['max_received_mms'] =  $this->input->post('max_received_mms');
                $data['max_social_ad'] =  $this->input->post('max_social_ad');
            }
            return $this->db->insert('packages',$data);
        }
    function edit_packages($package_id){
            $data = array(
                'package_name'          =>   $this->input->post('package_name'),
                'package_amount'        =>   $this->input->post('package_amount'),
                'description'           =>   $this->input->post('description'),
                'duration_id'           =>   $this->input->post('duration_id'),
                'call_charge'           =>   $this->input->post('call_charge'),
                'sms_charge'            =>   $this->input->post('sms_charge'),
                'sms_send_charge'       =>   $this->input->post('sms_send_charge'),
                'lookup_call_charge'    =>   $this->input->post('lookup_call_charge'),
                'call_forword_charges'  =>   $this->input->post('call_forword_charges'),
                'p_call_recording'      =>   $this->input->post('p_call_recording'),
                'p_transc_service'      =>   $this->input->post('p_transc_service'),
                'p_social_med_adv'      =>   $this->input->post('p_social_med_adv'),
                'p_blk_spam_calls'      =>   $this->input->post('p_blk_spam_calls'),
                'buy_number_charge'     =>   $this->input->post('buy_number_charge'),
                'features'              =>   implode('#$#',$this->input->post('features')),
                'status'                =>   $this->input->post('status')
            );
            if( $this->input->post('is_subscription')==1) {
                $data['max_call_in'] =  $this->input->post('max_call_in');
                $data['max_call_lookup'] =  $this->input->post('max_call_lookup');
                $data['max_call_transcripts'] =  $this->input->post('max_call_transcripts');
                $data['max_call_minutes'] =  $this->input->post('max_call_minutes');

                $data['max_phone_numbers'] =  $this->input->post('max_phone_numbers');
                $data['max_send_sms'] =  $this->input->post('max_send_sms');
                $data['max_received_sms'] =  $this->input->post('max_received_sms');
                $data['max_social_ad'] =  $this->input->post('max_social_ad');
            }
            $this->db->where('package_id',$package_id);
            return $this->db->update('packages',$data);
        }
    ##########################
    #########################3 Category Module #######
        function delete_category($category_id){
            $this->db->where('category_id',$category_id);
            return $this->db->delete('tbl_category');
        }
        function create_category(){
        //print_r($_POST); exit;
            $data['category_name']     =   ucfirst($this->input->post('category_name'));
            $data['status']           =   $this->input->post('status');
            return $this->db->insert('tbl_category',$data);
        }
    function edit_category($category_id){
        //print_r($_POST); exit;
            $data['category_name']     =   ucfirst($this->input->post('category_name'));
            $data['status']           =   $this->input->post('status');
            $this->db->where('category_id',$category_id);
            return $this->db->update('tbl_category',$data);
        }
    #########################3 Subcategory Module #######
        function delete_subcategory($subcategory_id){
            $this->db->where('subcategory_id',$subcategory_id);
            return $this->db->delete('tbl_subcategory');
        }
        function create_subcategory(){
        //print_r($_POST); exit;
            $data1['category_id']     =   $this->input->post('category_id');
            $data1['subcategory_name']     =   ucfirst($this->input->post('subcategory_name'));
            $data1['status']          =   $this->input->post('status');
            return $this->db->insert('tbl_subcategory',$data1);
        }
    function edit_subcategory($subcategory_id){
                $data1['category_id']     =   $this->input->post('category_id');
                $data1['subcategory_name']     =   ucfirst($this->input->post('subcategory_name'));
                $data1['status']          =   $this->input->post('status');
            $this->db->where('subcategory_id',$subcategory_id);
            return $this->db->update('tbl_subcategory',$data1);
        }
    #########################3 Budget Module #######
        function delete_budget($budget_id){
            $this->db->where('budget_id',$budget_id);
            return $this->db->delete('tbl_budget');
        }
    function edit_budget($budget_id){
                $data['amount']     =   $_POST['amount'];
                $data['amt_on']     =   $_POST['amt_on'];
                $data['status']     =   $_POST['status'];
                //print_r($data);exit;
            $this->db->where('budget_id',$budget_id);
            return $this->db->update('tbl_budget',$data);
        }
    #########################3 Offer Module #######
        function delete_offer($offer_id){
            $this->db->where('offer_id',$offer_id);
            return $this->db->delete('tbl_offer');
        }
        function create_offer(){
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('category_id')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['file_name']     = uniqid();
                $config['upload_path']   = "./uploads/offer_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
        $date =  date("Y-m-d h:i:s");
        //print_r($_POST); exit;
            $data1['category_id']     =   $this->input->post('category_id');
            $data1['subcategory_id']     =   $this->input->post('subcategory_id');
            $data1['amount']     =   $this->input->post('amount');
            $data1['offer_img']           =   $data['file_name'];
            $data1['status']          =   $this->input->post('status');
            $data1['created']             =   $this->input->post('start_date');
            return $this->db->insert('tbl_offer',$data1);
        }
    function edit_offer($offer_id){
        //print_r($_POST); exit;
                        $newFileName = $_FILES['userfile']['name'];
        $date =  date("Y-m-d h:i:s");
            //print_r($newFileName);exit;
            if($newFileName!= "")
            {
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('category_id')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['file_name']     = uniqid();
                $config['upload_path']   = "./uploads/offer_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['category_id']     =   $this->input->post('category_id');
            $data1['subcategory_id']     =   $this->input->post('subcategory_id');
            $data1['amount']     =   $this->input->post('amount');
            $data1['offer_img']           =   $data['file_name'];
            $data1['status']          =   $this->input->post('status');
            $data1['updated']             =   $date;
            }
            else{
                $data1['category_id']     =   $this->input->post('category_id');
                $data1['subcategory_id']     =   ucfirst($this->input->post('subcategory_id'));
                $data1['amount']     =   $this->input->post('amount');
                $data1['status']          =   $this->input->post('status');
                $data1['updated']             =   $date;
            }
            $this->db->where('offer_id',$offer_id);
            return $this->db->update('tbl_offer',$data1);
        }
            #########################3 User job Module #######
        function approve_job($trades_id){
            $data['status']           =   1;
            $this->db->where('trades_id',$trades_id);
            return $this->db->update('tbl_trades',$data);
        }
    #########################3 FAQ Module #######
        function deactivate_user($client_id){
                $data1['status']                =   '2';
                $data1['deactivation_reason']   =   'deactivated_by_admin';
                $data1['status_changed_at']     =   date('Y-m-d');
            $this->db->where('client_id',$client_id);
            return $this->db->update('client',$data1);
        }
        function activate_user($client_id){
        $data1['status']                =   '1';
        $data1['deactivation_reason']   =   '';
        $data1['status_changed_at']     =  date('Y-m-d');
            $this->db->where('client_id',$client_id);
            return $this->db->update('client',$data1);
        }
        function delete_faq($faq_id){
            $this->db->where('faq_id',$faq_id);
            return $this->db->delete('tbl_faq');
        }
        function create_faq(){
        //print_r($_POST); exit;
            $data['question']     =   $this->input->post('question');
            $data['answer']     =   $this->input->post('answer');
            $data['status']           =   $this->input->post('status');
            return $this->db->insert('tbl_faq',$data);
        }
    function edit_faq($faq_id){
        //print_r($_POST); exit;
            $data['question']     =   $this->input->post('question');
            $data['answer']     =   $this->input->post('answer');
            $data['status']           =   $this->input->post('status');
            $this->db->where('faq_id',$faq_id);
            return $this->db->update('tbl_faq',$data);
        }
    #########################3 services Module #######
        function delete_services($services_id){
            $this->db->where('services_id',$services_id);
            return $this->db->delete('tbl_services');
        }
        function create_services(){
        //print_r($_POST); exit;
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('question')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['file_name']     = uniqid();
                $config['upload_path']   = "./uploads/services_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('question');
            $data1['subtitle']     =   $this->input->post('answer');
            $data1['image']           =   $data['file_name'];
            $data1['status']          =   $this->input->post('status');
            return $this->db->insert('tbl_services',$data1);
        }
    function edit_services($services_id){
        //print_r($_POST); exit;
        $newFileName = $_FILES['userfile']['name'];
            if($newFileName!= "")
            {
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('question')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['upload_path']   = "./uploads/services_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('question');
            $data1['subtitle']     =   $this->input->post('answer');
            $data1['status']     =   $this->input->post('status');
            $data1['image']           =   $data['file_name'];
            }
            else{
            $data1['title']     =   $this->input->post('question');
            $data1['subtitle']     =   $this->input->post('answer');
            $data1['status']          =   $this->input->post('status');
            }
            $this->db->where('services_id',$services_id);
            return $this->db->update('tbl_services',$data1);
        }
    #########################3 How It Works Module #######
        function delete_works($works_id){
            $this->db->where('works_id',$works_id);
            return $this->db->delete('tbl_howitworks');
        }
        function create_works(){
        //print_r($_POST); exit;
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('title')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['file_name']     = uniqid();
                $config['upload_path']   = "./uploads/works_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            $data1['image']           =   $data['file_name'];
            return $this->db->insert('tbl_howitworks',$data1);
        }
    function edit_works($works_id){
        $newFileName = $_FILES['userfile']['name'];
        $date =  date("Y-m-d h:i:s");
            //print_r($newFileName);exit;
            if($newFileName!= "")
            {
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('title')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['upload_path']   = "./uploads/works_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            $data1['image']           =   $data['file_name'];
            $this->db->where('works_id',$works_id);
            return $this->db->update('tbl_aboutus',$data1);
            }
            else{
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            }
            $this->db->where('works_id',$works_id);
            return $this->db->update('tbl_howitworks',$data1);
        }
    #########################3 Team Module #######
        function delete_team($team_id){
            $this->db->where('team_id',$team_id);
            return $this->db->delete('tbl_team');
        }
        function create_team(){
        //print_r($_POST); exit;
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('title')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['file_name']     = uniqid();
                $config['upload_path']   = "./uploads/team_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            $data1['image']           =   $data['file_name'];
            return $this->db->insert('tbl_team',$data1);
        }
    function edit_team($team_id){
        $newFileName = $_FILES['userfile']['name'];
        $date =  date("Y-m-d h:i:s");
            //print_r($newFileName);exit;
            if($newFileName!= "")
            {
                $newFileName = $_FILES['userfile']['name'];
                $fileExt     = array_pop(explode(".", $newFileName));
                $filename    = str_replace(' ', '_', $this->input->post('title')) . "_" . time() . "." . $fileExt;
                //set filename in config for upload
                $config['upload_path']   = "./uploads/team_img";
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                 $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $data = $this->upload->data();  
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            $data1['image']           =   $data['file_name'];
            $this->db->where('team_id',$team_id);
            return $this->db->update('tbl_team',$data1);
            }
            else{
            $data1['title']     =   $this->input->post('title');
            $data1['status']     =   $this->input->post('status');
            }
            $this->db->where('team_id',$team_id);
            return $this->db->update('tbl_team',$data1);
        }
    #########################3 About Us Module #######
        function delete_aboutus($aboutus_id){
            $this->db->where('aboutus_id',$aboutus_id);
            return $this->db->delete('tbl_howitworks');
        }
        function create_aboutus(){
        //print_r($_POST); exit;
            $data['aboutus']     =   $this->input->post('aboutus');
            //print_r($data['aboutus']);exit;
            return $this->db->insert('tbl_aboutus',$data);
        }
    function edit_aboutus($aboutus_id){
        //print_r($_POST); exit;
            $data['aboutus']     =   $this->input->post('aboutus');
            $this->db->where('aboutus_id',$aboutus_id);
            return $this->db->update('tbl_aboutus',$data);
        }
    ##########################
        function delete_caliber($caliber_id){
            $this->db->where('package_id',$caliber_id);
            return $this->db->delete('packages');
        }
        function create_calibers(){
            $data['caliber_name']   =   $this->input->post('caliber_name');
            $data['caliber_label']   =   $this->input->post('caliber_label');
            $data['status']   =   $this->input->post('status');
            return $this->db->insert('caliber_master',$data);
            }
        function edit_calibers($caliber_id){
            $data['caliber_name']   =   $this->input->post('caliber_name');
            $data['caliber_label']   =   $this->input->post('caliber_label');
            $data['status']   =   $this->input->post('status');
            $this->db->where('caliber_id',$caliber_id);
            return $this->db->update('caliber_master',$data);
                }
        /**********/
        function create_manufacturer(){
            $data['manufacturer_name']   =   $this->input->post('manufacturer_name');
            $data['caliber_id']   =   $this->input->post('caliber_id');
            $data['status']   =   $this->input->post('status');
            return $this->db->insert('manufacturer_master',$data);
            }
        function edit_manufacturer($manufacturer_id){
             $data['manufacturer_name']   =   $this->input->post('manufacturer_name');
             $data['caliber_id']   =   $this->input->post('caliber_id');
             $data['status']        =   $this->input->post('status');
            $this->db->where('manufacturer_id',$manufacturer_id);
            return $this->db->update('manufacturer_master',$data);
                }
        function delete_manufacturer($manufacturer_id){
            $this->db->where('manufacturer_id',$manufacturer_id);
            return $this->db->delete('manufacturer_master');
        }
        /*********/
        /****SErvice section ******/
        function create_service_section(){
            $data['section_name']   =   $this->input->post('section_name');
            $data['section_code']   =   $this->input->post('section_code');
            $data['status']   =   $this->input->post('status');
            return $this->db->insert('section_master',$data);
            }
        function edit_service_section($section_id){
             $data['section_name']   =   $this->input->post('section_name');
             $data['section_code']   =   $this->input->post('section_code');
             $data['status']        =   $this->input->post('status');
            $this->db->where('section_id',$section_id);
            return $this->db->update('section_master',$data);
                }
        function delete_service_section($section_id){
            $this->db->where('section_id',$section_id);
            return $this->db->delete('section_master');                 
                    }
        /*********/
    /**** Staff SErvices Section ******/
        function create_staff_services(){
            $data['services_name']   =   $this->input->post('services_name');
            $data['services_code']   =   $this->input->post('services_code');
            $data['staff_id']   =   $this->input->post('staff_id');
            $caliberCount=4;
            $caliberIds='';
            $caliberValues='';
            for($i=1;$i<=$caliberCount;$i++){
            //echo 'before '.$this->input->post($i);
            $calibersindex =$this->input->post($i);
                if(!empty($calibersindex)){
                    //echo $this->input->post($i);
                        $caliberIds.=$i.',';
                        $caliberValues.=$this->input->post($i).',';
                    }
                }
            $data['caliberIds']   = $caliberIds;
            $data['caliber_amount']   = $caliberValues;
            $data['status']   =   $this->input->post('status');
            return $this->db->insert('services_master',$data);
            }
        function edit_staff_services($services_id){
             $data['services_name']   =   $this->input->post('services_name');
             $data['services_code']   =   $this->input->post('services_code');
             $data['status']          =   $this->input->post('status');
             /**combined vlaues and ids insert into table */
            $caliberCount=4;
            $caliberIds='';
            $caliberValues='';
            for($i=1;$i<=$caliberCount;$i++){
            //echo 'before '.$this->input->post($i);
            $caliberindex= $this->input->post($i);
                if(!empty($caliberindex)){
                    //echo $this->input->post($i);
                        $caliberIds.=$i.',';
                        $caliberValues.=$this->input->post($i).',';
                    }
                }
            $data['caliberIds']   = $caliberIds;
            $data['caliber_amount']   = $caliberValues;
             /***/
            $this->db->where('services_id',$services_id);
            return $this->db->update('services_master',$data);
                }
        function delete_staff_services($services_id){
            $this->db->where('services_id',$services_id);
            return $this->db->delete('services_master');                    
                    }
        /*********/
        /****services category ******/
        function create_services_category(){
            $data['service_category_name']   =   $this->input->post('service_category_name');
            $data['business_type']   =   $this->input->post('business_type');
            $data['status']   =   $this->input->post('status');
            return $this->db->insert('service_category_master',$data);
            }
        function edit_services_category($category_id){
             $data['service_category_name']   =   $this->input->post('service_category_name');
             $data['parent_id']   =   $this->input->post('parent_id');
             $data['status']        =   $this->input->post('status');
            $this->db->where('category_id',$category_id);
            return $this->db->update('service_category_master',$data);
                }
        function delete_services_category($category_id){
            $this->db->where('category_id',$category_id);
            return $this->db->delete('service_category_master');                    
                    }
        /*********/
                /****services SUB-Category ******/
        function create_services_subcategory($images){
            $data['service_category_name']=   $this->input->post('service_category_name');
            $data['parent_id']            =   $this->input->post('parent_id');
            $data['status']               =   $this->input->post('status');
            $data['image_upload']         = $_FILES['image_upload']['name'];
            $data['description']          =   $this->input->post('description');
            //print_r($this->upload->data());
            //        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
            move_uploaded_file($_FILES['image_upload']['tmp_name'],'uploads/subcategory/'.$_FILES['image_upload']['name']);
            return $this->db->insert('service_category_master',$data);
            }
        function edit_services_subcategory($category_id){
            //print_r($_FILES['image_upload']['name']);
            $exte = explode('.',$_FILES['image_upload']['name']);
            $exte =$exte[1];
            //print_r($exte);exit;
             $data['service_category_name']   =   $this->input->post('service_category_name');
             $data['parent_id']               =   $this->input->post('parent_id');
             $data['status']                  =   $this->input->post('status');
             $data['image_upload']        = time().'.'.$exte;///$_FILES['image_upload']['name'];
            $data['description']          =   $this->input->post('description');
            //        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
            move_uploaded_file($_FILES['image_upload']['tmp_name'],'uploads/subcategory/'.$data['image_upload']);
            $this->db->where('category_id',$category_id);
            return $this->db->update('service_category_master',$data);
                }
        function delete_services_subcategory($category_id){
            $this->db->where('category_id',$category_id);
            return $this->db->delete('service_category_master');                    
                    }
        /*********/
    /****Metal Module******/
        function create_metal(){
            $data['metal_name']   =   $this->input->post('metal_name');
            $data['base_price']   =   $this->input->post('base_price');
            $data['status']        =   $this->input->post('status');
            return $this->db->insert('metal_master',$data);
            }
        function edit_metal($metal_id){
             $data['metal_name']   =   $this->input->post('metal_name');
             $data['base_price']   =   $this->input->post('base_price');
             $data['status']       =   $this->input->post('status');
             $this->db->where('metal_id',$metal_id);
            return $this->db->update('metal_master',$data);
                }
        function delete_metal($metal_id){
            $this->db->where('metal_id',$metal_id);
            return $this->db->delete('metal_master');                   
                    }
    /*********/
    /****services category ******/
        function create_jwelleryAndOtherServices(){
            $data['services_name']  =   $this->input->post('services_name');
            $data['bin']            =   $this->input->post('bin');
            $metal_id               = $this->input->post('metal'); 
            if(!empty($metal_id)) {$data['metal_id']    =   $metal_id;}else{  $data['metal_id'] ==0;}
            $data['price']          = $this->input->post('price'); 
            $data['status']         =   $this->input->post('status');
            return $this->db->insert('jwelleryAndOtherServices_master',$data);
            }
        function edit_jwelleryAndOtherServices($jwe_services_id){
             $data['services_name']  = $this->input->post('services_name');
             $data['bin']            = $this->input->post('bin');
             $data['price']          = $this->input->post('price');
             $metal_id               = $this->input->post('metal'); 
            if(!empty($metal_id)) $data['metal_id']     =   $metal_id;
            $data['status']          =   $this->input->post('status');
            $this->db->where('jwe_services_id',$jwe_services_id);
            return $this->db->update('jwelleryAndOtherServices_master',$data);
                }
        function delete_jwelleryAndOtherServices($jwe_services_id){
            $this->db->where('jwe_services_id',$jwe_services_id);
            return $this->db->delete('jwelleryAndOtherServices_master');                    
                    }
        /*********/
    public function add_records($table_name,$insert_array)
    {
        if (is_array($insert_array)) 
        {
            if ($this->db->insert($table_name,$insert_array))
                return true;
            else
                return false;
        }
        else 
        {
            return false; 
        }
    }
    public function update_records($table_name,$update_array,$where_array)
    {
        if (is_array($update_array) && is_array($where_array)) 
        {
            $this->db->where($where_array);
            if($this->db->update($table_name,$update_array))
            {                
                return true;
            }   
            else
            {
                return false;
            }   
        } 
        else 
        {
            return false;
        }
    }
        public function delete_records($table_name,$where_array)
    { 
        if (is_array($where_array)) 
        {  
            $this->db->where($where_array);
            if($this->db->delete($table_name))
                return true;
            else
                return false;
        } 
        else 
        {
            return false;
        }
    }
    public function get_records($table_name,$filed_name_array=FALSE,$where_array=FALSE,$single_result=FALSE)
    {
        if(is_array($filed_name_array) && isset($filed_name_array))
        {
            $str=implode(',',$filed_name_array);
            $this->db->select($str);
        }
        if(is_array($where_array)&& isset($where_array))
        {
            $this->db->where($where_array);
        }
        $result=$this->db->get($table_name);
        if($single_result==true && isset($single_result))
        {
            return $result->row_array();
        } 
        else 
        {
            return $result->result_array();         
        }       
    }
    
    public function filterPackages($types){
        if($types != ""){
            $is_subscription = $this->db->get_where('packages', array('is_subscription' => $types ))->result_array();
        }else{
            $is_subscription = $this->db->get('packages')->result_array();
        }
        return $is_subscription;
    }
    
    public function update_db_records($tblname,$actionType)
    {
        if($actionType == 'delete'){
            return $this->db->delete($tblname); 
        }
        if($actionType == 'update'){
            if($tblname == 'packages'){
                return $this->db->update('packages', array('package_amount' => 0,'call_charge' => 0,'status' => 0));
            }
            if($tblname == 'client'){
                return $this->db->update('client', array('subscription_id' => 0,'subscription_amt' => 0,'subaccount_sid' => '', 'available_fund' =>'1000'));
            }
            if($tblname == 'client_phonenumber_purchased'){
                return $this->db->update('client_phonenumber_purchased', array('phoneNumber' => '+12012930148','friendlyName' => '(201) 293-0148','call_forward_no' => '', 'phoneNumber_price' =>'0'));
            }   
        }
    }

    public function get_sum_paid($cl_id) {

        $this->db->select('SUM(payment_gross_amount) as total'); 
        $this->db->from('client_payment_details');   
        $this->db->where('client_id', $cl_id);
        $rez = $this->db->get()->result_array();
        return $rez[0]['total'];
    }
    /* My Own Changes to the Model -- @EdGolub */

    public function isNumberChecked($phone_num) {
        $ql = $this->db->select('*')->from('advanced_caller_details')->where('phoneNumber', trim($phone_num))->get();
        if($ql->num_rows()>0)
            return true;
        else
            return false;
    }

    public function getNumberDetails($phone_num) {
        $ql = $this->db->get_where('advanced_caller_details', array('phoneNumber' => $phone_num))->row_array();
            return $ql;
    }

    public function get_count_numbers($clientID) {

            /* --- Check if has that phone number */
            $this->db->select('*');
            $this->db->from('client_phonenumber_purchased ');
            $this->db->where(array(
                'client_id' => $clientID
            ));
            $phoneNumbers = $this->db->get()->result_array();
            $num_phones = count( $phoneNumbers);
            return intval($num_phones);
    }


    /* SUBSCRIPTION SERVICE MANAGE */
    public function exists_subs_count($cl_id) {
        $this->db->where('client_id', $cl_id);
        $this->db->where('date', date("Y-m"));
        $query = $this->db->get('ct_subs_count');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            $data_subs['date'] = date("Y-m");
            $data_subs['client_id'] = $cl_id;
            $data_subs['max_call_in'] = 0;
            $data_subs['max_call_minutes'] = 0;
            $data_subs['max_send_sms'] = 0;
            $data_subs['max_received_sms'] = 0;
            $data_subs['max_call_lookup'] = 0;
            $data_subs['max_call_transcripts'] = 0;
            $this->db->insert('ct_subs_count', $data_subs);
            return false;
        }
    }

    public function get_subs_count_alls($koji) {
        $this->db->select('SUM('.$koji.') as '.$koji.'_total'); 
        $this->db->from('ct_subs_count');
        $this->db->where('date', date("Y-m"));
        $rez = $this->db->get()->result_array();
        return $rez[0][$koji.'_total'];
    }

    public function get_subs_count_total_alls($koji) {

        $this->db->select('SUM('.$koji.') as '.$koji.'_total'); 
        $this->db->from('ct_subs_count');   
        $rez = $this->db->get()->result_array();
        return $rez[0][$koji.'_total'];
    }

    public function get_subs_count_total($cl_id,$koji) {
        $this->exists_subs_count($cl_id);

        $this->db->select('SUM('.$koji.') as '.$koji.'_total'); 
        $this->db->from('ct_subs_count');   
        $this->db->where('client_id', $cl_id);
        $rez = $this->db->get()->result_array();
        return $rez[0][$koji.'_total'];
    }

    public function get_subs_count($cl_id,$koji) {
        $this->exists_subs_count($cl_id);

        $this->db->select($koji); 
        $this->db->from('ct_subs_count');   
        $this->db->where('client_id', $cl_id);
        $this->db->where('date', date("Y-m"));
        $rez = $this->db->get()->result_array();
        return $rez[0][$koji];
    }
    public function get_subs_count_all($cl_id) {
        if($cl_id=='') {

        }
        $this->exists_subs_count($cl_id);

        $this->db->select('*'); 
        $this->db->from('ct_subs_count');   
        $this->db->where('client_id', $cl_id);
        $this->db->where('date', date("Y-m"));
        $rez = $this->db->get()->result_array();
        return $rez[0][$koji];
    }

    public function update_subs_count($cl_id,$koji,$koliko=1) {
        $this->exists_subs_count($cl_id);

        $this->db->where('client_id', $cl_id);
        $this->db->set($koji, $koji.'+'.$koliko, FALSE);
        $ql = $this->db->update('ct_subs_count');

        if($ql)
            return true;
        else
            return false;

    }
}