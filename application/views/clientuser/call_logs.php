<style>
/ * @media screen and (max-width:767px){
.modal.in .modal-dialog {
  height: 212px;
  margin-top: -111px !important;
  top: 50%  !important;
 }
} */
</style>
<script>
  $(document).ready(function(){
    $('.bdatepicker').datepicker({
        format: 'yyyy-mm-dd',
        orientation: 'left bottom'
    });
  });
$(document).ready(function(){
    $(document).on('click',".sendMail",function(){
		/*var from= $(this).data('from');
		var to= $(this).data('to');*/
		var transid = $(this).attr('data-trnsid');
    var caller = $(this).attr('data-from');
    var receiver = $(this).attr('data-to');
    $('.callog-wrap').addClass('sleep');
		
		var basepath='<?php echo base_url("/base/get_transcript"); ?>';
		 $.ajax({
				  method: 'POST',
				  url: basepath,
				  data: { 
			        'transid':transid,
              'caller':caller,
              'receiver':receiver,
              'ajax_req':true
			},success: function(data) { 
			    if(data==1){
					// window.alert('Transcription mail has been sent successfully');
					$("#successs").html("");
					$("#successs").html("<div class='alert alert-success' style='color:#000;'>Your call is being transcribed and will be emailed to you shortly.</div>");
					$("#myModall").modal('show');
					 
				 }else{
					  window.alert('Something goes wrong');
				 }
        $('.callog-wrap').removeClass('sleep');
			}
		 });
    });
	
	$(document).on('keyup change','.dataTables_filter .input-sm',function(){
		var value = $(this).val().trim();
		if(value != ''){
			$('#data-table tr').hide();
			$('#data-table tr:contains("'+value+'")').show();
		}
		else{
			$('#data-table tr').show();
		}	
	});
		
});
</script>

<div class="profile-section">

<!-- begin row -->

<div class="row">

  
  <!-- begin col-4 -->
  
 <?php if(isset($system_error)){?>
  <div class="well bg-red-lighter">
  <?php echo $system_error;?>
  </div>
  <?php }?>
