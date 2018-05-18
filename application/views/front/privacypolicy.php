        <!-- begin #contact -->
        <div id="contact" class="content bg-silver-lighter" data-scrollview="true" style="margin-top:80px; border-top:1px solid #E6E6E6;">
            <!-- begin container -->
<?php $policy = $this->crud_model->get_records('ct_pages','',array('page_title'=>'privacy_policy'),'');?>          
            <!-- begin container -->
            <div class="container" data-animation="true" data-animation-type="fadeInDown">
              <h2 class="content-title"><?php echo $page_title?> </h2>
                <?php echo $policy[0]['page_content'];?>
                
                
            </div>
            
            
            <!-- end container -->
        </div>
        <!-- end #contact -->
