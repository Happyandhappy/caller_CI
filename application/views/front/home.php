<style>
    #main_video_caontainer{
        padding: 0 70px; padding-top: 20px;padding-bottom:0px;
    }
    .adjust_center{
        text-align:center;
    }
    #lookup_result_div{
        padding:0px 20px 40px 20px;
    }
    .col-1{
        margin-top:10px;text-align:center;;
    }
    .col-2{
        margin-top:20px; text-align:center;
    }
    .col-3{
        margin-top:15px; text-align:center; font-size:16px; font-weight:bold;
    }
    .col-4{
        margin-top:5px; text-align:center;
    }
    .col-5{
        margin-top:15px; text-align:center;
    }
    #phonenumbermask{
        max-width: 450px;float: none;margin: 0 auto;
    }
    #lookup_button_click{
        padding:5px 20px !important;
        max-width: 265px;
    }
    #lookup_loader{
        display:none;
    }
    #lookup_loader div{
        text-align: center;width:100%;margin-top:20px;
    }
    #lookup_loader div p{
        font-size:20px;
    }
    .fa-check{
        color: #32CD32;
    }
    #firstname{
        max-width: 215px;float: right; margin: 0 auto;
    }
    #lastname{
        max-width: 215px;float: left; margin: 0 auto;
    }
    #emailaddress{
        max-width: 450px;float: none; margin: 0 auto;
    }
    #sendMail_button_click{
        padding:5px 20px !important; margin-bottom:20px;
    }
    #successEmailSend{
        padding:20px 20px 40px 20px; display:none;
    }
    .price-number{
        color:#100!important;
    }
    #send_email_block{
        padding-top:120px;padding-bottom:0px;
    }
