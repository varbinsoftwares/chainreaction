<?php
$this->load->view('layout/header');
?>
<!-- breadcrumbs -->
<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/index"); ?>">Home</a><span>«</span></li>

                <li>Confirmed Drive</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->
<div class="appointment">
    <div class="container">

        <?php
        if ($result) {
            foreach ($result as $key => $value) {
                ?>
                <div class="timings">

                    <div class="list-group ">
                        <a href="#" class="list-group-item active list-group-item-warning">
                            <h4 class="list-group-item-heading">Confirmed Drive</h4>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Contact No.</h4>
                            <p class="list-group-item-text"><?php echo $value['contact_no'] ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Vehicle Name</h4>
                            <p class="list-group-item-text"><?php echo $value['vehicle_name'] ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Start Point</h4>
                            <p class="list-group-item-text"><?php echo $value['start_point'] ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">End Point</h4>
                            <p class="list-group-item-text"><?php echo $value['end_point'] ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Pickup Time</h4>
                            <p class="list-group-item-text"><?php echo $value['pickup_time'] ?></p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Amount</h4>
                            <p class="list-group-item-text"><?php echo $value['offer_amount'] ?>/-</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <a class="btn btn-danger" href="<?php echo site_url("AccountController/tracklocation/".$value['user_id'])?>"><i class="fa fa-map-marker"></i> Tracking  Ride</a>

                        </a>

                    </div>


                </div>

                <?php
            }
        } else {
            ?>
            <h5>You do not have any confirmed drive.</h5>
        <?php } ?>
    </div>
</div>

<?php
$this->load->view('layout/footer');
?>
