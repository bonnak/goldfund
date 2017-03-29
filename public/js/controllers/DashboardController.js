angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    '$location',
    'Restful',
    function($scope, $location, Restful) {
        var vm = this;
        vm.model = {};        


        vm.fetchData = function()
        {
        	Restful.get('/api/earning/data').success(function(data){
                vm.model = data;
            });
        }  

        vm.fetchTransactions = function()
        {
            Restful.get('/api/transactions').success(function(data){
                vm.transactions = data;
            });
        } 

        vm.fetchData();  
        vm.fetchTransactions();

        console.log($scope.userProfile);

        vm.link = $location.protocol() + "://" + $location.host() + 
            ($location.port() !== 80 ? (':' + $location.port()) : '') + '/register?ref=' + $scope.userProfile.username;
    }
]);