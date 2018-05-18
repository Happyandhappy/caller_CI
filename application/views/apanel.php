<!DOCTYPE html>
<html lang="en-US">
<?php $this->load->view('include/apanel/head'); ?>
<body>          
    <div id="page-container" class="admin-container page-container fade page-without-sidebar page-header-fixed page-with-top-menu">

	<?php $this->load->view('include/apanel/header'); ?>
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>home">Home</a></li>
					<li><a href="<?php echo base_url(); ?>apanel/dashboard">Admin Panel</a></li>
					
				<li class="active"><?php echo get_phrase($page_title); ?> </li>
			</ol>
					
			<h1 class="page-header"><?php echo get_phrase(ucfirst($page_title)); ?></h1>    

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
					<?php $this->load->view('apanel/'.$page_name); ?>
					</div>
				</div>
		</div> 
		<?php $this->load->view('include/apanel/footer'); ?>