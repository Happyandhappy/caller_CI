 <?php $phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;

$system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;

$system_name = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;

$address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>

<!-- begin invoice -->

<?php foreach($details as $row): ?>

                    <div class="panel panel-inverse">

            <div class="invoice">

                <div class="invoice-company">

                    <span class="pull-right hidden-print">

                    <!--<a href="javascript:;" class="btn btn-sm btn-success m-b-10"><i class="fa fa-download m-r-5"></i> Export as PDF</a>-->

                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>

                    </span>

                    <?php echo $system_name. ' - '.get_phrase(str_replace("-"," ",$row['plan_name'])); ?>

                </div>

				<div class="invoice-header">

                    <div class="invoice-from">

                        <small>from</small>

                        <address class="m-t-5 m-b-5">

                            <strong><?php echo $system_name ?></strong><br />

                            <?php echo $address ?>

                            Phone: <?php echo $phone ?>

                        </address>

                    </div>

                    <div class="invoice-to">

                        <small>to</small>

                        <address class="m-t-5 m-b-5">

                            <strong><?php echo ucfirst($row['name']).' '.ucfirst($row['lname']); ?></strong><br />

                            Company Name:<?php echo $row['company_name']; ?><br />

                            Email: <?php echo $row['email']; ?>

                        </address>

                    </div>

                    <div class="invoice-date">

                        <small>Invoice </small>

                        <div class="date m-t-5"><?php echo date('F d, Y',strtotime($row['payment_date']));?></div>

                    </div>

                </div>

                <div class="invoice-header">

                    <div class="table-responsive">

                        <table class="table table-invoice">

                            <thead>

                                <tr>

                                    <th>PAYMENT DETAILS</th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

								  <th><ul>

									  <li><b>Buyer Name :</b></li>

									  <li><b>Payer email :</b></li>

									  <li><b>Amount :</b></li>
                                      
                                        <br/>

									  <li><b>Payment Status :</b></li>

									  <li><b>Date :</b></li>

									  </ul>

								  </th>

                                    <td><ul>

									  <li><?php echo ucfirst($row['buyer_first_name']).' '.ucfirst($row['buyer_last_name']);?></li>

									  <li><?php echo $row['payment_payer_email'];?></li>

									  <li><?php echo $row['payment_gross_amount'].' '.$row['payment_mc_currency'];?></li>
                                      
                                      
                                      <?php #to check if any amount is reducted from subscription
											$this->db->where('client_id',$this->session->userdata('login_user_id'));
											$this->db->where('payment_gross_amount < ',0);
											$reduce_amt  = $this->db->get('client_payment_details')->result_array();
											foreach($reduce_amt as $rowAmt)
											{
												if($row['payment_date'] == $rowAmt['payment_date'])
												{
													echo ' <li><b>Amount Reduce : &nbsp;&nbsp;</b> '.$rowAmt['payment_gross_amount'].'<br/>'.
													get_phrase($rowAmt['plan_name']).'</li>';
												}
											}
											?>

									  <li><?php echo $row['payment_status'];?></li>

									  <li><?php //echo $row['payment_date'];
									  
									echo date("F d, Y", strtotime($row['payment_date']))?></li>

									  </ul></td>

                                </tr>

                            </tbody>

                            <thead>

                                <tr>

                                    <th>PLAN DETAILS</th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

								  <th><ul>

									  <li><b>Name :</b></li>

									  <li><b>Amount :</b></li>

									  <li><b>Duration :</b></li>

									  </ul>

								  </th>

                                    <td><ul>

									<?php $pkg = $this->crud_model->get_records('packages','',array('package_id'=>$row['plan_id']));

										  foreach($pkg as $res){ ?>

									  <li><?php echo $res['package_name'];?></li>

									  <li><?php echo $res['package_amount'];?></li>

									  <li><?php if($res['duration_id']=='1'){ echo "Monthly"; } if($res['duration_id']=='3'){ echo "Quarterly"; }if($res['duration_id']=='12'){ echo "Yearly"; }if($res['duration_id']=='free'){ echo "Free"; }?></li>

										  <?php } ?>

									  </ul></td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="invoice-footer text-muted">

                    <p class="text-center m-b-5">

                        THANK YOU FOR YOUR BUSINESS

                    </p>

                    <p class="text-center">

                        <span class="m-r-10"><i class="fa fa-globe"></i> <?php echo $system_name ?></span>

                        <span class="m-r-10"><i class="fa fa-phone"></i> T:<?php echo $phone ?></span>

                        <span class="m-r-10"><i class="fa fa-envelope"></i> <?php echo $system_email ?></span>

                    </p>

                </div>

            </div>

			

                    </div>

			<!-- end invoice -->

<?php endforeach;?>

		

