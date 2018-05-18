

<?php  foreach($edit_data as $row): ?>
		
<div class="col-md-12 ui-sortable">
  <?php include("profile_page.php"); ?>
   <div class="panel-body panel-form" style="border:1px solid #eee;">
   
		<?php
			$charges = $this->crud_model->fetch_package_pricing( $row['subscription_id'] );			
		?>
      <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_profile/update_profile_info" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
         
		 
        

         <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" ><?php echo get_phrase('Full name');?></label>
            <div class="col-md-4">
               <input class="form-control" data-toggle="fname"  data-placement="after"  name="fname" value="<?php echo $row['name'];?>" placeholder="Required" data-parsley-required="true" type="text">
            </div>
            <div class="col-md-5">
               <input class="form-control" data-toggle="lname" data-placement="after"  name="lname" value="<?php echo $row['lname'];?>" placeholder="Required" data-parsley-required="true" type="text">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" >Email * :</label>
            <div class="col-md-4">
               <input class="form-control" data-toggle="email" data-placement="after"  id="email" name="email" value="<?php echo $row['email'];?>" data-parsley-type="email" placeholder="Email" data-parsley-required="true" type="text">
            </div>
            <div class="col-md-5">
               <input class="form-control" data-toggle="email" data-placement="after"  id="second_email" name="second_email" value="<?php echo $row['second_email'];?>" data-parsley-type="email" placeholder="Alternative Email" data-parsley-required="false" type="text">
            </div>
         </div>
         
         <div class="form-group">
           <label class="control-label col-md-3 col-sm-4" ><?php echo get_phrase('Phone number');?></label>
            <div class="col-md-9">
              <input class="form-control cust_phone_no" name="contact"  data-toggle="contact" data-placement="after" value="<?php echo $row['contact'];?>" placeholder="Phone number" type="text"  data-parsley-required="true"><span style="color:red;"><?php echo form_error('contact','<span for="category" class="help-inline">','</span>');?></span>
            </div>
         </div>
        
         
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" for="message"><?php echo get_phrase('address');?></label>
            <div class="col-md-9 col-sm-8">
               <textarea class="form-control" id="address" name="address" rows="4" placeholder="address"><?php echo $row['address'];?></textarea>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" for="message"><?php echo get_phrase('Company Name');?></label>
            <div class="col-md-9 col-sm-8">
              
               <input class="form-control" name="company_name"  data-toggle="company_name" data-placement="after" value="<?php echo $row['company_name'];?>" placeholder="Company Name" type="text"/>
            </div>
         </div> 
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-4" >Facebook Ad Account ID<!-- <?php echo get_phrase('name');?> --></label>
        <div class="col-md-5">
          <input class="form-control" data-toggle="adaccount"  data-placement="after"  name="adaccount" value="<?php echo $row['adaccount'];?>"   type="text">
        </div>
        <div class="col-md-4">
          <div class="facebook-minipanel">
            <?php if ($row['accesstoken'] != NULL): ?>
              <p>You're logged on FB Marketing. <a class="btn btn-sm" href="<?php echo base_url().'clientuser/fb_logout'; ?>">Logout!</a></p>
            <?php else: ?>
              <h3>Login with Facebook</h3>
              <p>Visit <a target='_blank' href="http://facebook.com/device">facebook.com/device</a> and enter this code:</p>
              <p class='code'><?php echo $fbmarketing->user_code ?></p>
            <?php endif; ?>
          </div>
        </div>      
      </div> 
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-4" >Send To Facebook & Instagram Custom Audience</label>
        <div class="col-md-2">           
              <label class="switch">
                <input type="checkbox" name="send_custom_audience" value="1"  <?php if($row['send_custom_audience']) {?> checked="checked" <?php } ?>>
                <span class="slider round"></span>
              </label> 
        </div>
        <label class="control-label col-md-4 col-sm-4" style="text-align: left;border: none;"><?php //echo '$'.number_format($charges['p_social_med_adv'],2); ?></label>
      </div> 
     
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-4" >Stop Sending Facebook & Instagram Ads After</label>
        <div class="col-md-2">
        
           <input class="form-control" data-toggle="fadaccount_expire"  data-placement="after"  name="adaccount_expire" value="<?php echo $row['adaccount_expire'];?>" placeholder="90" data-parsley-required="true" type="number">
        </div>
        <label class="control-label col-md-6" style="text-align: left;border: none;">
           days
        </label>
      </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" >Select Your Timezone</label>
            <div class="col-md-8">        
              <select class="form-control" name="timezone" id="timezone">
              
                <option value="0" <?php echo ($row['timezone']=='0' ? 'selected="selected"': ''); ?>>(GMT +0:00) Western Europe Time, London, Lisbon, Casablanca</option>
                <option value="-5"<?php echo ($row['timezone']=='-5' ? 'selected="selected"': ''); ?>>(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima</option>
                <option value="-6"<?php echo ($row['timezone']=='-6' ? 'selected="selected"': ''); ?>>(GMT -6:00) Central Time (US & Canada), Mexico City</option>
                <option value="-7"<?php echo ($row['timezone']=='-7' ? 'selected="selected"': ''); ?>>(GMT -7:00) Mountain Time (US & Canada)</option>
                <option value="-8"<?php echo ($row['timezone']=='-8' ? 'selected="selected"': ''); ?>>(GMT -8:00) Pacific Time (US & Canada)</option>
                <option value="-9"<?php echo ($row['timezone']=='-9' ? 'selected="selected"': ''); ?>>(GMT -9:00) Alaska</option>
                <!--
                <option value="(GMT -12:00) Eniwetok, Kwajalein">(GMT -12:00) Eniwetok, Kwajalein</option>
                <option value="(GMT -11:00) Midway Island, Samoa">(GMT -11:00) Midway Island, Samoa</option>
                <option value="(GMT -10:00) Hawaii">(GMT -10:00) Hawaii</option>
                <option value="(GMT -9:30) Taiohae">(GMT -9:30) Taiohae</option>
                <option value="(GMT -9:00) Alaska">(GMT -9:00) Alaska</option>
                <option value="(GMT -8:00) Pacific Time (US & Canada)">(GMT -8:00) Pacific Time (US & Canada)</option>
                <option value="(GMT -7:00) Mountain Time (US & Canada)">(GMT -7:00) Mountain Time (US & Canada)</option>
                <option value="(GMT -6:00) Central Time (US & Canada), Mexico City">(GMT -6:00) Central Time (US & Canada), Mexico City</option>
                <option value="(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima">(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima</option>
                <option value="(GMT -4:30) Caracas">(GMT -4:30) Caracas</option>
                <option value="(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                <option value="(GMT -3:30) Newfoundland">(GMT -3:30) Newfoundland</option>
                <option value="(GMT -3:00) Brazil, Buenos Aires, Georgetown">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                <option value="(GMT -2:00) Mid-Atlantic">(GMT -2:00) Mid-Atlantic</option>
                <option value="(GMT -1:00) Azores, Cape Verde Islands">(GMT -1:00) Azores, Cape Verde Islands</option>
                <option value="(GMT +0:00) Western Europe Time, London, Lisbon, Casablanca" selected="selected">(GMT +0:00) Western Europe Time, London, Lisbon, Casablanca</option>
                <option value="(GMT +1:00) Brussels, Copenhagen, Madrid, Paris">(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
                <option value="(GMT +2:00) Kaliningrad, South Africa">(GMT +2:00) Kaliningrad, South Africa</option>
                <option value="(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                <option value="(GMT +3:30) Tehran">(GMT +3:30) Tehran</option>
                <option value="(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                <option value="(GMT +4:30) Kabul">(GMT +4:30) Kabul</option>
                <option value="(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                <option value="(GMT +5:30) Bombay, Calcutta, Madras, New Delhi">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                <option value="(GMT +5:45) Kathmandu, Pokhara">(GMT +5:45) Kathmandu, Pokhara</option>
                <option value="(GMT +6:00) Almaty, Dhaka, Colombo">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                <option value="(GMT +6:30) Yangon, Mandalay">(GMT +6:30) Yangon, Mandalay</option>
                <option value="(GMT +7:00) Bangkok, Hanoi, Jakarta">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                <option value="(GMT +8:00) Beijing, Perth, Singapore, Hong Kong">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                <option value="(GMT +8:45) Eucla">(GMT +8:45) Eucla</option>
                <option value="(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                <option value="(GMT +9:30) Adelaide, Darwin">(GMT +9:30) Adelaide, Darwin</option>
                <option value="(GMT +10:00) Eastern Australia, Guam, Vladivostok">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                <option value="(GMT +10:30) Lord Howe Island">(GMT +10:30) Lord Howe Island</option>
                <option value="(GMT +11:00) Magadan, Solomon Islands, New Caledonia">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                <option value="(GMT +11:30) Norfolk Island">(GMT +11:30) Norfolk Island</option>
                <option value="(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                <option value="(GMT +12:45) Chatham Islands">(GMT +12:45) Chatham Islands</option>
                <option value="(GMT +13:00) Apia, Nukualofa">(GMT +13:00) Apia, Nukualofa</option>
                <option value="(GMT +14:00) Line Islands, Tokelau">(GMT +14:00) Line Islands, Tokelau</option>
                -->
              </select>
            </div>
          </div> 
         
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-4" >Turn On Call Transcriptions</label>
            <div class="col-md-9">

              <label class="switch">
                <input type="checkbox" data-toggle="flag_transcribe_call"  value='1' data-placement="after" <?php if($row['flag_transcribe_call']) {?> checked='checked' <?php } ?>name="flag_transcribe_call" value="<?php echo $row['flag_transcribe_call'];?>">
                <span class="slider round"></span>
              </label>
            </div>
          </div> 
          
          <div class="vcard-pick-upload">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-4" >Select Your Contact Card / vCard (.vcf .vcard)</label>
              <div class="col-md-6">
                 <input class="form-control" name="vcardfile" id="vcardfile" type="file"> 
              </div>
              <label class="control-label col-md-3" style="text-align: left;border: none;"><?php echo (isset($row['vcard_url']) && $row['vcard_url']!='' ? '<b>vCard Already Set <a href="'.$row['vcard_url'].'" download>DOWNLOAD</a></b>' : 'Please upload vCard'); ?></label>
            </div> 
          </div>
         <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
                  <button type="submit" class="btn btn-sm btn-success"><?php echo get_phrase('Save Settings');?></button>
                  <div class=" pull-right"><span>Need help?</span>  <a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>home/contact">Contact Us</a>
                  </div>
            </div>
         </div>
          <div class="vcard-pick-maker" style="display:none">
            <b>Coming soon</b>
          </div>
         <div class="form-group">
            <div class="col-md-9 col-md-offset-3">

            </div>
         </div>
      </form>
   </div>
   <?php /*include("manage_numbers.php");*/ ?>
   <?php /* include("change_password.php"); */ ?>
</div>
<?php endforeach;?>
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery-1.9.1.min.js"></script> 
      

<?php if ($details['accesstoken'] == NULL): ?>

<script>
$('#vcardfile').change(function() {
  $('#vcardform').submit();
});

   jQuery(document).ready(function($){

    $('.switch-vcard-pick').on('change',function(){
        var picked = $(this).is(':checked');
        if(picked) {
          $('.vcard-pick-upload').hide();
          $('.vcard-pick-maker').show();
        } else {
          $('.vcard-pick-upload').show();
          $('.vcard-pick-maker').hide();

        }
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
                 $('.facebook-minipanel').html('<p class="mt-3"><b>You are successfully logged on Facebook Marketing. <a class="btn btn-sm" href="<?php echo base_url().'clientuser/fb_logout'; ?>">Log Out!</a></b></p>')
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
</script>
<?php endif; ?>