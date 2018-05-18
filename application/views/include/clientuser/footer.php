<!-- begin #footer -->
<?php 
    $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
    $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
?>
<div id="footer" class="footer"> <?php echo $system_name; ?> - <?php echo $system_title; ?> &copy; 2016 All Rights
    Reserved
</div>
<div class="subfooter"></div>
<!-- end #footer -->

<!-- begin theme-panel -->

<!-- end theme-panel -->

<!-- begin scroll to top btn -->

<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>

<!-- end scroll to top btn -->

</div>

<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->

<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-maskMoney/jquery.maskMoney.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/swal/sweetalert.min.js"></script>


<script src="<?php echo base_url() ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>


<script src="<?php echo base_url() ?>assets/plugins/parsley/dist/parsley.js"></script>

<!-- charts  -->

<script src="<?php echo base_url() ?>assets/plugins/morris/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/morris/morris.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dashboard-v2.js"></script>
<script src="<?php echo base_url() ?>assets/js/dashboard.js"></script>
<!--script src="<?php echo base_url() ?>assets/js/dashboard.min.js"></script-->

<!-- charts  -->

<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.crosshair.min.js"></script>

<script src="<?php echo base_url() ?>assets/plugins/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url() ?>assets/js/chart-flot.demo.js"></script>
<!-- multiple uploads  -->

<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>

<!--[if (gte IE 8)&(lt IE 10)]>

<script src="assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>

<![endif]-->

<script src="<?php echo base_url() ?>assets/js/form-multiple-upload.demo.js"></script>

<!-- forms plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/masked-input/masked-input.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/masked-input/masked-input.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/form-plugins.demo.min.js"></script>

<!-- data-table  -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url() ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/table-manage-buttons.demo.js"></script>

<script src="<?php echo base_url() ?>assets/plugins/DataTables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/table-manage-scroller.demo.js"></script>



<script src="<?php echo base_url() ?>assets/js/table-manage-combine.demo.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/apps.min.js"></script>


<script src="<?php echo base_url() ?>assets/js/form-wysiwyg.demo.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<style>
    .toggleMenu {
        left: 0 !important;
    }
</style>
<script>
    $(function ($) {


        jQuery('.play-recording').on('click', function () {
            _id = jQuery(this).data('sid');
            console.log(_id)
            var myAudio = document.getElementById(_id);
            idstateicon = 'stateicon-' + _id
            if (myAudio.paused) {
                jQuery('.' + idstateicon).removeClass('fa fa-play');
                jQuery('.' + idstateicon).addClass('fa fa-pause');
                myAudio.play();
            } else {
                jQuery('.' + idstateicon).removeClass('fa fa-pause');
                jQuery('.' + idstateicon).addClass('fa fa-play');
                myAudio.pause();
            }
        })
        jQuery('.p-r-5').on('click', function () {
            jQuery('.play-recording').unbind('click')
            setTimeout(function () {
                jQuery('.play-recording').on('click', function () {
                    _id = jQuery(this).data('sid');
                    console.log(_id)
                    var myAudio = document.getElementById(_id);
                    idstateicon = 'stateicon-' + _id
                    if (myAudio.paused) {
                        jQuery('.' + idstateicon).removeClass('fa fa-play');
                        jQuery('.' + idstateicon).addClass('fa fa-pause');
                        myAudio.play();
                    } else {
                        jQuery('.' + idstateicon).removeClass('fa fa-pause');
                        jQuery('.' + idstateicon).addClass('fa fa-play');
                        myAudio.pause();
                    }
                })
            }, 100)
        })


        $(".cust_phone_no").mask("(999) 999-9999");
        $("#phonenumbermask").mask("(999) 999-9999");

        var searchArea = false;
        $('.button-area-code').on('click', function () {
            şearchArea = true;
            if(searchArea == false) {
                jQuery('#buy-numbers-container').addClass('sleep');
                $('.button-area-code').attr('disabled','disabled');

                    areacode = jQuery('#areacode').val()
                    var searchfor = jQuery('#searchfor').val()
                    $.ajax({
                        url: "<?php echo base_url() ?>clientuser/ajax_available_numbers_area_code",
                        type: "post",
                        data: {
                            areacode: areacode,
                            searchfor: searchfor
                        },
                        success: function (response) {
                            if (response) {
                                jQuery('#buy-numbers-container').html(response)

                            }
                            else {
                                alert('No results! Try different search parameters.')
                            }
                            $('.button-area-code').removeAttr('disabled');
                            searchArea = false;
                                jQuery('#buy-numbers-container').removeClass('sleep');
                $(".cust_phone_no").mask("(999) 999-9999");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        $('.button-area-code').removeAttr('disabled');
                            jQuery('#buy-numbers-container').removeClass('sleep');
                        searchArea = false;
                    }


                });
            }
        })


    });
</script>
<script>
    $(document).ready(function () {
        $("#cust_nav").bind("click", function () {
            
            var setFlag = $(this).attr('data-click');
            if (setFlag == 0) {
                $('#sidebar').css('left', '0');
                $(this).attr('data-click', '1');
            }
            else {
                $('#sidebar').css('left', '');
                $(this).attr('data-click', '0');
            }
            // alert();
        });
    });
    $(document).ready(function () {
        $("#cust_nav_admin").bind("click", function () {
            
            var setFlag = $(this).attr('data-click');
            if (setFlag == 0) {
                $('#top-menu').css('display', 'block');
                $('#top-menu').css('left', '0');
                $(this).attr('data-click', '1');
            }
            else {
                $('#top-menu').css('display', 'none');
                $('#top-menu').css('left', '');
                $(this).attr('data-click', '0');
            }
            // alert();
        });
        setTimeout(function () {
            $('.page-container').css('opacity',1);
        },1000);
    });

</script>
<script>
    $(document).ready(function () {
        
        App.init();
        FormMultipleUpload.init();

        FormPlugins.init();
        TableManageButtons.init();
        

    });

</script>
<script>
    $(document).ready(function () {
        
        Chart.init();
    });
</script>
<script>


    $(document).ready(function () {

        DashboardV2.init();

    });

</script>
<script>

    $(document).ready(function () {

        TableManageScroller.init();
        setTimeout(function () {
            $('.hide-open td').on('click', function () {
                row = $(this).parent().data('click');

                $('.hide-click[data-click="' + row + '"]').toggle();

            });
        }, 1000)

    })


</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF9VNVX');</script>
<!-- End Google Tag Manager -->





<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF9VNVX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



</body></html>
