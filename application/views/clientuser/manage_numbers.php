<?php
	$charges = $this->crud_model->fetch_package_pricing( $row['subscription_id'] );			
?>		
<!--<div class="col-md-12 ui-sortable">-->
   <div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
		
		<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_numbers/<?=$phoneNumber ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
			<div class="form-group" style="background-color: #eee">
			<label class="control-label col-md-4 col-sm-4" ><h5 style="font-weight: bold;margin: 0;"><?php echo get_phrase('Choose Phone Number');?></h5></label>
			<div class="col-md-8 ">
				<select class="form-control" name="phoneSelection" id="phoneSelection"  onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/manage_numbers/'+this.value;$('body.boxed-layout').css('opacity','0.6')">
				<?php 
				/*if($_SERVER['REMOTE_ADDR'] == '110.232.248.49'){
					//echo $this->session->userdata('login_user_id').'HERE1<pre>';print_r($phoneNumbers);exit;
				}*/
				foreach($phoneNumbers as $phoneNumberr){
					echo "<option value=".$phoneNumberr['phoneNumber']." ".($phoneNumber==$phoneNumberr['phoneNumber']?"selected":"").">".$phoneNumberr['friendlyName'].' '.$phoneNumberr['campaign_name']."</option>";
				}
				?>
			  
				</select>
			</div>
		</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Campaign Name');?></label>
				<div class="col-md-8">
				   <input class="form-control" data-toggle="fname"  data-placement="after"  name="campaign_name" value="<?php echo $details['campaign_name'];?>" placeholder="Required" data-parsley-required="true" type="text">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Phone Number To Forward SMS To');?></label>
				<div class="col-md-8">
					<!-- <input class="form-control cust_phone_no" name="sms_forward_no"  data-toggle="sms_forward_no" data-placement="after" value="<?php echo $details['sms_forward_no'];?>" placeholder="Phone number to send SMS to" type="text"  data-parsley-required="true"> -->
					<input class="form-control cust_phone_no" name="sms_forward_no"  data-toggle="sms_forward_no" data-placement="after" value="<?php echo $details['sms_forward_no'];?>" placeholder="Phone number to send SMS to" type="text">
					<span style="color:red;">
						<?php echo form_error('sms_forward_no','<span for="category" class="help-inline">','</span>');?></span>
				</div>
			</div>
         
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Number(s) To Forward Calls To<br/> <small>Separate Phone Numbers With a Comma</small>');?></label>
				<div class="col-md-8">
					<!-- <input class="form-control cust_multi_phone_no" name="call_forward_no_all"  data-toggle="call_forward_no_all" data-placement="after" value="<?php echo $details['call_forward_no'].$details['multi_forward'];?>" placeholder="Phone number to send calls back to" type="text"  data-parsley-required="true"><span style="color:red;"><?php echo form_error('call_forward_no','<span for="category" class="help-inline">','</span>');?></span> -->
					<input class="form-control cust_multi_phone_no" name="call_forward_no_all"  data-toggle="call_forward_no_all" data-placement="after" value="<?php echo $details['call_forward_no'].$details['multi_forward'];?>" placeholder="Phone number to send calls back to" type="text"><span style="color:red;"><?php echo form_error('call_forward_no','<span for="category" class="help-inline">','</span>');?></span>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					//$(".cust_multi_phone_no").mask('999-999-9999, 999-999-9999');
					$('.cust_multi_phone_no').mask('(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000,(000) 000-0000');
				});
			</script>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Jump To Next Number After X Rings?<br/><small>(only for round robin, put 0 to call all numbers at once, the first person to answer gets the call)</small></label>
				<div class="col-md-3">
					<input class="form-control" name="multi_timeout" data-toggle="multi_timeout" data-placement="after" value="<?php echo ceil($details['multi_timeout']/$zvuk_sek);?>" placeholder="How long to wait for answers in seconds." type="text"  data-parsley-required="true"><span style="color:red;"><?php echo form_error('multi_timeout','<span for="category" class="help-inline">','</span>');?></span>
				</div>
			</div>

		    <?php if ($usr['accesstoken'] != NULL): ?>
		      <div class="form-group">
		    	
		    	<?php if ($usr['adaccount'] != NULL): ?>

		        <label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Facebook custom audience ID');?></label>
		        <?php if(empty($details['custom_audience_id'])): ?>
		        <div class="col-md-4 col-sm-4">
		        	<a class="btn btn-primary btn-gencust btn-sm" href="#">Generate Facebook Audience</a>
		        </div>
		        <?php endif; ?>
		        <div class="col-md-4 col-sm-4">
		          <input class="form-control" data-toggle="custom_audience_id"  data-placement="after" id="cust_id_field" name="custom_audience_id" <?php if(empty($details['custom_audience_id'])) echo 'disabled="disabled"'; ?> placeholder="Generate Audience" value="<?php echo $details['custom_audience_id'];?>"   type="text">
		      	</div> 
		      <?php else: ?>
		        <label class="control-label col-md-12 col-sm-12" ><b>You have connected your Facebook account with Us, but have not set your Ad Account ID. Please do so under <a href="/clientuser/manage_profile">Profile Settings</a></b></label>

		      <?php endif; ?>
		     </div>      
		      <?php else: ?>
			<div class="form-group">
		        <label class="control-label col-md-12 col-sm-12" ><b>You have not connected your Facebook account with US. If you want to use Custom Audiences, please do so under <a href="/clientuser/manage_profile">Profile Settings</a></b></label>

			</div>
		    <?php endif; ?>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Turn On Call Recording</label>
				<div class="col-sm-2">
		              <label class="switch">
						   <input class="" data-toggle="flag_record_calls"  value='1' data-placement="after" <?php if($details['flag_record_calls']) {?> checked='checked' <?php } ?>name="flag_record_calls" value="<?php echo $details['flag_record_calls'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 

				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Turn On Call Whisper</label>
				<div class="col-sm-2">
		              <label class="switch">
						   <input class="" data-toggle="flag_whisper_record"  value='1' data-placement="after" <?php if($details['flag_whisper_record']) {?> checked='checked' <?php } ?>name="flag_whisper_record" value="<?php echo $details['flag_whisper_record'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 

				</div>
				<label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;">If you live in <u data-toggle="tooltip" data-html="true" title="California, Connecticut, Florida, Illinois, Maryland, Massachusetts, Montana, New Hampshire, Pennsylvania and Washington">one of these States</u> by law you need to turn On the call recording notification.</label>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Whisper Message (optional)<br/><small>If You Leave This Blank It Will Play The Default Whisper Recording Notification</small></label>
				<div class="col-md-8">
					<textarea name="whisper_message" placeholder="Leave This Blank To Play The Default Whisper Recording Notification" class="form-control" style="min-height:100px" rowspan="2"><?php echo $details['whisper_message']; ?></textarea>
				</div>
			</div>

			<!-- campos novov -->
			<!--<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Check to turn On Advanced Demographic Lookups</label>
				<div class="col-md-2">

				   <input class="" data-toggle="flag_adv_lookup"  value='1' data-placement="after" <?php if($details['flag_adv_lookup']) {?> checked='checked' <?php } ?>name="flag_adv_lookup" value="<?php echo $details['flag_adv_lookup'];?>" type="checkbox"> 
				</div>
				<label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;"><?php //echo '$'.number_format($charges['lookup_call_charge'],2); ?></label>
			</div>-->
			<!--
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Check to Block Spam Calls</label>
				<div class="col-md-2">

				   <input class="" data-toggle="block_spam_calls"  value='1' data-placement="after" <?php if($details['block_spam_calls']) {?> checked='checked' <?php } ?>name="block_spam_calls" value="<?php echo $details['block_spam_calls'];?>" type="checkbox"> 
				</div>
				<label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;"><?php //echo '$'.number_format($charges['p_blk_spam_calls'],2); ?></label>
			</div>
			-->
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Receive Email Notifications From Incoming SMS</label>
				<div class="col-md-2">

		              <label class="switch">
				   <input class="" data-toggle="flag_mailnotif_sms"  value='1' data-placement="after" <?php if($details['flag_mailnotif_sms']) {?> checked='checked' <?php } ?>name="flag_mailnotif_sms" value="<?php echo $details['flag_mailnotif_sms'];?>" type="checkbox">  
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;"><?php //echo '$'.number_format($charges['p_blk_spam_calls'],2); ?></label>
			</div>
