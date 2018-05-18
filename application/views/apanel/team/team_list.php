<div class="row-fluid sortable">		
				<div class="box span12">
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
					<div class="box-header well" data-original-title>
						<h2><i class="fa fa-align-justify"></i> <?php echo $page_title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="fa fa-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="fa fa-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="fa fa-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                     <a href="<?php echo base_url();?>apanel/team_add/">
            <button class="btn btn-success m-r-5 m-b-5"><?php echo get_phrase('Add New')?> <i class="fa fa-plus icon-white"></i></button>
            </a>
		<table id="data-table" class="table table-striped table-bordered nowrap">
          <thead>
            <tr>
              <th><?php echo get_phrase('Sr/No')?></th>
              <th><?php echo get_phrase('Image')?></th>
              <th><?php echo get_phrase('Title')?></th>
              <th><?php echo get_phrase('status')?></th>
              <th style="text-align:center;"><?php echo get_phrase('Actions')?></th>
            </tr>
          </thead>
          <tbody>
            <?php
        $this->db->order_by('team_id', 'asc');
        $test = $this->db->get('tbl_team')->result_array();
        $caounter=0;
        foreach ($test as $row):$caounter++;?>
            <tr>
              <td style="width:30px;"><?php echo $caounter;?></td>
              <td><img src="<?php echo base_url();?>/uploads/team_img/<?php echo $row['image']; ?>" alt="..."></td>
              <td><?php echo $row['title']; ?></td>
              <td><?php if($row['status']=='1'){ echo "Active"; }
				  else { echo "Deleted"; }				  
				  ?></td>
              <td style="width:200px"><a href="<?php echo base_url().'apanel/team_edit/'.$row['team_id']; ?>">
                <button class="btn btn-primary"> Update</button>
                </a>
				<a href="<?php echo base_url().'apanel/team/delete/'. $row['team_id']; ?>">
                <button class="btn btn-danger"></i>Delete</button>
                </a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
 <!-- /block --> 
</div>

	<script src="<?php echo base_url()?>assets/backend/js/charisma.js"></script>
<script src="<?php echo base_url()?>assets/backend/js/jquery-1.7.2.min.js"></script> 
<!-- jQuery UI --> 
<script src="<?php echo base_url()?>assets/backend/js/jquery-ui-1.8.21.custom.min.js"></script> 
<script src="<?php echo base_url()?>assets/backend/js/bootstrap-modal.js"></script> 
<script>
function get_model(id){
	//alert(id);
	$('#modal-services'+id).modal({show:true})
}
</script>
<script type="text/javascript">


	
	jQuery(document).ready(function($)
	{
		//convert all checkboxes before converting datatable
		replaceCheckboxes();
		
		// Highlighted rows
		$("#table_export tbody input[type=checkbox]").each(function(i, el)
		{
			var $this = $(el),
				$p = $this.closest('tr');
			
			$(el).on('change', function()
			{
				var is_checked = $this.is(':checked');
				
				$p[is_checked ? 'addClass' : 'removeClass']('highlight');
			});
		});
		
		// convert datatable
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"aoColumns": [
				{ "bSortable": false}, 	//0,checkbox
				{ "bVisible": true},		//1,name
				{ "bVisible": true},		//2,role
				{ "bVisible": true},		//3,contact
				{ "bVisible": true}		//4,option
			],
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						"mColumns": [1, 2, ]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(0, false);
							datatable.fnSetColumnVis(3, false);
							datatable.fnSetColumnVis(4, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(0, true);
									  datatable.fnSetColumnVis(3, true);
									  datatable.fnSetColumnVis(4, true);
								  }
							});
						},
						
					},
				]
			},
			
		});
		
		//customize the select menu
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		

		
	});
		
</script> 
