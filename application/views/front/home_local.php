<div id="slideshow">
  <div class="fullwidthbanner-container">
    <div class="global-map-area section parallax global-map-area-top-section" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="text-center description">
          <h1>For Homes With Potential</h1>
          <p>Find tradesmen for every job around the home - leaky taps,
            light fittings, a lick of paint or a loft conversion.</p>
          <p> Create a job for free, get a quote - job done.</p>
          <div class="search-tab-content">
            <div class="tab-pane fade active in" id="hotels-tab">
              <form method="post" id="formhm" name="formhm" novalidate="novalidate" action="<?php echo base_url();?>index.php?local/joblocal">
                <div class="row">
                  <div class="form-group col-sm-6 col-md-2 "> </div>
                  <div class="form-group col-sm-6 col-md-3 ">
                    <h4 class="title">I need a..</h4>
					<select class="input-text full-width" name="category_id" id="category_id" onchange="get_subcat(this.value);">
						<option selected="selected" value="">Trades</option>
						<?php $this->db->order_by('category_id', 'asc');
						$test = $this->db->get('tbl_category')->result_array();
						foreach($test as $res){ ?>
						<option value="<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></option>
						<?php } ?>
					</select>
                  </div>
                  <div class="form-group col-sm-8 col-md-3 ">
                    <h4 class="title">To Help Me With..</h4>
					<select class="input-text full-width" name="subcategory_id" id="subcategory_id">
						<option selected="selected" value="">Job Type</option>
					</select>
                  </div>
                  <div class="form-group col-sm-6 col-md-2 fixheight ">
                    <button type="submit" class="full-width icon-check next" id="nxtstep" name="nxtstep" data-animation-type="bounce" data-animation-duration="1">Next Step</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <br />
      </div>
    </div>
  </div>
