 <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;
$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
$system_email_contact = $this->db->get_where('settings', array('type' => 'system_email_contact'))->row()->description;
$system_name = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>

<div id="contact" class="content " data-scrollview="true"></div>
<div id="contact" class="content  bg-silver-lighter " data-scrollview="true">
            <!-- begin container -->
            <div class="container">
				  <?php if($this->session->flashdata('success')){ ?>
					<div class="alert alert-success fade in">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span>
						</button>
						<?php echo $this->session->flashdata('success');?>
					</div>
				  <?php } if($this->session->flashdata('error')){ ?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span>
						</button>
						<?php echo $this->session->flashdata('error');?>
					</div>
				  <?php } ?>

                <h2 class="content-title"><?php echo $page_title;?></h2>
   				<p class="content-desc"></p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-6 -->
                    <div class="col-md-6" data-animation="true" data-animation-type="fadeInLeft">
                        <p>
                            <strong><?php echo $system_name?></strong><br />
                            <?php echo $address?>
                            P: <?php echo $phone?><br />
                        </p>
                        <p>
                            <span class="phone"><?php echo $phone ?></span><br />
                            <a href="mailto:<?php echo $system_email_contact ?>"><?php echo $system_email_contact ?></a>
                        </p>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-md-6 form-col" data-animation="true" data-animation-type="fadeInRight">
                     <p style="color:#FF0000;">
						<?php $error = $this->session->flashdata('error');
                        if(isset($error)) {?>
                        <div class="alert alert-notice"><?php echo $error;?></div>
                        <?php }?>
                        </p>
                        <form class="form-horizontal" action="<?php echo base_url()?>login/forgot_password" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3">Email <span class="text-theme">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"  placeholder="email address" name="email" value=""/>
                                     <?php echo form_error('email','<div for="category" class="alert alert-error">','</div>');?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 text-left">
                                    <button type="submit" name="btn_forgot" class="btn btn-theme btn-block">Submit</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <!-- end col-6 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
