 <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;

$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;

$system_name = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;

$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>

<!-- begin invoice -->

<div class="col-md-12 ui-sortable">

  <div class="panel-body panel-form">

        <div class="profile-section">

            <!-- begin profile-right -->

            <div class="">

                <!-- begin profile-info -->

                <div class="profile-info">

                    <!-- begin table -->

                    <div class="table-responsive">

					<table id="data-table" class="table table-striped table-bordered">

							<thead>

						<div class="table-toolbar">

							  <tr>

									  <th><?php echo get_phrase('Sr/No')?></th>

									  <th><?php echo get_phrase('Payment Details')?></th>

									  <th><?php echo get_phrase('Plan Details')?></th>

									  <th><?php echo get_phrase('Action')?></th>

							  </tr>

							</thead>

							  <?php $this->db->order_by('subcription_id','desc');

									$this->db->where('client_id',$this->session->userdata('login_user_id'));
									$this->db->where('payment_gross_amount>=','0');
									//$this->db->join('packages','packages.package_id=client_payment_details.plan_id');

									$payment = $this->db->get('client_payment_details')->result_array();?>

								<tbody>

									<?php $counter=1;

								

									foreach($payment as $res){ ?>

								  <tr class="even gradeX">

										  <td><?php echo $counter;?></td>

										  <td><ul>

											  <li><b>Amount :</b> <?php echo $res['payment_gross_amount'].' '.$res['payment_mc_currency'];?></li>

											  <li><b>Payment Date:</b> <?php echo  date("F d, Y", strtotime($res['payment_date']));?></li>

											  <li><b>Payment Status:</b> <?php echo $res['payment_status'];?></li>

											  </ul>

										  </td>

										  <td>

										  <ul>

											  <li><b>Plan Name :</b> <?php echo get_phrase($res['plan_name']);?></li>

										  <?php $pkg = $this->crud_model->get_records('packages','',array('package_id'=>$res['plan_id']));

										  foreach($pkg as $row){ ?>

											  <li><b>Duration :</b> <?php if($row['duration_id']=='1'){ echo "Monthly"; } if($row['duration_id']=='3'){ echo "Quarterly"; }if($row['duration_id']=='12'){ echo "Yearly"; }if($row['duration_id']=='free'){ echo "Free"; }?></li>

										  <?php } 
										    #to check if any amount is reducted from subscription
											/*$this->db->where('client_id',$this->session->userdata('login_user_id'));
											$this->db->where('payment_gross_amount < ',0);
											$reduce_amt  = $this->db->get('client_payment_details')->result_array();
											foreach($reduce_amt as $rowAmt)
											{
												if($res['payment_date'] == $rowAmt['payment_date'])
												{
													///echo ' <li><b>Amount Reduce : </b> '. $rowAmt['payment_gross_amount'];
													echo '<br/>'.get_phrase($rowAmt['plan_name']).'</li>';
												}
											}*/
										  ?>

											  </ul>

										  </td>

										  <td><a href="<?php echo base_url()?>clientuser/paymentinvoice/<?php echo $res['subcription_id']?>" class="btn btn-sm btn-success">Invoice</a></td>

								  </tr>

									<?php $counter++; } ?>



								   

								</tbody>

						  </table>

						</div>

						

                    </div>

                    <!-- end table -->

                </div>

                <!-- end profile-info -->

            </div>

            <!-- end profile-right -->

       </div>