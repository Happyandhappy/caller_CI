<style>


/*form styles*/
#msform {
	width: 100%;
	/*position: relative;*/
}
fieldset {
	background: white;
	border: 1px solid #cccccc;
	border-radius: 3px;
	padding: 10px 30px;
	width: 80%;
	margin: 0 10%;
	
	/*stacking fieldsets above each other*/
	/*position: absolute;*/
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
	display: none;
}

/*buttons*/
#msform .action-button {
	width: 100px;
	background: #27AE60;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
}

/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
    list-style-type: none;
    color: #01b7f3;
    text-transform: uppercase;
    font-size: 12px;
    width: 25%;
    margin-top: 20px;
    float: left;
    text-align: center;
    position: relative;
}
#progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 50px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    display: block;
    color: #333;
     background: white;
    border-radius: 50%;
    border-width: 40px;
    margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
    content: '';
    width: 87%;
    height: 6px;
    background: #f5f5f5;
    position: absolute;
    left: -42%;
    top: 21px;
    z-index: 0;
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #27AE60;
	color: white;
}

</style>

<!-- jQuery Form Validation code --> 
<!-- multistep form --> 
<!-- progressbar -->
<ul id="progressbar">
  <li class="active">CREATE YOUR JOB</li>
  <li>CONTACT DETAILS</li>
  <li>CONFIRMATION</li>
</ul>
<!-- fieldsets -->
<form name="msform" id="msform" novalidate="novalidate" class="box">
  <!--<fieldset>
		<h2 class="fs-title">Create your account</h2>
		<h3 class="fs-subtitle">This is step 1</h3>
		<input type="text" name="email" id="email" placeholder="Email" value=""/>
		<input type="password" name="password" id="password" placeholder="Password" />
		<input type="password" name="cpass" placeholder="Confirm Password" />
		<input type="button" name="next" id="formfirst" class="next action-button" value="Next" />
