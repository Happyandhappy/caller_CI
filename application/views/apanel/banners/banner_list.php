
<div class="row-fluid"> 
  
  <!-- block -->
  <div class="block">
    <div class="block-content collapse in">
      <div class="span12">
	  <?php if($this->session->flashdata('success')){ ?>
		<div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
            </button>
            <?php echo $this->session->flashdata('success');?>
        </div>
	  <?php } if($this->session->flashdata('error1')){ ?>
		<div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
            </button>
            <?php echo $this->session->flashdata('error1');?>
        </div>
	  <?php } ?>
       <table id="data-table" class="table table-striped table-bordered nowrap">
          <thead>
            <tr>
              <th><?php echo get_phrase('Sr/No')?></th>
              <th><?php echo get_phrase('Content')?></th>
              <th style="text-align:center;"><?php echo get_phrase('Actions')?></th>
            </tr>
          </thead>
          <tbody>
            <?php
        $this->db->order_by('banner_id', 'asc');
        $test = $this->db->get('tbl_banner')->result_array();
        $caounter=0;
        foreach ($test as $row):$caounter++;?>
            <tr>
              <td style="width:30px;"><?php echo $caounter;?></td>
              <td><?php echo $row['description']; ?></td>
              <td style="width:200px"><a href="<?php echo base_url().'apanel/banner_edit/'.$row['banner_id']; ?>">
                <button class="btn btn-primary"> Update</button>
                </a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /block --> 
  
</div>
