<?php
$this->load->view('layout/header');
?>

<!-- breadcrumbs -->
<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/index"); ?>">Home</a><span>«</span></li>

                <li>Pick Ride</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->
  <?php
           // print_r($this->session->userdata('logged_in'));
              $session_data1 = $this->session->userdata('distnceinfo');
             //print_r($session_data1['dis']);
            ?>
<!-- Appointment -->
<div class="locations-w3-agileits">
    <div class="container">
        <div class="form-group">
            <h4>Your Current Location</h4><br/>
            <p id='origin-input'><?php echo $session_data1['address']?> </p>
            <input type="button" class="btn btn-primary" onclick="getLocation()" value="Get current location"><br/>

          <hr>
            <form action="" method="post">
                <input   type="hidden" class="controls" name="lat" value="<?php echo $session_data1['lat']?>" />
                <input   type="hidden" class="controls" name="lng" value="<?php echo $session_data1['lng']?>" />
                <label for="exampleFormControlSelect1">Select Distance</label>
                <select class="form-control" name="distance" id="distance" >


                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <button class="btn btn-primary" type="submit"  name='search'><i class="fas fa-search"></i> Search by Distance</button>
                <button class="btn btn-success" type="submit"  name='allsearch'><i class="fas fa-search"></i> Search All</button>

            </form>

        </div>
        <?php
        if ($attr_value) {
            foreach ($attr_value as $key => $value) {
                ?> 
                <div class="" style="padding: 10px 0px;border-bottom: 2px solid #000 " >
                    <div class="loc-left">

                                                                                                        <!--                    <h4>Person Name : <?php echo $value['person_name'] ?></h4>-->
                        <h4>Contact No. : <?php echo $value['contact_no'] ?></h4>
                        <p>Vehicle  Name : <?php echo $value['vehicle_name'] . '[' . $value['vehicle_no'] . ']' ?> </p>
                        <p>Start Point : <?php echo $value['start_point'] ?></p>
                        <p>End Point : <?php echo $value['end_point'] ?></p>
                        <p>Available Sits : <?php echo $value['available_sit'] ?></p>
                        <p>Pickup Date : <?php echo $value['off_date'] ?></p>
                        <p>Pickup Time : <?php echo $value['pickup_time'] ?></p>
                        <p>Ride Amount : <?php echo $value['offer_amount'] ?>/- Per Person <br/>

                            <a class="btn btn-success btn-sm pull-left" href="<?php echo site_url("Shop/drivemap/" . $value['id']); ?>" ><i class="fas fa-eye"></i> View Map</a>

                            <?php
                            $session_data = $this->session->userdata('logged_in');

                            if ($value['contact_no'] == $session_data['mobile_no']) {
                                ?>
                                <button class="btn btn-primary btn-sm pull-right"  disabled><i class="fas fa-check"></i> Your Ride</button>

                                <?php
                            } else {

                                if ($value['stat'] == 1) {
                                    ?>

                                <form action="#" method="post"> 
                                    <button class="btn btn-danger btn-sm pull-right " value="<?php echo $value['id'] . '+' . $value['contact_no'] ?>" name="cancel_pick_ride"><i class="fas fa-trash"></i> Cancel Ride</button>
                                </form>
                            <?php } else { ?>
                                <button class="btn btn-primary btn-sm pull-right" href="#myModalNew<?php echo $key; ?>" data-toggle="modal" ><i class="fas fa-check"></i> Pick Ride</button>

                                <?php
                            }
                        }
                        ?>

                        </p>
                    </div>

                    <div class="clearfix"> </div>
                </div>

                <!-- modal -->
                <div class="modal about-modal w3-agileits fade" id="myModalNew<?php echo $key; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
                            </div> 
                            <div class="modal-body login-page "><!-- login-page -->     
                                <div class="login-top sign-top">
                                    <div class="agileits-login">
                                        <h5>Confirm Ride</h5>

                                        <form action="#" method="post">
                                            <input type="hidden" name="offer_drive_id" value=" <?php echo $value['id'] ?>">
                                            <input type="hidden" name="picker_no" value=" <?php echo $session_data['mobile_no'] ?>">
                                            <input type="hidden" name="offer_no" value=" <?php echo $value['contact_no'] ?>">

                                            <div class="w3ls-submit"> 
                                                <input type="submit" name="confirm_pick_drive" value="Confirm Now">  	
                                            </div>

                                        </form>

                                    </div>  
                                </div>
                            </div>  
                        </div> <!-- //login-page -->
                    </div>
                </div>


                <?php
            }
        } else {
            ?>
            <h4>No Drive Available For Selected Distance</h4>
        <?php } ?>
    </div>
</div>

<?php
$this->load->view('layout/footer');
?>


<script type="text/javascript">

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }
    function showPosition(position) {

        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
       
        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
               
                    var data = {'lat': latitude, 'lng': longitude, 'address':  results[1].formatted_address,'dis':$("#distance").val()};
                //console.log(data);   
                $.post("<?php echo site_url("Api/getAddress") ?>", data, function () {
                        window.location = "<?php echo site_url("Shop/pickride");?>"
                    })


                }
            }
        });
    }
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            mapTypeControl: false,
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });

        //new AutocompleteDirectionsHandler(map);
    }
   $(function(){
      $("#distance").val('<?php echo $session_data1['dis']?>');
       
   })

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG-NpKiDnTrBNcGJGzXaC0ufdr1URu8A0&callback=initMap" async defer></script>
