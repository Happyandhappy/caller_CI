        <!-- begin #contact -->
        <div id="contact" class="content bg-silver-lighter" data-scrollview="true" style="margin-top:80px; ">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title">Contact Us</h2>
                <!-- begin row -->
 				  <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;
					$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
					$system_name = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
					$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>
               <div class="row" style="margin-top:60px;">
                    <!-- begin col-6 -->
                    <div class="col-md-6" data-animation="true" data-animation-type="fadeInLeft">
                        <h3>Caller Technologies is always here for you.</h3>
                        <h4>Complete the form to reach our customer support team. </h4>
                        <h5 style="margin-top:45px;">
                           <b>If you encounter an issue please report it, and we will be in touch shortly.</b>
                        </h5>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-md-6">
                    <?php  
                        if ($this->session->flashdata('success') != ''): 
                            echo '<div class="col-md-10 col-md-push-2"><div class="alert alert-warning">'.$this->session->flashdata('success').'</div></div>'; 
                        endif;
                        if ($this->session->flashdata('error') != ''): 
                            echo '<div class="col-md-10 col-md-push-2"><div class="alert alert-danger">'.$this->session->flashdata('error').'</div></div>'; 
                        endif;
                    ?>
                    </div>
				<form class="form-horizontal" action="<?php echo base_url(); ?>home/contact" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 form-col" data-animation="true" data-animation-type="fadeInRight">
                            <div class="form-group">
                                <label class="control-label col-md-2">Name <span class="text-theme">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name')?>">
								<?php echo form_error('name');?>
                                </div>
                           </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Email <span class="text-theme">*</span></label>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email')?>">
								<?php echo form_error('email');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Message <span class="text-theme">*</span></label>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="10" id="message" name="message"><?php echo set_value('message')?></textarea>
								<?php echo form_error('message');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-10 text-left">
                                    <button type="submit" class="btn btn-theme btn-block">Send Message</button>
                                </div>
                            </div>
                    </div>
                </form>
                    <!-- end col-6 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #contact -->