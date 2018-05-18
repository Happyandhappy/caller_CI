

<script type="text/javascript">
	var send_sms = function(sfrom,sto,smess) {
		var textf = $('#text-msg-form textarea');
		var msgcnt = textf.val().length;
		if(msgcnt>0) {
			//$('#rpfrm-'+smsid).submit();
			textf.attr('disabled', true);
			$('#text-msg-form a').attr('disabled', true);

			var postdata = {
				msg: smess,
				from:  sfrom,
				to:  sto,
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
		$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
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
			$('#file_pick').trigger('click'); 

		});
		$('#file_pick').on('change',function(ev) {
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



		<?php if( !empty($picked_num) && !empty($picked_who) ) : ?>
			setInterval(function() {
				get_sms('<?php echo $picked_num; ?>','<?php echo $picked_who; ?>');
			},60000);
		<?php endif; ?>
		$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
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
	
	<form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/send_bulksms/<?php echo $list_info->rec_id; ?>" name="demo-form" novalidate method="post"  enctype="multipart/form-data">
		<div class="form-group" style="background-color: #eee">
			<div class="col-md-3">
				<a class="btn btn-primary" href="<?php echo base_url(); ?>clientuser/manage_bulksms/<?php echo $list_info->rec_id; ?>"><i class="fa fa-angle-left"></i> Manage Bulk List </a>
			</div>
			<label class="control-label col-md-3 col-sm-3" ><h5 style="font-weight: bold;margin: 0;"><?php echo get_phrase('Choose Phone Number');?></h5></label>
			<div class="col-md-6">
				<select class="form-control" name="phoneSelection" id="phoneSelection"  onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/send_bulksms/'+this.value;$('body.boxed-layout').css('opacity','0.6')">
				<?php 
				/*if($_SERVER['REMOTE_ADDR'] == '110.232.248.49'){
					//echo $this->session->userdata('login_user_id').'HERE1<pre>';print_r($phoneNumbers);exit;
				}*/

				foreach($phoneNumbers as $phoneNumberr){
					echo "<option value=".$phoneNumberr->rec_id." ".($phoneNumber==$phoneNumberr->phoneNumber ? "selected":"").">".$phoneNumberr->friendlyName.' '.$phoneNumberr->campaign_name."</option>";
				}
				?>
			  
				</select>
			</div>
		</div>

	  </form>
	</div>
	<div class="panel-body panel-form" style="border:1px solid #eee; margin-top:0px;">

	<?php if( !empty($list_info) && $bulk_count>0 ) { ?>
	<div class="col-md-12 text-message-wrapper">

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