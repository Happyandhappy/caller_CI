
<div class="row">
	<div class="col-md-4 col-md-push-1">

		<div class="alert alert-primary" style="margin-top:35px;border: 1px dotted #cecece;background: #fcfcfc;">
			<h2 style="margin-top:0px"><span style="font-size: 20px;">Balance:</span>
			<span class="pull-right" <?php echo $acc_balance<0 ? 'style="color:red"': ''; ?>><?php echo $acc_balance<0 ? '-': ''; ?> $<?php echo abs($acc_balance); ?></span></h2>
		</div>
	</div>
<?php

		$frm_url = base_url() . 'payment/topup_payment';
		$value= 5;
		echo $notification = '
		<div class="col-md-4 col-md-push-3">
			<div style="padding-right:30px;">
				<h4> Add more funds to your account!</h4>
				<p> Please add funds to your account</p>
				<p> 
					<form class="form-inline" name="frm_payment" id="frm_payment" method="post" action="' . $frm_url . '" onSubmit="return validate_amt();" >
						<div class="input-group m-r-10">
      						<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input type="text"  class="form-control" name="topup_amount" id="topup_amount" value="'.$value.'" required placeholder="Enter amount" >
						</div>
						<input type="submit" class="btn btn-md btn-primary m-r-5" name="pay_submit" id="pay_submit" value="Pay">
					</form>
				</p>
			</div>
		</div>';
?>
</div>
<?php $this->load->view('clientuser/account_plan_prices');