angular.module('MetronicApp').controller('DepositController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.model = {
            plan_id: null,
            amount: null
        };
        vm.plans = [];
        vm.deposits = [];

        vm.save = function(){
            if (!$scope.depositForm.$valid) {
                $anchorScroll();
                return;
            }
            vm.loading = true;

            Restful.save('api/deposit', vm.model).success(function(data){
                $state.go('deposit/history');
            }).finally(function () {
                vm.loading= false;
            });;
        };

        vm.getHistory = function(params){
            Restful.get('api/deposit/history').success(function(data){
                data.forEach(function(el){
                    vm.deposits.push(el);
                });
            });
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
        vm.getHistory();
        $scope.$on('$viewContentLoaded', function() {});

    }
]);
