
<div class="row-fluid"> 
  
  <!-- block -->
  
  <div class="block">
    <div class="block-content collapse in">
      <div class="span12">
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
		<div class="table-toolbar">
          <div class="btn-group"> <a href="<?php echo base_url(); ?>apanel/admins/add/">
            <button class="btn btn-success m-r-5 m-b-5"><?php echo get_phrase('Add New')?> <i class="fa fa-plus icon-white"></i></button>
            </a> </div>
          <div class="btn-group pull-right">
            <button data-toggle="dropdown" class="btn dropdown-toggle"><?php echo get_phrase('Tools')?> <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#"><?php echo get_phrase('Print')?></a></li>
              <li><a href="#"><?php echo get_phrase('Save As PDF')?></a></li>
              <li><a href="#"><?php echo get_phrase('Export to Excel')?></a></li>
            </ul>
          </div>
        </div>
       <table id="data-table" class="table table-striped table-bordered nowrap">
          <thead>
            <tr>
              <th><?php echo get_phrase('Sr/No')?></th>
              <th><?php echo get_phrase('Name')?></th>
              <th><?php echo get_phrase('Email')?></th>
              <th style="text-align:center;"><?php echo get_phrase('Actions')?></th>
            </tr>
          </thead>
          <tbody>
            <?php
        $caounter=0;
        foreach ($list_admins as $row):$caounter++;?>
            <tr>
              <td style="width:30px;"><?php echo $caounter;?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td style="width:200px">
                <?php if($row['admin_id']!=1): ?>
				        <a href="<?php echo base_url().'apanel/admins/delete/'. $row['admin_id']; ?>" class="btn btn-danger">Delete</a>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /block --> 
  
</div>
