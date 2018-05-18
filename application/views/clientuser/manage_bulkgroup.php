<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_bulkgroup/<?php echo $list_info->rec_id; ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
		<div class="form-group" style="background-color: #eee">
		<label class="control-label col-md-3" ><h5 style="font-weight: bold;margin: 0;"><?php echo get_phrase('Choose Phone Number');?></h5></label>
		<div class="col-md-6">
			<select class="form-control" name="phoneSelection" id="phoneSelection"  onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/manage_bulkgroup/'+this.value;$('body.boxed-layout').css('opacity','0.6')">
			<?php 
			/*if($_SERVER['REMOTE_ADDR'] == '110.232.248.49'){
				//echo $this->session->userdata('login_user_id').'HERE1<pre>';print_r($phoneNumbers);exit;
			}*/
			foreach($phoneNumbers as $phoneNumberr){
				echo "<option value=".$phoneNumberr->rec_id." ".($list_info->phoneNumber==$phoneNumberr->phoneNumber ? "selected":"").">".$phoneNumberr->friendlyName.' '.$phoneNumberr->campaign_name."</option>";
			}
			?>
		  
			</select>
	</div>
	<div class="col-md-3 text-right">
		<!--<a class="btn btn-primary" href="<?php echo base_url(); ?>clientuser/send_bulksms/<?php echo $list_info->rec_id; ?>">Send Text in Bulk <i class="fa fa-angle-right"></i></a>-->
	</div>

  </form>
</div>

<section>
<?php if(count($bulksms_list)>0 && !isset($numedit)): ?>
<div class="col-md-8">
	<div class="panel-body panel-form" style="margin-top:25px; padding: 0 0px !important">
				<table id="data-table" class="table table-responsive table-striped table-striped table-bordered ">
					<thead>
						<th></th>
						<th>Name</th>
						<th>Actions</th>
					</thead>
					<tbody>
						<?php $j=0; ?>
						<?php foreach($bulksms_list as $bulknum): ?>
						<tr>
							<td><?php echo ++$j; ?></td>
							<td><b><?php echo ($bulknum->name); ?></b></td>
							<td><a class="btn btn-sm btn-secondary" href="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $bulknum->id; ?>"><i class="fa fa-eye"></i> View</a>
							<a class="btn btn-sm btn-secondary" href="<?php echo base_url(); ?>clientuser/manage_bulkgroup/<?php echo $list_info->rec_id; ?>/edititem/<?php echo $bulknum->id; ?>"><i class="fa fa-edit"></i> Edit</a> <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>clientuser/manage_bulkgroup/<?php echo $list_info->rec_id; ?>/delete/<?php echo $bulknum->id; ?>"><i class="fa fa-remove"></i> Delete</a></td>
						</tr>
						<?php endforeach; ?>	
					</tbody>
				</table>
	</div>
</div>
<?php elseif(!isset($numedit)): ?>
<div class="alert alert-notice text-center">
	<b class="lead">No groups for Bulk Texting!</b>
</div>
<?php endif; ?>
<div class="col-md-4">

	<div class="panel-body panel-form" style="border:0px solid #eee; margin: 25px 0px;">
		
		<form class="form-horizontal col-sm-12" style="border:1px solid #eee;padding-top:10px;" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_bulkgroup/<?php echo $list_info->rec_id; ?>/updatelist" name="blockednum-form" novalidate method="post"  enctype="multipart/form-data">
				<input type="hidden" name="inlist_id" value="<?php echo isset($numedit) ? $numedit->id : ''; ?>" />
				<div class="form-group">
					<div class="col-md-12">
					<label class="control-label" ><?php echo get_phrase('Group Name');?></label>
					   <input class="form-control" name="gname" placeholder="Group Name" data-parsley-required="false" type="text" value="<?php echo isset($numedit) ? $numedit->name : ''; ?>">
					</div>
				</div>
				
				<!--  SUBMIT -->
				<div class="form-group">
					<div class="col-md-12 text-center">
					   <div class="">
						  <button type="submit" class="btn btn-success"><?php echo isset($numedit) ? get_phrase('Save Group') : get_phrase('Add Group'); ?></button>
					   </div>
					</div>
				</div>
	    </form>
	</div>
</div>	
</section>
<script>
	$(document).ready(function(){

	})
</script>