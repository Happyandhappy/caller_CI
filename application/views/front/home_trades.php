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
              <form method="post" id="formhm" name="formhm" novalidate="novalidate" action="<?php echo base_url();?>index.php?trades/jobtrades">
                <div class="row">
                  <div class="form-group col-sm-6 col-md-2 "> </div>
                  <div class="form-group col-sm-6 col-md-3 ">
                    <h4 class="title">I need a..</h4>
					<select class="input-text full-width" name="category_id" id="category_id" onchange="get_subcat(this.value);">
						<option selected="selected" value="">Trades</option>
						<?php $this->db->order_by('category_id', 'asc');
						$test = $this->db->get('tbl_category')->result_array();
						foreach($test as $res){ ?>
						<option value="<?php echo $res['category_id'];?>" <?php if($cat_id==$res['category_id']) echo 'selected';?>><?php echo $res['category_name'];?></option>
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
  <div class="global-map-area section parallax no-bg"  data-stellar-background-ratio="0.5" style="background-position: 50% 64px;background-color:#ecf3ea;">
    <div class="container">
        <div id="main">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <!--<h4 class="search-results-title"><i class="soap-icon-search"></i><b>1,984</b> results found.</h4>-->
                    <div class="toggle-container filters-container">
                        <div class="panel style1 arrow-right">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#amenities-filter" class="collapsed">Trades</a>
                            </h4>
                            <div id="amenities-filter" class="panel-collapse collapse">
                                <div class="panel-content">
                                    <ul class="">
										<?php $this->db->order_by('category_id', 'asc');
										$cat = $this->db->get('tbl_category')->result_array();
										foreach($cat as $res){ ?>
										<li><a href="<?php echo base_url();?>index.php?trades/trades_cat/<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></a></li>
										<?php } ?>
									</ul>	
                                </div>
                            </div>
                        </div>
                        <div class="panel style1 arrow-right">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#amenities-filter1" class="collapsed">Featured Trades People</a>
                            </h4>
                            <div id="amenities-filter1" class="panel-collapse collapse">
                                <div class="panel-content">
                                    <ul class="">
										<?php $this->db->order_by('category_id', 'asc');
										$cat = $this->db->get('tbl_category')->result_array();
										foreach($cat as $res){ ?>
										<li><a href="<?php echo base_url();?>index.php?trades/trades_cat/<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></a></li>
										<?php } ?>
									</ul>	
                                </div>
                            </div>
                        </div>
                        <div class="panel style1 arrow-right">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#amenities-filter2" class="collapsed">Popular Trades</a>
                            </h4>
                            <div id="amenities-filter2" class="panel-collapse collapse">
                                <div class="panel-content">
                                    <ul class="">
										<?php $this->db->order_by('category_id', 'asc');
										$cat = $this->db->get('tbl_category')->result_array();
										foreach($cat as $res){ ?>
										<li><a href="<?php echo base_url();?>index.php?trades/trades_cat/<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></a></li>
										<?php } ?>
									</ul>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 col-md-9">
                    
                    <div class="listing-style3 hotel">
						<?php foreach($tradsman as $res) { ?>
						<article class="box force_padding">
                            <figure class="col-sm-2 col-md-2">
                                <a title="" href="#" class="">
								<?php if(empty($res['profile_photo'])) {?>
								<img width="270" height="160" alt="" src="<?php echo base_url()?>uploads/staff_image/default.png"></a>
								
								<?php } else {?> 
								<img width="270" height="160" alt="" src="<?php echo base_url()?>uploads/staff_image/<?php echo $res['profile_photo']?>"></a>
								<?php } ?>
                            </figure>
                            <div class="details col-sm-7 col-md-8">
                                <div>
                                    <div>
                                        <h4 class="box-title differential_small"><?php echo $res['prefix'].' '.$res['name'].' '.$res['lname']?><small><i class="soap-icon-businessbag blue-color"></i> <?php echo $res['company_name']?></small> <!--<small><i class="soap-icon-departure blue-color"></i><?php echo $res['house_name'].','.$res['street'].','.$res['town'].','.$res['country'].','.$res['postal_code']?></small>--></h4>
                                    </div>
										<?php $review = $this->crud_model->get_records('tbl_ratingreview','',array('staff_id'=>$res['staff_id']),'');?>	
									<div>
                                        <div class="five-stars-container">
                                            <span class="five-stars" style="width: <?php echo ($review[0]['rating']/5)* 100 ?>%;"></span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div>
                                    <div>
                                        <a href="<?php echo base_url();?>index.php?trades/profile/<?php echo base64_encode($res['staff_id'])?>" target="_blank" class="button btn-small text-center" title="View Profile">Profile</a>
                                         <a href="<?php echo base_url();?>index.php?trades/get_quotes/<?php echo base64_encode($res['staff_id'])?>" target="_blank" class="button btn-small  text-center" title="Get Quotes">Get A Quote</a>
                                    </div>
                                </div>
                            </div>
                        </article>	
						<?php } ?>
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