<script>

function deletephNumber(broj) {
    var ask = window.confirm("If you release this number (<?=$phoneNumber ?>) you will not be able to get it back, are you sure you want to remove it?");
    if (ask) {
        document.location.href = '<?php echo base_url('clientuser/release_number') ?>/'+broj;
    }
}

</script>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Receive Email Notifications From Incoming Calls</label>
				<div class="col-md-2">

		              <label class="switch">
				   <input class="" data-toggle="flag_mailnotif_call"  value='1' data-placement="after" <?php if($details['flag_mailnotif_call']) {?> checked='checked' <?php } ?>name="flag_mailnotif_call" value="<?php echo $details['flag_mailnotif_call'];?>" type="checkbox">  
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;"><?php //echo '$'.number_format($charges['p_blk_spam_calls'],2); ?></label>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Send Auto Reply Text From A SMS</label>
				<div class="col-md-2">
			          <label class="switch">
					   <input class="" data-toggle="flag_auto_sms"  value='1' data-placement="after" <?php if($details['flag_auto_sms']) {?> checked='checked' <?php } ?>name="flag_auto_sms" value="<?php echo $details['flag_auto_sms'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-6"><b>Automatically send your message and/or files to each sms sender.</b></label>
			</div> 
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Send Auto Reply TEXT From A Call</label>
				<div class="col-md-2">
			          <label class="switch">
					   <input class="" data-toggle="flag_auto_sms_oncall"  value='1' data-placement="after" <?php if($details['flag_auto_sms_oncall']) {?> checked='checked' <?php } ?>name="flag_auto_sms_oncall" value="<?php echo $details['flag_auto_sms_oncall'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-6"><b>Automatically send your message and/or files to each caller.</b></label>
			</div> 
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Auto SMS Reply</label>
				<div class="col-md-8">
					<textarea name="auto_sms_reply" class="form-control" style="min-height:100px" rowspan="4"><?php echo $details['auto_sms_reply']; ?></textarea>
				</div>
			</div>
			<div class="form-group">
              <label class="control-label col-md-4 col-sm-4" >Select An Optional File To Send With Your Auto Reply SMS</label>
              <div class="col-md-4">
                 <input class="form-control" name="auto_sms_file" type="file"> 
              </div>
              <label class="control-label col-md-3" style="text-align: left;border: none;"><?php echo (isset($details['auto_sms_file']) && $details['auto_sms_file']!='' ? '<b>File Set <a href="'.$details['auto_sms_file'].'">VIEW</a></b>' : 'Please upload a File'); ?></label>
            </div> 
			<?php if($usr['vcard_url']!=''): ?>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Auto vCard</label>
				<div class="col-md-2">
			          <label class="switch">
					   <input class="" data-toggle="auto_vcard"  value='1' data-placement="after" <?php if($details['auto_vcard']) {?> checked='checked' <?php } ?>name="auto_vcard" value="<?php echo $details['auto_vcard'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-6"><b>Automatically send your vCard once to each incoming SMS sender.</b></label>
			</div> 
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >If you would like to send a message when your Contact / vCard is sent type it here.</label>
				<div class="col-md-8">
					<textarea name="vcard_reply_text" placeholder="Thanks for the call, attached is my contact card, please add me to your contacts." class="form-control" style="min-height:100px" rowspan="4"><?php echo $details['vcard_reply_text']; ?></textarea>
				</div>
			</div>
			<?php endif; ?>
			<!-- VOICEMAIL -->
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" >Turn On Voice Mail</label>
				<div class="col-md-3">
		              <label class="switch">
				   <input class="" data-toggle="voice_on"  value='1' data-placement="after" <?php if($details['voice_on']) {?> checked='checked' <?php } ?>name="voice_on" value="<?php echo $details['voice_on'];?>" type="checkbox"> 
		                <span class="slider round"></span>
		              </label> 
				</div>
				<label class="control-label col-md-5"><b>If you turn On the voice mail make sure it is turned off On the phone the calls forward to. </b></label>
			</div> 
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Activate Voice Mail After How Many Rings? <br/>');?></label>
				<div class="col-md-3">
					<input class="form-control" name="voice_timeout" data-toggle="voice_timeout" data-placement="after" value="<?php echo ceil($details['voice_timeout']/$zvuk_sek);?>" placeholder="How long to wait for answers in seconds." type="text"  data-parsley-required="true"><span style="color:red;"><?php echo form_error('voice_timeout','<span for="category" class="help-inline">','</span>');?></span>
				</div>
			</div>
	          <div class="form-group">
	            <label class="control-label col-md-4 col-sm-4" >Use Prerecorded File?</label>
	            <div class="col-md-4">
	              <!-- Rounded switch -->
	              <label class="switch">
	                <input type="checkbox" <?php echo (isset($details['voicename_url']) && $details['voicename_url']!='' ? 'checked' : ''); ?> name="create-voicemail" class="switch-voicemail-pick">
	                <span class="slider round"></span>
	              </label>
	            </div>
	            <label class="control-label col-md-4" style="text-align: left;border: none;"></label>
	          </div> 
	            <div class="voicemail-pick-upload"  <?php echo (isset($details['voicename_url']) && $details['voicename_url']!='' ? '' : 'style="display:none"'); ?>>
	            	<div class="form-group">
		              <label class="control-label col-md-4 col-sm-4" >Pick a Voicemail Recording (.mp3 or .wav file)</label>
		              <div class="col-md-4">
		                 <input class="form-control" name="voicefile" type="file"> 
		              </div>
		              <label class="control-label col-md-3" style="text-align: left;border: none;"><?php echo (isset($details['voicename_url']) && $details['voicename_url']!='' ? '<b>Voicename File Set <a href="'.$details['voicename_url'].'">VIEW</a></b>' : 'Please upload Voicemail File'); ?></label>
		            </div> 
	            </div>
	            <div class="voicemail-pick-maker"  <?php echo (!isset($details['voicename_url']) || $details['voicename_url']=='' ? '' : 'style="display:none"'); ?>>
			        <div class="form-group">
			            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Voice Mail Text');?></label>
			            <div class="col-md-8 col-sm-8">
			               <textarea class="form-control" id="voicetext" name="voicetext" rows="4" placeholder="Please leave your message after the beep."><?php echo ($details['voicetext'] != '' ? $details['voicetext'] : '');?></textarea>
			               <small><b>Type your greeting message here.</b></small>
			            </div>
			        </div>
			    </div>
			<!-- ./ VOICEMAIL -->
			<div class="form-group">
				<div class="col-md-8 col-md-offset-4">
				   <div class="">
					  <button type="submit" class="btn btn-sm btn-success" id="submit_button"><?php echo get_phrase('Save Settings');?></button>
					  <a href="javascript:deletephNumber('<?=$details['rec_id'] ?>')" class="btn btn-sm btn-danger pull-right"><?php echo get_phrase('Release Number');?></a>
				   </div>
				</div>
			</div>

      </form>
   </div>
