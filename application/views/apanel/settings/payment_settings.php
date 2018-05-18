			  <?php if($this->session->flashdata('success')){ ?>
				<div class="alert alert-success fade in">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">×</span>
					</button>
					<?php echo $this->session->flashdata('success');?>
				</div>
			  <?php } if($this->session->flashdata('error')){ ?>
				<div class="alert alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">×</span>
					</button>
					<?php echo $this->session->flashdata('error');?>
				</div>
			  <?php } ?>
<div class="panel-body panel-form">
  
  <form class="form-horizontal form-bordered"  method="post" data-parsley-validate="true" name="demo-form" action="<?php echo base_url()?>apanel/payment_settings/update_payment_settings">
    <div class="col-md-6 col-sm-6">
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="fullname" > <?php echo get_phrase('system_currency');?>* :</label>
        <div class="col-md-6 col-sm-6">
                  <select class="form-control" name="system_currency_id">

         <?php 
                          $currencies = $this->db->get('currency')->result_array();
                          $system_currency_id = $this->db->get_where('settings' , array('type' => 'system_currency_id'))->row()->description;
                          foreach ($currencies as $row):
                        ?>
                                            <option value="<?php echo $row['currency_id'];?>"
                            <?php if ($row['currency_id'] == $system_currency_id) echo 'selected';?>>
                              <?php echo $row['currency_name'];?></option>
                        <?php endforeach;?>
                        </select>
         </div>
          <div class="col-md-1 col-sm-1"><i class="fa fa-2x fa-money"></i></div>
     </div>
      <!--<div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('stripe_secret_key');?>* :</label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" id="stripe_api_key" placeholder="<?php echo get_phrase('stripe_api_key');?>" data-parsley-required="true" name="stripe_api_key" value="<?php echo $this->db->get_where('settings' , array('type' =>'stripe_api_key'))->row()->description;?>" />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('stripe_publishable_key');?>* :</label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" id="stripe_publishable_key" name="stripe_publishable_key" value="<?php echo $this->db->get_where('settings' , array('type' =>'stripe_publishable_key'))->row()->description;?>" data-parsley-required="true" placeholder="<?php echo get_phrase('stripe_publishable_key');?>" />
        </div>
      </div>-->
      
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('paypal_email');?>* :</label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" id="paypal_email" name="paypal_email" value="<?php echo $this->db->get_where('settings' , array('type' =>'paypal_email'))->row()->description;?>" data-parsley-required="true" placeholder="<?php echo get_phrase('paypal_email');?>" />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('Paypal % Per Payment (ex. 0.01 for 1%)');?>* :</label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" id="paypal_cost_per_payment" name="paypal_cost_per_payment" value="<?php echo $this->db->get_where('settings' , array('type' =>'paypal_cost_per_payment'))->row()->description;?>" data-parsley-required="true" placeholder="<?php echo get_phrase('paypal_email');?>" />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('Paypal Processing Fee Per Payment (eg. 0.3 for 30 cents)');?>* :</label>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" id="paypal_cost_per_payment" name="paypal_cost_per_payment" value="<?php echo $this->db->get_where('settings' , array('type' =>'paypal_cost_per_payment_more'))->row()->description;?>" data-parsley-required="true" placeholder="<?php echo get_phrase('paypal_email');?>" />
        </div>
      </div>
      
      
      
      <div class="form-group">
      <label class="control-label col-md-4 col-sm-6"></label>
      <div class="col-md-6 col-sm-6">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    
    </div>
    </form>
    <div class="col-md-6 col-sm-6">
		<div class="note note-info">
    <h4>                    <?php echo get_phrase('payment setting');?>!</h4>
  </div>
  		<div class="col-md-8 col-sm-8 text-center">

          <div class="fileinput fileinput-new" data-provides="fileinput" style="overflow:hidden;">
            <div class="fileinput-new text-center"  data-trigger="fileinput" >
                                        <img src="<?php echo base_url().'uploads/paymentlogo.png';?>" alt="..." style="width:100%;">
                                    </div>
                                    

                                </div>
        </div>
  
    </div>
    
  
</div>
