/* Setup general page controller */
angular.module('MetronicApp').controller('ChangePasswordController', [
    '$rootScope', '$scope', 'Restful', '$state',
    function($rootScope, $scope, restful, $state) {
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
            restful.put('/api/password/change', vm.model).success(function(response){
                console.log(response);
                $state.go('user_profile');
            }).finally(function () {
                vm.loading= false;
            });
        };
    }
]);