</style>
<div id="home" class="content has-bg home"> 

    <?php if($lookup_data->countLookUpRecord == 0 ){ ?> 

    <div class="container content service-container <?php if($lookup_data->countLookUpRecord > 0 && empty($lookup_data->email)){ echo 'hidePricing'; } ?>"  id="main_video_caontainer">
        <div class="row adjust_center">

            <div class="col-md-12">

                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://player.vimeo.com/video/245971564?autoplay=<?php echo  ($this->session->userdata('login_user_id')!='' ? '0': '1'); ?>&loop=1&autopause=0" width="1100" height="550" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div  class="container content service-container " id="lookup_result_div" data-scrollview="true">
        <div class="row home_page_lookup">                                   
            <form class="form-horizontal form-bordered" data-parsley-validate="true" action="<?php echo base_url(); ?>base/lookup_number_calllog_home" name="demo-form" novalidate method="post" enctype="multipart/form-data">
                <div class="row" >
                    <div class="col-xs-12 col-sm-12 col-md-12 col-1">
                        <input type="text" class='form-control' placeholder='Enter Your Phone Number For A Free Lookup, Video Testimonials & Pricing' name='phonenumber' id='phonenumbermask'/>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-1">
                        <button class='btn btn-sm'  id="lookup_button_click">GO!</button>
                    </div>           
                </div>
            </form>         
        </div>
        <div id="lookup_loader">
            <div>
                <p>Please wait while we are fetching the lookup details.</p>
                <img height="40" src="<?php echo base_url();?>assets/frontend/img/45.gif" alt="45.GIF"/>
            </div>
        </div>
    </div>
     <?php } ?> 
     <div class="row home_page_lookup <?php if(($lookup_data->countLookUpRecord > 0 && !empty($lookup_data->email))||($lookup_data->countLookUpRecord == 0)){ echo 'hidePricing'; } ?>" id="send_email_block" >                  
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-2"><h5><i class="fa fa-check" aria-hidden="true"></i> Report Complete</h5></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-3" >Where Should We Send Your</div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-4" >Caller Technologies Advanced Demographic Report?</div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-2" >
                <input class="form-control" placeholder="First Name" name="firstname" id="firstname" type="text">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-2" >
                <input class="form-control" placeholder="Last Name" name="lastname" id="lastname"  type="text">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-5">
                <input class="form-control" placeholder="Email Address" name="emailaddress" id="emailaddress" type="text">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-5" >
                <button class="btn btn-sm" id="sendMail_button_click">Send!</button>
            </div>           
        </div>
            <!--</form>-->         
     </div>
     <div  class="container content service-container" data-scrollview="true" id="successEmailSend">
        <div class="row home_page_lookup">            
            <div class="main-table-div">
                <div class="full-set adjust_center">
                    <i class="fa fa-check" aria-hidden="true"></i>Your Advanced Demographic Report Has Been Sent
                </div>
            </div>        
        </div>
    </div>
    
    <div id="pricing" class="container content service-container <?php if(!(!is_array($lookup_data) && $lookup_data->used != 0 )){ ?> hidePricing <?php } ?>" data-scrollview="true" >
        <form class="form-horizontal form-bordered" data-parsley-validate="true"  action="<?php echo base_url(); ?>signup" id="theForm" name="demo-form" novalidate="" method="post" enctype="multipart/form-data">
            <div class="container"> 
                <?php $price = $this->crud_model->get_records('ct_pages','',array('page_title'=>'our_price'),'');     ?>      
                <h2 class="content-title"><?php echo $price[0]['page_heading']; ?> </h2>      
                <?php echo $price[0]['page_content']; ?>
                
                <?php 
                
                $this->db->where('status', 1);
                $packagesData   = $this->db->get_where('packages', array('is_subscription' => '1'))->result_array();
                $counter=0;
                $currency =$this->db->get_where('settings', array('type' => 'currency'))->row()->description;
                
                if($this->session->userdata('login_user_id')!=''){      
                $is_logged = true;              
                
                ?>
                <ul class="pricing-table col-4">
                <?php 
                    if(count($packagesData)>0){
                        foreach($packagesData as $prow):
                           $phoneAmount = $prow['duration_id']*$payment_details->phoneNumber_price ;                    
                            if(1==1)
                            {
                                if($counter>4) $counter=0;
                ?>
                                <li data-animation="true" data-animation-type="fadeInUp">
                                    <div class="pricing-container">
                                        <h3 ><span ><?php echo ucwords($prow['package_name']);?></span></h3>
                                        <div class="price">
                                            <div class="price-figure"> <span class="price-number"><?php echo '$' ;?><?php echo $prow['package_amount'];?> </span>

                                            </div>
                                        </div>
                                        <ul class="features ">
                                            <?php 
                                            $features= explode('#$#',$prow['features']);
                                            for($f=0; $f <count($features); $f++){
                                                if(!empty($features[$f])){ 
                                                ?>
                                                <li><?php echo ucwords($features[$f]);?></li>
                                                <?php 
                                                }
                                             }
                                            ?>
                                        </ul>
                                        <div class="footer"<?php 
                        if($is_logged)
                            echo ' data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="You already have a subscription for this account!" class="fa fa-info-circle" ';
                        ?>>
                                            <button type="button" class="btn <?php echo $buttonColor[$counter]?> btn-block"  <?php if(!$is_logged) { ?> onclick="submitForm(<?php echo $prow['package_amount']?>,<?php echo $prow['package_id']?>)" <?php } else { echo ' disabled title="You already have a subscription!"';} ?> ><?php echo get_phrase('buy now');?></button>
                                        </div>
                                    </div>
                                </li>
                <?php 
                                $counter++;
                           } 
                        endforeach;
                    }else{ 
                        echo get_phrase('No Packages available.');
                    }
                ?>
                </ul>
                <?php
            }
            else
            { 
                ?>
                <ul class="pricing-table col-4">
       
                <?php 
                if(count($packagesData)>0){
                    foreach($packagesData as $prow):
                    if($counter>4) $counter=0;?>
                    <li data-animation="true" data-animation-type="fadeInUp">
                      <div class="pricing-container">
                        <h3><span ><?php echo ucwords($prow['package_name']);?></span></h3>

                        <div class="price">
                          <div class="price-figure"> <span class="price-number"><?php echo '$';?><?php echo $prow['package_amount'];?> </span>
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
                          <button type="button" class="btn <?php echo $buttonColor[$counter]?> btn-block" onclick="submitForm(<?php echo $prow['package_amount']?>,<?php echo $prow['package_id']?>)"><?php echo get_phrase('buy now');?></button>
                        </div>
                      </div>
                    </li>
                <?php 
                    $counter++; 
                    endforeach;
                } else
                { 
                    echo get_phrase('No Packages available.');
                }
                ?>
                </ul>
            <?php
                } 
                ?>
            </div>
    
    <!-- end container -->
    
            <input type="hidden" value="" name="plan_amount"  id="plan_amount" />
            <input type="hidden" value="" name="plan_id" id="plan_id" />
        </form>
    </div>


<script>
    function submitForm(packageAmount,packageID){
        $("#plan_amount").val(packageAmount);
        $("#plan_id").val(packageID);
        document.getElementById("theForm").submit();            
    }
</script> 

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>