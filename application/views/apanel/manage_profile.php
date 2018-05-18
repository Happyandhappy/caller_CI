<?php  foreach($edit_data as $row): ?>

<div class="col-md-8 ui-sortable">
   <div class="panel-body panel-form">
      <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/manage_profile/update_profile_info" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
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
            <label class="control-label col-md-4 col-sm-4" for="message"><?php echo get_phrase('admin profile picture'); ?></label>
            <div class="col-md-6 col-sm-6">
               
                     
                     <div class="fileinput fileinput-new" data-provides="fileinput" style="overflow:hidden;">
                  <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;" data-trigger="fileinput" >
                  <!--<img src="<?php //echo base_url().'uploads\client_image\\'.$row['client_id'].'.jpg';?>" alt="..." style="height:100%;">--> 
                  <img src="<?php echo base_url().'uploads\admin_image\\'.$row['profile_image'];?>" alt="..." style="height:100%;">
                  <input type="hidden" name="profile_img" id="profile_img"  value="<?php echo $row['profile_image'];?>"/></div>
                  <div> <span class="btn btn-white btn-file" style="overflow:hidden;"> <i class="fa fa-plus"></i> <span>Add file...</span>
                     <input type="file" name="image" accept="image/*" value="" class="btn btn-primary start">
                     </span> </span><span style="color:red;"><?php if($error!='')echo $error; ?></span> </div>
            
                     
                     
               </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
               <button type="submit" class="btn btn-sm btn-success"><?php echo get_phrase('update_profile');?></button>
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
   <div class="panel panel-success" style="margin-bottom:0px;">
      <div class="panel-heading">
         <h4 class="panel-title"><?php echo get_phrase('change_password');?></h4>
      </div>
   </div>
   <div class="panel-body bg-green text-white">
      <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/manage_profile/change_password" name="demo-form" novalidate="" method="post">
         <div class="form-group">
            <label class="control-label col-md-4 text-white"><?php echo get_phrase('current_password');?></label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" class="form-control" type="password" name="password" value="" placeholder="password" data-parsley-required="true"/>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 text-white">new Password</label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" class="form-control" type="password" name="new_password" value="" placeholder="password" data-parsley-required="true" />
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 text-white"><?php echo get_phrase('confirm_new_password');?></label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" class="form-control" type="password" name="confirm_new_password" value="" placeholder="password" data-parsley-required="true"/>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
               <div class="input-append input-group">
                  <button type="submit" class="btn btn-warning"><?php echo get_phrase('change_password');?></button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<?php endforeach;?>
