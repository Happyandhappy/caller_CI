 <section id="content">
            <div class="container">
                <div class="row">
                    <div id="main" class="col-md-12">
                    <div id="hotel-features" class="tab-container">
                            <ul class="tabs">
                                <li><a href="#hotel-description" data-toggle="tab">Home</a></li>
                                <li><a href="#hotel-amenities" data-toggle="tab">Services</a></li>
                                <li><a href="#photos-tab" data-toggle="tab">Work Gallery</a></li>
                                <li><a href="#hotel-reviews" data-toggle="tab">Reviews</a></li>
                                <li  class="active"><a href="#hotel-quotes" data-toggle="tab">Get A Quote</a></li>
                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="hotel-description">
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
                                    
                                    <!--<h2>Amenities Style 02</h2>
                                    <p>Maecenas vitae turpis condimentum metus tincidunt semper bibendum ut orci. Donec eget accumsan est. Duis laoreet sagittis elit et vehicula. Cras viverra posuere condimentum. Donec urna arcu, venenatis quis augue sit amet, mattis gravida nunc. Integer faucibus, tortor a tristique adipiscing, arcu metus luctus libero, nec vulputate risus elit id nibh.</p>
                                    <ul class="amenities clearfix style2">
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-wifi circle"></i>WI_FI</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-swimming circle"></i>swimming pool</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-television circle"></i>television</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-coffee circle"></i>coffee</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-aircon circle"></i>air conditioning</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-fitnessfacility circle"></i>fitness facility</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-fridge circle"></i>fridge</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-winebar circle"></i>wine bar</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-smoking circle"></i>smoking allowed</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-entertainment circle"></i>entertainment</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-securevault circle"></i>secure vault</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-pickanddrop circle"></i>pick and drop</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-phone circle"></i>room service</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-pets circle"></i>pets allowed</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-playplace circle"></i>play place</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-breakfast circle"></i>complimentary breakfast</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-parking circle"></i>Free parking</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-conference circle"></i>conference room</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-fireplace circle"></i>fire place</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-handicapaccessiable circle"></i>Handicap Accessible</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-doorman circle"></i>Doorman</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-tub circle"></i>Hot Tub</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-elevator circle"></i>Elevator in Building</div>
                                        </li>
                                        <li class="col-md-4 col-sm-6">
                                            <div class="fa fa-box style2"><i class="soap-icon-star circle"></i>Suitable for Events</div>
                                        </li>
                                    </ul>-->
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
								<div class="tab-pane fade in active" id="hotel-quotes">

									<form name="msform" id="msform" novalidate="novalidate" class="box" method="post" action="<?php echo base_url();?>index.php?trades/add_quotes">
  
									  <fieldset name="personal_form" id="personal_form">
										<div id="form_basic">
										<div id="packageamount"></div>
                                           <div class="row form-group">
                                              <div class="col-sms-6 col-sm-4">
                                                 <label>Trade</label>
													 <select class="input-text full-width" name="category_id" id="category_id" onChange="get_subcat(this.value);">
													 <option selected="selected" value="">Trades</option>
													 <?php $this->db->order_by('category_id', 'asc');
													$test = $this->db->get('tbl_category')->result_array();
													foreach($test as $rescat){ ?>
													 <option value="<?php echo $rescat['category_id'];?>"><?php echo $rescat['category_name'];?></option>
													 <?php } ?>
													 </select>
                                              </div>
                                              <div class="col-sms-6 col-sm-4">
                                                 <label>Job Type</label>
													 <select class="input-text full-width" name="subcategory_id" id="subcategory_id">
													 <option selected="selected" value="">Job Type</option>
													 </select>
                                              </div>
                                           </div>
										<div class="form-group row">
										  <div class="col-sm-8 col-md-8">
											<label>Name your job</label>
											<input type="text" class="input-text full-width" name="job_name" id="job_name" placeholder="Name your job" required='required'/>
											<input type="hidden" name="tradesman_id" value="<?php echo $tradsman[0]['staff_id']?>">
											<!--<?php echo $this->session->userdata('user_id'); 
													echo $this->session->userdata('fname');?>-->
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-8 col-md-8">
											<label>Describe your needs</label>
											<textarea class="input-text full-width" name="job_desc" id="job_desc" placeholder="Describe few more lines about your needs regarding the job"></textarea>
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-6 col-md-6">
											<label>Select The Your Status</label>
											<label for="rad-ready-hire">
											  <input type="radio" checked="" name="ready_hire" id="rad-ready-hire" value="1"/>
											  Ready To Hire</label>
											<label for="rad-plan">
											  <input type="radio" name="ready_hire" id="rad-plan" value="2"/>
											  Planing and Budgeting</label>
											<label for="rad-insurance">
											  <input type="radio" name="ready_hire" rad="rad-insurance" value="3"/>
											  Need a quote for inssurance purposes</label>
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-6 col-md-6">
											<label>When do you like to start your job?</label>
											<select name="job_start" id="job_start" class="full-width">
											  <option disabled="" selected="" value="">-- Select timing --</option>
											  <option value="URGENTLY">Urgently</option>
											  <option value="LT_2_DAYS">Within 2 days</option>
											  <option value="LT_2_WEEKS">Within 2 weeks</option>
											  <option value="LT_2_MONTHS">Within 2 months</option>
											  <option value="GT_2_MONTHS">2 months+</option>
											  <option value="FLEXIBLE_S_D">I am flexible on start date</option>
											</select>
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-6 col-md-6">
											<label>What's your approximate budget?</label>
											<br />
											<p> Our tradespeople estimate a job like this will cost from around £500 to £4000</p>
											<select name="job_budget" id="job_budget" class="full-width">
											  <option disabled="" selected="" value="">-- Select budget --</option>
											  <option value="LT_100">Under £100</option>
											  <option value="RANGE_100_250">Under £250</option>
											  <option value="RANGE_250_500">Under £500</option>
											  <option value="RANGE_500_1000">Under £1,000</option>
											  <option value="RANGE_1000_2000">Under £2,000</option>
											  <option value="RANGE_2000_4000">Under £4,000</option>
											  <option value="RANGE_4000_8000">Under £8,000</option>
											  <option value="RANGE_8000_15000">Under £15,000</option>
											  <option value="RANGE_15000_30000">Under £30,000</option>
											  <option value="GT_30000">Over £30,000</option>
											</select>
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-8 col-md-8">
											<label>What is the postcode for the job? </label>
											<input type="text" class="input-text full-width" name="zipcode" id="zipcode" placeholder="Enter Your Postal code" required='required'/>
										  </div>
										</div>
											<input type="button" class="button btn-medium green" value="Next" onclick="display_signup();">
										</div>
										
										<div id="form_login" style="display:none;">
										<h4 class="skin-color">Posted Job Before</h4>
										<div class="form-group row">
										  <div class="col-sm-8 col-md-4">
											<label>First Name</label>
											<input type="text" class="input-text full-width" name="fname" id="fname" placeholder="" required='required'/>
										  </div>
										  <div class="col-sm-8 col-md-4">
											<label>Last Name</label>
											<input type="text" class="input-text full-width" name="lname" id="lname" placeholder="" required='required'/>
										  </div>
										</div>
										<div class="form-group row">
										  <div class="col-sm-8 col-md-4">
											<label>Email</label>
											<input type="email" class="input-text full-width" name="email" id="email" placeholder="" required='required'/>
										  </div>
										  <div class="col-sm-8 col-md-4">
											<label>Phone No</label>
											<input type="text" class="input-text full-width" name="phoneno" id="phoneno" placeholder="" required='required'/>
										  </div>
										</div>
										<button type="submit" name="user_form" id="user_form" class="next button btn-medium green">Create Your Job</button>										
										</div>
									</fieldset>
									</form>

                                
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
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

 $(function() {
    // Setup form validation on the #register-form element
    $("#msform").validate({
        // Specify the validation rules
        rules: {
			category_id :{required: true},
			subcategory_id :{required: true},
            job_name: "required",
			job_desc :"required",
			job_start :{required: true},
			job_budget :{required: true},
			zipcode :"required",
			fname :"required",
			lname :"required",
			phoneno :"required",
			email: {
                required: true,
                email: true
				},	
            /*email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
			con_password: {
                required: true,
                minlength: 5,
				equalTo: "#password"
            },*/
        },
        // Specify the validation error messages
        messages: {
			category_id: { required: "Select Your Job"},
			subcategory_id: { required: "Select Your Job Estimate"},
            job_name: "Please enter job name",
            job_desc: "Please enter job description",
			job_start: { required: "Select Your Job"},
			job_budget: { required: "Select Your Job Estimate"},
			phoneno :"Please enter phone no",
			zipcode :"Please enter Postal Code",
			fname :"Please enter First Name",
			lname :"Please enter Last Name",
			email: {
						required: "Please enter your email address.",
						email: "Please enter a valid email address.",
					},
        },
    });
  });
  function display_signup()
{
	//alert('display_signup');
  if($('#category_id').valid() && $('#subcategory_id').valid() && $('#job_name').valid() && $('#job_desc').valid() && $('#job_start').valid() && $('#job_budget').valid() && $('#zipcode').valid()){
	  	//activate next step on progressbar using the index of next_fs
		 $("#form_basic").hide();
		 $("#form_login").show();
		//$("#details").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
	 //	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
}
$(".check").click(function(){
	//alert('on click');
 	  if($(this).attr('id') =='login_pro'){
  if($('#user_email').valid() && $('#user_password').valid()){
		var user_email = $("#user_email").val();
		var user_password = $("#user_password").val();
		var postData={
					  'user_email':user_email,
					  'user_password':user_password
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?quotes/user_login",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			if(data=='Enter Correct Details'){
			$("#msg").html('<p> Enter Correct Details</p>');
				return false;
			}		
			else{
				//alert('true');
				$('#details').html(data);
				$("#login_form").click();	
				}
			},
		  });
	  }else{
		return false;
	  }
	}
});

