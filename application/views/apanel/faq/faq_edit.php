<?php 
$this->db->where('faq_id', $faq_id);
$data = $this->db->get('tbl_faq')->row();
?>


<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/faq_edit/<?php echo $data->faq_id ?>" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-6 ui-sortable">
  <div class="panel-body panel-form">

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Question')?> * :</label>
			<div class="col-md-6 col-sm-6">
			  <input class="form-control" id="question" name="question" maxlength="100"  value="<?php echo $data->question ?>" placeholder="<?php echo get_phrase('question')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('question','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Answer')?> * :</label>
			<div class="col-md-8 col-sm-6">
              <textarea id="answer" rows="10" name="answer" placeholder="<?php echo get_phrase('Answer')?>" data-validation="required" class="form-control" data-parsley-required="true" data-parsley-type="text"><?php echo $data->answer?></textarea>
			  <?php echo form_error('answer','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->


          <!---->
      <div class="form-group"  style="display:none;">
         <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('Status')?></label>
        <div class="col-md-8">
          <div class="radio">
            <label><input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" <?php if( $data->status =='1'){?>checked=checked<?php }?>/>Active</label>
            <label><input type="radio" name="status" id="radio-required2" value="0" <?php if( $data->status =='0'){ ?>checked=checked<?php }?>/>In-active</label>
          </div>
        </div>
        <?php echo form_error('status','<span for="category" class="help-inline">','</span>');?> </div>

	<div class="form-group">
      <div class="col-md-8 col-md-offset-4">
        <div class="input-append input-group">
          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Update');?></button>
          <button type="button" class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>apanel/faq'"><?php echo get_phrase('Cancel');?></button>
        </div>
      </div>
    </div>

  
    
</div>
</div>

</form>
