angular.module('MetronicApp').controller('ContactController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.model = [];

        vm.fetchData = function(){
            Restful.get('api/company/profile').success(function(data){
                vm.model = data;
            })
        };

        vm.fetchData();

    }
]);