function display_thirdform()
{
	$("#form_basic").css('display','none');
	$("#form_third").css('display','block');
}
function display_basic_log()
{
		 $("#form_login").css('display','none');
		$("#form_third").css('display','none');
}

function display_basic()
{
	  	//activate next step on progressbar using the index of next_fs
		 $("#form_basic").css('display','block');
		 $("#form_login").css('display','none');
		 $("#form_third").css('display','none');
		 $("#replace_btn").html("<input type='button' name='user_form' id='user_form' class='next button btn-medium green' onclick='display_thirdform()' value='Next'/>");
		 
		//$("#details").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
}
$(".next").click(function(){
	//alert('on click');
 	  /*if($(this).attr('id') =='personal_form'){
	  	//activate next step on progressbar using the index of next_fs
	 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	}*/
 
	
 	if($(this).attr('id') =='business_form1'){
  if($('#job_name').valid() && $('#job_desc').valid() && $('#job_start').valid() && $('#job_budget').valid()){
	  	//activate next step on progressbar using the index of next_fs
		 $("#form_login").hide();
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var email = $("#email").val();
		//$("#form_login").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
	 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	  if($(this).attr('id') =='user_form'){
  if($('#fname').valid() && $('#lname').valid() && $('#email').valid() && $('#phoneno').valid()){
		//$("#details").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
	 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
 	  /*if($(this).attr('id') =='login_form'){
  if($('#user_email').valid() && $('#user_password').valid()){
	  	//activate next step on progressbar using the index of next_fs
	 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}*/

	if($(this).attr('id') =='next_business_form'){
  if($('#zipcode').valid() && $('#phoneno').valid() && $('#pin').valid()){
	  	//activate next step on progressbar using the index of next_fs
	 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInQuad'//'easeOutBounce'//'easeInOutBack'
	});
});

$(".previous").click(function(){

	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	//alert(current_fs.toSource());
	previous_fs = $(this).parent().prev();
	//alert(previous_fs.toSource());
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(previous_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		//easeOutQuad.'easeInOutQuad','easeInCubic','easeOutCubic',
		//easeInOutCubic //easeInQuart // easeOutQuart // easeInOutQuart//easeInQuint

		easing: 'easeInQuad'//'easeOutBounce'//'easeInOutBack'
	});
});
$(".first").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	//alert(current_fs.toSource());
	previous_fs = $(this).parent().prev();
	//alert(previous_fs.toSource());
	
	//de-activate current step on progressbar
	var ind = 1;
	//alert(ind);
	$("#progressbar li").eq($("fieldset").index(previous_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		//easeOutQuad.'easeInOutQuad','easeInCubic','easeOutCubic',
		//easeInOutCubic //easeInQuart // easeOutQuart // easeInOutQuart//easeInQuint

		easing: 'easeInQuad'//'easeOutBounce'//'easeInOutBack'
	});
});


</script> 
 	<script type="text/javascript">
	function signup()
	{
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var email = $("#email").val();
		$("#details").html('<p>Name :'+fname +' '+lname+'</p><p>Email :'+email+'</p>');
	}	
</script>   
 	<script type="text/javascript">
	function add_quotes()
	{
		var cat_id = $("#cat_id").val();
		var subcat_id = $("#subcat_id").val();
		var job_name = $("#job_name").val();
		var job_desc = $("#job_desc").val();
		var job_title = document.querySelector('input[name="ready_hire"]:checked').value;
		//alert(job_title);
		var job_start = $("#job_start").val();
		var job_budget = $("#job_budget").val();
		
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var email = $("#email").val();
		var password = $("#password").val();

		
		var zipcode = $("#zipcode").val();
		var phoneno = $("#phoneno").val();
		var postData={
					  'cat_id':cat_id,
					  'subcat_id':subcat_id,
					  'job_name':job_name,
					  'job_desc':job_desc,
					  'job_title':job_title,
					  'job_start':job_start,
					  'job_budget':job_budget,
					  'fname':fname,
					  'lname':lname,
					  'email':email,
					  'password':password,
					  'zipcode':zipcode,
					  'phoneno':phoneno
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?quotes/add_quotes",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			 $('#details').html(data);
			},
		  });
	}
