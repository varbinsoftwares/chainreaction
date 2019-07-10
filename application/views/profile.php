<?php
$this->load->view('layout/header');
?>

<!-- breadcrumbs -->
<div class="w3l_agileits_breadcrumbs">
    <div class="container">
        <div class="w3l_agileits_breadcrumbs_inner">
            <ul>
                <li><a href="<?php echo site_url("Shop/index"); ?>">Home</a><span>«</span></li>

                <li>Profile</li>
            </ul>
        </div>
    </div>
</div>		
<!-- //breadcrumbs -->
<div class="timings-w3ls">
    <h5>User Profile</h5>
    <ul>
        <li>Name<span style="color:white;"><?php echo $user_data->user_name; ?></span></li>
        <li>Contact No.<span style="color:white;"><?php echo $user_data->mobile_no; ?></span></li>
        <li> 
            <button class="btn btn-primary btn-sm " href="#profileModal" data-toggle="modal" >
                <i class="fas fa-check"></i> Update Profile</button>
        </li>

        <!-- modal -->
        <div class="modal about-modal w3-agileits fade" id="profileModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
                    </div> 
                    <div class="modal-body login-page "><!-- login-page -->     
                        <div class="login-top sign-top">
                            <div class="agileits-login">
                                <h5>Update Profile</h5>

                                <form action="#" method="post">
                                    <input type="text" name="user_name" placeholder="Enter Name">

                                    <div class="w3ls-submit"> 
                                        <input type="submit" name="update_profile" value="Update Profile">  	
                                    </div>

                                </form>

                            </div>  
                        </div>
                    </div>  
                </div> <!-- //login-page -->
            </div>
        </div>
    </ul>
</div>

<div class="well well-sm" style="margin:10px 5px 10px 5px">
    <!--<input type="text" id="positionval" style="width: 100%"/>-->
    <div class="row">
        <form method="post" action="#" class="col-xs-6">
            <input type = "submit" name="starttracking"  class="btn btn-lg btn-success"  value = "Start Tracking"  <?php echo $trackingstatus=='Yes'?'disabled':'';?>/>
        </form>
        <form method="post" action="#"  class="col-xs-6">
            <input type = "submit" name="stoptracking"  class="btn btn-lg pull-right btn-danger" <?php echo $trackingstatus=='No'?'disabled':'';?>  value = "Stop Tracking"/>
        </form>
    </div>

</div>

<?php
$this->load->view('layout/footer');
?>
