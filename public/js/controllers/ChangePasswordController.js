/* Setup general page controller */
angular.module('MetronicApp').controller('ChangePasswordController', [
    '$rootScope', '$scope', 'Restful',
    function($rootScope, $scope, restful) {
        var vm = this;
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });

        vm.save = function(){
            if($scope.profileForm.$invalid){
                return;
            }
            vm.loading= true;
            restful.put('/api/user/password/change', vm.model).success(function(response){
                console.log(response);
            }).finally(function () {
                vm.loading= false;
            });
        };
    }
]);