</fieldset>-->
  
  <fieldset name="personal_form" id="personal_form">
	<div id="form_basic">
    <div id="packageamount"></div>
    <h4 class="skin-color">Create Your Job</h4>
    <p> We would like to know litle more about your job</p>
    <div class="form-group row">
      <div class="col-sm-8 col-md-8">
        <label>Name your job</label>
        <input type="text" class="input-text full-width" name="job_name" id="job_name" placeholder="Name your job" required='required'/>
		<input type="hidden" id="cat_id" value="<?php echo $_POST['category_id']?>"><input type="hidden" id="subcat_id" value="<?php echo $_POST['subcategory_id']?>">
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
 <?php if($this->session->userdata('user_id')=="") { ?>
    <!--<input type="button" name="business_form" id="business_form" class="button btn-medium green" onclick="display_signup()" value="Next"/>-->
	<div id="replace_btn">
		<input type="button" class="button btn-medium green" value="Next" onclick="display_signup();">
	</div> 
 <?php } else {?>
    <input type="button" name="business_form1" id="business_form1" class="next button btn-medium green" value="Next"/>
 <?php } ?>
	</div>
	
 <?php if($this->session->userdata('user_id')=="") { ?>
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
        <label>Password</label>
        <input type="password" class="input-text full-width" name="password" id="password" placeholder="" required='required'/>
      </div>
    </div>
    <input type="button" name="user_form" id="user_form" class="next button btn-medium green" onclick="signup()" value="Sing Up" />
	
    <div class="form-group row">
      <div class="col-sm-8 col-md-4">
        <label>Email</label>
        <input type="email" class="input-text full-width" name="user_email" id="user_email" placeholder="" required='required'/>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-8 col-md-4">
        <label>Password</label>
        <input type="password" class="input-text full-width" name="user_password" id="user_password" placeholder="" required='required'/>
      </div>
    </div>
      <div class="col-sm-8 col-md-2" id="msg">
      </div>

    <input type="button" name="login_form" id="login_form" class="next button btn-medium green" style="visibility:hidden;"value="Next" />
    <input type="button" class="check button btn-medium green" id="login_pro" value="Log In" />
	</div>
 <?php } else {?>
 
 <?php } ?>
 <div id="form_third" style="display:none;">
  <div class="form-group row">
	  <div class="col-sm-8 col-md-8" id="details">
 <?php if($this->session->userdata('user_id')=="") { ?>
		<h1 class="skin-color" >Your Contact Details</h1>
		<!--<label>Name :<input type="text" id="name1" readonly></label>
		<label>Email :<input type="text" id="email1" readonly></label>--> 
 <?php } else { ?>
 		<h1 class="skin-color" >Your Contact Details</h1>
		<label>Name :<?php echo $this->session->userdata('fname')?> <?php echo $this->session->userdata('lname')?></label>
		<label>Email :<?php echo $this->session->userdata('email')?></label> 
 <?php } ?>
	  </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-8 col-md-8">
    <h3>Tell us where the job location</h3>
      <p>We use the postcode to match you with local tradespeople. Only tradespeople who want to quote will be able to see your details.</p>
      <input type="text" name="zipcode" id="zipcode" class="input-text full-width" value="" placeholder="Zip Code" />
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-8 col-md-8">
      <h3> What number can the tradesperson contact you on?</h3>
      <label>Enter Your Phone </label>
      <input type="text" name="phoneno" id="phoneno" class="input-text full-width" value="" placeholder="07123456789" />      <button type="button" class="next button btn-medium sky-blue1" id="send_pin" name="send_pin">Send Pin</button> </div>
    <div class="col-sm-8 col-md-8">
      <label>Verify</label>
      <input type="text" name="pin" id="pin" class="input-text full-width" value="" placeholder="Enter the Pin" />	      <button type="button" class="check1 button btn-medium sky-blue1" id="verify_pin" style="display:none;" name="verify_pin">Verify</button> </div>		<div id="notverify"></div>
  </div>
  <hr />
  <div class="form-group row">
    <div class="">
      <p>Tradespeople pay for the chance to quote on your job, so we may contact you to confirm your job details.</p>
      <p>We don’t employ the tradespeople who use our site, so it’s your responsibility to choose and employ a tradesperson. We verify Gas Safe registration but do not check other qualifications so you should always review, these as well as their reviews, ratings and insurance before making your decision.</p>
    </div>
  </div>
  <!--<input type="button" name="previous_form" id="previous_form" class="button btn-medium red" value="Previous" />-->
 <?php if($this->session->userdata('user_id')=="") { ?>
  <input type="button" class="button btn-medium red" value="previous" onclick="display_basic();">
   <?php } else {?>
  <input type="button" class="previous button btn-medium red" value="previous" onclick="display_basic_log();">
 <?php } ?>
 <?php if($this->session->userdata('user_id')=="") { ?>
  <input type="button" name="next_business_form" id="next_business_form" style="display:none;margin-top: -34px; margin-left: 124px;" class="next button btn-medium green" value="Submit My Job" />
   <?php } else {?>
  <input type="button" name="next_business_form" id="next_business_form" style="display:none;margin-top: -34px; margin-left: 124px;" class="next button btn-medium green" value="Submit My Job" />
 <?php } ?>
</div>
	<div id="thanku" style="display:none;">
		<h1> Thank you for posting job...</h1>
		<h3> Your job is submitted for the review once it is done then will be published and you will get the quotes. </h3>
	</div>
  </fieldset>
</form>
<script>
function getIdFormDiv(IdValue){
		jQuery('#IdDtailsForm').slideUp(100,'slow');	
	alert(IdValue);
	jQuery("#labelforIDNumber").html(IdValue+' Number');
	jQuery("#IDProofName").val(IdValue);
	jQuery('#IdDtailsForm').slideDown(1000,'slow');	
	}

