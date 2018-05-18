<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $group_info->id; ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
		<div class="form-group" style="background-color: #eee">
		<label class="control-label col-md-3" ><h5 style="font-weight: bold;margin: 0;"><?php echo get_phrase('Choose Group');?></h5></label>
		<div class="col-md-6">
			<select class="form-control" name="phoneSelection" id="phoneSelection"  onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/manage_bulksms/'+this.value;$('body.boxed-layout').css('opacity','0.6')">
			<?php 
			/*if($_SERVER['REMOTE_ADDR'] == '110.232.248.49'){
				//echo $this->session->userdata('login_user_id').'HERE1<pre>';print_r($phoneNumbers);exit;
			}*/
			foreach($group_list as $bulkgroup){
				echo "<option value=".$bulkgroup->id." ".($group_info->id==$bulkgroup->id ? "selected":"").">".$bulkgroup->name."</option>";
			}
			?>
		  
			</select>
	</div>
	<div class="col-md-3 text-right">
		<!--<a class="btn btn-primary" href="<?php echo base_url(); ?>clientuser/send_bulksms/<?php echo $group_info->id; ?>">Send Text in Bulk <i class="fa fa-angle-right"></i></a>-->
	</div>

  </form>
</div>

<div class="panel-body panel-form" style="margin-top:25px; padding: 0 10px !important">
	<?php if(count($bulksms_list)>0 && !isset($numedit)): ?>
			<table id="data-table" class="table table-responsive table-striped table-striped table-bordered ">
				<thead>
					<th></th>
					<th>Number</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Sent Count</th>
					<th>Added</th>
					<th>Details</th>
					<th>Actions</th>
				</thead>
				<tbody>
					<?php $j=0; ?>
					<?php foreach($bulksms_list as $bulknum): ?>
					<tr>
						<td><?php echo ++$j; ?></td>
						<td><?php echo ct_format_nice_number($bulknum->user_number); ?></td>
						<td><?php echo substr($bulknum->user_fname,0,80); ?></td> 
						<td><?php echo substr($bulknum->user_lname,0,80); ?></td>
						<td><?php echo intval($bulknum->sent_count); ?></td>
						<td><?php echo ct_format_nice_date($bulknum->added); ?></td>
						<td><?php @$priv_inf=json_decode($bulknum->user_moreinfo); if(is_array($priv_inf)) foreach($priv_inf as $mor) {
							if($mor!='') {
								echo substr($mor,0,50)."<hr style='margin: 5px 0;border-color: #ddd;'/>";
							}
						} ?></td>
						<td style="min-width:50px"><a class="btn btn-sm btn-secondary" href="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $group_info->id; ?>/edititem/<?php echo $bulknum->id; ?>"><i class="fa fa-edit"></i></a> <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $group_info->id; ?>/delete/<?php echo $bulknum->id; ?>"><i class="fa fa-remove"></i></a></td>
					</tr>
					<?php endforeach; ?>	
				</tbody>
			</table>
	<?php elseif(!isset($numedit)): ?>
		<div class="alert alert-notice text-center">
			<b class="lead">No numbers in Bulk Text list!</b>
		</div>
	<?php endif; ?>
