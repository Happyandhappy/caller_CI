<section class="gray-area" id="content">
   <div class="container shortcode">
      <div class="block">
         <div class="row">
            <div class="col-md-12">
               <div class="tab-container box">
                  <div class="tab-content">
                     <div class="tab-pane fade active in" id="satisfied-customers">						<div id="accepted">	
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
						<?php } ?>						</div>
						<div class="toggle-container box">
                           <?php foreach($quotation as $res){ ?>
                           <div class="panel style2">
                              <h4 class="panel-title">
							  <a class="collapsed" href="#tgg<?php echo $res['quote_id']?>" data-toggle="collapse" aria-expanded="false"><h3 class="box-title"><?php echo $res['job_name']?></h3><h5><?php echo $res['job_desc']?></h5></a> 
								</h4>
								<hr>
                              <div id="tgg<?php echo $res['quote_id']?>" class="panel-collapse collapse" aria-expanded="true" style="">
									<div class="main-rating table-wrapper full-width hidden-table-sms intro">
                                        <div class="table-cell col-sm-8">
                                            <div class="overall-rating">
                                                <div class="detailed-rating">
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Job Reference </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php echo $res['job_ref']?></h6></div></li>
														<input type="hidden" id="job_id<?php echo $res['quote_id']?>" value="<?php echo $res['job_id']?>">
														<input type="hidden" id="tradesmen_id<?php echo $res['quote_id']?>" value="<?php echo $res['tradesmen_id']?>">														<input type="hidden" id="purchased_id<?php echo $res['quote_id']?>" value="<?php echo $res['purchased_id']?>">
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Job Type </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php echo $res['job_type']?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Hiring Stage </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php if($res['job_title']=="1") { echo 'Ready To Hire'; }?>
																<?php if($res['job_title']=="2") { echo 'Planing and Budgeting'; }?>
																<?php if($res['job_title']=="3") { echo 'Need a quote for inssurance purposes'; }?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Budget </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php $r2 = explode('_',$res['job_budget']);
																echo $r2[0].' '.$r2[1].' '.$r2[2];?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Timing </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php $r1 = explode('_',$res['job_start']);
																echo $r1[0].' '.$r1[1].' '.$r1[2];?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Quotation Details </label></div></li><li class="col-md-9"><div class="each-rating"><h6><?php echo $res['quotation_details']?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Payment Terms </label></div></li><li class="col-md-9"><div class="each-rating"><h6><?php echo $res['payment_terms']?></h6></div></li>
                                                    </ul>
													<ul class="clearfix">
                                                        <li class="col-md-3"><div class="each-rating"><label>Price </label></div></li><li class="col-md-3"><div class="each-rating"><h6><?php echo $res['quote_price']?></h6></div></li>
                                                    </ul>
												</div>
                                            </div>
                                        </div>
								<?php if($res['quote_status']=='0') { ?><button style="float:left;" class="button btn-small sky-blue1 pull-right" onclick="quoate_accept(<?php echo $res['quote_id']?>);">Accept Quotation</button><?php } ?> 
								</div>
								<div class="character clearfix">
									<?php if($res['quote_status']=='1') { ?><a aria-expanded="false" style="float:left;" class="collapsed button btn-small sky-blue1 pull-right" href="#acc<?php echo $res['quote_id']?>" data-toggle="collapse" data-parent="#accordion2">Rating/Review</a><?php } ?> 									
                                       <div id="acc<?php echo $res['quote_id']?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                          <div class="view-profile col-sm-12">
                                             <div class="col-sm-12 no-float no-padding">
                                                <form class="review-form" id="fmreview" enctype="multipart/form-data" action="<?php echo base_url();?>index.php?dashboard/review_rating/<?php echo base64_encode($res['trades_id'])?>" method="post">
												  <div class="form-group">
													  <h4 class="title">Title review</h4>
													  <input type="text" name="review_title" id="review_title" placeholder="enter a review rating" class="input-text full-width">
													  <input type="hidden" name="job_id" value="<?php echo $res['trades_id']?>">
													  <input type="hidden" name="purchased_id" value="<?php echo $res['purchased_id']?>">
												  </div>
												  <div class="form-group">
													  <h4 class="title">Your review</h4>
													  <textarea rows="5" name="review_desc" id="review_desc" placeholder="enter your review" class="input-text full-width"></textarea>
												  </div>
												  <div class="form-group col-md-5 no-float no-padding">
													  <h4 class="title">Your Rating</h4>
													  <input type="number" min="1" max="9" name="rating" id="rating" placeholder="enter a review rating" class="input-text full-width" name="review-title">
												  </div>
												  <div class="form-group col-md-5 no-float no-padding no-margin">
													  <button id="btn_review" name="btn_review" class="btn-small" type="submit">SUBMIT REVIEW</button>
												  </div>
											  </form>
                                             </div>
                                          </div>
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
   </div>
</section>
<script type="text/javascript" src="assets/frontend/js/bootstrap.js"></script> 
<script type="text/javascript" src="assets/frontend/js/jquery_1.9.1_jquery.min.js"></script> 
<script type="text/javascript">
	function quoate_accept(id)
	{
		var job_id = $('#job_id'+id).val();
		//alert(job_id);
		var tradesmen_id = $('#tradesmen_id'+id).val();		var purchased_id = $('#purchased_id'+id).val();
		//alert(tradesmen_id);
		var postData={
					  'job_id':job_id,
					  'tradesmen_id':tradesmen_id,					  'purchased_id':purchased_id
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?dashboard/accept_quote",
			type: "POST",  
			data: postData,
			success: function(data){
				$('#accepted').html('<div class="alert alert-success">Quotation Accepted Successfully<span class="close"></span></div>');

			},
		  });
	}
</script> 
<script type="text/javascript">
	function get_subcat(id)
	{
		var cat_id = id;
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
			 //$('#subcategory_id2').html(data);
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
	
	if($(this).attr('id') =='btn_submit'){
  if($('#category_id').valid() && $('#subcategory_id').valid()&& $('#job_name').valid() && $('#job_desc').valid() && $('#job_start').valid() && $('#job_budget').valid()&& $('#phoneno').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}

	if($(this).attr('id') =='btn_review'){
  if($('#review_title').valid() && $('#review_desc').valid() && $('#rating').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	
});

</script>
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmupdate").validate({
        // Specify the validation rules
        rules: {
			category_id :{required: true},
			subcategory_id :{required: true},
            job_name: "required",
			job_desc :"required",
			phoneno :"required",
			job_start :{required: true},
			job_budget :{required: true},

        },
        // Specify the validation error messages
        messages: {
			category_id: { required: "Trade required"},
			subcategory_id: { required: "Job Type required"},
            job_name: "Please enter job name",
            job_desc: "Please enter job description",
			job_start: { required: "Select Your Job"},
			job_budget: { required: "Select Your Job Estimate"},
			phoneno :"Please enter phone no",
        },
    });
  });
</script>
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmreview").validate({
        // Specify the validation rules
        rules: {
			review_desc :{required:true, minlength :30},
			review_title :"required",
			rating :"required",

        },
        // Specify the validation error messages
        messages: {
 			review_desc: { required: "Please enter Description",
					  minlength: "Please enter more than 30 words"},
			review_title :"Please enter rating title",
			rating :"Please enter rating",
        },	
    });
  });
</script>