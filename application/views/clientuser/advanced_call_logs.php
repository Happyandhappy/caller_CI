<div class="profile-section">

    <!-- begin row -->
<div id="soundTone"></div>
    <div class="row">
        <?php 
		if ($this->session->flashdata('not_fund')){ 
			$value = $this->session->flashdata('not_fund');
			if($this->session->userdata('is_subscriber')) {
		?>
			<div class="col-md-12">
	            <div class="alert alert-warning"><span class="close" data-dismiss="alert">×</span>
	                <div><h5> You have used up all lookups for your subscription!</h4></div>
	            </div>
	         </div>

			<?php } else { ?>
			<div class="col-md-12">
	            <div class="alert alert-warning"><span class="close" data-dismiss="alert">×</span>
	                <div class="row p-20"><h4> Your Fund is not enough to lookup a new number!</h4>
	                    <p class="f-s-16" style="font-size: 12px;"> Your account funds are low and you need to add a minimum of $<?=$value ?> to lookup a number!</p>
	                    <p>
	                        <form class="form-inline" name="frm_payment" id="frm_payment" method="post" action="'.$frm_url.'"
	                              onSubmit="return validate_amt();">
								<div class="input-group m-r-10">
		      						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
	                                <input type="text" class="form-control" name="topup_amount" id="topup_amount" value="<?=$value ?>" required placeholder="Enter amount">
	                            </div>
	                            <input type="submit" class="btn btn-sm btn-primary m-r-5" name="pay_submit" id="pay_submit"  value="Pay">
	                        </form>
	                    </p>
	                </div>
	            </div>
	         </div>
	         <?php }  ?>
        <?php } ?>
        <!-- begin col-4 -->

        <div class="col-md-12"> 
            <!-- begin scrollbar -->
            <div class="well bg-silver-lighter p-20">

	        <?php 
				if (!$this->session->flashdata('not_fund')) { 
			?>
			<?php if($view_one_number) { ?>
				<style> .dataTables_filter,.dt-buttons { display: none!important; }</style>
			<?php } ?>
                <div class="well bg-grey text-white <?php echo ($view_one_number ? 'hide':  '') ?>">
                    <div id="step1" role="tabpanel" class="bwizard-activated" aria-hidden="false">
                        <fieldset>
                            <legend class="pull-left width-full">
                                <h4 class="col-md-6 title text-white">Input Number to Lookup: </h4>
								<div class="col-md-6 row dropdownMain">
									<select name="phoneSelection" id="phoneSelection" style="width:100%;max-width: 250px;" onchange="javascript:window.location.href='<?php echo base_url();?>clientuser/number_lookup/'+this.value+'/list';">
									<?php 
									echo "<option value='all'>All Lookups</option>";
									echo "<option value='manual'>Manual Lookups</option>";
									foreach($phoneNumbers as $phoneNumber){
										echo "<option value=".$phoneNumber['phoneNumber']." ".($phone_number_purchased==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
									}
									?>								  
									</select>
								</div>
								<div class="col-md-12 row" style="margin-top:5px;">
                                <form class="form-horizontal form-bordered" data-parsley-validate="true"
                                      action="<?php echo base_url(); ?>base/lookup_number_calllog"
                                      name="demo-form" novalidate method="post" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <input type="hidden" class='form-control' placeholder='Number'
                                                   name='pur_number' id='' value="<?=$phone_number_purchased ?>">
										   
											<input type="text" class='form-control' placeholder='Number'
                                                   name='phonenumber' id='phonenumbermask'>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <button class='btn btn-sm btn-primary'>Look up!</button>
                                        </div>
                                    </div>
                                </form>
								</div>
                            </legend>
                        </fieldset>
                    </div>
                </div>
                <?php }?>

                <?php  
				$html1 = '';
				$html2 = '';
				
				
				$html1 .= '<table id="data-table" class="table table-striped table-bordered nowrap table-ajeitada-1">
                    <thead class="bg-silver-lighter p-10">
                        <tr>
                            <th width="">'.strtoupper(get_phrase('Sr/No.')).'</th>
                            <th>'.strtoupper(get_phrase('First Name')).'</th>                            
                            <th>'.strtoupper(get_phrase('Middle Initial')).'</th>                            
                            <th>'.strtoupper(get_phrase('Last Name')).'</th>                            
                            <th class="">'.strtoupper(get_phrase('Number')).'</th>
                            <th class="">'.strtoupper(get_phrase('date')).'</th>
                            <th class="">'.strtoupper(get_phrase('lookup status')).'</th>
                            <th class="">'.strtoupper(get_phrase('caller_type')).'</th>
                            <th class="">'.strtoupper(get_phrase('age')).'</th>
                            <th class="">'.strtoupper(get_phrase('education')).'</th>
                            <th class="">'.strtoupper(get_phrase('gender')).'</th>
                            <th class="">'.strtoupper(get_phrase('high_net_worth')).'</th>
                            <th class="">'.strtoupper(get_phrase('home_owner_status')).'</th>
                            <th class="">'.strtoupper(get_phrase('household_income')).'</th>
                            <th class="">'.strtoupper(get_phrase('phone_carrier')).'</th>
                            <th class="">'.strtoupper(get_phrase('phone_line_type')).'</th>
                            <th class="">'.strtoupper(get_phrase('country_Code')).'</th>
                            <th class="">'.strtoupper(get_phrase('national_Format')).'</th>
                            <th class="">'.strtoupper(get_phrase('length_of_residence')).'</th>
                            <th class="">'.strtoupper(get_phrase('marital_status')).'</th>
                            <th class="">'.strtoupper(get_phrase('market_value')).'</th>
                            <th class="">'.strtoupper(get_phrase('occupation')).'</th>
                            <th class="">'.strtoupper(get_phrase('presence_of_children')).'</th>
                            <th class="">'.strtoupper(get_phrase('address')).'</th>
                            <th class="">'.strtoupper(get_phrase('Mobile Country Code ')).'</th>
                            <th class="">'.strtoupper(get_phrase('Mobile Network Code ')).'</th>
                            <th class="">'.strtoupper(get_phrase('Wireless Name ')).'</th>
                            <th class="">'.strtoupper(get_phrase('Mobile Type ')).'</th>
                            <th class="">'.strtoupper(get_phrase('Number')).'</th>
                            <th class="">'.strtoupper(get_phrase('Carrier')).'</th>
                            <th class="">'.strtoupper(get_phrase('Line Type')).'</th>
							
                            <th class="">'.strtoupper(get_phrase('City')).'</th>
                            <th class="">'.strtoupper(get_phrase('Address Extended Zip')).'</th>
                            <th class="">'.strtoupper(get_phrase('Country')).'</th>
                            <th class="">'.strtoupper(get_phrase('Address Line 1')).'</th>
                            <th class="">'.strtoupper(get_phrase('Address Line 2')).'</th>
                            <th class="">'.strtoupper(get_phrase('State')).'</th>
                            <th class="">'.strtoupper(get_phrase('Zip Code')).'</th>
                            <th class="">'.strtoupper(get_phrase('email 1')).'</th>
                            <th class="">'.strtoupper(get_phrase('email 2')).'</th> 
                            <th class="">'.strtoupper(get_phrase('email 3')).'</th>
                            <th class="">'.strtoupper(get_phrase('email 4')).'</th>
                            <th class="">'.strtoupper(get_phrase('email 5')).'</th>
                            <th class="">'.strtoupper(get_phrase('facebook')).'</th>
                            <th class="">'.strtoupper(get_phrase('twitter')).'</th>
                            <th class="">'.strtoupper(get_phrase('linkedin')).'</th>
                            
                        </tr>
                    </thead>
                    <tbody>';
					
					$html2 .= '<table class="table table-bordered nowrap table-ajeitada-1 " id="caller_lookups_data_table">
                    <tbody>';
                    
                    if (count($calls_read) > 0) {
                        $j = 1;
                        foreach ($calls_read as $cread) {
							
							if( empty( $cread['nationalFormat'] ) )
								continue;
                            $html1 .= '<tr>
                                <td class="p-r-5">'.$j.'</td>                                
								<td>'.ucwords($cread['first_name'] ).'</td>
								<td>'.ucwords($cread['middle_name']).'</td>
								<td>'.ucwords($cread['last_name']).'</td>
								<td>'.ucwords($cread['nationalFormat']).'</td>
								<td>'.date("m-d-Y H:i:s", strtotime($cread['call_date'])).'</td>
								<td>'.ucwords($cread['status']).'</td>
								<td>'.ucwords($cread['caller_type']).'</td>
								<td>'.ucwords($cread['age']).'</td>
								<td>'.ucwords($cread['education']).'</td>
								<td>'.ucwords($cread['gender']).'</td>
								<td>'.ucwords($cread['high_net_worth']).'</td>
								<td>'.ucwords($cread['home_owner_status']).'</td>
								<td>'.ucwords($cread['household_income']).'</td>
								<td>'.ucwords($cread['phone_carrier']).'</td>
								<td>'.ucwords($cread['phone_line_type']).'</td>
								<td>'.ucwords($cread['countryCode']).'</td>
								<td>'.ucwords($cread['nationalFormat']).'</td>
								<td>'.ucwords($cread['length_of_residence']).'</td>
								<td>'.ucwords($cread['marital_status']).'</td>
								<td>'.ucwords($cread['market_value']).'</td>
								<td>'.ucwords($cread['occupation']).'</td>
								<td>'.ucwords($cread['presence_of_children']).'</td>
								<td>';
								
							$html2 .= '<tr class="'.($view_one_number ? 'hide-opened"':  'hide-open" data-click="'.$j.'" ').'><td style="'.($cread['location']=='manual' ? 'background-color:#fafafa;padding: 0;': 'padding:0').'">
                                <div class="title-tabela" data-from="'.($cread['from'] ? $cread['from']: '0').'"  data-od="'.$cread['phoneNumber'].'" style="width:70%;display:inline-block;'.($cread['location']=='manual' ? 'background-color:#fafafa;padding: 10px 15px;': 'padding: 10px 15px;').'">';
							if($cread['location'] == 'home'){
								$html2 .= '* '; 
							}
								
							if ($cread['first_name']){ 
								$html2 .= ucwords($cread['first_name'] . ' ' . $cread['middle_name'] . ' ' . $cread['last_name']).' - '.ucwords($cread['nationalFormat']); 
							} else { 
								$html2 .= 'NO NAME - '.ucwords($cread['nationalFormat']);
							} 
							$html2 .= '</div><a data-cid="'.(isset($cread['id']) ? $cread['id'] : 0).'" data-toggle="tooltip" title="Permanently Remove This Record" class="pull-right action-btn send-removerow"><i class="fa fa-remove"></i></a><a href="#" title="Call This Person" data-toggle="tooltip" data-from="'.(($cread['location']!='manual') ? ct_format_nice_number($cread['odakle']) : '0').'" data-to="'.($cread['nationalFormat']).'" class="pull-right bridge-call action-btn"><i class="fa fa-phone"></i></a> <a '.($view_one_number ? 'style="display:none"' : '').' title="Send Text" data-toggle="tooltip" data-from="'.($cread['from'] ? $cread['from']: '0').'"  data-od="'.$cread['phoneNumber'].'"  class="pull-right action-btn send-smsbtnnow" data-notifsms="'.$cread['phoneNumber'].'"><i class="fa fa-weixin"></i></a><a data-toggle="tooltip" title="Print Address Label" data-numbr="'.($cread['phoneNumber']).'" class="pull-right action-btn send-printbtn '.(isset($printed_numbers[$picked_who]) ? 'btn-wasprinted': '' ).'"><i class="fa fa-print"></i></a><a data-numbr="'.($cread['phoneNumber']).'" class="pull-right action-btn action-demo" data-toggle="tooltip" title="Email Demographic Report"><i class="fa fa-envelope" ></i></a>';
							if(isset($usr_vCard) && $usr_vCard!='')
								$html2 .= '<a data-from="'.(($cread['location']!='manual') ? ct_format_nice_number($cread['odakle']) : ct_format_nice_number($picked_prvi)).'" data-numbr="'.($cread['phoneNumber']).'" data-toggle="tooltip" title="Send Contact Card" class="pull-right action-btn send-vcardbtn '.(isset($vcard_numbers[$picked_who]) ? 'btn-wasprinted': '' ).'"><i class="fa fa-address-card-o"></i></a>';
							$html2 .= '</td>
									</tr>
									<tr class="hide-click '.($view_one_number ? 'opened"': '" data-click="'.$j).'" ">
									<td>';
									$adv_caller_name  = ucwords($cread['first_name'] . ' ' . $cread['middle_name'] . ' ' . $cread['last_name']);
							$message = '<div class="row home_page_lookup">
										<div class="main-table-div">
											
											<div class="primary-table">
												<label class="full-label-one"><b>User Details</b></label>
												  <table>
															<tr>
																<td><label>'.get_phrase('name').':</label>'.(!empty($adv_caller_name) ? '<a href="https://google.com/search?q='.$adv_caller_name.'" target="__blank" title="Search for Person on Google">'.$adv_caller_name.'</a>': 'No Name').'
																</td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('Number')).':</label><a target="__blank" href="http://google.com/search?q=' . ucwords($cread['nationalFormat']) . '">' .ucwords($cread['nationalFormat']).'</a></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('date')).':</label>'.date("m-d-Y H:i:s", strtotime($cread['call_date'])).'</td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('lookup status')).': </label>'.ucwords($cread['status']).'</td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('caller_type')).':</label>'.ucwords($cread['caller_type']).'</td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('age')).':</label><span style="display: inline-block;">'.ucwords($cread['age']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('education')).':</label><span style="display: inline-block;">'.ucwords($cread['education']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('gender')).':</label><span style="display: inline-block;">'.ucwords($cread['gender']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('high_net_worth')).':</label><span style="display: inline-block;">'.ucwords($cread['high_net_worth']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('home_owner_status')).':</label><span style="display: inline-block;">'.ucwords($cread['home_owner_status']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('length_of_residence')).':</label><span style="display: inline-block;">'.ucwords($cread['length_of_residence']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('market_value')).':</label><span style="display: inline-block;">'.ucwords($cread['market_value']).'</span></td>
															</tr>
															 <tr>
																<td><label> '.ucwords(get_phrase('household_income')).':</label><span style="display: inline-block;">'.ucwords($cread['household_income']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('marital_status')).':</label><span style="display: inline-block;">'.ucwords($cread['marital_status']).'</span></td>
															</tr>
															<tr>
																<td><label> '.ucwords(get_phrase('presence_of_children')).':</label><span style="display: inline-block;">'.ucwords($cread['presence_of_children']).'</span></td>
															</tr>   
															<tr>
																<td><label> '.ucwords(get_phrase('occupation')).':</label><span style="display: inline-block;">'.ucwords($cread['occupation']).'</span></td>
															</tr>
                                
									';
									$data = explode('#', $cread['linked_emails']);
									if ($data[0]):

								$message .= '<tr><td><label>Email:</label></td></tr>';
							  for ($i = 0; $i <= count($data); $i++) {

									$mail = explode('=', $data[$i]);
									$message .= '<tr>
													<td><a style="color:#337ab7" href="mailto:'.$mail[1].'">'.$mail[1].' </a></td>
												</tr>';
							  }
							endif;
							$data = explode('#', $cread['social_links']);

							if ($data[0]): 
								$message .= '<tr><td><label>Social Media Links:</label></td></tr>';
			   
				
							
							for ($i = 0; $i <= count($data); $i++) {

								$link = explode('url=', $data[$i]);
								
								if ($link[0] != ''):
									continue;
								endif;
								$message .= '<tr>
									<td><label><a style="color:#337ab7" target="_blank" href="'.$link[1].'">'.$link[1].'</a>
										</label></td>
								</tr>';
							} 
                                    
                        endif;
                            $message .= '</table>

                        
				</div>
		  
				<div class="secondary-table">
                    <label class="full-label-two"><b>Address</b> (Click address for Google map views)</label>
				<div class="loc-table">
					                            <table>
                                <tr>
                                    <td >';
                                         $data = explode('#', $cread['address']);                                            
                                        $address = array();
                                        $i=0;
                                        foreach ($data as $res) { 

                                            $data2 = explode('=', $res); 
                                            if (!$data2[0]) continue; 

                                            if( $data2[0] == 'city' ){
                                                $i++;
                                                $address[$i] = array('city'=>$data2[1]);
                                            }
                                            else{
                                                $address[$i][$data2[0]]=$data2[1];
                                            }



                                        }
                                        foreach( $address as $addr ){
                                            $address_string = ''; $address_string .= (ucwords($addr['line1'])) ? ucwords($addr['line1']) . ',  ' : '';
                                            $address_string .= (ucwords($addr['line2'])) ? ucwords($addr['line2']) . ',  ' : '';
                                            $address_string .= (ucwords($addr['city'])) ? ucwords($addr['city']) . '  ' : '';
                                            $address_string .= (ucwords($addr['state'])) ? ucwords($addr['state']) . '  ' : '';
                                            $address_string .= (ucwords($addr['zip_code'])) ? ucwords($addr['zip_code']) . '-' : '0000';
                                            $address_string .= (ucwords($addr['extended_zip'])) ? ucwords($addr['extended_zip']) . '  ' : '';
                                            $address_string .= (ucwords($addr['country'])) ? ucwords($addr['country']) . ' ' : '';
                                            if( !empty( $address_string ) ){ 
                                            $message .= '<a href="https://www.google.com/maps/place/'.urlencode($address_string).'" target="_blank" style="display:block;color:#337ab7;">
                                                '.$address_string.'
                                            </a>';
                                            }
                                        }
                                        
                                    $message .= '</td>
                                </tr>';
                                
                                    $data = explode('#', $cread['address']);

                                    foreach ($data as $res) {
                                        $data2 = explode('=', $res);
                                        if (!$data2[0]) continue;
                                        $message .= '<tr>
                                            <td>
                                                <label for="">'.ucwords(get_phrase($data2[0])).':</label>'.$data2[1].'
                                            </td>
                                        </tr>';
                                     }
                                

                            $message .= '</table>
							</div>
                            <label class="full-label"><b>Phone Carrier Details</b></label>
							 <div class="sec-tab">
                                <table>
                                    <tr>
                                        <td><label>'.ucwords(get_phrase('phone_carrier')).':</label>'.ucwords($cread['phone_carrier']).'</td>
                                    </tr>
                                    <tr>
                                        <td><label>'.ucwords(get_phrase('phone_line_type')).':</label>'.ucwords($cread['phone_line_type']).'</td>
                                    </tr>

                                    <tr>
                                        <td><label> '.ucwords(get_phrase('national_Format')).':</label>'.ucwords($cread['nationalFormat']).'</td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px; font-size: 13px;"><img src="'.base_url('images/facebook-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" href="https://www.facebook.com/search/top/?q='.urlencode($adv_caller_name).'&init=public">Search on FB by Name</a><br/><a target="_blank" href="https://www.facebook.com/search/top/?q='.urlencode($cread['nationalFormat']).'&init=public">Search on FB by Number</a></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px;"><img src="'.base_url('images/linkedin-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" style="margin-top:15px; display: inline-block;" href="https://www.linkedin.com/search/results/index/?keywords='.urlencode($adv_caller_name).'&origin=GLOBAL_SEARCH_HEADER">Search on Linkedin</a><br/></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 30px; min-width: 280px;"><img src="'.base_url('images/twitter-icn.png').'" alt="" style="float:left;margin:10px;margin-left:0;margin-top:0;" height="60px" /><a target="_blank" style="margin-top:15px; display: inline-block;" href="https://twitter.com/search?q='.urlencode($adv_caller_name).'&src=typd">Search on Twitter</a><br/></td>
                                    </tr>
                                </table>
				            </div>  
			</div> 
        </div><hr/><div class="clearfix"></div><div class="text-center" style="margin-top:15px;"><h4>SMS Messages for '.$adv_caller_name.' '.$cread['nationalFormat'].'</h4></div>
    <div class="hidden-xs hidden-sm"><h5 class="pull-left" style="display:inline">Incoming</h5> <h5  style="display:inline" class="pull-right">Outgoing</h5></div>
    </div>
    ';
									$html2 .= $message.'</td>
								</tr>';
                                                   
								$data = explode('#', $cread['address']);                                            
								$address = array();
								$i=0;
								foreach ($data as $res) { 

									$data2 = explode('=', $res); 
									if (!$data2[0]) continue; 

									if( $data2[0] == 'city' ){
										$i++;
										$address[$i] = array('city'=>$data2[1]);
									}
									else{
										$address[$i][$data2[0]]=$data2[1];
									}
								}
								
								foreach( $address as $addr ){ 
                                    $address_string = ''; 
									$address_string .= (ucwords($addr['line1'])) ? ucwords($addr['line1']) . ',  ' : ''; 
                                    $address_string .= (ucwords($addr['line2'])) ? ucwords($addr['line2']) . ',  ' : ''; 
                                    $address_string .= (ucwords($addr['city'])) ? ucwords($addr['city']) . '  ' : ''; 
                                    $address_string .= (ucwords($addr['state'])) ? ucwords($addr['state']) . '  ' : ''; 
                                    $address_string .= (ucwords($addr['zip_code'])) ? ucwords($addr['zip_code']) . '-' : '0000'; 
                                    $address_string .= (ucwords($addr['extended_zip'])) ? ucwords($addr['extended_zip']) . '  ' : ''; 
                                    $address_string .= (ucwords($addr['country'])) ? ucwords($addr['country']) . ' ' : ''; 
                                    if( !empty( $address_string ) ){ 
                                        $html1 .= '<a href="https://www.google.com/maps/place/'.urlencode($address_string).'" target="_blank" style="display:block;color:#337ab7;">'.$address_string.' </a>';    
									} 
								} 
                                
								$html1 .= '</td>';
                                 
								$data = explode('#', $cread['carrier']);
								$carrier_data = array();
								foreach ($data as $res) { 
									$data2 = explode('=', $res); 
									$carrier_data[$data2[0]] = $data2[1];
								}
								if( isset($carrier_data['mobile_country_code']) ){
									$html1 .= "<td>".$carrier_data['mobile_country_code']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['mobile_network_code']) ){
									$html1 .= "<td>".$carrier_data['mobile_network_code']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['name']) ){
									$html1 .= "<td>".$carrier_data['name']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['type']) ){
									$html1 .= "<td>".$carrier_data['type']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
										
								$us = 0;
								if( trim($cread['countryCode']) =='US')
									$us = 1;
									
								$data = explode('#', $cread['phone_details']);
								$carrier_data = array();
								foreach ($data as $res) { 
									$data2 = explode('=', $res); 
									$carrier_data[$data2[0]] = $data2[1];
								}
								if( isset($carrier_data['number']) ){
									$html1 .= "<td>".($us?'1':'0').$carrier_data['number']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['carrier']) ){
									
									$html1 .= "<td>".$carrier_data['carrier']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['line_type']) ){
									$html1 .= "<td>".$carrier_data['line_type']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
								$data = explode('#', $cread['address']);
								$carrier_data = array();
								foreach ($data as $res) { 
									$data2 = explode('=', $res);
									
									if( isset( $carrier_data[$data2[0]] ) && !empty( $carrier_data[$data2[0]] ) && $data2[1] != $carrier_data[$data2[0]] )
										$carrier_data[$data2[0]] .= '|'.$data2[1];
									else
										$carrier_data[$data2[0]] = $data2[1];
									
								}
								if( isset($carrier_data['city']) ){
									$html1 .= "<td>".$carrier_data['city']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['extended_zip']) ){
									$html1 .= "<td>".$carrier_data['extended_zip']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['country']) ){
									$html1 .= "<td>".$carrier_data['country']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['line1']) ){
									$html1 .= "<td>".$carrier_data['line1']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['line2']) ){
									$html1 .= "<td>".$carrier_data['line2']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								if( isset($carrier_data['state']) ){
									$html1 .= "<td>".$carrier_data['state']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
								if( isset($carrier_data['zip_code']) ){
									$html1 .= "<td>".$carrier_data['zip_code']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
									 
								$data = explode('#', $cread['linked_emails']);
								$emails = array();
								for ($i = 0; $i <= count($data); $i++) {
									$mail = explode('=', $data[$i]); 
									if (filter_var($mail[1], FILTER_VALIDATE_EMAIL) ){
										$emails[] = trim($mail[1]); 
									} 
								} 
								foreach( $emails as $ema ){
									$html1 .= "<td>".$ema."</td>";
								}
								for($i=count($emails);$i<5;$i++){
									$html1 .= "<td></td>";
								}
								$data = explode('#', $cread['social_links']);
							
								$links = array();
								for ($i = 0; $i <= count($data); $i++) {

									$link = explode('=', $data[$i]); 
									if (filter_var($link[1], FILTER_VALIDATE_URL) ){
										if( strpos($link[1],'facebook')){
											$links['facebook'] = trim($link[1]);
										}
										if( strpos($link[1],'twitter')){
											$links['twitter'] = trim($link[1]);
										}
										if( strpos($link[1],'linkedin')){
											$links['linkedin'] = trim($link[1]);
										}
									} 
								 } 
								 
								if( isset($links['facebook']) ){
									$html1 .= "<td>".$links['facebook']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
								if( isset($links['twitter']) ){
									$html1 .= "<td>".$links['twitter']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
								if( isset($links['linkedin']) ){
									$html1 .= "<td>".$links['linkedin']."</td>";
								}
								else{
									$html1 .= "<td></td>";
								}
								
                            $html1 .= '</tr>';
							
							
              

							$j++; 
                        }

                    } else { 
                        $html1 .= '<tr><td class="p-r-5" colspan="4">No Data selected.</td></tr>';
                        $html2 .= '<tr><td class="p-r-5" colspan="4">No Data selected.</td></tr>';
                    }

                
            
			
			$html1 .= '</tbody></table>';
			$html2 .= '</tbody></table>';
            
			echo $html1;
			echo $html2;

             ?>

            <!-- Modal -->

            <!-- end table -->

            <!--</div>-->
            

        </div>

        <!-- end scrollbar -->

    </div>

    <!-- end col-4 -->

</div>

<!-- end row -->
  <div class="modal fade" id="sms-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Text</h4>
        </div>
        <div class="modal-body">
        	<div id="status-field"></div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="pickselect" id="fromSelect" style="display:hidden">
        			<h4>From:</h4>
        				<select id="select-sms" name="select-sms-bridge">
						<?php 
						$ij=0;
						foreach($phoneNumbers as $phoneNumber){
							echo "<option value=".$phoneNumber['phoneNumber']." ".($picked_who==$phoneNumber['phoneNumber']?"selected":"").($picked_who=='' && $ij==0 ? ' selected': '').">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
							$ij++;
						}
						?>								  
						</select>
        			</div>
        			<div class="pick-from">
        				<h4>From: <span id="from-sms"></span></h4>
        			</div>
        			
        		</div>
        		<div class="col-md-6 text-right">
        			<h4>To: <span id="to-sms"></span></h4>
        		</div>
        	</div>
        	<hr style="margin:5px 0;" />
        	<h3>Message</h3>
			  <textarea class="form-control" rows="2" id="text-msg-content2" name="text-msg"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary sendNewText2">Send Text!</button>
          <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<script type="text/javascript">
	var send_sms2 = function(sfrom,sto,smess) {
		var froms = sfrom;
		froms =  froms.replace("(", "");
		froms =  froms.replace(")", "");
		froms =  froms.replace("-", "");
		froms =  froms.replace(" ", "");
		froms =  '+1'+froms;
		var tos = sto;
		var textf = $('#text-msg-content2');
		var msgcnt = textf.val().length;
		if(msgcnt>0) {
			//$('#rpfrm-'+smsid).submit();
			textf.attr('disabled', true);
			$('.sendNewText').attr('disabled', true);

			var postdata = {
				msg: smess,
				from:  froms,
				to:  sto,
				americanize: 1,
				ajax: 1
			};

				$.post( '<?php echo site_url('/base/send_sms'); ?>',postdata)
				  .done(function(res) {
				    //alert( "It worked!" );
				    if(res.status=='success') {
		 				$('#sms-modal #status-field').html('<div class="alert alert-success"><b>Text Sent!</b></div>');

				    } else {
		 				$('#sms-modal #status-field').html('<div class="alert alert-danger"><b>Could not send text message!</b></div>');
				    }
				  })
				  .fail(function() {
				    alert( "There was an error! Try again!" );
				  })
				  .always(function() {
					textf.val('');
					textf.attr('disabled', false);
					$('.sendNewText').attr('disabled', false);
				  });
				 

		} else {
			alert("1 Character Minimum");
		}
		return true;
	}
    $(document).ready(function () {
		$('.sendNewText2').on('click',function(ev) {
			var textf = $('#text-msg-content2');

			var from = $('#from-sms').html();
			var to = $('#to-sms').html();
			if(from=='0')
				from = $( "#select-sms" ).val();
			console.log($( "#select-sms" ).val());

	 		send_sms2(from,to,textf.val());
	 		ev.preventDefault();

		});
		/* sms now */
		$('.send-smsbtn').on('click',function(ev) { // show modal
			ev.preventDefault();
			var from = $(this).attr('data-from');
			var to = $(this).attr('data-to');

			 $('#sms-modal #from-sms').html(from);
			 $('#sms-modal #to-sms').html(to);
			 $('#sms-modal #status-field').html('');
			 if(from=='0') {
			 	$('#sms-modal .pickselect').show();
			 	$('#sms-modal .pick-from').hide();

			 }
			 else {
			 	$('#sms-modal .pickselect').hide();
			 	$('#sms-modal .pick-from').show();
			 }


	        $('#sms-modal').modal({show: true})
		});

		//$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
	});
	
</script>
 <!-- Modal -->
  <div class="modal fade" id="bridge-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Our one click to call feature allows you to call
this customer with your Caller Technologies phone number showing on their caller I.D.To make a call, push the Connect Now! button, this will call your phone, after it detects you answer it will call the
customer and patch you two together.</h4>
        </div>
        <div class="modal-body"> 
        	<div id="status-field"></div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="pickselect" id="fromSelect" style="display:hidden">
        				<select id="select-from" class="form-control" name="select-from-bridge">
						<?php 
						foreach($phoneNumbers as $phoneNumber){
							echo "<option value=".$phoneNumber['phoneNumber']." ".($picked_who==$phoneNumber['phoneNumber']?"selected":"").">".$phoneNumber['friendlyName'].' '.$phoneNumber['campaign_name']."</option>";
						}
						?>								  
						</select>
        			</div>
        			<div class="pick-from">
        				<h4><span id="from-field"></span></h4>
        			</div>
        			
        		</div>
        		<div class="col-md-6 text-right">
        			<h4>To Call: <span id="tocall-field"></span></h4>
        		</div>
        	</div>
        	<hr style="margin:5px 0;" />
        	<h3>Calling via:</h3>
        	<input class="form-control" name="caller-field" id="connect-with" placeholder="Your Phone Number" value="<?php echo $client_details->contact; ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary bridge-now">Connect Now!</button>
          <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">


	$('body').on('click','.send-vcardbtn',function(){
		var pnm = $(this).attr('data-numbr');
		var from = $(this).attr('data-from');
		var posd = {
			number: pnm,
			from: from,
		};

		$.post( '<?php echo site_url('/base/ajax_send_vcard'); ?>',posd)
		  .done(function(res) {
		    //alert( "It worked!" );
		    if(res.status=='success') {
		    	alert("Contact Card Sent!");
		    } else {
		    	alert(res.message)
		    }
		  })
		  .fail(function() {
		    alert( "There was an error! Try again later!" );
		  })
		  .always(function() {

		  });
				 
	});

	$('body').on('click','.send-removerow',function(){
		var cid = $(this).attr('data-cid');
		var redirto= '<?php echo site_url('/clientuser/del_lookup'); ?>/'+cid;
		window.location.href = redirto;
	});
	$('body').on('click','.send-printbtn',function(){
		var pnm = $(this).attr('data-numbr');
		var posd = {
			number: pnm,
		};

		$.post( '<?php echo site_url('/base/ajax_print_num'); ?>',posd)
		  .done(function(res) {
		    //alert( "It worked!" );
		    if(res.status=='success') {
		    	alert("Label printer request sent.");
		    } else {
		    	alert(res.message)
		    }
		  })
		  .fail(function() {
		    alert( "There was an error! Try again!" );
		  })
		  .always(function() {

		  });
				 
	});
	$('body').on('click','.action-demo',function(){
		var pnm = $(this).attr('data-numbr');
		var tosend = '';

	    var nowmail = prompt("Enter an email address");
	    if (nowmail != null) {
	    	tosend = nowmail;
	    	console.log(nowmail);
	    	console.log(tosend);

			var posd = {
				number: pnm,
				tomail: tosend
			};

			$.post( '<?php echo site_url('/base/ajax_send_demographics'); ?>',posd)
			  .done(function(res) {
			    //alert( "It worked!" );
			    if(res.status=='success') {
			    	alert("Advanced Demographic Report has been sent.");
			    } else {
			    	alert(res.message)
			    }
			  })
			  .fail(function() {
			    alert( "There was an error! Try again!" );
			  })
			  .always(function() {

			  });
	    }
				 
	});
	var bridge_call = function(from,to,caller) {

			var postdata = {
				from: from,
				to:  to,
				caller:  caller,
				ajax: 1
			};
		 	$('#bridge-modal #status-field').html('<div class="alert alert-warning"><b>Connecting to your number, please wait...</b></div>');

				$.post( '<?php echo site_url('/base/ajax_bridge_call'); ?>',postdata)
				  .done(function(res) {
				    //alert( "It worked!" );
				    if(res.status=='success') {
		 				$('#bridge-modal #status-field').html('<div class="alert alert-success"><b>Call Started!</b></div>');

				    } else {
		 				$('#bridge-modal #status-field').html('<div class="alert alert-danger"><b>Could not start call!</b></div>');
				    }
				  })
				  .fail(function() {
				    alert( "There was an error! Try again!" );
				  })
				  .always(function() {
					/*textf.val('');
					textf.attr('disabled', false);
					$('#text-msg-form a').attr('disabled', false);*/
				  });
				 
		return true;
	}
	$(document).ready(function(){

        $("#connect-with").mask("(999) 999-9999");



	});


	$('.bridge-call').on('click',function(ev) { // show modal
		ev.preventDefault();
		var from = $(this).attr('data-from');
		var to = $(this).attr('data-to');

		 $('#bridge-modal #from-field').html(from);
		 $('#bridge-modal #tocall-field').html(to);
		 $('#bridge-modal #status-field').html('');
		 if(from=='0') {
		 	$('#bridge-modal .pickselect').show();
		 	$('#bridge-modal .pick-from').hide();

		 }
		 else {
		 	$('#bridge-modal .pickselect').hide();
		 	$('#bridge-modal .pick-from').show();
		 }


        $('#bridge-modal').modal({show: true})
	});
	$('.bridge-now').on('click',function() { // bridge the shit
		var from = $('#from-field').html();
		var to = $('#tocall-field').html();
		var caller = $('#connect-with').val();
		if(from=='0')
			from = $( "#select-from" ).val();

		bridge_call(from,to,caller);
	});

</script>

<script>
	
    function get_model(id) {

        //alert(id);

        $('#myModal' + id).modal({show: true})

    }

    setTimeout(function () {
        $('.hide-open td .title-tabela').on('click', function () {
            el = $(this).parent().parent();
            row = $(this).parent().parent().data('click');
            if ($(el).hasClass('opened-tr')) {

                $('.opened').hide().removeClass('opened')
                $('.opened-tr').removeClass('opened-tr')

            }
            else {
                $(el).addClass('opened-tr')
                $('.opened').hide().removeClass('opened')
                $('.hide-click[data-click="' + row + '"]').addClass('opened').toggle();

            }
            $(this).trigger('prikazano');

        });
		$(document).ready(function(){
			$(document).on('keyup change','.dataTables_filter .input-sm',function(){
				var value = $(this).val().trim();
				if(value != ''){
				$('#caller_lookups_data_table tr.hide-open').hide();
				$('#caller_lookups_data_table tr.hide-open:contains("'+value+'")').show();
				}
				else{
					$('#caller_lookups_data_table tr.hide-open').show();
				}	
			});
		});
    }, 1000);

    function playTone(filename){   
        document.getElementById("soundTone").innerHTML='<audio autoplay="autoplay"><source src="' + filename + '.mp3" type="audio/mpeg" /><source src="' + filename + '.ogg" type="audio/ogg" /></audio>';
    }
            
    var unreadSMS = function() {
		$.ajax({
		       url : '<?php echo base_url(); ?>clientuser/ajax_get_unread_text',
		       type : 'GET',
		       processData: true,  // tell jQuery not to process the data
		       success : function(data) {
		       		var $btnProm;
					$('[data-notifsms]').removeClass('btn-newsms');
					if(data.length>0) {
				    	// playTone('/assets/received_sms');
					}
				    $.each(data, function(i,v) {

				    	$brnProm = $('[data-notifsms="'+v.phoneNumber+'"]')
				    	//$brnProm.append(v.cnt);
				    	$brnProm.addClass('btn-newsms');
				    });
		       }
		});
    }
    	unreadSMS();
    setInterval(function () {
    	unreadSMS();
    }, 90000);
    <?php if($send_custom_audience ) { ?>
    setInterval(function () {
        $.ajax({
            url: "<?php echo base_url(); ?>base/lookup_incoming_calls",
            type: "get",
        })

    }, 30000)
    <?php } ?>

</script>
<style>
    #data-table, #data-table_info, #data-table_paginate {
        display: none;
    }
</style>

<?php if($picked_prvi!=''): ?>
<script type="text/javascript">

var refreshChat = null;
var send_sms = function send_sms(sfrom, sto, smess) {
		var textf = $('#text-msg-form textarea');

	var msgcnt = textf.val().length;
	if (msgcnt > 0) {
		//$('#rpfrm-'+smsid).submit();
		textf.attr('disabled', true);
		$('#text-msg-form a').attr('disabled', true);

		var postdata = {
			msg: smess,
			from: sfrom,
			to: sto,
			ajax: 1
		};
		if ($('.attached-file').length) {
			postdata.fileName = $('.attached-file').html();
			postdata.fileNewName = $('.attached-file').attr('data-fileNewName');
			postdata.fileType = $('.attached-file').attr('data-type');
		}

		$.post('<?php echo site_url('/base/send_sms'); ?>', postdata).done(function (res) {
			//alert( "It worked!" );
			if (res.status == 'success') {
				$('<div/>', {
					'class': 'text-message sent clearfix',
					'html': $('<div/>', {
						'html': '<small>Sending...</small>',
						'class': 'message-bubble'
					})
				}).appendTo('#text-message-list');
				get_sms(sfrom, sto);
				playTone('/assets/sent_sms');
			} else {
				$('<div/>', {
					'class': 'text-message sent clearfix danger',
					'html': $('<div/>', {
						'html': smess + '<br/><b>Message Not Send!</b>',
						'class': 'message-bubble'
					})
				}).appendTo('#text-message-list');
			}
		}).fail(function () {
			alert("There was an error! Try again!");
		}).always(function () {
			textf.val('');
			textf.attr('disabled', false);
			$('#text-msg-form a').attr('disabled', false);

			$('#text-msg-form .label').remove();
		});
	} else {
		alert("1 Character Minimum");
	}
	return true;
};
var get_sms = function get_sms(sfrom, sto) {
	var listsms = $('#text-message-list');
	//$('#rpfrm-'+smsid).submit();
	listsms.attr('disabled', true);

	var postdata = {
		ajax: 1
	};

	$.post('<?php echo base_url('/clientuser/view_messages');?>/' + sfrom + '/' + sto, postdata).done(function (res) {
		//alert( "It worked!" );
		//console.log(res);

		var dod = $('<div/>');
		$.each(res, function (i, v) {
			var fajlovi = '';
			//console.log(v);
			if (parseFloat(v.mms_num_files) > 0) {
				fajlovi = '<br/>';
				for (var i = 0; i < parseFloat(v.mms_num_files); i++) {
					console.log(v.media_urls);
					fajlovi = fajlovi + '<span class="mms-file"><i class="fa fa-file-' + v.media_urls[i]['mediaTypeGroup'] + '-o"></i> <a href="' + v.media_urls[i]['mediaUrlShort'] + '"  target="_blank" download> M' + v.id + '_' + (i + 1) + '.' + v.media_urls[i]['mediaTypeNice'] + '</a>, </span>';
				}
			}
			var cls = 'text-message sent clearfix';
			if (this.direction == 'in') var cls = 'text-message received clearfix';

			if (v.is_read == '0' && v.direction == 'in') playTone('/assets/received_sms');

			$('<div/>', {
				'class': cls,
				'html': $('<div/>', {
					'html': this.message + fajlovi,
					'class': 'message-bubble'
				})
			}).appendTo(dod);
		});
		$('#text-message-list').html(dod);
		$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
		if (res.status == 'success') {
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
	}).fail(function () {
		console.log("There was an error with the refresh!");
	}).always(function () {
		/*textf.val('');
  textf.attr('disabled', false);
  $('#text-msg-form a').attr('disabled', false);*/
	});

	return true;
};
$(document).ready(function () {
	var ObradiChat = function ObradiChat(froms, tos) {

		$('.sendNewText').on('click', function (ev) {
			var textf = $('#text-msg-form textarea');
			send_sms(textf.attr('data-from'), textf.attr('data-to'), textf.val());
			ev.preventDefault();
		});
		$('#attachFile').on('click', function (ev) {
			$('#file_pick').trigger('click');
		});
		$('#file_pick').on('change', function (ev) {
			if ($('#file_pick').val() == '') return false;

			var formData = new FormData();
			formData.append('file', $('#file_pick')[0].files[0]);
			/*if($('#text-msg-form').attr('data-files-attc') > 1 ) {
   	return false;
   }*/
			var textf = $('#text-msg-form textarea');
			textf.attr('disabled', true);
			$('#text-msg-form a').attr('disabled', true);

			$.ajax({
				url: '<?php echo base_url(); ?>clientuser/upload_mms_file',
				type: 'POST',
				data: formData,
				processData: false, // tell jQuery not to process the data
				contentType: false, // tell jQuery not to set contentType
				success: function success(data) {
					//console.log(data);
					// alert(data);
					$('#file_pick').val('');
					if (data.status == 'success') {
						var fileName = data.fileUploaded.client_name;
						var fileNewName = data.fileUploaded.file_name;
						var file_type = data.fileUploaded.file_type;
						$('#text-msg-form .label').remove();

						$('<span/>', {
							'class': 'label label-warning attached-file',
							'html': '<b>Attached: </b>' + fileName,
							'data-fileNewName': fileNewName,
							'data-type': file_type
						}).prependTo('.submit-btn-wrap');
						textf.attr('disabled', false);
						$('#text-msg-form a').attr('disabled', false);
					} else {
						$('#text-msg-form a').attr('disabled', false);
						textf.attr('disabled', false);
						alert(data.message);
					}
				}
			});
			ev.preventDefault();
		});
	};

	var PrikaziChat = function PrikaziChat(froms, tos) {
		console.log(froms);
		console.log(tos);
		$('#sms-list').remove();
		var prik = '\n\t\t\t  <div class="clearfix"></div><div class="smschat-insert" id="sms-list"><div id="sms-list-end" class="clearfix"> </div>\n\t\t\t   <div class="col-md-12 text-message-wrapper">\n\t\t\t\t\t<div class="text-message-window clearfix" id="text-message-list" style="max-height:240px">\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t\t<div class="form-group">\n\t\t\t        \t<div id="text-msg-form" data-files-attc="0">\n\t\t\t    \t\t<br/>\n\t\t\t\t\t\t  <label for="reply-msg"></label>\n\t\t\t\t\t\t  <textarea class="form-control" rows="2" id="text-msg-content" name="text-msg" data-from="' + froms + '" data-to="' + tos + '"></textarea>\n\t\t\t\t\t\t  <div class="submit-btn-wrap">\n\t\t\t\t\t\t  <br/>\n\t\t\t\t\t\t  \t<a style="margin-top:2px;" class="btn btn-primary sendNewText" href="#">Send SMS Text</a>\n\t\t\t\t\t\t  \t<a class="btn btn-secondary btn-sm pull-right" id="attachFile">Add File <i class="fa fa-upload"></i></a>\n\t\t\t\t\t\t  </div>\n\t\t\t\t\t\t  <div style="opacity:0;height:0;width:0;overflow:hidden;" id="file-picker">\n\t\t\t\t\t\t\t<input type="file" id="file_pick" name="file_pick" />\n\t\t\t\t\t\t  </div>\n\t\t\t\t\t  \t</div>\n\t\t\t\t\t</div>\n\t\t\t  </div>\n\t\t\t';
		$('.hide-click.opened .home_page_lookup').append(prik);
		ObradiChat(froms, tos);
		get_sms(froms, tos);

		if (refreshChat != null) {
			clearInterval(refreshChat);
		}

		refreshChat = setInterval(function () {
			get_sms(froms, tos);
		}, 60000);
		$("#text-message-list").scrollTop($("#text-message-list")[0].scrollHeight);
	};

	$('.hide-open td .title-tabela').on('prikazano', function () {
		var tos = $(this).attr('data-od');
		var froms1 = '<?php echo $picked_prvi;?>';
		var froms = $(this).attr('data-from');
		if (froms == 0) froms = froms1;
		PrikaziChat(froms, tos);
	});

	// if one number showcase page
	<?php if($view_one_number): ?>
		var tos = '<?php echo $cread['phoneNumber'];?>';
		var froms1 = '<?php echo $picked_prvi;?>';
		PrikaziChat(froms1, tos);
	<?php endif; ?>

	(function($) {
    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top -122 + 'px'
        }, 'fast');
        return this; // for chaining...
    }
	$('.send-smsbtnnow').on('click', function () {

	    el = $(this).closest('tr');
	    row = el.data('click');
	    if ($(el).hasClass('opened-tr')) {

	        $('.opened').hide().removeClass('opened')
	        $('.opened-tr').removeClass('opened-tr')

	    }
	    else {
	        $(el).addClass('opened-tr')
	        $('.opened').hide().removeClass('opened')
	        $('.hide-click[data-click="' + row + '"]').addClass('opened').toggle();
	    }

		var tos = $(this).attr('data-od');
		var froms1 = '<?php echo $picked_prvi;?>';
		var froms = $(this).attr('data-from');
		if (froms == 0) froms = froms1;
		PrikaziChat(froms, tos);
		$('#sms-list-end').goTo();
	});
})(jQuery);
});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php endif;?>