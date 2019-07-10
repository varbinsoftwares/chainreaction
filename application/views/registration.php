<?php
$this->load->view('layout/header');
?>
<div class="login-top sign-top">
    <div class="agileits-login">
     
        <h5>Registration</h5>
           <?php echo $msg;?>
        <form action="#" method="post">
            <input type="text" name="user_name" placeholder="Username" required=""/>
            <input class="name" type="text"  name="mobile_no" placeholder="Mobile No." required=""/>
            <input type="password"  class="pass" name="password" placeholder="Password" required=""/>
            <input type="password" class="con_pass" name="con_password" placeholder="Confirm Password" required=""/>

            <div class="w3ls-submit"> 
                <input type="submit" name="submit" value="Register">  	
            </div>	
        </form>

    </div>  
</div>

<?php
$this->load->view('layout/footer');
?>