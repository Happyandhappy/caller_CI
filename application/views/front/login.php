 <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;

$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;

$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;

$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>



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

                        <h3 class="ct-login-lead-txt">Experience Caller Technologies Advanced Demographics!</h3>

                        
                        
                      

                        

                    </div>

                    <!-- end col-6 -->

                    <!-- begin col-6 -->

                    <div class="col-md-6 form-col" data-animation="true" data-animation-type="fadeInRight">

                     <p style="color:#FF0000;">

						<?php $error = $this->session->flashdata('error');

                        if(isset($error)) {?>

                        <div class="alert alert-danger"><?php echo $error;?></div>

                        <?php }?>

                        </p>

                        <form class="form-horizontal" action="<?php echo base_url()?>login" method="post">

                            <div class="form-group">

                                <label class="control-label col-md-3">Email <span class="text-theme">*</span></label>

                                <div class="col-md-9">

                                    <input type="text" class="form-control"  placeholder="email address" name="email" value=""/>

                                     <?php echo form_error('email','<div for="category" class="alert text-danger">','</div>');?>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-md-3">Password <span class="text-theme">*</span></label>

                                <div class="col-md-9">

                                    <input type="password" class="form-control" placeholder="password" name="password" value="">

							<?php echo form_error('password','<div for="category" class="alert text-danger">','</div>');?>  

                                </div>

                            </div>

                          

                            <div class="form-group">

                                <label class="control-label col-md-3"></label>

                                <div class="col-md-9 text-left">

                                    <button type="submit" class="btn btn-theme btn-block">Login</button>

                                </div>

                            </div>

                            

                            <div class="form-group">

                                <label class="control-label col-md-3"></label>

                                <div class="col-md-9 text-left">

                                    <p>Don't have an account? <a href="<?php echo base_url()?>home/pricing" class="goto-signup soap-popupbox">Sign up</a></p>

                                </div>

                            </div>

                             

                        </form>

                        <div class="clearfix"></div>

                    <div class="form-group">

                        <a href="<?php echo base_url();?>login/forgot_password" class="forgot-password pull-right">Forgot password?</a>

                        <div class="checkbox checkbox-inline">

							<!--<label><input type="checkbox"> Remember me</label>--> 

                            

                       </div>

                    </div>

                    </div>

                    <!-- end col-6 -->

                </div>

                <!-- end row -->

            </div>

            <!-- end container -->

        </div>

        <div id="contact" class="content " data-scrollview="true"></div>













        <?php /*?><section id="content">

            <div class="container">

                <div id="main">

                   

                    <div class="travelo-box box-full">

                    <div class="row "> &nbsp;</div>

<div class="row">&nbsp;</div>

<div class="row">&nbsp;</div>

                        <div class="contact-form">

                            <h2><?php echo $page_title;?></h2>

							<div class="col-md-3"></div>

                                                    <div class="col-md-6">



                            <div id="travelo-login" class="travelo-box">

                            <?php $error = $this->session->flashdata('error');

								if(isset($error)) {?>

								<div class="alert alert-notice"><?php echo $error;?></div>

									<?php }?>

                            

                

                <form name="" action="<?php echo base_url()?>index.php?login" method="post">

                    <div class="form-group">

                        <input type="text" class="input-text full-width" placeholder="email address" name="email" value="">

                        <?php echo form_error('email','<div for="category" class="alert alert-error">','</div>');?>

                    </div>

                    <div class="form-group">

                        <input type="password" class="input-text full-width" placeholder="password" name="password" value="">

							<?php echo form_error('password','<div for="category" class="alert alert-error">','</div>');?>

                    </div>

                     <div class="col-md-3"><input type="submit" class="btn-medium full-width" value="<?php echo get_phrase('Login')?>" name="submit"/></div>

                     <div class="clearfix"></div>

                    <div class="form-group">

                        <a href="#" class="forgot-password pull-right">Forgot password?</a>

                        <div class="checkbox checkbox-inline">

							<label><input type="checkbox"> Remember me</label>--> 

                            

                       </div>

                    </div>

                </form>

                <div class="seperator"></div>

                <p>Don't have an account? <a href="#travelo-signup" class="goto-signup soap-popupbox">Sign up</a></p>

            </div>

            </div>

            <div class="clearfix"></div>

                        </div>

                    </div>

                    

                      </div>

                    

                </div>

            </div>

           

        </section><?php */?>