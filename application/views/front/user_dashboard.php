<section class="gray-area" id="content">
   <div class="container shortcode">
      <div class="block">
         <div class="row">
            <div class="col-md-12">
               <div class="tab-container box">
                  <ul class="tabs">
                     <li class="active"><a data-toggle="tab" href="#satisfied-customers" aria-expanded="true">DASHBOARD</a></li>
                     <li class=""><a data-toggle="tab" href="#tours-suggestions" aria-expanded="false">MY JOBS</a></li>
                     <li class=""><a data-toggle="tab" href="#careers" aria-expanded="false">TRADESPEOPLE</a></li>
                     <li class=""><a data-toggle="tab" href="#leadback" aria-expanded="false">LEAD BUY BACK</a></li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane fade active in" id="satisfied-customers">
						<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success">
                                <?php echo $this->session->flashdata('success');?>
                                <span class="close"></span>
                            </div> 
						<?php } ?>
						<?php if($this->session->flashdata('error')) { ?>
							<div class="alert alert-error">
                                <?php echo $this->session->flashdata('error');?>
                                <span class="close"></span>
                            </div>
						<?php } ?>
						<div class="toggle-container box">
                           <?php $jobs = $this->crud_model->get_records('tbl_trades','',array('user_id'=>$this->session->userdata('user_id'),'status'=>'1'),'');
						foreach($jobs as $res){ ?>
                           <div class="panel style2">
                              <h4 class="panel-title"> <a class="collapsed" href="#tgg<?php echo $res['trades_id']?>" data-toggle="collapse" aria-expanded="false">
                                 <h4 class="box-title"><?php echo $res['job_name']?></h4>
                                 <p><?php echo $res['job_desc']?></p>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Ref Job:</span><br>
                                          <?php echo $res['job_ref']?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Posted</span><br>
                                          <?php echo date('d-m-Y H:i',strtotime($res['created']))?> </div>
                                    </div>
                                 </div>
                                 </a> </h4>
                              <div id="tgg<?php echo $res['trades_id']?>" class="panel-collapse collapse" aria-expanded="true" style="">
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Location:</span> </div>
                                    </div>
                                    <div class="col-xs-4 departure">
                                       <div> <span class="skin-color">Hiring Stage:</span>
                                          <?php if($res['job_title']=="1") { echo 'Ready To Hire'; }?>
                                          <?php if($res['job_title']=="2") { echo 'Planing and Budgeting'; }?>
                                          <?php if($res['job_title']=="3") { echo 'Need a quote for inssurance purposes'; }?>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Budget:</span> <?php $r2 = explode('_',$res['job_budget']);
										echo $r2[0].' '.$r2[1].' '.$r2[2];?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Timing:</span> <?php $r1 = explode('_',$res['job_start']);
									   echo $r1[0].' '.$r1[1].' '.$r1[2];?> </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     <div id="tours-suggestions" class="tab-pane fade">
                        <div class="toggle-container box">
                           <?php $jobs = $this->crud_model->get_records('tbl_trades','',array('user_id'=>$this->session->userdata('user_id'),'status'=>'1'),'');
						foreach($jobs as $res){ ?>
                           <div class="panel style2">
                              <h4 class="panel-title"> <a class="collapsed" href="#tgg<?php echo $res['trades_id']?>1" data-toggle="collapse" aria-expanded="false">
                                 <h4 class="box-title"><?php echo $res['job_name']?></h4>
                                 <p><?php echo $res['job_desc']?></p>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Ref Job:</span><br>
                                          <?php echo $res['job_ref']?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Posted</span><br>
                                          <?php echo date('d-m-Y H:i',strtotime($res['created']))?> </div>
                                    </div>
                                 </div>
                                 </a> </h4>
                              <div id="tgg<?php echo $res['trades_id']?>1" class="panel-collapse collapse" aria-expanded="true" style="">
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Location:</span> </div>
                                    </div>
                                    <div class="col-xs-4 departure">
                                       <div> <span class="skin-color">Hiring Stage:</span>
                                          <?php if($res['job_title']=="1") { echo 'Ready To Hire'; }?>
                                          <?php if($res['job_title']=="2") { echo 'Planing and Budgeting'; }?>
                                          <?php if($res['job_title']=="3") { echo 'Need a quote for inssurance purposes'; }?>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Budget:</span> <?php $r2 = explode('_',$res['job_budget']);
										echo $r2[0].' '.$r2[1].' '.$r2[2];?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Timing:</span> <?php $r1 = explode('_',$res['job_start']);
									   echo $r1[0].' '.$r1[1].' '.$r1[2];?> </div>
                                    </div>
                                 </div>
                                 <div class="character clearfix">
                                    <h4 class="">
									<a aria-expanded="false" style="float:left;" class="collapsed button btn-small sky-blue1 pull-right" href="#acc<?php echo $res['trades_id']?>" data-toggle="collapse" data-parent="#accordion2">Update My Job</a>
									<a style="float:left;" class="button btn-small red pull-right" href="<?php echo base_url();?>index.php?dashboard/delete_job/<?php echo base64_encode($res['trades_id'])?>">Delete My Job</a>
                                       <div id="acc<?php echo $res['trades_id']?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                          <div class="view-profile col-sm-12">
                                             <div class="col-sm-12 no-float no-padding">
                                                <form id="fmupdate" enctype="multipart/form-data" action="<?php echo base_url();?>index.php?dashboard/update/<?php echo base64_encode($res['trades_id'])?>" method="post">
                                                   <div class="row form-group">
                                                      <div class="col-sms-6 col-sm-4">
                                                         <label>Trade</label>
														   <select class="input-text full-width" name="category_id" id="category_id<?php echo $res['trades_id']?>" onChange="get_subcategory(<?php echo $res['trades_id']?>);">
															  <option selected="selected" value="">Trades</option>
															  <?php $this->db->order_by('category_id', 'asc');
																$test = $this->db->get('tbl_category')->result_array();
																foreach($test as $rescat){ ?>
															  <option value="<?php echo $rescat['category_id'];?>" <?php if($rescat['category_id']==$res['cat_id']) { echo 'selected';} ?>><?php echo $rescat['category_name'];?></option>
															  <?php } ?>
														   </select>
                                                      </div>
                                                      <div class="col-sms-6 col-sm-4">
                                                         <label>Job Type</label>
														   <select class="input-text full-width" name="subcategory_id" id="subcategory_id<?php echo $res['trades_id']?>">
															  <!--<option selected="selected" value="">Job Type</option>-->
															  <?php $this->db->where('category_id',$res['cat_id']);
																$test1 = $this->db->get('tbl_subcategory')->result_array();
																foreach($test1 as $rescat1){ ?>
															  <option value="<?php echo $rescat1['subcategory_id'];?>" <?php if($rescat1['subcategory_id']==$res['subcat_id']) { echo 'selected';} ?>><?php echo $rescat1['subcategory_name'];?></option>
															  <?php } ?>
														   </select>
                                                      </div>
                                                   </div>
													<div class="form-group row">
													  <div class="col-sm-8 col-md-6">
														<label>Name your job</label>
														<input type="text" class="input-text full-width" name="job_name" id="job_name" placeholder="Name your job" required='required' value="<?php echo $res['job_name']?>"/>
													  </div>
													</div>
													<div class="form-group row">
													  <div class="col-sm-8 col-md-8">
														<label>Describe your needs</label>
														<textarea class="input-text full-width" name="job_desc" id="job_desc" placeholder="Describe few more lines about your needs regarding the job"><?php echo $res['job_desc']?></textarea>
													  </div>
													</div>
													<div class="form-group row">
													  <div class="col-sm-6 col-md-6">
														<label>Select The Your Status</label>
														<label for="rad-ready-hire">
														  <input type="radio" <?php if($res['job_title']=='1'){ echo 'checked'; } ?> name="ready_hire" id="rad-ready-hire" value="1"/>
														  Ready To Hire</label>
														<label for="rad-plan">
														  <input type="radio" <?php if($res['job_title']=='2'){ echo 'checked'; } ?> name="ready_hire" id="rad-plan" value="2"/>
														  Planing and Budgeting</label>
														<label for="rad-insurance">
														  <input type="radio" <?php if($res['job_title']=='3'){ echo 'checked'; } ?> name="ready_hire" rad="rad-insurance" value="3"/>
														  Need a quote for inssurance purposes</label>
													  </div>
													</div>
													<div class="form-group row">
													  <div class="col-sm-6 col-md-6">
														<label>When do you like to start your job?</label>
														<select name="job_start" id="job_start" class="full-width">
														  <option disabled="" selected="" value="">-- Select timing --</option>
														  <option value="URGENTLY" <?php if($res['job_start']=='URGENTLY'){ echo 'selected'; } ?>>Urgently</option>
														  <option value="LT_2_DAYS" <?php if($res['job_start']=='LT_2_DAYS'){ echo 'selected'; } ?>>Within 2 days</option>
														  <option value="LT_2_WEEKS" <?php if($res['job_start']=='LT_2_WEEKS'){ echo 'selected'; } ?>>Within 2 weeks</option>
														  <option value="LT_2_MONTHS" <?php if($res['job_start']=='LT_2_MONTHS'){ echo 'selected'; } ?>>Within 2 months</option>
														  <option value="GT_2_MONTHS" <?php if($res['job_start']=='GT_2_MONTHS'){ echo 'selected'; } ?>>2 months+</option>
														  <option value="FLEXIBLE_S_D" <?php if($res['job_start']=='FLEXIBLE_S_D'){ echo 'selected'; } ?>>I am flexible on start date</option>
														</select>
													  </div>
													</div>
													<div class="form-group row">
													  <div class="col-sm-6 col-md-6">
														<label>What's your approximate budget?</label>
														<br />
														<select name="job_budget" id="job_budget" class="full-width">
														  <option disabled="" selected="" value="">-- Select budget --</option>
														  <option value="LT_100" <?php if($res['job_budget']=='LT_100'){ echo 'selected'; } ?>>Under £100</option>
														  <option value="RANGE_100_250" <?php if($res['job_budget']=='RANGE_100_250'){ echo 'selected'; } ?>>Under £250</option>
														  <option value="RANGE_250_500" <?php if($res['job_budget']=='RANGE_250_500'){ echo 'selected'; } ?>>Under £500</option>
														  <option value="RANGE_500_1000" <?php if($res['job_budget']=='RANGE_500_1000'){ echo 'selected'; } ?>>Under £1,000</option>
														  <option value="RANGE_1000_2000" <?php if($res['job_budget']=='RANGE_1000_2000'){ echo 'selected'; } ?>>Under £2,000</option>
														  <option value="RANGE_2000_4000" <?php if($res['job_budget']=='RANGE_2000_4000'){ echo 'selected'; } ?>>Under £4,000</option>
														  <option value="RANGE_4000_8000" <?php if($res['job_budget']=='RANGE_4000_8000'){ echo 'selected'; } ?>>Under £8,000</option>
														  <option value="RANGE_8000_15000" <?php if($res['job_budget']=='RANGE_8000_15000'){ echo 'selected'; } ?>>Under £15,000</option>
														  <option value="RANGE_15000_30000" <?php if($res['job_budget']=='RANGE_15000_30000'){ echo 'selected'; } ?>>Under £30,000</option>
														  <option value="GT_30000" <?php if($res['job_budget']=='GT_30000'){ echo 'selected'; } ?>>Over £30,000</option>
														</select>
													  </div>
													</div>
													<div class="form-group row">
													  <div class="col-sm-8 col-md-6">
														<label>Phone no</label>
														<input type="text" class="input-text full-width" name="phoneno" id="phoneno" placeholder="Name your job" required='required' value="<?php echo $res['phoneno']?>"/>
													  </div>
													</div>
                                                   <hr>
                                                   <div class="form-group col-sm-5 col-md-4 no-float no-padding no-margin">
                                                      <button class="btn-small" id="btn_submit" name="btn_submit" type="submit">Update Job Posting</button>
                                                   </div>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     <div id="careers" class="tab-pane fade">
						<div class="toggle-container box">
						<div class="col-sm-8 col-md-9">
						  <div class="listing-style3 hotel">
							<?php $this->db->select('*');
							$this->db->group_by('trades_quotation.tradesmen_id');
							$this->db->where('trades_quotation.jobuser_id',$this->session->userdata('user_id'));
							$this->db->join('staff_profile','staff_profile.tradesmen_id=trades_quotation.tradesmen_id');
							$this->db->join('staff','staff.staff_id=trades_quotation.tradesmen_id');
							$tradsman = $this->db->get('trades_quotation')->result_array();
							//print_r($tradsman);
							foreach($tradsman as $man) { ?>
							<article class="box force_padding">
								<?php if(empty($man['profile_photo'])) {?>
							  <figure class="col-sm-2 col-md-2"> <a class="" href="#" title=""><img width="270" height="160" src="<?php echo base_url();?>uploads/staff_image/default.png" alt=""></a> </figure>
								
								<?php } else {?> 
							  <figure class="col-sm-2 col-md-2"> <a class="" href="#" title=""><img width="270" height="160" src="<?php echo base_url();?>uploads/staff_image/<?php echo $man['profile_photo']?>" alt=""></a> </figure>
								<?php } ?>
							  <div class="details col-sm-7 col-md-8">
								<div>
								  <div>
									<h4 class="box-title differential_small"><?php echo $man['prefix'].' '.$man['name'].' '.$man['lname']?><!--<small><i class="soap-icon-businessbag blue-color"></i> fgdf</small>--><small><i class="soap-icon-departure blue-color"></i><?php echo $man['house_name'].','.$man['street'].','.$man['town'].','.$man['country']?></small></h4>
								  </div>
									<?php $review = $this->crud_model->get_records('tbl_ratingreview','',array('staff_id'=>$man['tradesmen_id']),'');?>	
									<div>
									<div class="five-stars-container"> <span class="five-stars" style="width: <?php echo ($review[0]['rating']/5)* 100 ?>%;"></span> </div>
								</div>
								<div>
								  <div> <a title="View Profile" class="button btn-small text-center" target="_blank" href="<?php echo base_url();?>index.php?trades/profile/<?php echo base64_encode($man['tradesmen_id'])?>">Profile</a> <a title="Get Quotes" class="button btn-small  text-center" target="_blank" href="<?php echo base_url();?>index.php?dashboard/get_quotation/<?php echo base64_encode($man['tradesmen_id'])?>">Show Quotation</a> </div>
								</div>
							  </div>
							</article>
							<hr>
							<?php } ?>
						  </div>
						</div>
                           
                        </div>
                      
					 </div>
                     <div id="leadback" class="tab-pane fade">
                        <div class="toggle-container box">
                           <?php $this->db->select('purchased.*,cat.category_name,subcat.subcategory_name,trades.job_desc,trades.job_title,trades.job_start,trades.job_budget,staffs.name,staffs.lname');
							$this->db->order_by('purchased.purchased_id', 'asc');
							$this->db->where('purchased.lead_status',1);
							$this->db->where('purchased.jobuser_id',$this->session->userdata('user_id'));
							$this->db->join('tbl_trades as trades','trades.trades_id=purchased.job_id');
							$this->db->join('staff as staffs','staffs.staff_id=purchased.tradesmen_id');
							$this->db->join('tbl_category as cat','cat.category_id=purchased.cat_id');
							$this->db->join('tbl_subcategory as subcat','subcat.subcategory_id=purchased.subcat_id');
							$test = $this->db->get('tbl_purchased as purchased')->result_array();
							//print_r($test);
						foreach($test as $res){ ?>
                           <div class="panel style2">
                              <h4 class="panel-title"> <a class="collapsed" href="#tggg<?php echo $res['purchased_id']?>1" data-toggle="collapse" aria-expanded="false">
                                 <h4 class="box-title">Tradesmen Name - <?php echo $res['name'].' '.$res['lname']?></h4>
                                 </a> </h4>
                              <div id="tggg<?php echo $res['purchased_id']?>1" class="panel-collapse collapse" aria-expanded="true" style="">
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Trade:</span> <?php echo $res['category_name']?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Job Type:</span> <?php echo $res['subcategory_name']?> </div>
                                    </div>
                                 </div>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Location:</span> </div>
                                    </div>
                                    <div class="col-xs-4 departure">
                                       <div> <span class="skin-color">Hiring Stage:</span>
                                          <?php if($res['job_title']=="1") { echo 'Ready To Hire'; }?>
                                          <?php if($res['job_title']=="2") { echo 'Planing and Budgeting'; }?>
                                          <?php if($res['job_title']=="3") { echo 'Need a quote for inssurance purposes'; }?>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="character clearfix">
                                    <div class="col-xs-2 date">
                                       <div> <span class="skin-color">Budget:</span> <?php $r2 = explode('_',$res['job_budget']);
										echo $r2[0].' '.$r2[1].' '.$r2[2];?> </div>
                                    </div>
                                    <div class="col-xs-2 departure">
                                       <div> <span class="skin-color">Timing:</span> <?php $r1 = explode('_',$res['job_start']);
									   echo $r1[0].' '.$r1[1].' '.$r1[2];?> </div>
                                    </div>
                                 </div>
								<form method="post" action="<?php echo base_url();?>index.php?dashboard/tradesback">
									<div class="form-group row">
                                        <div class="col-sm-6 col-md-5">
                                            <label>If you want lead buy back to tradesmen?</label>
                                            <div class="constant-column-2">
                                                <div class="selector">
                                                    <select class="full-width" required name="status">
                                                        <option value="">Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>
													<input type="hidden" name="payment_gross_amount" value="<?php echo $res['payment_gross_amount']?>">
													<input type="hidden" name="purchased_id" value="<?php echo $res['purchased_id']?>">
													<input type="hidden" name="tradesmen_id" value="<?php echo $res['tradesmen_id']?>">
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <div class="col-sm-6 col-md-5">
                                            <label>Comments</label>
                                            <textarea class="input-text full-width" name="comment" required></textarea>
                                        </div>
                                    </div>
									<div class="form-group row">
										<div class="col-sm-6 col-md-5">
											<button type="submit" class=" btn-small">Submit</button>
										</div>
									</div>
								</form>
								</div>
                           </div>
                           <?php } ?>
                        </div>
                      
					 </div>
	               </div>
               </div>
            </div>
         </div>
		 <div class="travelo-box box-full">
			<div class="contact-form">
				<div class="row">
					<div class="col-sm-12">
                        <div class="parallax how_it_work_local" data-stellar-background-ratio="0.5" style="background-position: 50% 93.5px;">
							<div class="container description">
							  <div class="text-center description">
								<h1 class="heading-underlined">How it works</h1>
								<p> </p>
							  </div>
							  <br />
							<?php $works = $this->crud_model->get_records('tbl_howitworks');?>
							  <div class="row image-box style8">
								<div class="col-md-4">
								  <article class="box animated" data-animation-type="fadeInUp">
									<div class="details">
									  <h2 class="box-title text-center">Create A Job</h2>
									  <p class="box_border_top text-center"><?php echo $string = substr($works[0]['create'], 0, 250);?></p>
									</div>
								  </article>
								</div>
								<div class="col-md-4">
								  <article class="box animated" data-animation-type="fadeInUp">
									<div class="details">
									  <h2 class="box-title text-center">Get A Quote</h2>
									  <p class="box_border_top text-center"><?php echo $string = substr($works[0]['quotes'], 0, 250);?></p>
									</div>
								  </article>
								</div>
								<div class="col-md-4">
								  <article class="box animated" data-animation-type="fadeInUp">
									<div class="details">
									  <h2 class="box-title text-center">Rate And Review</h2>
									  <p class="box_border_top text-center"><?php echo $string = substr($works[0]['review'], 0, 250);?></p>
									</div>
								  </article>
								</div>
							  </div>
							</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		 <div class="travelo-box box-full">
			<div class="contact-form">
				<div class="row">
					<div class="col-sm-12">
                        <div class="parallax how_it_work_local" data-stellar-background-ratio="0.5" style="background-position: 50% 93.5px;">
							<div class="search-tab-content">
							   <div class="tab-pane fade active in" id="hotels-tab">
								  <form method="post" id="formhm" name="formhm" novalidate action="<?php echo base_url();?>index.php?quotes/jobquotes">
									 <div class="row">
										<div class="form-group col-sm-6 col-md-2 "> </div>
										<div class="form-group col-sm-6 col-md-3 ">
										   <h4 class="title">I need a..</h4>
										   <select class="input-text full-width" name="category_id" id="category_id" onChange="get_subcat(this.value);">
											  <option selected="selected" value="">Trades</option>
											  <?php $this->db->order_by('category_id', 'asc');
											$test = $this->db->get('tbl_category')->result_array();
											foreach($test as $res){ ?>
											  <option value="<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></option>
											  <?php } ?>
										   </select>
										</div>
										<div class="form-group col-sm-8 col-md-3 ">
										   <h4 class="title">To Help Me With..</h4>
										   <select class="input-text full-width" name="subcategory_id" id="subcategory_id">
											  <option selected="selected" value="">Job Type</option>
										   </select>
										</div>
										<div class="form-group col-sm-6 col-md-2 fixheight ">
										   <button type="submit" class="full-width icon-check next" id="nxtstep" name="nxtstep" data-animation-type="bounce" data-animation-duration="1">Next Step</button>
										</div>
									 </div>
								  </form>
							   </div>
							</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
      </div>
   </div>
</section>
<script type="text/javascript" src="assets/frontend/js/bootstrap.js"></script> 
<script type="text/javascript" src="assets/frontend/js/jquery_1.9.1_jquery.min.js"></script> 
<script type="text/javascript">
	function get_subcategory(id)
	{
		var cat_id = $('#category_id'+id).val();
		var postData={
					  'cat_id':cat_id
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?home/subcat",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			 $('#subcategory_id'+id).html(data);
			 //$('#subcategory_id2').html(data);
			},
		  });
	}
