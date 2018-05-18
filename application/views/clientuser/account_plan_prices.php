<div class="row clearfix">
 <div class="col-md-6">
   <table class="table table-bordered">
      <thead>
        <tr>
          <th class="warning">Service</th>
          <th class="warning">Price</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($service_list1 as $name => $price) { ?>
        <tr>
          <td class="active"><?php echo $name; ?></td>
          <td>$ <?php echo $price; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
 <div class="col-md-6">
   <table class="table table-bordered">
      <thead>
        <tr>
          <th class="warning">Service</th>
          <th class="warning">Price</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($service_list2  as $name => $price) { ?>
        <tr>
          <td class="active"><?php echo $name; ?></td>
          <td>$ <?php echo $price; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>