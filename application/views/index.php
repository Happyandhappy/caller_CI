<!DOCTYPE html>
<html lang="en-US">
<?php $this->load->view('include/clientuser/head'); ?>
<body class="boxed-layout">
	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

	<?php $this->load->view('include/clientuser/header'); ?>
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>home">Home</a></li>
					<li><a href="<?php echo base_url(); ?>clientuser/dashboard">User Panel</a></li>
				<li class="active"><?php echo get_phrase($page_title); ?> </li>
			</ol>

			
			<h1 class="page-header"><?php echo get_phrase(ucfirst($page_title)); ?></h1>    

			<div id="notificationDiv_<?php echo $this->session->userdata('login_user_id'); ?>">

			<?php

				if( $this->session->userdata('login_user_id') ) {
			        $this->db->where(array(
			            'email_verified' => '0',
			            'client_id' => $this->session->userdata('login_user_id')
			        ));
					$rez = $this->db->get('client')->result_array();
					$client = $rez[0];
					if( !empty($client) && $client['subaccount_sid']!='') {
						?>
						<div class="alert alert-danger">
								<p class="lead"><b>Email not verified!</b></p>
								<p class="lead lead-small">Please verify your email address.  Check your email for the link.</p>

								<p class="lead lead-small"><a href="<?php echo base_url(); ?>clientuser/resend_email_verify">Click here</a> to resend the verification email.
						</div>
						<?php
					}

				}

				if(!$this->session->userdata('is_subscriber')) {

					$this->db->where('client_id', $this->session->userdata('login_user_id'));
					$client = $this->db->get('client')->result_array();
					$balance_amount = round($client[0]['available_fund'],4);
        			$charges = $this->crud_model->fetch_package_pricing($client[0]['subscription_id']);
					$min_balance = '5';

					if($balance_amount<=0 && $page_title!='Account Balance' && $page_title!='Signed Up Successfully!') { ?>
						<div class="alert alert-danger">
							<span class="close" data-dismiss="alert">×</span>
							<div style="padding: 5px 10px;">
								<p class="lead"><b>Warning!</b></p>
								<p class="lead lead-small">Your account balance is <b><?php echo $balance_amount;?>$ </b>. To use all our services, your balance <b>needs to be above $0. </b>.<br/>
								SMS will not be received and Calls will be rejected.</p><p class="lead lead-small"> Please <b><a href="<?php site_url('/clientuser/account_balance'); ?>">top up your account</a></b> to use our services. </p>
								<!--<p>
									<a href="<?php site_url('/home/pricing'); ?>" class="btn btn-primary btn-lg">Pricing</a>
								</p>-->
							</div>
						</div>
			<?php

					}
				}
				
				if ($this->session->flashdata('not_fund_purchase_number') && $this->session->userdata('is_subscriber')){ ?>
			
				<div class="alert-wrap">
		            <div class="alert alert-warning"><span class="close" data-dismiss="alert">×</span>
		                <div><h5> You have used up all phone numbers for your subscription!</h4></div>
		            </div>
		         </div>

			<?php  } else if ($this->session->flashdata('not_fund_purchase_number')){
					$value = $this->session->flashdata('not_fund_purchase_number');
					$frm_url = base_url() . 'payment/topup_payment';
					echo $notification = '
					<div class="alert alert-warning">
						<span class="close" data-dismiss="alert">×</span>
						<div class="row p-20">
							<h4> Your Funds are not enough!</h4>
							<p class="text-white" style="font-size: 16px;"> Your account balance is low and <b>needs $'.$value.' more</b> to purchase the number.</p>
							<p> Please add funds to your account</p>
							<p> 
								<form class="form-inline" name="frm_payment" id="frm_payment" method="post" action="' . $frm_url . '" onSubmit="return validate_amt();" >
									<div class="input-group m-r-10">
			      						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
										<input type="text"  class="form-control" name="topup_amount" id="topup_amount" value="'.$value.'" required placeholder="Enter amount" >
									</div>
									<input type="submit" class="btn btn-sm btn-primary m-r-5" name="pay_submit" id="pay_submit" value="Pay to Account Balance">
								</form>
							</p>
						</div>
					</div>';

				}
				/*else if ($this->uri->segment('2') != 'number_lookup'){
					$clientFUNFDetails = $this->db->get_where('client', array('client_id' => $this->session->userdata('login_user_id')))->row();
					$lookup_call_charge = $this->db->get_where('settings', array('type' => 'lookup_call_charge'))->row()->description;
					$is_subscription = $this->db->get_where('packages', array('package_id' => $clientFUNFDetails->subscription_id))->row();
					if (($clientFUNFDetails->available_fund <= $lookup_call_charge || $clientFUNFDetails->available_fund <= 3) && $is_subscription->is_subscription !=1) {

						$frm_url = base_url() . 'payment/topup_payment';
						echo $notification = '<div class="note note-danger alert"><span class="close" data-dismiss="alert">×</span><div class="row p-20"><h4> Your Funds are not enough!</h4><p class="text-white" style="font-size: 16px;"> Your account funds are low and we have suspended your account, please add a minimum of $100 to reactivate it.</p><p> <form class="form-inline" name="frm_payment" id="frm_payment" method="post" action="' . $frm_url . '" onSubmit="return validate_amt();" ><div class="form-group m-r-10"><input type="text"  class="form-control" name="topup_amount" id="topup_amount" value="100" required placeholder="Enter amount" ></div><input type="submit" class="btn btn-sm btn-primary m-r-5" name="pay_submit" id="pay_submit" value="Pay"></form></p></div></div>';

					}
				
				}*/

					
				?>


				<script>

					function validate_amt() {
						if ($('#topup_amount').val() == '' || $('#topup_amount').val() <= 0) {
							alert("Please enter topup amount");
							return false;
						}
						return true;
					}
				
				</script>
		    </div>

			<div class="panel panel-success">
				<?php if ($this->session->flashdata('flash_message')!=''){ ?>
					<div class="alert alert-success" style="width:auto">
						<button class="close" data-dismiss="alert">x</button>
						<?php echo $this->session->flashdata('flash_message'); ?>
					</div>
				<?php }
				if ($this->session->flashdata('error')!='') {
				?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
						<?php echo $this->session->flashdata('error'); ?> 
					</div>
				<?php
				} ?>


				<div class="panel-body">
					<div id="alert-btn"></div>
					<?php $this->load->view('clientuser/'.$page_name); ?>
				</div>
			</div>
		</div> 
	<?php $this->load->view('include/clientuser/footer'); ?>