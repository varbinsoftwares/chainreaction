<!DOCTYPE html>
<?php
$this->load->view('layout/header');
?>
<link href="<?php echo base_url(); ?>assets/theme/fonts/css/all.css" rel="stylesheet" type="text/css" media="all" /> 
<link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/theme/bootstrap-timepicker/css/timepicker.less" />
<link type="text/css" href="<?php echo base_url(); ?>assets/theme/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
<!-- breadcrumbs -->
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
    }
    .input-group {
        position: relative;
        display: unset !important;
        border-collapse: separate;
    }
    /* Optional: Makes the sample page fill the window. */
    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
    }

    #origin-input,
    #destination-input {
        font-family: Roboto;
        font-size: 15px;
        ;
    }

    #origin-input:focus,
    #destination-input:focus {
        border-color: #4d90fe;
    }

    #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
    }

    #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>

<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/index"); ?>">Home</a><span>«</span></li>

                <li>Offer Drive</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->
<div class="timings-w3ls">
    <h5>User Detail</h5>
    <ul><?php
            $session_data = $this->session->userdata('logged_in');
            ?>
        <li>Mobile No.<span><?php echo $session_data['mobile_no'];  ?></span></li>
    </ul>
</div>
 <div class="clearfix"></div>
    <div class="form-agileits">
            <h3>Offer Drive</h3>
            <p>Providing Transportation Solution</p>
             <div class="clearfix"></div>
              <form action="#" method="post">
                <input  class="name" type="hidden" name="person_name"  value="<?php echo $session_data['user_name']; ?>"/>
                <input  class="name" type="hidden" name="contact_no" value="<?php echo $session_data['mobile_no']; ?>"/>
                <input type="text" name="vehicle_name" placeholder="Vehicle Name" required=""/>

                <input type="text" name="vehicle_no" placeholder="Vehicle Number" required=""/>

                <input  id="datepicker1" name="off_date" type="text" value="" onfocus="this.value = '';" onblur="if (this.value == '') {
                            this.value = 'mm/dd/yyyy';
                        }" placeholder="mm/dd/yyyy" required="">

                <input   type="text" id="origin-input" class="controls" name="start_point" placeholder="Start Point" />
                <span>OR</span><br/>
                <input type="button" class="btn btn-primary" onclick="getLocation()" value="Get current location"><br/>

                <input   type="text" id="destination-input" class="controls" name="end_point" placeholder="End Point" required=""/>
                <input   type="hidden" id="lat" class="controls" name="lat" />
                <input   type="hidden" id="lng" class="controls" name="lng" />

                <div class="input-group bootstrap-timepicker timepicker">
                    <input id="timepicker1" type="text" class=" input-small" name="pickup_time">
                </div>
                <input  class="name" type="text" name="available_sit" placeholder="Available Sits" required=""/>
                <input  class="name" type="text" name="offer_amount" placeholder="Amount" required=""/>
                <?php
                $session_data = $this->session->userdata('logged_in');

                if ($session_data) {
                    ?>
                    <input type="submit" value="Save Detail" name="submit">
                <?php } else { ?>
                    <h2>Please Login First</h2>
                <?php } ?>
            </form>
             <div id="map"></div>
    </div>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 

<?php
$this->load->view('layout/footer');
?>

<script>
                    var x = document.getElementById("demo");

                    function getLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showPosition);
                        } else {
                           
                        }
                    }

                    function showPosition(position) {
//                    x.innerHTML = "Latitude: " + position.coords.latitude +
//                            "<br>Longitude: " + position.coords.longitude;
                        $("#lat").val(position.coords.latitude);
                        $("#lng").val(position.coords.longitude);
                        console.log(position)
                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        var geocoder = geocoder = new google.maps.Geocoder();
                        geocoder.geocode({'latLng': latlng}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                   alert("Location: " + results[1].formatted_address);
                                    $("#origin-input").val(results[1].formatted_address);
                                }
                            }
                        });
                    }


</script>

<script>

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            mapTypeControl: false,
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });

        new AutocompleteDirectionsHandler(map);
    }

    /**
     * @constructor
     */
    function AutocompleteDirectionsHandler(map) {
        this.map = map;
        //this.originPlaceId = null;
        //this.destinationPlaceId = null;
        var originInput = document.getElementById('origin-input');
        var destinationInput = document.getElementById('destination-input');
        var originAutocomplete = new google.maps.places.Autocomplete(originInput);
        var destinationAutocomplete =
                new google.maps.places.Autocomplete(destinationInput);
        var autocomplete = new google.maps.places.Autocomplete(originInput);
        autocomplete.addListener('place_changed', function () {

            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            $("#lat").val(lat);
            $("#lng").val(lng);

        })

    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG-NpKiDnTrBNcGJGzXaC0ufdr1URu8A0&libraries=places&callback=initMap" async defer></script>
<script>
    $(function () {
        $("#datepicker,#datepicker1,#datepicker2,#datepicker3").datepicker();
    });</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/theme/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript">
    $('#timepicker1').timepicker();
</script>