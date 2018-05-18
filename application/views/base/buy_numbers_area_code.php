<?php 
$this->db->select('*');
$this->db->from('client_phonenumber_purchased');                    
$this->db->where(array('status'=>'active','client_id' => $this->session->userdata('login_user_id')));
$query = $this->db->get();
$phones = $query->result_array();
?>
<table class="table table-condensed bg-silver">
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

			for($j=0; $j<count($local['friendlyName']);$j++){?>
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
                                <button type="submit" name="Buynumber"  class="submit_buy_number btn btn-white btn-sm">Get<span class="hidden-xs"> Number</span></button>   
                            </form>
                        </td>
                    </tr>
			<?php }

		}else{?>
		<tr>
			<td class="p-r-5 center" colspan="8">No Data selected.</td>
		</tr>
		<?php }?>

		<!-- LISTING OF TOLL FREE NUMBERS -->
	</tbody>
</table>

<script>
	jQuery('#buy-numbers-container button').on('click', function(){
		var incId = jQuery(this).attr('rel');
		var campaign_name = jQuery("#campaign_name"+incId).val();
		var phonenumber = jQuery("#phonenumber"+incId).val();
		var country = jQuery("#country"+incId).val();
		var number_price = jQuery("#number_price"+incId).val();
		if( campaign_name == ''){
			$("buyNumErr"+incId).show();
			return false;
		}
		$.ajax({
                url: "<?php echo base_url() ?>clientuser/buy_number",
                type: "post",
                data: {
                    campaign_name: campaign_name,
					phonenumber: phonenumber,
					country: country,
					number_price: number_price
                },
                success: function (response) {
                    window.location.href = "<?php echo base_url() ?>clientuser/buy_number/"+phonenumber;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
	})
</script>