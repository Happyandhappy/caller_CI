<head>
<meta charset="utf-8" />
<title>CallerTech</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" size="57x57" href="/images/apple-icon-57.png"/>
<link rel="apple-touch-icon" size="48x48" href="/images/apple-icon-48.png"/>

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/css/animate.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/css/style.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/css/style-responsive.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/css/theme/default.css" id="theme" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/frontend/css/style-responsive.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url();?>assets/frontend/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<!-- ================== END BASE JS ================== -->


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1072030529568805');
<?php if(isset($_GET['_act_ad']) ): ?>
fbq('track', '<?php echo $_GET['_act_ad']; ?>');
<?php endif;?>
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1072030529568805&ev=PageView&noscript=1" alt=""
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->

<script type="text/javascript">
    _linkedin_data_partner_id = "275860";
</script>
<script type="text/javascript">
    (function(){
        var s = document.getElementsByTagName("script")[0];
        var b = document.createElement("script");
        b.type = "text/javascript";b.async = true;
        b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
        s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
    <img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=275860&fmt=gif" />
</noscript>

</head>

<style type="text/css">
   
   @page { size:8.5in 11in; margin: 2cm }
   
</style>