</div>
<div class="panel-body panel-form" style="border:0px solid #eee; margin: 25px 10px;">
	
	<form class="form-horizontal col-sm-7" style="border:1px solid #eee;padding-top:10px;" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $group_info->id; ?>/updatelist" name="blockednum-form" novalidate method="post"  enctype="multipart/form-data">
			<input type="hidden" name="inlist_id" value="<?php echo isset($numedit) ? $numedit->id : ''; ?>" />
		
			<div class="form-group">
				<div class="col-md-12">
				<label class="control-label"><?php echo get_phrase('Phone Number to Add');?></label>
				   <input class="form-control cust_phone_no" name="user_number" placeholder="Number" data-parsley-required="true" type="text" value="<?php echo isset($numedit) ? ct_format_nice_number($numedit->user_number) : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
				<label class="control-label" ><?php echo get_phrase('First Name');?></label>
				   <input class="form-control" name="user_fname" placeholder="First Name" data-parsley-required="false" type="text" value="<?php echo isset($numedit) ? $numedit->user_fname : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
				<label class="control-label" ><?php echo get_phrase('Last Name');?></label>
				   <input class="form-control" name="user_lname" placeholder="Last Name" data-parsley-required="false" type="text" value="<?php echo isset($numedit) ? $numedit->user_lname : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
				<label class="control-label" ><?php echo get_phrase('User Details');?></label>
				   <input class="form-control" name="moreinfo1" placeholder="Add some more user details" data-parsley-required="false" type="text" value="<?php echo isset($umoreinfo[0]) ? $umoreinfo[0] : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
				<label class="control-label" ><?php echo get_phrase('More Details');?></label>
				   <input class="form-control" name="moreinfo2" placeholder="And even more details" data-parsley-required="false" type="text" value="<?php echo isset($umoreinfo[1]) ? $umoreinfo[1] : ''; ?>">
				</div>
			</div>
			
			<!--  SUBMIT -->
			<div class="form-group">
				<div class="col-md-12 text-center">
				   <div class="">
					  <button type="submit" class="btn btn-success"><?php echo get_phrase('Save Number to List');?></button>
				   </div>
				</div>
			</div>
    </form>
    <div class="col-sm-5">
    	<div class="bulkupload-helptext clearfix" style="border:1px solid #eee;padding:10px;margin-bottom:10px;">
    		<h4 class="text-center">Bulk Import</h4>
    		<p  class="text-center">
    			To import multiple numbers into a list you can upload a .csv file. The file should be formated as <b><a href="<?php echo base_url(); ?>uploads/bulksms_sample_importfile.csv" download>shown here</a></p>
    		</p>
    	</div>

		<form class="form-horizontal" style="border:1px solid #eee;padding:10px;" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/import_bulksms/<?php echo $group_info->id; ?>" name="blockednum-form" novalidate method="post"  enctype="multipart/form-data">
			<input type="hidden" name="inlist_id" value="<?php echo isset($numedit) ? $numedit->id : ''; ?>" />
			<div class="form-group">
				<div class="col-md-12">
				   <label class="control-label"><?php echo get_phrase('Upload .csv File');?></label>
				   <input class="form-control" name="imfile" type="file" />
				</div>
			</div>
			<!--  SUBMIT -->
			<div class="form-group">
				<div class="col-md-12 text-center">
				   <div class="">
					  <button type="submit" class="btn btn-success"><?php echo get_phrase('Import Numbers');?></button>
				   </div>
				</div>
			</div>
		</form>
    </div>
</div>

<script type="text/javascript">
	var send_sms = function(sfrom,sto,smess) {
		var textf = $('#text-msg-form textarea');
		var msgcnt = textf.val().length;
		if(msgcnt>0) {
			//$('#rpfrm-'+smsid).submit();
			textf.attr('disabled', true);
			$('#text-msg-form a').attr('disabled', true);

	   		 var picked = $('.send-optout').is(':checked');
	        if(picked) {
	        	smess = smess + "\n\n"+"Reply STOP to opt-out.";
	    	 }

			var postdata = {
				msg: smess,
				from:  sfrom,
				to:  sto,
				groupid: <?php echo $group_info->id; ?>,
				bulk: 1,
				ajax: 1
			};
			if($('.attached-file').length) {
				postdata.fileName = $('.attached-file').html();
				postdata.fileNewName = $('.attached-file').attr('data-fileNewName');
				postdata.fileType = $('.attached-file').attr('data-type');
			}

				$.post( '<?php echo site_url('/base/send_sms'); ?>',postdata)
				  .done(function(res) {
				    //alert( "It worked!" );
				    if(res.status=='success') {
				    	alert("All Messages Sent!");
				    } else {
				    	alert("There was an error! Messaging was interrupted!");
				    }
				  })
				  .fail(function() {
				    alert( "There was an error! Try again!" );
				  })
				  .always(function() {
					textf.val('');
					textf.attr('disabled', false);
					$('#text-msg-form a').attr('disabled', false);

						$('#text-msg-form .label').remove();
				  });
				 
				 

		} else {
			alert("1 Character Minimum");
		}
		return true;
	}
	var get_sms = function(sfrom,sto) {
		console.log("all good!");
	}
    $(document).ready(function () {
		$('.sendNewText').on('click',function(ev) {
	 		ev.preventDefault();
			var sure = confirm("Warning! You are about to send multiple SMS to every user in your list. Are you sure about this?");
			if(sure) {
				var textf = $('#text-msg-form textarea');
		 		send_sms('<?php echo ($list_info->phoneNumber); ?>',<?php echo $list_info->rec_id; ?>,textf.val());
			}

		});
		$('#attachFile').on('click',function(ev) {
			ev.preventDefault();
			$('#file_pick').trigger('click'); 

		});
		$('#file_pick').on('change',function(ev) {
			ev.preventDefault();
			if($('#file_pick').val()=='')
				return false;

			var formData = new FormData();
			formData.append('file', $('#file_pick')[0].files[0]);
			/*if($('#text-msg-form').attr('data-files-attc') > 1 ) {
				return false;
			}*/
			var textf = $('#text-msg-form textarea');
			textf.attr('disabled', true);
			$('#text-msg-form a').attr('disabled', true);

			$.ajax({
			       url : '<?php echo base_url(); ?>clientuser/upload_mms_file',
			       type : 'POST',
			       data : formData,
			       processData: false,  // tell jQuery not to process the data
			       contentType: false,  // tell jQuery not to set contentType
			       success : function(data) {
			           //console.log(data);
			          // alert(data);
					$('#file_pick').val(''); 
					if(data.status == 'success') {
						var fileName = data.fileUploaded.client_name;
						var fileNewName = data.fileUploaded.file_name;
						var file_type = data.fileUploaded.file_type;
						$('#text-msg-form .label').remove();

				   		 $('<span/>', {
						    'class': 'label label-warning attached-file',
						    'html': '<b>Attached: </b>'+fileName,
						    'data-fileNewName': fileNewName,
						    'data-type': file_type
						}).prependTo('#text-msg-form');
						textf.attr('disabled', false);
						$('#text-msg-form a').attr('disabled', false);
					}
			       }
			});
			ev.preventDefault();
			
		});

	});
	
