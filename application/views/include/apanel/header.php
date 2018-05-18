<!-- begin #header -->
<?php 
$userType = $this->session->userdata('login_type');
$login_user_id = $this->session->userdata('login_user_id');
$username = $this->session->userdata('name');
$fetch_class =  $this->router->fetch_class(); // class = controller
$fetch_method = $this->router->fetch_method();

?>
		<div id="header" class="header admin-header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">

                <div class="logo-mob-small pull-left">
                    <img src="<?php echo base_url()?>uploads/logo.png" height="30" alt="" />
                </div>
                        
                <div class="pull-right sidebar-toggle-btn">
                    <button type="button" onClick="$('.sider-cont').toggleClass('page-sidebar-toggled');"> <span class="fa fa-bars"></span> </button>
                </div>
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
    				<a href="<?php echo base_url()?>apanel" class='logo-img'><img src="<?php echo base_url()?>uploads/logo.png" height="40" alt="" /></a>
				</div> 
				<!-- end mobile sidebar expand / collapse button -->
				<!-- begin header navigation right -->

    				<ul class="nav navbar-nav navbar-right" id="myNavbar">
    					<li class="dropdown navbar-user">

    						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <?php 
    							$query = $this->db->get_where('admin' , array('admin_id'=>$login_user_id));
                                $userdetails = $query->row(); 
    							if($userdetails->profile_image!='')
                                {?>
                            		<img src='<?php echo base_url()."uploads/".$userType."_image/".$userdetails->profile_image;?>' alt="..." style="height:100%;">
                           	 		<?php 
    						 	} 
    						 ?>
    							<span class="hidden-xs"><?php echo ucfirst($username);?></span> <b class="caret"></b>
    						</a>
    						<ul class="dropdown-menu animated fadeInLeft">
    							<li class="arrow"></li>
                                <li><a href="<?php echo base_url()?>apanel/manage_profile">Edit Profile</a></li>
                                <?php  if($this->session->userdata('admin_user_id') == 1): ?>
                                <li><a href="<?php echo base_url()?>apanel/admins">Manage Admins</a></li>
    							<li><a href="<?php echo base_url()?>apanel/system_settings">System setting</a></li>
    							<li class="divider"></li>
                                <?php endif; ?>
    							<li><a href="<?php echo base_url()?>logout">Log Out</a></li>
    						</ul>
    					</li>
    				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
        <div id="top-menu" class="top-menu">
            <!-- begin top-menu nav -->
            <ul class="nav">
                <li class="has-sub <?php if($fetch_method=='dashboard') echo 'active';?>">
                    <a href="<?php echo base_url()?>apanel/dashboard">
                        <i class="fa fa-laptop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="has-sub <?php if($fetch_method=='packages') echo 'active';?>">
                    <a href="javascript:;">
                    <b class="caret pull-right"></b>
                        <i class="fa fa-inbox"></i> 
                        <span>Subscriptions</span>
                    </a>
                    <ul class="sub-menu">
                     <li><a href="<?php echo base_url()?>apanel/packages">View Subscriptions</a></li>
                        <!--<li><a href="<?php echo base_url()?>apanel/package_add">Packages add</a></li>-->
                        <li><a href="<?php echo base_url()?>apanel/subscription_add">Subscription add</a></li>
                                <?php  if($this->session->userdata('admin_user_id') == 1): ?>
                        <li><a href="<?php echo base_url()?>apanel/promos">Promos</a></li>
                                <?php endif; ?>
                    </ul>
                </li>
                <li class="has-sub <?php if($fetch_method=='user_list') echo 'active';?>">
                    <a href="javascript:;">
                    <b class="caret pull-right"></b>
                        <i class="fa fa-th fa-2x pull-left fa-fw"></i> 
                        <span>Details</span>
                    </a>
                    <ul class="sub-menu">
                     <li><a href="<?php echo base_url()?>apanel/user_list">User Details</a></li>
                     <li><a href="<?php echo base_url()?>apanel/calls_list">Call Details</a></li>
                     <li><a href="<?php echo base_url()?>apanel/advanced_details">Lookup Details</a></li>
                    </ul>
                </li>
                <li class="has-sub <?php if($fetch_method=='cms') echo 'active';?>">
                    <a href="javascript:;">
                    <b class="caret pull-right"></b>
                        <i class="fa fa-wrench fa-2x pull-left fa-fw"></i> 
                        <span>CMS</span>
                    </a>
                    <ul class="sub-menu">
                     <li><a href="<?php echo base_url()?>apanel/pages">CMS - Custom Pages</a></li>
                     <li><a href="<?php echo base_url()?>apanel/faq">Frequently Asked Questions</a></li>
                     <!--<li><a href="<?php echo base_url()?>apanel/works">How It Works?</a></li>
                     <li><a href="<?php echo base_url()?>apanel/services">Our Services</a></li>
                     <li><a href="<?php echo base_url()?>apanel/team">Team Member</a></li>-->
                     <li><a href="<?php echo base_url()?>apanel/banner">Manage Banner</a></li>
                    </ul>
                </li>

                <?php  if($this->session->userdata('admin_user_id') == 1): ?>
                <li class="has-sub <?php if($fetch_method=='system_settings' || $fetch_method=='payment_settings' || $fetch_method=='email_settings') echo 'active';?>">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-cogs"></i>
                            <span><?php echo get_phrase('site_setting');?></span>
                        </a>
                        <ul class="sub-menu">
                            <li class=""><a href="<?php echo base_url()?>apanel/manage_language">Language Settings</a></li>
                            <li class=""><a href="<?php echo base_url()?>apanel/system_settings">System Setting</a></li>
                            <li class=""><a href="<?php echo base_url()?>apanel/payment_settings">Payment Setting</a></li>
                            <li class=""><a href="<?php echo base_url()?>apanel/twilio_prices">Provider Costs</a></li>
                            <!--<li class=""><a href="<?php //echo base_url()?><?php echo $userType;?>/email_settings">Email Setting</a></li>-->
                        </ul>
                    </li>
                                <?php endif; ?>
            </ul>
            <!-- end top-menu nav -->
        </div>
<!-- end #header -->