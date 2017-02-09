angular.module('MetronicApp').controller('DashboardController', function($rootScope, $scope, $http, $timeout) {
    //$scope.$on('$viewContentLoaded', function() {
    //    // initialize core components
    //    App.initAjax();
    //});
    //
    //// set sidebar closed and body solid layout mode
    $rootScope.settings.layout.pageContentWhite = true;
    $rootScope.settings.layout.pageBodySolid = true;
    $rootScope.settings.layout.pageSidebarClosed = false;

    $scope.pageName = 'OPEW';
});