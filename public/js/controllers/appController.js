
/* Setup App Main Controller */
MetronicApp.controller('AppController', [
    '$scope',
    '$rootScope',
    'Restful',
    function($scope, $rootScope, restful) {
        $scope.$on('$viewContentLoaded', function() {
            App.initComponents(); // init core components
            // Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials
            // included in server side instead of loading with ng-include directive
        });
        $scope.initSetting = function(){
            restful.get('/user/getProfile').success(function(result){
                $scope.userProfile = result;
                console.log($scope.userProfile);
            });
        };
        $scope.initSetting();

        $rootScope.$on("InitSettingMethod", function(){
            $scope.initSetting();
        });
    }
]);
