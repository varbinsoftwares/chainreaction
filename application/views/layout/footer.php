
<script src="<?php echo base_url(); ?>assets/theme/angular/mainController.js"></script>


<!-- js -->
<script type='text/javascript' src='<?php echo base_url(); ?>assets/theme/js/jquery-2.2.3.min.js'></script>
<!-- //js -->
<script src="<?php echo base_url(); ?>assets/theme/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets/theme/js/scripts.js"></script>

<!--responsiveslides js-->
<script src="<?php echo base_url(); ?>assets/theme/js/responsiveslides.min.js"></script>
<script>
    // You can also use "$(window).load(function() {"
    $(function () {
        // Slideshow 4
        $("#slider4").responsiveSlides({
            auto: true,
            pager: true,
            nav: false,
            speed: 500,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });

    });
</script>
<script>
    // You can also use "$(window).load(function() {"
    $(function () {
        // Slideshow 3
        $("#slider3").responsiveSlides({
            auto: true,
            pager: false,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });

    });
</script>

<!--//responsiveslides js-->
<script src="<?php echo base_url(); ?>assets/theme/js/SmoothScroll.min.js"></script>
<!--menu script-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/theme/js/modernizr-2.6.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/theme/js/classie.js"></script>
<script src="<?php echo base_url(); ?>assets/theme/js/demo1.js"></script>
<!--//menu script-->

<!-- banner -->
<script type='text/javascript' src='<?php echo base_url(); ?>assets/theme/js/jquery.easing.1.3.js'></script> 
<!-- //banner -->

<!-- //jarallax -->
<script src="<?php echo base_url(); ?>assets/theme/js/jquery-ui.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
        });
    });
</script>
<!--js for bootstrap working-->
<script src="<?php echo base_url(); ?>assets/theme/js/bootstrap.js"></script>
<!-- //for bootstrap working -->



<script type = "text/javascript">
    var watchID;
    var geoLoc;
<?php
$trackingstatus = $this->session->userdata('trackingstatus');
if ($trackingstatus == 'Yes') {
    $session_data = $this->session->userdata('logged_in');
    if ($session_data) {
        ?>

            function showLocation(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $("#positionval").val("Latitude : " + latitude + " Longitude: " + longitude);
                var data = {'lat': latitude, 'lng': longitude, 'user_id': '<?php echo $session_data['login_id']; ?>'};
                console.log(data);
                $.post("<?php echo site_url("Api/gpsPosition") ?>", data, function () {})



            }

            function errorHandler(err) {
                if (err.code == 1) {
                    alert("Error: Access is denied!");
                } else if (err.code == 2) {
                    alert("Error: Position is unavailable!");
                }
            }

            function getLocationUpdate() {

                if (navigator.geolocation) {

                    // timeout at 60000 milliseconds (60 seconds)
                    var options = {timeout: 6000};
                    geoLoc = navigator.geolocation;
                    watchID = geoLoc.watchPosition(showLocation, errorHandler, options);
                } else {
                    alert("Sorry, browser does not support geolocation!");
                }
            }

            getLocationUpdate();
        <?php
    }
}
?>


</script>



</body>
</html>