</script> 
<!-- jQuery --> 
<script src="http://thecodeplayer.com/uploads/js/jquery-1.9.1.min.js" type="text/javascript"></script> 
<!-- jQuery easing plugin --> 
<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script> 
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
            job_name: "required",
			job_desc :"required",
			zipcode :{required: true,					  digits: true},
			phoneno :"required",
			pin :"required",
			fname :"required",
			lname :"required",
			email: {
                required: true,
                email: true,
                remote: {
                    url: "<?php echo base_url();?>index.php?quotes/email_check",
                    type: "post"
                }
			},	
            password: {                required: true,                minlength: 5            },
			user_email :"required",
			user_password: {required: true},	
			job_start :{required: true},
			job_budget :{required: true},
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
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
			/*con_password: {
                required: "Please provide a confirm password",
                minlength: "Your confirm password must be at least 5 characters long",
				equalTo : "Confirm password value should same as create password"
            },*/
            job_name: "Please enter job name",
            job_desc: "Please enter job description",
			job_start: { required: "Select Your Job"},
			job_budget: { required: "Select Your Job Estimate"},
			zipcode: {						required: "Please enter zipcode",						digits: "Please enter valid number.",					},
			phoneno :"Please enter phone no",
			pin :"Please enter pin no",
			fname :"Please enter First Name",
			lname :"Please enter Last Name",
			email: {
						required: "Please enter your email address.",
						email: "Please enter a valid email address.",
						remote: "Email already in use!"
					},

			user_email :"Please enter Email",
			user_password: {required: "Please enter your Password."},
        },
    });
  });
  function display_signup()
{
	//alert('display_signup');
  if($('#job_name').valid() && $('#job_desc').valid() && $('#job_start').valid() && $('#job_budget').valid()){
	  	//activate next step on progressbar using the index of next_fs
		 $("#form_basic").hide();
		 $("#form_login").show();
		//$("#details").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
	 //	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
}$(".check1").click(function(){ 	  if($(this).attr('id') =='verify_pin'){  if($('#pin').valid()){		var pin = $("#pin").val();		var phoneno = $("#phoneno").val();		var postData={					  'pin':pin,					  'phoneno':phoneno					 };			$.ajax({			url: "<?php echo base_url();?>index.php?quotes/pin_verify",			type: "POST",  			data: postData,			success: function(data){			//alert(data);			if(data=='0'){			$("#notverify").html('<p> Enter Correct Pin</p>');				return false;			}					if(data=='1'){				$("#next_business_form").css('display','block');				$("#notverify").css('display','none');				return false;			}					},		  });	  }else{		return false;	  }	}});
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
				$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li>CONFIRMATION</li>');
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
		$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li>CONTACT DETAILS</li><li>CONFIRMATION</li>');
}

function display_basic()
{
	  	//activate next step on progressbar using the index of next_fs
		 $("#form_basic").css('display','block');
		 $("#form_login").css('display','none');
		 $("#form_third").css('display','none');
         $("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li>CONTACT DETAILS</li><li>CONFIRMATION</li>');
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
		$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li>CONFIRMATION</li>');
	 	//$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	  if($(this).attr('id') =='user_form'){
  if($('#fname').valid() && $('#lname').valid() && $('#email').valid() && $('#password').valid()){
		$("#form_third").show();
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var email = $("#email").val();
		//$("#details").append('<p>Name '+fname +' '+lname+'</p><p>Email '+email+'</p>');
	 	//$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
 	  if($(this).attr('id') =='send_pin'){	if($('#zipcode').valid() && $('#phoneno').valid()){		//var zipcode = $("#zipcode").val();		var phoneno = $("#phoneno").val();		$(".error").empty('');						var postData={					  'phoneno':phoneno,				 };			$.ajax({			url: "<?php echo base_url();?>index.php?quotes/sms",			type: "POST",  			data: postData,			success: function(data){			if(data=='1'){				$("#verify_pin").css('display','block');				return false;			}					},		  });	  }else{		return false;	  }	}	  /*if($(this).attr('id') =='login_form'){
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
	 	//$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$(".error").empty('');
				$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li class="active">CONFIRMATION</li>');
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
			url: "<?php echo base_url();?>index.php?local/add_local",
			type: "POST",  
			data: postData,
			success: function(data){
			 $('#details').html(data);
			},
		  });
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
		$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li>CONFIRMATION</li>');
		$("#details").html('<p>Name :'+fname +' '+lname+'</p><p>Email :'+email+'</p>');
	}	
</script>   
 	<script type="text/javascript">
	function add_local()
	{
		$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li class="active">CONFIRMATION</li>');
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
			url: "<?php echo base_url();?>index.php?local/add_local",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li class="active">CONFIRMATION</li>');
			 $('#details').html(data);
			},
		  });
	}
</script>   
	<script type="text/javascript">
	function login_local()
	{
		$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li class="active">CONFIRMATION</li>');
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
			url: "<?php echo base_url();?>index.php?local/login_local",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			$("#progressbar").html('<li class="active">CREATE YOUR JOB</li><li class="active">CONTACT DETAILS</li><li class="active">CONFIRMATION</li>');
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
