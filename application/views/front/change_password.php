
<div id="contact" class="content " data-scrollview="true"></div>
<div id="contact" class="content  bg-silver-lighter " data-scrollview="true">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title"><?php echo $page_title;?></h2>
   				<p class="content-desc"></p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-6 -->
                    <div class="col-md-6" data-animation="true" data-animation-type="fadeInLeft">
                        <h3>If you have a project you would like to discuss, get in touch with us.</h3>
                        <p>
                            Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus.
                        </p>
                        <p>
                            <strong><?php echo $system_name?></strong><br />
                            <?php echo $address?>
                            P: <?php echo $phone?><br />
                        </p>
                        <p>
                            <span class="phone"><?php echo $phone?></span><br />
                            <a href="mailto:<?php echo $system_email?>"><?php echo $system_email?></a>
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
                        <form class="form-horizontal" action="<?php echo base_url()?>login/change_password/<?php echo $user_id?>" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3">Change Password <span class="text-theme">*</span></label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" required placeholder="New Password" name="password" value=""/>
                                     <?php echo form_error('password','<div for="category" class="alert alert-error">','</div>');?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9 text-left">
                                    <button type="submit" name="btn_change" class="btn btn-theme btn-block">Submit</button>
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
