                    <?php //print_r($friendlyName);?>
                      
			    <!-- begin col-10 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered display" cellspacing="0" width="100%">
									<thead class="bg-silver-lighter">
										<tr>
                                            <th><?php echo get_phrase('Sr/No')?></th>
                                            <th><?php echo get_phrase('Call Time')?></th>
                                            <th><?php echo get_phrase('Called')?></th>
                                            <th><?php echo get_phrase('To_State')?></th>
											<th><?php echo get_phrase('Caller_Country')?></th>
                                            <th><?php echo get_phrase('Direction')?></th>
                                            <th><?php echo get_phrase('Caller_State')?></th>
                                            <th><?php echo get_phrase('To_call')?></th>
                                            <th><?php echo get_phrase('Caller_Zip')?></th>
                                            <th><?php echo get_phrase('To_Country')?></th>
                                            <th><?php echo get_phrase('Call_Status')?></th>
                                            <th><?php echo get_phrase('From_call')?></th>
                                            <th><?php echo get_phrase('Called_Country')?></th>
                                            <th><?php echo get_phrase('Caller_City')?></th>
                                            <th><?php echo get_phrase('Caller')?></th>
                                            <th><?php echo get_phrase('From_Country')?></th>
                                            <th><?php echo get_phrase('From_City')?></th>
                                            <th><?php echo get_phrase('Called_State')?></th>
                                            <th><?php echo get_phrase('From_Zip')?></th>
                                            <th><?php echo get_phrase('From_State')?></th>
										</tr>
									</thead>
									<tbody>
                                    <?php // Loop over the list of calls and echo a property for each one 
									//print_r($calls_read['startTime']);print_r($calls_read['endTime']);?>
                                    <?php $counter=1; foreach($income_calls as $res) { ?>
										<tr>
                                             <td><?php echo $counter?></td>
                                             <td><?php echo $res['call_time']?></td>
                                             <td><?php echo $res['Called']?></td>
                                             <td><?php echo $res['ToState']?></td>
                                             <td><?php echo $res['CallerCountry']?></td>
                                             <td><?php echo $res['Direction']?></td>
                                             <td><?php echo $res['CallerState']?></td>
                                             <td><?php echo $res['To_call']?></td>
                                             <td><?php echo $res['CallerZip']?></td>
                                             <td><?php echo $res['ToCountry']?></td>
                                             <td><?php echo $res['CallStatus']?></td>
                                             <td><?php echo $res['From_call']?></td>
                                             <td><?php echo $res['CalledCountry']?></td>
                                             <td><?php echo $res['CallerCity']?></td>
                                             <td><?php echo $res['Caller']?></td>
                                             <td><?php echo $res['FromCountry']?></td>
                                             <td><?php echo $res['FromCity']?></td>
                                             <td><?php echo $res['CalledState']?></td>
                                             <td><?php echo $res['FromZip']?></td>
                                             <td><?php echo $res['FromState']?></td>
										</tr>
									<?php $counter++; } ?>
									</tbody>
                           </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-10 -->
                      
