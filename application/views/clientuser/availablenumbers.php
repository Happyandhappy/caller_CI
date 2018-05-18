<?php 
$this->db->select('*');
$this->db->from('client_phonenumber_purchased');                    
$this->db->where(array('status'=>'active','client_id' => $this->session->userdata('login_user_id')));
$query = $this->db->get();
$phones = $query->result_array();
?>
<div class="profile-section">
    <div class="row">    
        <?php if(isset($system_error)){?>
            <div class="well bg-red-lighter">
                <?php echo $system_error;?>
            </div>
        <?php }?>
    <div class="col-md-12">
        <div class="well bg-silver-lighter">
            <div id="step1" role="tabpanel" class="bwizard-activated" aria-hidden="false">
                <fieldset>
                    <legend class="pull-left width-full" style="position:relative; padding-bottom: 50px;">
                        <div class="col-md-6" style="position:static;">
                            <div><h4 style="font-size:15px;"><b>You have used <?php echo count($phones); ?> of your <?php echo $charges['max_phone_numbers']; ?> allowed numbers</b></h4></div>
                            <h4 class="col-md-6" style="position:absolute;bottom:0;left:0;font-size:15px;">Enter the Area Code for your <?php echo str_replace(array('LLC', 'llc', ','), '',  $site_settings['system_name']); ?> number: </h4>
                        </div>
                        <div class="col-md-6" style="text-align:left;">
							<div class="col-md-12 col-sm-12" style="font-size:18px;">Your <?php echo str_replace(array('LLC', 'llc', ','), '',  $site_settings['system_name']); ?>Numbers are:</div>
							<div class="col-md-12 col-sm-12" style="font-size:16px;color:#a1a1a1;margin-top:5px">
							<?php
								foreach($phones as $phone) {
									 echo '<div><b>'.$phone['friendlyName'].'</b> - <span style="font-size:85%">'.$phone['campaign_name'].'</span></div>'; 									 
								}
							?>							
							</div>                            
                        </div>
                    </legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-3">
                            <input  type="text" class='form-control' maxlength='3' placeholder='Area Code' name='areacode' id='areacode'> 
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <input  type="text" class='form-control' maxlength='12' placeholder='Vanity Search' name='searchfor' id='searchfor'> 
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <button class='btn button-area-code btn-info btn-sm'>Search</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>    
        <div data-scrollbar="false" id='buy-numbers-container' data-height="700px" class="bg-silver"> 
            <table class="table table-condensed bg-silver" style="table-layout:auto">      
                <thead class="bg-silver-lighter">
                    <tr>
                        <th><span class="hidden-xs">Phone </span>Number</th>
                        <th>Campaign Name</th>
                        <th class="hidden-sm hidden-xs">Forward Calls To</th>
                        <th class="hidden-sm hidden-xs">Forward Messages To</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($local['friendlyName']) > 0){
			     for($j=0; $j<count($local['friendlyName']);$j++){ ?>
                    <tr>
                        <td><h5 class="m-t-0 m-b-5 avail-nicenum"><b><?php echo $local['friendlyName'][$j];?></b></h5>
                        </td>
                        <td style="position:relative;">

                                <input type="text" name="campaign_name" class="buy_number_box camp_forw" value="" placeholder="Campaign Name"   style="display: inline-block;margin: 5px 0px;padding: 5px;width:auto;max-width: 240px;" required/>
                        </td>
                        <td class="hidden-sm hidden-xs">
                                <input type="text" name="call_forward_no" class="cust_phone_no call_forw" value="<?php echo $phones[0]['call_forward_no'];?>" placeholder="Forward Calls To"   style="display: inline-block;margin: 5px 0px;padding: 5px;width: 110px;"/>
                        </td>
                        <td class="hidden-sm hidden-xs">
                                <input type="text" name="sms_forward_no" class="cust_phone_no sms_forw" value="<?php echo $phones[0]['sms_forward_no']; ?>" placeholder="Forward SMS To"  style="display: inline-block;margin: 5px 0px;padding: 5px;width: 110px;"/>
                        </td>
                        <td>

                            <form name="sendnumber" action="<?php echo base_url()."clientuser/buy_number"?>" method="post">
                                <input type="hidden" value="0" name="checkform" id="checkform" />
                                <input type="hidden" name="phonenumber" value="<?php echo  $local['phoneNumber'][$j] ;?>" />
                                <input type="hidden" name="country" value="<?php echo 'US';?>" />
                                <input type="hidden" name="sms_forward_no" value="<?php echo $phones[0]['sms_forward_no'];?>" />
                                <input type="hidden" name="call_forward_no" value="<?php echo $phones[0]['call_forward_no'];?>" />
                                <input type="hidden" name="campaign_name" value="New Campaign" />
                                <input type="hidden" name="number_price" value="<?php echo $number_price;?>" />
                                <button type="submit" name="Buynumber"  class=" submit_buy_number btn btn-white btn-sm">Get<span class="hidden-xs"> Number</span></button>   
                            </form>
                        </td>
                    </tr>
                <?php }
                }else{?>
                      <tr>
                        <td class="p-r-5 center" colspan="8">No Data selected.</td>
                      </tr>
                <?php }?>         
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	$('body').on('click','.submit_buy_number',function(){
		var value = $(this).parent().find('.buy_number_box').val().trim();
		if( value == ''){
			$(this).parent().find('.buy_number_error').show();
			return false;
		}else{
			return true;
			//$(this).parent().parent().find('form').submit();
		}
	});
	$('body').on('click','.buy_number_box',function(){		
		$(this).parent().parent().find('.buy_number_error').hide();			
	});
    $('body').on('change','.camp_forw',function(){  
        $(this).parent().parent().find('form input[name="campaign_name"]').val($(this).val());
    });
    $('body').on('change','.call_forw',function(){  
        $(this).parent().parent().find('form input[name="call_forward_no"]').val($(this).val());
    });
    $('body').on('change','.sms_forw',function(){  
        $(this).parent().parent().find('form input[name="sms_forward_no"]').val($(this).val());
    });

});
</script>