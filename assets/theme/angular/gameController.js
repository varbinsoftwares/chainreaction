/* 
 Shop Cart product controllers
 */
App.controller('gameController', function ($scope, $http, $timeout, $interval, $filter) {
    if (gamestart==false) {
        $("#gameInitModal").modal({
            keyboard: false,
            backdrop: false
        });
    }

    $scope.matrix = gameArray;

    function checkConverIndex(inumber) {
        if (inumber > (-1)) {
            var indchanges = "" + (inumber < 10 ? "0" + inumber : inumber);
            if ($scope.matrix.indexgame.hasOwnProperty(indchanges)) {
                return indchanges;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    $scope.getSiblings = function (ind1) {
        var sublings = [];
        var strind = Number(ind1);
        console.log(strind);
        var su = checkConverIndex(strind - 10);
        if (su) {
            sublings.push(su);
        }
        var sd = checkConverIndex(strind + 10);
        if (sd) {
            sublings.push(sd);
        }
        var sl = checkConverIndex(strind - 1);
        if (sl) {
            sublings.push(sl);
        }
        var sr = checkConverIndex(strind + 1);
        if (sr) {
            sublings.push(sr);
        }

        return sublings;
    }





    $timeout(function () {
        $(".indexclass").each(function () {
            $scope.matrix.indexgame["" + this.id] = {};
        });
        $(".indexclass").each(function () {
            var siblist = $scope.getSiblings(this.id);
            $scope.matrix.indexgame["" + this.id] = {"siblings": siblist, "limit": siblist.length, "gamemove": {}};
            $scope.matrix.gamemove["" + this.id] = [];
            $scope.matrix.gamemovelist["" + this.id] = [];
        });
        var maxwidth = $("table").width() - 50;
        var divider = $scope.matrix.col;
        $scope.matrix.colwidth = (maxwidth / divider);
    });

    $scope.checkMove = function (moveind, color) {
        var countmove = $scope.matrix.gamemove[moveind].length;
        var limit = $scope.matrix.indexgame[moveind].limit;
        if (limit == countmove) {
            $scope.matrix.gamemove[moveind] = [];
            var siblings = $scope.matrix.indexgame[moveind].siblings;
            for (sb in siblings) {
                var tempc = [];
                var tempclen = $scope.matrix.gamemove[siblings[sb]].length;
                for (i = 0; i < tempclen; i++) {
                    tempc.push(color);
                }
                $scope.matrix.gamemove[siblings[sb]] = tempc;
                $scope.matrix.gamemove[siblings[sb]].push(color);
                var checklist = [];
                for (gm in $scope.matrix.gamemove) {
                    var gmindlist = $scope.matrix.gamemove[gm];
                    checklist = checklist.concat(gmindlist);
                }
                var checkcolor = checklist.filter((x, i, a) => a.indexOf(x) == i);
                if (checkcolor.length == 1) {
                    $scope.matrix.winner = checkcolor[0];
                    break;
                } else {
                    $scope.checkMove(siblings[sb], color);
                }
            }
        }
    }


    $scope.gameMove = function (player, move, color) {
        $scope.matrix.selectedColor = $scope.matrix.players[player];
        var playerlist = $scope.matrix.moveselect;
        if (playerlist) {
            var npindex = playerlist.indexOf(player);
            var nindexp = npindex + 1;
            if (nindexp == playerlist.length) {
                nindexp = 0;
            }
            $scope.matrix.selectedPlayer = playerlist[nindexp];
            $scope.matrix.nextColor = $scope.matrix.players[$scope.matrix.selectedPlayer];
        } else {

        }
        if ($scope.matrix.gamemove[move].length) {
            $scope.matrix.gamemove[move].push(color);
        } else {
            $scope.matrix.gamemove[move] = [color];
        }
        $scope.checkMove(move, color);
    }



    $scope.getIndex = function (in1, in2, color_t) {
        var move = in1 + "" + in2;
        var player = $scope.matrix.selectedPlayer;
        var color = $scope.matrix.players[player];
        if (color_t) {
            if (color != color_t) {

                $scope.matrix.message = "bounceInUp";
                $timeout(function () {
                    $scope.matrix.message = "bounceOutDown";
                }, 1000)
            } else {
                $scope.gameMove(player, move, color)
            }
        } else {
            $scope.gameMove(player, move, color)
        }
    }

})