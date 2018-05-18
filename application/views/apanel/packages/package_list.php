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
    <div class="table-toolbar mainDivCls" style="height: 42px;">
          <div class="dt-buttons btn-group">
		  	<a href="<?php echo base_url();?>apanel/package_add/" class="btn btn-success m-r-5 m-b-5"><?php echo get_phrase('Add Package')?> <i class="fa fa-plus icon-white"></i>
            </a>
			<a href="<?php echo base_url();?>apanel/subscription_add/"class="btn btn-success m-r-5 m-b-5"><?php echo get_phrase('Add Subscription')?> <i class="fa fa-plus icon-white"></i>
            </a>  
			</div>
		  <div class="dataTables_filter mediaCls" style="float: right; width: 20%;">
		  <div class="mediaSubCls" style="float: left; margin-top: 7px; color: rgb(0, 0, 0); margin-left: 12%;">Filter:</div>
		  	<div style="float: right;">
		  		<select class="form-control" name="filter_type" id="filter_type" data-parsley-required="true">
                  <option value="">----Select Filter Type---</option>
                  <option value="0">Packages</option>
                  <option value="1">Subscription</option>
               </select>
  			</div>
		</div>
      <tr>
        <th width="10px" nowrap><?php echo get_phrase('Sr/No')?></th>
        <th width="200px" nowrap><?php echo get_phrase('Package Name')?></th>
        <th width="20px" nowrap><?php echo get_phrase('Packges Cost')?></th>
        <th width="250px" nowrap><?php echo get_phrase('Packges Description')?></th>
        <th width="200px" nowrap><?php echo get_phrase('Features')?></th>
        <th width="50px" nowrap><?php echo get_phrase('Type')?></th>
		<th width="50px" nowrap><?php echo get_phrase('status')?></th>
        <th><?php echo get_phrase('Actions')?></th>
      </tr>
    </thead>
    <tbody id="resultOutPut">
<?php
$this->db->order_by('package_id', 'desc');
$test = $this->db->get('packages')->result_array();
$caounter=0;
foreach ($test as $row):$caounter++; ?>
      <tr class="even gradeX">
              <td><?php echo $caounter;?></td>
              <td><?php echo $row['package_name']; ?></td>
              <td><?php echo $row['package_amount']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php $features = explode('#$#',$row['features']); ?>
                <?php if(count($features) >3) $limit=3; else $limit=count($features);?>
                <ul>
                  <?php for($i=0;$i<$limit;$i++){?>
                  <li><?php echo $features[$i];?></li>
                  <?php }?>
                  <?php if(count($features) >3){?>
                  <small>So On >> </small>...
                  <?php }?>
                </ul></td>
			  <td><?php if($row['is_subscription']=='1'){ echo "Subscription"; }else { echo "Package"; }?></td>
              <td><?php if($row['status']=='1'){ echo "Active"; }else { echo "InActive"; }?></td>
			  <?php if($row['is_subscription']=='1'){ $types = "subscription_edit"; }else { $types = "package_edit"; }?>
              <td><a href="<?php echo base_url().'apanel/'.$types.'/'.$row['package_id']; ?>">
                <button class="btn btn-primary" style="width: 68px;"><i class="fa fa-pencil icon-white"></i> Update</button>
                </a> <a href="<?php echo base_url().'apanel/packages/delete/'. $row['package_id']; ?>">
                <!--<a href="javascript:void(0);" onclick="alert('You cannot remove package');">-->
                <?php if($row['package_id']=='1'){?>
                <?php } else {?>
                <button class="btn btn-danger"><i class="fa fa-remove icon-white"></i> Delete</button>
                <?php }?>
                </a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<style>
.btn {line-height: 1.259;margin-bottom: 2px;}
@media only screen and (max-width : 980px) {
	.mainDivCls {height:42px !important;}
	.mediaCls {width:27% !important;}
	
/* Styles */
}

@media only screen and (max-width : 800px) {
	.mainDivCls {height:42px !important;}
	.mediaCls {width:35% !important;}
	
/* Styles */
}

@media only screen and (max-width : 780px) {
	.mainDivCls {height:42px !important;}
	.mediaCls {width:53% !important; margin-right:0 !important;}
	.mediaSubCls {margin-left:39% !important;}
	
/* Styles */
}

@media only screen and (max-width : 550px) {
	.mainDivCls {height:80px !important;}
	.mediaCls {width:53% !important; margin-right:26% !important;}
	.mediaSubCls {margin-left:0 !important;}
	
/* Styles */
}

@media only screen and (max-width : 480px) {
	.mainDivCls {height:80px !important;}
	.mediaCls {width:55% !important; margin-right:84px !important;}
	.mediaSubCls {margin-left:0 !important;}
	
/* Styles */
}

@media only screen and (max-width : 360px) {
	.mainDivCls {height:80px !important;}
	.mediaCls {width:auto !important; margin-right:30px !important;}
	.mediaSubCls {margin-left:2px !important;}
	
/* Styles */
}
@media only screen and (max-width : 320px) {
	.mainDivCls {height:80px !important;}
	.mediaCls {width:auto !important; margin-right:12px !important;}
	.mediaSubCls {margin-left:0 !important;}
	
/* Styles */
}
</style>
<script type="text/javascript">
$( document ).ready(function() {
    $("#filter_type").change(function() {
		var getVal = $(this).val();
		$.ajax({
			type: "POST",
			url: 'filter_package',
			data: "type="+getVal,
			dataType: "json",
			success: function(result){
				$("#resultOutPut").html(result.output);
				$("#data-table_info").html('Showing 1 to '+result.totalRecord+' of '+result.totalRecord+' entries');
				$("#data-table_paginate").hide();
			}
		});
	});
});
</script>