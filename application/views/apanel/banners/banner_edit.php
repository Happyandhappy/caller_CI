<?php 
$this->db->where('banner_id', $banner_id);
$data = $this->db->get('tbl_banner')->row();
?>
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/banner_edit/<?php echo $banner_id ?>/do_update" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
		   <div class="col-md-8 col-sm-6 ui-sortable">
				  <div class="panel-body panel-form">
                   
                    
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Upload Picture')?> * :</label>
				<div class="col-md-6 col-sm-6">
                      <!--<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                          <img src="<?php echo base_url();?>uploads/works_img/<?php echo $data->image?>" alt="...">
                      </div>-->
                      <div>
                          <span class="btn btn-white btn-file">
                              <span class="fileinput-new">Select video</span>
                              <span class="fileinput-exists">Change</span>
                              <input type="file" name="userfile" accept="*" class="form-control" >
                          </span>
                          <!--<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>-->
                      </div>
					  <?php echo form_error('userfile','<span for="category" class="help-inline">','</span>');?>
                </div>
          </div>
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
										<textarea class="ckeditor" id="content" name="content" rows="20" data-parsley-required="true" data-parsley-type="text" ><?php echo $data->description?></textarea>
								</div>
							</div>
							<!-- end panel -->
						</div>
					</div>
                

                  <div class="control-group">
                    <div class="col-sm-offset-3 controls">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
                    </div>
                  </div>

				</div>
			</div>	
                  <?php echo form_close();?>


