<?php 
$currency = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
$incoming = $this->db->get_where('settings', array('type' => 'call_charge'))->row()->description;
$advanced = $this->db->get_where('settings', array('type' => 'lookup_call_charge'))->row()->description;
?>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-grey">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-x fa-user"></i></div>
			            <div class="stats-title">No of Users</div>
			            <div class="stats-number"><?php echo count($this->crud_model->get_records('client'))?></div>
			            <div class="stats-progress progress"><div class="progress-bar" style="width: 100%;"></div></div>
                        <a href="<?php echo base_url();?>apanel/user_list"><div class="stats-desc">View Details</div></a>
			        </div>
			    </div>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-phone fa-fw"></i></div>
			            <div class="stats-title">Incoming Calls</div>
			            <div class="stats-number">
						<?php $this->db->where('Direction','inbound');
						$this->db->join('incoming_call_details','incoming_call_details.AccountSid=client.subaccount_sid');
						   $incoming_calls = $this->db->get('client')->result_array();
							echo count($incoming_calls);
						  ?>
						</div>
			            <div class="stats-progress progress"><div class="progress-bar" style="width: 100%;"></div></div>
                        <a href="<?php echo base_url();?>apanel/calls_list"><div class="stats-desc">View Details</div></a>
			        </div>
			    </div>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-phone fa-fw"></i></div>
			            <div class="stats-title">Advanced Demographics Lookups</div>
			            <div class="stats-number"><?php 
						$this->db->where('advanced_caller_details.status !=','failed');
						   $advance_calls = $this->db->get('advanced_caller_details')->result_array();
						   echo (count($advance_calls));
						   ?></div>
			            <div class="stats-progress progress"><div class="progress-bar" style="width: 100%;"></div></div>
                        <a href="<?php echo base_url();?>apanel/advanced_details"><div class="stats-desc">View Details</div></a>
			        </div>
			    </div>
			    <!-- end col-3 -->
			</div>
			<!-- end row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-blue">
					<div class="stats-icon stats-icon-lg"><i class="fa fa-phone fa-fw"></i></div>			            <div>
						<!--  Display the current count of phone numbers used and Available max count of phone numbers  -->
							<div class="stats-title">Total Numbers Acquired Out Of Max</div>
							<div class="stats-number"> 
								<?php 
								    // get count of active phone numbers from client_phonenumber_purchaased table
									$this->db->from('client_phonenumber_purchased');
									$this->db->where('status','active');
									$query = $this->db->get();
									$active_count = $query->num_rows(); 
									// get max count of phone numbers from packages and client_payment_details table
									$query = $this->db->get('client')->result_array();									
									$max_count = 0;
									foreach ($query as $row){
	
										$this->db->join('client_payment_details', 'client_payment_details.client_id='.$row['client_id']);
										$this->db->where('packages.package_id = client_payment_details.plan_id');
										$test1 = $this->db->get('packages')->result_array();
										foreach ($test1 as $unit){
											$max_count += $unit['max_phone_numbers'];
										}
									}
									// display them
									echo $active_count . " / " . $max_count;
								?>
							</div>
						</div>
			        </div>
			    </div>
				<!-- end col-3 -->

				<!-- begin col-3 -->
				<div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg">
							<i class="fa fa-comments fa-fw"></i>
						</div>
			            <div>
						<!-- Display The cont of SMS -->
							<div class="stats-title">Total SMS Sent / Received</div>
							<div class="stats-number"> 
								<?php 
									$this->db->from('ct_messages');
									$this->db->where('direction','out');
									$incoming_sms = $this->db->get()->num_rows();
									$this->db->from('ct_messages');
									$this->db->where('direction', 'in');
									$outgoing_sms = $this->db->get()->num_rows();
									echo $incoming_sms." / ".$outgoing_sms; ?>
							</div>
						</div>
			        </div>
			    </div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg">
							<!-- <i class="fa fa-comments fa-fw"></i> -->
						</div>
			            <div>
						<!-- Display The cont of SMS -->
							<!-- <div class="stats-title">Total SMS Sent / Received</div> -->
							<div class="stats-number"> 
								<div style="height:57px;"></div>
							</div>
						</div>
			        </div>
			    </div>
				<!-- end col-3 -->
			</div>
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-3 -->
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg">
							<i class="fa fa-money fa-fw"></i>
						</div>
			            <div class="stats-title">Monthly Gross</div>
			            <div class="stats-number">
							 $<?php 

							$this->db->select('SUM(subscription_amt) AS amount');
							$amt = $this->db->get('client')->result_array();
							$total_amount = $amt[0]['amount'];

							$this->db->select('SUM(payment_gross_amount) AS amt')->where('payment_gross_amount >=','0')->where('(payment_date LIKE "'.date("Y-m-").'%")');
							$package = $this->db->get('client_payment_details')->result_array();
							$mnt_gross = ($package[0]['amt']);
							echo round($mnt_gross,2) ?> 
						</div>
			        </div>
			    </div>
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-red">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			            <div class="stats-title">Monthly Costs</div>
			            <div class="stats-number">$<?php $lookup = $this->db->get_where('settings' , array('type' =>'lookup_call_charge'))->row()->description;
						$this->db->where('advanced_caller_details.status !=','failed');
						$this->db->where('client_phonenumber_purchased.status','active');
						$this->db->join('client_phonenumber_purchased','client_phonenumber_purchased.phoneNumber=advanced_caller_details.to_call');
						   $advcall = $this->db->get('advanced_caller_details')->result_array();
						   $advance_amount = (($lookup)*(count($advcall)));
						echo round(($cost_sum+$month_paypal),2);
						?>
							
						</div>
			        </div>
			    </div>
			    <!-- end col-3 --> 
			    <!-- end col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-green">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			            <div class="stats-title">Monthly Net Profit</div>
			            <div class="stats-number">
							$<?php 

							$this->db->select('SUM(subscription_amt) AS amount');
							$amt = $this->db->get('client')->result_array();

							$total_amount = $amt[0]['amount'];
							echo round(($mnt_gross-$cost_sum-$month_paypal),2); ?>
						</div>
			        </div>
			    </div>
			</div>
			<!-- end row -->
			<div class="row">
			    <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-purple">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			            <div class="stats-title">Total Gross</div>
			            <div class="stats-number"> 
							$<?php 
							$this->db->select('SUM(payment_gross_amount) AS amt')->where('payment_gross_amount >=','0');
							$package = $this->db->get('client_payment_details')->result_array();
							echo round($package[0]['amt'],2);

							?>
						</div>
			        </div>
			    </div>
			    <!-- begin col-3 -->
			    <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-red">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-x fa-money"></i></div>
			            <div class="stats-title">Total Costs</div>
			            <div class="stats-number">
						$<?php 					
							$amount = $this->db->select('sum(abs(`payment_gross_amount`)) as total_amt')->from('client_payment_details')->where("plan_name = 'payment_against_number_purchase'")->get();
							$amt = $amount->row();
							$purchase_amount =  $amount->row();
							echo round(($cost_total_sum + $total_paypal),2);
							?>
						</div>
			        </div>
			    </div>
                <!-- begin col-3 -->
                <div class="col-md-4 col-sm-6">
			        <div class="widget widget-stats bg-green">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
			            <div class="stats-title">Total Net Profit</div>
			            <div class="stats-number"> 
							$<?php 
							$this->db->select('SUM(payment_gross_amount) AS amt')->where('payment_gross_amount >=','0');
							$package = $this->db->get('client_payment_details')->result_array();
							echo round(($package[0]['amt']-$cost_total_sum-$total_paypal),2);

							?>
						</div>
			        </div>
			    </div>
                 <!-- end col-3 -->
			</div>
