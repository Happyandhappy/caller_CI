<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success fade in">
   <button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> </button>
   <?php echo $this->session->flashdata('success');?> </div>
<?php }?>
<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/subscription_add" name="demo-form" novalidate="" method="post">
   <div class="col-md-6 ui-sortable">
      <div class="panel-body panel-form">
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="fullname"><?php echo get_phrase('Subscription Name')?> * :</label>
            <div class="col-md-6 col-sm-6">
               <input class="form-control"  name="package_name" value="<?php echo set_value('package_name')?>" placeholder="<?php echo 'Subscription Name';?>"   type="text">
               <?php echo form_error('subscription_name','<span for="category" class="help-inline">','</span>');?> </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Subscription Cost')?> * :</label>
            <div class="col-md-6 col-sm-6">
               <input class="form-control" id="package_amount" name="package_amount" value="<?php echo set_value('package_amount')?>" placeholder="<?php echo 'Subscription Amount';?>"   data-parsley-type="number" type="text">
               <?php echo form_error('subscription_amount','<span for="category" class="help-inline">','</span>');?> </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Subscription Description')?></label>
            <div class="col-md-6 col-sm-6">
               <textarea class="form-control" id="description" name="description" rows="4"  placeholder="<?php echo get_phrase('Subscription Description')?>"  ><?php echo set_value('description')?></textarea>
               <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 ui-sortable">
      <div class="panel-body panel-form">
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Features')?></label>
            <div class="col-md-6 col-sm-6">
               <div class="input-group">
                  <input class="form-control" id="features" name="features[]" value="<?php echo set_value('features[]')?>" placeholder="<?php echo get_phrase('Subscription Features')?>"   type="text">
                  <div class="input-group-btn"><a href="javascript:;" class="btn btn-success" onclick="CallInput();" style="width: 80px"><i class="fa fa-plus"></i> Add </a></div>
               </div>
               <?php echo form_error('features','<span for="category" class="help-inline">','</span>');?>
               <div class="p-5 bg-silver" id="inputDiv"></div>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Subscription Duration')?></label>
            <div class="col-md-8">
               <select class="form-control" name="duration_id"   >
                  <option value="">--<?php echo get_phrase('Select Subscription')?>--</option>
                  <!--<option value="12" selected="selected"><?php echo get_phrase('Yearly')?></option>
                  <option value="3" ><?php //echo get_phrase('Quarterly')?></option>-->
                  <option value="1" selected="selected"><?php echo get_phrase('Monthly');?></option>
                  <!--<option value="free" ><?php //echo get_phrase('Free')?></option>-->
               </select>
               <?php echo form_error('duration_id','<span for="category" class="help-inline">','</span>');?> </div>
         </div>
         <div class="form-group" style="">
            <label class="control-label col-md-4 "><?php echo get_phrase('Status')?></label>
            <div class="col-md-8">
               <div class="radio">
                  <label>
                     <input type="radio" name="status" value="1" id="radio-required"   />
                     Active</label>
                  <label>
                     <input type="radio" name="status" id="radio-required2" value="0" />
                     In-active</label>
               </div>
            </div>
            <?php echo form_error('status','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
   </div> 
   <div class="col-md-12 ui-sortable">
	<div class="panel-body panel-form" style="display:none">
		<h3>Subscription Pricing</h3>
		<div class="col-md-6">
			<div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Incoming Call Charges')?></label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" id="call_charge" name="call_charge" value="" placeholder="<?php echo get_phrase('Incoming Call Charges')?>"    type="text">
          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
	  
	   <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Lookup Call Charges')?></label>
        <div class="col-md-8 col-sm-8">
         <input class="form-control" id="lookup_call_charge" name="lookup_call_charge" value="" placeholder="<?php echo get_phrase('Lookup Call Charges')?>"    type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
	  
	    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Call Forward Charges')?></label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" id="call_forword_charges" name="call_forword_charges" value="" placeholder="<?php echo get_phrase('Call Forward Charges')?>"    type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
	  
	    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Call Recording Price')?></label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" id="p_call_recording" name="p_call_recording" value="" placeholder="<?php echo get_phrase('Call Recording Price')?>"    type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Incoming SMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="sms_charge" name="sms_charge" value="" placeholder="<?php echo get_phrase('Incoming SMS Price')?>"    type="text">
           <?php echo form_error('sms_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Incoming MMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="mms_charge" name="mms_charge" value="" placeholder="<?php echo get_phrase('Incoming MMS Price')?>"    type="text">
           <?php echo form_error('mms_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>

	  </div>
	  <div class="col-md-6">
	    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Transc. Service Price')?></label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" id="p_transc_service" name="p_transc_service" value="" placeholder="<?php echo get_phrase('Transc. Service Price')?>"    type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
	  
	  
	    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Social Media Adv. Price')?></label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" id="p_social_med_adv" name="p_social_med_adv" value="" placeholder="<?php echo get_phrase('Social Media Adv. Price')?>"    type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
	  
	    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Block Spam Calls Price')?></label>
        <div class="col-md-8 col-sm-8">		
			<input class="form-control" id="p_blk_spam_calls" name="p_blk_spam_calls" value="" placeholder="<?php echo get_phrase('Block Spam Calls Price')?>"    type="text">

			<?php echo form_error('p_blk_spam_calls','<span for="category" class="help-inline">','</span>');?> </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Purchase Number Price (Monthly)')?></label>
          <div class="col-md-8 col-sm-8">
  			     <input class="form-control" id="buy_number_charge" name="buy_number_charge" value="" placeholder="<?php echo get_phrase('Purchase Number Price')?>"    type="text">
  			   <?php echo form_error('buy_number_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Outgoing/Forwarded SMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="sms_send_charge" name="sms_send_charge" value="" placeholder="<?php echo get_phrase('Outgoing/Forwarded SMS Price')?>"    type="text">
           <?php echo form_error('sms_send_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Outgoing/Forwarded MMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="mms_send_charge" name="mms_send_charge" value="" placeholder="<?php echo get_phrase('Outgoing/Forwarded MMS Price')?>"    type="text">
           <?php echo form_error('mms_send_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>

    </div>
  </div>
</div>
 <div class="col-md-12 ui-sortable">
  <div class="panel-body panel-form">
    <h3>Subscription Limits</h3>
    <div class="col-md-6">

      <!-- SUB. MAX -->
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Calls In')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_call_in" name="max_call_in" value="100" placeholder="<?php echo get_phrase('Max. Calls In')?>"    type="text">
           <?php echo form_error('max_call_in','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Call Lookup')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_call_lookup" name="max_call_lookup" value="100" placeholder="<?php echo get_phrase('Max. Call Lookup')?>"    type="text">
           <?php echo form_error('max_call_lookup','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Transcripts')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_call_transcripts" name="max_call_transcripts" value="100"    type="text">
           <?php echo form_error('max_call_transcripts','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Call Minutes')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_call_minutes" name="max_call_minutes" value="100"    type="text">
           <?php echo form_error('max_call_minutes','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <!-- SUB. MAX -->

    </div>
    <div class="col-md-6">

      <!-- SUB. MAX -->
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Phone Numbers')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_phone_numbers" name="max_phone_numbers" value="10" placeholder="<?php echo get_phrase('Max. Phone Numbers')?>"    type="text">
           <?php echo form_error('max_phone_numbers','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Send SMS')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_send_sms" name="max_send_sms" value="100" placeholder="<?php echo get_phrase('Max. Send SMS')?>"    type="text">
           <?php echo form_error('max_send_sms','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Send MMS')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_send_mms" name="max_send_mms" value="100" placeholder="<?php echo get_phrase('Max. Send SMS')?>"    type="text">
           <?php echo form_error('max_send_mms','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Received SMS/MMS')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_received_sms" name="max_received_sms" value="100" placeholder="<?php echo get_phrase('Max. Received SMS')?>"    type="text">
           <?php echo form_error('max_received_sms','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Max. Social Ads')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="max_social_ad" name="max_social_ad" value="100"    type="text">
           <?php echo form_error('max_social_ad','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      <!-- SUB. MAX -->

	  </div>
		</div>
   </div>
	<input type="hidden" name="is_subscription" value="1" />
   <div class="">
      <div class="col-md-5 col-md-offset-5">
         <div class="input-append input-group">
            <button type="submit" class="btn btn-warning"><?php echo get_phrase('Add Subscription');?></button>
         </div>
      </div>
   </div>
</form>
<script>

var counter =1;

function CallInput()
{

	counter++;
	
	$('#inputDiv').append('<div class="input-group" id="div'+counter+'"><input type="text" class="form-control" name="features[]" id="features" value="<?php echo set_value('features')?>"/><div class="input-group-btn"><a href="javascript:;" class="btn btn-danger p-5" onclick="removeInput('+counter+');" style="width: 80px"><i class="fa fa-times"></i> Remove</a></div></div>');
	
	}
	
	function removeInput(cnt){
	
	$('#div'+cnt).remove();
	
	counter--;

}
</script>