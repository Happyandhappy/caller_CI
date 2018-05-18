<?php 

?>


<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/twilio_prices" name="twilio-form" novalidate="" method="post" enctype="multipart/form-data">

	<div class="col-md-10 ui-sortable">
	  <div class="panel-body panel-form">


			 <div class="col-md-12 ui-sortable">
			    <div class="panel-body panel-form">
			        <h3>Prices Charged by Third Party</h3>

			        <div class="col-md-6">

			          <!-- SUB. MAX -->
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Calls In')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_call_in" name="price_call_in" value="<?php echo $data->price_call_in;?>" placeholder="<?php echo get_phrase('Cost for Calls In')?>"    type="text">
			               <?php echo form_error('price_call_in','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Call Lookup')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_call_lookup" name="price_call_lookup" value="<?php echo $data->price_call_lookup;?>" placeholder="<?php echo get_phrase('Cost for Call Lookup')?>"    type="text">
			               <?php echo form_error('price_call_lookup','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Transcripts')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_call_transcripts" name="price_call_transcripts" value="<?php echo $data->price_call_transcripts;?>" placeholder="<?php echo get_phrase('Cost for Transcripts')?>"    type="text">
			               <?php echo form_error('price_call_transcripts','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Call Minutes')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_call_minutes" name="price_call_minutes" value="<?php echo $data->price_call_minutes;?>" placeholder="<?php echo get_phrase('Cost for Call Minutes')?>"    type="text">
			               <?php echo form_error('price_call_minutes','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <!-- SUB. MAX -->
			        </div>
			        <div class="col-md-6">
			          <!-- SUB. MAX -->
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Phone Numbers')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_phone_numbers" name="price_phone_numbers" value="<?php echo $data->price_phone_numbers;?>" placeholder="<?php echo get_phrase('Cost for Phone Numbers')?>"    type="text">
			               <?php echo form_error('price_phone_numbers','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Sent SMS')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_send_sms" name="price_send_sms" value="<?php echo $data->price_send_sms;?>" placeholder="<?php echo get_phrase('Cost for Send SMS')?>"    type="text">
			               <?php echo form_error('price_send_sms','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Received SMS')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_received_sms" name="price_received_sms" value="<?php echo $data->price_received_sms;?>" placeholder="<?php echo get_phrase('Cost for Received SMS')?>"    type="text">
			               <?php echo form_error('price_received_sms','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Sent MMS')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_send_mms" name="price_send_mms" value="<?php echo $data->price_send_mms;?>" placeholder="<?php echo get_phrase('Cost for Send MMS')?>"    type="text">
			               <?php echo form_error('price_send_mms','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Received MMS')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_received_mms" name="price_received_mms" value="<?php echo $data->price_received_mms;?>" placeholder="<?php echo get_phrase('Cost for Received MMS')?>"    type="text">
			               <?php echo form_error('price_received_mms','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Cost for Social Ads')?></label>
			              <div class="col-md-8 col-sm-8">
			                 <input class="form-control" id="price_social_ad" name="price_social_ad" value="<?php echo $data->price_social_ad;?>" placeholder="<?php echo get_phrase('Cost for Received SMS')?>"    type="text">
			               <?php echo form_error('price_social_ad','<span for="category" class="help-inline">','</span>');?> 
			              </div>
			          </div>
			          <!-- SUB. MAX -->
			    	 </div>
				</div>
			</div>
			<div class="form-group">
		      <div class="col-md-8 col-md-offset-2">
		        <div class="">
		          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Update');?></button>
		          <button type="button" class="btn btn-warning pull-right" onclick="window.location.href='<?php echo base_url()?>apanel/dashboard'"><?php echo get_phrase('Cancel');?></button>
		        </div>
		      </div>
		    </div>
		 </div>

</form>