/* Setup general page controller */
angular.module('MetronicApp').controller('UserProfileEditController', [
    '$rootScope', '$scope', 'Restful', '$state',
    function($rootScope, $scope, restful, $state) {
        var vm = this;
        vm.model = $scope.userProfile;
        vm.genders = [{
            code: 'M',
            name: 'Male'
        },
        {
            code: 'F',
            name: 'Female'
        }];
        vm.directions = [{
            code: 'L',
            name: 'Left'
        },
        {
            code: 'R',
            name: 'Right'
        }];
        $scope.$on('$viewContentLoaded', function() {
            // initialize core components
            App.initAjax();
        });

        vm.getInit = function(){
            restful.get('getCountry').success(function(result){
                vm.countries = result;
            });
            restful.get('user/getProfile').success(function(result){
                vm.model = result;
            });
        };
        vm.getInit();

        vm.save = function(){
            vm.loading= true;
            restful.put('/api/user/updateProfile', vm.model).success(function(result){
                console.log(result);
                // call from parent scope function in main.js
                $rootScope.$emit("InitSettingMethod", {});
                $state.go('user_profile');
            }).finally(function () {
                vm.loading= false;
            });
        };

    }
]);
