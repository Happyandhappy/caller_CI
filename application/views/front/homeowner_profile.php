<section class="gray-area" id="content">
  <div class="container shortcode">
    <div class="block">
      <div class="travelo-box box-full">
        <div class="contact-form">
          <div class="row">
            <div class="col-sm-12">
              <div class="parallax how_it_work_local" data-stellar-background-ratio="0.5" style="background-position: 50% 93.5px;">
                <div class="view-profile col-sm-12">
                  <div class="col-sm-12 no-float no-padding">
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
                    <form method="post" action="<?php echo base_url();?>dashboard/user_profile" enctype="multipart/form-data" id="fmprofile">
					<?php
						$this->db->select('*');
						$this->db->where('user_id',$this->session->userdata('user_id'));
						$test = $this->db->get('tbl_user')->result_array();?>
                      <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                          <label>First Name</label>
                          <input type="text" class="input-text full-width" name="fname" id="fname" placeholder="First Name" required='required' value="<?php echo $test[0]['fname']?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                          <label>Last Name</label>
                          <input type="text" class="input-text full-width" name="lname" id="lname" placeholder="Last Name" required='required' value="<?php echo $test[0]['lname']?>"/>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-8 col-md-6">
                          <label>Phone no</label>
                          <input type="text" class="input-text full-width" name="phone_no" id="phone_no" placeholder="Phone No" required='required' value="<?php echo $test[0]['phone_no']?>"/>
                        </div>
                      </div>
					  <h2>Old Profile Picture</h2>
					<figure class="col-sm-4 col-md-12"> <a><img width="230" height="180" alt="" src="<?php echo base_url();?>/uploads/homeowner_profile/<?php echo $test[0]['profile_image']?>"></a></figure>
					 <div class="row form-group">
						<div class="col-sms-12 col-sm-6 no-float">
							<div class="fileinput full-width" style="line-height: 34px;">
								<input type="file" data-placeholder="select image" class="input-text" name="userfile" id="userfile"><input type="text" class="custom-fileinput input-text" placeholder="select image">
							</div>
						</div>
					</div>
						<hr>
                      <div class="form-group col-sm-5 col-md-4 no-float no-padding no-margin">
                        <button class="btn-medium full-width" id="btn_submit" name="btn_submit" type="submit">Update Profile</button>
                      </div>
                    </form>
                  </div>
                </div>
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
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script> 
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmprofile").validate({
        // Specify the validation rules
        rules: {
			fname :{required: true},
			lname :{required: true},
			phone_no :{required: true},

        },
        // Specify the validation error messages
        messages: {
			fname: { required: "First Name required"},
			lname: { required: "Last Name required"},
			phone_no: { required: "Phone No required"},
        },
    });
  });
$(".next").click(function(){
	
	if($(this).attr('id') =='btn_submit'){
  if($('#fname').valid() && $('#lname').valid() && $('#phone_no').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
});

</script> 
