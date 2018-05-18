
<div class="panel-body panel-form" style="border:0px solid #eee; margin: 25px 10px;">
	
	<form class="form-horizontal col-sm-12" style="border:1px solid #eee;padding-top:10px;" data-parsley-validate="true"  action="<?php echo base_url(); ?>clientuser/import_bulksms/<?php echo $group_info->id; ?>/updatelist" name="blockednum-form" novalidate method="post"  enctype="multipart/form-data">
			<input type="hidden" name="filename" value="<?php echo isset($filename) ? $filename : ''; ?>" />
			<input type="hidden" name="listnumber_id" value="<?php echo isset($list_info) ? $list_info->rec_id : ''; ?>" />
		
		<?php

		$possible_groups = [
			'user_number' => 'Phone Number',
			'user_fname' => 'First Name (optional)',
			'user_lname' => 'Last Name (optional)',
			'user_moreinfo1' => 'User Info 1 (optional)',
			'user_moreinfo2' => 'User Info 2 (optional)',
		];
		?>

			<!--  SUBMIT -->
			<div class="form-group">
				<div class="col-md-12 text-center">
				   <div class="">
					  <button type="submit" class="btn btn-success"><?php echo get_phrase('Import Numbers');?></button>
				   </div>
				</div>
			</div>
			<h2>Select the appropriate fields:</h2>
			<div class="wmd-view-topscroll">
			    <div class="scroll-div1">
						<table id="data-tabe" class="table table-responsive table-striped table-striped table-bordered ">
							<thead>
								<th></th>
								<?php for($i=0;$i<count($inprows[0]);$i++): ?>
								<th>
									<select name="grdata[<?php echo $i; ?>]">
										<option value="0">Choose Type</option>
									<?php foreach($possible_groups as $k=>$grp): ?>
										<option value="<?php echo $k; ?>"><?php echo $grp ?></option>
									<?php endforeach; ?>
									</select>
								</th>
							<?php endfor; ?>
							</thead>
							<tbody>
								<?php $j=0; ?>
								<?php foreach($inprows as $row): ?>
								<tr>
									<td><?php echo ++$j; ?></td>
									<?php for($i=0;$i<count($row);$i++): ?>
									<td><?php echo substr($row[$i],0,80); ?></td>
									<?php endfor; ?>
									<?php if($j>100) break; ?>
								</tr>
								<?php if($j>2) break; ?>
								<?php endforeach; ?>	
							</tbody>
						</table>
			    </div>
			</div>
			<div class="wmd-view">
			    <div class="scroll-div2">
						<table id="data-tabe" class="table table-responsive table-striped table-striped table-bordered ">
							<thead>
								<th></th>
								<?php for($i=0;$i<count($inprows[0]);$i++): ?>
								<th>
									<select name="grdata[<?php echo $i; ?>]">
										<option value="0">Choose Type</option>
									<?php foreach($possible_groups as $k=>$grp): ?>
										<option value="<?php echo $k; ?>"><?php echo $grp ?></option>
									<?php endforeach; ?>
									</select>
								</th>
							<?php endfor; ?>
							</thead>
							<tbody>
								<?php $j=0; ?>
								<?php foreach($inprows as $row): ?>
								<tr>
									<td><?php echo ++$j; ?></td>
									<?php for($i=0;$i<count($row);$i++): ?>
									<td><?php echo substr($row[$i],0,80); ?></td>
									<?php endfor; ?>
									<?php if($j>100) break; ?>
								</tr>
								<?php endforeach; ?>	
							</tbody>
						</table>
			    </div>
			</div>
		</form>
</div>

<style>
.wmd-view-topscroll, .wmd-view {
    overflow-x: scroll;
    overflow-y: hidden;
    width:  100%;
    height: 20px;
    max-width: 900px;
    border: none 0px RED;
}

.wmd-view-topscroll { height: auto; overflow: auto; }
.wmd-view { height: initial; }
.scroll-div1 { 
    width:  100%;
    max-width: 900px;
    overflow-x: scroll;
    overflow-y: hidden;
    height: 20px;
}
.scroll-div2 { 
    width:  100%;
    max-width: 900px;
    height:auto;
}

</style>
<script>
	$(function(){
    $(".wmd-view-topscroll .scroll-div1").scroll(function(){
        $(".wmd-view")
            .scrollLeft($(".wmd-view-topscroll .scroll-div1").scrollLeft());
    });
    $(".wmd-view").scroll(function(){
        $(".wmd-view-topscroll")
            .scrollLeft($(".wmd-view").scrollLeft());
    });
});

</script>