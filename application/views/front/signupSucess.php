<div id="contact" class="content " data-scrollview="true"></div>
<div class="jumbotron m-b-0 text-center" style="min-height: 429px;">
  <!--<div class="alert alert-success col-md-12 center" style="background: #f0f3f4; font-size: 20px; color: #000;">Congratulations, You Are Signed Up!<span class="close"></span></div>-->
  <div class="clearfix"></div>
  	<h3>Thank you for your payment. Your transaction has been completed, and a receipt </h3>
	<h3>for  your purchase has been emailed to you. You may log into your account at</h3>
	<h3>www.paypal.com to view details of this transaction.</h3><br><br><br>
  <p><a href="<?php echo base_url()?>login" class="btn btn-success btn-lg" role="button">Login</a></p>
  <a class="button btn-small red" href="<?php echo base_url()?>home">Home</a> </div>
<!--<div id="contact" class="content " data-scrollview="true"></div>-->

<script>
	 fbq('track', 'Purchase',{
  content_name: '<?php echo $pixel_purchage_plname; ?>',
  content_ids: 'subs_<?php echo $pixel_purchage_plid; ?>',
  content_type: 'product',
  value: '<?php echo $pixel_purchage_amount; ?>',
  currency: 'USD'
});
	 fbq('track', 'CompleteRegistration');
</script>