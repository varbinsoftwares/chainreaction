/* 
 Producrt list controllers
 */

ClassApartStore.controller('ProductController', function ($scope, $http, $timeout, $interval) {

    $scope.productResults = {};
    $scope.init = 0;
    $scope.checkproduct = 0;
    $scope.pricerange = {'min': 0, 'max': 0};

    $scope.getProducts = function (attrs) {


        var argsk = [];
        for (i in $scope.attribute_checked) {
            var at = $scope.attribute_checked[i];
            var argsv = [];
            for (t in at) {
                var tt = at[t];
                argsv.push(tt)
            }
            var ak = "a" + i + "=" + argsv.join("-");
            argsk.push(ak);
        }
        var pmm = $("#price-range-min").text().replace("$", "");
        var pmx = $("#price-range-max").text().replace("$", "");

        var elempm = "maxprice=" + pmx;
        var elempx = "minprice=" + pmm;



        if (pmm.trim()) {
            $scope.pricerange.max = pmx;
            $scope.pricerange.min = pmm;
            argsk.push(elempx);
            argsk.push(elempm);
        }
        var stargs = argsk.join("&");



        var url = baseurl + "Api/productListApi/" + category_id + "";

        if (stargs) {
            url = url + "?" + stargs;
        }

        $http.get(url).then(function (result) {
            console.log(result.data);
            if ($scope.productResults.products) {
                $scope.productResults.products = result.data.products;
            }
            else {
                $scope.productResults = result.data;
                if ($scope.productResults.products.length) {
                    $scope.checkproduct = 1;
                }
            }
            if ($scope.init == 0) {

                $timeout(function () {


                    var priceSlider = document.getElementById('price-range-filter');
                    if (priceSlider) {
                        noUiSlider.create(priceSlider, {
                            start: [Number($scope.productResults.price.minprice) - 1, Number($scope.productResults.price.maxprice)],
                            connect: true,
                            /*tooltips: true,*/
                            range: {
                                'min': Number($scope.productResults.price.minprice) - 1,
                                'max': Number($scope.productResults.price.maxprice)
                            },
                            format: wNumb({
                                decimals: 0
                            }),
                        });
                        var marginMin = Number($scope.productResults.price.minprice) - 1,
                                marginMax = Number($scope.productResults.price.maxprice);
                        priceSlider.noUiSlider.on('update', function (values, handle) {
                            if (handle) {
                                $timeout(function () {
                                    $scope.productResults.price.maxprice = values[handle];
                                })

                            } else {
                                $timeout(function () {
                                    $scope.productResults.price.minprice = values[handle];
                                })
                            }
                        });
                    }

                }, 1000)
            }
            $scope.init = 1;
        }, function () {
        });
    }

    $scope.attribute_checked = {};
    $scope.getProducts();

    $scope.attribute_checked_pre = {};

    $scope.attributeProductGet = function (atv) {

        //check attribute id
        if (atv.checked) {
            if ($scope.attribute_checked[atv.attribute_id]) {
                var attrlist = $scope.attribute_checked[atv.attribute_id];
                if (attrlist.indexOf(atv.id) > -1) {

                }
                else {
                    $scope.attribute_checked[atv.attribute_id].push(atv.id)
                }
            }
            else {
                $scope.attribute_checked[atv.attribute_id] = [atv.id];
            }
        }
        else {
            var attrlist = $scope.attribute_checked[atv.attribute_id];
            var ind = attrlist.indexOf(atv.id)
            $scope.attribute_checked[atv.attribute_id].splice(ind, 1);
            if ($scope.attribute_checked[atv.attribute_id].length == 0) {
                delete $scope.attribute_checked[atv.attribute_id];
            }
        }


        //check attribute lable
        if (atv.checked) {
            if ($scope.attribute_checked_pre[atv.attribute]) {
                var attrlist = $scope.attribute_checked_pre[atv.attribute];
                if (attrlist.indexOf(atv.id) > -1) {

                }
                else {
                    $scope.attribute_checked_pre[atv.attribute].push(atv)
                }
            }
            else {
                $scope.attribute_checked_pre[atv.attribute] = [atv];
            }
        }
        else {
            var attrlist = $scope.attribute_checked_pre[atv.attribute];
            var ind = attrlist.indexOf(atv.id)
            $scope.attribute_checked_pre[atv.attribute].splice(ind, 1);
            if ($scope.attribute_checked_pre[atv.attribute].length == 0) {
                delete $scope.attribute_checked_pre[atv.attribute];
            }
        }

        console.log($scope.attribute_checked_pre);


//        var stargs = encodeURIComponent(fargs);
        $scope.getProducts();




    }


    $scope.filterPrice = function () {
        $scope.getProducts();

    }


})


