

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
				   		 $('<div/>', {
						    'class': 'text-message sent clearfix',
						    'html': 
						        $('<div/>', {
						            'html': smess,
						            'class': 'message-bubble'
						        })
						}).appendTo('#text-message-list');
				    } else {
				   		 $('<div/>', {
						    'class': 'text-message sent clearfix danger',
						    'html': 
						        $('<div/>', {
						            'html': smess+'<br/><b>Message Not Send!</b>',
						            'class': 'message-bubble'
						        })
						}).appendTo('#text-message-list');

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
		var listsms = $('#text-message-list');
			//$('#rpfrm-'+smsid).submit();
			listsms.attr('disabled', true);

			var postdata = {
				ajax: 1
			};

				$.post( '<?php echo base_url('/clientuser/view_messages');?>/'+sfrom+'/'+sto,postdata)
				  .done(function(res) {
				    //alert( "It worked!" );
				    //console.log(res);
				    
				    var dod = $('<div/>');
				    $.each(res, function() {
				    	var fajlovi = '';
				    	if(res.mms_num_files>0) {
				    		fajlovi = '<br/>';
				    		for(var i = 0; i < res.mms_num_files; i++ ) {
				    			fajlovi = fajlovi+'<span class="mms-file"><i class="fa fa-file-'+res.media_urls[i]['mediaTypeGroup']+'-o"></i> <a href="'+res.media_urls[i]['mediaUrlShort']+'"  target="_blank" download> M'+res.id+'_'+(i+1)+'.'+res.media_urls[i]['mediaTypeNice']+'</a>, </span>';
				    		}
				    	}
				    	var cls = 'text-message sent clearfix';
				    	if(this.direction == 'in')
				    	var cls = 'text-message received clearfix';
				   		 $('<div/>', {
						    'class': cls,
						    'html': 
						        $('<div/>', {
						            'html': this.message+fajlovi,
						            'class': 'message-bubble'
						        })
						}).appendTo(dod);
					});
				   	$('#text-message-list').html(dod);
				    if(res.status=='success') {
				    	/*
				   		 */
				    } else {
				    	/*
				   		 $('<div/>', {
						    'class': 'text-message sent clearfix danger',
						    'html': 
						        $('<div/>', {
						            'text': smess+'<br/><b>Message Not Send!</b>',
						            'class': 'message-bubble'
						        })
						}).appendTo('#text-message-list');*/

				    }
				  })
				  .fail(function() {
				    console.log( "There was an error with the refresh!" );
				  })
				  .always(function() {
					/*textf.val('');
					textf.attr('disabled', false);
					$('#text-msg-form a').attr('disabled', false);*/
		$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
				  });
				 
				 
		return true;
	}
    $(document).ready(function () {
		$('.sendNewText').on('click',function(ev) {
			var textf = $('#text-msg-form textarea');
	 		send_sms(textf.attr('data-from'),textf.attr('data-to'),textf.val());
	 		ev.preventDefault();

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
	<div class="col-md-12">
	    <div class="well bg-grey">
	      <div id="step1" role="tabpanel" class="bwizard-activated" aria-hidden="false">
	        <fieldset>
	          <legend class="pull-left width-full">
	      		  <div class="col-md-5 row dropdownMain" style="text-align:left">
		      		  <select name="phoneSelection" id="phoneSelection" style="width:100%;max-width: 350px;border:1px solid #efefef;" onchange="javascript:window.location.href='<?php echo base_url(); ?>clientuser/view_messages/'+this.value;">
		      		  <option value=''>Select your Number</option>
		      		  <?php 
		      			foreach($phoneNumbers as $phoneNumber){
		      				echo "<option value=".$phoneNumber['phoneNumber']." ".($picked_num==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
		      			}
		      		  ?>
			        </select>
			      </div>
					<?php if( !empty($picked_num) ) { ?>
		      		  <div class="col-md-5 dropdownMain">
				  		 <input class="form-control cust_phone_no" name="blocked" placeholder="Send to Number" value="<?php echo (ct_format_nice_number($picked_who)!='+1' ? ct_format_nice_number($picked_who) : ''); ?>" id="msg_who_to_insert" data-parsley-required="true" type="text">

				  		</div>
		      		  <div class="col-md-2">
		      		  	<a class="btn btn-sm btn-success" onclick="javascript:window.location.href='<?php echo base_url();?>clientuser/view_messages/<?php echo $picked_num; ?>/'+$('#msg_who_to_insert').val();">Continue</a>
		      		  </div>
				      </div>
	   			 	<?php }else { ?>
	   			 		<h4 class="col-md-6 title text-white">No number chosen.</h4>
	   			 	<?php } // --/End-if ?>
	          </legend>
	        </fieldset>
	          
	      </div>
	    </div>
    </div>

	<?php if( !empty($picked_who) && !empty($picked_num) ) { ?>
	<div class="col-md-12 text-message-wrapper">
		<div class="text-message-window" id="text-message-list">
		<?php $i=1; foreach($sms_list as $sms) { ?>
			    <div class="text-message <?php echo ($sms->direction=='in' ? 'received' : 'sent'); ?> clearfix" title="On: <?php echo ct_format_sms_str($sms->date. ' '.$sms->time,$timezone) ?>" id="text-message-<?php echo $sms->id; ?>">
			        <div class="message-bubble">
						<?php echo $sms->message; ?>
						<?php if($sms->mms_num_files>0) :  ?>
							<?php 
								$ij=1;
							foreach($sms->media_urls as $k => $media) { ?>
							<br/><span class="mms-file"><i class="fa fa-file-<?php echo $media['mediaTypeGroup']; ?>-o"></i> <a href="<?php echo $media['mediaUrlShort'] ?>"  target="_blank" download> M<?php echo $sms->id; ?>_<?php echo $ij; ?>.<?php echo $media['mediaTypeNice']; ?></a></span>
							<?php } ?>
						<?php 
							$ij++;
						endif; ?>
					</div>
			    </div>
	    <?php $i++; } // --/End-foreach ?>
		</div>

    	<div class="form-group">
        	<div id="text-msg-form" data-files-attc="0">
    		<br/>
			  <label for="reply-<?php echo $sms->id; ?>-msg">Message:</label>
			  <textarea class="form-control" rows="2" id="text-msg-content" name="text-msg" data-from="<?php echo $picked_num; ?>" data-to="<?php echo $picked_who; ?>"></textarea>
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
		<div class="clearfix"></div>
		<?php if( empty($picked_num) ) { ?>
		<div class="col-md-12">
			<div class="alert alert-warning"><b>Important:</b> Choose one of your phone numbers!</div>
		</div>
		<?php } else  if( empty($picked_who) ) {?>
		<div class="col-md-12">
			<div class="alert alert-warning lead"><b>Important:</b> Choose the number to contact!</div>
		</div>
		<?php /*} else {?>
		<div class="col-md-12">
			<div class="alert alert-warning lead"><b>Important:</b> No Text Messages for this number found!</div>
		</div>
		<?php */} // ---/. ?>

	<?php } // ---/. END SMS LISTING ?>


</div>