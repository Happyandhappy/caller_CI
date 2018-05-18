
<?php $pro_ids = array(); ?>
<div id="pricing" class="content" data-scrollview="true" style="padding-top:100px;">
    
    <!-- begin container -->
    
    <div class="container">
      <?php $price = $this->crud_model->get_records('ct_pages','',array('page_title'=>'our_price'),'');
	  
	  ?>
	  
      <h2 class="content-title" style="padding-top:35px"><?php echo $price[0]['page_heading']; ?> </h2>
      
      <?php echo $price[0]['page_content']; ?> 

      <!--<div class="promo-form ct-loadArea clearfix">
        <div class="promo-form-inner">
        <div class="row">
          <div class="col-xs-12 text-left"><h4>Do you have a promo code?</h4></div>
          <div class="col-xs-9">
            <input type="text" class="form-control promo-input" id="promo-input" placeholder="Paste Code Here" />
          </div>
          <div class="col-xs-3">
            <button class="btn btn-info apply-promo">Apply Code</button>
          </div>
        </div>
        </div>
      </div>
    </div>-->
      
<div class="container">
  <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>signup" id="theForm" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="promocode" id="promo-hidden" value="" />
      <!-- begin pricing-table -->
      <?php
				#check plans for current login user
				if($this->session->userdata('login_user_id')!=''){
  				$is_logged = true;
				  ?>
           <?php ### Fetch the active packges of sites.########

				    $this->db->where('status', 1);

				    $packagesData	= $this->db->get('packages')->result_array();
				
    				
    				
    				#######################################

    				$blockColor=array('bg-aqua-darker','bg-purple-lighter','bg-yellow-darker','bg-aqua');

    				$buttonColor=array('btn-info','btn-inverse','btn-warning','btn-success');

    				$counter=0;

    				$currency =$this->db->get_where('settings', array('type' => 'currency'))->row()->description;

    				#[package_id] => 1[package_name] => name[package_amount] => 52[features] => fgdfgdf[description] => hfhfghfghfghghhfghffg[duration_id] => 2[status] => 1#?>
      <?php if(count($packagesData)>0){?>
      <ul class="pricing-table ct-loadArea clearfix col-4">
            <?php foreach($packagesData as $prow):
    					$phoneAmount	= $prow['duration_id']*$payment_details->phoneNumber_price ; 
    					#Check if package amount is greater than total phone price
      					if($prow['is_subscription'])
      					{
                         	 if($counter>4) $counter=0;?>
                <li data-animation="true" data-animation-type="fadeInUp">
                  <div class="pricing-container">
                    <h3><span><?php echo ucwords($prow['package_name']);?></span></h3>
                    <div class="price">
                      <div class="price-figure"> 
                      <span class="price-number" style="color:#100;"><?php echo '$' ;?>
                        <span id="ct-price-<?php echo $prow['package_id'];?>">
                        <?php echo $prow['package_amount'];?>
                        </span> 
                      </span> 
                      </div>
                    </div>
                    <ul class="features ">
                      <?php $features= explode('#$#',$prow['features']);?>
                      <?php for($f=0; $f <count($features); $f++){

                                            if(!empty($features[$f])){?>
                      <li><?php echo ucwords($features[$f]);?></li>
                      <?php }

                                             }?>
                    </ul>
                    <div class="footer"<?php 
                        if($is_logged)
                            echo ' data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="You already have a subscription for this account!" class="fa fa-info-circle" ';
                        ?>>
                <?php array_push($pro_ids,'subs_'.$prow['package_id']); ?>
                      <button type="button" class="btn <?php echo $buttonColor[$counter]?> btn-block" <?php if(!$is_logged) { ?> onclick="submitForm(<?php echo $prow['package_amount']?>,<?php echo $prow['package_id']?>)" <?php } else { echo ' disabled title="You already have a subscription!"';
                    } ?> ><?php echo get_phrase('buy now');?></button>
                    </div>
                  </div>
                </li>
                 <?php $counter++;
  					   }
              endforeach;

            } else{ echo get_phrase('No Packages available.');}?>
        
        
          <div class="clearfix"></div>
      </ul>
      <?php
			}
			else
			{?>
      <ul class="pricing-table ct-loadArea col-4">
        <?php ### Fetch the active packges of sites.########

				$this->db->where('status', 1);

				$packagesData = $this->db->get('packages')->result_array();
				
				
				#######################################

				$blockColor=array('bg-aqua-darker','bg-purple-lighter','bg-yellow-darker','bg-aqua');

				$buttonColor=array('btn-info','btn-inverse','btn-warning','btn-success');

				$counter=0;

				$currency =$this->db->get_where('settings', array('type' => 'currency'))->row()->description;

				#[package_id] => 1[package_name] => name[package_amount] => 52[features] => fgdfgdf[description] => hfhfghfghfghghhfghffg[duration_id] => 2[status] => 1#?>
        <?php if(count($packagesData)>0){?>
        <?php foreach($packagesData as $prow):
        if(!$prow['is_subscription']) /* only subs */
          continue;

                    if($counter>4) $counter=0;?>
        <li data-animation="true" data-animation-type="fadeInUp">
          <div class="pricing-container">
            <h3><span><?php echo ucwords($prow['package_name']);?></span></h3>
            <div class="price">
              <div class="price-figure"> <span class="price-number" style="color:#100;"><?php echo '$';?>
                        <span id="ct-price-<?php echo $prow['package_id'];?>">
                        <?php echo $prow['package_amount'];?>
                        </span> 
                      </span>
                <?php /*<span class="price-tenure">per <?php echo ucwords($prow['duration_id']);?> month/s</span>*/ ?>
              </div>
            </div>

            <ul class="features ">
              <?php $features= explode('#$#',$prow['features']);?>
              <?php for($f=0; $f <count($features); $f++){

                                    if(!empty($features[$f])){?>
              <li><?php echo ucwords($features[$f]);?></li>
              <?php }

                                     }?>
            </ul>
            <div class="footer">
                <?php array_push($pro_ids,'subs_'.$prow['package_id']); ?>
              <button type="button" class="btn <?php echo $buttonColor[$counter]?> btn-block" onclick="submitForm(<?php echo $prow['package_amount']?>,<?php echo $prow['package_id']?>)"><?php echo get_phrase('buy now');?></button>
            </div>
          </div>
        </li>
        <?php $counter++; endforeach;

                    }else
					{ echo get_phrase('No Packages available.');}?>
          <div class="clearfix"></div>
      </ul>
      <?php
                }?>

    </div>
    
    <!-- end container -->
    
    <input type="hidden" value="" name="plan_amount"  id="plan_amount" />
    <input type="hidden" value="" name="plan_id" id="plan_id" />
  </form>
