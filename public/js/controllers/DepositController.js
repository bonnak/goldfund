angular.module('MetronicApp').controller('DepositController', [
    '$scope',
    '$anchorScroll',
    'Restful',
    function($scope, $anchorScroll, Restful) {
        var vm = this;
        vm.model = {
            plan_id: null,
            amount: null
        };
        vm.plans = [];

        vm.save = function(){
            if (!$scope.depositForm.$valid) {
                $anchorScroll();
                return;
            }
            vm.loading = true;

            Restful.save('api/deposit', vm.model).success(function(data){
            }).finally(function () {
                vm.loading= false;
            });;
        };
        vm.getQrCode = function(params){
            Restful.get('api/qr/admin/bitcoin').success(function(data){
                vm.qrcode = data;
            });
        };

        vm.getPlans = function(){
            Restful.get('/api/plans').success(function(data){
                data.forEach(function(el){
                    vm.plans.push(el);
                });
            });
        }
        vm.getQrCode();
        vm.getPlans();
        $scope.$on('$viewContentLoaded', function() {});

    }
]);
