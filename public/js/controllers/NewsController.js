angular.module('MetronicApp').controller('NewsController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    '$state',
    function($scope, $anchorScroll, $state, Restful, $state) {
        var vm = this;

        vm.fetchNews = function(params){
            Restful.get('api/news').success(function(data){
                vm.all_news = data;
            });
        };

        vm.getById = function(){
            if($state.params.id !== undefined){
                Restful.get('api/news/' + $state.params.id).success(function(data){
                    vm.news = data;
                });
            }            
        };

        vm.fetchNews();
        vm.getById();
    }
]);