</script>   
	<script type="text/javascript">
	function login_quotes()
	{
		var cat_id = $("#cat_id").val();
		var subcat_id = $("#subcat_id").val();
		var job_name = $("#job_name").val();
		var job_desc = $("#job_desc").val();
		var job_title = document.querySelector('input[name="ready_hire"]:checked').value;
		//alert(job_title);
		var job_start = $("#job_start").val();
		var job_budget = $("#job_budget").val();

		var zipcode = $("#zipcode").val();
		var phoneno = $("#phoneno").val();
		var postData={
					  'cat_id':cat_id,
					  'subcat_id':subcat_id,
					  'job_name':job_name,
					  'job_desc':job_desc,
					  'job_title':job_title,
					  'job_start':job_start,
					  'job_budget':job_budget,
					  'zipcode':zipcode,
					  'phoneno':phoneno
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?quotes/login_quotes",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			 $('#details').html(data);
			},
		  });
	}
</script>
	<script type="text/javascript">
	function user_login()
	{
		var user_email = $("#user_email").val();
		var user_password = $("#user_password").val();
		var postData={
					  'user_email':user_email,
					  'user_password':user_password
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?quotes/user_login",
			type: "POST",  
			data: postData,
			success: function(data){
			alert(data);
			$('#details').html(data);
			},
		  });
	}
</script>
