<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url();?>assets/frontend/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/jquery.mask.js"></script>
<!--[if lt IE 9]>
		<script src="<?php echo base_url();?>assets/frontend/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo base_url();?>assets/frontend/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo base_url();?>assets/frontend/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
<script src="<?php echo base_url();?>assets/frontend/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo base_url();?>assets/frontend/plugins/scrollMonitor/scrollMonitor.js"></script>
<script src="<?php echo base_url();?>assets/frontend/js/apps.js"></script>
<!-- ================== END BASE JS ================== -->
<script>    
	$(document).ready(function() {
		App.init();
		globalMaskTrue = 0;
		//TableManageCombine.init();
        setTimeout(function(){
			var options =  {
				onComplete: function(cep) {
					globalMaskTrue = 1;
				},  
				onInvalid: function(val, e, f, invalid, options){
					globalMaskTrue = 0;
				}
			};
			$("#phonenumbermask").mask("(999) 999-9999",options); 
		},1000);
        $('#lookup_button_click').on('click touchstart touch', function () {
			if( globalMaskTrue ){
				var phonenumbermask = jQuery('#phonenumbermask').val();
				var html = jQuery('#lookup_loader').html();
				jQuery('#lookup_result_div').html(html);
				$.ajax({
					url: "<?php echo base_url() ?>base/lookup_number_calllog_home",
					type: "post",
					data: {
						phonenumber: phonenumbermask
					},
					dataType:'html',
					success: function (response) {
						//jQuery('#lookup_result_div').html(response);
						//jQuery('#lookup_result_div').css('padding-top','20px');
						jQuery('#lookup_result_div').addClass('hidePricing');
						jQuery(main_video_caontainer).remove();
						jQuery('#send_email_block').removeClass('hidePricing');
						//jQuery('#main_video_caontainer').addClass('hidePricing');
						//jQuery('#testimonial').removeClass('hidePricing');
						return false;
					},
					error: function (jqXHR, textStatus, errorThrown) { 
						console.log(textStatus, errorThrown);
					}
				});
				return false;
			}
			else{
				alert('Invalid Phone Number');
				return false;
			}
        });
		
		$("#sendMail_button_click").click(function(){
			var firstname = $("#firstname").val();
			var lastname = $("#lastname").val();
			var emailaddress = $("#emailaddress").val();
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var valid = 0;
			if(firstname ==""){
				alert('Please enter first name!');
				valid = 1;
				return false;
			}
			if(lastname ==""){
				alert('Please enter last name!');
				valid = 1;
				return false;
			}
			if(emailaddress ==""){
				alert('Please enter email address!');
				valid = 1;
				return false;
			}else if(!regex.test(emailaddress)){
				alert('Please enter valid email!');
				valid = 1;
				return false;
			}
			if(valid == 0){
				$.ajax({
					url: "<?php echo base_url() ?>base/update_email_send_data",
					type: "post",
					data: {
						firstname: firstname,
						lastname:lastname,
						emailaddress:emailaddress
					},
					dataType:'html',
					success: function (response) {
						jQuery('#lookup_result_div').addClass('hidePricing');
						jQuery('#send_email_block').addClass('hidePricing');
						jQuery('#main_video_caontainer').removeClass('hidePricing');
						jQuery('#pricing').removeClass('hidePricing');
						jQuery('#successEmailSend').show();//.delay(5000).fadeOut()
						return false;
					},
					error: function (jqXHR, textStatus, errorThrown) { 
						console.log(textStatus, errorThrown);
					}
				});
			}
		});
	});
	</script>