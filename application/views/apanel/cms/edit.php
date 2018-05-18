	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/pages/edit" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
		   <div class="col-md-8 col-sm-6 ui-sortable">
				  <div class="panel-body panel-form">
                   
                  <div class="form-group">
                      <label class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Page Title');?></label>
                      <div class="col-md-10 col-sm-6">
                          <input type="text" class="form-control" readonly id="page_title" name="page_title" maxlength="100"
                              value="<?php echo $this->db->get_where('ct_pages' , array('page_id' =>$page_id))->row()->page_title;?>" data-parsley-required="true" data-parsley-type="text">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="control-label col-md-2 col-sm-4" for="email"><?php echo get_phrase('Page Heading');?></label>
                      <div class="col-md-10 col-sm-6">
                          <input type="text" class="form-control" name="page_heading" id="page_heading" 
                              value="<?php echo $this->db->get_where('ct_pages' , array('page_id' =>$page_id))->row()->page_heading;?>" data-parsley-required="true" data-parsley-type="text">
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
										<textarea class="ckeditor" id="content" name="content" rows="20" data-parsley-required="true" data-parsley-type="text" ><?php echo $this->db->get_where('ct_pages' , array('page_id' =>$page_id))->row()->page_content;?></textarea>
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


