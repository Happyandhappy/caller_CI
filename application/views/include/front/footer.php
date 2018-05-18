<!-- begin #footer -->

				  <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;

					$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;

					$system_name = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;

					$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?>





<!-- end #footer -->



<div id="footer-copyright" class="footer-copyright"> 

  <!-- BEGIN container -->

  <div class="container">

    <div class="payment-method"> <!--img src="<?php echo base_url()?>assets/frontend/img/pay.png" alt=""--> </div>

    <div class="copyright"> Copyright © 2016 <?php echo $system_name ?></div>

  </div>

  <!-- END container --> 

</div>

