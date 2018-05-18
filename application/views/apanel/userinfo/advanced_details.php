 <div class="profile-section">
                    <!-- begin row -->
                    <div class="row">
                    <?php //print_r($friendlyName);?>
                      
			    <!-- begin col-10 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-body">
                    <table class="table table-bordered table-striped table-ajeitada-1" id="data-table" width="100%" style="cell-spacing;">
                                <!-- $page_data['friendlyName']= $friendlyName;$page_data['phoneNumber']= $phoneNumber;
			$page_data['lata']= $lata;
			$page_data['region']= $region;
			$page_data['country']= $country;-->
									<thead class="bg-silver-lighter p-10">
										<tr>
                            <th width=""><?php echo strtoupper(get_phrase('Sr/No.')) ?></th>
                            <th><?php echo strtoupper(get_phrase('First Name')) ?></th>                            
                            <th><?php echo strtoupper(get_phrase('Middle Initial')) ?></th>                            
                            <th><?php echo strtoupper(get_phrase('Last Name')) ?></th>                            
                            <th class=""><?php echo strtoupper(get_phrase('Number')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('date')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('lookup status')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('caller_type')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('age')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('education')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('gender')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('high_net_worth')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('home_owner_status')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('household_income')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('phone_carrier')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('phone_line_type')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('country_Code')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('national_Format')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('length_of_residence')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('marital_status')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('market_value')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('occupation')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('presence_of_children')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('address')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Mobile Country Code ')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Mobile Network Code ')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Wireless Name ')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Mobile Type ')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Number')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Carrier')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Line Type')) ?></th>
							
                            <th class=""><?php echo strtoupper(get_phrase('City')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Address Extended Zip')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Country')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Address Line 1')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Address Line 2')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('State')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('Zip Code')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('email 1')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('email 2')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('email 3')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('email 4')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('email 5')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('facebook')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('twitter')) ?></th>
                            <th class=""><?php echo strtoupper(get_phrase('linkedin')) ?></th>
                            
                        </tr>
									</thead>
									<tbody>
                                    <?php // Loop over the list of calls and echo a property for each one ?>
                                    <?php if(count($advance_calls) > 0){
										$j =1;
											foreach($advance_calls as $cread){
												?>
										<tr>
										<td class="p-r-5"><?php echo $j++; ?></td>
                                
										<td><?php echo ucwords($cread['first_name']); ?></td>
										<td><?php echo ucwords($cread['middle_name']); ?></td>
										<td><?php echo ucwords($cread['last_name']); ?></td>
                                        <td><?php echo ucwords($cread['nationalFormat']); ?></td>
										<td><?php echo date("m-d-Y H:i:s", strtotime($cread['call_date'])); ?></td>
                                        <td><?php echo ucwords($cread['status']); ?></td>
                                        <td><?php echo ucwords($cread['caller_type']); ?></td>
                                        <td><?php echo ucwords($cread['age']); ?></td>
                                        <td><?php echo ucwords($cread['education']); ?></td>
                                        <td><?php echo ucwords($cread['gender']); ?></td>
                                        <td><?php echo ucwords($cread['high_net_worth']); ?></td>
                                        <td><?php echo ucwords($cread['home_owner_status']); ?></td>
                                        <td><?php echo ucwords($cread['household_income']); ?></td>
                                        <td><?php echo ucwords($cread['phone_carrier']); ?></td>
                                        <td><?php echo ucwords($cread['phone_line_type']); ?></td>
                                        <td><?php echo ucwords($cread['countryCode']); ?></td>
                                        <td><?php echo ucwords($cread['nationalFormat']); ?></td>
                                        <td><?php echo ucwords($cread['length_of_residence']); ?></td>
                                        <td><?php echo ucwords($cread['marital_status']); ?></td>
                                        <td><?php echo ucwords($cread['market_value']); ?></td>
                                        <td><?php echo ucwords($cread['occupation']); ?></td>
                                        <td><?php echo ucwords($cread['presence_of_children']); ?></td>
                                        <td>
                                                 <?php  
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
                                        ?>
                                        <?php $address_string = ''; 
                                                $address_string .= (ucwords($addr['line1'])) ? ucwords($addr['line1']) . ',  ' : ''; ?>
                                        <?php $address_string .= (ucwords($addr['line2'])) ? ucwords($addr['line2']) . ',  ' : ''; ?>
                                        <?php $address_string .= (ucwords($addr['city'])) ? ucwords($addr['city']) . '  ' : ''; ?>
                                        <?php $address_string .= (ucwords($addr['state'])) ? ucwords($addr['state']) . '  ' : ''; ?>
                                        <?php $address_string .= (ucwords($addr['zip_code'])) ? ucwords($addr['zip_code']) . '-' : '0000'; ?>
                                        <?php $address_string .= (ucwords($addr['extended_zip'])) ? ucwords($addr['extended_zip']) . '  ' : ''; ?>
                                        <?php $address_string .= (ucwords($addr['country'])) ? ucwords($addr['country']) . ' ' : ''; ?>
                                        <?php if( !empty( $address_string ) ){ ?>
                                        <a href="https://www.google.com/maps/place/<?=urlencode($address_string) ?>" target="_blank" style="display:block;color:#337ab7;">
                                            <?=$address_string ?>  
                                        </a>
                                        <?php } } ?> 
                                               

										</td>
                                        
                                        <?php 
										$data = explode('#', $cread['carrier']);
										$carrier_data = array();
                                        foreach ($data as $res) { 
											$data2 = explode('=', $res); 
											$carrier_data[$data2[0]] = $data2[1];
										}
										
										if( isset($carrier_data['mobile_country_code']) ){
											echo "<td>".$carrier_data['mobile_country_code']."</td>";
											
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['mobile_network_code']) ){
											echo "<td>".$carrier_data['mobile_network_code']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['name']) ){
											echo "<td>".$carrier_data['name']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['type']) ){
											echo "<td>".$carrier_data['type']."</td>";
										}
										else{
											echo "<td></td>";
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
											echo "<td>".($us?'1':'0').$carrier_data['number']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['carrier']) ){
											
											echo "<td>".$carrier_data['carrier']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['line_type']) ){
											echo "<td>".$carrier_data['line_type']."</td>";
										}
										else{
											echo "<td></td>";
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
											echo "<td>".$carrier_data['city']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['extended_zip']) ){
											echo "<td>".$carrier_data['extended_zip']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['country']) ){
											echo "<td>".$carrier_data['country']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['line1']) ){
											echo "<td>".$carrier_data['line1']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['line2']) ){
											echo "<td>".$carrier_data['line2']."</td>";
										}
										else{
											echo "<td></td>";
										}
										if( isset($carrier_data['state']) ){
											echo "<td>".$carrier_data['state']."</td>";
										}
										else{
											echo "<td></td>";
										}
										
										if( isset($carrier_data['zip_code']) ){
											echo "<td>".$carrier_data['zip_code']."</td>";
										}
										else{
											echo "<td></td>";
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
											echo "<td>".$ema."</td>";
										}
										for($i=count($emails);$i<5;$i++){
											echo "<td></td>";
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
											echo "<td>".$links['facebook']."</td>";
										}
										else{
											echo "<td></td>";
										}
										
										if( isset($links['twitter']) ){
											echo "<td>".$links['twitter']."</td>";
										}
										else{
											echo "<td></td>";
										}
										
										if( isset($links['linkedin']) ){
											echo "<td>".$links['linkedin']."</td>";
										}
										else{
											echo "<td></td>";
										}
										 
										 ?> 
                                
                            </tr>
                                        <?php }
										}else{?>
                                        <tr>
										    <td class="p-r-5" colspan="4">No Data selected.</td>
                                            </tr>
									<?php }?>
									</tbody>
								</table>
					</div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-10 -->
                     </div>
                    <!-- end row -->
                </div>
                     
