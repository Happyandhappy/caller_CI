<head>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1072030529568805');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1072030529568805&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<?php 
	$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
	$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
?>
<meta charset="utf-8">
<title>CallerTech - Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $system_name;?>">

<!-- ================== BEGIN BASE CSS STYLE ================== -->

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="<?php echo base_url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/style.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/style-responsive.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/theme/default.css" rel="stylesheet" id="theme" />
<link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/custom-css.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/swal/sweetalert.css" rel="stylesheet" />

<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->

<!--1. VALIDATION  -->

<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />

<!-- 2. DASHBOARD CHARTS -->

<link href="<?php echo base_url();?>assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/morris/morris.css" rel="stylesheet" />

<!-- 3   file upload-->

<link href="<?php echo base_url();?>assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<!-- 3  Passwors inpit view-->

<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />

<!-- DAta table view-->

<link href="<?php echo base_url();?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/AutoFill/css/autoFill.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/ColReorder/css/colReorder.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/KeyTable/css/keyTable.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/RowReorder/css/rowReorder.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/DataTables/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- DAta table view-->

<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->

<!-- ================== END BASE JS ================== -->

<style>
.table-content tr, .table-content td, .table-content th {
	display:block !important;
}
.buttons-pdf {
/*display: none !important;*/
}
</style>
</head>

<!-- End //HEad.php =-->

