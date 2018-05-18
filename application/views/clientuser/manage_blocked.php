<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_blocked/<?=$phoneNumber ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
		<div class="form-group" style="background-color: #eee">
		<label class="control-label col-md-4 col-sm-4" ><h5 style="font-weight: bold;margin: 0;"><?php echo get_phrase('Choose Phone Number');?></h5></label>
		<div class="col-md-8 ">
			<select class="form-control" name="phoneSelection" id="phoneSelection"  onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/manage_numbers/'+this.value;$('body.boxed-layout').css('opacity','0.6')">
			<?php 
			/*if($_SERVER['REMOTE_ADDR'] == '110.232.248.49'){
				//echo $this->session->userdata('login_user_id').'HERE1<pre>';print_r($phoneNumbers);exit;
			}*/
			foreach($phoneNumbers as $phoneNumberr){
				echo "<option value=".$phoneNumberr['phoneNumber']." ".($phoneNumber==$phoneNumberr['phoneNumber']?"selected":"").">".$phoneNumberr['friendlyName'].' '.$phoneNumberr['campaign_name']."</option>";
			}
			?>
		  
			</select>
		</div>
	</div>

  </form>
</div>

<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:25px;">
	<?php if(count($blocked_listed)>0): ?>
			<table class="table table-responsive table-striped">
				<thead>
					<th>Number</th>
					<th>Added</th>
					<th>Times Blocked</th>
					<th>Actions</th>
				</thead>
				<tbody>
					<?php foreach($blocked_listed as $blocknum): ?>
					<tr>
						<td><?php echo ct_format_nice_number($blocknum->blocked); ?></td>
						<td><?php echo ct_format_nice_date($blocknum->created_at); ?></td>
						<td><?php echo $blocknum->times; ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>clientuser/manage_blocked/<?=$phoneNumber ?>/delete/<?php echo $blocknum->id; ?>">Unblock</a></td>
					</tr>
					<?php endforeach; ?>	
				</tbody>
			</table>
	<?php else: ?>
		<div class="alert alert-notice text-center">
			<b class="lead">No blocked numbers!</b>
		</div>
	<?php endif; ?>
</div>
<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:25px;">
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_blocked/<?=$phoneNumber ?>" name="blockednum-form" novalidate method="post"  enctype="multipart/form-data">
		
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" ><?php echo get_phrase('Phone Number to Block');?></label>
				<div class="col-md-8">
				   <input class="form-control cust_phone_no" name="blocked" placeholder="Number to Block" data-parsley-required="true" type="text">
				</div>
			</div>
			
			<!--  SUBMIT -->
			<div class="form-group">
				<div class="col-md-8 col-md-offset-4">
				   <div class="">
					  <button type="submit" class="btn btn-sm btn-success"><?php echo get_phrase('Block Number');?></button>
				   </div>
				</div>
			</div>

  </form>
</div>
<script>
	$(document).ready(function(){

	})
</script>