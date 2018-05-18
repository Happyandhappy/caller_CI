        <!-- begin #contact -->
        <div id="contact" class="content bg-silver-lighter" data-scrollview="true" style="margin-top:80px;min-height:700px;">
            <!-- begin container -->
          
            <!-- begin container -->
            <div class="container" data-animation="true" data-animation-type="fadeInDown">
              <h2 class="content-title">Frequently Asked Question's </h2>
                
                
            <div class="col-sm-10 col-md-offset-1">
            <div class="panel-group" id="faq">
                    <!-- begin panel -->
					<?php $faq = $this->crud_model->get_records('tbl_faq');
					foreach($faq as $res) { ?>
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span data-toggle="collapse" data-to="#faq-<?php echo $res['faq_id']?>"> <?php echo $res['question']?></span>
                            </h4>
                        </div>
                        <div id="faqs-<?php echo $res['faq_id']?>">
                            <div class="panel-body">
                                <p><?php echo nl2br($res['answer']) ?></p>
                            </div>
                        </div>
                    </div>
					<?php } ?>
                    <!-- end panel -->
                </div>
                </div>
                
            </div>
            
            
            <!-- end container -->
        </div>
        <!-- end #contact -->