<?php 	$this->db->order_by('client_payment_details.subcription_id','desc');
		$this->db->group_by('client_payment_details.client_id');
		$this->db->limit(5,0);	
		$this->db->join('client_payment_details','client_payment_details.client_id=client.client_id');	
		$top_users = $this->db->get('client')->result_array();		//print_r($top_users);?>

						<div class="col-md-12 p-t-25 bg-silver">
						  <h4 class="title">User Payments Completed <small>(Last 5 Payments)</small></h4>
							<div class="table-responsive">
							    <table class="table table-bordered">
									<thead>
									  <tr>
										<th>Sr/No.</th>
										<th>User name</th>
										<th>Email</th>
										<th>Amount</th>
									  </tr>
									</thead>
									<tbody>
									  <?php $counter=1;	
									  foreach($top_users as $res){ ?>
									  <tr>
										<td class="col-md-1 p-r-5"><?php echo $counter;?></td>
										<td><?php echo ucfirst($res['name']).' '.ucfirst($res['lname']);?></td>
										<td><?php echo $res['email'];?></td>
										<td><?php echo $res['payment_gross_amount'].' '.$currency;?></td>
									  </tr>
									  <?php $counter++; } ?>
									</tbody>
								</table>
							</div>
						</div>	
							
</div>


		<?php $this->db->select('client_payment_details.payment_date,sum(payment_gross_amount) as amt');
			 $this->db->where('plan_name','Subscriptions'); 
			 $this->db->order_by('payment_date','asc'); 
			 $this->db->group_by('Month(payment_date)'); 
			$test =  $this->db->get('client_payment_details')->result_array();
			//print_r($test);
			$other_amount = ($total_amount -($incoming_amount + $advance_amount + $purchase_amount->total_amt));
			
				$this->db->select('client_payment_details.payment_date,sum(payment_gross_amount) as amount');
				$this->db->where('plan_name','Subscriptions'); 
				$this->db->order_by('payment_date','asc'); 
				$this->db->group_by('Day(payment_date)'); 
				$this->db->where('Month(payment_date)', date('m') );            
				$current_income =  $this->db->get('client_payment_details')->result_array();

			//print_r($current_income); 
		?>
		<div class="row">
			    <div class="col-md-12">
			        <div class="widget-chart with-sidebar bg-black">
			            <div class="widget-chart-content">
			                <h4 class="chart-title">
			                    Subscription Amount In <?php echo $currency;?>
			                </h4>
			                <div id="visitors-line-chart" style="height: 260px;"></div>
			            </div>
			            <div class="widget-chart-sidebar bg-black-darker">
						<?php 
						//$this->db->select('client_payment_details.payment_date,SUM(payment_gross_amount) as amt');
							?>
			                <h4 class="chart-title">
			                    Client Users
			                </h4>
			                <div id="visitors-donut-chart" style="height: 160px"></div>
							<?php 
							$active = $this->crud_model->get_records('client','',array('status'=>'1'),'');
							$inactive = $this->crud_model->get_records('client','',array('status'=>'2'),'');
							
							?>
							
			                <ul class="chart-legend">
			                    <li><i class="fa fa-circle-o fa-fw text-success m-r-5"></i> <?php echo count($active);?>  <span>Active Clients</span></li>
			                    <li><i class="fa fa-circle-o fa-fw text-primary m-r-5"></i> <?php echo count($inactive);?> <span>Inactive Clients</span></li>
			                </ul>
			            </div>
			        </div>
			    </div>
			</div>
			<!-- end row -->
		    <!-- begin row -->
		    <?php if( !empty($current_income) ) { ?>
		    <div class="row">
		        <div class="col-md-12">
					<div class="widget-chart with-sidebar bg-black">
			            <div class="widget-chart-content" style="width:100%">
			                <h4 class="chart-title">
			                    Current Month Subscription Amount In <?php echo $currency;?>
			                </h4>
			                <div id="visitors-line-chart1" style="height: 342px;"></div>
			            </div>
			        </div>
			    
		        </div>
		    </div>
		    <?php } //---ENDIF ?>

		    <!-- end row -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-8 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
			        <div class="panel panel-inverse" data-sortable-id="index-4">
			            <div class="panel-heading">
			                <h4 class="panel-title">New Registered Users </h4>
			            </div>
                        <ul class="registered-users-list clearfix">
						<?php $this->db->order_by('client_id','desc');
							  $this->db->limit(16,0);
						      $user = $this->db->get('client')->result_array();
						foreach($user as $res) { ?>
                            <li>
                                <a href="javascript:;">
								<?php 
								if ($res['profile_image']!='')	
								{ ?>
									<img style="height:100px;" src="<?php echo base_url()?>uploads/client_image/<?php echo $res['profile_image']?>" alt="" />
								<?php }
								else 
								{ ?>
									<img style="height:100px;" src="<?php echo base_url()?>uploads/client_image/clientimg.jpg" alt="" />
								<?php } ?>

								</a>
								
                                <h4 class="username text-ellipsis">
                                    <?php echo ucfirst($res['name']).' '.ucfirst($res['lname'])?>
                                    <small><u><?php if(empty($res['email'])) { echo '-'; } else { echo $res['email']; }?></u></small>
                                    <small><?php if(empty($res['company_name'])) { echo '-'; } else { echo $res['company_name']; }?></small>
                                </h4>
                            </li>
						<?php } ?>
                        </ul>
			        </div>
			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			</div>
			<!-- end row -->
