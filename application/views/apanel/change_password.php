<!DOCTYPE html>
<html lang="en">
	<?php include 'head.php';?>

	<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<div class="login-cover">
	    <div class="login-cover-image"><img src="<?php echo base_url()?>assets/img/login-bg/bg-1_new.jpg" data-id="login-cover-image" alt="" /></div>
	    <div class="login-cover-bg"></div>
	</div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <a href="<?php echo base_url(); ?>" ><img src="<?php echo base_url()?>uploads/logo.png" height="60" alt="" /></a> 
                    Admin Panel
                    <small> WELCOME TO <?php echo $system_title;?></small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
			<?php if($this->session->userdata('error')) { ?>
				<div class="alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">×</span>
                    </button>
						<?php echo $this->session->userdata('error');?>
                </div>
			<?php } ?>
                <form action="<?php echo base_url()?>apanel/change_password/<?php echo $user_id ?>"  id="form_login"  method="POST" class="margin-bottom-0" data-parsley-validate="true">
                    <div class="form-group m-b-20">
                        <input class="form-control" type="password" id="password" name="password" data-parsley-type="password" placeholder="Password" data-parsley-required="true" />
                    </div>
                    <div class="login-buttons">
                        <button type="submit" name="btn_change" class="btn btn-success btn-block btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
        
       
        <!-- begin theme-panel -->
        
        <!-- end theme-panel -->
	</div>
	<!-- end page container -->
	
	<?php include 'footer.php';
