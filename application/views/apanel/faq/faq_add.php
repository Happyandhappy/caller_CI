
<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/faq_add" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-6 ui-sortable">
  <div class="panel-body panel-form">

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Question')?> * :</label>
			<div class="col-md-6 col-sm-6">
			  <input class="form-control" id="question" name="question" maxlength="100" value="<?php echo set_value('question')?>" placeholder="<?php echo get_phrase('question')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('question','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-4 col-sm-4" for="email"><?php echo get_phrase('Answer')?> * :</label>
			<div class="col-md-8 col-sm-6">
              <textarea id="answer" rows="10" name="answer" placeholder="<?php echo get_phrase('Answer')?>" data-validation="required" class="form-control" data-parsley-required="true" data-parsley-type="text"><?php echo set_value('answer')?></textarea>
			  <?php echo form_error('answer','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->


          <!---->
    <div class="form-group" >
      <label class="control-label col-md-4 "><?php echo get_phrase('Status')?></label>
       <div class="col-md-8">
      <div class="radio">
        <label><input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true"  />Active</label>
         <label><input type="radio" name="status" id="radio-required2" value="0" />In-active</label>
         </div>
      </div>
      <?php echo form_error('status','<span for="category" class="help-inline">','</span>');?> </div>

	<div class="form-group">
      <div class="col-md-8 col-md-offset-4">
        <div class="input-append input-group">
          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Create');?></button>
          <button type="button" class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>apanel/faq'"><?php echo get_phrase('Cancel');?></button>
        </div>
      </div>
    </div>

  
    
</div>
</div>

</form>
