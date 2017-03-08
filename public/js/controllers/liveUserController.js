var app = angular.module(
    'app',
    [
        // @todo add
        'angularMoment'
    ],
    function($interpolateProvider) {
        // change express angular snytax to avoid conflict with laravel expression
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }
);
//var sampleApp = angular.module('sampleApp', [], );
app.controller(
    'liveUser', [
        '$scope'
        , '$http'
        , '$interval'
        , function ($scope, $http, $interval){            
            var vm = this;
            vm.ageInMinutes = '2017-02-18 03:00:39';
            vm.getUserLive = function(){
                $http({
                    method: 'GET',
                    url: '/api/portfolio/live'
                }).then(function successCallback(response) {
                    //console.log(response);
                    vm.customers = response.data.customers;
                    vm.totalMember = response.data.total_member;
                    vm.investedCapital = response.data.invested_capital;
                    vm.lastDeposits = response.data.last_deposits;
                    // this callback will be called asynchronously
                    // when the response is available
                }, function errorCallback(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
            };
            $interval(function() {
                vm.getUserLive();
            }, 2000);
            vm.model = {};
            vm.getPlan = function(){
                $http({
                    method: 'GET',
                    url: '/api/plans'
                }).success(function(data){
                    vm.plans = data;
                    console.log(data);
                });
            };
            vm.getPlan();
        }
    ]
);
