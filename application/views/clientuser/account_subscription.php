<div class="row clearfix">
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
          <td><?php echo $service['count']; ?></td>
          <td><?php echo $service['max']; ?></td>
          <td style="width:50%">
            <?php 
            if($service['count']==0 && $service['max'] == 0) {
              $procent = 100;
              $procenat2 = '100%';
              $label = 'Not available';
            }
            else if($service['count']==0) {
              $procent = 0;
              $procenat2 = '0%';
              $label = $procenat2;
            }
            else {
              $procent = round( ($service['count']/$service['max']*100),2 );
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