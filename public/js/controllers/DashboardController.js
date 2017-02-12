angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    function($scope) {alert('sd');
        $scope.$on('$viewContentLoaded', function() {});
        //
        //// set sidebar closed and body solid layout mode
        //$rootScope.settings.layout.pageContentWhite = true;
        //$rootScope.settings.layout.pageBodySolid = true;
        //$rootScope.settings.layout.pageSidebarClosed = false;
        //
        //$scope.pageName = 'OPEW';
    }
]);