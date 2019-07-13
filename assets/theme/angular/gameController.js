App.controller('gameController', function ($scope, $http, $timeout, $interval, $filter) {
    if (gamestart == false) {
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
            $scope.matrix.indexes.push("" + this.id);
        });
        var maxwidth = $("table").width() - 50;
        var divider = $scope.matrix.col;
        $scope.matrix.colwidth = (maxwidth / divider);
    });
    $scope.removeNoColor = function (checkcolor) {
        var output = $scope.matrix.colors.filter((e, i, l) => checkcolor.indexOf(e) == (-1))
        if (output.length) {
            for (cl in output) {
                var tcolor = output[cl];
                var tnpindex = $scope.matrix.colors.indexOf(tcolor);
                $scope.matrix.game_player[tcolor].status = "removed";
                var tplayer = $scope.matrix.color_players[tcolor];
                delete $scope.matrix.players[tplayer];
            }
            var ctemp = [];
            for (cc in checkcolor) {
                var ccolor = checkcolor[cc];
                var cplayer = $scope.matrix.color_players[ccolor];
                ctemp.push(cplayer);
            }
            $scope.matrix.moveselect = ctemp;
            var c_color = $scope.matrix.selectedColor;
            var player = $scope.matrix.color_players[c_color];
            var npindex = $scope.matrix.colors.indexOf(c_color);
            var npindex = checkcolor.indexOf(c_color);
            var playerlist = $scope.matrix.moveselect;
            var nindexp = npindex + 1;
            if (nindexp == checkcolor.length) {
                nindexp = 0;
            }
            $scope.matrix.selectedPlayer = playerlist[nindexp];
            $scope.matrix.nextColor = $scope.matrix.players[$scope.matrix.selectedPlayer];
        }
    }
    $scope.checkWinnerOrMove = function (c_siblings, count, color) {
        var checklist = [];
        for (gm in $scope.matrix.gamemove) {
            var gmindlist = $scope.matrix.gamemove[gm];
            checklist = checklist.concat(gmindlist);
        }
        var checkcolor = checklist.filter((x, i, a) => a.indexOf(x) == i);
        if (checkcolor.length == 1) {
            $scope.matrix.winner = checkcolor[0];
            $scope.matrix.nextColor = $scope.matrix.winner;
            var wplayer = $scope.matrix.color_players[$scope.matrix.winner];
            var templist = $scope.matrix.moveselect;
            templist.splice(wplayer, 1);
            if (templist) {
                var tcolor = $scope.matrix.players[templist[0]];
                $scope.matrix.game_player[tcolor].status = "removed";
            }
        } else {
            $scope.removeNoColor(checkcolor);
            $scope.checkMove(c_siblings[count], color);
        }
    }
    $scope.siblingsCheck = function (c_siblings, color, count) {
        if (count < c_siblings.length) {
            var tempc = [];
            var tempclen = $scope.matrix.gamemove[c_siblings[count]].length;
            for (i = 0; i < tempclen; i++) {
                tempc.push(color);
            }
            $scope.matrix.gamemove[c_siblings[count]] = tempc;
            $scope.matrix.gamemove[c_siblings[count]].push(color);
            $scope.checkWinnerOrMove(c_siblings, count, color);
            count += 1;
            $scope.siblingsCheck(c_siblings, color, count);
        }
    }
    $scope.checkMove = function (moveind, color) {
        var countmove = $scope.matrix.gamemove[moveind].length;
        var limit = $scope.matrix.indexgame[moveind].limit;
        if (limit == countmove) {
            $scope.matrix.gamemove[moveind] = [];
            var siblings = $scope.matrix.indexgame[moveind].siblings;
            $scope.siblingsCheck(siblings, color, 0);
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
        if ($scope.matrix.winner) {
            $scope.matrix.nextColor = $scope.matrix.winner;
        } else {
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
    }



    $scope.autoMove = function (ind1, ind2) {
        var indx = ind1 + "" + ind2;
        console.log(indx);
        var color = $scope.matrix.gamemove[indx][0] || "";
        $scope.getIndex(ind1, ind2, color)
    }


    $scope.playMove = function (ind1, ind2) {
       
        if ($scope.matrix.selectedPlayer == $scope.matrix.my_player) {
            $scope.autoMove(ind1, ind2);
        }

    }


    $scope.getRandonItem = function () {

        var item = $scope.matrix.indexes[Math.floor(Math.random() * $scope.matrix.indexes.length)];
 console.log($scope.matrix.selectedPlayer, $scope.matrix.my_player)
        if ($scope.matrix.selectedPlayer != $scope.matrix.my_player) {
            $timeout(function(){
               $scope.autoMove(item[0], item[1]); 
            })
             
        }
    }
//  
    $interval(function () {
        console.log("sdfsd");
        $scope.getRandonItem();
    }, 1000)


})