</script>

<?php if ($this->session->flashdata('error_sms') && $this->session->userdata('is_subscriber')) { ?>


	<div class="alert-wrap">
        <div class="alert alert-danger"><span class="close" data-dismiss="alert">×</span>
            <div><b><?php echo $this->session->flashdata('error_sms'); ?></b></div>
        </div>
     </div>

<?php } ?>
<div id="sms-list">

	<!-- begin row -->
	<div class="row">
		<div class="col-md-12">

		<?php if(isset($alert_danger)){?>
			<div class="alert alert-danger">
				<b>Warning:</b> <?php echo $alert_danger;?>
			</div>
		<?php } else if(isset($alert_warning)){?>
			<div class="alert alert-wanring">
				<?php echo $alert_warning;?>
			</div>
		<?php }?>
	</div>
	</div>
	<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:5px;">
	
	<div class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/send_bulksms/<?php echo $list_info->rec_id; ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
		<div class="form-group" style="background-color: #eee">
			<div class="col-md-12">
				<h4>Send Mass Text</h4>
			</div>
		</div>

	  </div>
	</div>
	<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:0px;">

	<?php if( !empty($list_info) && $bulk_count>0 ) { ?>
	<div class="col-md-12 text-message-wrapper">

          <div class="form-group">
            <div class="col-md-8" style="margin:5px 0">
              <!-- Rounded switch -->
              <label class="switch"  style="float: left;">
                <input type="checkbox" name="send-optout" class="send-optout">
                <span class="slider round"></span>
              </label>
            	<label class="control-label" style="line-height: 30px; float: left; margin: 0 10px;">Turn this on to attach an opt-out message to the bottom of your bulk sms.</label>
            </div>
            <label class="control-label col-md-4" style="text-align: left;border: none;"></label>
          </div> 
          <div class="clearfix"></div>
    	<div class="form-group">
        	<div id="text-msg-form" data-files-attc="0">
    		<br/>
			  <label for="reply-msg">Message:</label>
			  <textarea class="form-control" rows="4" id="text-msg-content" name="text-msg" data-from="<?php echo $picked_num; ?>" data-to="0"></textarea>
			  <div class="submit-btn-wrap">
			  	<a class="btn btn-primary sendNewText" href="#">Send Message</a>
			  	<a class="btn btn-secondary btn-sm pull-right" id="attachFile" href="#">Add File <i class="fa fa-upload"></i></a>
			  </div>
			  <div style="opacity:0;height:0;width:0;overflow:hidden;" id="file-picker">
				<input type="file" id="file_pick" name="file_pick" />
			  </div>
		  	</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<?php } else {// -/ Empty SMS LISTING  ?>
		<div class="clearfix" style="margin:10px;">
		<?php if( empty($list_info) ) { ?>
		<div class="col-md-12">
			<div class="alert alert-warning"><b>Important:</b> Choose one of your phone numbers. </div>
		</div>
		<?php } elseif($bulk_count<=0) {?>
		<div class="col-md-12">
			<div class="alert alert-warning lead"><b>Important:</b> This list has zero opted in numbers to send texts to!</div>
		</div>
		<?php /*} else {?>
		<div class="col-md-12">
			<div class="alert alert-warning lead"><b>Important:</b> No Text Messages for this number found!</div>
		</div>
		<?php */} // ---/. ?>
		</div>

	<?php } // ---/. END SMS LISTING ?>

	</div>