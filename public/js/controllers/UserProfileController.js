/* Setup general page controller */
angular.module('MetronicApp').controller('UserProfileController', [
    '$rootScope', '$scope',
    function($rootScope, $scope) {
        var vm = this;
        vm.model = $scope.userProfile;

        console.log(vm.model);
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });

        //when model from outside is changed, update local data
        $scope.$watch('userProfile', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.model = newValue;
            }
        });
    }
]);
