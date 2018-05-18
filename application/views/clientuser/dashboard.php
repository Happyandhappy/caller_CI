<?php 

$currency       = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
$call_charge    = $this->db->get_where('settings', array('type' => 'call_charge'))->row()->description;
    
$phone_details = $this->db->get_where('client_payment_details', array('plan_name' => $this->session->userdata('login_user_id')))->result_array();
$tot_no_purch_amt = $this->db->select('sum(abs(`payment_gross_amount`)) as total_amt')->from('client_payment_details')->where("plan_name LIKE '%payment_against_number_purchase-%' and `client_id`=" . $this->session->userdata('login_user_id'))->get();

$number_purchase_amt = $tot_no_purch_amt->row();

if ($number_purchase_amt->total_amt > 0 || $number_purchase_amt->total_amt != NULL)
    $total_amt = $number_purchase_amt->total_amt;
else
    $total_amt = 0;

$this->db->select('cl.*,cl_ph.*');
$this->db->from('client cl');
$this->db->join('client_phonenumber_purchased cl_ph', 'cl_ph.client_id = cl.client_id ', 'left');
$this->db->where(array('cl.status'=>'active','cl.client_id' => $this->session->userdata('login_user_id')));
if( !empty($phone_number_purchased) ){
	$this->db->where(array('cl_ph.phoneNumber' => $phone_number_purchased ));
}

$query = $this->db->get();
$client_details = $clientdetails = $query->row();
				
$this->db->select('*');
$this->db->from('client_phonenumber_purchased');                    
$this->db->where(array('status'=>'active','client_id' => $this->session->userdata('login_user_id')));
$query = $this->db->get();
$phones = $query->result_array();
						