ClassApartStore.controller('ProductSearchController', function ($scope, $http, $timeout, $interval) {

    $scope.productResults = {};
    $scope.init = 0;
    $scope.checkproduct = 0;
    $scope.pricerange = {'min': 0, 'max': 0};



    $scope.getProducts = function (attrs) {


        var argsk = [];
        for (i in $scope.attribute_checked) {
            var at = $scope.attribute_checked[i];
            var argsv = [];
            for (t in at) {
                var tt = at[t];
                argsv.push(tt)
            }
            var ak = "a" + i + "=" + argsv.join("-");
            argsk.push(ak);
        }
        var pmm = $("#price-min").text().replace("$", "");
        var pmx = $("#price-max").text().replace("$", "");

        var elempm = "maxprice=" + pmx;
        var elempx = "minprice=" + pmm;



        if (pmm.trim()) {
            $scope.pricerange.max = pmx;
            $scope.pricerange.min = pmm;
            argsk.push(elempx);
            argsk.push(elempm);
        }
        var stargs = argsk.join("&");



        var url = baseurl + "Api/productListSearchApi/" + keywords + "";

        if (stargs) {
            url = url + "?" + stargs;
        }

        $http.get(url).then(function (result) {


            if ($scope.productResults.products) {
                $scope.productResults.products = result.data.products;
            }
            else {
                $scope.productResults = result.data;
                if ($scope.productResults.products.length) {
                    $scope.checkproduct = 1;
                }
            }
            if ($scope.init == 0) {


            }
            $scope.init = 1;
        }, function () {
        });
    }

    $scope.attribute_checked = {};
    $scope.getProducts();

    $scope.attribute_checked_pre = {};

    $scope.attributeProductGet = function (atv) {

        //check attribute id
        if (atv.checked) {
            if ($scope.attribute_checked[atv.attribute_id]) {
                var attrlist = $scope.attribute_checked[atv.attribute_id];
                if (attrlist.indexOf(atv.id) > -1) {

                }
                else {
                    $scope.attribute_checked[atv.attribute_id].push(atv.id)
                }
            }
            else {
                $scope.attribute_checked[atv.attribute_id] = [atv.id];
            }
        }
        else {
            var attrlist = $scope.attribute_checked[atv.attribute_id];
            var ind = attrlist.indexOf(atv.id)
            $scope.attribute_checked[atv.attribute_id].splice(ind, 1);
            if ($scope.attribute_checked[atv.attribute_id].length == 0) {
                delete $scope.attribute_checked[atv.attribute_id];
            }
        }


        //check attribute lable
        if (atv.checked) {
            if ($scope.attribute_checked_pre[atv.attribute]) {
                var attrlist = $scope.attribute_checked_pre[atv.attribute];
                if (attrlist.indexOf(atv.id) > -1) {

                }
                else {
                    $scope.attribute_checked_pre[atv.attribute].push(atv)
                }
            }
            else {
                $scope.attribute_checked_pre[atv.attribute] = [atv];
            }
        }
        else {
            var attrlist = $scope.attribute_checked_pre[atv.attribute];
            var ind = attrlist.indexOf(atv.id)
            $scope.attribute_checked_pre[atv.attribute].splice(ind, 1);
            if ($scope.attribute_checked_pre[atv.attribute].length == 0) {
                delete $scope.attribute_checked_pre[atv.attribute];
            }
        }

        console.log($scope.attribute_checked_pre);


//        var stargs = encodeURIComponent(fargs);
        $scope.getProducts();




    }


    $scope.filterPrice = function () {
        $scope.getProducts();

    }


})
