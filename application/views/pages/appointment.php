<?php
$this->load->view('layout/header');
$prefixshopappointment = array('Sun' => [9, 19], 'Other' => [9, 21]);
$cdateshort = date("D");
$timingarray = [];
if (isset($prefixshopappointment[$cdateshort])) {
    $timingarray = $prefixshopappointment[$cdateshort];
} else {
    $timingarray = $prefixshopappointment['Other'];
}
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    #ui-datepicker-div{
        z-index: 200000!important;
    }
</style>
<!-- Inner Page Banner Area Start Here -->
<div class="inner-page-banner-area" style="    background: url(<?php echo base_url(); ?>assets/images/shop2.jpg);
     background-size: cover;
     background-position: 459px -1031px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb-area">
                    <h1>Appointment</h1>
                    <ul>
                        <li><a href="#">Home</a> /</li>
                        <li>Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->
<!-- Contact Us Page Area Start Here -->
<!-- Single Blog Page Area Start Here -->
<div class="single-blog-page-area" style="padding: 0px 0 0px;background: url(<?php echo base_url(); ?>assets/theme2/img/mapback.png);background-size: contain;">
    <div class="container contact-us-page-area" style="padding: 50px 0 30px;">
        <div class="row" style="border-bottom: 2px solid;    background: #ffffffb5; ">
            <div class="contact-us-right">
                <h2 class="title-sidebar text-center" style="margin-bottom: 30px;padding-bottom:  30px;border-bottom: 1px dotted ">Local Appointment</h2>
                <div class="col-md-3">

                    <ul style="    margin-bottom: 30px;">
                        <li class="con-address">2nd Floor, 45 Haiphong Road,
                            <br/>
                            Tsim Sha Tsui, Kowloon, <br/>Hong Kong
                        </li>

                    </ul>
                </div>
                <div class="col-md-3">
                    <ul style="    margin-bottom: 30px;">

                        <li class="con-envelope">info@bespoketailorshk.com</li>
                        <li class="con-phone">+(852) 2730 8566</li>


                    </ul>
                </div>
                <div class="col-md-3">
                    <ul style="    margin-bottom: 30px;">

                        <li class=""><i class="con-clock fa fa-clock-o"></i> 
                            <span class="timeing_opensm">Timing</span><br/>
                            <span class="timeing_open">Mon - Sat</span>: 09:00 to 19:00 <br/>
                            <span class="timeing_open">Sun & Holidays</span>: 09:00 to 18:00
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger btn-lg" style="background: black" data-toggle="modal" data-target="#schedule_modal_shop">Book Now</button>
                </div>
            </div>
        </div>

        <!--global appointment-->
        <div class="row"  style="border-bottom: 2px solid;    background: #ffffffb8; ">
            <div class="contact-us-right">
                <h2 class="title-sidebar text-center" style="margin: 30px;padding-bottom:  30px;border-bottom: 1px dotted ">Global Appointment</h2>

                <p class="text-center" style="font-size: 20px;">Coming Soon</p>

            </div>

        </div>
    </div>
</div>
<!-- Single Blog Page Area End Here -->
<!-- Contact Us Page Area End Here -->




