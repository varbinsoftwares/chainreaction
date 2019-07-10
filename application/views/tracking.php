<?php
$this->load->view('layout/header');
?>
<style>
    #map {
        height: 500px;
    }
    /* Optional: Makes the sample page fill the window. */

    #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }
    #warnings-panel {
        width: 100%;
        height:10%;
        text-align: center;
    }
</style>
<!-- breadcrumbs -->
<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/pickride"); ?>">Pick Ride</a><span>«</span></li>

                <li>Track Ride</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->
<!-- Appointment -->
<div class="locations-w3-agileits">
    <div class="container">
        <div class="location-agileits" >
            <div class="loc-left">

                <div id="map"></div>
                &nbsp;
                <div id="warnings-panel"></div>
            </div>
            <div class="loc-right">


            </div>
            <div class="clearfix"> </div>
        </div>


        <script>
            // Note: This example requires that you consent to location sharing when
            // prompted by your browser. If you see the error "The Geolocation service
            // failed.", it means you probably did not give permission for the browser to
            // locate you.
            var map, infoWindow, marker;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 16
                });
                $.get("<?php echo site_url('Api/gpsPosition/'.$user_id); ?>", function (result) {


                
                    console.log(result)
                    var pos = {
                        lat: Number(result.lat),
                        lng: Number(result.lng)
                    };
                    marker = new google.maps.Marker({
                        position: pos,
                        icon: "<?php echo base_url(); ?>assets/images/Car.png",
                        map: map
                    });
                    map.setCenter(pos);
                })


            }




            setInterval(function () {

                $.get("<?php echo site_url('Api/gpsPosition/'.$user_id); ?>", function (result) {
                    var pos = {
                        lat: Number(result.lat),
                        lng: Number(result.lng)
                    };
                    var latlng = new google.maps.LatLng(Number(result.lat), Number(result.lng));
                    marker.setPosition(latlng);
                    map.setCenter(pos);
                })



            }, 5000)


        </script>


       
    </div>
</div>
<?php
$this->load->view('layout/footer');
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG-NpKiDnTrBNcGJGzXaC0ufdr1URu8A0&libraries=places&callback=initMap" async defer></script>
<script>