<!-- begin #header -->
<?php 
$userType = $this->session->userdata('login_type');
$login_user_id = $this->session->userdata('login_user_id');
$username = $this->session->userdata('name');
$fetch_class =  $this->router->fetch_class(); // class = controller
$fetch_method = $this->router->fetch_method();

$this->db->select('*');
$this->db->from('client_phonenumber_purchased');                    
$this->db->where(array('status'=>'active','client_id' => $this->session->userdata('login_user_id')));
$query = $this->db->get();
$phones = $query->result_array();

$client_Details = $this->db->where('client_id', $this->session->userdata('login_user_id'))->get('client')->result_array();
$charges = $this->crud_model->fetch_package_pricing($client_Details[0]['subscription_id']);
$max_phone_nums = $charges['max_phone_numbers'];
?>
<!-- begin left menu -->   
<?php 
	//$fetch_class =  $this->router->fetch_class(); // class = controller
	//$fetch_method
    if(!$this->session->userdata('is_subscriber')) {
		$this->db->where('client_id', $login_user_id);
		$client = $this->db->get('client')->result_array();
		$balance_amount = round($client[0]['available_fund'],4);

    }

	 ?>
	 <div class="sider-cont">
	<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
                        <?php if($userType=='clientuser'){ $folder='client';
						$query = $this->db->get_where('client' , array('client_id'=>$login_user_id));$userdetails = $query->row();
						}else{
							$folder = $userType;
							$query = $this->db->get_where($userType , array($userType.'_id'=> $login_user_id));
							$userdetails = $query->row();
						}?>
						<div class="info">
							<?php echo ucfirst($this->session->userdata('name').' '.$this->session->userdata('lname'));?>
							<small><?php echo $userdetails->email; ?></small>
							<?php if(!$this->session->userdata('is_subscriber')) { ?>
							<div class="side-balance">
								<span class="balance-label" ">Balance:</span> <span class="pull-right"
								<?php echo $balance_amount<0 ? 'style="color:red"': ''; ?>><?php echo $balance_amount<0 ? '-': ''; ?> $<?php echo abs($balance_amount); ?></span>
							</div>
							<?php } ?>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<!--<li class="nav-header">Account Details</li>-->
					<li class="<?php if($fetch_class == $userType && $fetch_method=='dashboard') { echo 'active';}?> <?php echo count($phones)>0 && $max_phone_nums>0 ? '':'disabled';?>">
						<a href="<?php echo base_url()?>clientuser/dashboard">
						    <i class="fa fa-bar-chart-o"></i>
						    <span>Dashboard</span>
					    </a>
					</li>
				<?php 
					$account_setting_menu = array('available_numbers','manage_numbers'); ?>
					<li class="has-sub <?php if($fetch_class == 'clientuser' && in_array($fetch_method, $account_setting_menu)) { echo 'active';}?> <?php echo $max_phone_nums>0 ? '':'disabled';?>">
						<a href="#">
                         <b class="caret pull-right"></b>
							<i class="fa fa-phone"></i> 
							<span>Phone Numbers</span>
						</a>
						<ul class="sub-menu">
						    <li class="<?php if($fetch_method=='available_numbers') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/available_numbers">
						    	<span><?php echo get_phrase('Get Phone Number');?></span>
                            </a></li>
						    <li class="<?php if($fetch_method=='manage_numbers') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/manage_numbers">Phone Number Settings</a></li>

						    <li class="<?php if($fetch_method=='manage_blocked') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/manage_blocked">Blocked Numbers</a></li>
                            
						</ul>
					</li>
				<?php 
					$account_sms_menu = array('view_sms','view_messages','import_bulksms','manage_blocked','manage_bulkgroup','manage_bulksms'); ?>
					<li class="has-sub <?php if($fetch_class == 'clientuser' && in_array($fetch_method, $account_sms_menu)) { echo 'active';}?> <?php echo count($phones)>0 ? '':'disabled';?>">
						<a href="#">
                         <b class="caret pull-right"></b>
						    <i class="fa fa-envelope"></i>
							<span>Text Messages</span>
						</a>
						<ul class="sub-menu">
						    <li class="<?php if($fetch_method=='view_messages') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/view_messages">
						    	<span><?php echo get_phrase('Send Message');?></span>
                            </a></li>
						    <li class="<?php if($fetch_method=='view_sms') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/view_sms"><?php echo get_phrase('SMS Logs');?></a></li>

						    <li class="<?php if($fetch_method=='import_bulksms' || $fetch_method=='manage_bulksms' || $fetch_method=='manage_blocked' || $fetch_method=='manage_bulkgroup') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/manage_bulkgroup">Bulk Messaging</a></li>
						</ul>
					</li>
                    <li class="<?php echo count($phones)>0 ? ' ':'disabled';?> <?php if($fetch_class == 'clientuser' && $fetch_method=='get_call_log') { echo 'active';}?>">
						<a href="<?php echo base_url()?>clientuser/get_call_log">
						    <i class="fa fa-phone"></i>
						    <span><?php echo get_phrase('Call Logs');?></span>
					    </a>
					</li>
					<li class="<?php echo count($phones)>0 ? ' ':' ';?> <?php if($fetch_class == 'clientuser' && $fetch_method=='number_lookup') { echo 'active';}?>">
						<a href="<?php echo base_url();?>clientuser/number_lookup">
						 <i class="fa fa-users"></i>
						 <span><?php echo get_phrase('Lookup Number');?></span>
						</a>
					</li>	
				<?php 
					$account_payment_menu = array('account_subscription','account_balance','transactions','report'); ?>
					<li class="has-sub <?php if($fetch_class == 'clientuser' && in_array($fetch_method, $account_payment_menu)) { echo 'active';}?>">
						<a href="#">
                         <b class="caret pull-right"></b>
							<i class="fa fa-money"></i> 
							<span>Payments</span>
						</a>
						<ul class="sub-menu">
						<?php if(!$this->session->userdata('is_subscriber')) { ?>
						   <li class="<?php if($fetch_method=='account_balance') { echo 'active';}?>"> 
                            <a href="<?php echo base_url()?>clientuser/account_balance">Balance &amp; Pricing</a></li>
						   <li class="<?php if($fetch_method=='transactions') { echo 'active';}?>"> 
                            <a href="<?php echo base_url()?>clientuser/transactions">Transactions</a></li>
                        <?php } else { ?>
						   <li class="<?php if($fetch_method=='account_subscription') { echo 'active';}?>"> 
                            <a href="<?php echo base_url()?>clientuser/account_subscription">Subscription Details</a></li>
                        <?php } ?>
						   <li class="<?php if($fetch_method=='report') { echo 'active';}?>"> 
                            <a href="<?php echo base_url()?>clientuser/report">Invoice</a></li>
						</ul>
					</li>
				<?php 
					$account_setting_menu = array('manage_profile','change_password','report'); ?>
					<li class="has-sub <?php if($fetch_class == 'clientuser' && in_array($fetch_method, $account_setting_menu)) { echo 'active';}?>">
						<a href="#">
                         <b class="caret pull-right"></b>
							<i class="fa fa-cogs"></i> 
							<span>Settings</span>
						</a>
						<ul class="sub-menu">
						    <li class="<?php if($fetch_method=='manage_profile') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/manage_profile">Profile Settings</a></li>
						    <li><a href="<?php echo base_url()?>clientuser/address_printing">Address Printing</a></li>
						    <li><a href="<?php echo base_url()?>home/contact">Contact Us</a></li>
						    <li class="<?php if($fetch_method=='change_password') { echo 'active';}?>">
                            <a href="<?php echo base_url()?>clientuser/change_password">Change Password</a></li>
						   <li class="<?php if($fetch_method=='report') { echo 'active';}?>"> 
                            <a href="<?php echo base_url()?>logout">Logout</a></li>
						</ul>
					</li>
			        <!-- begin sidebar minify button
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li> -->
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		</div>
		<!-- end #sidebar -->

	
<!-- left menu ends -->