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
        vm.error = '';
        vm.allow_withdrawal = null;

        vm.save = function(){
            vm.loading = true;

            Restful.save('api/withdrawal/cashout', { withdraw_amount: vm.withdraw_amount}).success(function(data){
                $state.go('withdrawal_history');
            }).error(function(err_response){
                vm.error = err_response.error;
            }).finally(function () {
                vm.loading= false;
            });
        };

        vm.getData = function(){
            Restful.get('/api/withdrawal/balance').success(function(data){
                vm.balance = data.balance;                
                vm.allow_withdrawal = true;
            }).error(function(err_response){
                vm.error = err_response.error;
                vm.allow_withdrawal = false;
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
