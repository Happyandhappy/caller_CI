<div class="row clearfix">
 <div class="col-md-12">
    <div class="alert alert-warning">
      <p class="lead">
        <u><?php echo $usrinf->first_name;?> <?php echo $usrinf->last_name;?><u> is running the <b><?php echo $plan_details['package_name'] ?></b> plan @ <b>$<?php echo $month_paid;  ?> / month</b> <br/><u>Max</u> Costs for this plan is <b>$<?php echo $max_plan_cost; ?></b><i title="Details for Costs" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="hover" data-content="<?php foreach($service_list as $name => $service) { ?>
          <p><?php echo $name; ?> <span class='pull-right' style='padding-left:5px'>$<?php echo $service['max_cost']; ?></span></p>
        <?php } ?>" class="fa fa-info-circle" style="font-size:15px;vertical-align:top;margin-left:3px"></i> (for one month), with <b>$<?php echo  $cost_sum; ?> (<?php echo  round(($cost_sum/$max_plan_cost*100),2); ?>%)</b> billed this month to you.
      </p>
      <p class="lead">
        You have been paid by this user <b>$<?php echo  $total_paid; ?></b>, and earned in total <b>$<?php echo  ($total_paid_paypal-$cost_total_sum); ?></b>.<i data-toggle="popover" data-trigger="hover" data-content="All Subscriptions earnings, Paypal & Call Provider Costs are included in this number." class="fa fa-info-circle" style="font-size:15px;vertical-align:top;margin-left:3px"></i> This user has been subscribed for <?php echo $numpayments; ?> months.
      </p>
    </div>
    <?php  if( !($total_paid_paypal-$cost_total_sum) <0) :  ?>
    <div class="alert alert-warning">

      <p class="lead">
        <b>You are losing money on this user!</b>
      </p>
    </div>
    <?php endif; ?>
 </div>
</div>
<div class="row clearfix">
 <div class="col-md-12">
  <h2>Costs and Profit</h2>
 </div>
 <div class="col-md-12">
   <table class="table table-bordered">
      <thead>
        <tr>
          <th class="warning">Service</th>
          <th class="warning">Used This Month</th>
          <th class="warning">Used Total</th>
          <th class="warning">This Month</th>
          <th class="warning">Total</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($service_list as $name => $service) { ?>
        <tr>
          <td class="active"><?php echo $name; ?></td>
          <td><?php echo $service['count']; ?></td>
          <td><?php echo $service['count_total']; ?></td>
          <td>$<?php echo $service['cost']; ?></td>
          <td>$<?php echo $service['cost_total']; ?></td>
        </tr>
        <?php } ?>
        <tr style="font-size:18px;">
          <td>Costs</td>
          <td></td>
          <td></td>
          <td>$<?php echo  ($cost_sum); ?> <i title="Details for Costs" data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="<?php foreach($service_list as $name => $service) { ?>
          <p><?php echo $name; ?> <span class='pull-right' style='padding-left:5px'><?php echo round(($service['cost']/$cost_sum*100),2); ?>%</span></p>
        <?php } ?>" class="fa fa-info-circle" style="font-size:15px;vertical-align:top;margin-left:10px"></i></td>
          <td>$<?php echo  $cost_total_sum; ?> <i title="Details for Costs" data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="<?php foreach($service_list as $name => $service) { ?>
          <p><?php echo $name; ?> <span class='pull-right' style='padding-left:5px'><?php echo round(($service['cost_total']/$cost_total_sum*100),2); ?>%</span></p>
        <?php } ?>" class="fa fa-info-circle" style="font-size:15px;vertical-align:top;margin-left:10px"></i></td>
        </tr>
        <tr style="font-size:18px;">
          <td>Subscription <small>(without paypal costs)</small></td>
          <td></td>
          <td></td>
          <td>$<?php echo  $month_paid; ?></td>
          <td>$<?php echo  $total_paid; ?></td>
        </tr>
        <tr style="font-size:18px;">
          <td>Paypal Costs</td>
          <td></td>
          <td></td>
          <td>$<?php echo  $month_paypal; ?></td>
          <td>$<?php echo  $total_paypal; ?></td>
        </tr>
        <tr style="font-size:18px;">
          <td>Subscription <small>(with paypal costs)</small></td>
          <td></td>
          <td></td>
          <td>$<?php echo  $month_paid_paypal; ?></td>
          <td>$<?php echo  $total_paid_paypal; ?></td>
        </tr>
        <tr style="font-size:18px;">
          <td class="active"><b>Profit</b></td>
          <td class="active"></td>
          <td class="active"></td>
          <td class="active"><b>$<?php echo  ($month_paid_paypal-$cost_sum); ?></b></td>
          <td class="active"><b>$<?php echo  ($total_paid_paypal-$cost_total_sum); ?></b><!--<i title="Details for Earnings" data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="<?php foreach($service_list as $name => $service) { ?>
          <p><?php echo $name; ?> <span class='pull-right' style='padding-left:15px'>2%</span></p>
        <?php } ?>" class="fa fa-info-circle" style="font-size:15px;vertical-align:top;margin-left:10px"></i>--></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


<div class="row clearfix">
 <div class="col-md-12">
  <h2>Usage Statistics (this month)</h2>
 </div>
 <div class="col-md-12">
   <table class="table table-bordered">
      <thead>
        <tr>
          <th class="warning">Service</th>
          <th class="warning">Used</th>
          <th class="warning">Max</th>
          <th class="warning">Usage (%)</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($service_list as $name => $service) { ?>
        <tr>
          <td class="active"><?php echo $name; ?></td>
          <td><?php echo ($name== 'Phone Numbers' ? $service['count_total'] : $service['count']); ?></td>
          <td><?php echo $service['max']; ?></td>
          <td style="width:50%">
            <?php 
            if(($name== 'Phone Numbers' ? $service['count_total'] : $service['count'])==0 && $service['max'] == 0) {
              $procent = 100;
              $procenat2 = '100%';
              $label = 'Not available';
            }
            else if(($name== 'Phone Numbers' ? $service['count_total'] : $service['count'])==0) {
              $procent = 0;
              $procenat2 = '0%';
              $label = $procenat2;
            }
            else {
              $procent = round( (($name== 'Phone Numbers' ? $service['count_total'] : $service['count'])/$service['max']*100),2 );
              $procenat2 = $procent .'%';
              $label = $procenat2;
            }
            ?>

            <div class="progress" style="margin:0;">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $procent; ?>" aria-valuemin="0" aria-valuemax="<?php echo $service['max']; ?>" style="width:<?php echo $procenat2; ?>">
                <?php echo $label; ?>
              </div>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>