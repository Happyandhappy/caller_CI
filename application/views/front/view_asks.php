<div id="slideshow">
  <div class="fullwidthbanner-container">
    <div class="global-map-area section parallax global-map-area-top-section" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="text-center description">
          <h1>For Homes With Potential</h1>
          <p>Find tradesmen for every job around the home - leaky taps,
            light fittings, a lick of paint or a loft conversion.</p>
          <p> Create a job for free, get a quote - job done.</p>
        </div>
        <br />
      </div>
    </div>
  </div>
</div>
<section id="content" style="padding-top:0px;">
  <div class="global-map-area section parallax no-bg"  data-stellar-background-ratio="0.5" style="background-position: 50% 64px;background-color:#ecf3ea;">
    <div class="container">
		 <div class="travelo-box box-full">
			<div class="contact-form">
					<div class="row">
						<div class="col-sm-10">
							<div class="form-group">
								<label>Give your question a title</label>
								<input type="text" class="input-text full-width" id="title" name="title">
							</div>
						</div>
						<div class="col-sm-10">
							<div class="form-group">
								<label>What would you like to know? (The more details you can provide, the better)</label>
								<textarea placeholder="write message here" class="input-text full-width" rows="6" id="review" name="review"></textarea>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" class="input-text full-width" id="first_name" name="first_name">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="input-text full-width" id="email" name="email">
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>Last Name</label>
								<input type="text" class="input-text full-width" id="last_name" name="last_name">
							</div>
							<div class="form-group">
								<label>Category</label>
									<select class="input-text full-width" name="category_id" id="category_id">
										<option selected="selected" value="">Trades</option>
										<?php $this->db->order_by('category_id', 'asc');
										$test = $this->db->get('tbl_category')->result_array();
										foreach($test as $res){ ?>
										<option value="<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></option>
										<?php } ?>
									</select>
							</div>
						</div>
					</div>
					<div class="checkbox checkbox-inline" id="ms8container">
						<label>
							<input type="checkbox" required id="terms"> Keep me up to date with Rated People's latest news, offers and home improvement advice.
						</label>
					</div>
					<div class="col-sms-offset-6 col-sm-offset-6 col-md-offset-8 col-lg-offset-9">
						<button type="submit" class="next btn-medium full-width" id="snd_review">SEND MESSAGE</button>
					</div>
			</div>
		</div>
	</div>
</div>
</section>
	<script type="text/javascript" src="assets/frontend/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/frontend/js/jquery_1.9.1_jquery.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
 	<script type="text/javascript">
	function get_expert(id)
	{
		var cat_id = id;
		var postData={
					  'cat_id':cat_id
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?asks/get_expert",
			type: "POST",  
			data: postData,
			success: function(data){
			 $('#expert').html(data);
			},
		  });
	}
</script>   

<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmask").validate({
        // Specify the validation rules
        rules: {
            title: "required",
			review :{required:true, minlength :30},
			first_name :"required",
			email :"required",
			last_name :"required",
			category_id :{required: true}

        },
        // Specify the validation error messages
        messages: {
            title: "Please enter Title",
 			review: { required: "Please enter Description",
					  minlength: "Please enter more than 30 words"},
            first_name: "Please enter First Name",
            email: "Please enter job Email",
            last_name: "Please enter Last Name",
			category_id: { required: "Question Category required"},
        },
    });
  });
$(".next").click(function(){
	
	  if($(this).attr('id') =='snd_review'){
  if($('#title').valid() && $('#review').valid()&& $('#first_name').valid()&& $('#email').valid()&& $('#last_name').valid()&& $('#category_id').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
});

</script>