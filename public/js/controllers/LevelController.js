angular.module('MetronicApp').controller('LevelController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.earnings = [];
        vm.level_number = '';
        vm.levels = [];

        vm.getHistory = function(params){
            vm.loading = true;
            Restful.get('api/earning/level').success(function(data){
                vm.earnings = data;
            }).finally(function(){
                vm.loading = false;
            });
        };

        vm.filterByLevel = function(){
            Restful.get('api/earning/level/' + vm.level_number).success(function(data){
                vm.earnings = data;
            })
        };

        vm.fetchLevel = function(){
            Restful.get('api/plan/levels').success(function(data){
                vm.levels = data;
            })
        };

        vm.fetchLevel();
        vm.getHistory();

    }
]);