<div class="callog-wrap">
  <div class="col-md-12">
    <div class="well bg-grey">
      <div id="step1" role="tabpanel" class="bwizard-activated" aria-hidden="false">
        <fieldset>
          <legend class="pull-left width-full">
          <h4 class="col-md-6 title text-white">Call Logs for : <?php echo ($phone_number_picked ? $phone_number_picked_nice : 'All');//$phone_number_purchased?></h4>
      		  <div class="col-md-6 row dropdownMain">
      		  <select name="phoneSelection" id="phoneSelection" style="width:100%;max-width: 350px;border:1px solid #efefef;" onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/get_call_log/'+this.value;">
      		  <?php 
            echo "<option value='' >All</option>";
      			foreach($phoneNumbers as $phoneNumber){
      				echo "<option value=".$phoneNumber['phoneNumber']." ".($phone_number_picked==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' - '.$phoneNumber['campaign_name']."</option>";
      			}
      		  ?>
		  
		        </select>
		       </div>
          </legend>
        </fieldset>
          
      </div>
    </div>
  
        <hr style="margin:3px;" />
        <div class="clearfix">  
          <h3 style="display:inline;float: left; margin-top:0;padding-top: 10px;">Select a date range.</h3> 
          <form 
          action="<?php echo base_url() . "clientuser/get_call_log/". ( $phone_number_picked ? $phone_number_picked : '');?>" method="GET">

          <div class="form-group pull-right" style="padding-top: 10px;">
              <div class="input-group">
               
                <span style="padding:0 15px;">to</span>  <input type="text" class="lem-date-filter bdatepicker" name="filt_to" value="<?php echo $lem_filt_to;?>" /> <input type="submit" value="Filter" class="btn btn-sm btn-orange" style="padding: 2px 10px;border-radius: 0;margin: 0 5px;" />
              </div>
          </div>
          <div class="form-group pull-right" style="padding-top: 10px;">
              <div class="input-group">
                <input type="text" class="lem-date-filter bdatepicker" name="filt_from" value="<?php echo $lem_filt_from;?>" />
              </div>
          </div>
          </form>
        </div>
    <!-- begin scrollbar -->
    
  <div data-scrollbar="true" data-height="750px" class="bg-silver"> 
      <!--   begin table -->
        <table id="data-table" class="table table-striped table-bordered nowrap">
        <thead class="bg-silver-lighter">
          <tr>
            <th></th>
            <th><?php echo get_phrase('from');?></th>
            <th><?php echo get_phrase('to');?></th>
            <th width="20px"><?php echo get_phrase('dur.');?></th>
            <th style="width:300px"><?php echo get_phrase('start_Time');?> - <?php echo get_phrase('end_Time');?> </th>
            
            <!--<th><?php //echo get_phrase('Price')?></th>-->
            
            <!--<th>status</th>-->
            <th>Recording</th>
            <!-- <th>Download</th> -->
           
          </tr>
        </thead>
        <tbody>
          <?php // Loop over the list of calls and echo a property for each one 



									//echo 'HERE';print_r($calls_read);exit;
			
			?>
          <?php if(count($calls_read) >= 1){

			for($j=0; $j<count($calls_read['duration']);$j++){
				$data = $calls_read['from'][$j];

				if(preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $data,  $matches ) )
				{
					$result = '('.$matches[1].')'. ' '.$matches[2] . '-' . $matches[3];
				}
				if(preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $calls_read['to'][$j],  $toCall ) )
				{
					$resultCall = '('.$toCall[1].')'. ' '.$toCall[2] . '-' . $toCall[3];
				}		
		 ?>
          <tr>
            <td class="p-r-5"><?php echo $j+1;?></td>
            <td style="width:15%">
            <b><?php echo ( !empty($calls_read['name'][$j]) ? '<a href="'.site_url('clientuser/number_lookup/'.$calls_read['advanced_number'][$j]).'">'.$calls_read['name'][$j].'</a>' : 'unknown');?></b>
            <br/><?php echo $result;?></td>
            <td style="width:15%"><?php echo $resultCall;?></td>
            <td ><?php echo $calls_read['duration'][$j];?><small> sec.</small></td>
            <td style="width:300px">
              <?php 
                $prevd = explode("-", $calls_read['startTime'][$j]);
                $prevdtmp = $prevd[0];
                $prevd[0] = $prevd[1];
                $prevd[1] = $prevdtmp;
                $datm = implode("-",$prevd);
              ?>
              <?php 
                $prevd = explode("-", $calls_read['endTime'][$j]);
                $prevdtmp = $prevd[0];
                $prevd[0] = $prevd[1];
                $prevd[1] = $prevdtmp;
                $datm = implode("-",$prevd);
              ?>
              <small><?php  echo  ct_format_nice_str($datm,$timezone);?>
              </small>
            - <small><?php  echo  ct_format_date("h:i:sa",$datm,$timezone);?></small></td>
   
            <td id="tdbt"><?php echo ($calls_read["mp3_url"][$j]) ? '<a class="btn btn-sm btn-success play-recording"  data-sid="'.$calls_read['sid'][$j].'"  href="#"><i class="stateicon-'.$calls_read['sid'][$j].' fa fa-play"></i></a>' : 'No recording';?>
             <?php echo ($calls_read['mp3_url'][$j]) ? '<a class="btn btn-sm btn-success" href="'.$calls_read['mp3_url'][$j].'" download><i class="fa fa-download"></i></a>' : '';
                $btn_disabled = !$calls_read['has_transcriptions'][$j]? 'disabled':'';
                ?>
             <?php echo ($calls_read['mp3_url'][$j]) ? "<a data-from='{$calls_read['from'][$j]}' 
                data-to='{$calls_read['to'][$j]}' data-trnsid='{$calls_read['request_sid'][$j]}' 
                 class=\"btn btn-sm btn-success sendMail  {$btn_disabled}\"   ><i class=\"fa fa-send\"></i></a>   " : '';?>
                 
             </td>

           
          </tr>
          <?php }
		  }else{?>
          <tr>
            <td class="p-r-5" colspan="9">No Data selected.</td>
          </tr>
          <?php }?>
        </tbody>
      </table>
      <style>
          #tdbt {min-width:120px;}
          /*#btsnd {opacity:.4;cursor:no-drop;}*/
      </style>
      <!-- end table -->
      
    </div> 
    
    <!-- end scrollbar --> 
    
  </div>
  <div class="clearfix"></div>
</div>
  <!-- end col-4 --> 
  
</div>
 <!-- Modal -->
  <div class="modal fade" id="myModall" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transcription</h4>
        </div>
        <div class="modal-body">
          <div id="successs"> </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

 <?php if(count($calls_read) >= 1){
  for($j=0; $j<count($calls_read['duration']);$j++){ ?>
    <?php if ($calls_read['mp3_url'][$j]) { ?>
      <audio id='<?php echo $calls_read['sid'][$j]; ?>' src="<?php echo $calls_read['mp3_url'][$j] ?>" ></audio>


<?php } ?>
<?php }
} ?>
