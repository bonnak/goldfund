angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    '$location',
    'Restful',
    function($scope, $location, Restful) {
        var vm = this;
        vm.model = {};        

        vm.profile = function(){
            Restful.get('/user/getProfile').success(function(result){
                vm.link = $location.protocol() + "://" + $location.host() + 
                            ($location.port() !== 80 ? (':' + $location.port()) : '') + '/register?ref=' + result.username;
            });
        }

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

        vm.fetchNews = function()
        {
            Restful.get('/api/news/latest').success(function(data){
                vm.news = data;
            });
        }  

        vm.profile();
        vm.fetchData();  
        vm.fetchTransactions();
        vm.fetchNews();

        
    }
]);