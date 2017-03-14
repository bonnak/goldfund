angular.module('MetronicApp').controller('BinaryController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.earnings = [];

        vm.getHistory = function(params){
            vm.loading = true;
            Restful.get('api/earning/binary').success(function(data){
                vm.earnings = data;
            }).finally(function(){
                vm.loading = false;
            });
        };

        vm.getHistory();

    }
]);