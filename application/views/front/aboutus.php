        
        <!-- begin #about -->
        <div id="about" class="content" data-scrollview="true" style="margin-top:80px; border-top:1px solid #E6E6E6;">
            <!-- begin container -->
            <div class="container" data-animation="true" data-animation-type="fadeInDown">
                <h2 class="content-title">About Us</h2>
 				<?php $aboutus = $this->crud_model->get_records('ct_pages','',array('page_title'=>'about_us'),'');?>
                    <?php echo substr($aboutus[0]['page_content'],0 ,100)?>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
                    <div class="col-md-6 col-sm-6">
                        <!-- begin about -->
 					<?php $our_story = $this->crud_model->get_records('ct_pages','',array('page_title'=>'our_story'),'');?>
                       <div class="about">
                            <h3>Our Story</h3>
                            <?php echo substr($our_story[0]['page_content'],0 ,300)?>
                        </div>
                        <!-- end about -->
                    </div>
                    <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-6 col-sm-6">
                        <h3>Our Philosophy</h3>
                        <!-- begin about-author -->
                        <div class="about-author">
  					<?php $philosophy = $this->crud_model->get_records('ct_pages','',array('page_title'=>'our_philosophy'),'');?>
                           <div class="quote bg-silver">
                                <i class="fa fa-quote-left"></i>
                                 <!--<h3>We work harder,<br /><span>to let our user keep simple</span></h3>-->
                               <?php echo $philosophy[0]['page_content']?>
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <div class="author">
                                <div class="image">
                                    <img src="<?php echo base_url()?>assets/img/user-1.jpg" alt="Sean Ngu" />
                                </div>
                                <div class="info">
                                    Sean Ngu
                                    <small>Front End Developer</small>
                                </div>
                            </div>
                        </div>
                        <!-- end about-author -->
                    </div>
                    <!-- end col-4 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #about -->
    
        
        
        <!-- begin #team -->
        <div id="team" class="content" data-scrollview="true">
            <!-- begin container -->
            <div class="container">
                <h2 class="content-title">Our Team</h2>
                <p class="content-desc">
                    Phasellus suscipit nisi hendrerit metus pharetra dignissim. Nullam nunc ante, viverra quis<br /> 
                    ex non, porttitor iaculis nisi.
                </p>
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
				<?php $this->db->limit(3,0);
					  $team = $this->db->get('tbl_team')->result_array();
					  foreach($team as $res){ ?>
					<div class="col-md-4 col-sm-4">
                        <!-- begin team -->
                        <div class="team">             
                            <div class="image" data-animation="true" data-animation-type="flipInX">
                                <img src="<?php echo base_url()?>uploads/team_img/<?php echo $res['image']?>"/>
                            </div>
                            <div class="info">
                                <?php echo $res['title']?>
                                <div class="social">
                                    <a href="#"><i class="fa fa-facebook fa-lg fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-twitter fa-lg fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-google-plus fa-lg fa-fw"></i></a>
                                </div>
                            </div>                     
                        </div>
                        <!-- end team -->
                    </div>
					  <?php } ?>
                    <!-- end col-4 -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #team -->
        
        <!-- begin #quote -->
        <!--<div id="quote" class="content bg-black-darker has-bg" data-scrollview="true">
            <div class="content-bg">
                <img src="<?php echo base_url()?>assets/img/quote-bg.jpg" alt="Quote" />
            </div>
            <div class="container" data-animation="true" data-animation-type="fadeInLeft">
                <div class="row">
                    <div class="col-md-12 quote">
                        <i class="fa fa-quote-left"></i> Passion leads to design, design leads to performance, <br />
                        performance leads to <span class="text-theme">success</span>!  
                        <i class="fa fa-quote-right"></i>
                        <small>Sean Themes, Developer Teams in Malaysia</small>
                    </div>
                </div>
            </div>
        </div>-->
      
