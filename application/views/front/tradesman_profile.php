 <section id="content">
            <div class="container">
                <div class="row">
				
				<?php if(empty($tradsman[0]['banner_image'])) {?>
                <div class=" col-md-12"  style="background:url(<?php echo base_url()?>uploads/staff_image/banner/default1.png) no-repeat;background-size:cover; height:300px;">
                </div>
				
				<?php } else {?> 
                <div class=" col-md-12"  style="background:url(<?php echo base_url()?>uploads/staff_image/banner/<?php echo $tradsman[0]['banner_image']?>) no-repeat;background-size:cover; height:300px;">
                </div>
				<?php } ?>
				
				
                 <div class=" col-md-12 box"  >

				<?php if(empty($tradsman[0]['profile_photo'])) {?>
				 <div class="col-md-2 profile_image" style=" background:url(<?php echo base_url()?>uploads/staff_image/default.png); ">
                </div>
				
				<?php } else {?> 
				 <div class="col-md-2 profile_image" style=" background:url(<?php echo base_url()?>uploads/staff_image/<?php echo $tradsman[0]['profile_photo']?>); ">
                </div>
				<?php } ?>

                <div class="col-md-10">
                 <p><?php echo $tradsman[0]['company_desc']?></p>
                </div>
                
                </div>
                
                    <div id="main" class="col-md-12">
                    <div id="hotel-features" class="tab-container">
                            <ul class="tabs">
                                <li class="active"><a href="#hotel-description" data-toggle="tab">Home</a></li>
                                <li><a href="#hotel-amenities" data-toggle="tab">Services</a></li>
                                  <li><a data-toggle="tab" href="#photos-tab">Work Gallery</a></li>
                                <li><a href="#hotel-reviews" data-toggle="tab">Reviews</a></li>
                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="hotel-description">
                                    <div class="intro table-wrapper full-width hidden-table-sms">
                                        <div class="col-sm-5 col-lg-4 features table-cell">
                                            <ul>
                                                <li><label>Name:</label><?php echo $tradsman[0]['name']?></li>
                                                <li><label>Last Name:</label><?php echo $tradsman[0]['lname']?></li>
                                                <li><label>Company Name:</label><?php echo $tradsman[0]['company_name']?></li>
                                                <li><label>House:</label><?php echo $tradsman[0]['house	_name']?></li>
                                                <li><label>Street:</label><?php echo $tradsman[0]['street']?></li>
                                                <li><label>Town:</label><?php echo $tradsman[0]['town']?></li>
                                                <li><label>Country:</label><?php echo $tradsman[0]['country']?></li>
                                                <li><label>Postal Code:</label><?php echo $tradsman[0]['postal_code']?>rict</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-7 col-lg-8 table-cell testimonials">
                                            <div class="testimonial style1">
                                                <ul class="slides ">
                                                    <li><?php $this->db->where('category_id',$tradsman[0]['primary_trade']);
															$cat = $this->db->get('tbl_category')->result_array();?>
                                                        <p class="description"><?php echo $tradsman[0]['company_desc']?></p>
                                                        <div class="author clearfix">
                                                            <h5 class="name"><?php echo $tradsman[0]['name'].' '.$tradsman[0]['lname']?><small><?php echo $cat[0]['category_name']?></small></h5>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="long-description">
                                        <h2>About <?php echo $tradsman[0]['company_name']?></h2>
                                        <p><?php echo $tradsman[0]['company_desc']?></p>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="hotel-amenities">
								<?php $this->db->select('*');												
									  $this->db->where('category_id',$tradsman[0]['primary_trade']);
									  $cat = $this->db->get('tbl_category')->result_array();
											  //print_r($cat);?>
                                    <h2><?php echo $cat[0]['category_name']?></h2>
                                    
                                    <!--<p>Maecenas vitae turpis condimentum metus tincidunt semper bibendum ut orci. Donec eget accumsan est. Duis laoreet sagittis elit et vehicula. Cras viverra posuere condimentum. Donec urna arcu, venenatis quis augue sit amet, mattis gravida nunc. Integer faucibus, tortor a tristique adipiscing, arcu metus luctus libero, nec vulputate risus elit id nibh.</p>-->
                                    <ul class="amenities clearfix style1">
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style1"><i class="soap-icon-tub"></i><?php echo $cat[0]['category_name']?></div>
                                        </li>
                                    </ul>
                                    <br />
                                    
                                </div>
                                <div id="photos-tab" class="tab-pane fade in ">
                                    <div class="photo-gallery style1" data-animation="slide" data-sync="#photos-tab .image-carousel">
                                        <ul class="slides">
										<?php $this->db->select('*');
											  $this->db->where('tradesmen_id',$tradsman[0]['staff_id']);
											  $image = $this->db->get('tradesmen_image_gallery')->result_array();
											  //print_r($image);
										foreach($image as $img) { ?>
                                            <li><img src="<?php echo base_url()?>uploads/staff_image/gallery/<?php echo $img['image_name']?>" alt="" /></li>
										<?php } ?>
                                        </ul>
                                    </div>
                                    <div class="image-carousel style1" data-animation="slide" data-item-width="70" data-item-margin="10" data-sync="#photos-tab .photo-gallery">
                                        <ul class="slides">
										<?php foreach($image as $img) { ?>
                                            <li><img src="<?php echo base_url()?>uploads/staff_image/gallery/<?php echo $img['image_name']?>" alt="" /></li>
										<?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="hotel-reviews">
                                    <div class="guest-reviews">
                                        <h2>Guest Reviews</h2>
										<?php $review = $this->crud_model->get_records('tbl_ratingreview','',array('staff_id'=>$tradsman[0]['staff_id']),'');
										foreach($review  as $res) { ?>
                                        <div class="guest-review table-wrapper">
                                            <div class="col-xs-9 col-md-10 table-cell comment-container">
                                                <div class="comment-header clearfix">
                                                    <h4 class="comment-title"><?php echo $res['review_title']?></h4>
                                                    <div class="review-score">
                                                        <div class="five-stars-container"><div class="five-stars" style="width: <?php echo ($res['rating']/5)* 100 ?>%;"></div></div>
                                                        <span class="score"><?php echo $res['rating']?>/5.0</span>
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    <p><?php echo $res['review_desc']?></p>
                                                </div>
                                            </div>
                                        </div>
										<?php } ?>
                                    </div>
                                   
                                </div>
                                
                                
                                
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </section>
       	<script type="text/javascript" src="assets/frontend/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/frontend/js/jquery_1.9.1_jquery.min.js"></script>
 	<script type="text/javascript">
	function get_subcat(id)
	{
		var cat_id = id;
		//alert(cat_id);
		var postData={
					  'cat_id':cat_id
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?home/subcat",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			 $('#subcategory_id').html(data);
			},
		  });
	}
</script>   
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#formhm").validate({
        // Specify the validation rules
        rules: {
			category_id :{required: true},
			subcategory_id :{required: true},

        },
        // Specify the validation error messages
        messages: {
			category_id: { required: "Trade required"},
			subcategory_id: { required: "Job Type required"},
        },
    });
  });
$(".next").click(function(){
	
	  if($(this).attr('id') =='nxtstep'){
  if($('#category_id').valid() && $('#subcategory_id').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
});

</script>