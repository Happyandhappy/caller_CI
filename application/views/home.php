<!DOCTYPE html>
<html lang="en-US">
<?php $this->load->view('include/front/head'); ?>
    <body data-spy="scroll" data-target="#header-navbar" data-offset="51">

		<script>
		(function(i,s,o,g,r,a,m) {
			i['GoogleAnalyticsObject']=r;
			i[r]=i[r]||function() {
				(i[r].q=i[r].q||[]).push(arguments)
			},i[r].l=1*new Date();
			a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];
			a.async=1;
			a.src=g;
			m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-93252325-1', 'auto');
		ga('send', 'pageview');

		</script>
    
		<div id="page-container" class="fade">

			<?php 
				$this->load->view('include/front/header');
				if($page_name=='error')
					$this->load->view('errors/html/error_' . $error_code);
				else
					$this->load->view('front/' . $page_name);
				$this->load->view('include/front/footer');
				$this->load->view('include/front/bottom_include');
			?>


		</div>


    </body>


</html>