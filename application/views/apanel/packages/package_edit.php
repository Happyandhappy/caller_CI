<?php 

$this->db->where('package_id', $package_id);

$data = $this->db->get('packages')->row();

?>

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



<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/package_edit/<?php echo $data->package_id?>" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-6 ui-sortable">

    <div class="panel-body panel-form">

      <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="fullname"><?php echo get_phrase('Package Name')?> * :</label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control"  name="package_name" value="<?php echo $data->package_name;?>" placeholder="<?php echo get_phrase('package_name')?>" data-parsley-required="true" type="text">

          <?php echo form_error('package_name','<span for="category" class="help-inline">','</span>');?> </div>

      </div>

      <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Package Cost')?> * :</label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="package_amount" name="package_amount" value="<?php echo $data->package_amount;?>" placeholder="<?php echo get_phrase('package_amount')?>" data-parsley-required="true" type="text">

          <?php echo form_error('package_amount','<span for="category" class="help-inline">','</span>');?> </div>

      </div>


      <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Package Description')?></label>

        <div class="col-md-8 col-sm-8">

          <textarea class="form-control" id="description" name="description" rows="4"  placeholder="<?php echo get_phrase('Package Description')?>" data-parsley-required="true"><?php echo $data->description;?></textarea>

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	 
	  
	 

    </div>

  </div>

  <div class="col-md-6 ui-sortable">

  <div class="panel-body panel-form">

  

  

    <div class="form-group">

      <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Features')?></label>

        <div class="col-md-8 col-sm-8">

        <div class="input-group">

          <?php $features = explode('#$#',$data->features); ?>

          <input class="form-control" id="features" name="features[]" value="<?php echo $features[0]?>" placeholder="<?php echo get_phrase('features')?>" data-parsley-required="true" type="text">

          <div class="input-group-btn"><a href="javascript:;" class="btn btn-success" onclick="CallInput();" style="width:80px;"><i class="fa fa-plus"></i> Add </a></div>

        </div>

        <div class="p-5 bg-silver" id="inputDiv">

          <?php  $limit = count($features);

              for($i=1;$i<$limit;$i++){?>

          <div class="input-group" id="div<?php echo $i;?>">

            <input  type="text" class="form-control" name="features[]" id="features" value="<?php echo $features[$i];?>"/>

            <div class="input-group-btn"><a href="javascript:;" class="btn btn-danger p-5 p-2" onclick="removeInput('<?php echo $i;?>');" style="width:80px;"><i class="fa fa-times"></i> Remove</a></div>

          </div>

          <?php }?>

        </div>

        <?php echo form_error('features','<span for="category" class="help-inline">','</span>');?> </div>

        </div>

      <script>

    var counter =<?php echo $limit;?>;

    function CallInput(){

    counter++;

    $('#inputDiv').append('<div class="input-group" id="div'+counter+'"><input type="text" class="form-control" name="features[]" id="features" value="<?php echo set_value('features')?>" class="p-5"/><div class="input-group-btn"><a href="javascript:;" class="btn btn-danger p-5" onclick="removeInput('+counter+');"><i class="fa fa-times"></i> Remove</a></div></div>');

    }

    function removeInput(cnt){

    $('#div'+cnt).remove();

    counter--;

    }

    </script>

      <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Package Duration')?></label>

        <div class="col-md-8">

          <select class="form-control" name="duration_id" data-parsley-required="true" >

                <option value="">--<?php echo get_phrase('Select Package')?>--</option>

                <option value="12" <?php if($data->duration_id =='12'){?>selected="selected" <?php } ?>><?php echo get_phrase('Yearly')?></option>

              <!--  <option value="3" <?php //if($data->duration_id =='3'){?>selected="selected" <?php //} ?>><?php //echo get_phrase('Quarterly')?></option>

                <option value="1" <?php //if($data->duration_id =='1'){?>selected="selected" <?php //} ?>><?php //echo get_phrase('Monthly')?></option>

                <option value="free" <?php //if($data->duration_id =='free'){?>selected="selected" <?php // } ?>><?php //echo get_phrase('Free')?></option>-->

          </select>

          <?php echo form_error('duration_id','<span for="category" class="help-inline">','</span>');?> </div>

      </div>

      <div class="form-group" style="">

         <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Status')?></label>

        <div class="col-md-8">

          <div class="radio">

            <label><input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" <?php if( $data->status =='1'){?>checked=checked<?php }?>/>Active</label>

            <label><input type="radio" name="status" id="radio-required2" value="0" <?php if( $data->status =='0'){ ?>checked=checked<?php }?>/>In-active</label>

          </div>

        </div>

        <?php echo form_error('status','<span for="category" class="help-inline">','</span>');?> </div>

    </div>

  </div>

  
   <div class="col-md-12 ui-sortable">
		<div class="panel-body panel-form">
		<h3>Package Pricing</h3>
		<div class="col-md-6">
			 <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Incoming Call Charges')?></label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="call_charge" name="call_charge" value="<?php echo $data->call_charge;?>" placeholder="<?php echo get_phrase('Incoming Call Charges')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	  <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Lookup Call Charges')?></label>

        <div class="col-md-8 col-sm-8">

         <input class="form-control" id="lookup_call_charge" name="lookup_call_charge" value="<?php echo $data->lookup_call_charge;?>" placeholder="<?php echo get_phrase('Lookup Call Charges')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	  <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Call Forward Charges')?></label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="call_forword_charges" name="call_forword_charges" value="<?php echo $data->call_forword_charges;?>" placeholder="<?php echo get_phrase('Call Forward Charges')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	  <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Call Recording Price')?></label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="p_call_recording" name="p_call_recording" value="<?php echo $data->p_call_recording;?>" placeholder="<?php echo get_phrase('Call Recording Price')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>

      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Incoming SMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="sms_charge" name="sms_charge" value="<?php echo $data->sms_charge;?>" placeholder="<?php echo get_phrase('Incoming SMS Price')?>" data-parsley-required="true"  type="text">
           <?php echo form_error('buy_number_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
      
	  </div>
	  <div class="col-md-6">
	   <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Transc. Service Price')?></label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="p_transc_service" name="p_transc_service" value="<?php echo $data->p_transc_service;?>" placeholder="<?php echo get_phrase('Transc. Service Price')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	  
	  <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Social Media Adv. Price')?></label>

        <div class="col-md-8 col-sm-8">

          <input class="form-control" id="p_social_med_adv" name="p_social_med_adv" value="<?php echo $data->p_social_med_adv;?>" placeholder="<?php echo get_phrase('Social Media Adv. Price')?>" data-parsley-required="true"  type="text">

          <?php echo form_error('description','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
	  
	  <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Block Spam Calls Price')?></label>

        <div class="col-md-8 col-sm-8">
		
			<input class="form-control" id="p_blk_spam_calls" name="p_blk_spam_calls" value="<?php echo $data->p_blk_spam_calls;?>" placeholder="<?php echo get_phrase('Block Spam Calls Price')?>" data-parsley-required="true"  type="text">

			<?php echo form_error('p_blk_spam_calls','<span for="category" class="help-inline">','</span>');?> </div>

      </div>
          
       <div class="form-group">

        <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Purchase Number Price (Monthly)')?></label>

        <div class="col-md-8 col-sm-8">
		
			<input class="form-control" id="buy_number_charge" name="buy_number_charge" value="<?php echo $data->buy_number_charge;?>" placeholder="<?php echo get_phrase('Purchase Number Price')?>" data-parsley-required="true"  type="text">

			<?php echo form_error('buy_number_charge','<span for="category" class="help-inline">','</span>');?> </div>

      </div>

      <div class="form-group">
        <label class="control-label col-md-4 col-sm-4"><?php echo get_phrase('Outgoing/Forwarded SMS Price')?></label>
          <div class="col-md-8 col-sm-8">
             <input class="form-control" id="sms_send_charge" name="sms_send_charge" value="<?php echo $data->sms_send_charge;?>" placeholder="<?php echo get_phrase('Outgoing/Forwarded SMS Price')?>" data-parsley-required="true"  type="text">
           <?php echo form_error('buy_number_charge','<span for="category" class="help-inline">','</span>');?> 
          </div>
      </div>
          
	  </div>
		</div>
   </div>
   
   
 
 
  <div class="">

    <div class="col-md-8  col-md-offset-5">

      <div class="input-append input-group">

        <button type="submit" class="btn btn-warning"><?php echo get_phrase('Update');?></button>

         <a href="<?php echo base_url(); ?>apanel/packages"  class="btn btn-default"><?php echo get_phrase('Back');?></a>

      </div>

    </div>

  </div>

</form>

