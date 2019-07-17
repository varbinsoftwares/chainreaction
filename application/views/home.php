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
        position: absolute;
        /* padding: 4px; */
        /* float: left; */
        border: none;
        background-repeat: no-repeat!important;
        background-size: cover!important;
        height: 30px;
        width: 30px;
        /* left: 11%; */
        /* top: 12%; */
        /* margin: 20px auto; */
        margin-top: 10px;
        margin-left: -20px;
        /* left: 0px; */
        /* margin-left: 5px; */
        transition: all 0.5s;

    }
    .matrixtable{
        width: 100%;
    }
    .indexclass i {
        /* position: absolute; */
        margin-left: -13px;
        display: none;
        border: 1px solid #000;
        border-radius: 50%;

    }
    .indexclass span:nth-child(3) {
        margin-top: 19px;
        margin-left: -14px;
    }

    .indexclass span:nth-child(4) {
        margin-top: -8px;
        margin-left: -14px;
    }



    .indexclass span:nth-child(2) {

        margin-left: -2px;


    }

    .indexclass i:nth-child(1) {
        margin-left: 0px;
        margin-top: -5px;


    }
    .winner_class{
        color: white;
        padding: 5px;
        text-align: center;
        text-transform: capitalize;
        text-shadow: 0px 0px 5px #000;
    }
    .playerlist{
        background: #fff;
        padding: 0px 20px;
    }
    span.playerlist.removed {
        text-decoration: line-through;
    }
</style>
<!--Services-->
<div class="options-wthree" ng-controller="gameController">


    <div class="container">


    
        <div class="col-md-4">
            <table class=" matrixtable animated bounceInUp">
                <tr ng-repeat="row in []| range:matrix.row">
                    <td ng-repeat="col in []| range: matrix.col" id="{{$parent.$index}}{{$index}}" indexattr ="{{$parent.$index}}{{$index}}"  class="button button-small button-positive indexclass text-center" style="border: 3px solid {{matrix.nextColor}};">

                        <data style="display: none">{{checkcolor = matrix.gamemove[$parent.$index + '' + $index][0]}}</data>
                        <div class="matrix_element" ng-click="playMove($parent.$index, $index)" style="height: {{matrix.colwidth}}px;width: {{matrix.colwidth}}px;"  class="">
                            <span class="{{matrix.atom_size}} animated {{matrix.animation}} {{matrix.animationInterval}} ball_element" ng-repeat="atm in []| range: matrix.gamemove[$parent.$index + '' + $index].length" style="background:url(<?php echo base_url(); ?>assets/balls/{{checkcolor}}.png);line-height: {{matrix.colwidth}}px;"></span>

                        </div>

                    </td>    
                </tr>

            </table>
            <h2 class="winner_class"  style="background:{{matrix.winner}};color:white;">{{matrix.winner}} Winner <br/>
                <center>
                    <button class="btn btn-default" ng-if="matrix.winner" onclick="window.location.reload()"><i class="fa fa-refresh"></i> Replay</button>
                    <button class="btn btn-default" onclick="window.location = '<?php echo site_url("/"); ?>'"><i class="fa fa-refresh"></i> Reset</button>

                </center>

            </h2>

        </div>
        <button ng-click="onlineMoveGet()" class="btn btn-default">Get Move</button>
        
        <div class="col-md-7">
            <ul class="list-group">
                <li class="list-group-item" style="background:{{k}};padding: 0px;" ng-repeat="(k, v) in matrix.game_player" ng-if="v.status == 'active'"><span class="playerlist {{v.status}}">{{v.player}}</span></li>
                <li class="list-group-item" style="background:{{k}};padding: 0px;" ng-repeat="(k, v) in matrix.game_player" ng-if="v.status != 'active'"><span class="playerlist {{v.status}}">{{v.player}}</span></li>

            </ul>


            <br/>
            <!--{{matrix}}-->
        </div>










    </div>

    <audio id="gamemove">
        <source src="<?php echo base_url(); ?>assets/sound/move.mp3" type="audio/mpeg">
    </audio>
    <audio id="gamewinner">
        <source src="<?php echo base_url(); ?>assets/sound/winner.mp3" type="audio/mpeg">
    </audio>

    <audio id="gameerror">
        <source src="<?php echo base_url(); ?>assets/sound/error.mp3" type="audio/mpeg">
    </audio>


    <div class="modal fade" id="gameInitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Initialize The Game</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="get">
                        <div class="form-group">
                            <label for="matrix">Matrix</label>
                            <select name="matrix">
                                <option value="3">3X3</option>
                                <option value="4">4X4</option>
                                <option value="5">5X5</option>
                                <option value="6">6X6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="players">Number Of Players</label>
                            <select name="players">
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>                       
                        </div>


                        <button type="submit" class="btn btn-default" name="start_game" value="submit">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>   


</div>
<!--//Services-->





<?php
$this->load->view('layout/footer');
?>
<script type = "text/javascript" 
        src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js">
</script>

<script>
    var gameArray = <?php echo $gamearray; ?>;
    var gamestart = <?php echo $gameinit; ?>;</script>
<script src="<?php echo base_url(); ?>assets/theme/angular/gameController.js"></script>
<style>

    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>