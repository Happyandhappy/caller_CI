
<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>apanel/promos/edit/<?php echo $pdat['promo_id']; ?>" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">

  <div class="col-md-10 ui-sortable">
  <div class="panel-body panel-form">

          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="promo_code"><?php echo get_phrase('Promo Code')?> * :</label>
			<div class="col-md-6 col-sm-6">
			  <input class="form-control" id="promo_code" name="promo_code" maxlength="200" value="<?php echo $pdat['promo_code']; ?>" placeholder="<?php echo get_phrase('Promo Code')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('promo_code','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="affect"><?php echo get_phrase('Affect')?> * :</label>
			<div class="col-md-6 col-sm-6">
				<select name="affect" class="form-control">
					<option value="0">All</option>
					<?php foreach($subs as $sid => $sub): ?>
					<option value="<?php echo $sid; ?>" <?php echo ($pdat['affect']==$sid ? 'selected': ''); ?>><?php echo $sub['package_name']; ?></option>
					<?php endforeach; ?>
				</select>
			  <?php echo form_error('affect','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->
          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="discount"><?php echo get_phrase('Promo Discount')?> * :</label>
			<div class="col-md-4 col-sm-4">
			  <input class="form-control" id="discount" name="discount" maxlength="100" value="<?php echo $pdat['discount']; ?>" placeholder="<?php echo get_phrase('Promo Discount')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			</div>
				<div class="col-md-2 col-sm-4">
				<select name="is_percent" class="form-control">
					<option value="0" <?php echo (!$pdat['is_percent'] ? 'selected': ''); ?>>$ - Cash</option>
					<option value="1" <?php echo ($pdat['is_percent'] ? 'selected': ''); ?>>% - Percent</option>
				</select>
				</div>
			  <?php echo form_error('discount','<span for="category" class="help-inline">','</span>');?> 
		  </div>
          <!---->
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-4" for="used_max"><?php echo get_phrase('Promo Max Usage')?> * :</label>
			<div class="col-md-6 col-sm-6">
			  <input class="form-control" id="used_max" name="used_max" maxlength="100" value="<?php echo $pdat['used_max']; ?>" placeholder="<?php echo get_phrase('Promo Discount')?>" data-parsley-required="true" data-parsley-type="text" type="text">
			  <?php echo form_error('used_max','<span for="category" class="help-inline">','</span>');?> </div>
		  </div>
          <!---->
                

	<div class="form-group">
      <div class="col-md-10 col-md-offset-2">
        <div class="input-append input-group">
          <button type="submit" class="btn btn-warning"><?php echo get_phrase('Update');?></button> &nbsp;
          <button type="button" class="btn btn-warning" onclick="window.location.href='<?php echo base_url()?>apanel/promos'"><?php echo get_phrase('Cancel');?></button>
        </div>
      </div>
    </div>

  
    
</div>
</div>

</form>
