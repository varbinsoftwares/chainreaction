<?php
$this->load->view('layout/header');
?>

<div class="login-top sign-top">
    <div class="agileits-login">

        <h5>Please Insert OTP</h5>
        <?php echo $msg;?>
        <form  action="#" method="post" >
            <input type='text' name='password2' placeholder="OTP" required=""/>

            <div class="w3ls-submit"> 
                <input type="submit" name="otpCheck" value="otp Check">  	
            </div>	
        </form>

    </div>  
</div>

<?php
$this->load->view('layout/footer');
?>