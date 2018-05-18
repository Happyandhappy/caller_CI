<!DOCTYPE html>
<html lang="en">
<body>
<div class='web'>
<?php 
		$signupSession = $this->session->userdata('signupData');
		//print_r($signupSession);exit;
?>
<form action="<?php echo base_url();?>index.php?stripe_payment/checkout" method="POST">
<script src="https://checkout.stripe.com/checkout.js"
class="stripe-button"
data-key="pk_test_WbcXVEmChHEzhMabG65ekGwP"
data-image="<?php echo base_url()?>uploads/logo.png"
data-name="Rated Builders"
data-description="Package Transaction ($<?php echo $signupSession['packageAmount'];?>)"/>
</script>
</form>
</div>
</body>
</html>