angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    '$location',
    function($scope, $location) {
        var vm = this;
        vm.link = $location.protocol() + "://" + $location.host() + ":" + 
                ($location.port() !== 80 ? $location.port() : '') + '/register?ref=' + $scope.userProfile.username;
    }
]);