<!-- begin #header -->
<style>
  .tag_hidden{
    display:none;
  }
</style>
<h1 class="tag_hidden">Caller Technologies</h1>
<h2 class="tag_hidden">Caller Technologies</h2>
<h3 class="tag_hidden">Caller Technologies</h3>
<h4 class="tag_hidden">Caller Technologies</h4>
<h5 class="tag_hidden">Caller Technologies</h5>
<h6 class="tag_hidden">Caller Technologies</h6>

<!-- begin #header -->
<?php $id = $this->uri->segment(2);$id1 = $this->uri->segment(1);?>
<div id="header" class="header navbar navbar-transparent navbar-fixed-top"> 
  <!-- begin container -->
  <div class="container" style="padding-top:5px;padding-bottom:5px;"> 
    <!-- begin navbar-header -->
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar"> <span class="fa fa-bars"></span></button>
      <a href="<?php echo base_url()?>home" class="navbar-brand"> <img src="<?php echo base_url()?>uploads/logo.png" height="56" /> </a> </div>
    <!-- end navbar-header --> 
    <!-- begin navbar-collapse -->
    <div class="collapse navbar-collapse" id="header-navbar">
      <ul class="nav navbar-nav navbar-right">
        <li <?php if($id1=='home' && $id==''){ ?> class="active" <?php } ?>> <a href="<?php echo base_url();?>home">HOME </a> </li>
        <?php /*<li <?php if($id=='services'){ ?> class="active" <?php } ?>><a href="<?php echo base_url()?>home/services">CT LOOKUP</a></li>*/
		if( $this->session->userdata('login_user_id')==''){?>
        <li <?php if($id=='pricing'){ ?> class="active" <?php } ?>><a href="<?php echo base_url()?>home/pricing">PRICING</a></li>
        <?php }?>
        <li <?php if($id=='faq'){ ?> class="active" <?php } ?>><a href="<?php echo base_url()?>home/faq">FAQ's</a></li>
      <?php /* <li <?php if($id=='aboutus'){ ?> class="active" <?php } ?>><a href="<?php echo base_url()?>home/aboutus" >ABOUT US</a></li>
*/
?>
        <li <?php if($id=='contact'){ ?> class="active" <?php } ?>><a href="<?php echo base_url()?>home/contact">CONTACT</a></li>
<?php 
    $clInetId=$this->session->userdata('login_user_id');
    if( empty( $clInetId ) ){ ?>
        <li><a href="<?php echo base_url()?>login">LOGIN</a></li>
    <?php }else{ ?>
        <li><a href="<?php echo base_url()?>clientuser/dashboard">ACCOUNT</a></li>
        <li><a href="<?php echo base_url()?>logout">LOGOUT</a></li>
    <?php } ?>
        
      </ul>
    </div>
    <!-- end navbar-collapse --> 
  </div>
  <!-- end container --> 
</div>
<!-- end #header --> 

