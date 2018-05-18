<div class="panel-body">

	  <?php if($this->session->flashdata('success')){ ?>

		<div class="alert alert-success fade in">

            <button type="button" class="close" data-dismiss="alert">

                <span aria-hidden="true">�</span>

            </button>

            <?php echo $this->session->flashdata('success');?>

        </div>

	  <?php } if($this->session->flashdata('error')){ ?>

		<div class="alert alert-danger fade in">

            <button type="button" class="close" data-dismiss="alert">

                <span aria-hidden="true">�</span>

            </button>

            <?php echo $this->session->flashdata('error');?>

        </div>

	  <?php } ?>

  <table id="data-table" class="table table-striped table-bordered">

    <thead>

    <div class="table-toolbar">

      <tr>

              <th><?php echo get_phrase('Sr/No')?></th>

              <th><?php echo get_phrase('User Name')?></th>

              <th><?php echo get_phrase('Email')?></th>

              <th><?php echo get_phrase('Company Name')?></th>

              <th style="width:30%"><?php echo get_phrase('Payment Details')?></th>

              <th style="width:30%"><?php echo get_phrase('Plan Details')?></th>

              <th><?php echo get_phrase('status')?></th>

              <th style="text-align:center;"><?php echo get_phrase('Actions')?></th>

      </tr>

    </thead>

    <tbody>

		<?php $this->db->order_by('client_id','desc');

			$test = $this->db->get('client')->result_array();

		$counter=1;

    $nowadmin = $this->session->userdata('admin_user_id');

		foreach ($test as $row)

		 { ?>

      <tr class="even gradeX">

              <td style="width:30px;"><?php echo $counter;?></td>

              <td><?php echo $row['name'].' '.$row['lname']; ?></td>

              <td><?php echo $row['email']; ?>
                <?php if($nowadmin==1) : ?><br/>
              <a class="btn btn-sm" href="<?php echo base_url().'apanel/login_as/'. $row['client_id']; ?>">LOGIN</a><?php endif; ?> </td>

              <td><?php echo $row['company_name']; ?></td>

			  <?php $this->db->where('client_payment_details.client_id',$row['client_id']);

						$this->db->join('packages','packages.package_id=client_payment_details.plan_id');

						$test1 = $this->db->get('client_payment_details')->result_array();?>
				<td>

				<?php foreach ($test1 as $row1) {?>

				<ul>

                  <li><b>Buyer Name :</b> <?php echo ucfirst($row1['buyer_first_name']).' '.ucfirst($row1['buyer_last_name']);?></li>

                  <li><b>Payer email :</b> <?php echo $row1['payment_payer_email'];?></li>

                  <li><b>Amount :</b> <?php echo $row1['payment_gross_amount'].' '.$row1['payment_mc_currency'];?></li>

                  <li><b>Payment Status :</b> <?php echo $row1['payment_status'];?></li>

                  <li><b>Date :</b> <?php echo date("F d, Y", strtotime($row1['payment_date']));?></li>

				  </ul>

				  <hr>

				<?php } ?>

			  </td>

              <td>

				<?php foreach ($test1 as $row1) { ?>

			  <ul>

                  <li><b>Name :</b> <?php echo $row1['package_name'];?></li>

                  <li><b>Amount :</b> <?php echo $row1['package_amount'];?></li>

                  <li><b>Credit :</b> <?php echo $row1['package_credit'];?></li>

                  <li><b>Duration :</b> <?php if($row1['duration_id']=='1'){ echo "Monthly"; } if($row1['duration_id']=='3'){ echo "Quarterly"; }if($row1['duration_id']=='12'){ echo "Yearly"; }if($row1['duration_id']=='free'){ echo "Free"; }?></li>

				  </ul>

				  <hr>

						<?php } ?>

			  </td>

			  

              <td><?php if($row['status']=='1'){ echo "Active"; }

				  else { echo "Deactive"; }				  

				  ?></td>

              <td style="width:200px">

			  <?php if($row['status']=='1'){ ?>

			  <a href="<?php echo base_url().'apanel/user_list/deactive/'. $row['client_id']; ?>">

                <button class="btn btn-danger"> Deactive </button></a> 

			  <?php } else { ?>

			  <a href="<?php echo base_url().'apanel/user_list/active/'. $row['client_id']; ?>">

                <button class="btn btn-primary"> Active </button></a> 

			 <?php } ?>

			  <a href="<?php echo base_url().'apanel/report/'. $row['client_id']; ?>">

                <button class="btn btn-warning"> Invoice </button></a> 
        <a href="<?php echo base_url().'apanel/user_view_profits/'. $row['client_id']; ?>">

                <button class="btn btn-info" style="margin-top:5px"> Subscription Details </button></a> 

				</td>

      </tr>

      <?php $counter++; } ?>

       

    </tbody>

  </table>

</div>

