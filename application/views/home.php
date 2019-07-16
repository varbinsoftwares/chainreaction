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
        border: 1px solid #000;
        border-radius: 50%;
    }
    .indexclass i:nth-child(3) {

        margin-left: -5px; 

        display: inline;

    }
    .indexclass i:nth-child(2) {

        margin-left: -5px;
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
        
        
        <form name="frmChat" id="frmChat">
			<div id="chat-box"></div>
			<input type="text" name="chat-user" id="chat-user" placeholder="Name" class="chat-input" required />
			<input type="text" name="chat-message" id="chat-message" placeholder="Message"  class="chat-input chat-message" required />
			<input type="submit" id="btnSend" name="send-chat-message" value="Send" >
		</form>
        <div class="col-md-4">
            <table class=" matrixtable animated bounceInUp">
                <tr ng-repeat="row in []| range:matrix.row">
                    <td ng-repeat="col in []| range: matrix.col" id="{{$parent.$index}}{{$index}}" indexattr ="{{$parent.$index}}{{$index}}"  class="button button-small button-positive indexclass text-center" style="border: 3px solid {{matrix.nextColor}};">
                        <span style="display: none">{{checkcolor = matrix.gamemove[$parent.$index + '' + $index][0]}}</span>
                        <span class="matrix_element" ng-click="playMove($parent.$index, $index)" style="height: {{matrix.colwidth}}px;width: {{matrix.colwidth}}px;"  class="">
                            <i class="fa fa-circle fa-{{matrix.atom_size}} animated zoomIn delay-2s" ng-repeat="atm in []| range: matrix.gamemove[$parent.$index + '' + $index].length" style="color:{{checkcolor}};line-height: {{matrix.colwidth}}px;"></i>
                        </span>
                    </td>    
                </tr>

            </table>
            <h2 class="winner_class"  style="background:{{matrix.winner}};color:white;">{{matrix.winner}} Winner <br/>
                <center>
                    <button class="btn btn-default" ng-if="matrix.winner" onclick="window.location.reload()"><i class="fa fa-refresh"></i> Replay</button>
                    <button class="btn btn-default" onclick="window.location = '<?php echo site_url("/"); ?>'"><i class="fa fa-refresh"></i> Reset</button>

                </center>

            </h2>

            <div class="alert alert-warning alert-dismissible animated {{matrix.message}}" role="alert" ng-if="matrix.message" style="background: red">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong style="color:white">Invalid Move</strong> 
            </div>
        </div>
        <div class="col-md-7">
            <ul class="list-group">
                <li class="list-group-item" style="background:{{k}};padding: 0px;" ng-repeat="(k, v) in matrix.game_player" ng-if="v.status=='active'"><span class="playerlist {{v.status}}">{{v.player}}</span></li>
                <li class="list-group-item" style="background:{{k}};padding: 0px;" ng-repeat="(k, v) in matrix.game_player" ng-if="v.status!='active'"><span class="playerlist {{v.status}}">{{v.player}}</span></li>

            </ul>


            <br/>
<!--{{matrix}}-->
        </div>








    </div>


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