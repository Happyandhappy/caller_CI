
<div class="col-md-8 ui-sortable">
   <div class="panel-body panel-form">
      <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/admins/newadd" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="fullname"><?php echo get_phrase('name');?></label>
            <div class="col-md-6 col-sm-6">
               <input class="form-control"  name="name" value="<?php echo $row['name'];?>" placeholder="Required" data-parsley-required="true" type="text">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="email">Email * :</label>
            <div class="col-md-6 col-sm-6">
               <input class="form-control" id="email" name="email" value="<?php echo $row['email'];?>" data-parsley-type="email" placeholder="Email" data-parsley-required="true" type="text">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 text-white">Password</label>
            <div class="col-md-6">
               <input data-toggle="password" data-placement="after" class="form-control" type="text" name="new_password" value="" placeholder="password" data-parsley-required="true" />
            </div>
         </div>
         <div class="form-group" >
            <label class="control-label col-md-4 col-sm-4" for="website"><?php echo get_phrase('phone');?></label>
            <div class="col-md-6 col-sm-6">
               <input class="form-control cust_phone_no" name="phone" value="<?php echo $row['phone'];?>" data-parsley-required="true" placeholder="phone" type="text">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('address');?></label>
            <div class="col-md-6 col-sm-6">
               <textarea class="form-control" id="address" name="address" rows="4" placeholder="Range from 20 - 200"><?php echo $row['address'];?></textarea>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
               <button type="submit" class="btn btn-sm btn-success"><?php echo get_phrase('Add Admin');?></button>
            </div>
         </div>
      </form>
   </div>
</div>
<div class="col-md-4 ui-sortable">
 <?php if($this->session->flashdata('success')){ ?>
   <div class="alert alert-success fade in">
      <button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> </button>
      <?php echo $this->session->flashdata('success');?> </div>
   <?php } if($this->session->flashdata('error')){ ?>
   <div class="alert alert-danger fade in">
      <button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> </button>
      <?php echo $this->session->flashdata('error');?> </div>
   <?php } ?>
</div>
