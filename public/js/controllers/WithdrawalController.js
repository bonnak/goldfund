angular.module('MetronicApp').controller('WithdrawalController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.withdraw_amount = '';
        vm.balance = '';
        vm.withdrawals = [];

        vm.save = function(){
            vm.loading = true;

            Restful.save('api/withdrawal/cashout', { withdraw_amount: vm.withdraw_amount}).success(function(data){
                $state.go('withdrawal_history');
            }).finally(function () {
                vm.loading= false;
            });
        };

        vm.getData = function(){
            Restful.get('/api/withdrawal/balance').success(function(data){
                vm.balance = data.balance;
            });
        }

        vm.getHistory = function(params){
            Restful.get('api/withdrawal/history').success(function(data){
                vm.withdrawals = data;
            });
        };

        vm.getData();
        vm.getHistory();

    }
]);
