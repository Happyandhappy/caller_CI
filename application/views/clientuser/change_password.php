<?php  foreach($edit_data as $row): ?>

<!--<div class="col-md-12 ui-sortable">
   <div class="panel-body bg-green text-white">-->
   <div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
      <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/change_password" name="demo-form" novalidate="" method="post">
         <div class="form-group">
            <label class="control-label col-md-4 text-white"><?php echo get_phrase('current_password');?></label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" name="password" class="form-control" type="password" value="" placeholder="password" data-parsley-required="true"/>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 text-white"><?php echo get_phrase('new_Password');?></label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" name="new_password" class="form-control" type="password" value="" placeholder="password" data-parsley-required="true" />
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-4 text-white"><?php echo get_phrase('confirm_new_password');?></label>
            <div class="col-md-8">
               <input data-toggle="password" data-placement="after" name="confirm_new_password" class="form-control" type="password" value="" placeholder="password" data-parsley-required="true"/>
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
<?php endforeach;?>