</script> 
<script type="text/javascript">
	function get_subcat(id)
	{
		var cat_id = id;
		var postData={
					  'cat_id':cat_id
					 };
			$.ajax({
			url: "<?php echo base_url();?>index.php?home/subcat",
			type: "POST",  
			data: postData,
			success: function(data){
			//alert(data);
			 $('#subcategory_id').html(data);
			 //$('#subcategory_id2').html(data);
			},
		  });
	}
</script> 
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script> 
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#formhm").validate({
        // Specify the validation rules
        rules: {
			category_id :{required: true},
			subcategory_id :{required: true},

        },
        // Specify the validation error messages
        messages: {
			category_id: { required: "Trade required"},
			subcategory_id: { required: "Job Type required"},
        },
    });
  });
$(".next").click(function(){
	
	  if($(this).attr('id') =='nxtstep'){
  if($('#category_id').valid() && $('#subcategory_id').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	
	if($(this).attr('id') =='btn_submit'){
  if($('#category_id').valid() && $('#subcategory_id').valid()&& $('#job_name').valid() && $('#job_desc').valid() && $('#job_start').valid() && $('#job_budget').valid()&& $('#phoneno').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}

	if($(this).attr('id') =='btn_review'){
  if($('#review_title').valid() && $('#review_desc').valid() && $('#rating').valid()){
	  	//activate next step on progressbar using the index of next_fs
		$(".error").empty('');
	  }else{
		return false;
	  }
	}
	
});

</script>
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmupdate").validate({
        // Specify the validation rules
        rules: {
			category_id :{required: true},
			subcategory_id :{required: true},
            job_name: "required",
			job_desc :"required",
			phoneno :"required",
			job_start :{required: true},
			job_budget :{required: true},

        },
        // Specify the validation error messages
        messages: {
			category_id: { required: "Trade required"},
			subcategory_id: { required: "Job Type required"},
            job_name: "Please enter job name",
            job_desc: "Please enter job description",
			job_start: { required: "Select Your Job"},
			job_budget: { required: "Select Your Job Estimate"},
			phoneno :"Please enter phone no",
        },
    });
  });
</script>
<script>
 $(function() {
    // Setup form validation on the #register-form element
    $("#fmreview").validate({
        // Specify the validation rules
        rules: {
			review_desc :{required:true, minlength :30},
			review_title :"required",
			rating :"required",

        },
        // Specify the validation error messages
        messages: {
 			review_desc: { required: "Please enter Description",
					  minlength: "Please enter more than 30 words"},
			review_title :"Please enter rating title",
			rating :"Please enter rating",
        },	
    });
  });
</script>