<div class="modal" id="errorModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Something went wrong!</h5>
      </div>
      <div class="modal-body">
        <div id="modal-error-msg" class="lead" style="font-size: 16px;">Error!</div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary err-ok-btn">Yes, Open.</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery-1.9.1.min.js"></script> 
      

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
    	html: true
    });   
});
</script>
<?php if ($details['accesstoken'] == NULL): ?>

<script>

   jQuery(document).ready(function($){

    $('.switch-voicemail-pick').on('change',function(){
        var picked = $(this).is(':checked');
        if(!picked) {
          $('.voicemail-pick-upload').hide();
          $('.voicemail-pick-maker').show();
        } else {
          $('.voicemail-pick-upload').show();
          $('.voicemail-pick-maker').hide();

        }
    });

   		$('.btn-gencust').on('click',function(ev) {
   			ev.preventDefault();
   			var brid = '<?php echo $details['phoneNumber']; ?>';
       		$.ajax({
              url: '<?php echo base_url(); ?>clientuser/ajax_get_custom_aud_id',
              type: "post",
              data: {
                  act: 'ajax_get_custom_aud_id',
                  numbr: brid,
                  name: '<?php echo htmlspecialchars($details['campaign_name']); ?>'

              } ,
              success: function (response) {
                 console.log(response)
                 if(response.status=='success') {
                 	alert("You have successfully uploaded the custom audience <?php echo htmlspecialchars($details['campaign_name']); ?> for your Caller Technologies phone number <?php echo htmlspecialchars($details['phoneNumber']); ?> to your Facebook advertising account");
                 	$('#cust_id_field').val(response.custom_id);
                 	$('.btn-gencust').hide();
                 	$('#cust_id_field').removeAttr('disabled');
                 	$('.btn-gencust').removeAttr('disabled');
                 } else { 
                 	var strs = response.error_log.error.message;
                 	var matching = strs.match(/\bhttps?:\/\/\S+/gi);
                 	var imalip = '';
                 	if(matching!='' && matching != null && matching != false) {
                 		imalip = "<br/><br/><b>Do you want to open the Mentioned Link?</b>";
                 		matchf = true;
                 	}
                 	$('#errorModal').modal('show');
                 	$('#errorModal #modal-error-msg').html(response.message + "<br/><br/> FB-Error: " + response.error_log.error.message.replace(/((http|https|ftp):\/\/[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1">$1</a> ') + imalip);
					    if (imalip!='') {
					    	$('#errorModal .err-ok-btn').attr('href',matching);
					    	$('#errorModal .err-ok-btn').attr('target','_blank');
					    } else {
					    	$('#errorModal .err-ok-btn').hide();
					    }
				}

              },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
                 
              }
            });
        });


      c = setInterval(function(){

       $.ajax({
              url: "https://graph.facebook.com/v2.8/device/login_status",
              type: "post",
              data: {
                  access_token: '291700144652483|9071b67d65ff9ecb6018698127592d7b',
                  //access_token: '1753571034962410|829464baa8cfd5308a294196f15aea00',
                  code: '<?php echo $fbmarketing->code; ?>'

              } ,
              success: function (response) {
                 console.log(response)
                 $('.facebook-minipanel').html('<p>You are successfully logged On Facebook Marketing</p>')
                 $.ajax({
                  url: '<?php echo base_url(); ?>clientuser/ajax_save_access_token',
                  type: 'post',
                  data: {
                     accesstoken : response.access_token,
                     expires : response.expires_in,
					 rec_id:'<?=$rec_id ?>'
                  },
                  success: function(res){
                     console.log('retorno do ajax')
                     console.log(res)
                  }
                 })


              },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
                 
              }
          });
      }, 8000)
   })

	 $('#submit_button').click(function(event){
		 	event.preventDefault();
		  var fromNumber   = $('#phoneSelection option:selected').val().substring(2,12);					
			var toSmsNumber	 = $('input[name=sms_forward_no]').val().replace('(','').replace('-','').replace(')','').replace(' ','');
			var toCallNumber = $('input[name=call_forward_no_all]').val();
			var res 				 = toCallNumber.split(",");
			// alert(toCallNumber);
			if( fromNumber == toSmsNumber ) {
				// parsley-error
					$('input[name=call_forward_no_all]').removeClass('parsley-success');
					$('input[name=sms_forward_no]').addClass('parsley-error');
					alert('You can not forward your Caller Technologies phone number to itself, please enter a different phone number.');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return;
			}
			for (var i = 0;i < res.length ; i++){
				if( fromNumber ==  res[i].replace('(','').replace('-','').replace(')','').replace(' ','')){
					$('input[name=call_forward_no_all]').removeClass('parsley-success');
					$('input[name=call_forward_no_all]').addClass('parsley-error');
					alert('You can not forward your Caller Technologies phone number to itself, please enter a different phone number.');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return; 						  
				}
			}
			
			$('[name=demo-form]').submit();

	 });
</script>
<?php endif; ?>