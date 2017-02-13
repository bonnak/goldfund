/* Setup general page controller */
angular.module('MetronicApp').controller('ChangePasswordController', [
    '$rootScope', '$scope',
    function($rootScope, $scope) {
        var vm = this;
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });
    }
]);
