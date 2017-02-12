/* Setup general page controller */
angular.module('MetronicApp').controller('UserProfileEditController', [
    '$rootScope', '$scope',
    function($rootScope, $scope) {
        var vm = this;
        vm.model = {};
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });
    }
]);
