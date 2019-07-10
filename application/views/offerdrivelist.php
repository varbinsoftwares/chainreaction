<?php
$this->load->view('layout/header');
?>

<!-- breadcrumbs -->
<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/index"); ?>">Home</a><span>«</span></li>

                <li>Your Offer Drive List</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->

<?php
foreach ($user_ride_data as $key => $value) {
    ?> 

    <div class="clearfix"></div>
    <div class="form-agileits">
        <h3>Offer Drive Detail</h3>

        <hr>
        Vehicle Name : <span><?php echo $value['vehicle_name']; ?></span><br/>
        Vehicle No : <span><?php echo $value['vehicle_no']; ?></span><br/>
        Start Point : <span><?php echo $value['start_point']; ?></span><br/>
        End Point : <span><?php echo $value['end_point']; ?></span><br/>
        Pickup Date :<span> <?php echo $value['off_date']; ?></span><br/>
        Pickup Time : <span><?php echo $value['pickup_time']; ?></span><br/>
        Available Sit: <span><?php echo $value['available_sit']; ?></span><br/>
        Amount: <span><?php echo $value['offer_amount']; ?> <br/>
            <form action="#" method="post">

                <button class="btn btn-danger btn-sm" value="<?php echo $value['id'] ?>" name="delete_drive"><i class="fas fa-trash"></i> Delete Ride</button>
            </form>
            <hr>
            <h3 style="margin-bottom:10px;">
                <?php if ($value['picker']) { ?> 
                    <span>Pickup Drive List</span>
                <?php } else { ?>
                    <span style="color:  red">No  Pickup Drive Found</span>
                <?php } ?>
            </h3>

            <?php foreach ($value['picker'] as $key1 => $value1) { ?>
                <div class="">
                    <h4><?php echo $value1['user_name'] ?></h4>
                    <p><?php echo $value1['mobile_no'] ?></p>

                    <form action="#" method="post">

                        <?php if ($value1['status'] == 'Done') { ?>

                            <button class="btn btn-danger btn-sm" value="<?php echo $value1['id'] . '+' . $value1['mobile_no'] ?>" name="cancel_drive"><i class="fas fa-trash"></i> Cancel Ride</button>

                        <?php } else { ?>
                            <button class="btn btn-primary btn-sm" value="<?php echo $value1['id'] . '+' . $value1['mobile_no'] ?>" name="confirm_pick_drive_id" ><i class="fas fa-check"></i> Confirm  Ride</button>


                        <?php }
                        ?>  
                    </form>



                </div>
                <div class="clearfix"> </div>
            <?php }; ?>  


    </div>



<?php } ?>
<?php
$this->load->view('layout/footer');
?>
