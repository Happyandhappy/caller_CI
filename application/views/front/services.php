        
        <!-- begin #quote -->
        <div id="quote" class="content bg-black-darker has-bg" data-scrollview="true" >
            <!-- begin content-bg -->
            <div class="content-bg">
                <img src="<?php echo base_url()?>assets/img/quote-bg.jpg" alt="Quote">
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container fadeInLeft contentAnimated finishAnimated" data-animation="true" data-animation-type="fadeInLeft">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12 quote" style="margin-top:70px;">
                        <i class="fa fa-quote-left"></i> CALLER LOOKUP BY, <br>
                         <span class="text-theme">CALLER TECH</span>!  
                        <i class="fa fa-quote-right"></i>
                        <small>Taking Technology to the new levels</small>
                    </div>
                    <!-- end col-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
      
        <!-- begin #pricing -->
        <div id="Services" class="content" data-scrollview="true" >
         <div class="container fadeInLeft contentAnimated finishAnimated" data-animation="true" data-animation-type="fadeInLeft">
                <!-- begin row -->
                <div class="row">
            <!-- begin container -->
            <div id="product-tab-content" class="tab-content">
                            <!-- BEGIN #product-desc -->
                            <div class="tab-pane fade active in" id="product-desc">
                                <!-- BEGIN product-desc -->
							<?php $services = $this->crud_model->get_records('tbl_services');
							$count = 0;
							foreach($services as $res) { ?>
                                <div class="product-desc <?php echo (++$count % 2) ? "" : "right"; ?>">
                                    <div class="image">
                                        <img src="<?php echo base_url()?>uploads/services_img/<?php echo $res['image']?>" alt="">
                                    </div>
                                    <div class="desc">
                                        <h4><?php echo $res['title']?></h4>
                                        <?php echo $res['subtitle']?>
                                    </div>
                                </div>
							<?php } ?>
                            </div>
                          
                        </div>
                        
                        </div>
                        </div>
            
            <!-- end container -->
        </div>
        
        
        <!-- end #pricing -->
        
        <div id="action-box" class="content has-bg" data-scrollview="true">
            <!-- begin content-bg -->
            <!--div class="content-bg">
                <img src="<?php echo base_url()?>assets/img/action-bg.jpg" alt="Action">
            </div-->
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container fadeInRight contentAnimated finishAnimated" data-animation="true" data-animation-type="fadeInRight">
                <!-- begin row -->
                <div class="row action-box">
                    <!-- begin col-9 -->
                    <div class="col-md-9 col-sm-9">
                        <div class="fa fa-large text-theme">
                            <i class="fa fa-binoculars"></i>
                        </div> 
                         <h3>CHECK OUT OUR PRODUCT PRICING IN DETAIL!</h3>
                        <p>
                           Lookup The product is driven by new technology and innovative minds .
                        </p>
                    </div>
                    <!-- end col-9 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-3">
                        <a href="<?php echo base_url();?>home/pricing" class="btn btn-outline btn-block">PRICING Information</a>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        
        <!-- begin #contact -->
        
        <!-- end #contact -->