<?php
?>
<script type="text/javascript">
    var green = '#0D888B';
    var greenLight = '#00ACAC';
    var blue = '#3273B1';
    var blueLight = '#348FE2';
    var blackTransparent = 'rgba(0,0,0,0.6)';
    var whiteTransparent = 'rgba(255,255,255,0.4)';
	var purple = '#727cb6';
var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	window.onload = function () {
		Morris.Line({
	        element: 'visitors-line-chart',
	        data: [
			
			<?php foreach($test as $res){ ?>
	           {x: '<?php echo date('Y-m',strtotime($res['payment_date']));?>', y: <?php echo $res['amt'];?> },
			<?php } ?>
	        ],
	        xkey: 'x',
	        ykeys: ['y'],
	        xLabelFormat: function(x) {
	            x = getMonthName(x.getMonth());
	            return x.toString();
	        },
	        labels: ['Amount'],
	        lineColors: [green, blue],
	        pointFillColors: [greenLight, blueLight],
	        lineWidth: '2px',
	        pointStrokeColors: [blackTransparent, blackTransparent],
	        resize: true,
	        gridTextFamily: 'Open Sans',
	        gridTextColor: whiteTransparent,
	        gridTextWeight: 'normal',
	        gridTextSize: '11px',
	        gridLineColor: 'rgba(0,0,0,0.5)',
	        hideHover: 'auto',
	    });

	<?php if( !empty($current_income) ): ?>
		Morris.Line({
	        element: 'visitors-line-chart1',
	        data: [
			
			<?php foreach($current_income as $inc){ ?>
	           {x: '<?php echo date('Y-m-d',strtotime($inc['payment_date']));?>', y: <?php echo $inc['amount'];?> },
			<?php } ?>
	        ],
	        xkey: 'x',
	        ykeys: ['y'],
	        xLabelFormat: function(x) {
	        	console.log(x);
	            return x.getDate() + " " + getMonthName(x.getMonth()).toString();
	        },
	        labels: ['Amount'],
	        lineColors: [green, blue],
	        pointFillColors: [greenLight, blueLight],
	        lineWidth: '2px',
	        pointStrokeColors: [blackTransparent, blackTransparent],
	        resize: true,
	        gridTextFamily: 'Open Sans',
	        gridTextColor: whiteTransparent,
	        gridTextWeight: 'normal',
	        gridTextSize: '11px',
	        gridLineColor: 'rgba(0,0,0,0.9)',
	        hideHover: 'auto',
	    });
	<?php endif; ?>
		
	    var green1 = '#00acac';

	    var blue1 = '#348fe2';
		
	    Morris.Donut({

	        element: 'visitors-donut-chart',

	        data: [

	            {label: "Active Clients", value: <?php echo count($active);?>},
	            {label: "Inactive Clients", value: <?php echo count($inactive);?>}

	        ],

	        colors: [green1, blue1],

	        labelFamily: 'Open Sans',

	        labelColor: 'rgba(255,255,255,0.4)',

	        labelTextSize: '12px',

	        backgroundColor: '#242a30'

	    });
			
		if ($('#donut-chart').length !== 0) {
			alert(<?php echo $incoming_amount?>);
			alert(<?php echo $advance_amount?>);
			alert(<?php echo $purchase_amount->total_amt?>);
			alert(<?php echo $other_amount?>);
	        var donutData = [
				{ label: "Incoming Calls",  data: <?php if(empty($incoming_amount)){ echo '0.00';} else { echo $incoming_amount; } ?>, color: purpleDark},
				{ label: "Advance Lookup",  data: <?php if(empty($advance_amount)){ echo '0.00';} else { echo $advance_amount; } ?>, color: purple},
				{ label: "Purchased Number",  data: <?php if(empty($purchase_amount->total_amt)){ echo '0.00';} else { echo$purchase_amount->total_amt; } ?>, color: purpleLight},
				{ label: "Fund in Clients Account",  data: <?php if(empty($other_amount)){ echo '0.00';} else { echo $other_amount; }?>, color: blue}];
			$.plot('#donut-chart', donutData, {
				series: {
					pie: {
						innerRadius: 0.5,
						show: true,
						label: {
							show: true
						}
					}
				},
				legend: {
					show: true
				}
			});
	    }
		"use strict";
	    function showTooltip(x, y, contents) {
	        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
	            top: y - 45,
	            left: x - 55
	        }).appendTo("body").fadeIn(200);
	    }
		if ($('#interactive-chart').length !== 0) {
	        var d1 = [
			<?php foreach($current_income as $inc){ ?>
			[<?php echo date('d',strtotime($inc['payment_date'])) ?>, <?php echo $inc['payment_gross_amount'] ?>],
			<?php } ?>
			];
	        
	        $.plot($("#interactive-chart"), [
	                {
	                    data: d1, 
	                    label: "Subscription Amount", 
	                    color: purple,
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: false, radius: 5, fillColor: '#fff' },
	                    shadowSize: 0
	                }
	            ], 
	            {
	                xaxis: {  tickColor: '#ddd',tickSize: 2 },
	                yaxis: {  tickColor: '#ddd', tickSize: 20 },
	                grid: { 
	                    hoverable: true, 
	                    clickable: true,
	                    tickColor: "#ccc",
	                    borderWidth: 1,
	                    borderColor: '#ddd'
	                },
	                legend: {
	                    labelBoxBorderColor: '#ddd',
	                    margin: 0,
	                    noColumns: 1,
	                    show: true
	                }
	            }
	        );
	        var previousPoint = null;
	        $("#interactive-chart").bind("plothover", function (event, pos, item) {
	           // $("#x").text(pos.x.toFixed(2));
	           // $("#y").text(pos.y.toFixed(2));
	            if (item) {
	                if (previousPoint !== item.dataIndex) {
	                    previousPoint = item.dataIndex;
	                    $("#tooltip").remove();
	                    var y = item.datapoint[1].toFixed(2);
	                    
	                    var content = item.series.label + " " + y;
	                    showTooltip(item.pageX, item.pageY, content);
	                }
	            } else {
	                $("#tooltip").remove();
	                previousPoint = null;            
	            }
	            event.preventDefault();
	        });
	    }

	};


</script>
