angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    '$location',
    'Restful',
    function($scope, $location, Restful) {
        var vm = this;
        vm.model = {};
        vm.link = $location.protocol() + "://" + $location.host() + ":" + 
                ($location.port() !== 80 ? $location.port() : '') + '/register?ref=' + $scope.userProfile.username;


        vm.fetchData = function()
        {
        	Restful.get('/api/earning/data').success(function(data){
                vm.model = data;
            });
        }  

        vm.fetchData();  
    }
]);