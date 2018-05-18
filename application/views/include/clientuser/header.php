<!-- begin #header -->
<?php 
$userType = $this->session->userdata('login_type');
$login_user_id = $this->session->userdata('login_user_id');
$username = $this->session->userdata('name');
$fetch_class =  $this->router->fetch_class(); // class = controller
$fetch_method = $this->router->fetch_method();

?>
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
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
    				<a href="<?php echo base_url()?>home" class='logo-img'><img src="<?php echo base_url()?>uploads/logo.png" height="40" alt="" /></a>
				</div> 
				<!-- end mobile sidebar expand / collapse button -->
				<!-- begin header navigation right -->

    				<ul class="nav navbar-nav navbar-right" id="myNavbar">
    					<li class="dropdown navbar-user">

    						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                           
    							<span class="hidden-xs"><?php echo ucfirst($username);?></span> <b class="caret"></b>
    						</a>
    						<ul class="dropdown-menu animated fadeInLeft">
    							<li class="arrow"></li>
                                <li><a href="<?php echo base_url()?>clientuser/manage_profile">Edit Profile</a></li>
                                <li><a href="<?php echo base_url()?>clientuser/change_password">Change Password</a></li>
    							<li class="divider"></li>
    							<li><a href="<?php echo base_url()?>logout">Log Out</a></li>
    						</ul>
    					</li>
    				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
<!-- end #header -->
    <?php 
        $this->load->view('include/clientuser/left_menu');
    ?>