</div>

<!-- begin #quote -->
<script>
fbq('track', 'ViewContent', {
  content_name: 'Pricing',
  content_type: 'product',
  content_ids: ['<?php echo implode("','",$pro_ids);?>'],
});
</script>
<!-- begin #pricing -->
<script>

        function submitForm(packageAmount,packageID){

			//alert(packageID+' '+packageAmount);

                        //alert(packageamount.toString());

             $("#plan_amount").val(packageAmount);

             $("#plan_id").val(packageID);

			document.getElementById("theForm").submit();

			

			}

        </script> 

<script>
jQuery(document).ready(function($){
    $('[data-toggle="popover"]').popover();   
    $('.apply-promo').on('click',function(){

      var $prTable = $('.pricing-table');
      var $promForm = $('.promo-form');

      $prTable.addClass('sleep');
      $promForm.addClass('sleep');
      var promoc = $('#promo-input').val();


        $.ajax({
          url: "<?php echo base_url(); ?>base/ajax_get_pricing",
          type: "post",
          data: {
            'promo': promoc
          },
          success: function (response) {
            if(response.status=='error') {
              alert(response.message);
            } else {
              //alert('dobio sve ok');
              $.each(response.updated,function(i,v){
                $('#ct-price-'+v.pid).html(v.price);
              })
              $('#promo-hidden').val(promoc);
            }

            $prTable.removeClass('sleep');
            $promForm.removeClass('sleep');
            return false;
          },
          error: function (jqXHR, textStatus, errorThrown) { 
            console.log(textStatus, errorThrown);
          }
        });


    });
});
</script>