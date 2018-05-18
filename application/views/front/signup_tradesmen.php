<!-- begin register -->

<script>
   fbq('track', 'InitiateCheckout', {
  content_name: '<?php echo $pixel_plname; ?>',
  content_ids: ['subs_<?php echo $pixel_plid ?>'],
  content_type: 'product',
  value: '<?php echo $pixel_amount; ?>',
  currency: 'USD'
});
</script>

<div class="register register-with-news-feed bg-white"> 
   
   <!-- begin news-feed -->
   
   <div class="news-feed">
      <div class="news-image"> <img src="<?php echo base_url()?>assets/img/login-bg/bg-8.jpg" alt=""> </div>
      <!--div class="news-caption">
         <h4 class="caption-title"><i class="fa fa-edit text-success"></i> Looking up a phone number</h4>
         <p> Ever curious who you are making calls and sending messages to? You can do a lookup on a  number to learn more about that number and who it belongs to. </p>
      </div-->
   </div>
   
   <!-- end news-feed --> 
   
   <!-- begin right-content -->
   
   <div class="right-content bg-white"> 
      
      <!-- begin register-header -->
      
      <h5 class="text-info p-10"> <a href="<?php echo base_url()?>home/pricing">Back</a> | <a href="<?php echo base_url()?>home">Go to Home page </a></h5>
      
      <!-- end register-header --> 
      
      <!-- begin register-content -->
      
      <div class="register-content">
         <form class="form-horizontal form-bordered" onsubmit="return myFunction()" data-parsley-validate="true"  action="<?php echo base_url(); ?>signup/tradesmen_payment" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
            <label class="control-label">Name <span class="text-danger">*</span></label>
            <div class="row row-space-10">
               <div class="col-md-6 m-b-15">
                  <input class="form-control" placeholder="First name" data-parsley-required="true" type="text" name="first_name" value="<?php echo set_value('first_name')?>">
                  <span style="color:red;"><?php echo form_error('first_name','<span for="category" class="help-inline">','</span>');?></span></div>
               <div class="col-md-6 m-b-15">
                  <input class="form-control" placeholder="Last name" data-parsley-required="true" type="text" name="last_name" value="<?php echo set_value('last_name')?>">
                  <span style="color:red;"><?php echo form_error('last_name','<span for="category" class="help-inline">','</span>');?></span></div>
            </div>
            <label class="control-label">Phone number </label>
            <div class="row m-b-15">
               <div class="col-md-12">
                   <input class="form-control cust_phone_no" placeholder="Phone number" id="contact"  type="text" name="contact" value="<?php echo set_value('contact')?>">
                     <span style="color:red;"><?php echo form_error('contact','<span for="category" class="help-inline">','</span>');?></span></div>
            </div>
             
            <div class="row m-b-15" style="display:none;">
               <div class="col-md-12">
                  <input class="form-control cust_phone_no" placeholder="Phone number "  type="text" name="call_forward_no" value="<?php echo set_value('call_forward_no')?>">
                    <span style="color:red;"><?php echo form_error('call_forward_no','<span for="category" class="help-inline">','</span>');?></span></div>
            </div>
            
             <div class="row m-b-15"></div>
            <label class="control-label">Email <span class="text-danger">*</span></label>
            <div class="row m-b-15">
               <div class="col-md-12">
                  <input class="form-control" name="email" id="email" placeholder="Email address" data-parsley-type="email" data-parsley-required="true" type="email" value="<?php echo set_value('email')?>">
                  <span style="color:red;"><?php echo form_error('email','<span for="category" class="help-inline">','</span>');?></span></div>
            </div>
              <label class="control-label">Password <span class="text-danger">*</span></label>
            <div class="row row-space-10">
               <div class="col-md-6 m-b-15">
                  <input class="form-control" placeholder="Password" data-parsley-required="true" type="password" name="password" value="<?php echo set_value('password')?>">
                  <span style="color:red;"><?php echo form_error('password','<span for="category" class="help-inline">','</span>');?></span></div>
               <div class="col-md-6 m-b-15">
                  <input class="form-control" placeholder="Re-enter Password" data-parsley-required="true" type="password" name="confirmed_password" value="<?php echo set_value('confirmed_password')?>">
                  <span style="color:red;"><?php echo form_error('confirmed_password','<span for="category" class="help-inline">','</span>');?></span></div>
            </div>
            <label class="control-label">Company Name </label>
            <div class="row m-b-15">
               <div class="col-md-12">
                  <input class="form-control" placeholder="Company Name (optional)" type="text" name="company_name" id="company_name" value="<?php echo set_value('company_name')?>">
               </div>
            </div>
            <input type="hidden" value="<?php echo $plan_amount ?>" name="plan_amount" />
            <input type="hidden" value="<?php echo $plan_amount_new ?>" name="plan_amount_new" />
            <input type="hidden" value="<?php echo $plan_id ?>" name="plan_id" />
            <div class="checkbox m-b-10">
               <label>
                  <input name="terms" type="checkbox">
                  By clicking Sign Up, you agree to our <a href="<?php echo base_url()?>home/termscondition">Terms</a> and that you have read our <a href="<?php echo base_url()?>home/privacy_policy">Data Policy</a>, including our <a href="#">Cookie Use</a>. <span style="color:red;"><?php echo form_error('terms','<span for="category" class="help-inline">','</span>');?></span> </label>
            </div>
            <div class="register-buttons">
               <button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
            </div>
            <div class="m-t-10 m-b-10  text-inverse"> Already a member? Click <a href="<?php echo base_url()?>login">here</a> to login. </div>

                 
            <label class="control-label">Promo Code </label>
            <div class="row m-b-15">
               <div class="col-md-12">
                  <input class="form-control" placeholder="Promo Code (optional)" type="text" name="promocode" id="promocode" value="<?php echo set_value('promo_code')?>">
               </div>
            </div>
            
            <hr>
         </form>
      </div>
      
      <!-- end register-content --> 
      
   </div>
   
   <!-- end right-content --> 
   
</div>

<!-- ================== BEGIN BASE JS ================== --> 

<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script> 
<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script> 
<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script> 
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script> 

<!--[if lt IE 9]>

		<script src="assets/crossbrowserjs/html5shiv.js"></script>

		<script src="assets/crossbrowserjs/respond.min.js"></script>

		<script src="assets/crossbrowserjs/excanvas.min.js"></script>

	<![endif]--> 

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script> 
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script> 

<!-- ================== END BASE JS ================== --> 

<!-- ================== BEGIN PAGE LEVEL JS ================== --> 

<script src="assets/js/apps.min.js"></script> 

<!-- ================== END PAGE LEVEL JS ================== --> 

<script>

		$(document).ready(function() {

			App.init();

		});

		

		
/*function myFunction() {

    var pass1 = document.getElementById("password").value;

    var pass2 = document.getElementById("confirmed_password").value;

    var ok = true;

    if (pass1 != pass2) {

        //alert("Passwords Do not match");

        document.getElementById("password").style.borderColor = "#E34234";

        document.getElementById("confirmed_password").style.borderColor = "#E34234";

        ok = false;

    }

    else {

        //alert("Passwords Match!!!");

    }

    return ok;

}*/

function myFunction()
{
	
}

	</script>
</body></html>