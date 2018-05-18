
<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/pages/add" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-10 ui-sortable">
  <div class="panel-body panel-form">

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Page Title')?> * :</label>
			<div class="col-md-10 col-sm-6">
			  <input class="form-control" id="page_title" name="page_title" maxlength="100" value="<?php echo set_value('page_title')?>" placeholder="<?php echo get_phrase('Page Title')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('page_title','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->
          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Page Heading')?> * :</label>
			<div class="col-md-10 col-sm-6">
			  <input class="form-control" id="page_heading" name="page_heading" maxlength="100" value="<?php echo set_value('page_heading')?>" placeholder="<?php echo get_phrase('Page Heading')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('page_heading','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-4" for="email">Content</label>	
				<div class="col-md-10">
							<!-- begin panel -->
							<div class="panel panel-inverse" data-sortable-id="form-wysiwyg-1">
								<div class="panel-heading">
									<div class="panel-heading-btn">
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
									</div>
									<h4 class="panel-title">Content</h4>
								</div>
								<div class="panel-body panel-form">
										<textarea class="ckeditor" id="content" name="content" rows="20" data-parsley-required="true" data-parsley-type="text" ><?php echo set_value('content')?></textarea>
								</div>
							</div>
							<!-- end panel -->
						</div>
			</div>
                

	<div class="form-group">
      <div class="col-md-10 col-md-offset-2">
        <div class="input-append input-group">
          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Create');?></button>
          <button type="button" class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>apanel/pages'"><?php echo get_phrase('Cancel');?></button>
        </div>
      </div>
    </div>

  
    
</div>
</div>

</form>
