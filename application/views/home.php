<?php
$this->load->view('layout/header');
?>
<style>
    .indexclass {
        padding: 0px;
        height: 20px;
        width: 20px;
        border: 1px solid #000;
    }
    .indexclass span {
        padding: 4px;

        float: left;
        border: none;
    }
    .matrixtable{
        width: 100%;
    }
    .indexclass i {
        /* position: absolute; */
        margin-left: -13px;
        display: none;
    }
    .indexclass i:nth-child(3) {
           position: absolute;
    /* margin-left: -35px; */
    margin-top: 22px;
    display: inline;
    left: 48%;
    }
    .indexclass i:nth-child(2) {

        margin-left: -10px;
        display: inline;

    }

    .indexclass i:nth-child(1) {
        margin-left: 0px;
        margin-top: -5px;
        display: inline;

    }
    .winner_class{
        color: white;
        padding: 5px;
        text-align: center;
        text-transform: capitalize;
    }
</style>
<!--Services-->
<div class="options-wthree" ng-controller="gameController">


    <div class="container">


        <table class="matrixtable animated bounceInUp">
            <tr ng-repeat="row in []| range:matrix.row">
                <td ng-repeat="col in []| range: matrix.col" id="{{$parent.$index}}{{$index}}" indexattr ="{{$parent.$index}}{{$index}}"  class="button button-small button-positive indexclass text-center" style="border: 3px solid {{matrix.nextColor}};">
                    <span style="display: none">{{checkcolor = matrix.gamemove[$parent.$index + '' + $index][0]}}</span>
                    <span ng-click="getIndex($parent.$index, $index, checkcolor)" style="height: {{matrix.colwidth}}px;width: {{matrix.colwidth}}px;"  class="">
                        <i class="fa fa-circle fa-{{matrix.atom_size}} animated zoomIn delay-2s" ng-repeat="atm in []| range: matrix.gamemove[$parent.$index + '' + $index].length" style="color:{{checkcolor}};line-height: {{matrix.colwidth}}px;"></i>
                    </span>
                </td>    
            </tr>

        </table>
        <h2 class="winner_class" ng-if="matrix.winner" style="background:{{matrix.winner}};color:white;">{{matrix.winner}} Winner <br/>
            <center><button class="btn btn-default" onclick="window.location.reload()"><i class="fa fa-refresh"></i></button></center>
        </h2>

        <div class="alert alert-warning alert-dismissible animated {{matrix.message}}" role="alert" ng-if="matrix.message" style="background: red">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong style="color:white">Invalid Move</strong> 
        </div>


    </div>
</div>
<!--//Services-->

<?php
$this->load->view('layout/footer');
?>
<script src="<?php echo base_url(); ?>assets/theme/angular/gameController.js"></script>
<style>

    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>