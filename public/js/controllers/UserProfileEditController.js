/* Setup general page controller */
angular.module('MetronicApp').controller('UserProfileEditController', [
    '$rootScope', '$scope', 'Restful',
    function($rootScope, $scope, restful) {
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
            console.log('save');
            restful.put('/user/updateProfile', vm.model).success(function(result){
                console.log(result);
            });
        };

    }
]);
