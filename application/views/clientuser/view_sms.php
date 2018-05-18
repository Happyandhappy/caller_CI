

<script type="text/javascript">
var sms_reply = function(smsid) {
		var msgcnt = $('#rpfrm-'+smsid+' textarea').val().length;
	if(msgcnt>0) {
		$('#rpfrm-'+smsid).submit();
		$('#rpfrm-'+smsid+' textarea').attr('disabled', true);
		$('#rpfrm-'+smsid+' a').attr('disabled', true);
	} else {
		alert("1 Character Minimum");
	}
	return true;
}
	
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
					<?php if( !empty($picked_num) ) { ?>
	          			<h4 class="col-md-6 title text-white">SMS Log for : <?php echo $picked_num_nice?></h4>
	   			 	<?php }else { ?>
	   			 		<h4 class="col-md-6 title text-white">No number chosen.</h4>
	   			 	<?php } // --/End-if ?>
	      		  <div class="col-md-6 row dropdownMain">
	      		  <select name="phoneSelection" id="phoneSelection" style="width:100%;max-width: 350px;border:1px solid #efefef;" onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/view_sms/'+this.value+'/<?php echo $picked_dir; ?>';">
	      		  <option>Select a Number</option>
	      		  <?php 
	      			foreach($phoneNumbers as $phoneNumber){
	      				echo "<option value=".$phoneNumber['phoneNumber']." ".($picked_num==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
	      			}
	      		  ?>
			  
			        </select>
			       </div>
	          </legend>
	        </fieldset>
	          
	      </div>
	    </div>
    </div>

	<?php if( !empty($sms_list) ) { ?>
	<div class="col-md-12">
		<ul class="nav nav-pills">
		  <li class="<?php echo $picked_dir == 'in' ? 'active' : ''; ?>"><a href="<?php echo base_url();?>clientuser/view_sms/<?php echo $picked_num; ?>/in">Incoming</a></li>
		  <li class="<?php echo $picked_dir == 'out' ? 'active' : ''; ?>"><a href="<?php echo base_url();?>clientuser/view_sms/<?php echo $picked_num; ?>/out">Outgoing</a></li>
		</ul>
	</div>
	<div class="col-md-12">
		<div class="panel-group" id="smsaccordion">
		<?php $i=1; foreach($sms_list as $sms) { ?>
			    <div class="panel panel-default <?php echo ($i==1 &&  isset($_GET['latest'])) ? 'panel-primary': ''; ?> sms_box">
			      <div class="panel-heading">
			        <h4 class="panel-title">
			          <a data-toggle="collapse" data-parent="#smsaccordion" href="#smsbox-<?php echo $sms->id; ?>">
			          	<i class="sms-time"><?php echo ct_format_nice_time(strtotime($sms->date . ' ' . $sms->time),$timezone); ?></i>
			          	<span class="sender_num"><?php echo $picked_dir=='out' ? $sms->to : $sms->from; ?>	</span>
			          	<!--<b class="pull pull-right">SMSID #<?php echo $sms->id; ?></b>-->
			          </a>
			        </h4>
			      </div>
			      <div id="smsbox-<?php echo $sms->id; ?>" class="panel-collapse collapse <?php echo ($i==1 &&  isset($_GET['latest'])) ? 'in': ''; ?>">
			        <div class="panel-body">
						<?php echo $sms->message; ?>
					</div>
					<?php if( $picked_dir == 'in' ) { ?>
				        <div class="panel-footer">
				        	<div class="form-group">
					        	<form method="post" id="rpfrm-<?php echo $sms->id; ?>" action="<?php echo base_url();?>base/send_sms">
					        	<input type="hidden" name="from" value="<?php echo $picked_num; ?>">
					        	<input type="hidden" name="to" value="<?php echo $pick_who!='to' ? $sms->to : $sms->from_clean; ?>">
								  <label for="reply-<?php echo $sms->id; ?>-msg">Reply via SMS:</label>
								  <textarea class="form-control" rows="2" id="reply-<?php echo $sms->id; ?>-msg" name="msg"></textarea>
								  <div class="submit-btn-wrap">
								  	<a class="btn btn-primary" href="javascript:sms_reply('<?php echo $sms->id; ?>')">Send SMS!</a>
								  </div>
							  	</form>
							</div>
				        </div>
	   			 	<?php } // --/End-if ?>
			      </div>
			    </div>
	    <?php $i++; } // --/End-foreach ?>
		</div>
	</div>
	<div class="col-md-12" id="content_pagination">
		<?php echo $content_pagination; ?>
	</div>
	<div class="clearfix"></div>

	<?php } else {// -/ Empty SMS LISTING  ?>
		<div class="clearfix"></div>
		<?php if( empty($picked_num) ) { ?>
		<div class="col-md-12">
			<div class="alert alert-warning"><b>Important:</b> Choose a number from above to populate this page!</div>
		</div>
		<?php } else {?>
		<div class="col-md-12">
			<div class="alert alert-warning lead"><b>Important:</b> No SMS for this number found!</div>
		</div>
		<?php } // ---/. ?>

	<?php } // ---/. END SMS LISTING ?>


</div>