</div>
<section id="content" style="padding-top:0px;">
            
            <div class="global-map-area section parallax no-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="text-center description">
                        <h1 class="heading-underlined">In Media Press Releases </h1>
                        <p> </p>
                    </div>
                    <br />
                    
                    <div class="row image-box style9">
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="<?php echo base_url();?>images/guradian.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="images/guradian.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="images/times.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="images/guradian.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="images/times.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <article class="box animated slideInRight" data-animation-type="slideInRight" data-animation-delay="0.3" style="animation-duration: 1s; animation-delay: 0.3s; visibility: visible;">
                                <figure>
                                    <a href="#" title=""> 
                                    <img src="images/guradian.png" alt="" width="170" height="160" />
                                    </a>
                                </figure>
                                
                            </article>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="global-map-area section parallax how_it_work_local" data-stellar-background-ratio="0.5" style="background-position: 50% 93.5px;">
                <div class="container">
                    <div class="text-center">
                        <h2>How it works </h2>
                    </div>
                    <br>
                    
				  <?php $works = $this->crud_model->get_records('tbl_howitworks');?>
      <div class="row image-box style8">
        <div class="col-md-4">
          <article class="box animated" data-animation-type="fadeInUp">
            <div class="details">
              <h2 class="box-title text-center">Create A Job</h2>
              <p class="box_border_top text-center"><?php echo $string = substr($works[0]['create'], 0, 250);?></p>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="box animated" data-animation-type="fadeInUp">
            <div class="details">
              <h2 class="box-title text-center">Get A Quote</h2>
              <p class="box_border_top text-center"><?php echo $string = substr($works[0]['quotes'], 0, 250);?></p>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="box animated" data-animation-type="fadeInUp">
            <div class="details">
              <h2 class="box-title text-center">Rate And Review</h2>
              <p class="box_border_top text-center"><?php echo $string = substr($works[0]['review'], 0, 250);?></p>
            </div>
          </article>
        </div>
      </div>
                    
                </div>
            </div>
			<div style="background-position: 50% -25.075px;" data-stellar-background-ratio="0.5" class="parallax no-bg">
                <div class="container">
					<div class="text-center description">
					  <h1>Find out what's happening near you</h1>
					  <div class="search-tab-content">
						<div id="hotels-tab" class="tab-pane fade active in">
						  <form action="<?php echo base_url();?>index.php?local/postalcode" novalidate="novalidate" name="formser" id="formser" method="post">
							<div class="row">
							  <div class="form-group col-sm-6 col-md-2 "> </div>
							  
							  <div class="form-group col-sm-8 col-md-5 ">
								<h4 class="title">To Help Me With..</h4>
									<input type="text" placeholder="Enter Postcode or Location" id="search_code" name="search_code" class="input-text full-width">
							  </div>
							  <div class="form-group col-sm-6 col-md-2 fixheight ">
								<button data-animation-duration="1" data-animation-type="bounce" name="nxtsearch" id="nxtsearch" class="full-width icon-check next" type="submit">Search</button>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					</div>
					<br>
				  </div>
            </div> 
			<div class="global-map-area section parallax no-bg" data-stellar-background-ratio="0.5" style="background-position: 0% -78px;">
                <div class="container">
                    <div class="text-center description">
                        <h1 class="heading-underlined">Have A Look On What Customers Speak Who Experienced The Services</h1>
                        <p> </p>
                    </div>
                    <br>
                    <div class="row block">
						<?php if(count($tradsman) > 0){
							foreach($tradsman as $res) { ?>
                    <div class="col-sm-4">
                        <div class="pricing-table white box apply_border">
                            <div class="header clearfix">
                                <i class="soap-icon-anchor circle blue-color"></i><h4 class="box-title"><span><?php echo $res['prefix'].' '.$res['name'].' '.$res['lname']?></span></h4>
								<span class="price"><small>Location</small><?php echo $res['country']?></span>
                            </div>
							<?php $review = $this->crud_model->get_records('tbl_ratingreview','',array('staff_id'=>$res['staff_id']),'');?>
							<div class="details inner_classification">
                            <p class="description"><?php echo $string = substr($res['company_desc'], 0, 200)?></p>
							    <div class="feedback  pull-right">
                                    <div data-original-title="4 stars" title="" class="five-stars-container" data-toggle="tooltip" data-placement="bottom"><span style="width: <?php echo ($review[0]['rating']/5)* 100 ?>%;" class="five-stars"></span></div>
                                    <!--<span class="review">75 reviews</span>-->
                                </div>
                                
                                <div class="action">
                                    <a target="_blank" href="<?php echo base_url();?>index.php?trades/profile/<?php echo base64_encode($res['staff_id'])?>" class="button btn-small">Profile</a>
                                    <a target="_blank" href="<?php echo base_url();?>index.php?trades/get_quotes/<?php echo base64_encode($res['staff_id'])?>" class="button btn-small popup-map">Request Quote</a>
                                </div>
							</div>
						</div>
                    </div>
						<?php }
						}
						else { ?>
                    <div class="col-sm-12">
						<a class="uppercase full-width button btn-large">No Available</a>
                    </div>
					<?php } ?>
				 </div>
                </div>
            </div>
            <div class="global-map-area section parallax no-bg-fill" data-stellar-background-ratio="0.5" style="background-position: 50% 93.5px;">
                <div class="container description">
                    <div class="text-center">
                        <h1 class="heading-underlined">Featured Trades Mens </h1>
                    </div>
                    <br>
                    
                    <div class="row hotel-list image-box hotel listing-style1 add-clearfix">
						<?php $this->db->select('*');
						$this->db->join('staff_profile','staff_profile.tradesmen_id=staff.staff_id');
						$this->db->join('tradesmen_company_details','tradesmen_company_details.tradesmen_id=staff.staff_id');
						$tradsman = $this->db->get('staff')->result_array();
						foreach($tradsman as $res) { ?>
                        <div class="col-md-3">
                             <!--<article class="box has-discount">-->
                             <article class="box">
                                 <figure>
                                     <a href="#" class="">
                                         <img style="height:200px !important;" alt="" src="<?php echo base_url();?>uploads/staff_image/<?php echo $res['profile_photo']?>">
                                         <!--<span class="discount"><span class="discount-text">Featured</span></span>-->
                                     </a>
                                 </figure>
                                 <div class="details">
                                     <h4 class="box-title"><?php echo $res['prefix'].' '.$res['name'].' '.$res['lname']?><small><?php echo $res['country']?></small></h4>
									<?php $review = $this->crud_model->get_records('tbl_ratingreview','',array('staff_id'=>$res['staff_id']),'');?>
                                     <div class="feedback">
                                         <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" title="" data-original-title="4 stars"><span style="width: <?php echo ($review[0]['rating']/5)* 100 ?>%;" class="five-stars"></span></div>
                                         <!--<span class="review">75 reviews</span>-->
                                     </div>
                                     <!--<p class="description"><?php echo $res['company_desc']?></p>-->
                                     <div class="action">
                                        <a href="<?php echo base_url();?>index.php?trades/profile/<?php echo base64_encode($res['staff_id'])?>" target="_blank" class="button btn-small text-center" title="View Profile">Profile</a>
                                         <a href="<?php echo base_url();?>index.php?trades/get_quotes/<?php echo base64_encode($res['staff_id'])?>" target="_blank" class="button btn-small  text-center" title="Get Quotes">Get A Quote</a>
                                     </div>
                                 </div>
                             </article>
                         </div>
						<?php } ?> 
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
 $(function() {
    // Setup form validation on the #register-form element
    $("#formser").validate({
        // Specify the validation rules
        rules: {
			search_code :{required: true},

        },
        // Specify the validation error messages
        messages: {
			search_code: { required: "Please Enter Postalcode"},
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
	
	if($(this).attr('id') =='nxtsearch'){
  if($('#search_code').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}

});

</script>