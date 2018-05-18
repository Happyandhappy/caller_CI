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
              <form method="post" id="formhm" name="formhm" novalidate="novalidate" action="<?php echo base_url();?>index.php?quotes/jobquotes">
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
						<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success">
                                <?php echo $this->session->flashdata('success');?>
                                <span class="close"></span>
                            </div> 
						<?php } ?>
						<?php if($this->session->flashdata('error')) { ?>
							<div class="alert alert-error">
                                <?php echo $this->session->flashdata('error');?>
                                <span class="close"></span>
                            </div>
						<?php } ?>
    <div class="container">
      <div class="text-center description">
        <h1 class="heading-underlined">How it works</h1>
        <p> </p>
      </div>
      <br />
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
  <!--<div class="global-map-area section parallax no-bg"  data-stellar-background-ratio="0.5" style="background-position: 50% 64px;background-color:#ecf3ea;">
    <div class="container">
      <div class="description">
        <h1 class="text-center heading-underlined">Featured Project</h1>
      </div>
      <div class="testimonial style3">
        <ul class="slides ">
          <li class="" style="width: 100%;float: left;margin-right: -100%;position: relative;opacity: 0;display: block;z-index: 1;height: 196px;">
            <div class="author"><a href="#"><img alt="" width="74" height="74" draggable="false"></a></div>
            <blockquote class="description">I like to thank <em>Your site</em> for making our House such a memorable ,as we were able to do everything on a single website.</blockquote>
            <h2 class="name">Jai Mathew</h2>
          </li>
          <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2; height: 196px;" class="testimonial-active-slide">
            <div class="author"><a href="#"><img src="http://placehold.it/270x270" alt="" width="74" height="74" draggable="false"></a></div>
            <blockquote class="description">I like to thank <em>Your site</em> for making our House such a memorable ,as we were able to do everything </blockquote>
            <h2 class="name">Client Name</h2>
          </li>
        </ul>
        <ul class="testimonial-direction-nav">
          <li><a class="testimonial-prev" href="#" tabindex="-1">Previous</a></li>
          <li><a class="testimonial-next testimonial-disabled" href="#" tabindex="-1">Next</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="global-map-area section parallax map_banner_img "  data-stellar-background-ratio="0.5" style="background-position: 50% 64px;">
    <div class="section container">
      <div class="row " style="padding-bottom:100px;">
        <div class="col-sms-6 col-sm-6 col-md-2"> </div>
        <div class="col-sms-6 col-sm-6 col-md-8">
          <div class="description">
            <h1 class="text-center heading-underlined"> Jobs and Projects happening in your area</h1>
            <div class="search-tab-content" style="padding-top:0px;">
              <div class="tab-pane fade active in" id="hotels-tab">
                <form action="hotel-list-view.html" method="post">
                  <div class="row">
                    <div class="form-group col-sm-8 col-md-4 make_search_center">
                      <h4 class="title" style="color:#000;">Enter Your Post Code Here</h4>
                      <input type="text" class="input-text full-width" placeholder="Enter Post Code or Area">
                    </div>
                    <div class="form-group col-sm-6 col-md-2 fixheight make_search_center">
                      <button type="submit" class="full-width icon-check animated bounce" data-animation-type="bounce" data-animation-duration="1" style="animation-duration: 1s; visibility: visible;">Go</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <h4 class="box-title text-center" style="margin-bottom:20px;"> <a href="#">Most Popular Places</a></h4>
            <ul class="arrow-square">
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Oxfordshire" class="special_links_places">Oxfordshire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Avon " class="special_links_places">Avon</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Gwent" class="special_links_places">Gwent</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Northern-Ireland" class="special_links_places">Northern Ireland</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Manchester-Area " class="special_links_places">Manchester Area </a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Cheshire" class="special_links_places">Cheshire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 "> <a href="/local/Leicestershire" class="special_links_places">Leicestershire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4"> <a href="/local/Somerset" class="special_links_places">Somerset</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a href="/local/Staffordshire" class="special_links_places">Staffordshire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a href="/local/Hampshire" class="special_links_places">Hampshire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a href="/local/Nottinghamshire" class="special_links_places">Nottinghamshire</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a href="/local/Surrey" class="special_links_places">Surrey</a> </li>
            </ul>
          </div>
        </div>
        <div class="col-sms-6 col-sm-6 col-md-2"> </div>
      </div>
      <div class="row "  style="padding-bottom:100px;">
        <div class="col-sms-6 col-sm-6 col-md-1"> </div>
        <div class="col-sms-6 col-sm-6 col-md-10">
          <div class="description">
            <h1 class="text-center heading-underlined"> Jobs and Projects happening in your area</h1>
            <h4 class="box-title text-center" style="margin-bottom:20px;"> <a href="#">Most Popular Places</a></h4>
            <ul class="arrow-square">
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places"href="/local/aerial-network-specialists">Aerial / Network Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places"href="/local/bathroom-specialists">Bathroom Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/bricklayers">Bricklayer</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/builders">Builder</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/carpenters-joiners">Carpenter / Joiner</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/cleaners">Cleaner</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/drainage-specialists">Drainage Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/driveway-services">Driveway Services</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/electricians">Electrician</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/flooring-specialists">Flooring Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/gardeners-garden-designers">Gardener / Garden Designer</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/handyman">Handyman</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/heating-engineers">Heating Engineer</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/kitchen-specialists">Kitchen Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/locksmiths">Locksmith</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/loft-conversion-specialists">Loft Conversion Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/metalworkers">Metalworker</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/painters-decorators">Painter / Decorator</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/pest-control">Pest Control</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/plasterers-renderers">Plasterer / Renderer</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/plumbers">Plumber</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/roofers">Roofer</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/security-specialists">Security Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/specialist-services">Specialist Tradesman</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/stoneworkers-stonemasons">Stoneworker / Stonemason</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/swimming-pool-specialists">Swimming Pool Specialist</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="/local/tilers">Tiler</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="#">Traditional Craftsman</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="#">Tree Surgeon</a> </li>
              <li class="col-sm-12 col-md-6 col-lg-4 padded-bottom-half"> <a class="special_links_places" href="#">Window &amp; Conservatory Specialist</a> </li>
            </ul>
          </div>
        </div>
        <div class="col-sms-6 col-sm-6 col-md-1"> </div>
      </div>
    </div>
  </div>-->
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