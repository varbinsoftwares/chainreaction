var App = angular.module('App', []).config(function ($interpolateProvider, $httpProvider) {
    //$interpolateProvider.startSymbol('{$');
    //$interpolateProvider.endSymbol('$}');
    $httpProvider.defaults.headers.common = {};
    $httpProvider.defaults.headers.post = {};
});

App.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);
    for (var i=0; i<total; i++)
      input.push(i);
    return input;
  };
})

App.controller('MainController', function ($scope, $http, $timeout, $interval, $filter) {



})