<div class = "modal fade" id = "schedule_modal_shop"  role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog ">
        <div class = "modal-content">
            <form method="post" action="#">
                <div class = "modal-header" style=" color: #fff;background: #000 ">
                    <button type = "button" style="    background-color: #000;
                            border: 1px solid #000;" class = " btn btn-danger btn-xm pull-right" data-dismiss = "modal" aria-hidden = "true">

                        <i class="fa fa-close"></i>

                    </button>

                    <div class = "modal-title row" id = "myModalLabel">

                        <address style="    margin-bottom: 0;">
                            <span id="location"><b>Appointment</b>
                            </span><br>
                            <span id="address">2nd Floor, 45 Haiphong Road,
                            <br/>
                            Tsim Sha Tsui, Kowloon, Hong Kong</span><br>
                        </address>

                        <div style="clear: both"></div>
                    </div>
                </div>



                <div class = "modal-body">


                

                    <div class="row" style="    border-bottom: 1px solid #E5E5E5;">
                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">

                                <label for="first_name">Last Name</label> 
                                <input type="text" class="time start form-control" name="last_name"  style="height:34px;" required/>

                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">

                                <label for="first_name">First Name</label> 
                                <input type="text" class="time start form-control" name="first_name"  style="height:34px;" required />

                            </div>
                        </div>


                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">
                                <label for="first_name">No. Of Persons</label> 
                                <input  class="time start form-control" type="number"  name="no_of_person"  style="height:34px;" min="1" value="1" />

                            </div>
                        </div>
                    </div>

                    <div class="row" style="    border-bottom: 1px solid #E5E5E5;">
                        <div class="col-md-6" >
                            <div class="form-group" style="font-color:black">

                                <label for="first_name">Email</label> 
                                <input type="text" class="time start form-control" name="email"   style="height:34px;" required />

                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="form-group" style="font-color:black">

                                <label for="first_name">Contact No.</label> 
                                <input type="text" class="time start form-control" name="contact_no"  style="height:34px;" required />

                            </div>
                        </div>
                    </div>
                    
                    
                        <div class="row" style="    border-bottom: 1px solid #E5E5E5;">
                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">

                                <label for="select_date">Available Date</label> 

                                <div class="input-group date" id="datepicker">
                                    <input class="form-control" id="appintmentDate" type="text" required class="form-control" name="select_date"  readonly=""  style="height:34px;" required value="<?php echo date("Y-m-d"); ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">

                                <label for="select_time">Available Time</label> 
                                <select class="form-control" name="select_time" id="select_time" style="height:34px;" required />
                                <?php
                                for ($tm = $timingarray[0]; $tm < $timingarray[1]; $tm++) {
                                    $tm1 = ($tm < 10 ? '0' . $tm : $tm);
                                    $tms1 = $tm1 . ":00 - $tm1:30";
                                    $tm2 = $tm1 + 1;
                                    $tms2 = $tm1 . ":30 - $tm2:00";

                                    $tms12 = $tm1 . ":00";

                                    $tms13 = $tm1 . ":30";


                                    echo "<option>$tms12</option>";
                                    echo "<option>$tms13</option>";
                                }
                                ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group" style="font-color:black">

                                <label for="select_date">Referral</label> 

                                <select class="form-control" name="referral" id="select_time" style="height:34px;" required >
                                    <option value="">Select</option>
                                    <option value="Newspaper">Newspaper</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="E-Newsletter">E-Newsletter</option>
                                    <option value="Online Search">Online Search</option>
                                    <option value="Word of Mouth">Word of Mouth</option>
                                    <option value="Paper Flier">Paper Flier</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="I am a Repeat Customer">I am a Repeat Customer</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <!--                    <div class="row" style="    border-bottom: 1px solid #E5E5E5;">
                                            <div class="col-md-12" >
                                                <label for="first_name">Address</label> <br>
                                                <textarea name="address" class="form-control"  rows="1" cols="27" style="height: 94px !important;"></textarea>
                                            </div>
                                        </div>-->



                    <div style="clear:both"></div>
                </div>









                <div class = "modal-footer">


                    <button type = "submit" name="submit" class="btn btn-danger" style="background: black" >
                        Book Appointment
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--angular controllers-->
<script src="<?php echo base_url(); ?>assets/theme/angular/productController.js"></script>
<script>
    $(document).ready(function () {
        $("#appintmentDate").datepicker({
            minDate: 0,
            dateFormat: "yy-mm-dd"
        });
        $.datepicker.parseDate("yy-mm-dd", "<?php echo date('Y-m-d'); ?>");
    });

</script>

<?php
$this->load->view('layout/footer');
?>