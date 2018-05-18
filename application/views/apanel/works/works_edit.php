<?php 
$this->db->where('works_id', $works_id);
$data = $this->db->get('tbl_howitworks')->row();
?>

<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/works_edit/<?php echo $data->works_id?>" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-10 ui-sortable">
  <div class="panel-body panel-form">

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Upload Picture')?> * :</label>
				<div class="col-md-6 col-sm-6">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                          <img src="<?php echo base_url();?>uploads/works_img/<?php echo $data->image?>" alt="...">
                      </div>
                      <div>
                          <span class="btn btn-white btn-file">
                              <span class="fileinput-new">Select image</span>
                              <span class="fileinput-exists">Change</span>
                              <input type="file" name="userfile" accept="image/*" class="form-control" >
                          </span>
                          <!--<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>-->
                      </div>
					  <?php echo form_error('userfile','<span for="category" class="help-inline">','</span>');?>
                </div>
          </div>
          <!---->

	<div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Content')?> * :</label>
		<div class="col-md-9">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-wysiwyg-1">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Description</h4>
				</div>
				<div class="panel-body panel-form">
					<textarea class="ckeditor" id="title" name="title" rows="20"  placeholder="<?php echo get_phrase('Description')?>" data-parsley-required="true" data-parsley-type="text" ><?php echo $data->title?></textarea>
				  <?php echo form_error('title','<span for="category" class="help-inline">','</span>');?> </div>
				</div>
			</div>
			<!-- end panel -->
		</div>
	</div>

          <!---->
      <div class="form-group" style="display:none;">
         <label class="control-label col-md-2 col-sm-4" for="message"><?php echo get_phrase('Status')?></label>
        <div class="col-md-8">
          <div class="radio">
            <label><input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" <?php if( $data->status =='1'){?>checked=checked<?php }?>/>Active</label>
            <label><input type="radio" name="status" id="radio-required2" value="0" <?php if( $data->status =='0'){ ?>checked=checked<?php }?>/>In-active</label>
          </div>
        </div>
        <?php echo form_error('status','<span for="category" class="help-inline">','</span>');?> </div>

	<div class="form-group">
      <div class="col-md-8 col-md-offset-2">
        <div class="input-append input-group">
          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Update');?></button>
          <button type="button" class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>apanel/works'"><?php echo get_phrase('Cancel');?></button>
        </div>
      </div>
    </div>

  
    
</div>
</div>

</form>
