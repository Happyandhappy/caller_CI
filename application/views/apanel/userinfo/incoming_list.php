<div class="panel-body">
	  <?php if($this->session->flashdata('success')){ ?>
		<div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
            </button>
            <?php echo $this->session->flashdata('success');?>
        </div>
	  <?php } if($this->session->flashdata('error')){ ?>
		<div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
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
              <th><?php echo get_phrase('status')?></th>
              <th style="text-align:center;"><?php echo get_phrase('Actions')?></th>
      </tr>
    </thead>
    <tbody>
		<?php $test = $this->db->get('client')->result_array();
		$counter=1;
		?>
		<tr class="even gradeX">
              <td style="width:30px;"><?php echo $counter++;?></td>
              <td>Home Page Lookups</td>
              <td></td>
              <td></td>
              <td></td>
              <td style="width:200px">			  
			  <a href="<?php echo base_url().'apanel/advanced_details/0'; ?>"> 
                <button class="btn btn-primary"> Advanced  </button></a> 
				</td>
      </tr>
		<?php
		foreach ($test as $row)
		 { ?>
      <tr class="even gradeX">
              <td style="width:30px;"><?php echo $counter;?></td>
              <td><?php echo $row['name'].' '.$row['lname']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['company_name']; ?></td>
              <td><?php if($row['status']=='1'){ echo "Active"; }
				  else { echo "Deactive"; }				  
				  ?></td>
              <td style="width:200px">
			  <a href="<?php echo base_url().'apanel/incoming_details/'. $row['client_id']; ?>">
                <button class="btn btn-primary"> Incoming  </button></a> 
			  <a href="<?php echo base_url().'apanel/advanced_details/'. $row['client_id']; ?>">
                <button class="btn btn-primary"> Advanced  </button></a> 
				</td>
      </tr>
      <?php $counter++; } ?>
       
    </tbody>
  </table>
</div>