if ($userdata[0]['subaccount_created'] != 'y') {

    ?>

    <div class="row">
        <div class="panel panel-inverse" data-sortable-id="ui-general-2">
            <div class="panel-body highlight ">
                <div class="alert alert-danger fade in"> 
                    <p> You have Sucessfully Registered with our Web Portal , by fulfilling all payment
                        formalities.
                    </p>
                    <p> But still you need to confirm our <?php echo $site_title; ?>'s service.<br/>
                    </p>
                </div>
				<div class="col-md-6 col-sm-8 p-10">
					<a href="<?php echo base_url(); ?>base/createSubaccount/<?php echo $userdata[0]['client_id']; ?>" class="btn bg-orange-darker btn-block text-white">Click here to Confirm</a>
								</div>
            </div>
        </div>
    </div>
    <?php


}else{


	if ($userdata[0]['subaccount_status'] == 'active') {
		if( count( $phones )){
		?>
		<div class="row">
			<div class="panel panel-inverse" data-sortable-id="ui-general-2">
				<div class="panel-body highlight ">					 
					<div class="col-md-7 col-sm-12 lem-hdr">Select Phone Number(s) For Stats:</div>
					<div class="col-md-5 col-sm-12 dropdownMain" style="font-size:16px;">
					
						<select name="phoneSelection" id="phoneSelection" style="width:100%;max-width: 350px;border:1px solid #efefef;" onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/dashboard/'+this.value;">
						<?php 
						echo "<option value='' >Select All Numbers</option>";
						foreach($phones as $phoneNumber){
							echo "<option value=".$phoneNumber['phoneNumber']." ".($phone_number_purchased==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
						}
						?>
					  
						</select>
		  						
					</div>
				</div>
			</div>
		</div>

        <hr style="margin:3px;" />
        <div class="clearfix">  
          <h3 style="display:inline;float: left; margin-top:0;padding-top: 10px;">Select a date range.</h3> 
          <form 
          action="<?php echo base_url() . "clientuser/dashboard/". ( $phone_number_purchased ? $phone_number_purchased : '');?>">

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
        <hr style="margin:10px;" />
        <div class="row">
            <div class="col-md-12">
                <div class="graph-container">
                    <h4>Incoming Calls (<?php echo intval($graphs['call_in']['total']);?>) 
                    / Answered (<?php echo intval($graphs['call_out']['total']);?>)
                    <span class="pull-right"><b>Total:</b> In (<?php echo intval($total_calls_in); ?>) / Out (<?php echo intval($total_calls_out); ?>)</span></h4>
                    <div class="graph-box">
                        <div id="call-chart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="graph-container">
                    <h4>Call Minutes (<?php echo intval($graphs['call_minutes']['total']);?>)</h4>
                    <div class="graph-box">
                        <div id="minutes-chart" style="height: 180px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="graph-container">
                    <h4>Text Incoming (<?php echo intval($graphs['sms_in']['total']);?>) 
                    / Outgoing (<?php echo intval($graphs['sms_out']['total']);?>)
                    <span class="pull-right"><b>Total:</b> In (<?php echo intval($total_sms_received); ?>) / Out (<?php echo intval($total_sms_send); ?>)</span></h4>
                    <div class="graph-box">
                        <div id="sms-chart" style="height: 250px;"></div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="graph-container">
                    <h4>People Added To Your Facebook Custom Audience  (<?php echo intval($graphs['sms_in']['total']);?>)</h4> 
                    <div class="graph-box">
                        <div id="fb-chart" style="height: 250px;"></div>
                    </div>
                </div>

            </div>

        <script type="text/javascript">
          $(document).ready(function(){
            $('.bdatepicker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'left bottom'
            });
          });

            window.onload = function () {
                /* sms area */
                 new Morris.Area({
                      // ID of the element in which to draw the chart.
                      element: 'sms-chart',
                      // Chart data records -- each entry in this array corresponds to a point on
                      // the chart.
                      data: [
                      <?php $brojdana = $lem_brDana; for($i=0;$i <= $brojdana;$i=$i+ $lem_brInk) {
                        $date = date("Y-m-d",strtotime("-".$i." Days"));
                        ?>{year: '<?php echo date("Y-m-d",strtotime("-".$i." Days")) ?>',a: <?php echo intval($graphs['sms_in'][$date]); ?>,b: <?php echo intval($graphs['sms_out'][$date]); ?>, },
                            <?php } ?>
                      ],
                      xkey: 'year',
                      ykeys: ['a', 'b'],
                      ymin: 0,
                      labels: ['SMS Received', 'SMS Sent'],
                      fillOpacity: 0.6,
                      hideHover: 'auto',
                      behaveLikeLine: true,
                      resize: true,
                      pointFillColors:['#ffffff'],
                      pointStrokeColors: ['black'],

                      lineColors:['blue','cyan'],
                      xLabelFormat: function(x) {
                        console.log(x);
                        return x.getDate() + " " + getMonthName(x.getMonth()).toString();
                      },
                });

                 /* call area */
                 new Morris.Area({
                      // ID of the element in which to draw the chart.
                      element: 'call-chart',
                      // Chart data records -- each entry in this array corresponds to a point on
                      // the chart.
                      data: [
                      <?php $brojdana = $lem_brDana; for($i=0;$i <= $brojdana;$i=$i+ $lem_brInk) {
                        $date = date("Y-m-d",strtotime("-".$i." Days"));
                        ?>{year: '<?php echo $date ?>',a: <?php echo intval($graphs['call_in'][$date]); ?>,b: <?php echo intval($graphs['call_out'][$date]); ?>,},
                            <?php } ?>
                      ],
                      xkey: 'year',
                      ykeys: ['a', 'b'],
                      ymin: 0,
                      labels: ['Incoming Calls', 'Answered Calls'],
                      fillOpacity: 0.6,
                      hideHover: 'auto',
                      behaveLikeLine: true,
                      resize: true,
                      pointFillColors:['#ffffff'],
                      pointStrokeColors: ['black'],
                      lineColors:['red','orange'],
                      xLabelFormat: function(x) {
                        console.log(x);
                        return x.getDate() + " " + getMonthName(x.getMonth()).toString();
                      },
                });
                 /* call area */
                 new Morris.Area({
                      // ID of the element in which to draw the chart.
                      element: 'minutes-chart',
                      // Chart data records -- each entry in this array corresponds to a point on
                      // the chart.
                      data: [
                      <?php $brojdana = $lem_brDana; for($i=0;$i <= $brojdana;$i=$i+ $lem_brInk) { 
                        $date = date("Y-m-d",strtotime("-".$i." Days"));
                        ?>{year: '<?php echo $date ?>',a: <?php echo intval($graphs['call_minutes'][$date]); ?>},
                            <?php } ?>],
                      xkey: 'year',
                      ykeys: ['a'],
                      ymin: 0,
                      labels: ['Minutes'],
                      fillOpacity: 0.6,
                      hideHover: 'auto',
                      behaveLikeLine: true,
                      resize: true,
                      pointFillColors:['#ffffff'],
                      pointStrokeColors: ['black'],
                      lineColors:['green'],
                      xLabelFormat: function(x) {
                        console.log(x);
                        return x.getDate() + " " + getMonthName(x.getMonth()).toString();
                      },
                });

                new Morris.Area({
                    element : "fb-chart",

                    data: [
                        <?php
                            $brojdana = $lem_brDana;
                            for ($i = 0 ; $i <= $brojdana ; $i = $i + $lem_brInk){
                                $date = date("Y-m-d", strtotime("-".$i." Days"));
                        ?>{
                            year: '<?php echo $date ?>', a: 10},
                    <?php } ?>
                        
                        // {year:2018, a:10}
                        
                    ],
                    xkey: 'year',
                    ykeys: ['a'],
                    ymin: 0,
                    labels: ['Count'] ,
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    behaveLikeLine: true,
                      resize: true,
                      pointFillColors:['#ffffff'],
                      pointStrokeColors: ['black'],
                      lineColors:['blue'],
                      xLabelFormat: function(x) {
                        console.log(x);
                        return x.getDate() + " " + getMonthName(x.getMonth()).toString();
                    },
                });
            }
        </script>
		<?php
		}
		else{
			?>
			<div class="row">
				<div class="panel panel-inverse" data-sortable-id="ui-general-2">
					<div class="panel-body highlight ">
						<div class="alert alert-sucess fade in text-white">
							<div class="col-md-12 col-sm-12 p-10">
								<p class="lead text-white">You Have Successfully Registered!</p>
								<p class="text-white" style="font-size:16px;">To set up your <?php echo str_replace(array('LLC', 'llc', ','), '', $site_settings['system_name']); ?> account, you need to first select a phone number.</p>
								<a href="<?php echo base_url()?>clientuser/manage_numbers"
								   class="btn bg-orange btn-block col-md-5 text-white">Click Here To Select Your Caller Technologies Phone Number(s)</a>
							</div>							
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	} 
}
?>