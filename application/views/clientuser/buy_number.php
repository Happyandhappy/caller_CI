<div class="row">
<div class="panel panel-inverse" data-sortable-id="ui-general-2">

 <?php if(isset($system_error)){?>
  <div class="well bg-red-lighter">
  <?php echo $system_error;?>
  </div>
  <?php }?>

   <div class="panel-body highlight">

      <?php if(!empty($buyButton)){?>

      <div class="alert alert-danger fade in"> <?php echo $buyButton;?> </div>

      <?php }?>

      <?php

	  if($clientPhoneDetails->call_forward_no!='')

	  {?>

      <div class="panel-body">
        <h2>Forwarded number!</h2>

        <h4>
        You have sucessfully acquired <?php echo $clientPhoneDetails->phoneNumber; ?>, it is forwarded to <?php echo $clientPhoneDetails->call_forward_no; ?>, you may change this anytime in the Phone Number Settings page.</h4>
        <h4> Your new number has Voice, SMS Text &amp; MMS (Multimedia Messaging Service) &amp; Real time dynamic call tracking, place this phone number in a unique advertisement to measure it's ROI, use different numbers for different advertisements to see it's ROI.
        </h4>
        <div>
          <a class="btn btn-lg btn-primary" href="<?php echo base_url(); ?>clientuser/manage_numbers/<?php echo $clientPhoneDetails->phoneNumber; ?>">Continue</a>
        </div>
    </div>

     	 

      <?php

	  }?>



      </div>

   </div>