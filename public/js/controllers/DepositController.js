angular.module('MetronicApp').controller('DepositController', [
    '$scope',
    '$anchorScroll',
    'Restful',
    function($scope, $anchorScroll, Restful) {
        var vm = this;
        vm.model = {};
        console.log(vm.model);

        vm.save = function(){
            if (!$scope.depositForm.$valid) {
                $anchorScroll();
                return;
            }
            vm.loading = true;
        };
        vm.getQrCode = function(params){
            Restful.get('api/qr/admin/bitcoin').success(function(data){
                vm.qrcode = data;
                console.log(data);
            });
        };
        vm.getQrCode();
        $scope.$on('$viewContentLoaded', function() {});

    }
]);
