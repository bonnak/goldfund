/* Setup blank page controller */
angular.module('MetronicApp').controller('DepositController', [
    '$scope',
    '$anchorScroll',
    function($scope, $anchorScroll) {
    $scope.$on('$viewContentLoaded', function() {
        var vm = this;
        vm.model = {};
        console.log(vm.model);

        vm.save = function(){
            if (!$scope.depositForm.$valid) {
                $anchorScroll();
                return;
            }
            vm.loading = true;
        }
    });

}]);
